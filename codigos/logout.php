<?php
session_start();
$idLogado = $_SESSION['idLogado'];
unset($idLogado);
header("location: telaLogin.php");
session_destroy();
exit;
 ?>
