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
$editNameSubCategory = $_POST['editNameSubCategory'];
$SubCategoryName = $_POST['itemName'];
$subCategoryRange = $_POST['subCategoryRange'];
$SubCategoryRangeMin = $_POST['subCategoryRange1'];
$SubCategoryRangeMax = $_POST['subCategoryRange2'];
$SubCategorySale = $_POST['itemSale'];
$SubCategoryDescription = $_POST['Description'];
$SubCategoryPDV = $_POST['PVD'];

try {
    mysqli_query($conn, "INSERT INTO `category` (
        `id_client`,
        `name`,
        `type`,
        `ranger`,
        `rangeMin`,
        `rangeMax`
    ) VALUES (
        '$id_client',
        '$editNameSubCategory',
        'sub',
        '$subCategoryRange',
        '$SubCategoryRangeMin',
        '$SubCategoryRangeMax'
    )");

    $path = $_FILES['imgInput2']['tmp_name'];
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    $categoryId = mysqli_insert_id($conn);
    echo $categoryId;

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
        '". $categoryId ."',
        '$SubCategoryName',
        '$SubCategorySale',
        '$SubCategoryDescription',
        '$SubCategoryPDV',
        '$base64'
    )");

} catch(PDOException $ex) {
    echo'Erro'.$ex->getmessage();
}

?>