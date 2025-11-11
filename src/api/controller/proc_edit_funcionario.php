<?php
session_start();
include_once("../../../conection.php");

$id = $_SESSION['id'];

$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
$status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
$nome_completo = $_POST['nome'];
$nome_sobrenome = explode(" ", $nome_completo);
$nome = $nome_sobrenome[0];
$sobrenome = $nome_sobrenome[1];

//verificação para não deixar enviar campo nulo
var_dump($nome);
$nome = trim($nome);
var_dump($nome);

var_dump($sobrenome);
$sobrenome = trim($sobrenome);
var_dump($sobrenome);




if (empty($nome)){
        $_SESSION['msg'] = '<div class="notificacao" style="border-left: 6px solid red;">
        <div class="notificacao-div">
            <i class="bi bi-x-circle-fill" style="color: red;"></i>
            <div class="mensagem">
                <span class="text text-1" style="color: red;">Erro! Funcionario não Cadastrado! Nome em Branco!</span>
            </div>
        </div>
        <i class="bi bi-x close" style="color: red;"></i>
        <div class="tempo tempo_error" style="background-color: #ddd;"></div>
    </div>';
    header('Location: ../../pages/editar_funcionario.php?id='.$id);
    exit();
}

// Verifique se um arquivo de imagem foi enviado
if (isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] === UPLOAD_ERR_OK) {
    $image = $_FILES["imagem"];
    $tmp_name = $image['tmp_name'];
    $name = basename($image["name"]);
    $allowTypes = array('jpg', 'png', 'jpeg');
    $fileType = strtolower(pathinfo($name, PATHINFO_EXTENSION));

    if (in_array($fileType, $allowTypes) && $image['size'] <= 2097152) {
        $imagem_binaria = file_get_contents($tmp_name);
    } else {
        if ($image['size'] > 2097152) {
            $_SESSION['msg'] = '<div class="notificacao" style="border-left: 6px solid red;">
                                    <div class="notificacao-div">
                                        <i class="bi bi-x-circle-fill" style="color: red;"></i>
                                        <div class="mensagem">
                                            <span class="text text-1" style="color: red;">Chamado não cadastrado. Tamanho de imagem não aceita. Máx 2MB.</span>
                                        </div>
                                    </div>
                                    <i class="bi bi-x close" style="color: red;"></i>
                                    <div class="tempo tempo_error" style="background-color: #ddd;"></div>
                                </div>';
            header('Location: ../../pages/editar_funcionario.php');
            exit();
        } else {
            $_SESSION['msg'] = '<div class="notificacao" style="border-left: 6px solid red;">
                                    <div class="notificacao-div">
                                        <i class="bi bi-x-circle-fill" style="color: red;"></i>
                                        <div class="mensagem">
                                            <span class="text text-1" style="color: red;">Chamado não cadastrado. Apenas arquivos JPG, PNG e JPEG são permitidos.</span>
                                        </div>
                                    </div>
                                    <i class="bi bi-x close" style="color: red;"></i>
                                    <<div class="tempo tempo_error" style="background-color: #ddd;"></div>
                                </div>';
            header('Location: ../../pages/editar_funcionario.php?id='.$id.'');
            exit();
        }
    }

    if (!empty($imagem_binaria)) {
        $update_query = "UPDATE funcionarios SET NOME_FUNCIONARIO=?, SOBRENOME_FUNCIONARIO=?, IMAGEM_FUNCIONARIO=?, STATUS_FUNCIONARIO=? WHERE ID_FUNCIONARIO = ?";
        $stmt = mysqli_prepare($conn, $update_query);
        mysqli_stmt_bind_param($stmt, 'ssssi', $nome, $nome_sobrenome[1], $imagem_binaria, $status, $id);
    } else {
        $update_query = "UPDATE funcionarios SET NOME_FUNCIONARIO=?, SOBRENOME_FUNCIONARIO=?, STATUS_FUNCIONARIO=? WHERE ID_FUNCIONARIO = ?";
        $stmt = mysqli_prepare($conn, $update_query);
        mysqli_stmt_bind_param($stmt, 'sssi', $nome, $nome_sobrenome[1], $status, $id);
    }

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['msg'] = '<div class="notificacao">
        <div class="notificacao-div">
            <i class="bi bi-check-lg"></i>
            <div class="mensagem">
                <span class="text text-1">Funcionário Editado com Sucesso!</span>
            </div>
        </div>
        <i class="bi bi-x close"></i>
        <div class="tempo"></div>
    </div>';
        header("Location: ../../pages/lista_funcionarios.php");
    } else {
        $_SESSION['msg'] = '<div class="notificacao" style="border-left: 6px solid red;">
                                        <div class="notificacao-div">
                                            <i class="bi bi-x-circle-fill" style="color: red;"></i>
                                            <div class="mensagem">
                                                <span class="text text-1" style="color: red;">Funcionario não foi Editado!</span>
                                            </div>
                                        </div>
                                        <i class="bi bi-x close" style="color: red;"></i>
                                        <div class="tempo tempo_error" style="background-color: #ddd;"></div>
                                    </div>';
        header('Location: ../../pages/editar_funcionario.php?id='.$id.'');
        exit();
    }
} else {
    $update_query = "UPDATE funcionarios SET NOME_FUNCIONARIO=?, SOBRENOME_FUNCIONARIO=?, STATUS_FUNCIONARIO=? WHERE ID_FUNCIONARIO = ?";
    $stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt, 'sssi', $nome, $nome_sobrenome[1], $status, $id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['msg'] = '<div class="notificacao">
                                <div class="notificacao-div">
                                    <i class="bi bi-check-lg"></i>
                                    <div class="mensagem">
                                        <span class="text text-1">Funcionário Editado com Sucesso!</span>
                                    </div>
                                </div>
                                <i class="bi bi-x close"></i>
                                <div class="tempo"></div>
                            </div>';
        header("Location: ../../pages/lista_funcionarios.php");
    } else {
        $_SESSION['msg'] = '<div class="notificacao" style="border-left: 6px solid red;">
                                        <div class="notificacao-div">
                                            <i class="bi bi-x-circle-fill" style="color: red;"></i>
                                            <div class="mensagem">
                                                <span class="text text-1" style="color: red;">Funcionario não foi Editado!</span>
                                            </div>
                                        </div>
                                        <i class="bi bi-x close" style="color: red;"></i>
                                        <div class="tempo tempo_error" style="background-color: #ddd;"></div>
                                    </div>';
        header('Location: ../../pages/editar_funcionario.php?id='.$id.'');
        exit();
    }
}
