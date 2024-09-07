<?php
include 'config.php'; // Include config.php to establish the database connection
?>

<!DOCTYPE html>
<html>
<head>
    <title>Simple Blog</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 40px;
            background: rgb(35,55,87);
            background: linear-gradient(45deg, rgba(35,55,87,0.9738707983193278) 36%, rgba(92,164,150,1) 56%, rgba(97,173,155,1) 71%, rgba(78,146,141,1) 81%, rgba(26,70,101,1) 93%);
            color: #333;
            position: relative; /* Add relative positioning */
            
        }
        h1 {
            color: #452c63;
            margin-left: auto;
            margin-right: auto;
            width: 50%;
            text-align: center;
            -webkit-text-stroke: 2px rgba(255, 255, 255, 0.3);
        }
        .posts {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            grid-gap: 20px;
        }
        .post {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            position: relative; /* Add relative positioning */
            cursor: pointer; /* Add cursor pointer for clickable effect */
            text-decoration: none; /* Remove underline */
        }
        .post:hover {
            transform: translateY(-5px);
        }
        img {
            width: auto; /* Allow width to adjust */
            max-height: 200px; /* Limit maximum height */
            border-radius: 10px;
            margin-bottom: 10px;
            display: block; /* Ensure proper spacing between images */
            margin-left: auto;
            margin-right: auto;
        }
        h2 {
            font-size: 1.5em;
            margin-bottom: 10px;
            color: black;
        }
        p {
            color: #555;
        }
        .content-snippet {
            margin-bottom: 20px;
        }
        .author-info {
            margin-bottom: 10px;
        }
        .author-info p {
            margin: 0;
        }
        .button-group {
            position: absolute;
            bottom: 10px; /* Move button group to the bottom */
            left: 20px;
            right: 20px;
            text-align: right;
        }
        .read-more, .edit-link {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            cursor: pointer;
            margin-left: 10px;
        }
        .read-more:hover, .edit-link:hover {
            background-color: #0056b3;
        }
        .add-new-post {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }
        .add-new-post:hover {
            background-color: #0056b3;
        }
        .post a{
            text-decoration:none;
        }
    </style>
</head>
<body>
    <h1>Anime Galaxy</h1>

    <a href="add_post.php" class="add-new-post">Add New Post</a>

    <div class="posts">
        <?php
        $sql = "SELECT * FROM posts LIMIT 300"; // Limit to 4 posts
        $result = $conn->query($sql);

        while($row = $result->fetch_assoc()): ?>
            <div class="post">
                <a href="single_post.php?id=<?php echo $row['id']; ?>" target="_blank"> <!-- Open link in new tab -->
                    <?php if($row['image']): ?>
                        <img src="<?php echo $row['image']; ?>" alt="Blog Image">
                    <?php endif; ?>
                    <h2><?php echo $row['title']; ?></h2>
                    <div class="content-snippet">
                        <p><?php echo substr($row['content'], 0, 150); ?>...</p> <!-- Show a snippet of content -->
                    </div>
                    <div class="author-info">
                        <p>By <?php echo $row['author']; ?> on <?php echo $row['created_at']; ?></p>
                    </div>
                </a>
                <div class="button-group">
                    <a href="edit_post.php?id=<?php echo $row['id']; ?>" class="edit-link">Edit</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

</body>
</html>
