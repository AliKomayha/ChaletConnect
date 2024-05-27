<?php
 include ("connection.php");

session_start();

if (!isset($_SESSION["oid"])) {
    header("Location: ownerIndex.php");
    exit();
}


 if (isset($_GET['logout'])) {
    ownerLogOut();
}


$ownerId = $_SESSION["oid"];
$conn = connectToDB();

// Fetch chalets owned by the logged-in owner
//$chaletsResult = mysqli_query($conn, "SELECT  c.id, c.name, c.location, cp.url, cp.main_image FROM chalet c LEFT JOIN chalet_pictures cp ON c.id = cp.cid WHERE c.oid = $ownerId");
$chaletsResult = mysqli_query($conn, "SELECT c.id, c.name, c.location, cp.url
    FROM chalet c 
    LEFT JOIN chalet_pictures cp ON c.id = cp.cid AND cp.main_image = 1
    WHERE c.oid = $ownerId");

$chalets = [];
while ($row = mysqli_fetch_assoc($chaletsResult)) {
    $chalets[] = $row;
}
closeDBconnection($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/ownerDash.css">
    <title>Document</title>

    <style>
       
    </style>
    
</head>
<body>
    <header>
        <div class="navbar">
            
            <span class="logo">Chalet Connect</span>
            <nav>
                <a href="#">already a partner?</a>
                <a id="myBtn" class="sign-in">Sign in</a>
                <!-- <button id="myBtn">Sign in</button> -->
                <!-- <a id="logOutBtn" onclick="ownerLogOut()" >Log out</a> -->
                <a href="?logout=true">Logout</a>
                
            </nav>
        </div>
    </header>
    <div class="add-chalet">
        <!-- <a href="addChalet.php" class="sign-in">Create new Chalet +</a> -->
        <button id="createChaletBtn" onclick="window.location.href='addChalet.php';">Create new Chalet +</button>
    </div>
    <main>

        <div class="chalet-grid">
        <?php foreach ($chalets as $chalet): ?>
            <div class="chalet">
                <img src="<?= $chalet['url'] ?>" alt="<?= $chalet['name'] ?>">
                
                <div class="chalet-details">
                    <h2><?= $chalet['name'] ?></h2>
                    <p><?= $chalet['location'] ?></p>
                    <a href="manageChalet.php?id=<?= $chalet['id'] ?>"><button>Manage Chalet info</button></a>
                    <a href="chaletBookings.php?id=<?= $chalet['id'] ?>"><button>View Bookings</button></a>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
        </main>
    




 
</body>
</html>