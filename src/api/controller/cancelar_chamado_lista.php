<?php
   include_once('../../../conection.php');
   session_start();
    
    // criar a conexão - string de conexão
    $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);

    $id = $_GET['id'];

    $resultado = "UPDATE ordem SET STATUS = 'CANCELADO' WHERE ordem.ID_ORDEM = $id";
    $query = mysqli_query($conn, $resultado);
    
    if(mysqli_affected_rows($conn)){
            $_SESSION['msg'] = '<div class="notificacao">
            <div class="notificacao-div">
                <i class="bi bi-check-lg"></i>
                <div class="mensagem">
                    <span class="text text-1">Chamado Cancelado com Sucesso!</span>
                </div>
            </div>
            <i class="bi bi-x close"></i>
            <div class="tempo"></div>
        </div>';
        header("Location: ../../pages/lista_chamados.php");
    }

?>