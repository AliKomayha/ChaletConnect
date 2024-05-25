<?php
    include ("connection.php");
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
        <button class="explore-btn">Explore Chalets</button>
    </main>
</body>
</html>
