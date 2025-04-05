<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST["username"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $check = "SELECT * FROM users WHERE username='$username'";
    $res = $conn->query($check);
    
    if ($res->num_rows > 0) {
        echo "Username already exists!";
    } else {
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        if ($conn->query($sql)) {
            echo "Registration successful! <a href='login.html'>Login now</a>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>
