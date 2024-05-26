<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in </title>
</head>
<body>
    

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

    
</body>
</html>