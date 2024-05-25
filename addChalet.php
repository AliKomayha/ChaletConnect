<?php

include ("connection.php");
session_start();

// Check the owner  log in
if (!isset($_SESSION["oid"])) {
    header("Location: ownerIndex.php");
    exit();
}

$conn=connectToDB();

// Fetch services 
$servicesResult = mysqli_query($conn, "SELECT id, name FROM services");
$services = [];
while ($row = mysqli_fetch_assoc($servicesResult)) {
    $services[] = $row;
}


$ownerId = $_SESSION["oid"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = isset($_POST["name"]) ? mysqli_real_escape_string($conn, $_POST["name"]) : '';
    $location = isset($_POST["location"]) ? mysqli_real_escape_string($conn, $_POST["location"]) : '';
    $description = isset($_POST["description"]) ? mysqli_real_escape_string($conn, $_POST["description"]) : '';
    $price = isset($_POST["price"]) ? mysqli_real_escape_string($conn, $_POST["price"]) : '';
    $capacity = isset($_POST["capacity"]) ? mysqli_real_escape_string($conn, $_POST["capacity"]) : '';
    $rooms = isset($_POST["rooms"]) ? mysqli_real_escape_string($conn, $_POST["rooms"]) : '';
    $services = isset($_POST['services']) ? $_POST['services'] : [];
    $ownerId = $_SESSION["oid"];

    if (empty($name) || empty($location) || empty($description) || empty($price) || empty($rooms)) {
        echo "Fields cannot be empty.";
    } else {
            
            $result=addChalet($name, $location, $description, $price, $capacity, $rooms, $services, $ownerId);
            if ($result) {
                echo "Chalet added successfully!";
                header("Location: ownerDash.php");
                exit();
            } else {
                echo "Error in adding chalet.";
            }
        }



}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Chalet</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 50%;
            margin: auto;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 10px;
        }
        input[type="text"], input[type="number"], textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }
        .checkbox-group {
            display: flex;
            flex-direction: column;
        }
        .checkbox-group div {
            margin-top: 5px;
        }
        input[type="submit"] {
            margin-top: 20px;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Create a New Chalet</h1>
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
            <label for="name">Chalet Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" required> in $

            <!-- <label for="owner_id">Owner ID:</label>
            <input type="number" id="owner_id" name="owner_id" required> -->

            <label for="capacity">Capacity:</label>
            <textarea id="capacity" name="capacity" required></textarea>

            <label for="rooms">Rooms:</label>
            <textarea id="rooms" name="rooms" required></textarea>

            <label>Services:</label>
            <div class="checkbox-group">
                <?php foreach ($services as $service): ?>
                    <div>
                        <input type="checkbox" name="services[]" value="<?= $service['id'] ?>"> <?= $service['name'] ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- status ??? -->

            <input type="submit" name="submit" value="Add Chalet">
        </form>
    </div>
</body>
</html>