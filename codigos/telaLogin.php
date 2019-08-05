<!DOCTYPE html>
<html lang="br" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="pagestilo.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
  </head>
  <body>
<div class="telaLogin">
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <section class="header-site">
                  <h1 class="text-center">Panambi no Futebol</h1>
                    <p class="text-center">A solução no agendamento de <br> partidas amadadoras.</p>
        </section>
      </div>
      <div class="col-md-4 login text-center">
        <form class="" action="verifica.php" method="post">
          <label for="idemail">E-mail</label><br>
          <input autocomplete="on" type="text" id="idemail" name="email" placeholder="Insira seu email..." required><br><br>

          <label for="idsenha">Senha</label><br>
          <input autocomplete="off" type="password" id="idsenha" required name="senha" placeholder="Insira sua senha..."><br><br>
          <a href="principal.php"><input type="submit" value="Entrar" /></a><br>
          <a href="cadastro.php"><input class="text-center" value="Cadastre-se"/></a>
        </form>

  <?php
    if (isset($_GET['erro'])){
      if (isset($_GET['erro']) == 1) {
        echo "<br />";
        echo '<div class="erro">' . "E-mail ou senha incorretos!" . '</div>';
      }
    }
   ?>

      </div>
    </div>
  </div>
</div>


  </body>
</html>
