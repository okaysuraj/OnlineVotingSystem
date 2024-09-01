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

// Get election ID from URL
$election_id = $_GET['id'];

// Fetch election details
$election_result = $conn->query("SELECT * FROM elections WHERE id = $election_id");
$election = $election_result->fetch_assoc();

// Fetch candidates for the election
$candidate_result = $conn->query("SELECT * FROM candidates WHERE election_id = $election_id");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Process vote
    $candidate_id = $_POST['candidate_id'];
    $conn->query("UPDATE candidates SET votes = votes + 1 WHERE id = $candidate_id");
    header("Location: voter_dashboard.php?message=Vote casted successfully.");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Election Details - Voting System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f4f4f9;
        }
        header {
            background: #4caf50;
            color: #ffffff;
            padding: 15px;
            text-align: center;
        }
        .main-content {
            padding: 20px;
            margin: 20px;
        }
        h1 {
            margin-top: 0;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background: #4caf50;
            color: #ffffff;
        }
        tr:nth-child(even) {
            background: #f2f2f2;
        }
        form {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-size: 16px;
        }
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }
        button {
            background: #4caf50;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background: #45a049;
        }
    </style>
</head>
<body>
    <header>
        <h1>Election Details</h1>
    </header>
    <div class="main-content">
        <h2><?php echo htmlspecialchars($election['name']); ?></h2>
        <p><strong>Date:</strong> <?php echo htmlspecialchars($election['election_date']); ?></p>

        <h3>Candidates</h3>
        <form action="" method="POST">
            <label for="candidate_id">Vote for a Candidate:</label>
            <select name="candidate_id" id="candidate_id" required>
                <?php while ($candidate = $candidate_result->fetch_assoc()) { ?>
                    <option value="<?php echo $candidate['id']; ?>"><?php echo htmlspecialchars($candidate['name']); ?></option>
                <?php } ?>
            </select>
            <button type="submit">Vote</button>
        </form>
        
        <h3>Results</h3>
        <table>
            <tr>
                <th>Candidate Name</th>
                <th>Votes</th>
            </tr>
            <?php
            $candidate_result = $conn->query("SELECT * FROM candidates WHERE election_id = $election_id");
            while ($candidate = $candidate_result->fetch_assoc()) {
                echo "<tr><td>" . htmlspecialchars($candidate['name']) . "</td><td>" . $candidate['votes'] . "</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
