<?php
        session_start();
        include "function.php";
        $conexao = conectar();
        $idLogado = $_GET['idLogado'];
        $idPartida = $_GET['codPartida'];
            if ($conexao) {
                $query = "delete from partida where codPartida = '$idPartida'";
                $resultado = mysqli_prepare($conexao, $query);
                if ($resultado) {
                    if (mysqli_stmt_execute($resultado)) {
                        if (mysqli_stmt_affected_rows($resultado) > 0) {
                            echo "0";
                        }
                        else {
                            echo "1";
                        }
                    }
                }
            }
 ?>
