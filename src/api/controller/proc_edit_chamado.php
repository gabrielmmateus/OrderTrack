<?php
session_start();
include_once("../../../conection.php");

// Verifique se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_SESSION['id'];
    $id_rel = $_SESSION['id_rel'];

    $nome_completo = $_POST['funcionario'];
    $nome_sobrenome = explode(" ", $nome_completo);
    
    $nome = isset($nome_sobrenome[0]) ? $nome_sobrenome[0] : null;
    $sobrenome = isset($nome_sobrenome[1]) ? $nome_sobrenome[1] : null;

    // Obtenha os valores do formulário
    $tituloNovo = trim(filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING));
    $assuntoNovo = trim(filter_input(INPUT_POST, 'item', FILTER_SANITIZE_STRING));
    $localNovo = trim(filter_input(INPUT_POST, 'local', FILTER_SANITIZE_STRING));
    $urgenciaNova = filter_input(INPUT_POST, 'urgencia', FILTER_SANITIZE_STRING);
    $prazoNovo = filter_input(INPUT_POST, 'prazo', FILTER_SANITIZE_STRING);
    $statusNovo = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);

    // Consulta para obter os valores atuais do banco de dados
    $consulta = "SELECT SERVICO, ITEM, LOCALIZACAO, PRIORIDADE, PRAZO, STATUS FROM ordem WHERE ID_ORDEM = '$id'";
    $resultado = mysqli_query($conn, $consulta);
    $row = mysqli_fetch_assoc($resultado);

    // Houve alteração, execute a atualização
    $update_query = "UPDATE ordem SET SERVICO='$tituloNovo', ITEM='$assuntoNovo', LOCALIZACAO='$localNovo', PRIORIDADE='$urgenciaNova', PRAZO='$prazoNovo', STATUS='$statusNovo' WHERE ID_ORDEM='$id'";
    
    $resultado_update = mysqli_query($conn, $update_query);
    
    if ($resultado_update) {
        // Atualização bem-sucedida
        $alteracao_descricao = "Ordem atualizada: 
        Título: $tituloNovo,
        Assunto: $assuntoNovo,
        Localização: $localNovo,
        Urgência: $urgenciaNova,
        Prazo: $prazoNovo,
        Status: $statusNovo";

        $alteracao_query = "INSERT INTO alteracao_ordem (DATA_ALTERACAO, ALTERACAO, FK_ORDEM) VALUES (NOW(), '$alteracao_descricao', '$id')";
        $resultado_insercao = mysqli_query($conn, $alteracao_query);

        if ($resultado_insercao) {
            if (isset($nome) && isset($nome_completo) && !empty($nome_completo) && $nome_completo != " ") {
                $select_funcionario = "SELECT * from funcionarios WHERE NOME_FUNCIONARIO = '$nome'";
                $query_funcionario = mysqli_query($conn, $select_funcionario);
                $resultado_funcionario = mysqli_fetch_assoc($query_funcionario);

                if ($resultado_funcionario) {
                    $id_funcionario = $resultado_funcionario['ID_FUNCIONARIO'];

                    $update_query_funcionario = "UPDATE rel SET FK_FUNCIONARIO='$id_funcionario' WHERE ID_REL = '$id_rel'";
                    $query_update_funcionario = mysqli_query($conn, $update_query_funcionario);

                    if ($query_update_funcionario) {
                        $_SESSION['msg'] = '<div class="notificacao">
                                            <div class="notificacao-div">
                                                <i class="bi bi-check-lg"></i>
                                                <div class="mensagem">
                                                    <span class="text text-1">Chamado Editado com Sucesso</span>
                                                </div>
                                            </div>
                                            <i class="bi bi-x close"></i>
                                            <div class="tempo"></div>
                                        </div>';
                        header("Location: ../../pages/lista_chamados.php");
                        exit;
                    } else {
                        $_SESSION['msg'] = '<div class="notificacao" style="border-left: 6px solid red;">
                        <div class="notificacao-div">
                            <i class="bi bi-x-circle-fill" style="color: red;"></i>
                            <div class="mensagem">
                                <span class="text text-1" style="color: red;">Chamado não Editado!</span>
                            </div>
                        </div>
                        <i class="bi bi-x close" style="color: red;"></i>
                        <div class="tempo tempo_error" style="background-color: #ddd;"></div>
                    </div>';
                        header("Location: ../../pages/editar_chamado.php?id=".$id);
                        exit;
                    }
                } else {
                    $_SESSION['msg'] = '<div class="notificacao" style="border-left: 6px solid red;">naooooooo</div>';
                    header("Location: ../../pages/editar_chamado.php?id=".$id);
                    exit;
                }
            }
        } else {
            $_SESSION['msg'] = '<div class="notificacao" style="border-left: 6px solid red;">aaaaaaa</div>';
            header("Location: ../../pages/editar_chamado.php?id=".$id);
            exit;
        }
    } else {
        $_SESSION['msg'] = '<div class="notificacao" style="border-left: 6px solid red;">oiiiiiiiiii</div>';
        header("Location: ../../pages/editar_chamado.php?id=".$id);
        exit;
    }
}
?>
