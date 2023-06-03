<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Insert Book
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["booksName"]) && isset($_POST["authorName"]) && isset($_POST["price"])) {
    $booksName = $_POST["booksName"];
    $authorName = $_POST["authorName"];
    $price = $_POST["price"];

    $stmt = $conn->prepare("INSERT INTO books (booksName, authorName, price) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $booksName, $authorName, $price);
    $stmt->execute();
    $stmt->close();

    header("Location: todo.php");
    exit();
}

// Update Book
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update_id"]) && isset($_POST["booksName"]) && isset($_POST["authorName"]) && isset($_POST["price"])) {
    $updateId = $_POST["update_id"];
    $booksName = $_POST["booksName"];
    $authorName = $_POST["authorName"];
    $price = $_POST["price"];

    $stmt = $conn->prepare("UPDATE books SET booksName = ?, authorName = ?, price = ? WHERE id = ?");
    $stmt->bind_param("ssdi", $booksName, $authorName, $price, $updateId);
    $stmt->execute();
    $stmt->close();

    header("Location: todo.php");
    exit();
}

// Delete Book
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["delete_id"])) {
    $deleteId = $_GET["delete_id"];

    $stmt = $conn->prepare("DELETE FROM books WHERE id = ?");
    $stmt->bind_param("i", $deleteId);
    $stmt->execute();
    $stmt->close();

    header("Location: todo.php");
    exit();
}

$stmt = $conn->prepare("SELECT id, booksName, authorName, price FROM books");
$stmt->execute();
$stmt->bind_result($id, $booksName, $authorName, $price);
$books = [];
while ($stmt->fetch()) {
    $books[] = ["id" => $id, "booksName" => $booksName, "authorName" => $authorName, "price" => $price];
}
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Books List</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
        <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">My Website</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#books">Books</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero bg-primary text-white text-center py-5">
        <div class="container">
            <h1 class="display-4">Welcome to My Website</h1>
            <p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam aliquet eros id mi consequat consectetur.</p>
            <a href="#books" class="btn btn-light btn-lg">Explore Books</a>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="display-4">About Us</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam aliquet eros id mi consequat consectetur. Vestibulum consectetur lacus non ipsum fringilla, ac feugiat sapien tristique.</p>
                </div>
                <div class="col-lg-6">
                    <!-- Online Resource -->
                    <div class="card">
                        <img src="path/to/online-resource.jpg" class="card-img-top" alt="Online Resource">
                        <div class="card-body">
                            <h5 class="card-title">Online Resource</h5>
                            <p class="card-text">Check out our online resource for additional information and resources.</p>
                            <a href="#" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="container">
        <h2>Books List</h2>
        <form method="POST" action="todo.php">
            <div class="form-group">
                <label for="booksName">Book Name:</label>
                <input type="text" class="form-control" name="booksName" required>
            </div>
            <div class="form-group">
                <label for="authorName">Author Name:</label>
                <input type="text" class="form-control" name="authorName" required>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" step="0.01" class="form-control" name="price" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Book</button>
        </form>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Book Name</th>
                    <th>Author Name</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $book): ?>
                    <tr>
                        <td><?php echo $book["id"]; ?></td>
                        <td><?php echo $book["booksName"]; ?></td>
                        <td><?php echo $book["authorName"]; ?></td>
                        <td><?php echo $book["price"]; ?></td>
                        <td>
                            <form method="POST" action="todo.php" class="d-flex">
                                <input type="hidden" name="update_id" value="<?php echo $book["id"]; ?>">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="booksName" value="<?php echo $book["booksName"]; ?>" required>
                                    <input type="text" class="form-control" name="authorName" value="<?php echo $book["authorName"]; ?>" required>
                                    <input type="number" step="0.01" class="form-control" name="price" value="<?php echo $book["price"]; ?>" required>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </form>
                            <a href="todo.php?delete_id=<?php echo $book["id"]; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
      <!-- Books Section -->
    <section id="books" class="py-5 bg-light">
        <div class="container">
            <h2 class="display-4 text-center">Books</h2>
            <div class="row">
                <?php foreach ($books as $book): ?>
                    <div class="col-lg-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $book["booksName"]; ?></h5>
                                <p class="card-text"><?php echo $book["authorName"]; ?></p>
                                <p class="card-text"><?php echo $book["price"]; ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5">
        <div class="container">
            <h2 class="display-4 text-center">Contact Us</h2>
            <div class="row">
                <div class="col-lg-6">
                    <form>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter your name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter your email">
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea class="form-control" id="message" rows="4" placeholder="Enter your message"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="col-lg-6">
                    <h5>Contact Information</h5>
                    <p>123 Street, City</p>
                    <p>Email: info@example.com</p>
                    <p>Phone: 123-456-7890</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>