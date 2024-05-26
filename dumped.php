<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($chalet['name']) ?></title>
    <link rel="stylesheet" href="styles/viewChalet.css">
    <!-- FullCalendar CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css' rel='stylesheet' />
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #f8f8f8;
        }
        .navbar .logo {
            font-size: 24px;
        }
        .navbar nav a {
            margin-left: 20px;
            text-decoration: none;
            color: black;
        }
        .navbar .sign-in {
            padding: 5px 15px;
            background-color: green;
            color: white;
            border: none;
            border-radius: 5px;
        }
        .chalet-details {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .chalet-main {
            display: flex;
            align-items: center;
        }
        .chalet-main img {
            max-width: 300px;
            border-radius: 10px;
            margin-right: 20px;
        }
        .chalet-main div {
            flex: 1;
        }
        .chalet-images {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }
        .chalet-images img {
            width: calc(33.333% - 10px);
            max-width: 200px;
            border-radius: 10px;
        }
        .chalet-details p {
            margin: 10px 0;
        }
        .services-list {
            list-style-type: none;
            padding: 0;
        }
        .services-list li {
            background-color: #f0f0f0;
            padding: 8px;
            margin: 5px 0;
            border-radius: 5px;
        }
        #calendar {
            max-width: 800px;
            margin: 20px auto;
        }
        .booking-form {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .booking-form input[type="date"] {
            margin: 10px 0;
            padding: 10px;
            width: calc(100% - 22px);
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .booking-form button {
            padding: 10px 20px;
            background-color: green;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
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
