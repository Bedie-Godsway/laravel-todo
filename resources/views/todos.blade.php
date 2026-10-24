@extends('layouts.app')

@section('title', 'All Todos')

@section('content')
<div class="w-full max-w-4xl mx-auto">

    <div class="mb-6">
        <h2 class="text-xl font-semibold text-slate-100">Your Todos</h2>
        <p class="text-sm text-slate-500 mt-1">Add, filter, update and remove your tasks.</p>
    </div>

    {{-- Add a todo --}}
    <div class="bg-[#0F1521] border border-white/10 rounded-xl p-5 mb-6">
        <form method="POST" action="/todos" class="flex gap-2">
            @csrf
            <input type="text" name="title" placeholder="New task..."
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

    {{-- Filter and sort --}}
    <form method="GET" action="/todos" class="flex flex-wrap gap-3 mb-6">
        <select name="status" onchange="this.form.submit()"
                class="rounded-md bg-[#0F1521] border border-white/10 text-slate-200 text-sm px-3 py-2">
            <option value="">All statuses</option>
            @foreach (\App\Models\Todo::STATUSES as $status)
                <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                </option>
            @endforeach
        </select>

        <select name="sort" onchange="this.form.submit()"
                class="rounded-md bg-[#0F1521] border border-white/10 text-slate-200 text-sm px-3 py-2">
            <option value="created_at" {{ request('sort', 'created_at') === 'created_at' ? 'selected' : '' }}>Date created</option>
            <option value="title" {{ request('sort') === 'title' ? 'selected' : '' }}>Title</option>
            <option value="status" {{ request('sort') === 'status' ? 'selected' : '' }}>Status</option>
        </select>

        <select name="direction" onchange="this.form.submit()"
                class="rounded-md bg-[#0F1521] border border-white/10 text-slate-200 text-sm px-3 py-2">
            <option value="desc" {{ request('direction', 'desc') === 'desc' ? 'selected' : '' }}>Descending</option>
            <option value="asc" {{ request('direction') === 'asc' ? 'selected' : '' }}>Ascending</option>
        </select>
    </form>

    {{-- Todo list --}}
    <ul class="space-y-3">
        @forelse ($todos as $todo)
            <li class="bg-[#0F1521] border border-white/10 rounded-xl px-5 py-4 flex items-center gap-4">

                <span class="flex-1 text-sm {{ $todo->status === 'completed' ? 'line-through text-slate-500' : 'text-slate-100' }}">
                    {{ $todo->title }}
                </span>

                <form method="POST" action="/todos/{{ $todo->id }}">
                    @csrf
                    @method('PATCH')
                    <select name="status" onchange="this.form.submit()"
                            class="rounded-md bg-[#0B0F17] border border-white/10 text-slate-200 text-xs px-2 py-1.5">
                        @foreach (\App\Models\Todo::STATUSES as $status)
                            <option value="{{ $status }}" {{ $todo->status === $status ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                            </option>
                        @endforeach
                    </select>
                </form>

                <a href="{{ route('todos.edit', ['todo' => $todo->id]) }}"
                   class="text-xs font-medium text-teal-300 border border-teal-400/30 bg-teal-400/10 hover:bg-teal-400/20 rounded-md px-3 py-1.5 transition-colors">
                    Edit
                </a>

                <form method="POST" action="/todos/{{ $todo->id }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="text-xs font-medium text-red-300 border border-red-400/30 bg-red-400/10 hover:bg-red-400/20 rounded-md px-3 py-1.5 transition-colors">
                        Delete
                    </button>
                </form>
            </li>
        @empty
    <li class="bg-[#0F1521] border border-white/10 rounded-xl px-5 py-8 text-center">
        @if (request('status'))
            <p class="text-sm text-slate-500">No todos match this filter.</p>
        @else
            <p class="text-sm font-medium text-slate-200">No todos yet</p>
            <p class="text-xs text-slate-500 mt-1">Add your first task above to get started.</p>
        @endif
    </li>
        @endforelse
    </ul>

</div>
@endsection