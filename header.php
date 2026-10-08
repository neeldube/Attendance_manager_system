<?php $current = basename($_SERVER['PHP_SELF']); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="topbar">
    <div class="brand">📘 Attendance Management System</div>
    <nav>
        <a href="index.php"            class="<?= $current=='index.php'?'active':'' ?>">Dashboard</a>
        <a href="add_student.php"      class="<?= $current=='add_student.php'?'active':'' ?>">Add Student</a>
        <a href="mark_attendance.php"  class="<?= $current=='mark_attendance.php'?'active':'' ?>">Mark Attendance</a>
        <a href="attendance_report.php" class="<?= $current=='attendance_report.php'?'active':'' ?>">Attendance Report</a>
    </nav>
</header>
<main class="content">
