@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div>
 <h2>Welcome to the Dashboard!</h2>
</div>

@if (session('success'))
    <div class="mb-4 rounded-lg border border-emerald-400/30 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-300">
        {{ session('success') }}
    </div>
@endif

@if (auth()->user()->email_verified_at == null)
    <div class="mt-4 flex items-center justify-between gap-4 rounded-lg border border-amber-400/30 bg-amber-400/10 px-4 py-3">
        <p class="text-sm text-amber-300">
            Please verify your email address to access your profile.
        </p>
        <form method="POST" action="/email/resend">
            @csrf
            <button type="submit" class="text-sm font-medium text-amber-200 underline hover:text-amber-100">
                Resend email
            </button>
        </form>
    </div>
@endif

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
         <div class="bg-[#0F1521] border border-white/10 rounded-xl p-5">
            <p class="text-sm text-slate-400">Pending Tasks</p>
            <p class="text-2xl font-semibold text-slate-100">{{ $pendingCount }}</p>
         </div>
         <div class="bg-[#0F1521] border border-white/10 rounded-xl p-5">
            <p class="text-sm text-slate-400">Tasks in progress</p>
            <p class="text-2xl font-semibold text-slate-100">{{ $inProgressCount }}</p>
         </div>
         <div class="bg-[#0F1521] border border-white/10 rounded-xl p-5">
            <p class="text-sm text-slate-400">Completed Tasks</p>
            <p class="text-2xl font-semibold text-slate-100">{{ $completedCount }}</p>
         </div>
         <div class="bg-[#0F1521] border border-white/10 rounded-xl p-5">
            <p class="text-sm text-slate-400">Total Tasks</p>
            <p class="text-2xl font-semibold text-slate-100">{{ $total }}</p>
         </div>
    </div>

    <div class="bg-[#0F1521] border border-white/10 rounded-xl p-5">
        <h3 class="text-sm font-medium text-slate-200 mb-4">Pending tasks</h3>

        <ul class="space-y-2">
            @forelse ($pendingTodos as $todo)
                <li class="text-sm text-slate-300">{{ $todo->title }}</li>
            @empty
                <li class="text-sm text-slate-500">No pending tasks. Nice work!</li>
            @endforelse
        </ul>
    </div>


    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8 items-start">

    <div class="bg-[#0F1521] border border-white/10 rounded-xl p-5">
        <h3 class="text-sm font-medium text-slate-200 mb-4">Task analysis</h3>

        @if ($total > 0)
        <div class="max-w-xs mx-auto">
            <canvas id="statusChart"
                    data-pending="{{ $pendingCount }}"
                    data-in-progress="{{ $inProgressCount }}"
                    data-completed="{{ $completedCount }}"
                    data-total="{{ $total }}"></canvas>
        </div>
        @else
            <div class="flex flex-col items-center justify-center py-10 text-center">
                <div class="w-12 h-12 rounded-full bg-teal-400/10 border border-teal-400/30 flex items-center justify-center mb-3">
                    <span class="text-teal-300 text-lg">+</span>
                </div>
                <p class="text-sm font-medium text-slate-200">No tasks yet</p>
                <p class="text-xs text-slate-500 mt-1">Add your first todo to see your task breakdown here.</p>
            </div>
        @endif
    </div>

    <div class="bg-[#0F1521] border border-white/10 rounded-xl p-5">
        <h3 class="text-sm font-medium text-slate-200 mb-4">Quick add</h3>

        <form method="POST" action="/todos" class="flex gap-2">
            @csrf
            <input type="text" name="title" placeholder="Add a task..."
                   class="flex-1 rounded-md bg-[#0B0F17] border border-white/10 text-slate-100 text-sm px-3 py-2.5">

            <select name="status"
                    class="rounded-md bg-[#0B0F17] border border-white/10 text-slate-100 text-sm px-3 py-2.5">
                @foreach (\App\Models\Todo::STATUSES as $status)
                    <option value="{{ $status }}" {{ $status === 'pending' ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                    </option>
                @endforeach
            </select>

            <button type="submit"
                    class="bg-teal-500 text-[#0B0F17] font-medium text-sm px-5 py-2.5 rounded-md hover:bg-teal-400 transition-colors">
                Add
            </button>
        </form>
    </div>

</div>
@endsection

