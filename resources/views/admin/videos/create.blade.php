@extends('layouts.admin.dashboard')

@section('page-title', 'Upload Video')

@section('content')
    <div class="w-full">
        <div class="bg-white rounded-xl border border-gray-200 p-6 relative">
            <h2 class="text-base font-semibold text-gray-800 mb-5">New Video</h2>

            @if ($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 rounded-xl px-4 py-3 text-sm text-red-700">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Loading Overlay --}}
            <div id="upload-overlay"
                class="hidden absolute inset-0 z-10 bg-white/80 rounded-xl flex flex-col items-center justify-center gap-3">
                <div class="w-10 h-10 border-4 border-indigo-200 border-t-indigo-600 rounded-full animate-spin"></div>
                <p class="text-sm font-medium text-gray-700">Uploading video<span class="dot-animate">...</span></p>
                <p class="text-xs text-gray-400">This may take a while for large files</p>
            </div>

            <form id="video-form" method="POST" action="{{ route('videos.store') }}" enctype="multipart/form-data"
                class="space-y-4">
                @csrf

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm bg-gray-50
                               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                        placeholder="e.g. Introduction to Laravel">
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select id="category_id" name="category_id" required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm bg-gray-50
                               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        <option value="">Select a category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description
                        <span class="text-gray-400 font-normal">(optional)</span>
                    </label>
                    <textarea id="description" name="description" rows="3"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm bg-gray-50
                               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                        placeholder="Brief description of the video">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-1">Thumbnail
                        <span class="text-gray-400 font-normal">(optional)</span>
                    </label>
                    <div id="thumbnail-preview-container" class="hidden mb-2">
                        <img id="thumbnail-preview" src="" alt="Thumbnail preview"
                            class="w-40 h-24 object-cover rounded-lg border border-gray-200">
                    </div>
                    <input type="file" id="thumbnail" name="thumbnail" accept="image/jpg,image/jpeg,image/png,image/webp"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm bg-gray-50
                               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition
                               file:mr-4 file:py-1.5 file:px-4 file:rounded-lg file:border-0
                               file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700
                               hover:file:bg-indigo-100 file:cursor-pointer">
                    <p class="mt-1 text-xs text-gray-400">Accepted: JPG, JPEG, PNG, WebP. Max 2MB.</p>
                </div>

                <div>
                    <label for="video" class="block text-sm font-medium text-gray-700 mb-1">Video File</label>
                    <input type="file" id="video" name="video" accept="video/*" required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm bg-gray-50
                               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition
                               file:mr-4 file:py-1.5 file:px-4 file:rounded-lg file:border-0
                               file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700
                               hover:file:bg-indigo-100 file:cursor-pointer">
                    <p class="mt-1 text-xs text-gray-400">Accepted: MP4, MPEG, MOV, AVI, WebM. Max 100MB.</p>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" id="submit-btn"
                        class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
                        Save Video
                    </button>
                    <a href="{{ route('videos.index') }}"
                        class="px-5 py-2.5 rounded-xl text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <style>
        @keyframes dotPulse {

            0%,
            20% {
                content: '.';
            }

            40% {
                content: '..';
            }

            60%,
            100% {
                content: '...';
            }
        }
    </style>

    <script>
        const MAX_SIZE = 100 * 1024 * 1024; // 100MB

        document.getElementById('thumbnail').addEventListener('change', function() {
            const container = document.getElementById('thumbnail-preview-container');
            const preview = document.getElementById('thumbnail-preview');
            if (this.files && this.files[0]) {
                if (this.files[0].size > 2 * 1024 * 1024) {
                    alert('Thumbnail too large. Maximum size is 2MB.');
                    this.value = '';
                    container.classList.add('hidden');
                    return;
                }
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    container.classList.remove('hidden');
                };
                reader.readAsDataURL(this.files[0]);
            } else {
                container.classList.add('hidden');
            }
        });

        document.getElementById('video').addEventListener('change', function() {
            if (this.files.length > 0 && this.files[0].size > MAX_SIZE) {
                alert('File too large. Maximum size is 100MB.');
                this.value = '';
            }
        });

        document.getElementById('video-form').addEventListener('submit', function(e) {
            const fileInput = document.getElementById('video');
            if (!fileInput.files.length) {
                e.preventDefault();
                alert('Please select a video file.');
                return;
            }
            if (fileInput.files[0].size > MAX_SIZE) {
                e.preventDefault();
                alert('File too large. Maximum size is 100MB.');
                return;
            }

            // Show loading overlay
            document.getElementById('upload-overlay').classList.remove('hidden');
            document.getElementById('submit-btn').disabled = true;
        });
    </script>
@endsection
