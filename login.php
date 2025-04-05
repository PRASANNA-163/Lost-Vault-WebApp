<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST["username"]);
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $res = $conn->query($sql);

    if ($res->num_rows == 1) {
        $user = $res->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user['id']; // ✅ store user ID from database
            include('navbar.html');
           // echo "Login successful! Welcome, " . $_SESSION['username'];
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "User not found!";
    }
}
?>
