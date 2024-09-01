<?php
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];

// Database connection
$conn = new mysqli('localhost', 'root', '', 'voting');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO voters (username, password, email) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sss', $username, $password, $email);

if ($stmt->execute()) {
    header("Location: index.php");
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
