@extends('layouts.app')

@section('content')
    @include('layouts.navbar')

    <div class="pt-32 px-16 pb-16 min-h-screen">
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900">Menunggu Akses</h1>
            <p class="text-lg text-gray-500 mt-2">Video yang sedang menunggu persetujuan admin</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @forelse ($requests as $req)
                <a href="{{ route('video.detail', $req->video) }}"
                    class="bg-white rounded-2xl border border-gray-200 overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all duration-300 block">
                    @if ($req->video->thumbnail)
                        <img src="{{ asset('storage/' . $req->video->thumbnail) }}" alt="{{ $req->video->title }}"
                            class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                            <i class="bi bi-play-circle text-gray-300 text-5xl"></i>
                        </div>
                    @endif
                    <div class="p-5 flex flex-col gap-3">
                        <div class="flex items-center gap-2">
                            <span class="text-xs bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full font-semibold">
                                {{ $req->video->category->name ?? '—' }}
                            </span>
                            <span class="text-xs bg-amber-100 text-amber-700 px-3 py-1 rounded-full font-semibold">
                                <i class="bi bi-hourglass-split"></i> Pending
                            </span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 leading-snug">{{ $req->video->title }}</h3>
                        <p class="text-xs text-gray-400">
                            Diajukan {{ $req->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                </a>
            @empty
                <div class="col-span-4 flex flex-col items-center justify-center py-20 text-center">
                    <i class="bi bi-hourglass text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-lg font-semibold text-gray-400">Tidak ada permintaan yang menunggu</h3>
                    <p class="text-sm text-gray-400 mt-1">Jelajahi <a href="{{ route('catalog') }}"
                            class="text-indigo-600 hover:underline">catalog</a> untuk minta akses video.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
