<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dishcovery";
$connection = new mysqli($servername, $username, $password, $dbname);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Handle user deletion
if (isset($_GET['delete_user'])) {
    $userId = intval($_GET['delete_user']);
    $deleteUserQuery = "DELETE FROM users WHERE id = ?";
    $stmt = $connection->prepare($deleteUserQuery);
    if ($stmt) {
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: user_management.php");
    exit;
}

// Fetch users data
$fetchUsersQuery = "SELECT id, username, email, created_at FROM users";
$usersResult = $connection->query($fetchUsersQuery);
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
        <h1>User Management</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($usersResult->num_rows > 0) {
                    while ($user = $usersResult->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($user['id']) . '</td>';
                        echo '<td>' . htmlspecialchars($user['username']) . '</td>';
                        echo '<td>' . htmlspecialchars($user['email']) . '</td>';
                        echo '<td>' . htmlspecialchars($user['created_at']) . '</td>';
                        echo '<td>';
                        echo '<a href="edit_user.php?id=' . $user['id'] . '" class="btn btn-primary btn-sm">Edit</a> ';
                        echo '<a href="?delete_user=' . $user['id'] . '" class="btn btn-danger btn-sm">Delete</a>';
                        echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="5">No users found.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <style>
        <?php include 'admin.css'; ?>
    </style>
</body>
</html>

<?php
$connection->close();
?>



