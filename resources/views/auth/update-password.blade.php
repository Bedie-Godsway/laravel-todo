@extends('layouts.app')

@section('title', 'Change password')

@section('content')

@if (session('success'))
    <div class="mb-4 rounded-lg border border-emerald-400/30 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-300">
        {{ session('success') }}
    </div>
@endif

<div class="min-h-screen flex items-center justify-center bg-[#0B0F17] px-4">

    <form method="POST" id="updatePassword" action="/profile/updatePassword"
          class="w-full max-w-md bg-[#0F1521] border border-white/10 rounded-xl p-8 shadow-xl">
        @csrf

        <h1 class="text-lg font-semibold text-slate-100 mb-1">Change Passwod</h1>
        <p class="text-sm text-slate-500 mb-6">Update the password and save your changes.</p>

        @if ($errors->any())
                <div class="mb-4 text-sm text-red-400">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>  
        @endif


        <div class="mb-6">
            <label for="password_current" class="block text-sm font-medium text-slate-300 mb-2">Current Password</label>
            <input type="password" id="password_current" name="password_current" value=""
                   class="w-full rounded-md bg-[#0B0F17] border border-white/10 text-slate-100 text-sm px-3 py-2.5
                          focus:outline-none focus:ring-2 focus:ring-teal-400/50 focus:border-teal-400/50">
        </div>

        <div class="mb-6">
            <label for="password" class="block text-sm font-medium text-slate-300 mb-2">New Password</label>
            <input type="password" id="password" name="password" value=""
                   class="w-full rounded-md bg-[#0B0F17] border border-white/10 text-slate-100 text-sm px-3 py-2.5
                          focus:outline-none focus:ring-2 focus:ring-teal-400/50 focus:border-teal-400/50">
        </div>

        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-medium text-slate-300 mb-2">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" value=""
                   class="w-full rounded-md bg-[#0B0F17] border border-white/10 text-slate-100 text-sm px-3 py-2.5
                          focus:outline-none focus:ring-2 focus:ring-teal-400/50 focus:border-teal-400/50">
        </div>

        <div class="flex items-center gap-3">
            <button type="submit"
                    class="bg-teal-500 text-[#0B0F17] font-medium text-sm px-5 py-2.5 rounded-md hover:bg-teal-400 transition-colors">
                Save Password
            </button>
            <a href="/profile" class="text-sm text-slate-400 hover:text-slate-200 transition-colors">Cancel</a>
        </div>
    </form>

</div>
@endsection