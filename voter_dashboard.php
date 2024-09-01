<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Database configuration
$servername = "localhost";
$username = "root";
$password = ""; // Your MySQL password
$dbname = "voting";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voter Dashboard - Voting System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            overflow: hidden;
            background: #f4f4f9;
        }
        .sidebar {
            background: #333;
            color: #fff;
            width: 250px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100vh;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            padding: 10px;
            margin-bottom: 10px;
            display: block;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .sidebar a:hover {
            background: #575757;
        }
        .main-content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }
        .main-content h1 {
            margin: 0 0 20px;
            color: #333;
        }
        .card {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .card h2 {
            margin: 0 0 10px;
            color: #333;
        }
        .card p {
            color: #666;
        }
        .card form, .card table {
            margin-top: 20px;
        }
        .card table {
            width: 100%;
            border-collapse: collapse;
        }
        .card table th, .card table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .card table th {
            background: #4caf50;
            color: #fff;
        }
        .card table tr:nth-child(even) {
            background: #f2f2f2;
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-size: 16px;
        }
        input[type="text"], input[type="date"], input[type="number"], select, input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background: #4caf50;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background 0.3s;
        }
        input[type="submit"]:hover {
            background: #45a049;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div>
            <h2>Voter Dashboard</h2>
            <a href="#ongoing-elections">Ongoing Elections</a>
            <a href="#all-elections">All Elections</a>
        </div>
        <div>
            <a href="logout.php">Logout</a>
        </div>
    </div>
    <div class="main-content">
        <div id="ongoing-elections" class="card">
            <h1>Ongoing Elections</h1>
            <?php
            $current_date = date('Y-m-d');
            $result = $conn->query("SELECT * FROM elections WHERE election_date >= '$current_date'");
            while ($row = $result->fetch_assoc()) {
                echo "<div class='box' onclick=\"window.location.href='election_details.php?id=" . $row['id'] . "'\">" . htmlspecialchars($row['name']) . "</div>";
            }
            ?>
        </div>
        <div id="all-elections" class="card">
            <h1>All Elections</h1>
            <?php
            $result = $conn->query("SELECT * FROM elections");
            while ($row = $result->fetch_assoc()) {
                echo "<div class='box' onclick=\"window.location.href='election_details.php?id=" . $row['id'] . "'\">" . htmlspecialchars($row['name']) . "</div>";
            }
            ?>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
