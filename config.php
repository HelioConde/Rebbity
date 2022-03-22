<?php
    $servidor = "localhost";
    $usuario = "u695741578_rebbity";
    $senha = "uY9YWlrv6emf5@JP!I*l%#pN";
    $dbname = "u695741578_rebbity";
    //ftp 6g^aBqwK&J9g#O#Ac!wnmGqZ


    $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
    mysqli_set_charset($conn,"utf8");
    
    if(!$conn){
        die("Falha na conexao: " . mysqli_connect_error());
    }else{
    } 
?> 