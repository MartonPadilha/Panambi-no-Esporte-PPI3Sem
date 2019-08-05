<!DOCTYPE html>
<html lang="br" dir="ltr">
  <head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <link rel="stylesheet" href="pagestilo.css">
    <link rel="stylesheet" href="../css/bootstrap.css" type="text/css" />
    <title></title>
  </head>
  <body>

  <div class="cadastro">
    <div class="container">
      <div class="text-center">
        <div class="row">
            <div class="col-xs-12">
                <p>Cadastro</p>
            </div>
        </div>

            <div class="row">
                <form method="post">
                  <div class="form-row text-center">
                    <div class="form-group col-md-12">
                      <label for="idemail">Nome da equipe</label>
                      <input name="nomeEquipe" type="text" class="form-control" id="idemail" placeholder="Nome da equipe..." required>

                      <label for="idcategoria">Categoria</label>
                      <select name="categoria" type="number" class="form-control" id="idcategoria" name="categoria" required>
                          <option value="11">Futebol 11</option>
                          <option value="7">Futebol 7</option>
                      </select>

                      <!--<label for="idsede">Sede</label>
                      <input name="sede" type="text" class="form-control" id="idsede" placeholder="Sede da equipe...">-->

                      <label for="idcidade">Cidade</label>
                      <select name="cidade" class="form-control" id="idcidade" required>
                          <option value="Panambi">Panambi</option>
                          <option value="Condor">Condor</option>
                          <option value="Pejuçara">Pejuçara</option>
                          <option value="Santa Bárbara do Sul">Santa Bárbara do Sul</option>
                          <option value="Ajuricaba">Ajuricaba</option>
                          <option value="Julho de Castilhos">Julho de Castilhos</option>
                          <option value="Tupanciretã">Tupanciretã</option>
                          <option value="Ijuí">Ijuí</option>
                          <option value="Cruz Alta">Cruz Alta</option>
                          <option value="Ibirubá">Ibirubá</option>
                      </select>

                       <label for="idresponsavel">Seu nome</label>
                      <input name="responsavel" type="text" class="form-control" id="idresponsavel"  required placeholder="Nome do responsável da equipe...">

                     <label for="idemail">E-mail</label>
                      <input type="email" id="idemail" class="form-control" name="email" placeholder="Email do responsável...">

                      <input type="submit" value="Cadastrar" id="cadastrar">
                      <a href="telaLogin.php"><input type="button" id="cadastrar" value="Voltar"></a>

                  </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  </body>
</html>

<?php
    header("content-type: text/html;charset=utf-8");

  if (isset($_POST['nomeEquipe']) and isset($_POST['email'])) {
    $nomeEquipe = $_POST['nomeEquipe'];
    $categoria = $_POST['categoria'];
    $cidade = $_POST['cidade'];
    $nomeUsuario = $_POST['responsavel'];
    $email = $_POST['email'];

      include "function.php";
      $conexao = conectar();

      if ($conexao){

        if (!empty($nomeEquipe) and !empty($email)){
          $query = "insert into equipe(nomeEquipe, categoria, cidade, nomeUsuario, email ) values (?, ?, ?, ?, ?)";
          $query .= mysqli_query("SET NAMES 'utf8'");
          $query .= mysqli_query("SET character_set_connection=utf8");
          $query .= mysqli_query("SET character_set_client=utf8");
          $query .= mysqli_query("SET character_set_results=utf8");
          $query_tratada = mysqli_prepare($conexao, $query);

        if ($query_tratada) {
              mysqli_stmt_bind_param($query_tratada, "sisss", $nomeEquipe, $categoria, $cidade, $nomeUsuario, $email);

          if (mysqli_stmt_execute($query_tratada)) {
            if (mysqli_stmt_affected_rows($query_tratada) > 0) {
                    header("location: registroSalvo.php");
                  }
                  else {
                    echo "Falha ao gravar";
                  }
                  mysqli_stmt_close($query_tratada);
                  mysqli_close($conexao);
                }
            }
        }
      }
  }
 ?>
