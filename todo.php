<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Read Students
$stmt = $conn->prepare("SELECT id, name, roll, father_name, department FROM students");
$stmt->execute();
$stmt->bind_result($id, $name, $roll, $fatherName, $department);
$students = [];
while ($stmt->fetch()) {
    $students[] = [
        "id" => $id,
        "name" => $name,
        "roll" => $roll,
        "fatherName" => $fatherName,
        "department" => $department
    ];
}
$stmt->close();

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Records</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<style>
    @import url("https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap");
html,
body {
  height: 100vh;
  display: grid;
  place-items: center;
  background-color: #F9FAFB;
}

section {
  max-width: 80rem;
  background: linear-gradient(to right, #4C1D95 30%, #8B5CF6);
  color: white;
  line-height: 1.5;
  font-family: "Nunito", sans-serif;
}

@media (min-width: 600px) {
  section {
    display: grid;
    grid-template-columns: 1fr 1fr;
  }

  .about-us {
    padding: 3vw 0 3vh 3vw;
  }

  .image-wrapper {
    filter: hue-rotate(20deg);
    clip-path: polygon(0% 100%, 50% 0%, 100% 0%, 100% 100%);
  }
}
.about-us {
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding: 2rem;
}
.about-us h2 {
  font-weight: 600;
  white-space: nowrap;
  font-size: clamp(2rem, 5vw, 4rem);
  margin-bottom: 0.5rem;
}
.about-us p {
  font-size: clamp(1rem, 1.5vw, 3rem);
}

.image-wrapper {
  height: 100%;
  width: 100%;
  clip-path: polygon(0%, 0%, 0% 0%);
}
.image-wrapper img {
  display: block;
  height: 100%;
  width: 100%;
  object-fit: cover;
  object-position: right center;
}
</style>
<body>
    <section>
  <div class="about-us">
    <h2>We are hiring.</h2>
    <p>Are you looking for a new challenge? You are passionate about innovation and enjoy working with people? Then you've come to the right place.</p>
  </div>
  <div class="image-wrapper">
    <img src="https://images.unsplash.com/photo-1531482615713-2afd69097998?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=2940&q=80" />
  </div>
</section>
    <div class="container">

        <h2>Student Records</h2>
         <div>
             <a href="insert.php" class="btn btn-success">Add Student</a>
         </div>
          <br>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Roll</th>
                    <th>Father's Name</th>
                    <th>Department</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?php echo $student["id"]; ?></td>
                        <td><?php echo $student["name"]; ?></td>
                        <td><?php echo $student["roll"]; ?></td>
                        <td><?php echo $student["fatherName"]; ?></td>
                        <td><?php echo $student["department"]; ?></td>
                        <td>
                            <a href="update.php?id=<?php echo $student["id"]; ?>" class="btn btn-primary">Edit</a>
                            <a href="delete.php?id=<?php echo $student["id"]; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="insert.php" class="btn btn-success">Add Student</a>
    </div>
    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>