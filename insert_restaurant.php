<?php
include("config.php");

try {
    $name = $_POST['name'];
    $password;
    $email;

    if($_POST['email'] == $_POST['email2']){
        $email = $_POST['email'];
    } else {
        echo '<script> window.location = "form-restaurant.html"; </script>';
    }

    if($_POST['password'] == $_POST['password2']){
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    } else {
        echo '<script> window.location = "form-restaurant.html"; </script>';
    }

    $phone = $_POST['phone'];
    $cep = $_POST['cep'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $district = $_POST['district'];
    $address = $_POST['address'];
    $complement = $_POST['complement'];
    $corporateName = $_POST['corporateName'];
    $cnpj = $_POST['cnpj'];

    $result = mysqli_query($conn, "SELECT * FROM `client` WHERE email='".  $email ."' LIMIT 1");
    $result2 = mysqli_query($conn, "SELECT * FROM `client` WHERE cnpj='".  $cnpj ."' LIMIT 1");


    if (!$result){
        echo '<script> window.location = "form-restaurant.html"; </script>';
    } else {
        if(mysqli_num_rows ($result2) == 0 ){
            if(mysqli_num_rows ($result) == 0 ){
                mysqli_query($conn, "INSERT INTO `client` (
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
                    `cnpj`,
                    `typeTable`
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
                    '$cnpj',
                    'restaurant'
                )");
                echo '<script> window.location = "finish.html?cadastrado=sucess"; </script>';
            } else {
                echo '<script> window.location = "form-restaurant.html?erro=email"; </script>';
            }
        } else {
            echo '<script> window.location = "form-restaurant.html?erro=cnpj"; </script>';
        }
    }

} catch(PDOException $ex) {
    echo'Erro'.$ex->getmessage();
}
?>