<?php
    include ("connection.php");
    session_start();

    // Check if user is logged in
    $isCustomerLoggedIn = isset($_SESSION["cid"]);
    



    $conn = connectToDB();
    
    //$result= mysqli_query($conn, "SELECT c.id, c.name, c.location, cp.url FROM chalet c LEFT JOIN chalet_pictures cp ON c.id = cp.cid GROUP BY c.id");
    $result = mysqli_query($conn, "SELECT c.id, c.name, c.location, cp.url FROM chalet c LEFT JOIN chalet_pictures cp ON c.id = cp.cid WHERE c.status = 'available' GROUP BY c.id");

    $chalets = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $chalets[] = $row;
        }
    closeDBconnection($conn);

    if (isset($_GET['logout'])) {
        logOut();
    }

    // /////// log in request /////////////

    if (isset($_POST["submit"]) && $_POST["submit"] == "login") {
        // Handle login
    $username = $_POST["username"];
    $password = $_POST["password"];
    $password = md5($password);
    

    // Retrieve user from the users table
    $result = logIn($username);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        if ($password == $row["password"]) {
            // Start session and set owner role
            //session_start();
            $_SESSION["cid"] = $row["id"];
            
          

            header("Location: index.php");
            // Redirect based on role
            // if ($row["rid"] == 1) {
            //     header("Location: librarianDashboard.php");
            // } else if($row["rid"] == 2) {
            //     header("Location: studentDashboard.php");
            // }
        } else {
            echo "Login failed! Incorrect password.";
        }
    } else {
        echo "Login failed! User not found.";
    }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Chalet Connect</title>
    <link rel="stylesheet" href="styles/styles.css">

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var isCustomerLoggedIn = <?= json_encode($isCustomerLoggedIn) ?>;
            if (isCustomerLoggedIn) {
                document.getElementById("myBtn").style.display = "none";
                document.getElementById("myProfileBtn").style.display = "inline-block";
                document.getElementById("logOutBtn").style.display = "inline-block";
            } else {
                document.getElementById("myBtn").style.display = "inline-block";
                document.getElementById("myProfileBtn").style.display = "none";
                document.getElementById("logOutBtn").style.display = "none";
                
            }
        });
    </script>

</head>
<body>
    <header>
        <div class="navbar">
            <span class="logo">Chalet Connect</span>
            <nav>
                
                <a href="ownerIndex.php">List your Chalet</a>
               
                <a href="signupPage.php">Register</a>
                
                <a id="myBtn" class="sign-in">Sign in</a>
                <a id="myProfileBtn" href="customerProfile.php" style="display: none;">My Profile</a>
                <a id="logOutBtn" href="?logout=true">Log out</a>
            </nav>
        </div>
    </header>

    <div class="center-photo">
        <img id="home-img" src="img/homepagephoto.jpg" alt="Homepage Photo">

    </div>
    <main>
        <!-- <div class="search-box">
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
        <button class="explore-btn">Explore Chalets</button> -->
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


    
    <!-- sign in modal -->
    <div id="myModal" class="modal">
        
    <div class="modal-content">
            <span class="close">&times;</span>
            <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                <h2>Sign in</h2>
                <input type="text" placeholder="Email or phone number" name="username" required>
                <input type="password" placeholder="Password" name="password" required>
                <div class="checkbox">
                    <input type="checkbox" id="terms">
                    <label for="terms">I agree to the terms and conditions</label>
                </div>
                <div class="checkbox">
                    <input type="checkbox" id="deals">
                    <label for="deals">Send me the latest deal alerts</label>
                </div>
                <button type="submit" class="btn" name="submit" value="login">Sign in</button>
                <p>or</p>
                <button type="button" class="btn google">Continue with Google</button>
            </form>
        </div>
    </div>

<script src="scripts/script2.js"></script>


</body>
</html>
