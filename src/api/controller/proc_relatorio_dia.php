<?php
include_once('../../../conection.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe a data selecionada do formulário (formato "YYYY-MM-DD")
    $data_selecionada = filter_input(INPUT_POST, 'dia', FILTER_SANITIZE_STRING);

    // Extrai o ano, mês e dia da data selecionada
    list($ano, $mes, $dia) = explode('-', $data_selecionada);

    // Define o primeiro e o último segundo do dia selecionado
    $inicio_dia = "$ano-$mes-$dia 00:00:00";
    $fim_dia = "$ano-$mes-$dia 23:59:59";

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

    // Consulta para o total de ordens no dia
    executarConsulta("SELECT COUNT(ID_ORDEM) AS total_ordens FROM ordem WHERE CRIADO BETWEEN '$inicio_dia' AND '$fim_dia'", $resultados, 'total_ordens');

    // Consulta para o total de pendentes no dia
    executarConsulta("SELECT COUNT(ID_ORDEM) AS total_pendente FROM ordem WHERE CRIADO BETWEEN '$inicio_dia' AND '$fim_dia' AND STATUS = 'PENDENTE'", $resultados, 'total_pendente');

    // Consulta para o total de em andamento no dia
    executarConsulta("SELECT COUNT(ID_ORDEM) AS andamento FROM ordem WHERE CRIADO BETWEEN '$inicio_dia' AND '$fim_dia' AND STATUS = 'EM ANDAMENTO'", $resultados, 'andamento');

    // Consulta para o total de concluído no dia
    executarConsulta("SELECT COUNT(ID_ORDEM) AS concluido FROM ordem WHERE CRIADO BETWEEN '$inicio_dia' AND '$fim_dia' AND STATUS = 'CONCLUIDO'", $resultados, 'concluido');

    // Consulta para o total de canceladas no dia
    executarConsulta("SELECT COUNT(ID_ORDEM) AS cancelado FROM ordem WHERE CRIADO BETWEEN '$inicio_dia' AND '$fim_dia' AND STATUS = 'CANCELADO'", $resultados, 'cancelado');

    // Envie os resultados como JSON de volta ao JavaScript
    header('Content-Type: application/json');
    echo json_encode(array('data' => $resultados));
} else {
    // Se a solicitação não for POST, envie uma resposta de erro.
    $_SESSION['msg'] = "<p style='color:red;'>Não foi possível</p>";
    header('location: lista_chamados.php');
}
?>
