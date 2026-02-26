@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8 space-y-6">
            <div class="text-center">
                <h1 class="text-2xl font-bold text-gray-900">Sign In</h1>
                <p class="text-sm text-gray-500 mt-1">Enter your credentials to continue</p>
            </div>
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-xl px-4 py-3 text-sm text-red-700">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('authenticate') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        placeholder="you@example.com" required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm bg-gray-50
                           focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                           transition-all duration-200">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm bg-gray-50
                           focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                           transition-all duration-200">
                </div>

                <button type="submit"
                    class="w-full py-2.5 rounded-xl text-sm font-semibold text-white
                       bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800
                       focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                       transition-all duration-200 cursor-pointer">
                    Sign In
                </button>
            </form>
        </div>
    </div>

@endsection
