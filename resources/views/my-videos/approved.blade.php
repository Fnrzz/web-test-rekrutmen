@extends('layouts.app')

@section('content')
    @include('layouts.navbar')

    <div class="pt-32 px-16 pb-16 min-h-screen">
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900">Video Saya</h1>
            <p class="text-lg text-gray-500 mt-2">Video yang sudah disetujui dan bisa kamu tonton</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @forelse ($requests as $req)
                @php
                    $isExpired = $req->expired_at && $req->expired_at->isPast();
                @endphp
                <a href="{{ route('video.detail', $req->video) }}"
                    class="bg-white rounded-2xl border border-gray-200 overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all duration-300 block {{ $isExpired ? 'opacity-60' : '' }}">
                    @if ($req->video->thumbnail)
                        <img src="{{ asset('storage/' . $req->video->thumbnail) }}" alt="{{ $req->video->title }}"
                            class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                            <i class="bi bi-play-circle text-gray-300 text-5xl"></i>
                        </div>
                    @endif
                    <div class="p-5 flex flex-col gap-3">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="text-xs bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full font-semibold">
                                {{ $req->video->category->name ?? '—' }}
                            </span>
                            @if ($isExpired)
                                <span class="text-xs bg-red-100 text-red-700 px-3 py-1 rounded-full font-semibold">
                                    <i class="bi bi-x-circle"></i> Kedaluwarsa
                                </span>
                            @else
                                <span class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full font-semibold">
                                    <i class="bi bi-check-circle"></i> Aktif
                                </span>
                            @endif
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 leading-snug">{{ $req->video->title }}</h3>
                        @if ($req->expired_at)
                            <p class="text-xs text-gray-400">
                                @if ($isExpired)
                                    Kedaluwarsa {{ $req->expired_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB
                                @else
                                    Berlaku hingga {{ $req->expired_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }}
                                    WIB
                                @endif
                            </p>
                        @endif
                    </div>
                </a>
            @empty
                <div class="col-span-4 flex flex-col items-center justify-center py-20 text-center">
                    <i class="bi bi-collection-play text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-lg font-semibold text-gray-400">Belum ada video yang disetujui</h3>
                    <p class="text-sm text-gray-400 mt-1">Jelajahi <a href="{{ route('catalog') }}"
                            class="text-indigo-600 hover:underline">catalog</a> dan minta akses untuk menonton video.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
