<?php
$servername = "localhost";
$username = "root"; // Default WAMP username
$password = ""; // Default WAMP password (no password)
$dbname = "student_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>