<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\AuditLog;

class TodoController extends Controller
{
    public function index(Request $request)
    {
        $query = Todo::where('user_id', Auth::id());
       
        if ($request->filled('status') && in_array($request->status, Todo::STATUSES)) {
            $query->where('status', $request->status);
        }

        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');

        $allowedSorts = ['created_at', 'title', 'status'];
        if (in_array($sort, $allowedSorts)) {
            $query->orderBy($sort, $direction === 'asc' ? 'asc' : 'desc');
        }

        $todos = $query->get();

        return view('todos', ['todos' => $todos]);
    }

    private function statusCounts()
    {
    $pendingCount = Todo::where('user_id', Auth::id())
        ->where('status', 'pending')->count();
    $inProgressCount = Todo::where('user_id', Auth::id())
        ->where('status', 'in_progress')->count();
    $completedCount = Todo::where('user_id', Auth::id())
        ->where('status', 'completed')->count();
    $total = Todo::where('user_id', Auth::id())
        ->count();

    return [
        'pendingCount'    => $pendingCount,
        'inProgressCount' => $inProgressCount,
        'completedCount'  => $completedCount,
        'total'           => $total,
    ];
    }

    private function pendingTodos(){
        return Todo::where('user_id', Auth::id())
            ->where('status', 'pending')
        ->latest('created_at')
        ->take(5)
        ->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'  => 'required|string|max:255',
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        Todo::create([
            'title'  => $request->title,
            'status' => $request->status,
            'user_id' => Auth::id(),
        ]);

        return back()->with('success', 'Task added');
    }

    public function update(Request $request, Todo $todo)
    {
        abort_if($todo->user_id !== Auth::id(), 403);

        $request->validate([
            'status' => 'sometimes|in:pending,in_progress,completed',
            'title'  => 'sometimes|string|max:255',
        ]);

        
    $data = [];

    if ($request->filled('title')) {
        $data['title'] = $request->title;
    }

    if ($request->filled('status')) {
        $data['status'] = $request->status;
    }

    $todo->update($data);
    
        return redirect('/todos');
    }


    public function edit(Todo $todo)
    {
        abort_if($todo->user_id !== Auth::id(), 403);
        return view('edit', ['todo' => $todo]);
    }


    public function destroy(Todo $todo)
    {
        abort_if($todo->user_id !== Auth::id(), 403);
        $todo->delete();

        return redirect('/todos');
    }


    public function dashboardPage()
    {
        return view('pages.dashboard', array_merge(
        $this->statusCounts(),
        ['pendingTodos' => $this->pendingTodos()]
        ));
    }
    

    public function profilePage()
    {
    $logs = AuditLog::where('user_id', Auth::id())
        ->latest('created_at')
        ->take(10)
        ->get();

    return view('pages.profile', ['logs' => $logs]);
    }

    public function settingsPage()
    {
        return view('pages.settings');
    }

    public function footerPage()
    {
        return redirect('/todos');
    }
}