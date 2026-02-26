@extends('layouts.admin.dashboard')

@section('page-title', 'Videos')

@section('content')
    <div class="bg-white rounded-xl border border-gray-200">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <h2 class="text-base font-semibold text-gray-800">All Videos</h2>
            <a href="{{ route('videos.create') }}"
                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition">
                <i class="bi bi-plus-lg"></i> Add Video
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-5 py-3">#</th>
                        <th class="px-5 py-3">Thumbnail</th>
                        <th class="px-5 py-3">Title</th>
                        <th class="px-5 py-3">Category</th>
                        <th class="px-5 py-3">Slug</th>
                        <th class="px-5 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($videos as $index => $video)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-3 text-gray-500">{{ $index + 1 }}</td>
                            <td class="px-5 py-3">
                                @if ($video->thumbnail)
                                    <img src="{{ asset('storage/' . $video->thumbnail) }}" alt="{{ $video->title }}"
                                        class="w-12 h-12 object-cover rounded-lg border border-gray-200">
                                @else
                                    <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center">
                                        <i class="bi bi-image text-gray-400 text-lg"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-5 py-3 font-medium text-gray-800">{{ $video->title }}</td>
                            <td class="px-5 py-3">
                                <span
                                    class="inline-block px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700">
                                    {{ $video->category->name ?? '—' }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-gray-600">
                                <span
                                    class="inline-block px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                    {{ $video->slug }}
                                </span>
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex items-center justify-start gap-2">
                                    <button type="button"
                                        onclick="openVideoModal('{{ asset('storage/' . $video->url) }}', '{{ addslashes($video->title) }}')"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-emerald-600 bg-emerald-50 hover:bg-emerald-100 transition cursor-pointer">
                                        <i class="bi bi-play-circle"></i> Play
                                    </button>
                                    <a href="{{ route('videos.edit', $video) }}"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 transition">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form id="delete-form-{{ $video->id }}" method="POST"
                                        action="{{ route('videos.destroy', $video) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            onclick="confirmDelete({{ $video->id }}, '{{ addslashes($video->title) }}')"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 transition cursor-pointer">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-gray-400">No videos found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="video-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeVideoModal()"></div>

        <div class="relative w-full max-w-3xl bg-gray-900 rounded-2xl shadow-2xl overflow-hidden animate-modal-in">
            <div class="flex items-center justify-between px-5 py-3 bg-gray-800/80">
                <h3 id="modal-title" class="text-sm font-semibold text-white truncate pr-4"></h3>
                <button type="button" onclick="closeVideoModal()"
                    class="p-1.5 rounded-lg text-gray-400 hover:text-white hover:bg-gray-700 transition cursor-pointer">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <div class="aspect-video bg-black">
                <video id="modal-video" class="w-full h-full" controls controlsList="nodownload">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </div>

    <script>
        function openVideoModal(videoUrl, title) {
            const modal = document.getElementById('video-modal');
            const video = document.getElementById('modal-video');
            const modalTitle = document.getElementById('modal-title');

            modalTitle.textContent = title;
            video.src = videoUrl;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            video.play();
        }

        function closeVideoModal() {
            const modal = document.getElementById('video-modal');
            const video = document.getElementById('modal-video');

            video.pause();
            video.src = '';
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }

        function confirmDelete(videoId, videoTitle) {
            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to delete video "${videoTitle}". This action cannot be undone!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e53e3e',
                cancelButtonColor: '#718096',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + videoId).submit();
                }
            });
        }
    </script>
@endsection
