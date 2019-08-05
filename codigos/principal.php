<!DOCTYPE html>
<html lang="br" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="pagestilo.css" rel="stylesheet">
  </head>
<body>

    <?php
          session_start();
      include_once "verificaLog.php";
      include "function.php";
      $conexao = conectar();
      // desconectar($conexao);
     ?>
<div class="fundo">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
                <div class="sair text-center">
                  <?php
                  echo $_SESSION['equipeLogado'];
                    ?>
                    <form class="" action="logout.php" method="post">
                      <input type="submit" class="sair" value="Sair">
                    </form>
          </div>
        </div>
        <div class="col-md-12 text-center">
          <nav class="menu">
            <ul>
                <li><a href="principal.php?link=1" class="active"><button value="">Jogos do seu time</button></a></li>
                <li><a href="principal.php?link=2" class="active"><button value="">Marcar partidas</button></a></li>
                <li><a href="principal.php?link=3" class="active"><button value="">Contato</button></a></li>
            </ul>
          </nav>
        </div>
              <div class="row">
                <div class="col-md-12 text-center">
                  <?php

                  if (!empty($_GET['link'])) {
                    $link = $_GET['link'];

                    switch($link){
                      case 1: include "jogosTime.php";
                      break;

                      case 2: include "marcarJogo.php";
                      break;

                      case 3: include "contato.php";
                      break;

                      default: break;
                    }
                  }
                      ?>

                </div>
              </div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
