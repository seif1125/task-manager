<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
            body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #11264a;
            color: #ffffff;
        }

        h1, h2 {
            color: #e6007e;
        }

        h1 {
            border-bottom: 3px solid #e6007e;
            padding-bottom: 10px;
        }

        form {
            margin: 10px 0;
        }

        select, textarea, button {
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #e6007e;
            border-radius: 4px;
            font-size: 14px;
            background-color: #1b365d;
            color: #ffffff;
        }

        button {
            background-color: #e6007e;
            color: #ffffff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #c0006c;
        }

        .task-container {
            border: 1px solid #e6007e;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            background-color: #1b365d; /* Slightly lighter than the main background */
        }

        .task-title {
            font-size: 18px;
            font-weight: bold;
        }

        .task-status {
            color: #f9a8d1; /* Lighter shade of magenta */
        }

        .comments {
            margin-top: 10px;
            padding: 10px;
            background-color: #2c4f7a; /* Darker blue for comments background */
            border-radius: 8px;
            color: #ffffff;
        }

        .no-tasks {
            color: #cfcfcf;
        }

        /* Filters */
        form[action="{{ route('tasks.index') }}"] {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-bottom: 20px;
        }

        select {
            width: 200px;
        }

        /* Logout Button */
        form[action="{{ route('logout') }}"] button {
            margin-top: 20px;
            padding: 10px 20px;
        }

        a {
            color: #e6007e;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <!-- Welcome Header -->
    <h1>Welcome, {{ Auth::user()->name }}!</h1>

    <!-- Logout Button -->
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
    <div style="margin-bottom: 20px;">
        <a href="{{ route('tasks.create') }}" class="create-task-btn"><button type="submit">Create Task</button></a>
    </div>

    <!-- Filters at the Top -->
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

    <!-- Tasks Created Section -->
    <h2>Your Created Tasks</h2>
    @if($tasksCreated->isNotEmpty())
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
                        <textarea name="content" required></textarea>
                        <button type="submit">Submit Comment</button>
                    </form>
                </div>
            </div>
        @endforeach
    @else
        <p class="no-tasks">No tasks match the current filter criteria.</p>
    @endif

    <!-- Tasks Assigned to You Section -->
    <h2>Tasks Assigned to You</h2>
    @if($tasksAssigned->isNotEmpty())
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

                <!-- Task Comments -->
                <div class="comments">
                    <h3>Comments</h3>
                    @foreach ($task->comments as $comment)
                        <p><strong>{{ $comment->user->name }}:</strong> {{ $comment->content }}</p>
                    @endforeach
                    <form action="{{ route('tasks.storeComment', $task->id) }}" method="POST">
                        @csrf
                        <textarea name="content" required></textarea>
                        <button type="submit">Submit Comment</button>
                    </form>
                </div>
            </div>
        @endforeach
    @else
        <p class="no-tasks">No tasks match the current filter criteria.</p>
    @endif


</body>
</html>
