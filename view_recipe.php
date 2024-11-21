<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dishcovery";
$connection = new mysqli($servername, $username, $password, $dbname);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$recipeId = $_GET['id']; // Get recipe ID from URL

// Fetch the full recipe details
$sql = "SELECT * FROM recipeee WHERE id = $recipeId";
$result = $connection->query($sql);
$recipe = $result->fetch_assoc();

// Handle rating submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['rating'])) {
    $rating = (int)$_POST['rating'];
    $insertRatingSql = "INSERT INTO ratings (recipe_id, rating) VALUES ($recipeId, $rating)";
    $connection->query($insertRatingSql);
}

// Handle comment submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comment'])) {
    $comment = $connection->real_escape_string($_POST['comment']);
    $userId = 1; // Replace with actual logged-in user ID
    $insertCommentSql = "INSERT INTO comments (recipe_id, user_id, comment) VALUES ($recipeId, $userId, '$comment')";
    $connection->query($insertCommentSql);
}

// Fetch the average rating for this recipe
$averageRatingSql = "SELECT AVG(rating) AS average_rating FROM ratings WHERE recipe_id = $recipeId";
$averageRatingResult = $connection->query($averageRatingSql);
$averageRating = $averageRatingResult->fetch_assoc()['average_rating'];

// Fetch all comments with usernames for this recipe
$commentsSql = "
    SELECT comments.comment, comments.created_at, users.username 
    FROM comments 
    JOIN users ON comments.user_id = users.id 
    WHERE comments.recipe_id = $recipeId 
    ORDER BY comments.created_at DESC";
$commentsResult = $connection->query($commentsSql);

// Close the database connection
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($recipe['dish_name']) ?> - Recipe Details</title>
    <link rel="stylesheet" href="view_recipe.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="recipe-details">
        <h2><?= htmlspecialchars($recipe['dish_name']) ?></h2>
        <img src="<?= htmlspecialchars($recipe['image_path']) ?>" alt="<?= htmlspecialchars($recipe['dish_name']) ?>" style="max-width: 100%; height: auto;">
        <p><strong>Category:</strong> <?= htmlspecialchars($recipe['category']) ?></p>
        <p><strong>Recipe and Procedure:</strong><br><?= nl2br(htmlspecialchars($recipe['recipe'])) ?></p>

        <p><strong>Average Rating:</strong> 
            <?php
            if ($averageRating) {
                $fullStars = floor($averageRating);
                $halfStar = ($averageRating - $fullStars) >= 0.5 ? 1 : 0;
                $emptyStars = 5 - $fullStars - $halfStar;

                for ($i = 0; $i < $fullStars; $i++) {
                    echo '<i class="fas fa-star"></i>';
                }
                if ($halfStar) {
                    echo '<i class="fas fa-star-half-alt"></i>';
                }
                for ($i = 0; $i < $emptyStars; $i++) {
                    echo '<i class="far fa-star"></i>';
                }
                echo " (" . round($averageRating, 1) . ")";
            } else {
                echo 'No ratings yet';
            }
            ?>
        </p>

        <form method="POST">
            <label for="rating">Rate this recipe:</label><br>
            <div class="stars">
                <input type="radio" name="rating" value="1" id="star1"><label for="star1"><i class="fas fa-star"></i></label>
                <input type="radio" name="rating" value="2" id="star2"><label for="star2"><i class="fas fa-star"></i></label>
                <input type="radio" name="rating" value="3" id="star3"><label for="star3"><i class="fas fa-star"></i></label>
                <input type="radio" name="rating" value="4" id="star4"><label for="star4"><i class="fas fa-star"></i></label>
                <input type="radio" name="rating" value="5" id="star5"><label for="star5"><i class="fas fa-star"></i></label>
            </div><br>
            <input type="submit" value="Submit Rating">
        </form>

        <h3>Comments:</h3>
        <?php
        if ($commentsResult->num_rows > 0) {
            while ($comment = $commentsResult->fetch_assoc()) {
                echo "<div class='comment'>";
                echo "<strong>" . htmlspecialchars($comment['username']) . ":</strong> "; // Display username
                echo "<p>" . htmlspecialchars($comment['comment']) . "</p>";
                echo "<small>Posted on " . htmlspecialchars($comment['created_at']) . "</small>";
                echo "</div><br>";
            }
        } else {
            echo "<p>No comments yet.</p>";
        }
        ?>

        <form method="POST">
            <label for="comment">Leave a comment:</label><br>
            <textarea name="comment" id="comment" rows="4" cols="50" required></textarea><br>
            <input type="submit" value="Submit Comment">
        </form>
    </div>

    <a href="userdash.php" class="back-to-dashboard-btn">Back to Dashboard</a>

    <style>
       /* Your Provided CSS */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f8f9fa;
    color: #333;
    margin: 0;
    padding: 0;
    line-height: 1.6;
}

.recipe-details {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.recipe-details h2 {
    font-size: 2rem;
    color: #343a40;
    text-align: center;
    margin-bottom: 20px;
}

.recipe-details h3 {
    font-size: 1.5rem;
    color: #495057;
    margin-top: 30px;
    border-bottom: 2px solid #e9ecef;
    padding-bottom: 5px;
}

.recipe-details img {
    display: block;
    margin: 0 auto 20px;
    border-radius: 10px;
    max-width: 100%;
}

.recipe-details p {
    margin: 10px 0;
    font-size: 1rem;
    color: #495057;
}

.recipe-details .fas, 
.recipe-details .far {
    font-size: 1.5rem;
    color: gold;
    margin-right: 5px;
}

.stars {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}

.stars label {
    font-size: 2rem;
    color: #ccc;
    cursor: pointer;
    transition: color 0.3s ease;
}

.stars input:checked ~ label,
.stars label:hover,
.stars label:hover ~ label {
    color: gold;
}

.comment {
    background-color: #f8f9fa;
    border-left: 4px solid #007bff;
    padding: 10px 15px;
    margin-bottom: 15px;
    border-radius: 5px;
}

.comment small {
    color: #6c757d;
    font-size: 0.9rem;
}

textarea {
    width: 100%;
    padding: 10px;
    font-size: 1rem;
    border: 1px solid #ced4da;
    border-radius: 5px;
    resize: vertical;
    margin-bottom: 10px;
}

textarea:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

input[type="submit"] {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1rem;
    transition: background-color 0.3s ease;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

.back-to-dashboard-btn {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: #28a745;
    color: white;
    padding: 10px 20px;
    font-size: 1rem;
    font-weight: bold;
    text-decoration: none;
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: background-color 0.3s ease;
}

.back-to-dashboard-btn:hover {
    background-color: #218838;
}
    </style>
</body>
</html>
