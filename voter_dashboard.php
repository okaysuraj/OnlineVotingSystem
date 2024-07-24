<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'voter') {
    header("Location: login.php?role=voter");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Voter Dashboard</title>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
    <p>This is the voter dashboard.</p>
    <a href="logout.php">Logout</a>
</body>
</html>
