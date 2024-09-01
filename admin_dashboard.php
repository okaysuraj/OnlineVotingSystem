<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login_admin.php");
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
    <title>Admin Dashboard - Voting System</title>
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
        .box {
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .box:hover {
            background: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div>
            <h2>Admin Dashboard</h2>
            <a href="#dashboard">Dashboard</a>
            <a href="#add-election">Add Election</a>
            <a href="#add-candidates">Add Candidates</a>
            <a href="#show-results">Show Results</a>
            <a href="#delete-election">Delete Election</a>
        </div>
        <div>
            <a href="logout.php">Logout</a>
        </div>
    </div>
    <div class="main-content">
        <div id="dashboard" class="card">
            <h1>Dashboard</h1>
            <h2>Current Elections</h2>
            <div class="elections">
                <?php
                $result = $conn->query("SELECT * FROM elections");
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='box' onclick=\"window.location.href='election_details.php?id=" . $row['id'] . "'\">" . htmlspecialchars($row['name']) . "</div>";
                }
                ?>
            </div>
        </div>
        <div id="add-election" class="card">
            <h2>Add New Election</h2>
            <form action="add_election.php" method="POST">
                <label for="name">Election Name:</label>
                <input type="text" id="name" name="election_name" required>
                <label for="date">Election Date:</label>
                <input type="date" id="date" name="election_date" required>
              
                <input type="submit" value="Add Election">
            </form>
        </div>
        <div id="add-candidates" class="card">
            <h2>Add Candidates</h2>
            <form action="add_candidate.php" method="POST">
                <label for="election_id">Election:</label>
                <select id="election_id" name="election_id" required>
                    <?php
                    $result = $conn->query("SELECT * FROM elections");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['name']) . "</option>";
                    }
                    ?>
                </select>
                <label for="candidate_name">Candidate Name:</label>
                <input type="text" id="candidate_name" name="candidate_name" required>
                <input type="submit" value="Add Candidate">
            </form>
        </div>
        <div id="show-results" class="card">
            <h2>Election Results</h2>
            <?php
            $result = $conn->query("SELECT elections.name as election_name, candidates.name as candidate_name, candidates.votes FROM candidates JOIN elections ON candidates.election_id = elections.id ORDER BY elections.id, candidates.votes DESC");
            echo "<table>";
            echo "<tr><th>Election</th><th>Candidate</th><th>Votes</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . htmlspecialchars($row['election_name']) . "</td><td>" . htmlspecialchars($row['candidate_name']) . "</td><td>" . htmlspecialchars($row['votes']) . "</td></tr>";
            }
            echo "</table>";
            ?>
        </div>
        <div id="delete-election" class="card">
            <h2>Delete Election</h2>
            <form action="delete_election.php" method="POST">
                <label for="election_id_delete">Select Election:</label>
                <select id="election_id_delete" name="election_id_delete" required>
                    <?php
                    $result = $conn->query("SELECT * FROM elections");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['name']) . "</option>";
                    }
                    ?>
                </select>
                <input type="submit" value="Delete Election">
            </form>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
