
<?php
include 'db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit;
}

// Fetch current student data
$stmt = $conn->prepare("SELECT * FROM student WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

// Update student data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $class_id = $_POST['class_id'];
    $image = $_FILES['image'];
    
    $imageName = $student['image'];
    
    if ($image['error'] === UPLOAD_ERR_OK) {
        $imageName = uniqid() . "_" . basename($image['name']);
        move_uploaded_file($image['tmp_name'], "uploads/$imageName");
    }
    
    $stmt = $conn->prepare("UPDATE student SET name = ?, email = ?, address = ?, class_id = ?, image = ? WHERE id = ?");
    $stmt->bind_param("ssssis", $name, $email, $address, $class_id, $imageName, $id);
    $stmt->execute();
    header("Location: view.php?id=$id");
}

// Fetch classes for dropdown
$classes = $conn->query("SELECT * FROM classes");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Edit Student</h1>
        <form method="POST" enctype="multipart/form-data" class="mt-4">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($student['name']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($student['email']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea name="address" class="form-control" required><?= htmlspecialchars($student['address']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="class_id" class="form-label">Class</label>
                <select name="class_id" class="form-select" required>
                    <option value="">Select Class</option>
                    <?php while ($class = $classes->fetch_assoc()): ?>
                        <option value="<?= $class['class_id'] ?>" <?= $student['class_id'] == $class['class_id'] ? 'selected' : '' ?>><?= $class['name'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" name="image" class="form-control" accept="image/jpeg, image/png">
                <img src="uploads/<?= htmlspecialchars($student['image']) ?>" alt="Student Image" style="width:50px; height:50px; object-fit:cover; margin-top:10px;">
            </div>
            <button type="submit" class="btn btn-success">Save Changes</button>
            <a href="view.php?id=<?= $student['id'] ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
