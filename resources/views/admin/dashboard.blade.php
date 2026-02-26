@extends('layouts.admin.dashboard')

@section('page-title', 'Dashboard')

@section('content')
    <div class="space-y-6">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-6 text-white">
            <h2 class="text-xl font-bold">Welcome back, {{ auth()->user()->name }}! 👋</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center text-lg">
                        <i class="bi bi-people"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ $totalUsers }}</p>
                        <p class="text-xs text-gray-500">Total Users</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-lg">
                        <i class="bi bi-play-circle"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ $totalVideos }}</p>
                        <p class="text-xs text-gray-500">Total Videos</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center text-lg">
                        <i class="bi bi-tag"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ $totalCategories }}</p>
                        <p class="text-xs text-gray-500">Video Categories</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center text-lg">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ $pendingRequests }}</p>
                        <p class="text-xs text-gray-500">Pending Requests</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <h2 class="text-base font-semibold text-gray-800">Recent Video Requests</h2>
                <a href="{{ route('video-requests.index') }}"
                    class="text-xs font-medium text-indigo-600 hover:text-indigo-800 transition">View All →</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="px-5 py-3">User</th>
                            <th class="px-5 py-3">Video</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3">Requested At</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($recentRequests as $req)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-5 py-3">
                                    <p class="font-medium text-gray-800">{{ $req->user->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $req->user->email }}</p>
                                </td>
                                <td class="px-5 py-3 text-gray-700">{{ $req->video->title }}</td>
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
                                <td class="px-5 py-3 text-gray-500 text-xs">
                                    {{ \Carbon\Carbon::parse($req->created_at)->timezone('Asia/Jakarta')->format('d M Y, H:i') }}
                                    WIB
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-8 text-center text-gray-400">No recent requests.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
