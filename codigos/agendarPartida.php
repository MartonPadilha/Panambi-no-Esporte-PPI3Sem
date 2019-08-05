<!DOCTYPE html>
<html lang="br" dir="ltr">
  <head>
            <?php
          session_start()
            ?>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <div class="container">
      <form method="post">
          <div class="form-row">
          <div class="form-group col-md-4">
          <label for="inputEmail4">Data da partida</label>
          <input type="date" class="form-control" id="inputEmail4" placeholder="Data da partida...">
          </div>

          <div class="form-group col-md-4">
          <label for="inputPassword4">Equipe</label>
          <input type="text" class="form-control" value="<?php echo $_SESSION['equipeLogado'];?>" id="inputAdress" placeholder="">
          </div>

          <div class="form-group col-md-4">
          <label for="inputAddress">Equipe</label>
          <input type="text" class="form-control" id="inputAddress" placeholder="">
          </div>

          <button type="submit" class="btn btn-primary">Buscar</button>
          </div>
          </form>
    </div>
  </body>
</html>
