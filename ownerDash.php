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
$chaletsResult = mysqli_query($conn, "SELECT c.id, c.name, c.location, cp.url FROM chalet c LEFT JOIN chalet_pictures cp ON c.id = cp.cid WHERE c.oid = $ownerId");
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
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: auto;
        }
        .chalet {
            border: 1px solid #ddd;
            padding: 15px;
            margin-top: 10px;
            display: flex;
            align-items: center;
        }
        .chalet img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            margin-right: 20px;
        }
        .chalet-details {
            flex-grow: 1;
        }
        .chalet-details h2 {
            margin: 0;
        }
        .chalet-details button {
            margin-top: 10px;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .add-chalet {
            margin: 20px 0;
        }
    </style>
    
</head>
<body>
    <header>
        <div class="navbar">
            <span class="logo"><a href="index.php">Chalet Connect</a></span>
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

    <?php foreach ($chalets as $chalet): ?>
            <div class="chalet">
                <img src="<?= $chalet['url'] ?>" alt="<?= $chalet['name'] ?>">
                <div class="chalet-details">
                    <h2><?= $chalet['name'] ?></h2>
                    <p><?= $chalet['location'] ?></p>
                    <a href="viewChalet.php?id=<?= $chalet['id'] ?>"><button>View Chalet</button></a>
                </div>
            </div>
        <?php endforeach; ?>




 
</body>
</html>