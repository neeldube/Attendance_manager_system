<?php
/**
 * db_connect.php
 * Establishes a MySQLi connection used by every page in the project.
 * Update the credentials below to match your local MySQL / XAMPP setup.
 */

$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASS = "";
$DB_NAME = "attendance_db";

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
