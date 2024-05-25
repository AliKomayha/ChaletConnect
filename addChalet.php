<?php
// connectToDB and closeDBconnection functions here or include them from an external file
include ("connection.php");

$conn=connectToDB();

// Fetch services to display as checkboxes

$servicesResult = mysqli_query($conn, "SELECT id, name FROM services");
$services = [];
while ($row = mysqli_fetch_assoc($servicesResult)) {
    $services[] = $row;
}
closeDBconnection($conn);
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
        <form action="addChalet.php" method="post">
            <label for="name">Chalet Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" required>

            <!-- <label for="owner_id">Owner ID:</label>
            <input type="number" id="owner_id" name="owner_id" required> -->

            <label>Services:</label>
            <div class="checkbox-group">
                <?php foreach ($services as $service): ?>
                    <div>
                        <input type="checkbox" name="services[]" value="<?= $service['id'] ?>"> <?= $service['name'] ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <input type="submit" value="Add Chalet">
        </form>
    </div>
</body>
</html>