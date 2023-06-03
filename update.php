<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"]) && isset($_POST["name"]) && isset($_POST["roll"]) && isset($_POST["fatherName"]) && isset($_POST["department"])) {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $roll = $_POST["roll"];
    $fatherName = $_POST["fatherName"];
    $department = $_POST["department"];

    $stmt = $conn->prepare("UPDATE students SET name=?, roll=?, father_name=?, department=? WHERE id=?");
    $stmt->bind_param("ssssi", $name, $roll, $fatherName, $department, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: todo.php");
    exit();
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $stmt = $conn->prepare("SELECT id, name, roll, father_name, department FROM students WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($id, $name, $roll, $fatherName, $department);
    $stmt->fetch();
    $stmt->close();
} else {
    header("Location: index.php");
    exit();
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Student</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-4 mb-4">Update Student</h2>
        <form method="POST" action="update.php">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" name="name" value="<?php echo $name; ?>" required>
            </div>
            <div class="form-group">
                <label for="roll">Roll:</label>
                <input type="text" class="form-control" name="roll" value="<?php echo $roll; ?>" required>
            </div>
            <div class="form-group">
                <label for="fatherName">Father's Name:</label>
                <input type="text" class="form-control" name="fatherName" value="<?php echo $fatherName; ?>" required>
            </div>
            <div class="form-group">
                <label for="department">Department:</label>
                <input type="text" class="form-control" name="department" value="<?php echo $department; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Student</button>
        </form>
    </div>
    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
