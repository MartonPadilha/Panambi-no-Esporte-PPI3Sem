<!DOCTYPE html>
<html lang="br" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title></title>
        <link rel="stylesheet" href="/css/bootstrap.css">
        <link rel="stylesheet" href="pagestilo.css">
        <script>

            function confirmar(logado, partida){
                var requisicao = new XMLHttpRequest();
                    requisicao.open("GET", "partidaSalva.php?idLogado=" + logado +"&codPartida="+ partida, true);
                    requisicao.send();
                    requisicao.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            if(this.responseText==0){
                             idJogo.innerHTML="Partida Salva";

                            }
                            if(this.responseText==1){
                               alert("Erro ao salvar partida");
                            }
                        }
                    }
                }

        </script>
    </head>
    <body>
<div class="container">
    <div class="row text-center menumarcarjogo">
        <div class="col-md-4 text-center menuancoras">
            <ul>
                <li><a href="principal.php?link=2&marcarJogo=1"><button class="active">Cadastar partida como mandante</button></a></li>
                <li><a href="principal.php?link=2&marcarJogo=2"><button class="active">Buscar partida como visitante</button></a></li>
            </ul>
        </div>
        <div class="col-md-8 text-center">
            <?php


                if (isset($_GET['marcarJogo']) and (!empty($_GET['marcarJogo'])) and (($_GET['marcarJogo']) == 1)) {
                    $marcarJogo = $_GET['marcarJogo'];
                    ?>
                    <form class="cadastrarjogo" action="principal.php?link=2&marcarJogo=1" method="post">
                        Data: <input type="date" name="data" required>
                        Hora: <input type="time" name="hora" required>
                        Local: <input type="text" name="local" required>
                        <button type="submit" name="botao">Cadastrar</button>
                    </form>
                    <?php
                }
            if (isset($_GET['marcarJogo']) and (!empty($_GET['marcarJogo'])) and (($_GET['marcarJogo']) == 2)) {
                ?>
                <form class="cadastrarjogo" method="post" action="principal.php?link=2&marcarJogo=2&pagina=1">
                  <div class="form-group">
                    <label for="iddata">Data:</label>
                    <input type="date" class="text-center" id="iddata" name="dataJogo">
                    <button type="submit" name="button">Pesquisar</button>
                    <p><i>Para pesquisar todos os jogos que esperam adversário não insira nenhuma data.</i></p>
                  </div>
                </form>
                <?php
            }
            ?>
        </div>
    </div>
    <br>
<?php

include_once "function.php";
$conexao = conectar();

if (isset($_GET['marcarJogo']) and (!empty($_GET['marcarJogo'])) and (($_GET['marcarJogo']) == 1)) {
    if (isset($_POST['data']) and isset($_POST['hora']) and isset($_POST['local'])){
      if (!empty($_POST['data']) and !empty($_POST['hora']) and !empty($_POST['local'])){
          $dataAtual = date("Y-m-d");
          $data = $_POST['data'];
          $hora = $_POST['hora'];
          $local = $_POST['local'];
          $equipe1 = $_SESSION['idLogado'];
          $categoria = $_SESSION['categoriaLogado'];
        if($dataAtual < $data){
            if ($conexao) {
                $query = "insert into partida(categoria, equipe1, data, hora, local) values (?,?,?,?,?)";
                $query_tratada = mysqli_prepare($conexao, $query);
///////////////////////////////////////////////////////////////////////////////////////////////////////
                $query_data = "select equipe1, equipe2, data from partida where data = '$data' and (equipe1 = '$equipe1' or equipe2 = '$equipe1')";//verifica
                $query_data_tratada = mysqli_query($conexao, $query_data);//verifica
                if ($query_data_tratada) {//dalhe
                     if(mysqli_num_rows($query_data_tratada) > 0){ //dalhe
                         echo "Você já tem uma partida marcada nesta data.";  //dalhe
                    }//////////////////////////////////////////////////////////////
                    else {
                        if ($query_tratada) {
                            mysqli_stmt_bind_param($query_tratada, "ddsss",$categoria,$equipe1,$data,$hora,$local);
                            if (mysqli_stmt_execute($query_tratada)) {
                                if (mysqli_stmt_affected_rows($query_tratada) > 0) {
                                    echo "<script>alert('Partida salva, aguardando adversário...')</script>";
                                }
                                else {
                                    echo "Falha ao gravar partida";
                                }
                                mysqli_stmt_close($query_tratada);
                                mysqli_close($conexao);
                            }
                        }
                    }//dalhe
                }//dalhe
          }
      }else {
          echo "Você não pode marcar uma partida anterior à atual.";
      }
   }}}

        $categoria = $_SESSION['categoriaLogado'];
        $nomeEquipe = $_SESSION['equipeLogado'];
        if (isset($_GET['marcarJogo']) and (!empty($_GET['marcarJogo'])) and (($_GET['marcarJogo']) == 2) and !empty($_POST['dataJogo'])) {
            header("Content-type: text/html; charset=utf-8");
            $dataJogo = $_POST['dataJogo'];
            if ($conexao) {
                $query = "select partida.codPartida, equipe.nomeEquipe, DATE_FORMAT(partida.DATA, '%d.%m.%y') as DATA,partida.hora, partida.local, equipe.cidade
                from partida inner JOIN equipe ON partida.equipe1 = equipe.codEquipe
                WHERE partida.DATA = '$dataJogo' and partida.equipe2 is null and partida.categoria = '$categoria' and equipe.nomeEquipe != '$nomeEquipe' order by partida.data";
                $resultado = mysqli_query($conexao, $query);
                $resultado = mysqli_set_charset('utf8');
                if ($resultado) {
                    $contador = 0;
                    while ($dados = mysqli_fetch_assoc($resultado)) {
                        $idLogado = $_SESSION['idLogado'];
                        $idPartida = $dados['codPartida'];
                        $equipe1 = $dados['nomeEquipe'];
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
                            <span id=$idJogo>Aguardando adversário...<br />
                            <button onclick=\"confirmar($idLogado, $idPartida);\">Confirmar</button>
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
                }
                mysqli_close($conexao);
            }
        }

        if (isset($_GET['marcarJogo']) and (!empty($_GET['marcarJogo'])) and (($_GET['marcarJogo']) == 2) and empty($dataJogo)) {
            $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
            if(isset($_GET['pagina']) and ($_GET['pagina'] < 1)){
                 header("location: principal.php?link=2&marcarJogo=2&pagina=1");
            }
            if ($conexao) {
                mysqli_set_charset($conexao, 'utf8');
                $query = "select partida.codPartida, equipe.nomeEquipe, DATE_FORMAT(partida.DATA, '%d.%m.%y') as DATA, partida.hora, partida.local, equipe.cidade
                from partida inner JOIN equipe ON partida.equipe1 = equipe.codEquipe
                WHERE partida.equipe2 is null and partida.categoria = '$categoria'and equipe.nomeEquipe != '$nomeEquipe'";
                $resultado = mysqli_query($conexao, $query);
                $total_jogos = mysqli_num_rows($resultado);
                $qtd_pg = 3;
                $num_pg = ceil($total_jogos/$qtd_pg);
                $inicio = ($qtd_pg*$pagina) - $qtd_pg;

                $query = "select partida.codPartida, equipe.nomeEquipe, DATE_FORMAT(partida.DATA, '%d.%m.%y') as DATA, partida.hora, partida.local, equipe.cidade
                from partida inner JOIN equipe ON partida.equipe1 = equipe.codEquipe
                WHERE partida.equipe2 is null and partida.categoria = '$categoria'and equipe.nomeEquipe != '$nomeEquipe' limit $inicio, $qtd_pg";
                $resultado = mysqli_query($conexao, $query);
                $total_jogos = mysqli_num_rows($resultado);

                if ($resultado) {
                    $contador = 0;
                    while ($dados = mysqli_fetch_assoc($resultado)) {
                        $idLogado = $_SESSION['idLogado'];
                        $idPartida = $dados['codPartida'];
                        $equipe1 = $dados['nomeEquipe'];
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
                            <span id=$idJogo>Aguardando adversário...<br />
                            <button onclick=\"confirmar($idLogado, $idPartida);\">Confirmar</button>
                            <script>var idJogo=$idJogo</script>
                            </span>

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
                      header("location: principal.php?link=2&marcarJogo=2&pagina=1");
                    }
                    $pagina_anterior = $pagina + 1;
                    $pagina_posterior = $pagina - 1;
                    ?>
                    <nav aria-label="Page navigation example">
                    <ul class="pagination paginacao">
                      <li> <?php
                      if ($pagina_posterior > 0) {
                        if ($pagina_anterior != 0) { ?>
                          <a href="principal.php?link=2&marcarJogo=2&pagina=<?php echo $pagina_posterior;?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                      <?php } else{ ?>
                          <span aria-hidden="true">&laquo;</span>
                        <?php } }?>
                      </li>

                      <?php
                  for ($i=1; $i < $num_pg; $i++) {?>
                    <li>
                      <a href="principal.php?link=2&marcarJogo=2&pagina=<?php echo $i;?>"><?php echo $i;?></a>
                    </li>

                  <?php } ?>
                      <li><?php
                      if ($pagina_anterior <= $num_pg) {
                        if ($pagina_posterior <= $num_pg + 1) { ?>
                          <a href="principal.php?link=2&marcarJogo=2&pagina=<?php echo $pagina_anterior;?>" aria-label="Previous">
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
</div>
</body>
</html>
