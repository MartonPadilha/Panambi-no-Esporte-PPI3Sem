<?php

function conectar(){
              $conexao = mysqli_connect("localhost", "root", "", "ppi1");
              return $conexao;
}

function desconectar($conexao){
              mysqli_close($conexao);
}

function loginComNomeEquipe($email, $senha, $conexao){
              $query = "select * from equipe where email=? and senha=?";
              $query_tratada = mysqli_prepare($conexao, $query);
               if ($query_tratada) {
                            mysqli_stmt_bind_param($query_tratada, "ss", $email, $senha);
                            mysqli_stmt_execute($query_tratada) ;
                            mysqli_stmt_bind_result($query_tratada, $id, $nomeEquipe, $categoria, $cidade, $nomeUsuario, $email, $senha);
                            mysqli_stmt_store_result($query_tratada);
                            if (mysqli_stmt_num_rows($query_tratada) > 0) {
                                mysqli_stmt_fetch($query_tratada);
                                session_start();
                                $_SESSION['idLogado'] = $id;
                                $_SESSION['equipeLogado'] = $nomeEquipe;
                                $_SESSION['categoriaLogado'] = $categoria;
                                $_SESSION['cidadeLogado'] = $cidade;
                                $_SESSION['nomeLogado'] = $nomeUsuario;
                                $_SESSION['emailLogado'] = $email;
                                mysqli_stmt_close($query_tratada);
                                mysqli_close($conexao);
                                header("location: principal.php");

                                return true;

                        }

               }
               mysqli_close($conexao);
               header("location: telaLogin.php?erro=1");
               return false;
}







 ?>
