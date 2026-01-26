<?php
 
namespace App\Http\Controllers;
 
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
 
class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }
 
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        $user = User::where('email', $credentials['email'])->first();
        if ($user && !$this->isBcryptHash($user->password)) {
            // Migrate legacy/plain passwords to bcrypt to avoid login errors.
            if ($this->matchesLegacyPassword($user->password, $credentials['password'])) {
                $user->password = Hash::make($credentials['password']);
                $user->save();
 
                Auth::login($user);
                $request->session()->regenerate();
 
                return redirect()->route('dashboard');
            }
 
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->withInput();
        }
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->route('dashboard');
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }
 
    public function showRegister()
    {
        return view('auth.register');
    }
 
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'student_id' => ['required', 'string', 'max:50', 'unique:users,student_id'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone_number' => ['required', 'string', 'max:30'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);
 
        $user = User::create([
            'name' => $data['name'],
            'student_id' => $data['student_id'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'password' => Hash::make($data['password']),
            'role' => User::ROLE_PATIENT,
        ]);
 
        Auth::login($user);
 
        return redirect()->route('dashboard');
    }
 
    public function logout(Request $request)
    {
        Auth::logout();
 
        $request->session()->invalidate();
        $request->session()->regenerateToken();
 
        return redirect()->route('landing');
    }
 
    private function isBcryptHash(?string $hash): bool
    {
        if (!$hash) {
            return false;
        }
 
        $info = password_get_info($hash);
 
        return $info['algoName'] === 'bcrypt';
    }
 
    private function matchesLegacyPassword(string $storedHash, string $plain): bool
    {
        $info = password_get_info($storedHash);
 
        if ($info['algo'] !== 0) {
            return password_verify($plain, $storedHash);
        }
 
        return hash_equals($storedHash, $plain);
    }
}