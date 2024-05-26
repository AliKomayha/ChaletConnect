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

$chalet = mysqli_fetch_assoc($chaletResult);

// Fetch the current images
$imagesResult = mysqli_query($conn, "SELECT * FROM chalet_pictures WHERE cid = '$chaletId'");
$images = [];
while ($row = mysqli_fetch_assoc($imagesResult)) {
    $images[] = $row;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle updating chalet information
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $location = mysqli_real_escape_string($conn, $_POST["location"]);
    $description = mysqli_real_escape_string($conn, $_POST["description"]);
    $price = mysqli_real_escape_string($conn, $_POST["price"]);
    $capacity = mysqli_real_escape_string($conn, $_POST["capacity"]);
    $rooms = mysqli_real_escape_string($conn, $_POST["rooms"]);

    $updateQuery = "UPDATE chalet SET name = '$name', location = '$location', description = '$description', price = '$price', capacity = '$capacity', rooms = '$rooms' WHERE id = '$chaletId' AND ownerId = '$ownerId'";
    mysqli_query($conn, $updateQuery);

    // Handle image uploads
    if (isset($_FILES['images'])) {
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

    // Refresh the page to show updated information and images
    header("Location: manageChalet.php?id=$chaletId");
    exit();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Chalet</title>
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
        <h1>Manage Chalet: <?= htmlspecialchars($chalet['name']) ?></h1>
        <form action="manageChalet.php?id=<?= htmlspecialchars($chaletId) ?>" method="post" enctype="multipart/form-data">
            <label for="name">Chalet Name:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($chalet['name']) ?>" required>

            <label for="location">Location:</label>
            <input type="text" id="location" name="location" value="<?= htmlspecialchars($chalet['location']) ?>" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?= htmlspecialchars($chalet['description']) ?></textarea>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" value="<?= htmlspecialchars($chalet['price']) ?>" required>

            <label for="capacity">Capacity:</label>
            <textarea id="capacity" name="capacity" required><?= htmlspecialchars($chalet['capacity']) ?></textarea>

            <label for="rooms">Rooms:</label>
            <textarea id="rooms" name="rooms" required><?= htmlspecialchars($chalet['rooms']) ?></textarea>

            <h2>Current Images</h2>
            <div class="current-images">
                <?php foreach ($images as $image): ?>
                    <div class="image-container">
                        <img src="<?= htmlspecialchars($image['url']) ?>" alt="Chalet Image" class="chalet-image">
                    </div>
                <?php endforeach; ?>
            </div>

            <label for="images">Upload New Images (up to 6):</label>
            <input type="file" name="images[]" id="images" multiple>

            <button type="submit">Update Chalet</button>
        </form>
    </main>
</body>
</html>
