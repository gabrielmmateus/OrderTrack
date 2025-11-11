<?php

include_once('../../../conection.php');
session_start();

$semana_selecionada = filter_input(INPUT_POST, 'semana', FILTER_SANITIZE_STRING);

if ($semana_selecionada) {
    // Extrai o ano e o número da semana da seleção
    list($ano_semana, $numero_semana) = explode('-W', $semana_selecionada);

    // Calcula o timestamp do primeiro dia da semana selecionada
    $primeiro_dia_timestamp = strtotime($ano_semana . 'W' . $numero_semana);

    // Calcula o timestamp do último dia da semana selecionada (adiciona 6 dias ao primeiro dia)
    $ultimo_dia_timestamp = strtotime("+6 days", $primeiro_dia_timestamp);

    // Formata as datas finais no formato Y-m-d
    $primeiro_dia_semana = date('Y-m-d', $primeiro_dia_timestamp);
    $ultimo_dia_semana = date('Y-m-d', $ultimo_dia_timestamp);

    // Converte as datas para o formato "datetime"
    $primeiro_dia_semana_datetime = $primeiro_dia_semana . ' 00:00:00';
    $ultimo_dia_semana_datetime = $ultimo_dia_semana . ' 23:59:59';

    // Query para obter estatísticas da semana
    $ordem_semana_total = "SELECT COUNT(ID_ORDEM) AS total_ordens_semanal FROM ordem WHERE CRIADO >= '$primeiro_dia_semana_datetime' AND CRIADO <= '$ultimo_dia_semana_datetime'";
    $result_semana_total = mysqli_query($conn, $ordem_semana_total);

    if ($result_semana_total) {
        $resultado_semana_total = mysqli_fetch_assoc($result_semana_total);

        //total de pendentes da semana
        $ordem_semana_pendentes = "SELECT COUNT(ID_ORDEM) AS total_ordens_pendentes FROM ordem WHERE CRIADO >= '$primeiro_dia_semana_datetime' AND CRIADO <= '$ultimo_dia_semana_datetime' AND STATUS = 'PENDENTE'";
        $result_semana_pendentes = mysqli_query($conn, $ordem_semana_pendentes);

        if ($result_semana_pendentes) {
            $resultado_semana_pendentes = mysqli_fetch_assoc($result_semana_pendentes);

            //total de ordens em andamento da semana
            $ordem_semana_andamento = "SELECT COUNT(ID_ORDEM) AS total_ordens_andamento FROM ordem WHERE CRIADO >= '$primeiro_dia_semana_datetime' AND CRIADO <= '$ultimo_dia_semana_datetime' AND  STATUS ='EM ANDAMENTO'";
            $result_semana_andamento = mysqli_query($conn, $ordem_semana_andamento);

            if ($result_semana_andamento) {
                $resultado_semana_andamento = mysqli_fetch_assoc($result_semana_andamento);

                // TOTAL DE ORDENS CONCLUIDAS
                $ordem_semana_concluido = "SELECT COUNT(ID_ORDEM) AS total_ordens_concluido FROM ordem WHERE CRIADO >= '$primeiro_dia_semana_datetime' AND CRIADO <= '$ultimo_dia_semana_datetime' AND STATUS = 'CONCLUIDO'";
                $result_semana_concluido = mysqli_query($conn, $ordem_semana_concluido);

                if ($result_semana_concluido) {
                    $resultado_semana_concluido = mysqli_fetch_assoc($result_semana_concluido);

                    // TOTAL DE ORDENS CANCELADAS
                    $ordem_semana_cancelado = "SELECT COUNT(ID_ORDEM) AS total_ordens_cancelado FROM ordem WHERE CRIADO >= '$primeiro_dia_semana_datetime' AND CRIADO <= '$ultimo_dia_semana_datetime' AND STATUS = 'CANCELADO'";
                    $result_semana_cancelado = mysqli_query($conn, $ordem_semana_cancelado);

                    if ($result_semana_cancelado) {
                        $resultado_semana_cancelado = mysqli_fetch_assoc($result_semana_cancelado);

                        $resultados = [
                            $resultado_semana_total['total_ordens_semanal'],
                            $resultado_semana_pendentes['total_ordens_pendentes'],
                            $resultado_semana_andamento['total_ordens_andamento'],
                            $resultado_semana_concluido['total_ordens_concluido'],
                            $resultado_semana_cancelado['total_ordens_cancelado']
                        ];

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
        // Erro ao consultar o total de ordens da semana
        header('Content-Type: application/json');
        echo json_encode(array("error" => "Erro ao consultar o total de ordens da semana"));
    }
} else {
    // Se 'semana_selecionada' não foi recebido, envie uma resposta de erro.
    header('Content-Type: application/json');
    echo json_encode(array("error" => "Semana não selecionada"));
}
?>
