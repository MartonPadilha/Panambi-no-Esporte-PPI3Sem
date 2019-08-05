<?php
include 'function.php';
if (isset($_POST['email']) and (isset($_POST['senha']))) {
  $email = $_POST['email'];
  $senha = $_POST['senha'];

  $conexao = conectar();

  if($conexao){
        if(loginComNomeEquipe($email, $senha, $conexao)){
        }
  else {
  }
}}


 ?>
