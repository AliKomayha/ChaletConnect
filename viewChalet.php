<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Chalet</title>
</head>
<body>

<?php
include("connection.php");

if (isset($_GET['id'])) {
    $chaletId = intval($_GET['id']);

    $conn = connectToDB();

    // Fetch the chalet details using the ID
    $stmt = $conn->prepare("SELECT c.name, c.location, c.description, c.price, c.capacity, c.rooms, cp.url FROM chalet c LEFT JOIN chalet_pictures cp ON c.id = cp.cid WHERE c.id = ?");
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
    <link rel="stylesheet" href="styles/styles.css">
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
            <img src="<?= htmlspecialchars($chalet['url']) ?>" alt="Chalet Image">
            <h1><?= htmlspecialchars($chalet['name']) ?></h1>
            <p><?= htmlspecialchars($chalet['location']) ?></p>
            <p><?= htmlspecialchars($chalet['description']) ?></p>
            <p>Price: $<?= htmlspecialchars($chalet['price']) ?></p>
            <p>Capacity: <?= htmlspecialchars($chalet['capacity']) ?></p>
            <p>Rooms: <?= htmlspecialchars($chalet['rooms']) ?></p>
        </div>
    </main>
</body>
</html>
    
</body>
</html>