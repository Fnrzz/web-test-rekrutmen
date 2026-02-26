@extends('layouts.app')

@section('content')
    @include('layouts.navbar')
    <div class="pt-24 md:pt-32 px-6 sm:px-10 lg:px-16 pb-12 md:pb-16 min-h-screen">
        <div class="mb-6 md:mb-8">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900">Semua Video</h1>
            <p class="text-base md:text-lg text-gray-500 mt-2">Jelajahi semua video pembelajaran yang tersedia</p>
        </div>

        <div class="flex flex-wrap items-center gap-3 mb-10">
            <a href="{{ route('catalog') }}"
                class="px-4 py-2 rounded-full text-sm font-semibold transition
                       {{ !request('category') ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Semua
            </a>
            @foreach ($categories as $category)
                <a href="{{ route('catalog', ['category' => $category->slug]) }}"
                    class="px-4 py-2 rounded-full text-sm font-semibold transition
                           {{ request('category') == $category->slug ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @forelse ($videos as $video)
                <a href="{{ route('video.detail', $video) }}"
                    class="bg-white rounded-2xl border border-gray-200 overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all duration-300 block">
                    @if ($video->thumbnail)
                        <img src="{{ asset('storage/' . $video->thumbnail) }}" alt="{{ $video->title }}"
                            class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                            <i class="bi bi-play-circle text-gray-300 text-5xl"></i>
                        </div>
                    @endif
                    <div class="p-5 flex flex-col gap-3">
                        <div>
                            <span class="text-xs bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full font-semibold">
                                {{ $video->category->name ?? '—' }}
                            </span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 leading-snug">{{ $video->title }}</h3>
                        @if ($video->description)
                            <p class="text-sm text-gray-500 leading-relaxed">
                                {{ Str::limit($video->description, 50) }}
                            </p>
                        @endif
                    </div>
                </a>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center py-20 text-center">
                    <i class="bi bi-collection-play text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-lg font-semibold text-gray-400">Belum ada video tersedia</h3>
                    <p class="text-sm text-gray-400 mt-1">Video akan muncul di sini setelah diunggah oleh admin.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
