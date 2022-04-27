<?php
session_start();
include("../config.php");

if(empty($_SESSION['token'])){
    echo '<script> window.location = "../"; </script>';
}

$result = mysqli_query($conn, "SELECT * FROM `client` WHERE id='". $_SESSION['id'] ."' LIMIT 1");

if (!$result){
} else {
    if(mysqli_num_rows ($result) > 0 ){
        $member = mysqli_fetch_assoc($result);
        if($member['token'] == $_SESSION['token']){
        } else {
            echo '<script> window.location = "../; </script>';
        }
    } else {
        echo '<script> window.location = "../; </script>';
    }
}

echo $_POST['editNameCategoryID'];
echo $_POST['editNameCategory'];

mysqli_query($conn, "UPDATE category SET name='".$_POST['editNameCategory']."' WHERE id=".$_POST['editNameCategoryID']."");

?>