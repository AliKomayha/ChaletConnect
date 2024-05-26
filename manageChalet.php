<?php

    include("connection.php");
    session_start();
    
    if (!isset($_SESSION["oid"])) {
        header("Location: ownerIndex.php");
        exit();
    }

    if (!isset($_GET['id'])) {
        echo "Invalid request.";
        exit();
    }

    $chaletId = intval($_GET['id']);
    $ownerId = $_SESSION["oid"];
    $conn = connectToDB();

// Verify that the chalet belongs to the logged-in owner
$chaletResult = mysqli_query($conn, "SELECT * FROM chalet WHERE id = '$chaletId' AND oid = '$ownerId'");
if (mysqli_num_rows($chaletResult) == 0) {
    echo "Chalet not found or you don't have permission to manage this chalet.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['images'])) {
    $targetDir = "uploads/";
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    $images = $_FILES['images'];
    $uploadOk = true;
    $imageURLs = [];

    for ($i = 0; $i < count($images['name']); $i++) {
        $imageFileType = strtolower(pathinfo($images['name'][$i], PATHINFO_EXTENSION));
        $targetFile = $targetDir . basename($images['name'][$i]);
        
        if (!in_array($imageFileType, $allowedTypes)) {
            echo "Only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = false;
            break;
        }
        
        if (move_uploaded_file($images['tmp_name'][$i], $targetFile)) {
            $imageURLs[] = $targetFile;
        } else {
            echo "Sorry, there was an error uploading your file.";
            $uploadOk = false;
            break;
        }
    }

    if ($uploadOk) {
        // Insert image URLs into the database
        foreach ($imageURLs as $index => $url) {
            $mainImage = ($index == 0) ? 1 : 0;
            $stmt = $conn->prepare("INSERT INTO chalet_pictures (cid, url, main_image) VALUES (?, ?, ?)");
            $stmt->bind_param("isi", $chaletId, $url, $mainImage);
            $stmt->execute();
        }
        echo "Images uploaded successfully.";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Chalet Images</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <header>
        <div class="navbar">
            <span class="logo">Chalet Connect</span>
            <nav>
                <a href="#">List item</a>
                <a href="ownerIndex.php">List your Chalet</a>
                <a href="signupPage.php">Register</a>
                <a href="#" class="sign-in">Sign in</a>
            </nav>
        </div>
    </header>

    <main>
        <h1>Manage Images for Chalet: <?= htmlspecialchars($chaletId) ?></h1>
        <form action="manageChalet.php?id=<?= htmlspecialchars($chaletId) ?>" method="post" enctype="multipart/form-data">
            <label for="images">Upload Images (up to 6):</label>
            <input type="file" name="images[]" id="images" multiple required>
            <button type="submit">Upload</button>
        </form>
    </main>
</body>
</html>

    
</body>
</html>