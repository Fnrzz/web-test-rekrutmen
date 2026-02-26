<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\VideoCategory;
use App\Models\VideoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SweetAlert2\Laravel\Swal;

class HomeController extends Controller
{
    public function welcome()
    {
        $latestVideos = Video::with('category')->latest()->take(4)->get();
        return view('welcome', compact('latestVideos'));
    }

    public function catalog()
    {
        $categories = VideoCategory::orderBy('name')->get();
        $query = Video::with('category')->latest();

        if (request('category')) {
            $query->whereHas('category', function ($q) {
                $q->where('slug', request('category'));
            });
        }

        $videos = $query->get();
        return view('catalog', compact('videos', 'categories'));
    }

    public function videoDetail(Video $video)
    {
        $canWatch = false;
        $accessRequest = null;

        if (Auth::check()) {
            $user = Auth::user();

            if ($user->role === 'admin') {
                $canWatch = true;
            } else {
                $accessRequest = VideoRequest::where('user_id', $user->id)
                    ->where('video_id', $video->id)
                    ->latest()
                    ->first();

                if (
                    $accessRequest
                    && $accessRequest->status === 'approved'
                    && ($accessRequest->expired_at === null || $accessRequest->expired_at->isFuture())
                ) {
                    $canWatch = true;
                }
            }
        }

        return view('video-detail', compact('video', 'canWatch', 'accessRequest'));
    }

    public function requestAccess(Video $video)
    {
        $user = Auth::user();

        VideoRequest::create([
            'user_id'  => $user->id,
            'video_id' => $video->id,
            'status'   => 'pending',
        ]);

        Swal::success(['title' => 'Berhasil!', 'text' => 'Permintaan akses telah dikirim. Tunggu persetujuan admin.']);

        return redirect()->route('video.detail', $video);
    }

    public function myPendingVideos()
    {
        $requests = VideoRequest::with('video.category')
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('my-videos.pending', compact('requests'));
    }

    public function myApprovedVideos()
    {
        $requests = VideoRequest::with('video.category')
            ->where('user_id', Auth::id())
            ->where('status', 'approved')
            ->where(function ($q) {
                $q->whereNull('expired_at')
                    ->orWhere('expired_at', '>', now());
            })
            ->latest()
            ->get();

        return view('my-videos.approved', compact('requests'));
    }
}
