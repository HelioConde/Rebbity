<?php
include("conexao_teste.php");
try{
$nome = $_POST['nome'];
$tel = $_POST['tel'];
$email = $_POST['email'];
$senha = $_POST['senha'];


$sql = "INSERT INTO cliente_restaurante(nome,tel,email,senha)
 values ('$nome','$tel','$email','$senha')";
$conn->query($sql); 
echo "<a href='/lucas/testando/form_dados_restaurante.php'><center><h1>ESTAMOS QUASE LA!<br> PARA CONCLUIR SEU CADASTRO COMPLETE SEUS DADOS<br>NECESSARIOS</h1></center></a>";
}catch(PDOException $ex){
  
    echo'Erro'.$ex->getmessage();
    
}
?> 
</form>