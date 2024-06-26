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
    
    $ownerId = $_SESSION["oid"];
    $chaletId = intval($_GET['id']);
    $conn = connectToDB();

    
    $chaletsResult = mysqli_query($conn, "SELECT 
    b.id, b.cid, b.cuid, b.booking_date, b.status, c.fname, c.lname, c.phone
    FROM bookings b JOIN customer c ON b.cuid = c.id
    WHERE b.cid = $chaletId; ");

    $bookings = [];
    while ($row = mysqli_fetch_assoc($chaletsResult)) {
        $bookings[] = $row;
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["booking_id"])) {
            $bookingId = intval($_POST["booking_id"]);
            if ($_POST["submit"] == "accept") {
                $status = "Accepted";
            } elseif ($_POST["submit"] == "decline") {
                $status = "Declined";
            } elseif ($_POST["submit"] == "cancel") {
                $status = "Canceled";
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
    <link rel="stylesheet" href="styles/chaletBookings.css">
    <title>Document</title>
</head>
<body>
    
<header>
        <div class="navbar">
            <span class="logo">Chalet Connect</span>
             <nav>
               <!-- <a href="#">already a partner?</a>
                <a id="myBtn" class="sign-in">Sign in</a>
                <button id="myBtn">Sign in</button> -->
                <!-- <a id="logOutBtn" onclick="ownerLogOut()" >Log out</a> -->
                <!-- <a href="?logout=true">Logout</a> -->
                
            </nav> 
        </div>
    </header>

    <div class="booking-grid">
        <?php foreach ($bookings as $booking): ?>
            <div class="booking">
                
                <div class="chalet-details">
                    
                    <p>Booking ID: <?= $booking['id'] ?></p>
                    <p>Booking Date: <?= $booking['booking_date'] ?></p>
                    <p>Customer Name: <?= $booking['fname'] ?> <?= $booking['lname'] ?></p>
                    <p>Customer Phone Number: <?= $booking['phone'] ?></p>
                    <p>Booking Status: <?= $booking['status'] ?></p>
                    
                    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>?id=<?= $chaletId ?>">
                    <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
                    <button type="submit" name="submit" value="accept">Accept</button>
                    <button type="submit" name="submit" value="decline">Decline</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
</body>
</html>