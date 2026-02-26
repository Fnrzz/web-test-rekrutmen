<?php

namespace App\Http\Controllers;

use App\Models\VideoCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use SweetAlert2\Laravel\Swal;

class VideoCategoryController extends Controller
{
    public function index()
    {
        $categories = VideoCategory::orderBy('name')->get();
        return view('admin.video-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.video-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:video_categories,name'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        VideoCategory::create($validated);

        Swal::success(['title' => 'Success!', 'text' => 'Category created successfully.']);

        return redirect()->route('video-categories.index');
    }

    public function edit(VideoCategory $videoCategory)
    {
        return view('admin.video-categories.edit', compact('videoCategory'));
    }

    public function update(Request $request, VideoCategory $videoCategory)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('video_categories')->ignore($videoCategory->id)],
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $videoCategory->update($validated);

        Swal::success(['title' => 'Success!', 'text' => 'Category updated successfully.']);

        return redirect()->route('video-categories.index');
    }

    public function destroy(VideoCategory $videoCategory)
    {
        $videoCategory->delete();

        Swal::success(['title' => 'Deleted!', 'text' => 'Category deleted successfully.']);

        return redirect()->route('video-categories.index');
    }
}
