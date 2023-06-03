<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"]) && isset($_POST["name"]) && isset($_POST["location"]) && isset($_POST["noBooks"]) && isset($_POST["phone"])) {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $location = $_POST["location"];
    $noBooks = $_POST["noBooks"];
    $phone = $_POST["phone"];

    $stmt = $conn->prepare("UPDATE library SET name = ?, location = ?, noBooks = ?, phone = ? WHERE id = ?");
    $stmt->bind_param("ssisi", $name, $location, $noBooks, $phone, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: todo.php");
    exit();
} elseif (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT id, name, location, noBooks, phone FROM library WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($id, $name, $location, $noBooks, $phone);
    $stmt->fetch();
    $stmt->close();
} else {
    header("Location: todo.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Library</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-4 mb-4">Update Library</h2>

        <!-- Update Library Form -->
        <form method="POST" action="update.php">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" name="name" value="<?php echo $name; ?>" required>
            </div>
            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" class="form-control" name="location" value="<?php echo $location; ?>" required>
            </div>
            <div class="form-group">
                <label for="noBooks">No. of Books:</label>
                <input type="number" class="form-control" name="noBooks" value="<?php echo $noBooks; ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" class="form-control" name="phone" value="<?php echo $phone; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
