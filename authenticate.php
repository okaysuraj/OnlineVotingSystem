<?php
$role = $_POST['role'];
$username = $_POST['username'];
$password = $_POST['password'];

// Database connection
$conn = new mysqli('localhost', 'root', '', 'voting_system');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($role === 'voter') {
    $sql = "SELECT * FROM voters WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $username, $password);
} else {
    $sql = "SELECT * FROM admins WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $username, $password);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    session_start();
    $_SESSION['username'] = $username;
    $_SESSION['role'] = $role;

    if ($role === 'voter') {
        header("Location: voter_dashboard.php");
    } else {
        header("Location: admin_dashboard.php");
    }
} else {
    echo "Invalid login credentials.";
}

$stmt->close();
$conn->close();
?>
