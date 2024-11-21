<?php
// Database connection
$host = 'localhost';
$dbname = 'dishcovery';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Retrieve logs (filtered by user ID if provided)
$userId = isset($_GET['user_id']) ? $_GET['user_id'] : null;

if ($userId) {
    $stmt = $pdo->prepare("SELECT * FROM user_activity_logs WHERE user_id = :user_id ORDER BY timestamp DESC");
    $stmt->execute(['user_id' => $userId]);
} else {
    $stmt = $pdo->query("SELECT * FROM user_activity_logs ORDER BY timestamp DESC");
}

$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
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
                <li><a href="pendingrecipe.php">Pending Recipe</a></li>
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
            <div class="container">
                <h1>Admin - User Activity Logs</h1>

                <!-- Filter logs by user ID -->
                <form method="GET" class="filter-form">
                    <label for="user_id">Filter by User ID:</label>
                    <input type="number" id="user_id" name="user_id" placeholder="Enter User ID" value="<?php echo htmlspecialchars($userId); ?>">
                    <button type="submit">Filter</button>
                </form>

                <!-- Display logs in a table -->
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User ID</th>
                            <th>Activity</th>
                            <th>Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($logs) > 0): ?>
                            <?php foreach ($logs as $log): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($log['id']); ?></td>
                                    <td><?php echo htmlspecialchars($log['user_id']); ?></td>
                                    <td><?php echo htmlspecialchars($log['activity']); ?></td>
                                    <td><?php echo htmlspecialchars($log['timestamp']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">No logs found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
     <style>
        <?php include 'admin.css'; ?>
    </style>
     <style>


        h1 {
            text-align: center;
            color: #333;
        }

        .filter-form {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .filter-form input, .filter-form button {
            padding: 10px;
            font-size: 14px;
        }

        .filter-form button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        .filter-form button:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: #f4f4f4;
            color: #333;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</body>
</html>
