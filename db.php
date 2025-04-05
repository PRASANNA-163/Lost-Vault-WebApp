<?php
$host = "localhost";
$user = "root";
$password = ""; // Update if your MySQL password is not blank
$dbname = "auth_demo";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
