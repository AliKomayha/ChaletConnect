<?php
 include ("connection.php");


 if (isset($_GET['logout'])) {
    ownerLogOut();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/ownerDash.css">
    <title>Document</title>
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
    <!-- <a href="addChalet.php" class="sign-in">Create new Chalet +</a> -->
    <button id="createChaletBtn" onclick="window.location.href='addChalet.php';">Create new Chalet +</button>


 
</body>
</html>