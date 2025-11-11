<?php
    include_once('../../conection.php');
    session_start();
    if ($_SESSION['login'] != 1) {
        header("Location: ./login.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabela</title>
    <link rel="shortcut icon" type="png" href="../../assets/images/icone_logo.png">
    <link href="../styles/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="../styles/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../styles/lista_chamados/style.css">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg ">
        <div class="container">
            <a class="navbar-brand" href="./menu.php">
                <img src="../../assets/images/logo.png" id="logo" alt="Logo" width="30" height="30">
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end header" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link linkss" href="../../index.php">Home</a>
                    </li>

                    <li class="nav-item dropdown linkss">
                        <a class="nav-link dropdown-toggle" href="#" id="chamadosDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Chamados <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                            </svg>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="chamadosDropdown">
                            <a class="dropdown-item" href="./lista_chamados.php">Lista de Chamados</a>
                            <a class="dropdown-item" href="./abrir_chamado.php">Abrir Chamado</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown linkss">
                        <a class="nav-link dropdown-toggle" href="#" id="funcionariosDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Funcionários <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                            </svg>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="funcionariosDropdown">
                            <a class="dropdown-item" href="./lista_funcionarios.php">Lista de Funcionários</a>
                            <a class="dropdown-item" href="./cadastro_funcionario.php">Cadastrar Funcionário</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <?php
    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
    echo '<script>
        const notificacao = document.querySelector(".notificacao");
        const tempo = document.querySelector(".tempo");
        let timer1;

        if (notificacao) {
            notificacao.classList.add("active");
            tempo.classList.add("active");
            timer1 = setTimeout(() => {
                notificacao.classList.remove("active");
                tempo.classList.remove("active");
                notificacao.style.display = "none";
            }, 5000); // 1s = 1000 milliseconds
        }

        const closeIcon = document.querySelector(".close");

        if (closeIcon) {
            closeIcon.addEventListener("click", () => {
                notificacao.classList.remove("active");
                tempo.classList.remove("active");
                notificacao.style.display = "none";
                clearTimeout(timer1);
            });
        }

        
    </script>';
    unset($_SESSION['msg']);
    }
    ?>

    <!-- Titulo -->
    <div class="titulo container">
        <h1>Lista de Chamados</h1>
    </div>


    <!-- Div com a Tabela de Chamados / Filtros / Navegação de Paginas -->
    <div class="tabela">

        
        <div class="cont_table">
            
            <!-- Filtros -->
            <div class="row colunas" style="margin: 0px;">

            <?php 

                // Variavel com os filtros 
                $filters = "
                <div class='dfiltros col-xl-2 row'>
                <div class='filtro1 col'>
                    <label class='label_filtro'>Filtrar por Status:</label>
                    <select id='statusFilter' name='status' 
                     onchange='applyStatusFilter()'>
                        <option id='selecionado_option1'></option>
                        <option value='TODOS'>Todos</option>
                        <option value='EM ANDAMENTO'>Em andamento</option>
                        <option value='CONCLUIDO'>Concluído</option>
                        <option value='PENDENTE'>Pendente</option>
                        <option value='CANCELADO'>CANCELADO</option>
                    </select>
                </div>
                <div class='filtro2 col'>
                    <label class='filtroLabelFuncionarios'>Filtrar por Funcionário:</label>
                    <select id='statusFilter2' name='funcionario' onchange='applyStatusFilter()'>
                        <option id='selecionado_option2'></option>
                        <option value='TODOS'>TODOS</option>
                        ";
                        // Query para pegar todos os funcionarios Ativos
                        $resultados_funcionarios = "SELECT * FROM funcionarios";
                        $query_funcionarios = mysqli_query($conn, $resultados_funcionarios);
              
                        while($row_funcionarios = mysqli_fetch_assoc($query_funcionarios)){
              
                            $funcionarios = $row_funcionarios['NOME_FUNCIONARIO'];
                            $sobrenome = $row_funcionarios['SOBRENOME_FUNCIONARIO'];
                                        
                            $filters .= "<option value='$funcionarios $sobrenome' name='funcionario'>$funcionarios $sobrenome</option>";        
                        };


                        $filters .= "
                        
                    </select>
                </div>
                <div class='filtro3 col'>
                    <label class='filtroLabelOrdem'>Ordem: Crescente ou Decrescente:</label>
                    <select id='statusFilter3' name='ordem' onchange='applyStatusFilter()'>
                        <option id='selecionado_option3'></option>
                        <option value='Decrescente'>Decrescente</option>
                        <option value='Crescente'>Crescente</option>
                    </select>
                </div>
    
            </div>


                ";
            
            // Mostrar conteudo da Variavel $filters
            echo $filters;
            

            //RECEBER O NÚMERO DA PAGINA
            $pagina_atual = filter_input(INPUT_GET, 'pagina', FILTER_SANITIZE_NUMBER_INT);
            $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;

            //Setar a quantidade de itens por pagina
            $qnt_result_pg = 10;

            //calcular o inicio visualização
            $inicio = ($qnt_result_pg * $pagina) - $qnt_result_pg;

            //Verificar se existe algum Ordem no $_GET / Para Ordem: CRESCENTE OU DECRESCENTE
            if (isset($_GET['ordem']) && !empty($_GET['ordem'])) {

                // Variavel que ira para URL atraves do $_GET e para o link na paginação
                $ordem_get = $_GET['ordem'];

                if ($ordem_get == 'Decrescente') {

                    // Variavel que ira para o Select
                    $ordem = 'DESC';
                } else if ($ordem_get == 'Crescente') {

                    // Variavel que ira para o Select
                    $ordem = 'ASC';
                }
            
            } else { // Se não existir nenhum $_GET['ordem'], a ordem sera Decrecente, para mostrar os Chamados mais recentes 

                // Variavel que ira para URL atraves do $_GET e para o link na paginação
                $ordem_get = 'Decrescente';

                // Variavel que ira para o Select
                $ordem = 'DESC';
            }


            // Verificar se existe algum Status no $_GET
            if ((isset($_GET['status']) && !empty($_GET['status']) and $_GET['status'] == 'TODOS') and (isset($_GET['funcionario']) && !empty($_GET['funcionario']) and $_GET['funcionario'] == 'TODOS')) {

                //Se o $_GET['status'] tiver o value de 'TODOS', mostar todos os Chamados
                $result_usuario = "SELECT * FROM ordem INNER JOIN rel ON ID_ORDEM = FK_ORDEM INNER JOIN historico_ordem ON rel.FK_HISTORICO = historico_ordem.ID_HISTORICO  INNER JOIN funcionarios ON FK_FUNCIONARIO = ID_FUNCIONARIO ORDER BY ID_ORDEM $ordem LIMIT $inicio, $qnt_result_pg";

            } else if ((isset($_GET['status']) && !empty($_GET['status'])) and (isset($_GET['funcionario']) && !empty($_GET['funcionario']))) { // Se existir algum value no $_GET['status'] e $_GET['funcionario']

                if ($_GET['status'] == 'TODOS' && $_GET['funcionario'] != 'TODOS') {

                    $status_filter = $_GET['funcionario'];
                    $separar_nome = explode(' ', $status_filter);

                    $nome_funcionario = $separar_nome[0];
                    $sobrenome_funcionario = $separar_nome[1];

                    $result_usuario = "SELECT * FROM ordem INNER JOIN rel ON ID_ORDEM = FK_ORDEM INNER JOIN historico_ordem ON rel.FK_HISTORICO = historico_ordem.ID_HISTORICO  INNER JOIN funcionarios ON FK_FUNCIONARIO = ID_FUNCIONARIO WHERE NOME_FUNCIONARIO = '$nome_funcionario' AND SOBRENOME_FUNCIONARIO = '$sobrenome_funcionario' ORDER BY ID_ORDEM $ordem LIMIT $inicio, $qnt_result_pg";

                } else if ($_GET['status'] != 'TODOS' && $_GET['funcionario'] == 'TODOS') {

                    $status_filter = $_GET['status'];
                    $result_usuario = "SELECT * FROM ordem INNER JOIN rel ON ID_ORDEM = FK_ORDEM INNER JOIN historico_ordem ON rel.FK_HISTORICO = historico_ordem.ID_HISTORICO INNER JOIN funcionarios ON FK_FUNCIONARIO = ID_FUNCIONARIO WHERE STATUS = '$status_filter' ORDER BY ID_ORDEM $ordem LIMIT $inicio, $qnt_result_pg";
                
                } else if ($_GET['status'] != 'TODOS' && $_GET['funcionario'] != 'TODOS') {

                    $status_filter = $_GET['status'];

                    $status_filter2 = $_GET['funcionario'];
                    $separar_nome = explode(' ', $status_filter2);

                    $nome_funcionario = $separar_nome[0];
                    $sobrenome_funcionario = $separar_nome[1];

                    $result_usuario = "SELECT * FROM ordem INNER JOIN rel ON ID_ORDEM = FK_ORDEM INNER JOIN historico_ordem ON rel.FK_HISTORICO = historico_ordem.ID_HISTORICO  INNER JOIN funcionarios ON FK_FUNCIONARIO = ID_FUNCIONARIO WHERE STATUS = '$status_filter' AND NOME_FUNCIONARIO = '$nome_funcionario' AND SOBRENOME_FUNCIONARIO = '$sobrenome_funcionario' ORDER BY ID_ORDEM $ordem LIMIT $inicio, $qnt_result_pg";
                }

            } elseif (isset($_GET['status']) && !empty($_GET['status'])) { // Se existir apenas o $_Get['status'] 

                if ($_GET['status'] == 'TODOS') {

                    //Se o $_GET['status'] tiver o value de 'TODOS', mostar todos os Chamados
                    $result_usuario = "SELECT * FROM ordem INNER JOIN rel ON ID_ORDEM = FK_ORDEM INNER JOIN historico_ordem ON rel.FK_HISTORICO = historico_ordem.ID_HISTORICO  INNER JOIN funcionarios ON FK_FUNCIONARIO = ID_FUNCIONARIO ORDER BY ID_ORDEM $ordem LIMIT $inicio, $qnt_result_pg";
                
                } else {

                    //Se tiver algum value no $_GET['status'], mostar os Chamados com status que o usuario filtrou
                    $status_filter = $_GET['status'];
                    $result_usuario = "SELECT * FROM ordem INNER JOIN rel ON ID_ORDEM = FK_ORDEM INNER JOIN historico_ordem ON rel.FK_HISTORICO = historico_ordem.ID_HISTORICO  INNER JOIN funcionarios ON FK_FUNCIONARIO = ID_FUNCIONARIO WHERE STATUS = '$status_filter' ORDER BY ID_ORDEM $ordem LIMIT $inicio, $qnt_result_pg";
                
                }

            } else if (isset($_GET['funcionario']) && !empty($_GET['funcionario'])) { // Se existir apenas o $_Get['funcionario'] 

                //Se o $_GET['funcionario'] tiver o value de 'TODOS', mostar todos os Chamados
                if ($_GET['funcionario'] == 'TODOS') {

                    $result_usuario = "SELECT * FROM ordem INNER JOIN rel ON ID_ORDEM = FK_ORDEM INNER JOIN historico_ordem ON rel.FK_HISTORICO = historico_ordem.ID_HISTORICO  INNER JOIN funcionarios ON FK_FUNCIONARIO = ID_FUNCIONARIO ORDER BY ID_ORDEM $ordem LIMIT $inicio, $qnt_result_pg";
                
                } else {

                    $status_filter = $_GET['funcionario'];
                    $separar_nome = explode(' ', $status_filter);

                    $nome_funcionario = $separar_nome[0];
                    $sobrenome_funcionario = $separar_nome[1];
                    $result_usuario = "SELECT * FROM ordem INNER JOIN rel ON ID_ORDEM = FK_ORDEM INNER JOIN historico_ordem ON rel.FK_HISTORICO = historico_ordem.ID_HISTORICO  INNER JOIN funcionarios ON FK_FUNCIONARIO = ID_FUNCIONARIO WHERE NOME_FUNCIONARIO = '$nome_funcionario' AND SOBRENOME_FUNCIONARIO = '$sobrenome_funcionario' ORDER BY ID_ORDEM $ordem LIMIT $inicio, $qnt_result_pg";
                
                }

            } else {

                // Se não tiver nenhum value no $_GET mostrar todos os Chamados
                $result_usuario = "SELECT * FROM ordem INNER JOIN rel ON ID_ORDEM = FK_ORDEM INNER JOIN historico_ordem ON rel.FK_HISTORICO = historico_ordem.ID_HISTORICO INNER JOIN funcionarios ON rel.FK_FUNCIONARIO = funcionarios.ID_FUNCIONARIO ORDER BY ID_ORDEM $ordem LIMIT $inicio, $qnt_result_pg";
            }

            // QUERY COM O BANCO
            $resultado_usuario = mysqli_query($conn, $result_usuario);

            // Variavel $dados com os campos e dados da tabela
            $dados = "  
                        <div class='table-responsive  col-md-9'>
                            <table class='table  text-center' >
                                <thead class='th-heads'>
                                    <tr>
                                        <th style='background-color: #8CB2B0; color: #fff;' scope='col'>ID</th>
                                        <th style='background-color: #8CB2B0; color: #fff;'  scope='col'>Serviço</th>
                                        <th style='background-color: #8CB2B0; color: #fff;'  scope='col'>Descrição</th>
                                        <th style='background-color: #8CB2B0; color: #fff;'  scope='col'>Localização</th>
                                        <th style='background-color: #8CB2B0; color: #fff;'  scope='col'>Funcionário</th>
                                        <th style='background-color: #8CB2B0; color: #fff;'  scope='col'>Data de Criação</th>
                                        <th style='background-color: #8CB2B0; color: #fff;'  scope='col'>Prazo</th>
                                        <th style='background-color: #8CB2B0; color: #fff;'  scope='col'>Data de Conclusão</th>
                                        <th style='background-color: #8CB2B0; color: #fff;'  scope='col'>Prioridade</th>
                                        <th style='background-color: #8CB2B0; color: #fff;'  scope='col'>Status</th>
                                        <th style='background-color: #8CB2B0; color: #fff;'  scope='col'></th>
                                    </tr>
                                </thead>
                                <tbody>
            ";



            // Laço de Repetição para mostar todos os dados dos chamados
            while ($row_usuario = mysqli_fetch_assoc($resultado_usuario)) {

                // id da Ordem
                $id = $row_usuario['ID_ORDEM'];

                // Serviço
                $servico  = $row_usuario['SERVICO'];

                // Item 
                $item = $row_usuario['ITEM'];

                // Localização
                $localizacao = $row_usuario['LOCALIZACAO'];

                // Funcionario
                $funcionario = $row_usuario['NOME_FUNCIONARIO'];

                $sobrenome_funcionario = $row_usuario['SOBRENOME_FUNCIONARIO'];

                // Urgencia
                $urgencia =  $row_usuario['PRIORIDADE'];

                // Status da Ordem
                $status = $row_usuario['STATUS'];

                // Formatar data, data de Criação do Chamado (DateTime)
                $datetime = $row_usuario['CRIADO'];
                $datehora = new DateTime($datetime);
                $data = $datehora->format("d/m/Y H:i:s");

                // Formatar data, Prazo (DateTime)
                $prazo = $row_usuario['PRAZO'];
                $datehora_prazo = new DateTime($prazo);
                $data_prazo = $datehora_prazo->format("d/m/Y");


                // Formatar data, data de Finalização (DateTime)
                $data_conclusao = $row_usuario['DATA_FINALIZACAO'];
                if ($data_conclusao == null) {
                    $data_finalizacao = ' ';
                } else {
                    $dataconclusao = new DateTime($data_conclusao);
                    $data_finalizacao = $dataconclusao->format("d/m/Y H:i:s");
                }


                // Concatenar a variavel $dados com os dados do laço de Repetição e criar uma <tr> para cada ordem
                $dados .= "
                            <tr class='tr-dados' style='font-size: 15px; text-align: center;'>
                                <td>$id</td>
                                <td>$servico</td>
                                <td><textarea readonly style='width: 300px; padding-left: 13px;  textarea::-webkit-scrollbar {
                                    width: 12px; }'>$item</textarea></td>
                                <td>$localizacao</td>
                                <td>$funcionario $sobrenome_funcionario</td>
                                <td>$data</td>
                                <td>$data_prazo</td>
                                <td>$data_finalizacao</td>
                                <td>$urgencia</td>
                              
                        ";

                // Mudar a cor do Status da Ordem 
                if ($status == "PENDENTE") {

                    // PENDENTE = PRETO
                    $dados .= "<td style='color: #FA9D4A;'>$status</td>";

                } elseif ($status == "CONCLUIDO") {

                    // CONCLUIDO = VERDE
                    $dados .= "<td style='color: green;'>$status</td>";

                } elseif ($status == "EM ANDAMENTO") {

                    // EM ANDAMENTO = AMARELO
                    $dados .= "<td style='color: #FFD929;'>$status</td>";

                } elseif ($status == "CANCELADO") {

                    // CANCELADO = VERMELHO
                    $dados .= "<td style='color: red; '>$status</td>";

                }

                if ($status != 'CANCELADO') {

                    // Dropdown menu para editar ou cancelar um chamado
                    $dados .= " <td>
                                <div class='btn-group dropend' >
                                  <button class='btn  dropdown-toggle' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-three-dots' viewBox='0 0 16 16'>
                                    <path d='M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z'/>
                                    </svg>
                                  </button>
                                  <ul class='dropdown-menu'>
                                    <li>
                                      <a class='dropdown-item' href='editar_chamado.php?id=$id'> 
                                        <svg id='svg-drop1' xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>
                                          <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
                                          <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'/>
                                        </svg>
                                        Editar
                                      </a>
                                    </li>
                                    <li>
                                      <a class='dropdown-item' href='../../src/api/controller/cancelar_chamado_lista.php?id=$id'>
                                      <svg id='svg-drop' xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-x-circle' viewBox='0 0 16 16'>
                                        <path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/>
                                        <path d='M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z'/>
                                      </svg>
                                      Cancelar
                                      </a>
                                    </li>
                                  </ul>
                                </div>
                              </td>
                          </tr>";
                } else {

                    // Dropdown menu para editar ou cancelar um chamado
                    $dados .= " <td>
                                <div class='btn-group dropend' >
                                  <button class='btn  dropdown-toggle' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-three-dots' viewBox='0 0 16 16'>
                                    <path d='M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z'/>
                                    </svg>
                                  </button>
                                  <ul class='dropdown-menu' style=''>
                                    <li>
                                      <a class='dropdown-item' href='editar_chamado.php?id=$id'> 
                                        <svg id='svg-drop1' xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>
                                          <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
                                          <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'/>
                                        </svg>
                                        Editar
                                      </a>
                                    </li>
                                  </ul>
                                </div>
                              </td>
                          </tr>";
                }
            }


            // TAGS PARA FECHAMENTO DAS </div> E A </table>
            $dados .= "             
                                    </tbody>
                                </table>
                            </div>
                        </div>
            ";

            // Mostrar Tabela com todos o dados
            echo $dados;



            ////  Paginação:   ///// 

            // Verificar se tem algum VALUE no $_GET['status'] == Todos
            if ((isset($_GET['status']) && !empty($_GET['status']) and $_GET['status'] == 'TODOS') and (isset($_GET['funcionnario']) && !empty($_GET['funcionario']) and $_GET['funcionario'] == 'TODOS')) {

                //Select para contar o id de todas as ordens
                $result_pg = "SELECT COUNT(ID_ORDEM) AS num_result FROM ordem";

            } elseif ((isset($_GET['status']) && !empty($_GET['status'])) and (isset($_GET['funcionario']) && !empty($_GET['funcionario']))) { //Verificar se tem algum value no $_GET['status']

                if ($_GET['status'] == 'TODOS' && $_GET['funcionario'] != 'TODOS') {

                    $filtro_paginacao = $_GET['funcionario'];
                    $separar_nome = explode(' ', $filtro_paginacao);

                    $filtro_nome_funcionario = $separar_nome[0];
                    $filtro_sobrenome_funcionario = $separar_nome[1];
                    $result_pg = "SELECT COUNT(ID_ORDEM) AS num_result FROM ordem INNER JOIN rel ON ID_ORDEM = FK_ORDEM INNER JOIN historico_ordem ON rel.FK_HISTORICO = historico_ordem.ID_HISTORICO  INNER JOIN funcionarios ON FK_FUNCIONARIO = ID_FUNCIONARIO WHERE NOME_FUNCIONARIO = '$filtro_nome_funcionario' AND SOBRENOME_FUNCIONARIO = '$filtro_sobrenome_funcionario'";


                } else if ($_GET['status'] != 'TODOS' && $_GET['funcionario'] == 'TODOS') {

                    $filtro_paginacao = $_GET['status'];
                    $result_pg = "SELECT COUNT(ID_ORDEM) AS num_result FROM ordem INNER JOIN rel ON ID_ORDEM = FK_ORDEM INNER JOIN historico_ordem ON rel.FK_HISTORICO = historico_ordem.ID_HISTORICO  INNER JOIN funcionarios ON FK_FUNCIONARIO = ID_FUNCIONARIO WHERE STATUS = '$filtro_paginacao'";
   

                } else if ((isset($_GET['status']) && !empty($_GET['status'])) and (isset($_GET['funcionario']) && !empty($_GET['funcionario']))) {

                    $filtro_paginacao = $_GET['status'];
                    $filtro_paginacao2 = $_GET['funcionario'];


                    if ($filtro_paginacao2 == 'TODOS') {

                        $result_pg = "SELECT COUNT(ID_ORDEM) AS num_result FROM ordem INNER JOIN rel ON ID_ORDEM = FK_ORDEM INNER JOIN historico_ordem ON rel.FK_HISTORICO = historico_ordem.ID_HISTORICO  INNER JOIN funcionarios ON FK_FUNCIONARIO = ID_FUNCIONARIO";

                    } else {
                        $separar_nome = explode(' ', $filtro_paginacao2);

                        $filtro_nome_funcionario = $separar_nome[0];
                        $filtro_sobrenome_funcionario = $separar_nome[1];

                        $result_pg = "SELECT COUNT(ID_ORDEM) AS num_result FROM ordem INNER JOIN rel ON ID_ORDEM = FK_ORDEM INNER JOIN historico_ordem ON rel.FK_HISTORICO = historico_ordem.ID_HISTORICO  INNER JOIN funcionarios ON FK_FUNCIONARIO = ID_FUNCIONARIO WHERE STATUS = '$filtro_paginacao' AND NOME_FUNCIONARIO = '$filtro_nome_funcionario' AND SOBRENOME_FUNCIONARIO = '$filtro_sobrenome_funcionario'";
     
                    }
                }

            } else if (isset($_GET['status']) && !empty($_GET['status'])) {

                $filtro_paginacao = $_GET['status'];

                if ($filtro_paginacao == 'TODOS') {

                    $result_pg = "SELECT COUNT(ID_ORDEM) AS num_result FROM ordem ";
    
                } else {

                    $result_pg = "SELECT COUNT(ID_ORDEM) AS num_result FROM ordem WHERE STATUS = '$filtro_paginacao'";
             

                }
            } else if (isset($_GET['funcionario']) && !empty($_GET['funcionario'])) {

                $filtro_paginacao = $_GET['funcionario'];

                $separar_nome = explode(' ', $filtro_paginacao);

                $filtro_nome_funcionario = $separar_nome[0];
                $filtro_sobrenome_funcionario = $separar_nome[1];

                if ($filtro_paginacao == 'TODOS') {

                    $result_pg = "SELECT COUNT(ID_ORDEM) AS num_result FROM ordem INNER JOIN rel ON ID_ORDEM = FK_ORDEM INNER JOIN historico_ordem ON rel.FK_HISTORICO = historico_ordem.ID_HISTORICO  INNER JOIN funcionarios ON FK_FUNCIONARIO = ID_FUNCIONARIO";
                    
                } else {

                    $result_pg = "SELECT COUNT(ID_ORDEM) AS num_result FROM ordem INNER JOIN rel ON ID_ORDEM = FK_ORDEM INNER JOIN historico_ordem ON rel.FK_HISTORICO = historico_ordem.ID_HISTORICO  INNER JOIN funcionarios ON FK_FUNCIONARIO = ID_FUNCIONARIO WHERE NOME_FUNCIONARIO = '$filtro_nome_funcionario' AND SOBRENOME_FUNCIONARIO = '$filtro_sobrenome_funcionario'";
                    
                }
            } else {

                // Se nao ouver nenhum value no $_GET mostrar todas os chamados
                $result_pg = "SELECT COUNT(ID_ORDEM) AS num_result FROM ordem INNER JOIN rel ON ID_ORDEM = FK_ORDEM INNER JOIN historico_ordem ON rel.FK_HISTORICO = historico_ordem.ID_HISTORICO  INNER JOIN funcionarios ON FK_FUNCIONARIO = ID_FUNCIONARIO";
                

            }

            // Query com o banco
            $resultado_pg = mysqli_query($conn, $result_pg);
            $row_pg = mysqli_fetch_assoc($resultado_pg);

            //Quantidade de pagina
            $quantidade_pg = ceil($row_pg['num_result'] / $qnt_result_pg);

            //Limitar os links nates depois
            $max_links = 2;



        $paginacao = "

                    <div class='container d-flex justify-content-end div-pag' style='margin-top: 25px; margin-bootom: 25px; '>
                      <nav aria-label='Page navigation example'>
                      <ul class='pagination'>    
        ";

            // Verificar se existe algum value no $_GET['status'] 
            if ((isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 'TODOS') and (isset($_GET['funcionario']) && !empty($_GET['funcionario']) && $_GET['funcionario'] == 'TODOS')) {

                //variavel com o value do $_GET
                $status_get = $_GET['status'];
                $funcionario_get = $_GET['funcionario'];
                
                if($quantidade_pg > 1){
                    $paginacao .= "<li class='page-item'><a class='page-link' href='lista_chamados.php?pagina=1&status=$status_get&funcionario=$funcionario_get&ordem=$ordem_get'>Primeira</a></li>";
                }else {
                    $paginacao .= "<li class='page-item page-link pag_disable_primeira'>Primeira</li>";
                }

                for ($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++) {
                    if ($pag_ant >= 1) {
                        $paginacao .= "<li class='page-item'><a class='page-link' href='lista_chamados.php?pagina=$pag_ant&status=$status_get&funcionario=$funcionario_get&ordem=$ordem_get'> $pag_ant </a></li>";
                    }
                }

                $paginacao .= "<li class='page-item page-link' style='background-color: #8CB2B0; color: #fff'>$pagina</li>";

                for ($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++) {
                    if ($pag_dep <= $quantidade_pg) {
                        $paginacao .= "<li class='page-item'><a  class='page-link' href='lista_chamados.php?pagina=$pag_dep&status=$status_get&funcionario=$funcionario_get&ordem=$ordem_get'> $pag_dep </a></li>";
                    }
                }

                if($quantidade_pg > 1){
                    $paginacao .= "<li class='page-item'><a class='page-link' href= 'lista_chamados.php?pagina=$quantidade_pg&status=$status_get&funcionario=$funcionario_get&ordem=$ordem_get'>  Última</a></li>";
                }else {
                    $paginacao .= "<li class='page-item page-link pag_disable_ultima'>Última</li>";
                }

                $paginacao .= "</ul></nav></div>";

            } else if ((isset($_GET['status']) && !empty($_GET['status'])) and (isset($_GET['funcionario']) && !empty($_GET['funcionario']))) {
               
                $status_get = $_GET['status'];
                $funcionario_get = $_GET['funcionario'];

                if($quantidade_pg > 1){
                    $paginacao .= "<li class='page-item'><a class='page-link' href='lista_chamados.php?pagina=1&status=$status_get&funcionario=$funcionario_get&ordem=$ordem_get'>Primeira</a></li>";
                }else {
                    $paginacao .= "<li class='page-item page-link pag_disable_primeira'>Primeira</li>";
                }


                for ($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++) {
                    if ($pag_ant >= 1) {
                        $paginacao .= "<li class='page-item'><a class='page-link' href='lista_chamados.php?pagina=$pag_ant&status=$status_get&funcionario=$funcionario_get&ordem=$ordem_get'> $pag_ant </a></li>";
                    }
                }

                $paginacao .= "<li class='page-item page-link' style='background-color: #8CB2B0; color: #fff'>$pagina</li>";
                for ($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++) {
                    if ($pag_dep <= $quantidade_pg) {
                        $paginacao .= "<li class='page-item'><a  class='page-link' href='lista_chamados.php?pagina=$pag_dep&status=$status_get&funcionario=$funcionario_get&ordem=$ordem_get'> $pag_dep </a></li>";
                    }
                }

                if($quantidade_pg > 1){
                    $paginacao .= "<li class='page-item'><a class='page-link' href= 'lista_chamados.php?pagina=$quantidade_pg&status=$status_get&funcionario=$funcionario_get&ordem=$ordem_get'>  Última</a></li>";
                }else{
                    $paginacao .= "<li class='page-item page-link pag_disable_ultima'>Última</li>";
                }

                $paginacao .= "</ul></nav></div>";

            } else if (isset($_GET['status']) && !empty($_GET['status'])) {
            
                $status_get = $_GET['status'];

                if($quantidade_pg > 1){
                    $paginacao .= "<li class='page-item'><a class='page-link' href='lista_chamados.php?pagina=1&status=$status_get&ordem=$ordem_get'>Primeira</a></li>";
                }else{
                    $paginacao .= "<li class='page-item page-link pag_disable_primeira'>Primeira</li>";
                }

                for ($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++) {
                    if ($pag_ant >= 1) {
                        $paginacao .= "<li class='page-item'><a class='page-link' href='lista_chamados.php?pagina=$pag_ant&status=$status_get&ordem=$ordem_get'> $pag_ant </a></li>";
                    }
                }

                $paginacao .= "<li class='page-item page-link' style='background-color: #8CB2B0; color: #fff'>$pagina</li>";
                for ($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++) {
                    if ($pag_dep <= $quantidade_pg) {
                        $paginacao .= "<li class='page-item'><a  class='page-link' href='lista_chamados.php?pagina=$pag_dep&status=$status_get&ordem=$ordem_get'> $pag_dep </a></li>";
                    }
                }

                if($quantidade_pg > 1){
                    $paginacao .= "<li class='page-item'><a class='page-link' href= 'lista_chamados.php?pagina=$quantidade_pg&status=$status_get&ordem=$ordem_get'>  Última</a></li>";
                }else{
                    $paginacao .= "<li class='page-item page-link pag_disable_ultima'>Última</li>";
                }

                $paginacao .= "</ul></nav></div>";

            } else if (isset($_GET['funcionario']) && !empty($_GET['funcionario'])) {
                
                $status_get = $_GET['funcionario'];

                if($quantidade_pg > 1){
                    $paginacao .= "<li class='page-item'><a class='page-link' href='lista_chamados.php?pagina=1&funcionario=$status_get&ordem=$ordem_get'>Primeira</a></li>";
                }else{
                    $paginacao .= "<li class='page-item page-link pag_disable_primeira'>Primeira</li>";
                }

                for ($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++) {
                    if ($pag_ant >= 1) {
                        $paginacao .= "<li class='page-item '><a class='page-link' href='lista_chamados.php?pagina=$pag_ant&funcionario=$status_get&ordem=$ordem_get'> $pag_ant </a></li>";
                    }
                }

                $paginacao .= "<li class='page-item page-link' style='background-color: #8CB2B0; color: #fff'>$pagina</li>";
                for ($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++) {
                    if ($pag_dep <= $quantidade_pg) {
                        $paginacao .= "<li class='page-item'><a  class='page-link' href='lista_chamados.php?pagina=$pag_dep&funcionario=$status_get&ordem=$ordem_get'> $pag_dep </a></li>";
                    }
                }

                if($quantidade_pg > 1){
                    $paginacao .= "<li class='page-item'><a class='page-link' href= 'lista_chamados.php?pagina=$quantidade_pg&funcionario=$status_get&ordem=$ordem_get'>  Última</a></li>";
                }else{
                    $paginacao .= "<li class='page-item page-link pag_disable_ultima'>Última</li>";
                }

                $paginacao .= "</ul></nav></div>";
            } else { // Se não existir nenhum value no $_GET 

                if($quantidade_pg > 1){
                    $paginacao .= "<li class='page-item'><a class='page-link' href='lista_chamados.php?pagina=1&ordem=$ordem_get'>Primeira</a></li>";
                }else{
                    $paginacao .= "<li class='page-item page-link pag_disable_primeira'>Primeira</li>";
                }
                for ($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++) {
                    if ($pag_ant >= 1) {
                        $paginacao .= "<li class='page-item'><a class='page-link' href='lista_chamados.php?pagina=$pag_ant&ordem=$ordem_get'> $pag_ant </a></li>";
                    }
                }

                $paginacao .= "<li class='page-item page-link' style='background-color: #8CB2B0; color: #fff'>$pagina</li>";
                for ($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++) {
                    if ($pag_dep <= $quantidade_pg) {
                        $paginacao .= "<li class='page-item'><a  class='page-link' href='lista_chamados.php?pagina=$pag_dep&ordem=$ordem_get'> $pag_dep </a></li>";
                    }
                }

                if($quantidade_pg > 1){
                    $paginacao .= "<li class='page-item'><a class='page-link' href= 'lista_chamados.php?pagina=$quantidade_pg&ordem=$ordem_get'>  Última</a></li>";
                }else{
                    $paginacao .= "<li class='page-item page-link pag_disable_ultima'>Última</li>";
                }

                $paginacao .= "</ul></nav></div></div>";
            }

            // mostrar a paginação
            echo $paginacao;



            // SCRIPT PARA O FILTRO. COLOCAR O STATUS QUE O USUARIO SELECIONAR NA URL
            echo '
                            <script>

                                  let url = window.location.href;
                                  let urlParams = new URLSearchParams(url.split("?")[1]);
                                  let nome = urlParams.get("funcionario");
                                  let status = urlParams.get("status");
                                  let ordem = urlParams.get("ordem");

                                  let option1 = document.getElementById("selecionado_option1");
                                  let option2 = document.getElementById("selecionado_option2");
                                  let option3 = document.getElementById("selecionado_option3");

                                  option1.innerText = status;
                                  option2.innerText = nome;
                                  option3.innerText = ordem;
                                 


                              function applyStatusFilter() {
                                  let selectedStatus = document.getElementById("statusFilter").value;
                                  let selectedStatusFuncionario = document.getElementById("statusFilter2").value;
                                  let selectedStatusOrdem = document.getElementById("statusFilter3").value;

                                  console.log(selectedStatus);
                                  
                                  

                                  if((selectedStatusFuncionario != false && selectedStatusFuncionario != " ") && (selectedStatus != false && selectedStatus != " " && selectedStatus != null)){
                                    window.location.href = "lista_chamados.php?pagina=1&status=" + selectedStatus +"&funcionario="+selectedStatusFuncionario+"&ordem="+selectedStatusOrdem
                                  }else if((selectedStatusFuncionario != false && selectedStatusFuncionario != " ") && (status != false && status != " " && status != null)){
                                    window.location.href = "lista_chamados.php?pagina=1&status=" + status +"&funcionario="+selectedStatusFuncionario+"&ordem="+selectedStatusOrdem
                                  } else if((selectedStatus != false && selectedStatus != " ")  &&  (nome != false && nome != " " && nome != null)){
                                    window.location.href = "lista_chamados.php?pagina=1&status=" + selectedStatus +"&funcionario="+nome+"&ordem="+selectedStatusOrdem
                                  }else if(selectedStatus != false && selectedStatus != " "){
                                    window.location.href = "lista_chamados.php?pagina=1&status=" + selectedStatus +"&ordem="+selectedStatusOrdem
                                  } else if(selectedStatusFuncionario != false && selectedStatusFuncionario != " "){
                                    window.location.href = "lista_chamados.php?pagina=1&funcionario=" + selectedStatusFuncionario +"&ordem="+selectedStatusOrdem
                                  } else if(selectedStatusOrdem != false && selectedStatusOrdem != " "){
                                    window.location.href = "lista_chamados.php?ordem=" + selectedStatusOrdem
                                  }
                              }

                            </script>
          ';

            ?>









            <style>
                
                    textarea::-webkit-scrollbar {
                     width: 12px; /* Ajuste a largura aqui */

                        }
                
            </style>










            <!-- Footer -->


        </div>
    </div>

    <footer class="footer">
        <div>
            <img id="logo_equipe" src="../../assets/images/logo_equipe.png" alt="">
        </div>
        <div class="container">
            <p class="d-flex justify-content-center align-items-center">© ProTask. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script src="../styles/bootstrap/dist/js/jquery-3.5.1.min.js"></script>
    <script src="../styles/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>