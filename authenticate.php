<?php
session_start(); // Ensure session is started

// Get POST data

$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Database connection
$conn = new mysqli('localhost', 'root', '', 'voting');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

    $sql = "SELECT * FROM voters WHERE username = ? AND password = ?";


// Prepare and execute statement
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Set session variables
    $_SESSION['username'] = $username;
        header("Location: voter_dashboard.php");
    exit(); // Make sure to exit after redirection
} else {
    echo "Invalid login credentials.";
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
