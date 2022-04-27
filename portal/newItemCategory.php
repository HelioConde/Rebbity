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

$path = $_FILES['imgInput2']['tmp_name'];
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

$id_client = $_SESSION['id'];
$newItemCategoryId = $_POST['newItemCategoryId'];
$newItemCategoryName  = $_POST['newItemCategoryName'];
$newItemCategorySale  = $_POST['newItemCategorySale'];
$newItemCategoryDescription  = $_POST['newItemCategoryDescription'];
$newItemCategoryPVD = $_POST['newItemCategoryPVD'];

mysqli_query($conn, "INSERT INTO `item` (
    `id_client`,
    `id_category`,
    `name`,
    `sale`,
    `description`,
    `PDV`,
    `img`
) VALUES (
    '$id_client',
    '$newItemCategoryId',
    '$newItemCategoryName',
    '$newItemCategorySale',
    '$newItemCategoryDescription',
    '$newItemCategoryPVD',
    '$base64'
)");

?>