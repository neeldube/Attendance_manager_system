<?php
include 'db_connect.php';
include 'includes/header.php';

// Calculate attendance percentage per student
$query = "
    SELECT
        s.student_id,
        s.roll_no,
        s.full_name,
        s.class_name,
        COUNT(a.attendance_id) AS total_marked,
        SUM(a.status = 'Present') AS total_present,
        ROUND(
            IFNULL(SUM(a.status = 'Present') / NULLIF(COUNT(a.attendance_id), 0) * 100, 0), 1
        ) AS attendance_pct
    FROM students s
    LEFT JOIN attendance a ON a.student_id = s.student_id
    GROUP BY s.student_id
    ORDER BY s.roll_no
";
$result = $conn->query($query);
?>

<h1 class="page-title">Attendance Report</h1>
<p class="page-sub">Class-wise summary of total classes, presence, and attendance percentage.</p>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Roll No.</th>
                <th>Name</th>
                <th>Class</th>
                <th>Days Marked</th>
                <th>Days Present</th>
                <th>Attendance %</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()):
            $pct = (float) $row['attendance_pct'];
            $badgeClass = $pct >= 75 ? 'badge-present' : 'badge-absent';
        ?>
            <tr>
                <td><?= htmlspecialchars($row['roll_no']) ?></td>
                <td><?= htmlspecialchars($row['full_name']) ?></td>
                <td><?= htmlspecialchars($row['class_name']) ?></td>
                <td><?= $row['total_marked'] ?></td>
                <td><?= $row['total_present'] ?></td>
                <td>
                    <span class="badge <?= $badgeClass ?>"><?= $pct ?>%</span>
                    <div class="pct-bar-track" style="margin-top:6px;">
                        <div class="pct-bar-fill" style="width: <?= $pct ?>%;"></div>
                    </div>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<p style="font-size:13px; color:#888;">
    Note: Students with attendance below 75% are highlighted in red, in line with common academic eligibility criteria.
</p>

<?php include 'includes/footer.php'; ?>
