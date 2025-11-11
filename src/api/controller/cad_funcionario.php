<?php

// Inclua o arquivo de conexão com o banco de dados
include_once('../../../conection.php');
// Inicie a sessão
session_start(); 

// Verifique se há mensagens na sessão
if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

// Obtenha os dados do formulário
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
$usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
$senha_funcionario = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
$sobrenome = filter_input(INPUT_POST, 'sobrenome', FILTER_SANITIZE_STRING);; // ENQUANTO NÃO FAZ PARA NÃO FICAR SEM NADA NO CAMPO DO SOBRENOME

//verificação para não deixar enviar campo nulo
var_dump($nome);
$nome = trim($nome);
var_dump($nome);

var_dump($sobrenome);
$sobrenome = trim($sobrenome);
var_dump($sobrenome);




if (empty($nome AND $sobrenome)){
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
    header('Location: ../../pages/cadastro_funcionario.php');
    exit();
}

// Criptografia da senha (MÉTODO UTILIZADO MEU FILHO >>>>> password_hash($variavel, PASSWORD_DEFAULT))
$criptosenha = password_hash($senha_funcionario, PASSWORD_DEFAULT);

// Verifique se um arquivo de imagem foi enviado
if (isset($_FILES["img"]) && $_FILES["img"]["error"] === UPLOAD_ERR_OK) {
    // Obtenha os dados da imagem (nome, nome temporário, tipo do arquivo)
    $image = $_FILES["img"];

    $tmp_name = $image['tmp_name'];
    
    $name = basename($image["name"]);

    $allowTypes = array('jpg','png','jpeg');

    $fileType = strtolower(pathinfo($name, PATHINFO_EXTENSION));

    if (in_array($fileType, $allowTypes) && $image['size'] <= 2097152) {
        // Lê os dados binários da imagem
        $imagem_binaria = file_get_contents($tmp_name);
    }else {

        if ($image['size'] > 2097152) { 
            $_SESSION['msg'] = '<div class="notificacao" style="border-left: 6px solid red;">
                                    <div class="notificacao-div">
                                        <i class="bi bi-x-circle-fill" style="color: red;"></i>
                                        <div class="mensagem">
                                            <span class="text text-1" style="color: red;">Funcionario não cadastrado. Tamanho de imagem não aceita. Máx 2MB.</span>
                                        </div>
                                    </div>
                                    <i class="bi bi-x close" style="color: red;"></i>
                                    <div class="tempo tempo_error" style="background-color: #ddd;"></div>
                                </div>';
            header('Location: ../../pages/menu.php');
            exit; // Encerra o script após redirecionar para evitar processamento adicional
        } else {
            $_SESSION['msg'] = '<div class="notificacao" style="border-left: 6px solid red;">
                                    <div class="notificacao-div" >
                                        <i class="bi bi-x-circle-fill" style="color: red;"></i>
                                        <div class="mensagem">
                                            <span class="text text-1" style="color: red;">Funcionario não cadastrado. Apenas arquivos JPG, PNG e JPEG são permitidos.</span>
                                        </div>
                                    </div>
                                    <i class="bi bi-x close" style="color: red;"></i>
                                    <div class="tempo tempo_error" style="background-color: #ddd;"></div>
                                </div>';
            header('Location: ../../pages/cadastro_funcionario.php');
            exit; // Encerra o script após redirecionar para evitar processamento adicional
        }
    }

    // Lê os dados binários da imagem
    $imagem_binaria = file_get_contents($tmp_name);
    // Verifique se a imagem não está vazia
    if (!empty($imagem_binaria)) {
        // Use uma prepared statement para inserir dados no banco de dados
        $sql = "INSERT INTO funcionarios (NOME_FUNCIONARIO, SOBRENOME_FUNCIONARIO, IMAGEM_FUNCIONARIO, USUARIO_FUNCIONARIO, SENHA_FUNCIONARIO, STATUS_FUNCIONARIO) VALUES (?, ?, ?, ?, ?, 'ATIVO')";
        $stmt = mysqli_prepare($conn, $sql);

        // Vincule os parâmetros à declaração SQL
        mysqli_stmt_bind_param($stmt, "sssss", $nome, $sobrenome, $imagem_binaria, $usuario, $criptosenha);
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
            $_SESSION['id'] = $id;
            header('Location: ../../pages/menu.php');
            
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
            header('Location: ../../pages/cadastro_funcionario.php');
        }
        // Feche a declaração preparada
        mysqli_stmt_close($stmt);
    } else {
        echo 'Imagem vazia ou inválida';
    }
} else {

    // Se a imagem não foi enviada, ou após o tratamento da imagem, realizamos a inserção no banco de dados apenas com o nome do usuário
    $sql = "INSERT INTO funcionarios (NOME_FUNCIONARIO, SOBRENOME_FUNCIONARIO, USUARIO_FUNCIONARIO, SENHA_FUNCIONARIO, STATUS_FUNCIONARIO) VALUES (?, ?, ?, ?, 'ATIVO')";
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
        $_SESSION['id'] = $id;
        header('Location: ../../pages/menu.php');
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
        header('Location: ../../pages/cadastro_funcionario.php');
    }
    // Feche a declaração preparada
    mysqli_stmt_close($stmt);
}
// Feche a conexão com o banco de dados
mysqli_close($conn);
?>

 