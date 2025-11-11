<?php
session_start();
include_once("../../../conection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    $sql = "UPDATE ordem SET STATUS='CANCELADO' WHERE ID_ORDEM='$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION['msg'] = "<p style='color:green;'>CHAMADO CANCELADO COM SUCESSO</p>";
        echo "success";
        
    } else {
        $_SESSION['msg'] = "<p style='color:red;'>ERRO AO CANCELAR O CHAMADO</p>";
        echo "error";
        
    }
} else {
    echo "invalid_request";
    exit;
}
?>