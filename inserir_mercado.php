<?php
include("conexao_teste.php");
try{
$nome = $_POST['nome'];
$email = $_POST['email'];
$tel = $_POST['tel'];
$senha = $_POST['senha'];
$sql = "INSERT INTO cliente_mercado(nome,tel,email,senha) values ('$nome','$tel','$email','$senha')";
$conn->query($sql);
echo "<a href='form_dados_mercado.php'><center><h1>ESTAMOS QUASE LA!<br> PARA CONCLUIR SEU CADASTRO COMPLETE SEUS DADOS<br>NECESSARIOS</h1></center></a>";
}catch(PDOException $ex){
    echo'Erro'.$ex->getmessage();
}
?>