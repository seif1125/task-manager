<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1, h2 {
            color: #333;
        }
        form {
            margin: 10px 0;
        }
        select, textarea, button {
            padding: 8px;
            margin: 5px 0;
        }
        .task-container {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .task-title {
            font-size: 18px;
            font-weight: bold;
        }
        .task-status {
            color: #777;
        }
        .comments {
            margin-top: 10px;
            padding: 10px;
            background-color: #e9f7e9;
            border-radius: 8px;
        }
        .no-tasks {
            color: #888;
        }
    </style>
</head>
<body>

    <h1>Welcome, {{ Auth::user()->name }}!</h1>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>

    <!-- Tasks Created Section -->
    <h2>Your Created Tasks</h2>
    @if(isset($tasksCreated) && $tasksCreated->isNotEmpty())
        @foreach($tasksCreated as $task)
            <div class="task-container">
                <p class="task-title">{{ $task->title }} - <span class="task-status">Status: {{ $task->status }}</span></p>

                <!-- Update Task Status -->
                <form action="{{ route('tasks.updateStatus', $task->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <select name="status">
                        <option value="open" {{ $task->status == 'open' ? 'selected' : '' }}>Open</option>
                        <option value="in progress" {{ $task->status == 'in progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    <button type="submit">Update Status</button>
                </form>

                <!-- Assign Task -->
                <form action="{{ route('tasks.assignTask', $task->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <select name="assignee_id">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ $task->assignee_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit">Assign Task</button>
                </form>

                <!-- Task Comments -->
                <div class="comments">
                    <h3>Comments</h3>
                    @foreach ($task->comments as $comment)
                        <p><strong>{{ $comment->user->name }}:</strong> {{ $comment->content }}</p>
                    @endforeach
                    <form action="{{ route('tasks.storeComment', $task->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <textarea name="content" required></textarea>
                        <button type="submit">Submit Comment</button>
                    </form>
                </div>
            </div>
        @endforeach
    @else
        <p class="no-tasks">You haven't created any tasks yet.</p>
    @endif

    <!-- Tasks Assigned to You Section -->
    <h2>Tasks Assigned to You</h2>
    @if(isset($tasksAssigned) && $tasksAssigned->isNotEmpty())
        @foreach($tasksAssigned as $task)
            <div class="task-container">
                <p class="task-title">{{ $task->title }} - <span class="task-status">Status: {{ $task->status }}</span></p>

                <!-- Update Task Status -->
                <form action="{{ route('tasks.updateStatus', $task->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <select name="status">
                        <option value="open" {{ $task->status == 'open' ? 'selected' : '' }}>Open</option>
                        <option value="in progress" {{ $task->status == 'in progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    <button type="submit">Update Status</button>
                </form>

                <!-- Assign Task -->
                <form action="{{ route('tasks.assignTask', $task->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <select name="assignee_id">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ $task->assignee_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit">Assign Task</button>
                </form>

                <!-- Task Comments -->
                <div class="comments">
                    <h3>Comments</h3>
                    @foreach ($task->comments as $comment)
                        <p><strong>{{ $comment->user->name }}:</strong> {{ $comment->content }}</p>
                    @endforeach
                    <form action="{{ route('tasks.storeComment', $task->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <textarea name="content" required></textarea>
                        <button type="submit">Submit Comment</button>
                    </form>
                </div>
            </div>
        @endforeach
    @else
        <p class="no-tasks">No tasks assigned to you.</p>
    @endif

    <!-- Filter Tasks -->
    <h2>Filter Tasks</h2>
    <form action="{{ route('tasks.index') }}" method="GET">
        <!-- Status Filter -->
        <select name="status">
            <option value="">All Statuses</option>
            <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
            <option value="in progress" {{ request('status') == 'in progress' ? 'selected' : '' }}>In Progress</option>
            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
        </select>

        <!-- Assignee Filter -->
        <select name="assignee_id">
            <option value="">All Users</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ request('assignee_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
            @endforeach
        </select>

        <button type="submit">Filter</button>
    </form>

    <!-- Display Filtered Tasks -->
    @if(isset($tasks) && $tasks->isNotEmpty())
        @foreach ($tasks as $task)
            <div class="task-container">

                <p class="task-title">{{ $task->title }} - Status: {{ $task->status }} - Assigned to: {{ $task->assignee_id ? $task->assignee->name : 'Unassigned' }}</p>
            </div>
        @endforeach
    @else
        <p class="no-tasks">No tasks match the current filter criteria.</p>
    @endif

    <!-- Create New Task -->
    <h2>Create New Task</h2>
    <a href="{{ route('tasks.create') }}">Create Task</a>

</body>
</html>
