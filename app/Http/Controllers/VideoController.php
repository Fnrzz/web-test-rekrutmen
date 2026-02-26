<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\VideoCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SweetAlert2\Laravel\Swal;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::with('category')->orderBy('title')->get();
        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        $categories = VideoCategory::orderBy('name')->get();
        return view('admin.videos.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:video_categories,id'],
            'description' => ['nullable', 'string'],
            'thumbnail'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'video'       => ['required', 'file', 'mimetypes:video/mp4,video/mpeg,video/quicktime,video/x-msvideo,video/webm', 'max:102400'],
        ]);

        $videoPath = $request->file('video')->store('videos', 'public');

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        Video::create([
            'title'       => $validated['title'],
            'slug'        => Str::slug($validated['title']),
            'category_id' => $validated['category_id'],
            'description' => $validated['description'] ?? null,
            'thumbnail'   => $thumbnailPath,
            'url'         => $videoPath,
        ]);

        Swal::success(['title' => 'Success!', 'text' => 'Video uploaded successfully.']);

        return redirect()->route('videos.index');
    }

    public function edit(Video $video)
    {
        $categories = VideoCategory::orderBy('name')->get();
        return view('admin.videos.edit', compact('video', 'categories'));
    }

    public function update(Request $request, Video $video)
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:video_categories,id'],
            'description' => ['nullable', 'string'],
            'thumbnail'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'video'       => ['nullable', 'file', 'mimetypes:video/mp4,video/mpeg,video/quicktime,video/x-msvideo,video/webm', 'max:102400'],
        ]);

        $data = [
            'title'       => $validated['title'],
            'slug'        => Str::slug($validated['title']),
            'category_id' => $validated['category_id'],
            'description' => $validated['description'] ?? null,
        ];

        if ($request->hasFile('thumbnail')) {
            if ($video->thumbnail) {
                Storage::disk('public')->delete($video->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        if ($request->hasFile('video')) {
            if ($video->url) {
                Storage::disk('public')->delete($video->url);
            }
            $data['url'] = $request->file('video')->store('videos', 'public');
        }

        $video->update($data);

        Swal::success(['title' => 'Success!', 'text' => 'Video updated successfully.']);

        return redirect()->route('videos.index');
    }

    public function destroy(Video $video)
    {
        if ($video->thumbnail) {
            Storage::disk('public')->delete($video->thumbnail);
        }

        if ($video->url) {
            Storage::disk('public')->delete($video->url);
        }

        $video->delete();

        Swal::success(['title' => 'Deleted!', 'text' => 'Video deleted successfully.']);

        return redirect()->route('videos.index');
    }
}
