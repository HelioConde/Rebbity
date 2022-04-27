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

$id_client = $_SESSION['id'];
$name = $_POST['nameCategory'];

try {
    mysqli_query($conn, "INSERT INTO `category` (
        `id_client`,
        `name`,
        `type`
    ) VALUES (
        '$id_client',
        '$name',
        'main'
    )");

    echo '<script> window.location = "./index.html?pag=category"; </script>';
} catch(PDOException $ex) {
    echo'Erro'.$ex->getmessage();
}
?>