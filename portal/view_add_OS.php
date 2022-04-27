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

    $result = mysqli_query($conn, "SELECT * FROM `category` WHERE type='sub' AND id_client='".$_SESSION['id']."'");
    
    echo '<div style="overflow: auto; margin: 0;">';
    while($row = $result->fetch_assoc()) {
        $result2 = mysqli_query($conn, "SELECT * FROM `item` WHERE id_category='".$row['id']."'");
        echo '<div class="categoryBox">
        <div class="categoryGroupView borderButton">
            <h1 class="titleC">
                '.$row['name'].'
            </h1>
            <div class="categoryMenuControl1">
                <span class="angle-down">
                </span>
                <span class="categoryMenuControlHover">
                    <span class="bars-staggered">
                    </span>
                    <span class="subMainMenu2">
                        <span onmouseup="categorySubDel(`' .$row['id']. '`,`' .$row['name']. '`)">Remover</span>
                    </span>
                </span>
            </div>
        </div>
        <div class="parent">
                        <div class="categoryGroup2">
                            <div>
                            </div>
                            <div>
                            </div>
                            <div>
                                Item
                            </div>
                            <div>
                                Preço
                            </div>
                            <div>
                            </div>
                        </div>';
        while($row2 = $result2->fetch_assoc()) {
        echo    '
                        <div class="categoryGroup2">
                            <div>
                            </div>
                            <div>
                                <img src="'.$row2['img'].'" alt="">
                            </div>
                            <div class="categoryItem">
                                <span>
                                    '.$row2['name'].'
                                </span>
                                <span>
                                    '.$row2['description'].'
                                </span>
                            </div>
                            <div>
                                R$ '.$row2['sale'].'
                            </div>

                            <div class="categoryMenuControl2">
                                <span class="categoryMenuControlHover">
                                    <span class="bars-staggered">
                                    </span>
                                    <span class="subMainMenu2">
                                        <span onmouseup="categoryDelItem(`' .$row2['id']. '`,`' .$row2['name']. '`)">Remover</span>
                                    </span>
                                </span>
                            </div>
                        </div>
                ';
        }
        echo '<div class="categoryGroup2">
        <span class="categoryGroupButton">
            <button id="addItem" onmouseup="addNewItemCategory(`' .$row['id']. '`)" class="categoryButtonItem">
                + Adicionar item
            </button>
        </span>
        </div>
    </div></div>';
    }

    echo '</div>';
    echo    '<div class="newCategoryButton">
                <span class="newCategoryButtonCancel" onmouseup="closeWindow2()" >Cancelar</span>
            </div>';

    ?>