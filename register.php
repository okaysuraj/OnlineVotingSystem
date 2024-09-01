<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Voting System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #333333;
        }
        header {
            background: #4caf50;
            color: #ffffff;
            width: 100%;
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }
        .container {
            text-align: center;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 350px;
            width: 100%;
            margin-top: 100px; /* Adjust to avoid overlap with header */
            animation: fadeIn 1s ease-out;
        }
        h1 {
            margin-bottom: 20px;
            font-size: 1.8em;
            color: #333333;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        label {
            margin-bottom: 10px;
            font-size: 16px;
            color: #666666;
            text-align: left;
            width: 100%;
        }
        input[type="text"], input[type="password"], input[type="email"] {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 16px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            box-sizing: border-box;
        }
        .btn {
            display: inline-block;
            padding: 15px 25px;
            border-radius: 5px;
            text-decoration: none;
            color: #ffffff;
            font-size: 18px;
            transition: background 0.3s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        .btn-register {
            background: #ffc107;
        }
        .btn:hover {
            opacity: 0.9;
        }
        footer {
            background: #4caf50;
            color: #ffffff;
            width: 100%;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            left: 0;
            box-shadow: 0 -4px 8px rgba(0,0,0,0.1);
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Online Voting System</h1>
    </header>
    <div class="container">
        <h1>Register as New Voter</h1>
        <form method="POST" action="register_user.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>
            <button type="submit" class="btn btn-register">Register</button>
        </form>
    </div>
    <footer>
        <p>&copy; 2024 Online Voting System. All rights reserved.</p>
    </footer>
</body>
</html>
