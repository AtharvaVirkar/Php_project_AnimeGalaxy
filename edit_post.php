<?php
ob_start(); // Start output buffering

include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $author = $_POST['author'];
        $image = $_POST['old_image']; // Default to the old image
        $website_url = $_POST['website_url'];

        // Check if a new image file is uploaded
        if ($_FILES["image"]["tmp_name"] != "") {
            // Image Upload
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false) {
                move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
                $image = $target_file;
            } else {
                echo "File is not an image.";
                exit();
            }
        }

        // Prepare the SQL statement
        $stmt = $conn->prepare("UPDATE posts SET title=?, content=?, author=?, image=?, website_url=? WHERE id=?");

        // Bind the parameters
        $stmt->bind_param("sssssi", $title, $content, $author, $image, $website_url, $id);

        // Execute the statement
        if ($stmt->execute()) {
            header('Location: index.php');
            exit(); // Exit to ensure no further output is sent
        } else {
            echo "Error updating post: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }

    $sql = "SELECT * FROM posts WHERE id=$id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Post not found!";
        exit();
    }
} else {
    echo "Post ID not provided!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="file"] {
            margin-top: 10px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        img {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Edit Post</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <label>Title:</label>
        <input type="text" name="title" value="<?php echo $row['title']; ?>" required>

        <label>Content:</label>
        <textarea name="content" rows="4" required><?php echo $row['content']; ?></textarea>

        <label>Author:</label>
        <input type="text" name="author" value="<?php echo $row['author']; ?>" required>

        <label>Current Image:</label>
        <?php if ($row['image']): ?>
            <img src="<?php echo $row['image']; ?>" alt="Current Image">
        <?php else: ?>
            <p>No image uploaded.</p>
        <?php endif; ?>

        <label>New Image:</label>
        <input type="file" name="image">

        <!-- Hidden input to store old image URL -->
        <input type="hidden" name="old_image" value="<?php echo $row['image']; ?>">

        <label>Website URL:</label>
        <input type="text" name="website_url" value="<?php echo $row['website_url']; ?>">

        <input type="submit" value="Update">
    </form>
</div>

</body>
</html>
