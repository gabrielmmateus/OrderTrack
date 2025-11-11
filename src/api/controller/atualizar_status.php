<?php

include_once('../../../conection.php');

$idChamado = $_POST['chamadoID'];
$novoStatus = $_POST['novoStatus'];
date_default_timezone_set('America/Sao_Paulo');

// Log para depuração
error_log("Tentando atualizar o chamado ID: $idChamado para o status: $novoStatus");
error_log("ID do Chamado: " . $idChamado . ", Novo Status: " . $novoStatus);

$dataHoraAtual = date('Y-m-d H:i:s');

$sql = "UPDATE ordem SET STATUS = ? WHERE ID_ORDEM = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $novoStatus, $idChamado);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {

        if($novoStatus == "CONCLUIDO"){
            $update_data = "UPDATE historico_ordem INNER JOIN rel ON rel.FK_HISTORICO = historico_ordem.ID_HISTORICO SET historico_ordem.DATA_FINALIZACAO = '$dataHoraAtual' WHERE rel.FK_ORDEM = '$idChamado';";
            $upadade_query = mysqli_query($conn, $update_data);
        }

        echo "Status atualizadoo com sucesso.";
    } else {
        echo "Nenhuma atualização foi feita. Verifique o ID do chamado.";
    }
    echo "Status atualizado com sucesso. Linhas afetadas: " . $stmt->affected_rows;
} else {
    echo "Erro ao atualizar o status: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

















