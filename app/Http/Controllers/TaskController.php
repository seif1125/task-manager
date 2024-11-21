<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller


{
    public function index(Request $request)
    {
        $query = Task::query();

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('assignee_id') && $request->assignee_id) {
            $query->where('assignee_id', $request->assignee_id);
        }

        $tasksCreated = $query->where('user_id', auth()->id())->get();
        $tasksAssigned = $query->where('assignee_id', auth()->id())->get();

        $users = User::all();

        return view('dashboard', compact('tasksCreated', 'tasksAssigned', 'users'));
    }

public function dashboard(Request $request)
{
    // Get tasks created by the logged-in user
$tasksCreated = Task::where('user_id', auth()->id())->get();

// Get tasks assigned to the logged-in user
$tasksAssigned = Task::where('assignee_id', auth()->id())->get();

// Fetch all users for assignee dropdown
$users = User::all();

// For filtering tasks (optional)
$tasks = Task::query();

if ($request->has('status') && $request->status !== '') {
    $tasks->where('status', $request->status);
}

if ($request->has('assignee_id') && $request->assignee_id !== '') {
    $tasks->where('assignee_id', $request->assignee_id);
}

// Get filtered tasks
$tasks = $tasks->get();

return view('dashboard', compact('tasks', 'tasksCreated', 'tasksAssigned', 'users'));
}

    // Create a new task
    public function create()
    {
        $users = User::all(); // For task assignment
        return view('tasks.create', compact('users'));
    }

    // Store a new task
    public function store(Request $request)
{
    echo 'store';
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'status' => 'required|string|in:open,in progress,completed',
        'assignee_id' => 'nullable|exists:users,id',

    ]);

    Task::create([
        'title' => $request->title,
        'description' => $request->description,
        'status' => $request->status,
        'assignee_id' => $request->assignee_id,
        'user_id' => auth()->id(),
        'due_date'=>'2024-12-16 15:48:47'
    ]);

    return redirect()->route('dashboard')->with('success', 'Task created successfully!');
}

    public function show($taskId)
    {
        // Retrieve the task with the given ID
        $task = Task::findOrFail($taskId);

        // Pass the task to the view
        return redirect()->route('dashboard')->with('success', 'Task assigned successfully!');
    }

    public function updateStatus(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        // Validate the status input
        $request->validate([
            'status' => 'required|in:open,in progress,completed',
        ]);

        // Update the status
        $task->status = $request->input('status');
        $task->save();

        // Redirect back to the dashboard
        return redirect()->route('dashboard');
    }

    public function assignTask(Request $request, Task $task)
    {
        // Validate the assignee_id
        $request->validate([
            'assignee_id' => 'required|exists:users,id', // Ensure the assignee exists in the users table
        ]);

        // Update the assignee of the task
        $task->assignee_id = $request->input('assignee_id');
        $task->save();

        // Redirect back with a success message
        return redirect()->route('dashboard')->with('success', 'Task assigned successfully!');
    }
    public function storeComment(Request $request, Task $task)
    {
        // Validate the comment content
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        // Save the comment (assumes a relationship between Task and Comment models)
        $task->comments()->create([
            'content' => $request->input('content'),
            'user_id' => auth()->id(), // Assuming you're associating with the logged-in user
        ]);

        // Redirect with a success message
        return redirect()->route('tasks.show', $task->id)->with('success', 'Comment added successfully!');
    }




    /**
     * Display a listing of tasks.
     */
    // public function index()
    // {
    //     // Fetch all tasks with relationships
    //     $tasks = Task::with(['user', 'assignee'])->get();

    //     return response()->json([
    //         'success' => true,
    //         'data' => $tasks,
    //     ]);
    // }

    /**
     * Store a newly created task in storage.
     */
    // public function store(Request $request)
    // {
        // Validate input
    //     $validated = $request->validate([
    //         'title' => 'required|string|max:255',
    //         'description' => 'nullable|string',
    //         'due_date' => 'required|date',
    //         'status' => 'required|in:open,in progress,completed',
    //         'priority' => 'required|in:low,medium,high',
    //         'user_id' => 'required|exists:users,id',
    //         'assignee_id' => 'nullable|exists:users,id',
    //     ]);

    //     // Create the task
    //     $task = Task::create($validated);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Task created successfully',
    //         'data' => $task,
    //     ], 201);
    // }

    // /**
    //  * Display the specified task.
    //  */
    // public function show($id)
    // {
    //     // Find task by ID
    //     $task = Task::with(['user', 'assignee', 'comments'])->find($id);

    //     if (!$task) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Task not found',
    //         ], 404);
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'data' => $task,
    //     ]);
    // }

    // /**
    //  * Update the specified task in storage.
    //  */
    // public function update(Request $request, $id)
    // {
    //     // Find task by ID
    //     $task = Task::find($id);

    //     if (!$task) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Task not found',
    //         ], 404);
    //     }

    //     // Validate input
    //     $validated = $request->validate([
    //         'title' => 'sometimes|required|string|max:255',
    //         'description' => 'sometimes|nullable|string',
    //         'due_date' => 'sometimes|required|date',
    //         'status' => 'sometimes|required|in:open,in progress,completed',
    //         'priority' => 'sometimes|required|in:low,medium,high',
    //         'user_id' => 'sometimes|required|exists:users,id',
    //         'assignee_id' => 'sometimes|nullable|exists:users,id',
    //     ]);

    //     // Update the task
    //     $task->update($validated);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Task updated successfully',
    //         'data' => $task,
    //     ]);
    // }

    // /**
    //  * Remove the specified task from storage.
    //  */
    // public function destroy($id)
    // {
    //     // Find task by ID
    //     $task = Task::find($id);

    //     if (!$task) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Task not found',
    //         ], 404);
    //     }

    //     // Delete the task
    //     $task->delete();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Task deleted successfully',
    //     ]);
    // }
}
