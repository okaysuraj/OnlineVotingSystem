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
$election_name = $_POST['election_name'];
$election_date = $_POST['election_date'];

// Prepare SQL query
$sql = "INSERT INTO elections (name, election_date) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $election_name, $election_date);

if ($stmt->execute()) {
    // Successful insertion, redirect to admin dashboard
    header("Location: admin_dashboard.php?message=Election added successfully.");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
