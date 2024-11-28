<?php
include 'db.php';

// Handle adding classes
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $stmt = $conn->prepare("INSERT INTO classes (name) VALUES (?)");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    header("Location: classes.php");
}

// Fetch all classes
$classes = $conn->query("SELECT * FROM classes");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Classes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Manage Classes</h1>
        <form method="POST" class="mb-4">
            <div class="mb-3">
                <label for="name" class="form-label">Class Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Add Class</button>
        </form>
        <h2>Existing Classes</h2>
        <ul class="list-group">
            <?php while ($class = $classes->fetch_assoc()): ?>
                <li class="list-group-item">
                    <?= htmlspecialchars($class['name']) ?>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
</body>
</html>
