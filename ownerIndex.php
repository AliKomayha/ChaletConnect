<!-- 
    add address option to form && request && query
 -->



 <?php
include ("connection.php");

$conn=connectToDB();

 function escapehtmlchars($input)
 {
     return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
 }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //echo"hello1";
    if (isset($_POST["submit"]) && $_POST["submit"] == "signup") {
        //echo"hello2";
    $fname = isset($_POST["fname"]) ? mysqli_real_escape_string($conn, $_POST["fname"]) : '';
    $lname = isset($_POST["lname"]) ? mysqli_real_escape_string($conn, $_POST["lname"]) : '';
    $phone = isset($_POST["phone"]) ? mysqli_real_escape_string($conn, $_POST["phone"]) : '';
    $email = isset($_POST["email"]) ? mysqli_real_escape_string($conn, $_POST["email"]) : '';
    //$address = isset($_POST["address"]) ? mysqli_real_escape_string($conn, $_POST["address"]) : '';
    $username = isset($_POST["username"]) ? mysqli_real_escape_string($conn, $_POST["username"]) : '';
    $password = isset($_POST["password"]) ? mysqli_real_escape_string($conn, $_POST["password"]) : '';
    // $rid = isset($_POST["rid"]) ? mysqli_real_escape_string($conn, $_POST["rid"]) : '';

    // Security feature: Escape HTML characters
    $username = escapehtmlchars($username);
    $password = escapehtmlchars($password);
    

    // Security feature: Limit username and password length to 20 characters
    $fname = substr($fname, 0, 20);
    $lname = substr($lname, 0, 20);
    $phone = substr($phone, 0, 8);
    $email = substr($email, 0, 40);
    $username = substr($username, 0, 20);
    $password = substr($password, 0, 20);
    $password = md5($password);

    // Security feature: Ensure username and password are not empty
    if (empty($username) || empty($password)) {
        echo "Username and password cannot be empty.";
    } else {
            // Insert user into the users table
            $result=ownerSignUP($email, $fname, $lname, $phone, $username, $password);
            if ($result) {
                echo "Registration successful!";
                redirectToLogInPage();
            } else {
                echo "Error in registration " . mysqli_error($conn);
            }
        }
    }
    /// log in request ////////////////////////////////////////////////////////////////////////////
    elseif (isset($_POST["submit"]) && $_POST["submit"] == "login") {
        // Handle login
    $username = $_POST["username"];
    $password = $_POST["password"];
    $password = md5($password);
    

    // Retrieve user from the users table
    $result = ownerLogIn($username);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        if ($password == $row["password"]) {
            // Start session and set owner role
            session_start();
            $_SESSION["oid"] = $row["id"];
          

            header("Location: ownerDash.php");
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
}
closeDBconnection($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Chalet Connect</title>
    <link rel="stylesheet" href="styles/ownerIndex.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">

</head>

    <header>
        <div class="navbar">
            
            <span class="logo"><a href="index.php">Chalet Connect</a></span>
            <nav>
                <a href="#">already a partner?</a>
                <a id="myBtn" class="sign-in">Sign in</a>
                <!-- <button id="myBtn">Sign in</button> -->
                <a href="#">help</a>
                
            </nav>
        </div>
    </header>
 
    <div class="container mt-5">
    <!-- Sign up form -->
    <div class="row">
        <div class="col-md-6">
    
            <div class="container">
                <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                <h2>Become a partner:</h2>
                <br>
                <div class="input-group">
                    <input id="email" type="email" class="form-control" name="email" placeholder="Email">
                </div>
                <div class="input-group mt-2">
                    <input id="fname" type="text" class="form-control" name="fname" placeholder="First name">
                    <input id="lname" type="text" class="form-control" name="lname" placeholder="Last name">
                </div>
                <div class="input-group mt-2">
                    <input id="phone" type="phone" class="form-control" name="phone" placeholder="Phone number">
                </div>

                <div class="input-group mt-4">
                    <input id="username" type="text" class="form-control" name="username" placeholder="Username">
                </div>
                <div class="input-group mt-2">
                    <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                </div>
                <div class="mt-2">
                    <button class="btn btn-secondary text-center" type="submit" name="submit" value="signup">Sign Up</button>
                </div>    
                </form>
            </div>

        </div>
    </div>
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

<script src="scripts/script.js"></script>



</body>
</html>
