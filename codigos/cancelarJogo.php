<!DOCTYPE html>
<html lang="br" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Cancelar Jogos</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="pagestilo.css">
    <script>
        function cancelarVis(logado, partida){
            var requisicao = new XMLHttpRequest();
               requisicao.open("GET", "partidaCanceladaVis.php?idLogado=" + logado +"&codPartida="+partida, true);
               requisicao.send();
               requisicao.onreadystatechange = function() {
                   if (this.readyState == 4 && this.status == 200) {
                       if(this.responseText==0){
                        idJogo.innerHTML="Partida Cancelada";
                       }
                       if(this.responseText==1){

                          alert("erro");
                       }
                   }
               }
        }

        function cancelarMan(logado, partida){
            var requisicao = new XMLHttpRequest();
               requisicao.open("GET", "partidaCanceladaMan.php?idLogado=" + logado +"&codPartida="+partida, true);
               requisicao.send();
               requisicao.onreadystatechange = function() {
                   if (this.readyState == 4 && this.status == 200) {
                       if(this.responseText==0){
                        idJogo.innerHTML="Partida Cancelada";
                       }
                       if(this.responseText==1){

                          alert("erro");
                       }
                   }
               }
        }
    </script>
  </head>
  <body>
    <div class="container cancelarJogo text-center">
    <button><a href="principal.php?link=1&cance=1&cancelar=1&pagina=1">Cancelar jogos como mandante</a></button>
    <button><a href="principal.php?link=1&cance=1&cancelar=2&pagina=1">Cancelar jogos como visitante</a></button>
    </div>
<?php
// session_start();
// include "function.php";
// include "verificaLog.php";
$idLogado = $_SESSION['idLogado'];
$nomeEquipe = $_SESSION['equipeLogado'];
$categoria = $_SESSION['categoriaLogado'];
// $conexao = conectar();

if (isset($_GET['cancelar']) and ($_GET['cancelar'] == 1)) {
    $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
    if (isset($_GET['pagina']) and ($_GET['pagina'] < 1)) {
      header("location: principal.php?link=1&cance=1&cancelar=1&pagina=1");
    }
    if ($conexao) {
        $query = "select e1.nomeEquipe as 'Equipe 1', e2.nomeEquipe as 'Equipe 2',partida.codPartida, DATE_FORMAT(partida.DATA, '%d.%m.%y') as DATA, partida.hora, partida.local, e1.cidade
        FROM partida INNER JOIN equipe e1 ON partida.equipe1 = e1.codEquipe
        INNER JOIN equipe e2 ON partida.equipe2 = e2.codEquipe where e1.nomeEquipe = '$nomeEquipe'";
        $resultado = mysqli_query($conexao, $query);

        $total_jogos = mysqli_num_rows($resultado);
        $qtd_pg = 3;
        $num_pg = ceil($total_jogos/$qtd_pg);
        $inicio = ($qtd_pg*$pagina) - $qtd_pg;

        $query = "select e1.nomeEquipe as 'Equipe 1', e2.nomeEquipe as 'Equipe 2',partida.codPartida, DATE_FORMAT(partida.DATA, '%d.%m.%y') as DATA, partida.hora, partida.local, e1.cidade
        FROM partida INNER JOIN equipe e1 ON partida.equipe1 = e1.codEquipe
        INNER JOIN equipe e2 ON partida.equipe2 = e2.codEquipe where e1.nomeEquipe = '$nomeEquipe' limit $inicio, $qtd_pg";
        $resultado = mysqli_query($conexao, $query);
        $total_jogos = mysqli_num_rows($resultado);
        $contador = 0;

        if ($resultado) {
            while ($dados = mysqli_fetch_assoc($resultado)) {
                $idLogado = $_SESSION['idLogado'];
                $idPartida = $dados['codPartida'];
                $equipe1 = $dados['Equipe 1'];
                $equipe2 = $dados['Equipe 2'];
                $dia = $dados['DATA'];
                $hora = $dados['hora'];
                $local = $dados['local'];
                $cidade = $dados['cidade'];
                $contador++;
                $idJogo = "jogo" . $contador;

                echo "<table class='text-center tabelaJogos'>
                <tr>
                    <td rowspan = '3'>
                    <span id=$idJogo>$equipe1<br />
                    <button class='cancelarPartida' onclick=\"cancelarMan($idLogado, $idPartida);\">Cancelar</button>
                    <script>var idJogo=$idJogo</script></span>
                    </td>
                    <td rowspan = '3' class = 'tdx'>
                    X
                    </td>
                    <td rowspan = '3' id='ok'>
                      $equipe2
                    </td>
                    <td>
                    Dia: $dia <br /> Hora: $hora
                    </td>
                </tr>
                <tr>
                    <td>
                    Local: $local
                    </td>
                </tr>
                <tr>
                    <td>
                    Cidade: $cidade
                    </td>
                </tr>
                </table>";
                echo "<br />";
            }

            if (isset($_GET['pagina']) and (($_GET['pagina'] > $num_pg))) {
              header("location: principal.php?link=1&cance=1&cancelar=1&pagina=1");
            }

            $pagina_anterior = $pagina + 1;
            $pagina_posterior = $pagina - 1;
            ?>
                <nav aria-label="Page navigation example">
                <ul class="pagination paginacao">
                <li> <?php
                if ($pagina_posterior > 0) {
                if ($pagina_anterior != 0) { ?>
                <a href="principal.php?link=1&cance=1&cancelar=1&pagina=<?php echo $pagina_posterior;?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                </a>
                <?php } else{ ?>
                <span aria-hidden="true">&laquo;</span>
                <?php } }?>
                </li>

                <?php
                for ($i=1; $i < $num_pg; $i++) {?>
                <li>
                <a href="principal.php?link=1&cance=1&cancelar=1&pagina=<?php echo $i;?>"><?php echo $i;?></a>
                </li>

                <?php } ?>
                <li><?php
                if ($pagina_anterior <= $num_pg) {
                if ($pagina_posterior <= $num_pg + 1) { ?>
                <a href="principal.php?link=1&cance=1&cancelar=1&pagina=<?php echo $pagina_anterior;?>" aria-label="Previous">
                <span aria-hidden="true">&raquo;</span>
                </a>
                <?php } else{ ?>
                <span aria-hidden="true">&raquo;</span>
                <?php } }?>
                </li>
                </ul>
                </nav>
            <?php
        }
        mysqli_close($conexao);
    }
}

if (isset($_GET['cancelar']) and ($_GET['cancelar'] == 2)) {
  $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
  if (isset($_GET['pagina']) and ($_GET['pagina'] < 1)) {
    header("location: principal.php?link=1&cance=1&cancelar=2&pagina=1");
  }
  if ($conexao) {
      $query = "select e1.nomeEquipe as 'Equipe 1', e2.nomeEquipe as 'Equipe 2',partida.codPartida, DATE_FORMAT(partida.DATA, '%d.%m.%y') as DATA, partida.hora, partida.local, e1.cidade
      FROM partida INNER JOIN equipe e1 ON partida.equipe1 = e1.codEquipe
      INNER JOIN equipe e2 ON partida.equipe2 = e2.codEquipe where e2.nomeEquipe = '$nomeEquipe'";
      $resultado = mysqli_query($conexao, $query);

      $total_jogos = mysqli_num_rows($resultado);
      $qtd_pg = 3;
      $num_pg = ceil($total_jogos/$qtd_pg);
      $inicio = ($qtd_pg*$pagina) - $qtd_pg;

      $query = "select e1.nomeEquipe as 'Equipe 1', e2.nomeEquipe as 'Equipe 2',partida.codPartida, DATE_FORMAT(partida.DATA, '%d.%m.%y') as DATA, partida.hora, partida.local, e1.cidade
      FROM partida INNER JOIN equipe e1 ON partida.equipe1 = e1.codEquipe
      INNER JOIN equipe e2 ON partida.equipe2 = e2.codEquipe where e2.nomeEquipe = '$nomeEquipe' limit $inicio, $qtd_pg";
      $resultado = mysqli_query($conexao, $query);
      $total_jogos = mysqli_num_rows($resultado);
      $contador = 0;
      if ($resultado) {
          while ($dados = mysqli_fetch_assoc($resultado)) {
              $idLogado = $_SESSION['idLogado'];
              $idPartida = $dados['codPartida'];
              $equipe1 = $dados['Equipe 1'];
              $equipe2 = $dados['Equipe 2'];
              $dia = $dados['DATA'];
              $hora = $dados['hora'];
              $local = $dados['local'];
              $cidade = $dados['cidade'];
              $contador++;
              $idJogo="jogo" . $contador;


              echo "<table class='text-center tabelaJogos'>
              <tr>
                  <td rowspan = '3'>
                  $equipe1
                  </td>
                  <td rowspan = '3' class = 'tdx'>
                  X
                  </td>
                  <td rowspan = '3' id='ok'>
                  <span id=$idJogo>  $equipe2 <br />
                  <button class='cancelarPartida' onclick=\"cancelarVis($idLogado, $idPartida);\">Cancelar</button>
                  <script>var idJogo=$idJogo</script></span>

                  </td>
                  <td>
                  Dia: $dia <br /> Hora: $hora
                  </td>
              </tr>
              <tr>
                  <td>
                  Local: $local
                  </td>
              </tr>
              <tr>
                  <td>
                  Cidade: $cidade
                  </td>
              </tr>
              </table>";
              echo "<br />";
          }
          if (isset($_GET['pagina']) and (($_GET['pagina'] > $num_pg))) {
            header("location:principal.php?link=1&cance=1&cancelar=2&pagina=1");
          }

          $pagina_anterior = $pagina + 1;
          $pagina_posterior = $pagina - 1;
          ?>
              <nav aria-label="Page navigation example">
              <ul class="pagination paginacao">
              <li> <?php
              if ($pagina_posterior > 0) {
              if ($pagina_anterior != 0) { ?>
              <a href="principal.php?link=1&cance=1&cancelar=2&pagina=<?php echo $pagina_posterior;?>" aria-label="Previous">
              <span aria-hidden="true">&laquo;</span>
              </a>
              <?php } else{ ?>
              <span aria-hidden="true">&laquo;</span>
              <?php } }?>
              </li>

              <?php
              for ($i=1; $i < $num_pg; $i++) {?>
              <li>
              <a href="principal.php?link=1&cance=1&cancelar=2&pagina=<?php echo $i;?>"><?php echo $i;?></a>
              </li>

              <?php } ?>
              <li><?php
              if ($pagina_anterior <= $num_pg) {
              if ($pagina_posterior <= $num_pg + 1) { ?>
              <a href="principal.php?link=1&cance=1&cancelar=2&pagina=<?php echo $pagina_anterior;?>" aria-label="Previous">
              <span aria-hidden="true">&raquo;</span>
              </a>
              <?php } else{ ?>
              <span aria-hidden="true">&raquo;</span>
              <?php } }?>
              </li>
              </ul>
              </nav>
          <?php
      }
      mysqli_close($conexao);
  }
}
 ?>
</body>
</html>
