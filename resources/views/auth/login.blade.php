<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <title>Login</title>
    <style>        body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #11264a; /* Dark background */
        color: #ffffff; /* Light text for contrast */
    }

    form {
        background-color: #1b365d; /* Slightly lighter dark background for form */
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.5);
        max-width: 400px;
        width: 100%;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #e6007e; /* Accent color for labels */
    }

    input {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #e6007e; /* Accent border */
        border-radius: 4px;
        background-color: #2c4f7a; /* Darker input background */
        color: #ffffff; /* Light text */
    }

    input::placeholder {
        color: #cfcfcf; /* Light gray for placeholders */
    }

    button {
        width: 100%;
        padding: 10px;
        background-color: #e6007e; /* Accent color */
        border: none;
        border-radius: 4px;
        color: #ffffff;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #c0006c; /* Slightly darker magenta */
    }

    p {
        text-align: center;
        margin-top: 20px;
        color: #f9a8d1; /* Light magenta for error message */
    }

    @media (max-width: 500px) {
        form {
            padding: 20px;
        }
    }</style>
</head>
<body>
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>

    @if(session('error'))
        <p>{{ session('error') }}</p>
    @endif
</body>
</html>
