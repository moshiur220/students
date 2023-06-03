<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["name"]) && isset($_POST["location"]) && isset($_POST["noBooks"]) && isset($_POST["phone"])) {
    $name = $_POST["name"];
    $location = $_POST["location"];
    $noBooks = $_POST["noBooks"];
    $phone = $_POST["phone"];

    $stmt = $conn->prepare("INSERT INTO library (name, location, noBooks, phone) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $name, $location, $noBooks, $phone);
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
    <title>Create Library</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-4 mb-4">Create Library</h2>

        <!-- Create Library Form -->
        <form method="POST" action="create.php">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" class="form-control" name="location" required>
            </div>
            <div class="form-group">
                <label for="noBooks">No. of Books:</label>
                <input type="number" class="form-control" name="noBooks" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" class="form-control" name="phone" required>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
