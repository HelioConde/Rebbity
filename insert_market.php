<?php
include("config.php");

try {

    function block(){
        echo '<script> window.location = "./index.html?pag=form-market"; </script>';
        return;
    }

    $name = $_POST['name'];
    $email;
    $password;
    $phone = $_POST['phone'];
    $cep = $_POST['cep'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $district = $_POST['district'];
    $address = $_POST['address'];
    $complement = $_POST['complement'];
    $class = $_POST['class'];
    $corporateName = $_POST['corporateName'];
    $cnpj = $_POST['cnpj'];
    $porpName = $_POST['porpName'];
    $cpf = $_POST['cpf'];

    if($_POST['email'] == $_POST['email2']){
        $email = $_POST['email'];
    } else {
        echo 'Erro E-mail';
        return;
        block();
    }

    if($_POST['password'] == $_POST['password2']){
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    } else {
        echo 'Erro Senha';
        return;
        block();
    }

    if ($name == ""){
        echo 'Erro Name';
        return;
        block();
    }

    if ($email == ""){
        echo 'Erro E-mail';
        return;
        block();
    }

    if ($password == ""){
        echo 'Erro Senha';
        return;
        block();
    }

    if ($phone == ""){
        echo 'Erro Telefone';
        return;
        block();
    }

    if ($cep == ""){
        echo 'Erro Cep';
        return;
        block();
    }

    if ($city == ""){
        echo 'Erro Cidade';
        return;
        block();
    }

    if ($state == ""){
        echo 'Erro Estado';
        return;
        block();
    }

    if ($district == ""){
        echo 'Erro Bairro';
        return;
        block();
    }

    if ($address == ""){
        echo 'Erro Endereço';
        return;
        block();
    }

    if ($corporateName == ""){
        echo 'Erro Nome2';
        return;
        block();
    }

    if ($cnpj == ""){
        echo 'Erro CNPJ';
        return;
        block();
    }
    

    $result = mysqli_query($conn, "SELECT * FROM `client` WHERE email='".  $email ."' LIMIT 1");
    $result2 = mysqli_query($conn, "SELECT * FROM `client` WHERE cnpj='".  $cnpj ."' LIMIT 1");


    if (!$result){
        echo '<script> window.location = "./index.html?pag=form-market"; </script>';
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
                    `class`,
                    `complement`,
                    `corporateName`,
                    `cnpj`,
                    `porpName`,
                    `cpf`,
                    `typeTable`,
                    `token`
                ) VALUES (
                    '$name',
                    '$email',
                    '$password',
                    '$phone',
                    '$cep',
                    '$city',
                    '$state',
                    '$district',
                    '$address',
                    '$class',
                    '$complement',
                    '$corporateName',
                    '$cnpj',
                    '$porpName',
                    '$cpf',
                    'market',
                    '0'
                )");

                echo '<script> window.location = "./index.html?pag=finish&cadastrado=sucess"; </script>';
            } else {
                echo '<script> window.location = "./index.html?pag=form-market&erro=email"; </script>';
            }
        } else {
            echo '<script> window.location = "./index.html?pag=form-market&erro=cnpj"; </script>';
        }
    }

} catch(PDOException $ex) {
    echo'Erro'.$ex->getmessage();
}
?>