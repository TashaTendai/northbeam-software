<?php
/* =========================================================================
   db.php
   Central database connection file. Every page that needs the database
   will include this file instead of connecting separately.
   ========================================================================= */

$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";           // XAMPP's default MySQL root user has no password
$dbName = "northbeam_db";

// Create the connection
$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

// Check if it failed
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>