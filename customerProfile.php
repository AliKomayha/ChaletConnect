<?php
include("connection.php");

session_start();

    if (!isset($_SESSION["cid"])) {
        header("Location: index.php");
        exit();
    }
    
    $customerId = $_SESSION["cid"];
    $conn = connectToDB();

    $chaletsResult = mysqli_query($conn, "SELECT b.id, b.cid, b.cuid, b.booking_date, b.status, c.name, c.location
            FROM bookings b
            JOIN  chalet c ON b.cid = c.id
            WHERE b.cuid = $customerId; ");

    $bookings = [];
    while ($row = mysqli_fetch_assoc($chaletsResult)) {
        $bookings[] = $row;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo"meow";
        if (isset($_POST["booking_id"])) {
            $bookingId = intval($_POST["booking_id"]);
            if ($_POST["submit"] == "cancel") {
                $status = "Canceled by customer";
            } 
    
            $updateQuery = "UPDATE bookings SET status = '$status' WHERE id = $bookingId";
            if (mysqli_query($conn, $updateQuery)) {
                echo "Booking status updated successfully.";
            } else {
                echo "Error updating booking status: " . mysqli_error($conn);
            }
        }
    }
    
    closeDBconnection($conn);

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/customerProfile.css">
    <title>My Profile</title>
</head>
<body>

<h1>MY BOOKINGS</h1>
    

<div class="booking-grid">
        <?php foreach ($bookings as $booking): ?>
            <div class="booking">
                
                <div class="chalet-details">
                    <h2> <?= $booking['name'] ?></h2>
                    <p> <?= $booking['location'] ?></p>
                    <p>Booking ID: <?= $booking['id'] ?></p>
                    <p>Booking Date: <?= $booking['booking_date'] ?></p>
                    <p>Booking Status: <?= $booking['status'] ?></p>
                    
                    <form method="post" >
                    <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
                    <button type="submit" name="submit" value="cancel">Cancel Reservation</button>
                    </form>

                </div>
            </div>
        <?php endforeach; ?>
        </div>
</body>
</html>