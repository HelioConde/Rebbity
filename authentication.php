<?php
session_start();
include("./config.php");

$email = $_POST['email'];
$password = $_POST['password'];

$result = mysqli_query($conn, "SELECT * FROM `client` WHERE email='".$email."' LIMIT 1");

if (!$result){
    echo '<script> window.location = "acess.html"; </script>';
} else {
    if(mysqli_num_rows ($result) > 0 ){
        $member = mysqli_fetch_assoc($result);
        if (password_verify($password, $member['password']))
        {
            echo 'Logado';
        } else {
            echo 'Erro password';
        }
    } else {
        echo 'Erro email';
    }
}
?>