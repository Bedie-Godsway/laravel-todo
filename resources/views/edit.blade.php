@extends('layouts.app')

@section('title', 'Edit Todo')

@section('content')

@if ($errors->any())
    <div class="mb-4 text-sm text-red-400">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="min-h-screen flex items-center justify-center bg-[#0B0F17] px-4">

    <form method="POST" id="editForm" action="/todos/{{ $todo->id }}"
          class="w-full max-w-md bg-[#0F1521] border border-white/10 rounded-xl p-8 shadow-xl">
        @csrf
        @method('PATCH')

        <h1 class="text-lg font-semibold text-slate-100 mb-1">Edit Todo</h1>
        <p class="text-sm text-slate-500 mb-6">Update the title below and save your changes.</p>

        <div class="mb-6">
            <label for="title" class="block text-sm font-medium text-slate-300 mb-2">Title</label>
            <input type="text" id="title" name="title" value="{{ $todo->title }}"
                   class="w-full rounded-md bg-[#0B0F17] border border-white/10 text-slate-100 text-sm px-3 py-2.5
                          focus:outline-none focus:ring-2 focus:ring-teal-400/50 focus:border-teal-400/50">
        </div>

        <div class="flex items-center gap-3">
            <button type="submit"
                    class="bg-teal-500 text-[#0B0F17] font-medium text-sm px-5 py-2.5 rounded-md hover:bg-teal-400 transition-colors">
                Save
            </button>
            <a href="/todos" class="text-sm text-slate-400 hover:text-slate-200 transition-colors">Cancel</a>
        </div>
    </form>

</div>
@endsection