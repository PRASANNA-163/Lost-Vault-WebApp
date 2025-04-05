<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access.");
}

$user_id = $_SESSION['user_id'];
$item_id = intval($_GET['id']);

// First, verify ownership
$stmt = $conn->prepare("SELECT image FROM items WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $item_id, $user_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($image_path);
    $stmt->fetch();

    // Delete the image file
    if (file_exists($image_path)) {
        unlink($image_path);
    }

    // Delete the item
    $delete_stmt = $conn->prepare("DELETE FROM items WHERE id = ? AND user_id = ?");
    $delete_stmt->bind_param("ii", $item_id, $user_id);
    $delete_stmt->execute();
    $delete_stmt->close();

    header("Location: view_items.php?deleted=1");
} else {
    echo "You are not authorized to delete this item.";
}

$stmt->close();
?>
