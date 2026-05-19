<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ThemeService;
use Illuminate\Http\Request;

class AdminThemeController extends Controller
{
    public function __construct(private ThemeService $themes) {}

    public function index()
    {
        $themes = $this->themes->getAll();
        $active = $this->themes->getActive();
        return view('admin.themes.index', compact('themes', 'active'));
    }

    public function edit(string $slug)
    {
        $theme = $this->themes->load($slug);
        return view('admin.themes.edit', compact('theme', 'slug'));
    }

    public function update(Request $request, string $slug)
    {
        $data = $request->validate([
            'meta.name'         => ['required', 'string', 'max:64'],
            'meta.description'  => ['nullable', 'string', 'max:255'],
            'colors'            => ['required', 'array'],
        ]);

        $existing = $this->themes->load($slug);
        $merged   = array_replace_recursive($existing, $data);
        $this->themes->createCustom($slug, $merged);

        return redirect()->route('admin.themes.index')->with('success', 'Theme updated.');
    }

    public function activate(string $slug)
    {
        $this->themes->setActive($slug);
        return back()->with('success', 'Theme activated.');
    }

    public function duplicate(string $slug)
    {
        $newSlug = $slug . '-copy-' . substr(md5(uniqid()), 0, 6);
        $this->themes->duplicate($slug, $newSlug);
        return redirect()->route('admin.themes.edit', $newSlug)->with('success', 'Theme duplicated.');
    }

    public function destroy(string $slug)
    {
        $this->themes->delete($slug);
        return redirect()->route('admin.themes.index')->with('success', 'Theme deleted.');
    }
}
