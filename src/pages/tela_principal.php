<?php
    session_start();
    include ('./modal.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../styles/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../src/styles/tela_principal/style.css">
    <title>Tela Principal</title>
    <link rel="shortcut icon" type="png" href="../../assets/images/icone_logo.png">
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href='../../index.php'>
                <img src="../../assets/images/logo.png" id="logo" alt="Logo" width="30" height="30">
            </a>
         
        </div>
 
    </nav>

    <main>
        <div class="main-card">
            <?php
                include_once('../../conection.php');
                if(isset($_SESSION['msg'])){
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }
               
                $result_usuario = "SELECT * FROM funcionarios ";
                $resultado_usuario = mysqli_query($conn,$result_usuario);
       
                while($row_usuario = mysqli_fetch_assoc($resultado_usuario)){
                    if($row_usuario['STATUS_FUNCIONARIO'] == 'ATIVO'){

                        echo '<div class="sub-card" style="width:170px;" onclick="aparecemodal(' . $row_usuario['ID_FUNCIONARIO'] . ')"alt="Ícone de Mensagem" class="mensagem-img"> ';
                        // Verifique se a imagem não está vazia
                if (!empty($row_usuario['IMAGEM_FUNCIONARIO'])) {
                    $tipo_mime = 'image/png'; // Substitua pelo tipo MIME correto (exemplo: image/png)
                    $imagem_base64 = base64_encode($row_usuario['IMAGEM_FUNCIONARIO']); // Codifica a imagem do funcionário em uma representação em base64.

                    // Adiciona a imagem apenas se atender aos critérios de tamanho
                    list($largura, $altura) = getimagesizefromstring($row_usuario['IMAGEM_FUNCIONARIO']);
                    if ($largura >= 200 && $altura >= 200) {
                        echo '<img src="data:' . $tipo_mime . ';base64,' . $imagem_base64 . '" alt="' . $row_usuario['NOME_FUNCIONARIO'] . '" class="funcionario-img">';
                    } else {
                        // Caso a imagem não atenda aos critérios de tamanho, exiba uma imagem padrão ou uma mensagem de erro.
                        echo '<img src="../../assets/images/telaPrincipal/funcionario.png" alt="' . $row_usuario['NOME_FUNCIONARIO'] . '" class="funcionario-img">';
                    }
                } else {
                    // Caso a imagem esteja vazia, exiba uma imagem padrão ou uma mensagem de erro.
                    echo '<img src="../../assets/images/telaPrincipal/funcionario.png" alt="' . $row_usuario['NOME_FUNCIONARIO'] . '" class="funcionario-img">';
                }

                        echo '<h3>' . $row_usuario['NOME_FUNCIONARIO'] . " " . $row_usuario['SOBRENOME_FUNCIONARIO'].'</h3>';
                        echo '<a onclick="aparecemodal(' . $row_usuario['ID_FUNCIONARIO'] . ')"><img src="../../assets/images/telaPrincipal/messagem.png" alt="Ícone de Mensagem" class="mensagem-img"></a>';
                        echo '<div class="subcard-overlay">';
                        echo '<h3>Detalhes do ' . $row_usuario['NOME_FUNCIONARIO'] . '</h3>';
                        // Coloque aqui mais detalhes sobre o funcionário
                        echo '</div>';
                        echo '</a></div>';           


                    }
                }
            ?>
        </div>
    </main>

    <footer class="footer">
        <div>
            <img id="logo_equipe" src="../../assets/images/logo_equipe.png" alt="">
        </div>
        <div class="container">
            <p id="p_footer" class="d-flex justify-content-center align-items-center">© ProTask. Todos os direitos reservados.</p>
        </div>
    </footer>
    
    <!-- Incluindo os arquivos JavaScript do Bootstrap (opcional) -->
    <script src="../styles/bootstrap/dist/js/jquery-3.5.1.min.js"></script>
    <script src="../js/js_modal/aparecemodal.js"></script>
    <script src="../styles/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>  -->

    <?php echoModal()?>
</body>
</html>