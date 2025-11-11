<?php
include_once('../../../conection.php');
$result_usuario = "SELECT * FROM funcionarios WHERE STATUS_FUNCIONARIO = 'ATIVO'";

$resultado_usuario = mysqli_query($conn, $result_usuario);

while ($row_usuario = mysqli_fetch_assoc($resultado_usuario)) {
    $imagem_blob = $row_usuario['IMAGEM_FUNCIONARIO']; // Substitua 'IMAGEM_FUNCIONARIO' pelo nome da coluna onde está armazenada a imagem BLOB no seu banco de dados

    // Verifique se a imagem não está vazia
    if (!empty($imagem_blob)) {

        $tipo_mime = 'image/PNG'; // Defina o tipo MIME correto aqui

        $imagem_base64 = base64_encode($imagem_blob);
        echo '<img src="data:' . $tipo_mime . ';base64,' . $imagem_base64 . '" alt="' . $row_usuario['NOME_FUNCIONARIO'] . '"  />';
    } else {
        echo 'Imagem vazia ou inválida para ' . $row_usuario['NOME_FUNCIONARIO'];
    }
}
?>

 