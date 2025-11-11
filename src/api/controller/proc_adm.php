<?php
include_once("../../../conection.php");

$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
$sobrenome = 'test';
$usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
$criptosenha = password_hash($senha_funcionario, PASSWORD_DEFAULT);

$sql = "INSERT INTO administrador (NOME_ADM, SOBRENOME_ADM, USUARIO_ADM, SENHA_ADM) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        // Vincule os parâmetros à declaração SQL
        mysqli_stmt_bind_param($stmt, "ssss", $nome, $sobrenome, $usuario, $criptosenha);

        if (mysqli_stmt_execute($stmt)) {
            $id = mysqli_insert_id($conn);
            $_SESSION['msg'] = '<div class="notificacao">
                                    <div class="notificacao-div">
                                        <i class="bi bi-check-lg"></i>
                                        <div class="mensagem">
                                            <span class="text text-1">Funcionario Cadastrado com Sucesso!</span>
                                        </div>
                                    </div>
                                    <i class="bi bi-x close"></i>
                                    <div class="tempo"></div>
                                </div>';
            header('Location: ../../pages/criando_adm.php');
            
        } else {
            $_SESSION['msg'] = '<div class="notificacao" style="border-left: 6px solid red;">
                                    <div class="notificacao-div">
                                        <i class="bi bi-x-circle-fill" style="color: red;"></i>
                                        <div class="mensagem">
                                            <span class="text text-1" style="color: red;">Erro! Funcionario não Cadastrado!</span>
                                        </div>
                                    </div>
                                    <i class="bi bi-x close" style="color: red;"></i>
                                    <div class="tempo tempo_error" style="background-color: #ddd;"></div>
                                </div>';
            header('Location: ../../pages/criando_adm.php');
        }
        // Feche a declaração preparada
        mysqli_stmt_close($stmt);


?>