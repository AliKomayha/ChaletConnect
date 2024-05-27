<?php
    include ("connection.php");

    $conn = connectToDB();
    
    //$result= mysqli_query($conn, "SELECT c.id, c.name, c.location, cp.url, c.status FROM chalet c LEFT JOIN chalet_pictures cp ON c.id = cp.cid GROUP BY c.id");
    //$result = mysqli_query($conn, "SELECT c.id, c.name, c.location, cp.url FROM chalet c LEFT JOIN chalet_pictures cp ON c.id = cp.cid WHERE c.status = 'available' GROUP BY c.id");
    // $result = mysqli_query($conn, "SELECT c.id, c.name, c.location, cp.url, c.status, o.id AS owner_id, o.phone AS owner_phone, o.fname AS owner_fname, o.lname AS owner_lname 
    //                            FROM chalet c 
    //                            LEFT JOIN chalet_pictures cp ON c.id = cp.cid 
    //                            JOIN owner o ON c.oid = o.id 
                                
    //                            GROUP BY c.id");
    $result = mysqli_query($conn, "SELECT c.id, c.name, c.location, cp.url, c.status, o.id AS owner_id, o.phone AS owner_phone, o.fname AS owner_fname, o.lname AS owner_lname,
                               (SELECT COUNT(*) FROM bookings WHERE cid = c.id) AS booking_count
                               FROM chalet c 
                               LEFT JOIN chalet_pictures cp ON c.id = cp.cid 
                               JOIN owner o ON c.oid = o.id 
                               GROUP BY c.id");



    $chalets = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $chalets[] = $row;
        }




        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["chalet_id"])) {
                $chaletId = intval($_POST["chalet_id"]);
                if ($_POST["submit"] == "available") {
                    $status = "available";
                } elseif ($_POST["submit"] == "unavailable") {
                    $status = "unavailable";
                } 
        
                $updateQuery = "UPDATE chalet SET status = '$status' WHERE id = $chaletId";
                if (mysqli_query($conn, $updateQuery)) {
                    echo "Chalet status updated successfully.";
                } else {
                    echo "Error updating chalet status: " . mysqli_error($conn);
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
    <link rel="stylesheet" href="styles/admin.css">
    <title>Document</title>
</head>
<body>

    
<div class="chalet-grid">
            <?php foreach ($chalets as $chalet): ?>
                <div class="chalet-card">
                    <img src="<?= htmlspecialchars($chalet['url']) ?>" alt="Chalet Image">
                    <h2><?= htmlspecialchars($chalet['name']) ?></h2>
                    <p><?= htmlspecialchars($chalet['location']) ?></p>
                    <p><?= $chalet['owner_fname'] ?> <?= $chalet['owner_lname'] ?></p>
                    <p><?= $chalet['owner_phone'] ?></p>
                    <p>Total Bookings:<?= $chalet['booking_count'] ?></p>
                    <p>STATUS: <?= $chalet['status'] ?></p>
                    <button id="viewchalet" onclick="window.location.href='viewChalet.php?id=<?= htmlspecialchars($chalet['id']) ?>';">View Chalet</button>
                    <br><br>    
                    <form method="post" >
                    <input type="hidden" name="chalet_id" value="<?= $chalet['id'] ?>">
                    <button type="submit" name="submit" value="available">Set Available</button>
                    <button type="submit" name="submit" value="unavailable">Set Unavailable</button>
                    </form>
                </div>
            <?php endforeach; ?>
    </div>
    
</body>
</html>