<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DownloadableForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DownloadableFormController extends Controller
{
    public function index()
    {
        return view('admin.forms.index', [
            'forms' => DownloadableForm::query()
                ->orderBy('sort_order')
                ->latest()
                ->get(),
        ]);
    }

    public function create()
    {
        return view('admin.forms.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateForm($request, false);
        $data['is_published'] = $request->boolean('is_published');
        $data['created_by'] = $request->user()->id;
        $data['file_path'] = $this->storeFormFile($request->file('form_file'));

        DownloadableForm::create($data);

        return redirect()->route('admin.forms.index')->with('status', 'Form created.');
    }

    public function edit(DownloadableForm $form)
    {
        return view('admin.forms.edit', [
            'form' => $form,
        ]);
    }

    public function update(Request $request, DownloadableForm $form)
    {
        $data = $this->validateForm($request, true);
        $data['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('form_file')) {
            $this->deleteFormFile($form->file_path);
            $data['file_path'] = $this->storeFormFile($request->file('form_file'));
        } else {
            $data['file_path'] = $form->file_path;
        }

        $form->update($data);

        return redirect()->route('admin.forms.index')->with('status', 'Form updated.');
    }

    public function destroy(DownloadableForm $form)
    {
        $this->deleteFormFile($form->file_path);
        $form->delete();

        return redirect()->route('admin.forms.index')->with('status', 'Form removed.');
    }

    private function validateForm(Request $request, bool $isUpdate): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_published' => ['nullable', 'boolean'],
            'form_file' => [$isUpdate ? 'nullable' : 'required', 'file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx', 'max:10240'],
        ]);
    }

    private function storeFormFile($file): string
    {
        $directory = public_path('downloads/forms');

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $filename = Str::uuid()->toString() . '.' . strtolower($file->getClientOriginalExtension());
        $file->move($directory, $filename);

        return 'downloads/forms/' . $filename;
    }

    private function deleteFormFile(?string $path): void
    {
        if (!$path || !str_starts_with($path, 'downloads/forms/')) {
            return;
        }

        $absolutePath = public_path($path);
        if (File::exists($absolutePath)) {
            File::delete($absolutePath);
        }
    }
}
