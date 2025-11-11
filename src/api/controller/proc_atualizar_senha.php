<?php
session_start();
ob_start();
include_once '../../../conection.php';

if (isset($_POST['SendNovaSenha'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $senha_usuario = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $recuperar_senha = NULL;

    $query_up_usuario = "UPDATE administrador 
            SET senha_adm = ?,
            recuperar_senha = ?
            WHERE id_adm = ? 
            LIMIT 1";
    $result_up_usuario = $conn->prepare($query_up_usuario);

    if ($result_up_usuario === false) {
        die('Erro na preparação da consulta de atualização: ' . $conn->error);
    }

    $result_up_usuario->bind_param('ssi', $senha_usuario, $recuperar_senha, $id);

    if ($result_up_usuario->execute()) {
        $_SESSION['msg'] = "<p style='color: green'>Senha atualizada com sucesso!</p>";
        header("Location: ../../pages/login.php");
    } else {
        echo "<p style='color: #ff0000'>Erro: Tente novamente!</p>";
    }
} else {
    $_SESSION['msg_rec'] = "<p style='color: #ff0000'>Erro: Link inválido, solicite novo link para atualizar a senha!</p>";
    header("Location: ../../pages/recuperar_senha.php");
}
