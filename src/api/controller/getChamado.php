<?php
include_once('../../../conection.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$response = [];

if (isset($_GET['chamadoID'])) {
    $chamadoID = intval($_GET['chamadoID']);

    // Consulta para obter detalhes específicos do chamado
    $queryChamado = "SELECT o.*, h.* 
    FROM ordem o 
    JOIN rel r ON o.ID_ORDEM = r.FK_ORDEM 
    LEFT JOIN historico_ordem h ON r.FK_HISTORICO = h.ID_HISTORICO 
    WHERE o.ID_ORDEM = ?";
    
    $stmtChamado = $conn->prepare($queryChamado);
    $stmtChamado->bind_param("i", $chamadoID);
    $stmtChamado->execute();
    $chamado = $stmtChamado->get_result()->fetch_assoc();

    if (!$chamado) {
        echo json_encode(["error" => "Chamado não encontrado"]);
        exit;   
    }
    
    if (isset($_GET['tipo']) && $_GET['tipo'] === 'imagem') {
        // Enviar somente a imagem
        if (!empty($chamado['FOTO'])) {
            $tipo_mime = 'image/png'; // Altere conforme necessário
            $imagem_base64 = base64_encode($chamado['FOTO']);
            echo json_encode(["imagemBase64" => $imagem_base64, "tipoMime" => $tipo_mime]);
        } else {
            echo json_encode(["error" => "Imagem não encontrada"]);
        }
    } else {
        // Enviar os detalhes do chamado sem a imagem
        unset($chamado['FOTO']); // Remover a imagem do array
        echo json_encode(["success" => true, "chamado" => $chamado]);
    }
    exit;
}

echo json_encode(["error" => "ID do chamado não fornecido"]);
?>