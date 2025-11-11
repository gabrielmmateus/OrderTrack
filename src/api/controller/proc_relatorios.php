<?php
include_once('../../../conection.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mes_selecionado = filter_input(INPUT_POST, 'mes', FILTER_SANITIZE_STRING);

    list($ano, $mes) = explode('-', $mes_selecionado);
    $primeiro_dia = "$ano-$mes-01 00:00:00";
    $ultimo_dia = date('Y-m-t 23:59:59', strtotime($primeiro_dia));

    $resultados = array();

    // Consulta para o total de ordens no mês
    $ordem_total = "SELECT COUNT(ID_ORDEM) AS total_ordens FROM ordem WHERE MONTH(CRIADO) = $mes";
    $result_total = mysqli_query($conn, $ordem_total);
    
    if ($result_total) {
        $resultado_total = mysqli_fetch_assoc($result_total);
        $resultados[] = $resultado_total['total_ordens'];

        // Consulta para o total de pendentes no mês
        $ordem_pendente = "SELECT COUNT(ID_ORDEM) AS total_pendente FROM ordem WHERE MONTH(CRIADO) = $mes AND STATUS = 'PENDENTE'";
        $result_pendente = mysqli_query($conn, $ordem_pendente);

        if ($result_pendente) {
            $total_pendente = mysqli_fetch_assoc($result_pendente);
            $resultados[] = $total_pendente['total_pendente'];

            // Consulta para o total de em andamento no mês
            $ordem_andamento = "SELECT COUNT(ID_ORDEM) AS andamento FROM ordem WHERE MONTH(CRIADO) = $mes AND STATUS = 'EM ANDAMENTO'";
            $result_andamento = mysqli_query($conn, $ordem_andamento);

            if ($result_andamento) {
                $resultado_andamento = mysqli_fetch_assoc($result_andamento);
                $resultados[] = $resultado_andamento['andamento'];

                // Consulta para o total de concluído no mês
                $ordem_concluido = "SELECT COUNT(ID_ORDEM) AS concluido FROM ordem WHERE MONTH(CRIADO) = $mes AND STATUS = 'CONCLUIDO'";
                $result_concluido = mysqli_query($conn, $ordem_concluido);

                if ($result_concluido) {
                    $resultado_concluido = mysqli_fetch_assoc($result_concluido);
                    $resultados[] = $resultado_concluido['concluido'];

                    // Consulta para o total de cancelado no mês
                    $ordem_cancelado = "SELECT COUNT(ID_ORDEM) AS cancelado FROM ordem WHERE MONTH(CRIADO) = $mes AND STATUS = 'CANCELADO'";
                    $result_cancelado = mysqli_query($conn, $ordem_cancelado);

                    if ($result_cancelado) {
                        $resultado_cancelado = mysqli_fetch_assoc($result_cancelado);
                        $resultados[] = $resultado_cancelado['cancelado'];

                        // Envie os resultados como JSON de volta ao JavaScript
                        header('Content-Type: application/json');
                        echo json_encode(array("data" => $resultados));
                    } else {
                        // Erro ao consultar o total de ordens canceladas
                        header('Content-Type: application/json');
                        echo json_encode(array("error" => "Erro ao consultar o total de ordens canceladas"));
                    }
                } else {
                    // Erro ao consultar o total de ordens concluídas
                    header('Content-Type: application/json');
                    echo json_encode(array("error" => "Erro ao consultar o total de ordens concluídas"));
                }
            } else {
                // Erro ao consultar o total de ordens em andamento
                header('Content-Type: application/json');
                echo json_encode(array("error" => "Erro ao consultar o total de ordens em andamento"));
            }
        } else {
            // Erro ao consultar o total de ordens pendentes
            header('Content-Type: application/json');
            echo json_encode(array("error" => "Erro ao consultar o total de ordens pendentes"));
        }
    } else {
        // Erro ao consultar o total de ordens no mês
        header('Content-Type: application/json');
        echo json_encode(array("error" => "Erro ao consultar o total de ordens no mês"));
    }
} else {
    // Se a solicitação não for POST, envie uma resposta de erro.
    header('Content-Type: application/json');
    echo json_encode(array("error" => "Solicitação inválida"));
}
?>
