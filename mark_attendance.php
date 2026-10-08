<?php
include 'db_connect.php';
include 'includes/header.php';

$message = "";
$selectedDate = $_POST['date_marked'] ?? $_GET['date_marked'] ?? date("Y-m-d");

// Handle attendance submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_attendance'])) {
    $date = $_POST['date_marked'];
    $statuses = $_POST['status']; // array: student_id => Present/Absent

    $stmt = $conn->prepare("
        INSERT INTO attendance (student_id, date_marked, status)
        VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE status = VALUES(status)
    ");

    foreach ($statuses as $studentId => $status) {
        $stmt->bind_param("iss", $studentId, $date, $status);
        $stmt->execute();
    }
    $stmt->close();
    $message = "Attendance for $date saved successfully.";
}

// Fetch students with today's/selected date's existing status (if any)
$students = $conn->query("
    SELECT s.student_id, s.roll_no, s.full_name, s.class_name,
           a.status AS current_status
    FROM students s
    LEFT JOIN attendance a
      ON a.student_id = s.student_id AND a.date_marked = '$selectedDate'
    ORDER BY s.roll_no
");
?>

<h1 class="page-title">Mark Attendance</h1>
<p class="page-sub">Select a date and mark each student Present or Absent.</p>

<?php if ($message): ?>
    <div class="alert-success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<div class="card">
    <form method="GET" action="mark_attendance.php" style="margin-bottom:10px;">
        <label>Attendance Date</label>
        <input type="date" name="date_marked" value="<?= htmlspecialchars($selectedDate) ?>" onchange="this.form.submit()">
    </form>

    <form method="POST" action="mark_attendance.php">
        <input type="hidden" name="date_marked" value="<?= htmlspecialchars($selectedDate) ?>">
        <table>
            <thead>
                <tr><th>Roll No.</th><th>Name</th><th>Class</th><th>Status</th></tr>
            </thead>
            <tbody>
            <?php while ($row = $students->fetch_assoc()):
                $isPresent = ($row['current_status'] ?? 'Present') === 'Present';
            ?>
                <tr>
                    <td><?= htmlspecialchars($row['roll_no']) ?></td>
                    <td><?= htmlspecialchars($row['full_name']) ?></td>
                    <td><?= htmlspecialchars($row['class_name']) ?></td>
                    <td>
                        <select name="status[<?= $row['student_id'] ?>]">
                            <option value="Present" <?= $isPresent ? 'selected' : '' ?>>Present</option>
                            <option value="Absent" <?= !$isPresent ? 'selected' : '' ?>>Absent</option>
                        </select>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        <button type="submit" name="submit_attendance" class="btn btn-gold">Save Attendance</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
