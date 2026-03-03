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

<!DOCTYPE html>
<html>
<head>
    <title>Student Management</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        .delete-btn {
            color: red;
        }
        .edit-btn {
            color: green;
        }
    </style>
</head>
<body>

<div class="container" style="width: 800px;">
    <h2>Student Management</h2>
    <form method="GET" style="margin-top:15px;">
    <input type="text" name="search" placeholder="Search by name, email or course"
           value="<?php echo $_GET['search'] ?? ''; ?>">
    <button type="submit">Search</button>
</form>
<br>

    <!-- Add Student Form -->
    <form method="POST">
        <input type="text" name="name" placeholder="Student Name" required>
        <input type="email" name="email" placeholder="Student Email" required>
        <input type="text" name="course" placeholder="Course" required>
        <button type="submit" name="add_student">Add Student</button>
    </form>

    <!-- Students Table -->
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Course</th>
            <th>Actions</th>
        </tr>

        <?php
        if (isset($_GET['search']) && $_GET['search'] != "") {
    $search = $_GET['search'];
    $query = "SELECT * FROM students 
              WHERE name LIKE '%$search%' 
              OR email LIKE '%$search%' 
              OR course LIKE '%$search%'";
} else {
    $query = "SELECT * FROM students";
}

$result = mysqli_query($conn, $query);

       while ($row = mysqli_fetch_assoc($result)) {
?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['course']; ?></td>
        <td>
            <a class="edit-btn" href="edit_student.php?id=<?php echo $row['id']; ?>">Edit</a> |
            <a class="delete-btn"
               href="students.php?delete=<?php echo $row['id']; ?>"
               onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
<?php
}
?>
        
    </table>

    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</div>

</body>
</html>