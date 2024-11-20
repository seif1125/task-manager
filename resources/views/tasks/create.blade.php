<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            color: #333;
        }
        form {
            margin: 10px 0;
        }
        select, textarea, button {
            padding: 10px;
            margin: 5px 0;
            font-size: 14px;
        }
        button {
            background-color: #11264a;
            color: #e6007e;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: ##11264a;
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
            color: #e6007e;
        }
        .comments {
            margin-top: 10px;
            padding: 10px;
            background-color: #e9f7e9;
            border-radius: 8px;
        }
        .no-tasks {
            color: #888;
            font-style: italic;
        }
        .logout-form, .filter-form, .create-task {
            margin-top: 20px;
            padding: 15px;
            background-color: #f1f1f1;
            border-radius: 8px;
        }
        .logout-form button {
            margin-left: auto;
        }
        .header, .footer {
            background: #11264a;
            color: #e6007e;
            padding: 15px 20px;
            text-align: center;
        }
        .header h1, .footer p {
            margin: 0;
            color: #e6007e
        }
        a.create-task {
            display: inline-block;
            text-decoration: none;
            padding: 10px 20px;
            background-color: ##e6007e;
            color: #e6007e;
            border-radius: 5px;
            margin-top: 10px;
        }
        a.create-task:hover {
            background-color: #11264a;
        }
        @media (max-width: 768px) {
            .task-container {
                font-size: 14px;
            }
            select, textarea, button {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Welcome, {{ Auth::user()->name }}!</h1>
    </div>

    <div class="container">
        <!-- Logout Form -->
        <div class="logout-form">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>

        <!-- Tasks Created Section -->
        <h2>Your Created Tasks</h2>

        <div class="create-task-form">
            <h2>Create New Task</h2>
            <form action="{{ route('tasks.store') }}" method="POST">
                @csrf
                <div>
                    <label for="title">Task Title</label><br>
                    <input type="text" id="title" name="title" placeholder="Enter task title" required style="width: 100%; padding: 8px; margin: 5px 0; border-radius: 5px; border: 1px solid #ccc;">
                </div>

                <div>
                    <label for="description">Description</label><br>
                    <textarea id="description" name="description" rows="4" placeholder="Enter task description" required style="width: 100%; padding: 8px; margin: 5px 0; border-radius: 5px; border: 1px solid #ccc;"></textarea>
                </div>

                <div>
                    <label for="status">Status</label><br>
                    <select id="status" name="status" style="width: 100%; padding: 8px; margin: 5px 0; border-radius: 5px; border: 1px solid #ccc;">
                        <option value="open">Open</option>
                        <option value="in progress">In Progress</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>

                <div>
                    <label for="assignee_id">Assign To</label><br>
                    <select id="assignee_id" name="assignee_id" style="width: 100%; padding: 8px; margin: 5px 0; border-radius: 5px; border: 1px solid #ccc;">
                        <option value="">Unassigned</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" style="background-color: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 5px; margin-top: 10px;">Create Task</button>
            </form>
        </div>


        <!-- Filter Tasks -->



    </div>

    <div class="footer">
        <p>© 2024 Task Management System</p>
    </div>

</body>
</html>
