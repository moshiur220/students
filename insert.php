<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["name"]) && isset($_POST["roll"]) && isset($_POST["fatherName"]) && isset($_POST["department"])) {
    $name = $_POST["name"];
    $roll = $_POST["roll"];
    $fatherName = $_POST["fatherName"];
    $department = $_POST["department"];

    $stmt = $conn->prepare("INSERT INTO students (name, roll, father_name, department) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $roll, $fatherName, $department);
    $stmt->execute();
    $stmt->close();

    header("Location: todo.php");
    exit();
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Insert Student</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        
        <h2 class="mt-4 mb-4">Insert Student</h2>
        <form method="POST" action="insert.php">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="form-group">
                <label for="roll">Roll:</label>
                <input type="text" class="form-control" name="roll" required>
            </div>
            <div class="form-group">
                <label for="fatherName">Father's Name:</label>
                <input type="text" class="form-control" name="fatherName" required>
            </div>
            <div class="form-group">
                <label for="department">Department:</label>
                <input type="text" class="form-control" name="department" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Student</button>
        </form>
    </div>
    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
