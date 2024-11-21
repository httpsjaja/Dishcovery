<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dishcovery";
$connection = new mysqli($servername, $username, $password, $dbname);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Get the current username from the session
$currentUsername = $_SESSION['username'];

// Handle form submission for updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newUsername = $_POST['new_username'];
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate input
    if (empty($newUsername) || empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        echo "All fields are required.";
        exit();
    }

    if ($newPassword !== $confirmPassword) {
        echo "Passwords do not match.";
        exit();
    }

    // Fetch current user password for verification
    $stmt = $connection->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $currentUsername);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user || !password_verify($currentPassword, $user['password'])) {
        echo "Current password is incorrect.";
        exit();
    }

    // Update username and password
    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
    $stmt = $connection->prepare("UPDATE users SET username = ?, password = ? WHERE username = ?");
    $stmt->bind_param("sss", $newUsername, $hashedPassword, $currentUsername);

    if ($stmt->execute()) {
        $_SESSION['username'] = $newUsername; // Update session variable
        echo "Profile updated successfully.";
    } else {
        echo "Error updating profile.";
    }

    $stmt->close();
}
$connection->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile Dashboard</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <div class="profile-container">
        <div class="profile-box">
            <img src="default-profile.png" alt="Profile Picture" class="profile-pic" id="profilePic">
            <div class="username-display">
                <label for="username">Username:</label> 
                <span id="usernameText"><?php echo htmlspecialchars($_SESSION['username']); ?></span> 
                <button id="editBtn">Edit</button>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="editModal" class="modal hidden">
        <div class="modal-content">
            <span class="close-btn" id="closeModal">&times;</span>
            <h2>Edit Profile</h2>
            <form id="editProfileForm" action="" method="POST" enctype="multipart/form-data">
                <!-- Change Profile Picture -->
                <label for="profilePicInput">Change Profile Picture:</label>
                <input type="file" id="profilePicInput" name="profile_picture" accept="image/*"><br><br>
                
                <!-- Edit Username -->
                <label for="usernameField">Edit Username:</label>
                <input type="text" id="usernameField" name="new_username" value="<?php echo htmlspecialchars($_SESSION['username']); ?>" required><br><br>
                
                <!-- Change Password -->
                <label for="currentPassword">Current Password:</label>
                <input type="password" id="currentPassword" name="current_password" required><br><br>
                
                <label for="newPassword">New Password:</label>
                <input type="password" id="newPassword" name="new_password" required><br><br>
                
                <label for="confirmPassword">Confirm New Password:</label>
                <input type="password" id="confirmPassword" name="confirm_password" required><br><br>
                
                <!-- Save Changes -->
                <button type="submit" id="saveBtn">Save</button>
                <button type="button" id="cancelBtn">Cancel</button>
            </form>
        </div>
    </div>

    <script src="profile.js"></script>
</body>
</html>
