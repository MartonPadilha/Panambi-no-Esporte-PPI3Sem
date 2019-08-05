<!DOCTYPE html>
<html lang="br" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="pagestilo.css">
  </head>
  <body>

    <div class="container">
      <div class="row">
          <div class="col-md-12">

            <form class="jogosTime" method="post" action="principal.php?link=1">
              <div class="form-group">
                  <p>Pesquise os jogos por data...</p>
                  <label for="iddata">Data:</label>
                  <input type="date" class="text-center" id="iddata" name="dataJogo">
                  <button type="submit" name="button">Pesquisar</button>
                  <button><a href="principal.php?link=1&cance=1">Cancelar Jogos</a></button>
              </div>
            </form>
          </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <?php
      header("content-type: text/html;charset=utf-8");
      $nomeEquipe = $_SESSION['equipeLogado'];
      include_once "function.php";
      $conexao = conectar();
          if (isset($_GET['cance']) and ($_GET['cance'] == 1)) {
            include "cancelarJogo.php";
          }
          else{
          if (isset($_POST['dataJogo']) and !empty($_POST['dataJogo'])){
              $dataJogo = $_POST['dataJogo'];
              $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

                  if ($conexao) {
                    $query = "select e1.nomeEquipe as 'Equipe 1', e2.nomeEquipe as 'Equipe 2', partida.DATA, partida.hora, partida.local, e1.cidade
                    FROM partida INNER join equipe e1 ON partida.equipe1 = e1.codEquipe
                    INNER JOIN equipe e2 ON partida.equipe2 = e2.codEquipe where partida.data = '$dataJogo' and (e1.nomeEquipe = '$nomeEquipe' or e2.nomeEquipe = '$nomeEquipe')";
                    $query_tratada = mysqli_prepare($conexao, $query);
                        if ($query_tratada) {
                          mysqli_stmt_execute($query_tratada);
                          mysqli_stmt_bind_result($query_tratada, $equipe1, $equipe2, $data, $hora, $local, $cidade);
                          mysqli_stmt_store_result($query_tratada);

                          while (mysqli_stmt_fetch($query_tratada)) {
                            printf("
                            <table class='text-center tabelaJogos'>
                            <tr>
                                <td rowspan = '3'>
                                %s
                                </td>
                                <td rowspan = '3' class = 'tdx'>
                                X
                                </td>
                                <td rowspan = '3'>
                                %s
                                </td>
                                <td>
                                Dia: %s <br /> Hora: %s
                                </td>
                            </tr>
                            <tr>
                                <td>
                                Local: %s
                                </td>
                            </tr>
                            <tr>
                                <td>
                                Cidade: %s
                                </td>
                            </tr>
                            </table>",
                            $equipe1, $equipe2, $data, $hora, $local, $cidade);

                            echo "<br />";}
                          mysqli_stmt_close($query_tratada);
                          mysqli_close($conexao);
                        }
                  }
                  else {
                    echo "2";
                  }
                }

              else{

                if (empty($_POST['dataJogo'])) {
                  $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
                  // if (isset($_GET['pagina']) and ($_GET['pagina'] < 1)) {
                  //   header("location: principal.php?link=1&pagina=1");
                  // }

                    if ($conexao) {
                      $query = "select e1.nomeEquipe as 'Equipe 1', e2.nomeEquipe as 'Equipe 2', DATE_FORMAT(partida.DATA, '%d.%m.%y'), partida.hora, partida.local, e1.cidade
                      FROM partida INNER join equipe e1 ON partida.equipe1 = e1.codEquipe
                      INNER JOIN equipe e2 ON partida.equipe2 = e2.codEquipe where e1.nomeEquipe = '$nomeEquipe' or e2.nomeEquipe = '$nomeEquipe'";
                      $resultado_query = mysqli_query($conexao, $query);
                      $total_jogos = mysqli_num_rows($resultado_query);
                      $qtd_pg = 3;
                      $num_pg = ceil($total_jogos/$qtd_pg);
                      $inicio = ($qtd_pg*$pagina) - $qtd_pg;

                      $query = "select e1.nomeEquipe as 'Equipe 1', e2.nomeEquipe as 'Equipe 2', DATE_FORMAT(partida.DATA, '%d.%m.%y'), partida.hora, partida.local, e1.cidade
                      FROM partida INNER join equipe e1 ON partida.equipe1 = e1.codEquipe
                      INNER JOIN equipe e2 ON partida.equipe2 = e2.codEquipe
                      where e1.nomeEquipe = '$nomeEquipe' or e2.nomeEquipe = '$nomeEquipe' order by partida.DATA desc limit $inicio, $qtd_pg";

                      $query_tratada = mysqli_prepare($conexao, $query);
                      $total_jogos = mysqli_stmt_num_rows($query_tratada);

                          if ($query_tratada) {
                            mysqli_stmt_execute($query_tratada);
                            mysqli_stmt_bind_result($query_tratada, $equipe1, $equipe2, $data, $hora, $local, $cidade);
                            mysqli_stmt_store_result($query_tratada);

                            while (mysqli_stmt_fetch($query_tratada)) {
                              printf("
                              <table class='text-center tabelaJogos'>
                              <tr>
                                  <td rowspan = '3'>
                                  %s
                                  </td>
                                  <td rowspan = '3' class = 'tdx'>
                                  X
                                  </td>
                                  <td rowspan = '3'>
                                  %s
                                  </td>
                                  <td>
                                  Dia: %s <br /> Hora: %s
                                  </td>
                              </tr>
                              <tr>
                                  <td>
                                  Local: %s
                                  </td>
                              </tr>
                              <tr>
                                  <td>
                                  Cidade: %s
                                  </td>
                              </tr>
                              </table>",
                              $equipe1, $equipe2, $data, $hora, $local, $cidade);

                              echo "<br />";
                            }

                          }

                          if (isset($_GET['pagina']) and (($_GET['pagina'] > $num_pg) or ($_GET['pagina'] < 1))) {
                            header("location: principal.php?link=1&pagina=1");
                          }

                          $pagina_anterior = $pagina + 1;
                          $pagina_posterior = $pagina - 1;
                          ?>
                          <nav aria-label="Page navigation example">
                            <ul class="pagination paginacao">
                              <li> <?php
                              if ($pagina_posterior > 0) {
                                if ($pagina_anterior != 0) { ?>
                                  <a href="principal.php?link=1&pagina=<?php echo $pagina_posterior;?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                              <?php } else{ ?>
                                  <span aria-hidden="true">&laquo;</span>
                                <?php } }?>
                              </li>

                              <?php
                          for ($i=1; $i < $num_pg; $i++) {?>
                            <li>
                              <a href="principal.php?link=1&pagina=<?php echo $i;?>"><?php echo $i;?></a>
                            </li>

                          <?php } ?>
                              <li><?php
                              if ($pagina_anterior <= $num_pg) {
                                if ($pagina_posterior <= $num_pg + 1) { ?>
                                  <a href="principal.php?link=1&pagina=<?php echo $pagina_anterior;?>" aria-label="Previous">
                                    <span aria-hidden="true">&raquo;</span>
                                  </a>
                                <?php } else{ ?>
                                  <span aria-hidden="true">&raquo;</span>
                                <?php } }?>
                                </li>
                            </ul>
                          </nav>
                <?php
                mysqli_stmt_close($query_tratada);
                mysqli_close($conexao);
                    }
                  }
                }
              }

           ?>

        </div>
      </div>


    </div>

  </body>
</html>
