<?php
include 'db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit;
}

// Fetch student details
$stmt = $conn->prepare("SELECT student.*, classes.name AS class_name FROM student LEFT JOIN classes ON student.class_id = classes.class_id WHERE student.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Student Details</h1>
        <div class="card">
            <img src="uploads/<?= htmlspecialchars($student['image']) ?>" class="card-img-top" alt="Student Image">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($student['name']) ?></h5>
                <p class="card-text"><?= htmlspecialchars($student['email']) ?></p>
                <p class="card-text"><?= htmlspecialchars($student['address']) ?></p>
                <p class="card-text">Class: <?= htmlspecialchars($student['class_name'] ?? 'N/A') ?></p>
                <a href="index.php" class="btn btn-primary">Back to List</a>
            </div>
        </div>
    </div>
</body>
</html>