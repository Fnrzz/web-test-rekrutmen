@extends('layouts.app')

@section('content')
    @include('layouts.navbar')

    <div class="pt-24 md:pt-30 px-6 sm:px-10 lg:px-16 pb-12 md:pb-16 min-h-screen">
        <a href="{{ route('catalog') }}"
            class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-indigo-600 transition mb-6">
            <i class="bi bi-arrow-left"></i> Kembali ke Catalog
        </a>

        <div class="flex flex-col lg:flex-row gap-10">
            <div class="w-full lg:w-2/3">
                @if ($canWatch)
                    <div class="rounded-2xl overflow-hidden bg-black shadow-lg">
                        <video class="w-full aspect-video" controls controlsList="nodownload">
                            <source src="{{ asset('storage/' . $video->url) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                    @if ($accessRequest && $accessRequest->expired_at)
                        <div class="mt-3 flex items-center gap-2 text-sm text-amber-600 bg-amber-50 px-4 py-2 rounded-xl">
                            <i class="bi bi-clock"></i>
                            Akses berlaku hingga
                            {{ $accessRequest->expired_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB
                        </div>
                    @endif
                @else
                    <div class="relative rounded-2xl overflow-hidden shadow-lg">
                        @if ($video->thumbnail)
                            <img src="{{ asset('storage/' . $video->thumbnail) }}" alt="{{ $video->title }}"
                                class="w-full aspect-video object-cover">
                        @else
                            <div class="w-full aspect-video bg-gray-200 flex items-center justify-center">
                                <i class="bi bi-play-circle text-gray-300 text-7xl"></i>
                            </div>
                        @endif
                        <div
                            class="absolute inset-0 bg-black/60 backdrop-blur-sm flex flex-col items-center justify-center gap-4">
                            <div
                                class="w-14 h-14 md:w-20 md:h-20 rounded-full bg-white/10 flex items-center justify-center">
                                <i class="bi bi-lock-fill text-white text-2xl md:text-3xl"></i>
                            </div>
                            @guest
                                <p class="text-white text-base md:text-lg font-semibold text-center px-4">Login untuk menonton
                                    video</p>
                                <a href="{{ route('login') }}"
                                    class="px-6 py-2.5 rounded-full text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition">
                                    Login Sekarang
                                </a>
                            @else
                                @if ($accessRequest && $accessRequest->status === 'pending')
                                    <p class="text-white text-base md:text-lg font-semibold text-center px-4">Permintaan akses
                                        sedang diproses</p>
                                    <span class="px-6 py-2.5 rounded-full text-sm font-semibold text-amber-300 bg-amber-900/40">
                                        <i class="bi bi-hourglass-split"></i> Menunggu Persetujuan Admin
                                    </span>
                                @elseif ($accessRequest && $accessRequest->status === 'rejected')
                                    <p class="text-white text-base md:text-lg font-semibold text-center px-4">Permintaan akses
                                        ditolak</p>
                                    <form method="POST" action="{{ route('video.request-access', $video) }}">
                                        @csrf
                                        <button type="submit"
                                            class="px-6 py-2.5 rounded-full text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition cursor-pointer">
                                            <i class="bi bi-arrow-repeat"></i> Minta Akses Ulang
                                        </button>
                                    </form>
                                @elseif (
                                    $accessRequest &&
                                        $accessRequest->status === 'approved' &&
                                        $accessRequest->expired_at &&
                                        $accessRequest->expired_at->isPast())
                                    <p class="text-white text-base md:text-lg font-semibold text-center px-4">Akses telah
                                        kedaluwarsa</p>
                                    <form method="POST" action="{{ route('video.request-access', $video) }}">
                                        @csrf
                                        <button type="submit"
                                            class="px-6 py-2.5 rounded-full text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition cursor-pointer">
                                            <i class="bi bi-arrow-repeat"></i> Minta Akses Ulang
                                        </button>
                                    </form>
                                @else
                                    <p class="text-white text-base md:text-lg font-semibold text-center px-4">Anda belum
                                        memiliki akses</p>
                                    <form method="POST" action="{{ route('video.request-access', $video) }}">
                                        @csrf
                                        <button type="submit"
                                            class="px-6 py-2.5 rounded-full text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition cursor-pointer">
                                            <i class="bi bi-key"></i> Minta Akses
                                        </button>
                                    </form>
                                @endif
                            @endguest
                        </div>
                    </div>
                @endif
            </div>
            <div class="w-full lg:w-1/3 flex flex-col gap-5">
                <div>
                    <span class="text-xs bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full font-semibold">
                        {{ $video->category->name ?? '—' }}
                    </span>
                </div>
                <h1 class="text-xl md:text-2xl font-bold text-gray-900">{{ $video->title }}</h1>
                @if ($video->description)
                    <p class="text-gray-600 leading-relaxed">{{ $video->description }}</p>
                @endif
                <div class="flex flex-col gap-2 text-sm text-gray-400">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-calendar3"></i>
                        Diunggah {{ $video->created_at->format('d M Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
