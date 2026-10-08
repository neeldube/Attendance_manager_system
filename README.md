# Attendance Management System (PHP + MySQL)

Mini Project — Neel Dube (240503020016), BCA Cybersecurity, A1

## Features
- Add Student
- Mark Attendance (date-wise, Present/Absent)
- Generate Attendance Report
- Calculate Attendance Percentage per student

## Setup Instructions (XAMPP / WAMP)

1. Copy the `AttendanceManagementSystem` folder into your server's `htdocs` (XAMPP) or `www` (WAMP) directory.
2. Start **Apache** and **MySQL** from the XAMPP/WAMP control panel.
3. Open **phpMyAdmin** (http://localhost/phpmyadmin) and import `schema.sql` to create the `attendance_db` database, tables, and sample data.
4. If your MySQL username/password differ from the defaults, update them in `db_connect.php`.
5. Visit **http://localhost/AttendanceManagementSystem/index.php** in your browser.

## File Structure
```
AttendanceManagementSystem/
├── db_connect.php          -> Database connection
├── schema.sql               -> Database schema + sample data
├── style.css                 -> Stylesheet (navy & gold theme)
├── index.php                 -> Dashboard
├── add_student.php           -> Add Student page
├── mark_attendance.php       -> Mark Attendance page
├── attendance_report.php     -> Attendance Report + percentage
└── includes/
    ├── header.php            -> Shared navigation header
    └── footer.php            -> Shared footer
```

## Notes
- Attendance percentage below 75% is flagged in red on the report page, matching common academic eligibility rules.
- The `attendance` table uses a UNIQUE key on (student_id, date_marked) with `ON DUPLICATE KEY UPDATE`, so re-marking a date updates the existing record instead of creating duplicates.
