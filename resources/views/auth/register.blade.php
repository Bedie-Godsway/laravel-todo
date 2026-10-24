@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-[#0B0F17] px-4">

    <form method="POST" action="/register"
          class="w-full max-w-md bg-[#0F1521] border border-white/10 rounded-xl p-8 shadow-xl">
        @csrf

        <h1 class="text-lg font-semibold text-slate-100 mb-6">Create an account</h1>

        @if ($errors->any())
            <div class="mb-4 text-sm text-red-400">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-4">
            <label class="block text-sm font-medium text-slate-300 mb-2">Name</label>
            <input type="text" name="name" value="{{ old('name') }}"
                   class="w-full rounded-md bg-[#0B0F17] border border-white/10 text-slate-100 text-sm px-3 py-2.5">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-slate-300 mb-2">Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                   class="w-full rounded-md bg-[#0B0F17] border border-white/10 text-slate-100 text-sm px-3 py-2.5">
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-slate-300 mb-2">Password</label>
            <input type="password" name="password"
                   class="w-full rounded-md bg-[#0B0F17] border border-white/10 text-slate-100 text-sm px-3 py-2.5">
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-slate-300 mb-2">Confirm Password</label>
            <input type="password" name="password_confirmation"
                   class="w-full rounded-md bg-[#0B0F17] border border-white/10 text-slate-100 text-sm px-3 py-2.5">
        </div>

        <button type="submit"
                class="w-full bg-teal-500 text-[#0B0F17] font-medium text-sm px-5 py-2.5 rounded-md hover:bg-teal-400 transition-colors">
            Register
        </button>
    </form>

</div>
@endsection