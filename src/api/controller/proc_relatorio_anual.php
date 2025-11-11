<?php
include_once('../../../conection.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ano_selecionado = filter_input(INPUT_POST, 'ano', FILTER_SANITIZE_NUMBER_INT);

    // Define o primeiro e o último segundo do ano selecionado
    $primeiro_dia = "$ano_selecionado-01-01 00:00:00";
    $ultimo_dia = "$ano_selecionado-12-31 23:59:59";

    $resultados = array();

    // Função para executar consultas e adicionar resultados ao array com verificação de erro
    function executarConsulta($query, &$resultados, $chave) {
        global $conn;
        $result = mysqli_query($conn, $query);
        if ($result) {
            $resultado = mysqli_fetch_assoc($result);
            $resultados[] = $resultado[$chave];
        } else {
            $resultados[] = array('error' => mysqli_error($conn));
        }
    }

    // Consulta para o total de ordens no ano
    executarConsulta("SELECT COUNT(ID_ORDEM) AS total_ordens FROM ordem WHERE CRIADO BETWEEN '$primeiro_dia' AND '$ultimo_dia'", $resultados, 'total_ordens');

    // Consulta para o total de pendentes no ano
    executarConsulta("SELECT COUNT(ID_ORDEM) AS total_pendente FROM ordem WHERE CRIADO BETWEEN '$primeiro_dia' AND '$ultimo_dia' AND STATUS = 'PENDENTE'", $resultados, 'total_pendente');

    // Consulta para o total de em andamento no ano
    executarConsulta("SELECT COUNT(ID_ORDEM) AS total_andamento FROM ordem WHERE CRIADO BETWEEN '$primeiro_dia' AND '$ultimo_dia' AND STATUS = 'EM ANDAMENTO'", $resultados, 'total_andamento');

    // Consulta para o total de concluído no ano
    executarConsulta("SELECT COUNT(ID_ORDEM) AS total_concluido FROM ordem WHERE CRIADO BETWEEN '$primeiro_dia' AND '$ultimo_dia' AND STATUS = 'CONCLUIDO'", $resultados, 'total_concluido');

    // Consulta para o total de canceladas no ano
    executarConsulta("SELECT COUNT(ID_ORDEM) AS total_cancelado FROM ordem WHERE CRIADO BETWEEN '$primeiro_dia' AND '$ultimo_dia' AND STATUS = 'CANCELADO'", $resultados, 'total_cancelado');

    // Envie os resultados como JSON de volta ao JavaScript
    header('Content-Type: application/json');
    echo json_encode(array('data' => $resultados));
} else {
    // Se a solicitação não for POST, envie uma resposta de erro.
    $_SESSION['msg'] = "<p style='color:red;'>Não foi possível</p>";
    header('location:lista_chamados.php');
}
?>
