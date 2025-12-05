@extends('layouts.main')

@section('content')
@php
    $initial = strtoupper(substr($user->name ?? $user->email ?? 'U', 0, 1));
@endphp

<div class="max-w-3xl mx-auto space-y-8">
    <div class="flex items-center gap-4">
        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center text-lg font-bold uppercase">
            {{ $initial }}
        </div>
        <div>
            <p class="text-sm text-neutral-400">Signed in as</p>
            <p class="text-2xl font-bold">{{ $user->name }}</p>
            <p class="text-sm text-neutral-500">{{ $user->email }}</p>
        </div>
    </div>

    <div class="bg-neutral-900 border border-neutral-800 rounded-xl p-6 space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-lg font-semibold">Profile</p>
                <p class="text-sm text-neutral-400">Ubah nama dan email akun kamu.</p>
            </div>
            @if (session('status') === 'profile-updated')
                <span class="text-sm text-green-400">Changes saved</span>
            @endif
        </div>

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
            @csrf
            @method('patch')

            <div class="space-y-2">
                <label for="name" class="text-sm text-neutral-300">Nama</label>
                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name', $user->name) }}"
                    class="w-full bg-neutral-950 border border-neutral-800 rounded-lg px-4 py-2 text-sm focus:outline-none focus:border-purple-500"
                    required
                    autocomplete="name"
                >
                @error('name')
                    <p class="text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="email" class="text-sm text-neutral-300">Email</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email', $user->email) }}"
                    class="w-full bg-neutral-950 border border-neutral-800 rounded-lg px-4 py-2 text-sm focus:outline-none focus:border-purple-500"
                    required
                    autocomplete="email"
                >
                @error('email')
                    <p class="text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3">
                <button
                    type="submit"
                    class="px-4 py-2 rounded-lg bg-purple-600 hover:bg-purple-500 text-sm font-semibold"
                >
                    Simpan perubahan
                </button>
                <a href="{{ route('home') }}" class="text-sm text-neutral-400 hover:text-white">Batal</a>
            </div>
        </form>
    </div>

    <div class="bg-neutral-900 border border-neutral-800 rounded-xl p-6 flex items-center justify-between">
        <div>
            <p class="font-semibold">Logout</p>
            <p class="text-sm text-neutral-400">Keluar dari akun ini.</p>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
                type="submit"
                class="px-4 py-2 rounded-lg border border-neutral-700 text-sm hover:border-red-400 hover:text-red-300"
            >
                Logout
            </button>
        </form>
    </div>
</div>
@endsection
