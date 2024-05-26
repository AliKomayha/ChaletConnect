<?php
include("connection.php");

if (isset($_GET['id'])) {
    $chaletId = intval($_GET['id']);

    $conn = connectToDB();

    // Fetch the main details of the chalet
    $stmt = $conn->prepare("SELECT c.name, c.location, c.description, c.price, c.capacity, c.rooms 
                            FROM chalet c WHERE c.id = ?");
    $stmt->bind_param("i", $chaletId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $chalet = $result->fetch_assoc();
    } else {
        echo "Chalet not found.";
        exit;
    }
    $stmt->close();

    // Fetch the images of the chalet
    $stmt = $conn->prepare("SELECT url, main_image FROM chalet_pictures WHERE cid = ?");
    $stmt->bind_param("i", $chaletId);
    $stmt->execute();
    $imagesResult = $stmt->get_result();

    $mainImage = null;
    $otherImages = [];
    while ($image = $imagesResult->fetch_assoc()) {
        if ($image['main_image']) {
            $mainImage = $image['url'];
        } else {
            $otherImages[] = $image['url'];
        }
    }

    $stmt->close();

    // Fetch the services of the chalet
    $stmt = $conn->prepare("SELECT s.name FROM chalet_services cs JOIN services s ON cs.sid = s.id WHERE cs.cid = ?");
    $stmt->bind_param("i", $chaletId);
    $stmt->execute();
    $servicesResult = $stmt->get_result();

    $services = [];
    while ($service = $servicesResult->fetch_assoc()) {
        $services[] = $service['name'];
    }

    $stmt->close();
    closeDBconnection($conn);
} else {
    echo "Invalid request.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($chalet['name']) ?></title>
    <link rel="stylesheet" href="styles/viewChalet.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    
</head>
<body>
    <header>
        <div class="navbar">
            <span class="logo">Chalet Connect</span>
            <nav>
                <a href="index.php">Home</a>
                <a href="ownerIndex.php">List your Chalet</a>
                <a href="signupPage.php">Register</a>
                <a href="#" class="sign-in">Sign in</a>
            </nav>
        </div>
    </header>
    <main>
        <div class="chalet-details">
            <div class="chalet-main">
                <img src="<?= htmlspecialchars($mainImage ?: 'default.jpg') ?>" alt="Chalet Main Image">
                <div>
                    <h1><?= htmlspecialchars($chalet['name']) ?></h1>
                    <p><?= htmlspecialchars($chalet['location']) ?></p>
                </div>
            </div>
            <p><?= htmlspecialchars($chalet['description']) ?></p>
            <p>Price: $<?= htmlspecialchars($chalet['price']) ?></p>
            <p>Capacity: <?= htmlspecialchars($chalet['capacity']) ?></p>
            <p>Rooms: <?= htmlspecialchars($chalet['rooms']) ?></p>

            <h2>Services</h2>
            <ul class="services-list">
                <?php foreach ($services as $service): ?>
                    <li><?= htmlspecialchars($service) ?></li>
                <?php endforeach; ?>
            </ul>

            <h2>Additional Images</h2>
            <div class="chalet-images">
                <?php foreach ($otherImages as $image): ?>
                    <img src="<?= htmlspecialchars($image) ?>" alt="Chalet Image">
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    
</body>
</html>
