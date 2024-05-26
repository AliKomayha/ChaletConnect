<?php
    include ("connection.php");

    $conn = connectToDB();
    
    $result= mysqli_query($conn, "SELECT c.id, c.name, c.location, cp.url FROM chalet c LEFT JOIN chalet_pictures cp ON c.id = cp.cid GROUP BY c.id");
    $chalets = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $chalets[] = $row;
        }
    closeDBconnection($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Chalet Connect</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <header>
        <div class="navbar">
            <span class="logo">Chalet Connect</span>
            <nav>
                <a href="#">list item</a>
                <a href="ownerIndex.php">List your Chalet</a>
                <a href="signupPage.php">Register</a>
                <a href="#" class="sign-in">Sign in</a>
            </nav>
        </div>
    </header>

    <div class="center-photo">
        <img id="home-img" src="img/homepagephoto.jpg" alt="Homepage Photo">

    </div>
    <main>
        <div class="search-box">
            <input type="text" placeholder="Area?">
            <input type="text" placeholder="Price?">
            <input type="date">
            <select>
                <option>1 adult</option>
                <option>2 adults</option>
                <option>3 adults</option>
            </select>
            <button>Search</button>
        </div>
        <!-- <button class="explore-btn">Explore Chalets</button> -->
    </main>

    <div class="chalet-grid">
            <?php foreach ($chalets as $chalet): ?>
                <div class="chalet-card">
                    <img src="<?= htmlspecialchars($chalet['url']) ?>" alt="Chalet Image">
                    <h2><?= htmlspecialchars($chalet['name']) ?></h2>
                    <p><?= htmlspecialchars($chalet['location']) ?></p>
                    <button id="viewchalet" onclick="window.location.href='viewChalet.php?id=<?= htmlspecialchars($chalet['id']) ?>';">View Chalet</button>
                </div>
            <?php endforeach; ?>
    </div>



</body>
</html>
