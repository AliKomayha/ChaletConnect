<?php
include("connection.php");
session_start();

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
    <!-- FullCalendar CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css' rel='stylesheet' />
    
</head>
<body>
    <header>
        <div class="navbar">
            <span class="logo">Chalet Connect</span>
            <nav>
                <a href="index.php">Home</a>
                <a href="ownerIndex.php">List your Chalet</a>
                <a href="signupPage.php">Register</a>
                <!-- <a href="#" class="sign-in">Sign in</a> -->
            </nav>
        </div>
    </header>
    
        <div class="chalet-page">
        <div class="chalet-page-left">
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
        </div>
        <div class="chalet-page-right">
        <h2>Booking Calendar</h2>
        <div id="calendar"></div>

        <div class="booking-form">
            <h3>Book this Chalet</h3>
            <form id="bookingForm" method="POST" action="bookChalet.php">
                <input type="hidden" name="chaletId" value="<?= htmlspecialchars($chaletId) ?>">
                <input type="date" name="bookingDate" required>
                <button type="submit">Book Now</button>
            </form>
        </div>
        </div>
    </div>
        
    </main>

    <!-- FullCalendar JS -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: 'fetchBookings.php?chaletId=<?= $chaletId ?>', // Fetch events from PHP script
                dateClick: function(info) {
                    // Handle date click
                    document.querySelector('input[name="bookingDate"]').value = info.dateStr;
                }
            });
            calendar.render();
        });
    </script>
</body>
</html>
