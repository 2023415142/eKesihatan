<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
 
class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }
 
    public function update(Request $request)
    {
        $user = $request->user();
 
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone_number' => ['nullable', 'string', 'max:30'],
            'student_id' => ['nullable', 'string', 'max:50', 'unique:users,student_id,' . $user->id],
            'staff_id' => ['nullable', 'string', 'max:50', 'unique:users,staff_id,' . $user->id],
            'specialization' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'min:8', 'confirmed'],
        ]);
 
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
 
        $user->update($data);
 
        return redirect()->route('profile.edit')->with('status', 'Profile updated successfully.');
    }
}