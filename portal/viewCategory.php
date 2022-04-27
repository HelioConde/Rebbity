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

$result = mysqli_query($conn, "SELECT * FROM `category` WHERE type='main' AND id_client='". $_SESSION['id'] ."'");

if (!$result){
    echo '<script> window.location = "index.html?pag=acess"; </script>';
} else {

    while($row = $result->fetch_assoc()) {
        echo '<div class="categoryBox">
                <div class="categoryGroup borderButton">
                    <h1 onmouseup="categoryName(`' .$row['id']. '`,`' .$row['name']. '`)" class="titleC">
                    ' .$row['name']. '
                    </h1>
                    <div class="categoryControl">
                        <div>
                            <button class="categoryDisabled categoryButton categoryButton1">Pausar</button>
                        </div>
                        <div>
                            <button class="categoryActive categoryButton categoryButton2">Ativar</button>
                        </div>
                    </div>
                    <div class="categoryMenuControl">
                        <span class="angle-down">
                        </span>
                        <span class="categoryMenuControlHover">
                            <span class="bars-staggered">
                            </span>
                            <span class="subMainMenu2">
                                <div onmouseup="categoryDelItem(`' .$row['id']. '`,`' .$row['name']. '`)">Remover</div>
                            </span>
                        </span>
                    </div>
                </div>
                <div class="categoryGroup2 categoryGroup2Margin">
                    <span class="categoryGroupButton">
                        <button onmouseup="categoryItem(`' .$row['id']. '`,`' .$row['name']. '`)" class="categoryButtonItem">
                        <span class="plus">
                        </span>
                        <span>
                            Adicionar item
                        </span>
                        </button>
                    </span>
                </div>
            </div>';
    }
}
?>