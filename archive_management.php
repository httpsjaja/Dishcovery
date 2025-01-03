<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dishcovery";
$connection = new mysqli($servername, $username, $password, $dbname);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Handle deletion of archived recipe
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $deleteArchiveSql = "DELETE FROM recipe_archive WHERE id = ?";
    $stmtArchive = $connection->prepare($deleteArchiveSql);

    if ($stmtArchive) {
        $stmtArchive->bind_param("i", $id);
        $stmtArchive->execute();
        $stmtArchive->close();
    }

    header("Location: archive_management.php");
    exit;
}

// Fetch archived recipes
$archiveSql = "SELECT * FROM recipe_archive";
$archiveResult = $connection->query($archiveSql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>Admin</h2>
            <ul>
                <li><a href="admin.php">Dashboard</a></li>
                <li><a href="adminuserdash.php">Userdash</a></li>
                <li><a href="user_management.php">Users</a></li>
                <li><a href="archive_management.php">Archive</a></li>
                <li><a href="addmin.php">Add Admin</a></li>
                <li><a href="pendingrecipe.php">Pending recipe</a></li>
                <li><a href="user_activity.php">Activity Logs</a></li>
                <li><a href="login.php">Logout</a></li>
            
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="content">
            <!-- Header -->
            <header class="header">
                <h1>Dish-covery</h1>
                <a href="login.php" class="logout-btn btn btn-danger">Logout</a>
            </header>
<body>
    <div class="container mt-5">
        <h1>Archived Recipes</h1>
        <div class="row">
            <?php
            if ($archiveResult->num_rows > 0) {
                while ($recipe = $archiveResult->fetch_assoc()) {
                    echo '<div class="col-md-4 mb-4">';
                    echo '<div class="card">';
                    if (!empty($recipe['image_path'])) {
                        echo '<img src="' . htmlspecialchars($recipe['image_path']) . '" class="card-img-top" alt="' . htmlspecialchars($recipe['dish_name']) . '">';
                    }
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . htmlspecialchars($recipe['dish_name']) . '</h5>';
                    echo '<p class="card-text">' . htmlspecialchars($recipe['recipe']) . '</p>';
                    echo '<p class="card-text"><small class="text-muted">Category: ' . htmlspecialchars($recipe['category']) . '</small></p>';
                    echo '<a href="?action=delete&id=' . $recipe['id'] . '" class="btn btn-danger">Delete</a>';
                    echo '</div>'; // Close card-body
                    echo '</div>'; // Close card
                    echo '</div>'; // Close column
                }
            } else {
                echo '<p>No archived recipes found.</p>';
            }
            ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        <?php include 'admin.css'; ?>
    </style>
</body>
</html>







