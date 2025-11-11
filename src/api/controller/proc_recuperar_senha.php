<?php
// Inclua o arquivo de conexão com o banco de dados
include_once('../../../conection.php');
session_start();
ob_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../../lib/vendor/autoload.php';
$mail = new PHPMailer(true);

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
var_dump($email);

$query_usuario = "SELECT ID_ADM, NOME_ADM, EMAIL_ADM FROM administrador WHERE EMAIL_ADM = ?";
$result_usuario = $conn->prepare($query_usuario);
$result_usuario->bind_param('s', $email);
$result_usuario->execute();

$result_usuario->store_result();

if ($result_usuario->num_rows != 0) {
    $result_usuario->bind_result($id, $nome, $email);
    $result_usuario->fetch();
    $chave_recuperar_senha = password_hash($id, PASSWORD_DEFAULT);
    // echo "Chave $chave_recuperar_senha <br>";

    $query_up_usuario = "UPDATE administrador SET RECUPERAR_SENHA = ? WHERE ID_ADM = ?";
    $result_up_usuario = $conn->prepare($query_up_usuario);

    if ($result_up_usuario === false) {
        die('Erro na preparação da consulta: ' . $conn->error);
    }

    $result_up_usuario->bind_param('si', $chave_recuperar_senha, $id);

    if ($result_up_usuario->execute()) {
        echo "Atualização bem-sucedida.";
    } else {
        echo "Erro na atualização: " . $conn->error;
    }

    $result_up_usuario->close();

    $link = "http://localhost/sistema_OS/src/pages/atualizar_senha.php?chave=$chave_recuperar_senha";
    try {
        /*$mail->SMTPDebug = SMTP::DEBUG_SERVER;*/
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'protask.suporte@gmail.com';
        $mail->Password = 'hdzy igrw vdcm vxmp';
        $mail->Port = 587;

        $mail->setFrom('protask.suporte@gmail.com', 'ProTask');
        $mail->addAddress($email);


        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Redefinição de senha';
        $mail->Body    = 'Prezado(a) ' . $nome .".<br><br>Você solicitou alteração de senha.<br><br>Para continuar o processo de recuperação de sua senha, clique no link abaixo ou cole o endereço no seu navegador: <br><br><a href='" . $link . "'>" . $link . "</a><br><br>Se você não solicitou essa alteração, nenhuma ação é necessária. Sua senha permanecerá a mesma até que você ative este código.<br><br>";
        $mail->AltBody = 'Prezado(a) ' . $nome ."\n\nVocê solicitou alteração de senha.\n\nPara continuar o processo de recuperação de sua senha, clique no link abaixo ou cole o endereço no seu navegador: \n\n" . $link . "\n\nSe você não solicitou essa alteração, nenhuma ação é necessária. Sua senha permanecerá a mesma até que você ative este código.\n\n";

        $mail->send();

        $_SESSION['msg'] = "<p style='color: green'>Enviado e-mail com instruções para recuperar a senha. Acesse a sua caixa de e-mail para recuperar a senha!</p>";
        header("Location: ../../pages/recuperar_senha.php");
    } catch (Exception $e) {
        echo "Erro: E-mail não enviado sucesso. Mailer Error: {$mail->ErrorInfo}";
    }
}




?>