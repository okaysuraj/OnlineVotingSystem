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
$delete_election_id = $_POST['delete_election_id'];

// Prepare SQL query
$sql = "DELETE FROM elections WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $delete_election_id);

if ($stmt->execute()) {
    // Successful deletion, redirect to admin dashboard
    header("Location: admin_dashboard.php?message=Election deleted successfully.");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
