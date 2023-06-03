<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Read Libraries
$stmt = $conn->prepare("SELECT id, name, location, noBooks, phone FROM library");
$stmt->execute();
$stmt->bind_result($id, $name, $location, $noBooks, $phone);
$libraries = [];
while ($stmt->fetch()) {
    $libraries[] = [
        "id" => $id,
        "name" => $name,
        "location" => $location,
        "noBooks" => $noBooks,
        "phone" => $phone
    ];
}
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Library CRUD</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<style>
    @import url("https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&family=Roboto:wght@400;700;900&display=swap");
html,
body {
  height: 100%;
}

section {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  min-height: min(80vh, 600px);
  background-color: #312e81;
  margin: 2rem 0 2rem;
  padding: 1rem;
  border-radius: 20px;
  text-align: center;
  overflow: hidden;
  font-family: "Roboto", sans-serif;
}
section:before {
  position: absolute;
  mix-blend-mode: overlay;
  filter: brightness(70%);
  content: "";
  inset: 0;
  width: 100%;
  height: 100%;
  background: url("https://images.unsplash.com/photo-1582005450386-52b25f82d9bb?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=2940&q=80");
  background-size: cover;
  background-position: center;
}

h1,
h2 {
  margin-top: 2rem;
  color: white;
}

h1 {
  position: relative;
  font-weight: 900;
  font-size: clamp(2.5rem, 5vw, 4rem);
}
h1 div {
  color: #ddd6fe;
}

h2 {
  font-size: clamp(1.3rem, 2vw, 3rem);
}

p {
  margin-top: 1rem;
  font-size: clamp(1.3rem, 3vw, 4rem);
  color: white;
}

.cta {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  margin-top: 3rem;
  gap: 1.5rem;
}
.cta button {
  border: none;
  padding: 1rem 3rem;
  font-size: clamp(1.1rem, 1.3vw, 3rem);
  border-radius: 8px;
  cursor: pointer;
}
.cta button:first-of-type {
  background-color: white;
  color: #4c1d95;
  transition: all 300ms ease-in;
}
.cta button:first-of-type:hover {
  background-color: #4c1d95;
  color: white;
}
.cta button:nth-of-type(2) {
  background-color: #2563eb;
  color: white;
}
.cta button:nth-of-type(2):hover {
  background-color: white;
  color: #2563eb;
}

@media (min-width: 600px) {
  .cta {
    flex-direction: row;
  }
}
</style>
<body>
    <section>
  <h1>Take control of your
    <div>customer support</div>
  </h1>
  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
  <div class="cta">
    <button>Get started</button>
    <button>Live demo</button>
  </div>
</section>
    <div class="container">
        <h2 class="mt-4 mb-4">Library CRUD</h2>

        <!-- Create Library Form -->
        <a href="create.php" class="btn btn-primary mb-4">Create Library</a>

        <!-- Display Libraries -->
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Location</th>
                    <th>No. of Books</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($libraries as $library): ?>
                    <tr>
                        <td><?php echo $library["id"]; ?></td>
                        <td><?php echo $library["name"]; ?></td>
                        <td><?php echo $library["location"]; ?></td>
                        <td><?php echo $library["noBooks"]; ?></td>
                        <td><?php echo $library["phone"]; ?></td>
                        <td>
                            <a href="update.php?id=<?php echo $library["id"]; ?>" class="btn btn-primary">Edit</a>
                            <a href="delete.php?id=<?php echo $library["id"]; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this library?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
