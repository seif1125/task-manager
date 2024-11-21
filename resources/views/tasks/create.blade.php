<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>  body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #11264a;
        color: #ffffff;
    }
    .container {
        max-width: 1200px;
        margin: 20px auto;
        padding: 20px;
        background: #1b365d;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
    }
    h2 {
        color: #e6007e;
        margin-bottom: 20px;
    }
    label {
        font-size: 14px;
        margin-bottom: 5px;
        display: block;
        color: #e6007e;
    }
    input[type="text"], textarea, select {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }
    button {
        background-color: #e6007e;
        color: #ffffff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }
    button:hover {
        background-color: #c0006c;
    }
    .header {
        background: #11264a;
        color: #e6007e;
        padding: 15px 20px;
        text-align: center;
    }
    .header h1 {
        margin: 0;
    }
    .logout-form {
        margin-bottom: 20px;
    }
    .footer {
        background: #11264a;
        color: #e6007e;
        padding: 15px;
        text-align: center;
    }
    .footer p {
        margin: 0;
    }</style>
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
