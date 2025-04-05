<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to report an item");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_name = $_POST['item_name'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $date = $_POST['report_date'];
    $founder_name = $_POST['founder_name'];
    $founder_email = $_POST['founder_email'];
    $user_id = $_SESSION['user_id'];

    // Handle image upload
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageName = time() . "_" . basename($_FILES['image']['name']);
        $uploadPath = "uploads/" . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
            // Save data to DB
            $stmt = $conn->prepare("INSERT INTO items (item_name, description, location, report_date, image, founder_name, founder_email, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssi", $item_name, $description, $location, $date, $imageName, $founder_name, $founder_email, $user_id);
            $stmt->execute();
            echo "Item reported successfully!";
        } else {
            echo "Failed to save image!";
        }
    } else {
        echo "Image upload error!";
    }
}
?>
