<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : "";

// Build query
$sql = "SELECT * FROM items";
if (!empty($search)) {
    $sql .= " WHERE item_name LIKE '%$search%' OR location LIKE '%$search%'";
}
$sql .= " ORDER BY report_date DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Reported Items</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background: linear-gradient(135deg, #1f2f33, #a3b4c4);
            height: 100vh;
        }

        .search-bar {
            max-width: 500px;
            margin: 0 auto 30px auto;
            display: flex;
        }

        .search-bar input[type="text"] {
            flex: 1;
            padding: 10px;
            font-size: 16px;
        }

        .search-bar button {
            padding: 10px 15px;
            font-size: 16px;
            background-color: #1F2F33;
            color: white;
            border: none;
            cursor: pointer;
        }

        .items-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .item-card {
            flex: 1 1 calc(33.333% - 40px);
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
            background-color: #a3b4c4;
        }

        .item-card img {
            max-width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 5px;
        }

        .item-card h3 {
            margin: 10px 0 5px 0;
        }

        .item-card p {
            margin: 5px 0;
        }

        .delete-btn {
            display: inline-block;
            margin-top: 10px;
            padding: 6px 10px;
            background-color: red;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        @media (max-width: 768px) {
            .item-card {
                flex: 1 1 100%;
            }
        }

        .arrowback {
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 16px;
            text-decoration: none;
            color: #ffffff;
            background: #1e2a30;
            padding: 8px 12px;
            border-radius: 5px;
        }

        .arrowback :hover {
            background: #31444f;
        }
    </style>
</head>
<body>
    <a style="text-align: left" href="navbar.html" class="arrowback">Back</a>
    <h2 style="margin-top: 30px; text-align:center">Reported Items</h2>
    
    <form class="search-bar" method="GET" action="">
        <input type="text" name="search" placeholder="Search by item name or location..." value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Search</button>
    </form>

    <div class="items-container">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="item-card">
                    <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="Item Image">
                    <h3><?php echo htmlspecialchars($row['item_name']); ?></h3>
                    <p><strong>Description:</strong> <?php echo htmlspecialchars($row['description']); ?></p>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?></p>
                    <p><strong>Date:</strong> <?php echo htmlspecialchars($row['report_date']); ?></p>
                    <p><strong>Posted by:</strong> <?php echo htmlspecialchars($row['founder_name']); ?> (<?php echo htmlspecialchars($row['founder_email']); ?>)</p>
                    <?php if ($row['user_id'] == $user_id): ?>
                        <a class="delete-btn" href="delete_item.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No items found.</p>
        <?php endif; ?>
    </div>

    <div style="text-align:center ; margin:10px ">
        <a href="ReportForm.html" style="color:white">Report Another Item</a>
    </div>

</body>
</html>
