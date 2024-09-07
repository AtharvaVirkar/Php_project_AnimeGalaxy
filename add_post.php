<?php
ob_start(); // Start output buffering

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_POST['author'];

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
        $image = null;
    }

    // Website URL
    $website_url = $_POST['website_url'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO posts (title, content, author, image, website_url) VALUES (?, ?, ?, ?, ?)");

    // Bind the parameters
    $stmt->bind_param("sssss", $title, $content, $author, $image, $website_url);

    // Execute the statement
    if ($stmt->execute()) {
        header('Location: index.php');
        exit(); // Exit to ensure no further output is sent
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Post</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 40px;
            background: rgb(35,55,87);
            background: linear-gradient(45deg, rgba(35,55,87,0.9738707983193278) 36%, rgba(92,164,150,1) 56%, rgba(97,173,155,1) 71%, rgba(78,146,141,1) 81%, rgba(26,70,101,1) 93%);
            color: #333;
        }
        h1 {
            color: #452c63;
            text-align: center;
            -webkit-text-stroke: 2px rgba(255, 255, 255, 0.3);
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            transition: border-color 0.3s ease;
        }
        input[type="text"]:focus,
        textarea:focus {
            border-color: #007bff;
            outline: none;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Add New Post</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <label>Title:</label>
        <input type="text" name="title" required>

        <label>Content:</label>
        <textarea name="content" rows="4" required></textarea>

        <label>Author:</label>
        <input type="text" name="author" required>

        <label>Image:</label>
        <input type="file" name="image">

        <label>Website URL:</label>
        <input type="text" name="website_url">

        <input type="submit" value="Submit">
    </form>
</body>
</html>
