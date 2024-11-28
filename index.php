<?php
include 'db.php';

// Query to get all students with their class name
$query = "
    SELECT student.*, classes.name AS class_name 
    FROM student 
    LEFT JOIN classes ON student.class_id = classes.class_id
";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Student List</h1>
        <a href="create.php" class="btn btn-primary mb-3">Add Student</a>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Class</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['class_name'] ?? 'N/A') ?></td>
                    <td>
                        <img src="uploads/<?= htmlspecialchars($row['image']) ?>" alt="Student Image" style="width:50px; height:50px; object-fit:cover;">
                    </td>
                    <td>
                        <a href="view.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm">View</a>
                        <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
