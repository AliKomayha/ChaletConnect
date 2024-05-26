<?php
session_start();
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['chaletId'], $_POST['bookingDate'])) {
    $chaletId = intval($_POST['chaletId']);
    $bookingDate = $_POST['bookingDate'];
    
    // Assume user is logged in and their ID is stored in the session
    if (isset($_SESSION['cid'])) {
        $customerId = intval($_SESSION['cid']);
    } else {
        echo "You need to be logged in to make a booking.";
        exit;
    }

    $conn = connectToDB();

    // Insert booking
    $stmt = $conn->prepare("INSERT INTO bookings (cid, cuid, booking_date, status) VALUES (?, ?, ?, 'Pending')");
    $stmt->bind_param("iis", $chaletId, $customerId, $bookingDate);

    if ($stmt->execute()) {
        echo "Booking request sent.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    closeDBconnection($conn);
} else {
    echo "Invalid request.";
    exit;
}
?>
