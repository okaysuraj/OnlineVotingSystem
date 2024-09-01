<?php
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

// Get form data
$election_id = $_POST['election_id'];
$candidate_name = $_POST['candidate_name'];

// Prepare SQL query
$sql = "INSERT INTO candidates (election_id, name) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $election_id, $candidate_name);

if ($stmt->execute()) {
    // Successful insertion, redirect to admin dashboard
    header("Location: admin_dashboard.php?message=Candidate added successfully.");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
