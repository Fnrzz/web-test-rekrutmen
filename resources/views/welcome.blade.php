@extends('layouts.app')

@section('content')
    @include('layouts.navbar')
    <div class="w-full min-h-screen flex flex-col md:flex-row items-center justify-center px-6 sm:px-10 lg:px-16">
        <div class="w-full md:w-2/5 h-full flex flex-col gap-4 md:gap-5 text-center md:text-left">
            <h3 class="text-base md:text-lg text-green-400 font-semibold">#SpiritOfLearning</h3>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold">Design & Code Your Future Career</h1>
            <p class="text-base md:text-lg text-gray-600">Enhance your design and code skills with the experts
                in their field and get the official certificate</p>
            <div class="flex gap-2 justify-center md:justify-start">
                @auth
                    <a href="{{ url('/my-videos/approved') }}"
                        class="px-4 md:px-5 py-2 rounded-full text-base md:text-lg font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition">
                        My Video
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="px-4 md:px-5 py-2 rounded-full text-base md:text-lg font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition">
                        Login
                    </a>
                @endauth
                <a href="{{ route('catalog') }}"
                    class="px-4 md:px-5 py-2 rounded-full text-base md:text-lg font-semibold bg-gray-200 hover:bg-gray-300 transition">
                    See Catalog
                </a>
            </div>
        </div>
        <div class="w-full md:w-3/5 h-full flex justify-center md:justify-end mt-8 md:mt-0">
            <img src="{{ asset('images/hero.webp') }}" alt="Hero" class="w-full sm:w-4/5 h-full object-cover">
        </div>
    </div>

    <div class="flex flex-col items-center gap-6 px-6 sm:px-10 lg:px-16 mb-10">
        <h6 class="text-sm px-3 py-2 bg-indigo-200 text-indigo-800 font-bold rounded-full text-center">
            Mengikuti Jejak Orang Sukses
        </h6>
        <h1 class="max-w-xl text-xl sm:text-2xl font-bold text-center">
            Alumni Kelas Online Bekerja Pada Perusahaan Besar dan Terkenal
        </h1>
        <div class="flex flex-wrap gap-4 sm:gap-6 justify-center">
            <div class="px-4 py-3 bg-white rounded-xl shadow-sm">
                <img src="{{ asset('images/company-logo/bca.png') }}" alt="bca" class="w-full h-[30px] object-cover ">
            </div>
            <div class="px-4 py-3 bg-white rounded-xl shadow-sm">
                <img src="{{ asset('images/company-logo/tokopedia.png') }}" alt="tokopedia"
                    class="w-full h-[30px] object-cover ">
            </div>
            <div class="px-4 py-3 bg-white rounded-xl shadow-sm">
                <img src="{{ asset('images/company-logo/jnt.png') }}" alt="jnt" class="w-full h-[30px] object-cover ">
            </div>
            <div class="px-4 py-3 bg-white rounded-xl shadow-sm">
                <img src="{{ asset('images/company-logo/tiketdotcom.png') }}" alt="tiketdotcom"
                    class="w-full h-[30px] object-cover ">
            </div>
            <div class="px-4 py-3 bg-white rounded-xl shadow-sm">
                <img src="{{ asset('images/company-logo/kawan-lama-group.png') }}" alt="kawan-lama-group"
                    class="w-full h-[30px] object-cover ">
            </div>
            <div class="px-4 py-3 bg-white rounded-xl shadow-sm">
                <img src="{{ asset('images/company-logo/grab.png') }}" alt="grab" class="w-full h-[30px] object-cover ">
            </div>
            <div class="px-4 py-3 bg-white rounded-xl shadow-sm">
                <img src="{{ asset('images/company-logo/traveloka.png') }}" alt="traveloka"
                    class="w-full h-[30px] object-cover ">
            </div>
            <div class="px-4 py-3 bg-white rounded-xl shadow-sm">
                <img src="{{ asset('images/company-logo/bluebird.png') }}" alt="bluebird"
                    class="w-full h-[30px] object-cover ">
            </div>
            <div class="px-4 py-3 bg-white rounded-xl shadow-sm">
                <img src="{{ asset('images/company-logo/telkomsel.png') }}" alt="telkomsel"
                    class="w-full h-[30px] object-cover ">
            </div>
            <div class="px-4 py-3 bg-white rounded-xl shadow-sm">
                <img src="{{ asset('images/company-logo/bank-dki.png') }}" alt="bank-dki"
                    class="w-full h-[30px] object-cover ">
            </div>
            <div class="px-4 py-3 bg-white rounded-xl shadow-sm">
                <h3 class="text-xl font-bold">30+ More</h3>
            </div>
        </div>
    </div>

    <div class="w-full flex flex-col-reverse md:flex-row items-center px-6 sm:px-10 lg:px-16 mb-10">
        <div class="w-full md:w-3/5 h-full flex justify-center md:justify-start mt-8 md:mt-0">
            <img src="{{ asset('images/hero2.png') }}" alt="Hero2" class="w-full sm:w-4/5 h-full object-cover">
        </div>
        <div class="w-full md:w-2/5 h-full flex flex-col gap-4 md:gap-5 text-center md:text-left">
            <h3 class="text-base md:text-lg text-green-400 font-semibold">You Deserve Better Career</h3>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold">
                Privileges Dari Kelas Online
                Karir Semakin Tumbuh
            </h1>
            <div class="flex flex-col gap-2 items-center md:items-start">
                <div class="flex items-center gap-2">
                    <i class="bi bi-check-circle-fill text-green-400"></i>
                    <p class="text-sm text-gray-600">
                        Akses Kelas Online selamanya
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <i class="bi bi-check-circle-fill text-green-400"></i>
                    <p class="text-sm text-gray-600">
                        Free materi update kelas
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <i class="bi bi-check-circle-fill text-green-400"></i>
                    <p class="text-sm text-gray-600">
                        Real-world projects Freelancer
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <i class="bi bi-check-circle-fill text-green-400"></i>
                    <p class="text-sm text-gray-600">
                        Forum UI/UX design & Web Development
                    </p>
                </div>
            </div>
            <div class="flex gap-2 justify-center md:justify-start">
                @auth
                    <a href="{{ url('/my-videos/approved') }}"
                        class="px-4 md:px-5 py-2 rounded-full text-base md:text-lg font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition">
                        My Video
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="px-4 md:px-5 py-2 rounded-full text-base md:text-lg font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition">
                        Login
                    </a>
                @endauth
                <a href="{{ route('catalog') }}"
                    class="px-4 md:px-5 py-2 rounded-full text-base md:text-lg font-semibold bg-gray-200 hover:bg-gray-300 transition">
                    See Catalog
                </a>
            </div>
        </div>
    </div>
    <div class="flex flex-col px-6 sm:px-10 lg:px-16 gap-6">
        <h3 class="text-base md:text-lg text-green-400 font-semibold">Become Freelancer</h3>
        <h1 class="text-2xl sm:text-3xl w-full md:w-1/2 font-bold">
            Kelas Online Membantu Kamu Mendapatkan Penghasilan Tambahan
        </h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse ($latestVideos as $video)
                <a href="{{ route('video.detail', $video) }}" class="flex flex-col gap-4">
                    @if ($video->thumbnail)
                        <img src="{{ asset('storage/' . $video->thumbnail) }}" alt="{{ $video->title }}"
                            class="w-full h-48 object-cover rounded-xl">
                    @else
                        <div class="w-full h-48 rounded-xl bg-gray-100 flex items-center justify-center">
                            <i class="bi bi-play-circle text-gray-400 text-4xl"></i>
                        </div>
                    @endif
                    <div>
                        <span class="text-sm bg-indigo-200 px-3 py-2 rounded-full font-semibold">
                            {{ $video->category->name }}
                        </span>
                    </div>
                    <h3 class="text-lg font-semibold">{{ $video->title }}</h3>
                </a>
            @empty
                <div class="col-span-full text-center text-gray-400 py-8">
                    Belum ada video tersedia.
                </div>
            @endforelse
        </div>
    </div>

    <div class="w-full min-h-screen flex flex-col md:flex-row items-center px-6 sm:px-10 lg:px-16 py-12 md:py-0">
        <div class="w-full md:w-1/2 h-full flex justify-center mb-8 md:mb-0">
            <img src="{{ asset('images/hero3.webp') }}" alt="Hero3" class="w-4/5 sm:w-3/5 h-full object-cover">
        </div>
        <div class="w-full md:w-1/2 h-full flex flex-col gap-4 md:gap-5 text-center md:text-left">
            <h3 class="text-base md:text-lg text-green-400 font-semibold">Sharing is Caring.</h3>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold">
                Gabung Sebagai Mentor.
                Bagikan Skills & Pengalamanmu.
            </h1>
            <div class="flex flex-col gap-2 items-center md:items-start">
                <div class="flex items-center gap-2">
                    <i class="bi bi-check-circle-fill text-green-400"></i>
                    <p class="text-sm text-gray-600">
                        Meningkatkan personal branding
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <i class="bi bi-check-circle-fill text-green-400"></i>
                    <p class="text-sm text-gray-600">
                        Menambah sumber income
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <i class="bi bi-check-circle-fill text-green-400"></i>
                    <p class="text-sm text-gray-600">
                        Menambah networking terbaru
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <i class="bi bi-check-circle-fill text-green-400"></i>
                    <p class="text-sm text-gray-600">
                        Mendapatkan projek freelance
                    </p>
                </div>
            </div>
            <div class="flex gap-2 justify-center md:justify-start">
                <a href=""
                    class="px-4 md:px-5 py-2 rounded-full text-base md:text-lg font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition">
                    Pelajari Selengkapnya
                </a>
            </div>
        </div>
    </div>
@endsection
