<?php
$servername = "localhost";
$username = "root"; // Default in XAMPP
$password = ""; // Default is empty
$dbname = "weddingcontact_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
