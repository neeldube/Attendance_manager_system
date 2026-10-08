<?php
include 'db_connect.php';
include 'includes/header.php';

// Total students
$totalStudents = $conn->query("SELECT COUNT(*) AS c FROM students")->fetch_assoc()['c'];

// Today's attendance
$today = date("Y-m-d");
$presentToday = $conn->query("SELECT COUNT(*) AS c FROM attendance WHERE date_marked='$today' AND status='Present'")->fetch_assoc()['c'];
$absentToday  = $conn->query("SELECT COUNT(*) AS c FROM attendance WHERE date_marked='$today' AND status='Absent'")->fetch_assoc()['c'];

// Overall average attendance percentage
$avgRow = $conn->query("
    SELECT ROUND(SUM(status='Present')/COUNT(*)*100, 1) AS avg_pct
    FROM attendance
")->fetch_assoc();
$avgPct = $avgRow['avg_pct'] !== null ? $avgRow['avg_pct'] : 0;
?>

<h1 class="page-title">Dashboard</h1>
<p class="page-sub">Overview of students and today's attendance at a glance.</p>

<div class="stat-grid">
    <div class="stat-card">
        <div class="num"><?= $totalStudents ?></div>
        <div class="lbl">Total Students</div>
    </div>
    <div class="stat-card">
        <div class="num"><?= $presentToday ?></div>
        <div class="lbl">Present Today</div>
    </div>
    <div class="stat-card">
        <div class="num"><?= $absentToday ?></div>
        <div class="lbl">Absent Today</div>
    </div>
    <div class="stat-card">
        <div class="num"><?= $avgPct ?>%</div>
        <div class="lbl">Overall Attendance</div>
    </div>
</div>

<div class="card">
    <h2 style="color:var(--navy); margin-top:0;">Quick Actions</h2>
    <a href="add_student.php" class="btn">+ Add Student</a>
    <a href="mark_attendance.php" class="btn btn-gold">Mark Today's Attendance</a>
    <a href="attendance_report.php" class="btn" style="background:#445070;">View Report</a>
</div>

<?php include 'includes/footer.php'; ?>
