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


function createChalet(){
    $conn=connectToDB();
    $sql="INSERT INTO ''('','','','','',)VALUES ('','','','',)";

    $result=mysqli_query($conn,$sql);
    closeDBconnection($conn);
     
}

function getChalet($cid){
    $conn= connectToDB();
    $sql="SELECT "; 


}
?>