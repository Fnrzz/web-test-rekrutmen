<?php

namespace App\Http\Controllers;

use App\Models\VideoRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use SweetAlert2\Laravel\Swal;

class VideoRequestController extends Controller
{
    public function index()
    {
        $requests = VideoRequest::with(['user', 'video'])
            ->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')")
            ->latest()
            ->get();

        return view('admin.video-requests.index', compact('requests'));
    }

    public function approve(Request $request, VideoRequest $videoRequest)
    {
        $request->validate([
            'expiry_hours' => ['required', 'integer', 'min:1'],
        ]);

        $expiredAt = Carbon::now()->addHours((int) $request->expiry_hours);

        $videoRequest->update([
            'status'     => 'approved',
            'expired_at' => $expiredAt,
        ]);

        Swal::success(['title' => 'Approved!', 'text' => 'Request approved. Access expires at ' . $expiredAt->timezone('Asia/Jakarta')->format('d M Y, H:i') . ' WIB.']);

        return redirect()->route('video-requests.index');
    }

    public function reject(VideoRequest $videoRequest)
    {
        $videoRequest->update(['status' => 'rejected']);

        Swal::success(['title' => 'Rejected!', 'text' => 'Request has been rejected.']);

        return redirect()->route('video-requests.index');
    }
}
