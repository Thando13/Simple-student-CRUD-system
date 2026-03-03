<?php
session_start();
include("config.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Count total students
$result = mysqli_query($conn, "SELECT COUNT(*) as total FROM students");
$data = mysqli_fetch_assoc($result);
$total_students = $data['total'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="dashboard">

    <div class="sidebar">
        <h3>Student System</h3>
        
        <a href="students.php">Manage Students</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="main-content">
        <div class="header">
            <h2>Welcome, <?php echo $_SESSION['username']; ?> 👋</h2>
        </div>

        <div class="card-container">
            <div class="card">
                <h3>Total Students</h3>
                <h1><?php echo $total_students; ?></h1>
            </div>

            <div class="card">
                <h3>System Status</h3>
                <p>Running Successfully ✅</p>
            </div>
        </div>
    </div>

</div>

</body>
</html>