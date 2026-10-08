<?php
include 'db_connect.php';
include 'includes/header.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roll  = trim($_POST['roll_no']);
    $name  = trim($_POST['full_name']);
    $class = trim($_POST['class_name']);
    $email = trim($_POST['email']);

    $stmt = $conn->prepare("INSERT INTO students (roll_no, full_name, class_name, email) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $roll, $name, $class, $email);

    if ($stmt->execute()) {
        $message = "Student '$name' added successfully.";
    } else {
        $message = "Error: " . $stmt->error;
    }
    $stmt->close();
}

$students = $conn->query("SELECT * FROM students ORDER BY student_id DESC");
?>

<h1 class="page-title">Add Student</h1>
<p class="page-sub">Register a new student so they can be marked present or absent.</p>

<?php if ($message): ?>
    <div class="alert-success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<div class="card">
    <form method="POST" action="add_student.php">
        <label>Roll Number</label>
        <input type="text" name="roll_no" placeholder="e.g. A1-04" required>

        <label>Full Name</label>
        <input type="text" name="full_name" placeholder="e.g. Riya Sharma" required>

        <label>Class</label>
        <input type="text" name="class_name" placeholder="e.g. BCA Cybersecurity A1" required>

        <label>Email (optional)</label>
        <input type="email" name="email" placeholder="student@example.com">

        <button type="submit" class="btn">Save Student</button>
    </form>
</div>

<div class="card">
    <h2 style="color:var(--navy); margin-top:0;">Existing Students</h2>
    <table>
        <thead>
            <tr><th>Roll No.</th><th>Name</th><th>Class</th><th>Email</th></tr>
        </thead>
        <tbody>
        <?php while ($row = $students->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['roll_no']) ?></td>
                <td><?= htmlspecialchars($row['full_name']) ?></td>
                <td><?= htmlspecialchars($row['class_name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>
