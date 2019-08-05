<?php
        session_start();
        include "function.php";
        $conexao = conectar();
        $idLogado = $_GET['idLogado'];
        $idPartida = $_GET['codPartida'];
            if ($conexao) {
                $query = "update partida set equipe2 = NULL where codPartida = ?";
                $resultado = mysqli_prepare($conexao, $query);
                if ($resultado) {
                    mysqli_stmt_bind_param($resultado,"i", $idPartida);
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
