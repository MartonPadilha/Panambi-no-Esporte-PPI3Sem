<?php
$conexao = mysqli_connect("localhost","root","","ppi1");

$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

$result_equipe = "select * from equipe";
$resultado_equipe = mysqli_query($conexao, $result_equipe);

$total_equipes = mysqli_num_rows($resultado_equipe);
$qtd_pg = 3;

$num_pg = ceil($total_equipes/$qtd_pg);

$inicio = ($qtd_pg*$pagina) - $qtd_pg;

$result_equipes = "select * from equipe limit $inicio, $qtd_pg";
$resultado_equipes = mysqli_query($conexao, $result_equipes);
$total_equipes = mysqli_num_rows($resultado_equipes);

while($dados = mysqli_fetch_assoc($resultado_equipes)){
    echo $dados['nomeEquipe'] . "<br>";
}

?>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<?php
$pagina_anterior = $pagina - 1;
$pagina_posterior = $pagina + 1;
?>
<nav aria-label="Page navigation example">
<ul class="pagination">
    <li>
<?php
    if($pagina_anterior != 0){ ?>
        <a href="testes.php?pagina=<?php echo $pagina_anterior;?>"><<</a>
            <span aria-hidden="true">&laquo;</span>
          </a>
    <?php}  else { ?>
      <span aria-hidden="true">&laquo;</span>
    <?php } ?>
  </li>
  <?php
    for($i = 1; $i < $num_pg + 1; $i++){ ?>
    <li class="page-item"><a class="page-link" href="testes.php?pagina=<?php echo $i;?>"><?php echo $i;?></a></li>
  <?php }?>
    <li>
      <a href="#">
        <span>&raquo;</span>
      </a>
    </li>
    <li>
<?php
    if($pagina_anterior <= $num_pg){ ?>
        <a href="testes.php?pagina=<?php echo $pagina_posterior;?>">>></a>
            <span aria-hidden="true">&raquo;</span>
          </a>
    <?php}  else { ?>
      <span aria-hidden="true">&raquo;</span>
    <?php } ?>
  </li>
  </ul>
</nav>
</body>
</html>
