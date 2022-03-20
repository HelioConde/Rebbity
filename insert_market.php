<?php
include("config.php");

try {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone = $_POST['phone'];
    $cep = $_POST['cep'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $district = $_POST['district'];
    $address = $_POST['address'];
    $complement = $_POST['complement'];
    $corporateName = $_POST['corporateName'];
    $cnpj = $_POST['cnpj'];


    mysqli_query($conn, "INSERT INTO `client_market` (
        `name`,
        `email`,
        `password`,
        `phone`,
        `cep`,
        `city`,
        `state`,
        `district`,
        `address`,
        `complement`,
        `corporateName`,
        `cnpj`
    ) 
    VALUES (
        '$name',
        '$email',
        '$password',
        '$phone',
        '$cep',
        '$city',
        '$state',
        '$district',
        '$address',
        '$complement',
        '$corporateName',
        '$cnpj'
    )");


} catch(PDOException $ex) {
    echo'Erro'.$ex->getmessage();
}
?>