<?php

function connectToDB(){
    $conn = new mysqli("localhost", "root","","chalettest");
    if(!$conn){
        die("connection failed ".mysqli_error($conn));
    }
    return $conn;
}


function closeDBconnection($conn) {
    mysqli_close($conn);
}

/// TO BE EDITED 
function logIn($username){
    $conn= connectToDB();
    $sql="SELECT Users.id, username, password, rid FROM Account, Users, Userroles 
            WHERE account.uid = Users.id
            AND Users.id= Userroles.uid 
            AND Account.username = '$username';";
    $result=mysqli_query($conn,$sql);
    closeDBconnection($conn);
    return $result;

}
function ownerLogIn($username){
    $conn= connectToDB();
    $sql="SELECT owner.id, username, password FROM oaccount, owner 
            WHERE oaccount.oid = owner.id
             AND oaccount.username = '$username';";
    $result=mysqli_query($conn,$sql);
    closeDBconnection($conn);
    return $result;

}
function ownerLogOut()
{
    session_start();
    session_destroy();
    header("Location: ownerIndex.php");
    exit;
}


function signUP($email, $fname, $lname, $phone, $username, $password){ 
        $conn= connectToDB();
        $sql=" INSERT INTO `customer` (`fname`, `lname`, `email`, `phone`) VALUES
        ( '$fname', '$lname', '$email', '$phone');
        SET @userId = LAST_INSERT_ID();
        INSERT INTO `caccount` (`username`, `password`, `cid`) VALUES
        ('$username', '$password', @userId); ";

        $result=mysqli_multi_query($conn,$sql);
        closeDBconnection($conn);
        return $result;
        redirectToLogInPage();

}

function ownerSignUP($email, $fname, $lname, $phone, $username, $password){ 
    $conn= connectToDB();
    $sql=" INSERT INTO `owner` (`fname`, `lname`, `email`, `phone`) VALUES
    ( '$fname', '$lname', '$email', '$phone');
    SET @userId = LAST_INSERT_ID();
    INSERT INTO `oaccount` (`username`, `password`, `oid`) VALUES
    ('$username', '$password', @userId); ";

    $result=mysqli_multi_query($conn,$sql);
    closeDBconnection($conn);
    return $result;
    redirectToOwnerPage();

}

function redirectToLogInPage(){
    header("Location: index.php");
    exit();
}
function redirectToOwnerPage(){
    header("Location: ownerDash.php");
    exit();
}


// function addChalet($name, $location, $description, $price, $capacity, $rooms, $services, $ownerId){
//     $conn=connectToDB();
//     $sql="INSERT INTO 'chalet'('name', 'location', 'description', 'price', 'capacity', 'rooms','ownerId')
//             VALUES ('$name', '$location', '$description', '$price', '$capacity', '$rooms','$ownerId');
//             SET @cid = LAST_INSERT_ID();
//             INSERT INTO 'chalet_services'()
//             ";

//     $result=mysqli_multi_query($conn,$sql);
//     closeDBconnection($conn);
     
// }

function addChalet($name, $location, $description, $price, $capacity, $rooms, $services, $ownerId){
    $conn = connectToDB();
    
    // Prepare the chalet insert statement
    $stmt = $conn->prepare("INSERT INTO chalet (name, location, description, price, capacity, rooms, oid) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiiii", $name, $location, $description, $price, $capacity, $rooms, $ownerId);
    
    if ($stmt->execute()) {
        // Get the last inserted chalet ID
        $chaletId = $stmt->insert_id;
        $stmt->close();
        
        // Prepare the chalet_services insert statement
        $stmtService = $conn->prepare("INSERT INTO chalet_services (cid, sid) VALUES (?, ?)");
        $stmtService->bind_param("ii", $chaletId, $serviceId);
        
        // Insert each selected service for the chalet
        foreach ($services as $serviceId) {
            $stmtService->execute();
        }
        $stmtService->close();
        
        closeDBconnection($conn);
        return true;
    } else {
        closeDBconnection($conn);
        return false;
    }
}

function getChalet($cid){
    $conn= connectToDB();
    $sql="SELECT "; 


}
?>