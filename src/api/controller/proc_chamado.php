<?php
include_once('../../../conection.php');
session_start();

$titulo_chamado = filter_input(INPUT_POST, 'titulo_chamado', FILTER_SANITIZE_STRING);
$urgencia = filter_input(INPUT_POST, 'urgencia', FILTER_SANITIZE_STRING);
$prazo = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_STRING);
$local = filter_input(INPUT_POST, 'local', FILTER_SANITIZE_STRING);
$funcionario = filter_input(INPUT_POST, 'funcionarios', FILTER_SANITIZE_STRING);
$descricao_tarefa = filter_input(INPUT_POST, 'item', FILTER_SANITIZE_STRING);
$data_atual = date("Y-m-d H:i:s");
$status = "PENDENTE";

//verificação para ver se não está vazio
$titulo_chamado = trim($titulo_chamado);
$local = trim($local);
$descricao_tarefa = trim($descricao_tarefa);

if(empty($titulo_chamado ) or empty($local) or empty($descricao_tarefa)){
        $_SESSION['msg'] = '<div class="notificacao" style="border-left: 6px solid red;">
        <div class="notificacao-div">
            <i class="bi bi-x-circle-fill" style="color: red;"></i>
            <div class="mensagem">
                <span class="text text-1" style="color: red;">Chamado não cadastrado.Envio em branco!</span>
            </div>
        </div>
        <i class="bi bi-x close" style="color: red;"></i>
        <div class="tempo tempo_error" style="background-color: #ddd;"></div>
    </div>';
    header('Location: ../../pages/abrir_chamado.php');
    exit; // Encerra o script após redirecionar para evitar processamento adicional
}

// Verifique se um arquivo de imagem foi enviado
if (isset($_FILES["img"]) && $_FILES["img"]["error"] === UPLOAD_ERR_OK) {
    // Obtenha os dados da imagem (nome, nome temporário, tipo do arquivo)
    $image = $_FILES["img"];
    $tmp_name = $image['tmp_name'];
    $name = basename($image["name"]);
    $allowTypes = array('jpg', 'png', 'jpeg');
    $fileType = strtolower(pathinfo($name, PATHINFO_EXTENSION));

    if (in_array($fileType, $allowTypes) && $image['size'] <= 2097152) {
        // Lê os dados binários da imagem
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
            header('Location: ../../pages/abrir_chamado.php');
            exit; // Encerra o script após redirecionar para evitar processamento adicional
        } else {
            $_SESSION['msg'] = '<div class="notificacao" style="border-left: 6px solid red;">
                                    <div class="notificacao-div">
                                        <i class="bi bi-x-circle-fill" style="color: red;"></i>
                                        <div class="mensagem">
                                            <span class="text text-1" style="color: red;">Chamado não cadastrado. Apenas arquivos JPG, PNG e JPEG são permitidos.</span>
                                        </div>
                                    </div>
                                    <i class="bi bi-x close" style="color: red;"></i>
                                    <div class="tempo tempo_error" style="background-color: #ddd;"></div>
                                </div>';
            header('Location: ../../pages/abrir_chamado.php');
            exit; // Encerra o script após redirecionar para evitar processamento adicional
        }
    }

    // Use uma prepared statement para inserir dados no banco de dados
    $sql = "INSERT INTO ordem (SERVICO, PRIORIDADE, ITEM, PRAZO, STATUS, LOCALIZACAO, FOTO, CRIADO) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    // Vincule os parâmetros à declaração SQL
    mysqli_stmt_bind_param($stmt, "ssssssss", $titulo_chamado, $urgencia, $descricao_tarefa, $prazo, $status, $local, $imagem_binaria, $data_atual);

    if (mysqli_stmt_execute($stmt)) {
        $ultimoIDInserido = $stmt->insert_id;

        $historico_ordem =  mysqli_query($conn, "INSERT INTO historico_ordem (ID_HISTORICO) VALUES ('$ultimoIDInserido')");

        if ($historico_ordem) {
            echo "Registro inserido na tabela historico_ordem com sucesso.<br>";
        } else {
            echo "Erro ao inserir registro na tabela historico_ordem: " . mysqli_error($conn) . "<br>";
        }

        $cadastro = mysqli_query($conn, "INSERT INTO rel (FK_ORDEM, FK_FUNCIONARIO, FK_HISTORICO) values ('$ultimoIDInserido', '$funcionario', '$ultimoIDInserido')");

        if ($cadastro) {
            $id = mysqli_insert_id($conn);
            $_SESSION['msg'] = '<div class="notificacao">
                                    <div class="notificacao-div">
                                        <i class="bi bi-check-lg"></i>
                                        <div class="mensagem">
                                            <span class="text text-1">Chamado Criado com sucesso!</span>
                                        </div>
                                    </div>
                                    <i class="bi bi-x close"></i>
                                    <div class="tempo"></div>
                                </div>';
            $_SESSION['id'] = $id;
            header('Location: ../../pages/menu.php');
        } else {
            $_SESSION['msg'] = '<div class="notificacao" style="border-left: 6px solid red;">
            <div class="notificacao-div">
                <i class="bi bi-x-circle-fill" style="color: red;"></i>
                <div class="mensagem">
                    <span class="text text-1" style="color: red;">Chamado não foi Cadastrado.</span>
                </div>
            </div>
            <i class="bi bi-x close" style="color: red;"></i>
            <div class="tempo tempo_error" style="background-color: #ddd;"></div>
        </div>';

                header('Location: ../../pages/abrir_chamado.php');
        }

        // Feche a declaração preparada
        mysqli_stmt_close($stmt);
    }
} else {
    // Se não houver imagem
    // Use uma prepared statement para inserir dados no banco de dados
    $sql = "INSERT INTO ordem (SERVICO, PRIORIDADE, ITEM, PRAZO, STATUS, LOCALIZACAO, CRIADO) VALUES (?, ?, ?, ?, ?, ?, NOW())";
    $stmt = mysqli_prepare($conn, $sql);

    // Vincule os parâmetros à declaração SQL
    mysqli_stmt_bind_param($stmt, "ssssss", $titulo_chamado, $urgencia, $descricao_tarefa, $prazo, $status, $local);

    if (mysqli_stmt_execute($stmt)) {
        $ultimoIDInserido = $stmt->insert_id;

        $historico_ordem =  mysqli_query($conn, "INSERT INTO historico_ordem (ID_HISTORICO) VALUES ('$ultimoIDInserido')");

        if ($historico_ordem) {
            echo "Registro inserido na tabela historico_ordem com sucesso.<br>";
        } else {
            echo "Erro ao inserir registro na tabela historico_ordem: " . mysqli_error($conn) . "<br>";
        }

        $cadastro = mysqli_query($conn, "INSERT INTO rel (FK_ORDEM, FK_FUNCIONARIO, FK_HISTORICO) values ('$ultimoIDInserido', '$funcionario', '$ultimoIDInserido')");

        if ($cadastro and $historico_ordem == TRUE) {
            $id = mysqli_insert_id($conn);
            $_SESSION['msg'] = '<div class="notificacao">
                                <div class="notificacao-div">
                                    <i class="bi bi-check-lg"></i>
                                    <div class="mensagem">
                                        <span class="text text-1">Chamado Criado com sucesso!</span>
                                    </div>
                                </div>
                                <i class="bi bi-x close"></i>
                                <div class="tempo"></div>
                            </div>';
            $_SESSION['id'] = $id;
            header('Location: ../../pages/menu.php');
        } else {
            $_SESSION['msg'] = '<div class="notificacao" style="border-left: 6px solid red;">
                                    <div class="notificacao-div">
                                        <i class="bi bi-x-circle-fill" style="color: red;"></i>
                                        <div class="mensagem">
                                            <span class="text text-1" style="color: red;">Chamado não foi Cadastrado.</span>
                                        </div>
                                    </div>
                                    <i class="bi bi-x close" style="color: red;"></i>
                                    <div class="tempo tempo_error" style="background-color: #ddd;"></div>
                                </div>';
                            
                                    header('Location: ../../pages/abrir_chamado.php');
        }

        // Feche a declaração preparada
        mysqli_stmt_close($stmt);
    }
}
?>
