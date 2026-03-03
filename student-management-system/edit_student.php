<?php
session_start();
include("config.php");

// Protect page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// CREATE STUDENT
if (isset($_POST['add_student'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $course = $_POST['course'];

    $sql = "INSERT INTO students (name, email, course)
            VALUES ('$name', '$email', '$course')";
    mysqli_query($conn, $sql);
}

// DELETE STUDENT
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM students WHERE id=$id");
}


// UPDATE STUDENT
if (isset($_POST['update_student'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $course = $_POST['course'];

    mysqli_query($conn, "UPDATE students 
                         SET name='$name', email='$email', course='$course' 
                         WHERE id=$id");
}
?>

<?php

include("config.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get student ID
if (!isset($_GET['id'])) {
    header("Location: students.php");
    exit();
}

$id = $_GET['id'];

// Fetch student data
$result = mysqli_query($conn, "SELECT * FROM students WHERE id=$id");
$student = mysqli_fetch_assoc($result);

// Update student
if (isset($_POST['update_student'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $course = $_POST['course'];

    mysqli_query($conn, "UPDATE students 
                         SET name='$name', email='$email', course='$course' 
                         WHERE id=$id");

    header("Location: students.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Edit Student</h2>

    <form method="POST">
        <input type="text" name="name"
               value="<?php echo $student['name']; ?>" required>

        <input type="email" name="email"
               value="<?php echo $student['email']; ?>" required>

        <input type="text" name="course"
               value="<?php echo $student['course']; ?>" required>

        <button type="submit" name="update_student">Update Student</button>
    </form>

    <br>
    <a href="students.php">Cancel</a>
</div>

</body>
</html>