<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Delete Todo
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["delete_id"])) {
    $deleteId = $_GET["delete_id"];
    $userId = $_SESSION["user_id"];

    $stmt = $conn->prepare("DELETE FROM todos WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $deleteId, $userId);
    $stmt->execute();
    $stmt->close();

    header("Location: todo.php");
    exit();
}

// Update Todo
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update_id"]) && isset($_POST["todo_name"])) {
    $updateId = $_POST["update_id"];
    $todoName = $_POST["todo_name"];
    $userId = $_SESSION["user_id"];

    $stmt = $conn->prepare("UPDATE todos SET todo_name = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("sii", $todoName, $updateId, $userId);
    $stmt->execute();
    $stmt->close();

    header("Location: todo.php");
    exit();
}

// Add Todo
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["todo_name"])) {
    $todoName = $_POST["todo_name"];
    $userId = $_SESSION["user_id"];

    $stmt = $conn->prepare("INSERT INTO todos (user_id, todo_name) VALUES (?, ?)");
    $stmt->bind_param("is", $userId, $todoName);
    $stmt->execute();
    $stmt->close();

    header("Location: todo.php");
    exit();
}

$userId = $_SESSION["user_id"];
$stmt = $conn->prepare("SELECT id, todo_name FROM todos WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($todoId, $todoName);
$todos = [];
while ($stmt->fetch()) {
    $todos[] = ["id" => $todoId, "name" => $todoName];
}
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Todo List</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .container .form-group label {
            font-weight: bold;
        }
        .container .form-group input[type="text"] {
            border-radius: 5px;
        }
        .container .form-group button[type="submit"] {
            width: 100%;
            margin-top: 20px;
        }
        .table {
            margin-top: 30px;
        }
        .table th {
            font-weight: bold;
        }
        .table td {
            vertical-align: middle;
        }
        .table .form-control {
            border-radius: 5px;
        }
        .table .btn {
            margin-right: 5px;
        }
        .logout-btn {
            margin-top: 30px;
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo $_SESSION["user_name"]; ?>!</h2>
        <form method="POST" action="todo.php">
            <div class="form-group">
                <label for="todo_name">Todo Name:</label>
                <input type="text" class="form-control" name="todo_name" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Todo</button>
        </form>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Todo Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($todos as $todo): ?>
                    <tr>
                        <td><?php echo $todo["id"]; ?></td>
                        <td><?php echo $todo["name"]; ?></td>
                        <td>
                            <form method="POST" action="todo.php" class="d-flex">
                                <input type="hidden" name="update_id" value="<?php echo $todo["id"]; ?>">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="todo_name" value="<?php echo $todo["name"]; ?>" required>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </form>
                            <a href="todo.php?delete_id=<?php echo $todo["id"]; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="logout-btn">
            <a href="logout.php" class="btn btn-secondary">Logout</a>
        </div>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
