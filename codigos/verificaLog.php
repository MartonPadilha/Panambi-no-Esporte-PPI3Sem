<?php
// session_start();
$idLogado = $_SESSION['idLogado'];
if (!$idLogado) {
  header("location: telaLogin.php");
  session_destroy();
  exit;
} ?>
