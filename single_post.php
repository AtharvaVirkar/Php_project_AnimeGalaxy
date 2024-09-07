<?php
include 'config.php';

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    // Sanitize the input to prevent SQL injection
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Prepare and execute the SQL query to fetch the post details
    $sql = "SELECT * FROM posts WHERE id = $id";
    $result = $conn->query($sql);

    // Check if the post exists
    if ($result->num_rows > 0) {
        $post = $result->fetch_assoc(); // Fetch the post details;
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $post['title']; ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 40px;
            background: rgb(35,55,87);
            background: linear-gradient(45deg, rgba(35,55,87,0.9738707983193278) 36%, rgba(92,164,150,1) 56%, rgba(97,173,155,1) 71%, rgba(78,146,141,1) 81%, rgba(26,70,101,1) 93%);
            color: #333;
            position: relative; /* Add relative positioning */
        }
        .post {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        img {
            max-width: 100%;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        h2 {
            color: #333;
            margin-bottom: 10px;
            text-align: center;
        }
        p {
            color: #666;
            margin-bottom: 10px;
        }
        .back-link {
            margin-top: 20px;
            display: block;
            text-align: center;
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .back-link:hover {
            color: #0056b3;
        }
        .website-link {
            display: block;
            text-align: center;
            color: #007bff;
            text-decoration: none;
            margin-top: 10px;
        }
        .website-link:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="post">
        <?php if($post['image']): ?>
            <img src="<?php echo $post['image']; ?>" alt="Blog Image">
        <?php endif; ?>
        <h2><?php echo $post['title']; ?></h2>
        <p><?php echo $post['content']; ?></p>
        <p>By <?php echo $post['author']; ?> on <?php echo $post['created_at']; ?></p>
        <?php if($post['website_url']): ?>
            <a href="<?php echo $post['website_url']; ?>" class="website-link">Purchase Link</a>
        <?php endif; ?>
    </div>
    <a href="index.php" class="back-link">Back to Home</a>
</body>
</html>

<?php
    } else {
        // If the post with the provided ID does not exist, display an error message
        echo "Post not found!";
    }
} else {
    // If no 'id' parameter is provided in the URL, display an error message
    echo "Post ID not provided!";
}
?>
