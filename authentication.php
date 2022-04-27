<?php
session_start();
include("./config.php");

$email = $_POST['email'];
$password = $_POST['password'];

$resultToken = "";


$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
$count = mb_strlen($chars);

for ($i = 0; $i < 64; $i++) {
    $index = Rand(0, $count - 1);
    $resultToken .= mb_substr($chars, $index, 1);
}

$result = mysqli_query($conn, "SELECT * FROM `client` WHERE email='".$email."' LIMIT 1");

if (!$result){
    echo '<script> window.location = "index.html?pag=acess"; </script>';
} else {
    if(mysqli_num_rows ($result) > 0 ){
        $member = mysqli_fetch_assoc($result);
        if (password_verify($password, $member['password']))
        {
            $_SESSION['id'] = $member['id'];
            $_SESSION['token'] = $resultToken;
            if($member['block'] == "true"){
                echo '<script> window.location = "index.html?pag=acess&erro=analise"; </script>';
            } else {
                mysqli_query($conn, "UPDATE `client` SET `token`='".$resultToken."' WHERE id='".$member['id']."'");
                echo '<script> window.location = "./portal/index.html"; </script>';
            }
        } else {
            echo '<script> window.location = "index.html?pag=acess&erro=password"; </script>';
        }
    } else {
        echo '<script> window.location = "index.html?pag=acess&erro=email"; </script>';
    }
}
?>