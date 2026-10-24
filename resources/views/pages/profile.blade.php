@extends('layouts.app')
@section('title', 'Profile')
@section('content')

<div class="w-full max-w-4xl mx-auto">

    <div class="mb-6">
        <h2 class="text-xl font-semibold text-slate-100">Profile</h2>
        <p class="text-sm text-slate-500 mt-1">Manage your account details and activity.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        {{-- Summary card --}}
        <div class="bg-[#0F1521] border border-white/10 rounded-xl p-6 flex flex-col items-center text-center">
            <div class="w-20 h-20 rounded-full bg-teal-400/10 border border-teal-400/30 flex items-center justify-center mb-4">
                <span class="text-2xl font-semibold text-teal-300">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
            </div>

            <p class="text-base font-semibold text-slate-100">{{ Auth::user()->name }}</p>
            <p class="text-sm text-slate-400 mt-1 break-all">{{ Auth::user()->email }}</p>

            @if (Auth::user()->email_verified_at)
                <span class="mt-3 inline-block rounded-md px-2 py-0.5 text-xs font-medium bg-emerald-400/10 text-emerald-300">Email verified</span>
            @else
                <span class="mt-3 inline-block rounded-md px-2 py-0.5 text-xs font-medium bg-amber-400/10 text-amber-300">Email not verified</span>
            @endif

            <p class="text-xs text-slate-500 mt-4">Member since {{ Auth::user()->created_at->format('d M Y') }}</p>

            <a href="/profile/updatePassword"
               class="mt-6 w-full text-center text-sm font-medium text-slate-200 border border-white/10 hover:bg-white/[0.04] rounded-md px-4 py-2.5 transition-colors">
                Change password
            </a>
        </div>

        {{-- Edit form card --}}
        <div class="lg:col-span-2 bg-[#0F1521] border border-white/10 rounded-xl p-6">
            <h3 class="text-sm font-medium text-slate-200">Personal information</h3>
            <p class="text-sm text-slate-500 mt-1 mb-6">Update your name and email address.</p>

            @if ($errors->any())
                <div class="mb-6 rounded-lg border border-red-400/30 bg-red-400/10 px-4 py-3 text-sm text-red-300">
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-4 rounded-lg border border-emerald-400/30 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-300">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="/profile">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-300 mb-2">Full name</label>
                        <input type="text" id="name" name="name" value="{{ Auth::user()->name }}"
                               class="w-full rounded-md bg-[#0B0F17] border border-white/10 text-slate-100 text-sm px-3 py-2.5
                                      focus:outline-none focus:ring-2 focus:ring-teal-400/50 focus:border-teal-400/50">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-300 mb-2">Email address</label>
                        <input type="email" id="email" name="email" value="{{ Auth::user()->email }}"
                               class="w-full rounded-md bg-[#0B0F17] border border-white/10 text-slate-100 text-sm px-3 py-2.5
                                      focus:outline-none focus:ring-2 focus:ring-teal-400/50 focus:border-teal-400/50">
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                            class="bg-teal-500 text-[#0B0F17] font-medium text-sm px-5 py-2.5 rounded-md hover:bg-teal-400 transition-colors">
                        Save changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Activity log --}}
    <div class="mb-2">
        <h3 class="text-sm font-medium text-slate-200">Activity log</h3>
        <p class="text-sm text-slate-500 mt-1">Your recent sign-in and sign-out events.</p>
    </div>

    <div class="bg-[#0F1521] border border-white/10 rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="text-slate-500 text-xs">
                        <th class="px-5 py-3 font-medium">Action</th>
                        <th class="px-5 py-3 font-medium">IP Address</th>
                        <th class="px-5 py-3 font-medium">Time</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($logs as $log)
                        <tr class="border-t border-white/5 hover:bg-white/[0.03] transition-colors">
                            <td class="px-5 py-3">
                                @php
                                    $badge = match ($log->log_action) {
                                        'login'           => ['label' => 'Login',             'class' => 'bg-teal-400/10 text-teal-300'],
                                        'logout'          => ['label' => 'Logout',            'class' => 'bg-slate-400/10 text-slate-300'],
                                        'update_password' => ['label' => 'Password changed',  'class' => 'bg-amber-400/10 text-amber-300'],
                                        default           => ['label' => ucfirst($log->log_action), 'class' => 'bg-slate-400/10 text-slate-300'],
                                    };
                                @endphp

                                <span class="inline-block rounded-md px-2 py-0.5 text-xs font-medium {{ $badge['class'] }}">
                                    {{ $badge['label'] }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-slate-300">{{ $log->ip_address }}</td>
                            <td class="px-5 py-3 text-slate-400">{{ $log->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                    @empty
                        <tr class="border-t border-white/5">
                            <td colspan="3" class="px-5 py-8 text-center text-slate-500">No activity yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection