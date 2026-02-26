@extends('layouts.admin.dashboard')

@section('page-title', 'Video Requests')

@section('content')
    <div class="bg-white rounded-xl border border-gray-200">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <h2 class="text-base font-semibold text-gray-800">All Video Requests</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-5 py-3">#</th>
                        <th class="px-5 py-3">User</th>
                        <th class="px-5 py-3">Video</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Expires At</th>
                        <th class="px-5 py-3">Requested At</th>
                        <th class="px-5 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($datas as $index => $req)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-3 text-gray-500">{{ $index + 1 }}</td>
                            <td class="px-5 py-3">
                                <div>
                                    <p class="font-medium text-gray-800">{{ $req->user->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $req->user->email }}</p>
                                </div>
                            </td>
                            <td class="px-5 py-3 font-medium text-gray-800">{{ $req->video->title }}</td>
                            <td class="px-5 py-3">
                                @if ($req->status === 'pending')
                                    <span
                                        class="inline-block px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                                        Pending
                                    </span>
                                @elseif ($req->status === 'approved')
                                    @if ($req->expired_at && \Carbon\Carbon::parse($req->expired_at)->isPast())
                                        <span
                                            class="inline-block px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                            Expired
                                        </span>
                                    @else
                                        <span
                                            class="inline-block px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                            Approved
                                        </span>
                                    @endif
                                @else
                                    <span
                                        class="inline-block px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                        Rejected
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-xs">
                                @if ($req->expired_at)
                                    @if (\Carbon\Carbon::parse($req->expired_at)->isPast())
                                        <span
                                            class="text-red-500 font-medium">{{ \Carbon\Carbon::parse($req->expired_at)->timezone('Asia/Jakarta')->format('d M Y, H:i') }}
                                            WIB</span>
                                    @else
                                        <span
                                            class="text-gray-500">{{ \Carbon\Carbon::parse($req->expired_at)->timezone('Asia/Jakarta')->format('d M Y, H:i') }}
                                            WIB</span>
                                    @endif
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-gray-500 text-xs">
                                {{ \Carbon\Carbon::parse($req->created_at)->timezone('Asia/Jakarta')->format('d M Y, H:i') }}
                                WIB
                            </td>
                            <td class="px-5 py-3">
                                @if ($req->status === 'pending')
                                    <div class="flex items-center gap-2">
                                        <button type="button" onclick="openApproveModal({{ $req->id }})"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-green-600 bg-green-50 hover:bg-green-100 transition cursor-pointer">
                                            <i class="bi bi-check-lg"></i> Approve
                                        </button>
                                        <form id="reject-form-{{ $req->id }}" method="POST"
                                            action="{{ route('video-requests.reject', $req) }}">
                                            @csrf
                                            <button type="button"
                                                onclick="confirmReject({{ $req->id }}, '{{ $req->user->name }}')"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 transition cursor-pointer">
                                                <i class="bi bi-x-lg"></i> Reject
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-8 text-center text-gray-400">No video requests found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="approve-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeApproveModal()"></div>
        <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-base font-semibold text-gray-800">Approve Request</h3>
                <p class="text-xs text-gray-500 mt-0.5">Set an expiration for this video access.</p>
            </div>

            <form id="approve-form" method="POST" action="" class="p-6 space-y-4">
                @csrf

                <div>
                    <label for="expiry_hours" class="block text-sm font-medium text-gray-700 mb-1">Number of Hours</label>
                    <input type="number" id="expiry_hours" name="expiry_hours" value="24" min="1"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm bg-gray-50
                               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                        placeholder="e.g. 24">
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit"
                        class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-green-600 hover:bg-green-700 transition cursor-pointer">
                        Approve
                    </button>
                    <button type="button" onclick="closeApproveModal()"
                        class="px-5 py-2.5 rounded-xl text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 transition cursor-pointer">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openApproveModal(requestId) {
            const form = document.getElementById('approve-form');
            form.action = '/dashboard/video-requests/' + requestId + '/approve';
            document.getElementById('approve-modal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeApproveModal() {
            document.getElementById('approve-modal').classList.add('hidden');
            document.body.style.overflow = '';
        }

        function confirmReject(requestId, userName) {
            Swal.fire({
                title: 'Reject Request?',
                text: `Are you sure you want to reject the request from "${userName}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e53e3e',
                cancelButtonColor: '#718096',
                confirmButtonText: 'Yes, reject it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('reject-form-' + requestId).submit();
                }
            });
        }
    </script>
@endsection
