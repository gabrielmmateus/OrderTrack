<?php
  session_start();
  include_once('../../conection.php');
  if ($_SESSION['login'] != 1) {
    header("Location: ./login.php");
    exit;
  }

  $id = $_GET['id'];
  $_SESSION['id'] = $id;
  $result_usuario="SELECT * FROM ordem WHERE ID_ORDEM = '$id'";//string para ver os campos da tabela identificados pelo id e sua inserção 
  $resultado_usuario= mysqli_query($conn, $result_usuario);// executa 
  $row_usuario = mysqli_fetch_assoc($resultado_usuario);// é usada para retornar uma matriz associativa representando a próxima linha no conjunto de resultados representado pelo parâmetro result , aonde cada chave representa o nome de uma coluna do conjunto de resultados.

  //setando data e hora do br
  date_default_timezone_set('America/Sao_Paulo');


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Chamado</title>
    <link rel="shortcut icon" type="png" href="../../assets/images/icone_logo.png">
    <link href="../styles/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="../styles/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../styles/editar_chamado/styles.css">
</head>
<body>
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
                  <a class="nav-link dropdown-toggle links" href="#" id="chamadosDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Chamados <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                      </svg>
                  </a>

                  <div class="dropdown-menu" aria-labelledby="chamadosDropdown">
                    <a class="dropdown-item" href="./lista_chamados.php">Lista de Chamados</a>
                    <a class="dropdown-item" href="./abrir_chamado.php">Abrir Chamado</a>
                  </div>
                </li>

                <li class="nav-item dropdown ">
                  <a class="nav-link dropdown-toggle linkss" href="#" id="funcionariosDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Funcionários <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                      </svg>
                  </a>

                  <div class="dropdown-menu" aria-labelledby="funcionariosDropdown">
                    <a class="dropdown-item" href="./lista_funcionarios.php">Lista de Funcionários</a>
                    <a class="dropdown-item" href="./cadastro_funcionario.php">Cadastrar Funcionário</a>
                  </div>
                </li>
              </ul>
            </div>
          </nav>
        </div>

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


      
    <div class="container">
      <div class="container container-form">
        <div class="text-start">
          <h2 class="d-flex justify-content-center align-items-center titulo">Editar Chamado</h2>
          <form class="cont-form" method="post" action= "../../src/api/controller/proc_edit_chamado.php">
            <div class="form-group">
                <label for="assunto">Título do Chamado: </label>
                <input type="text" class="form-control" id="assunto" name="titulo" value="<?php echo $row_usuario['SERVICO']; ?>" required>
            </div>             
            <div class="form-group">
                <label for="mensagem">Assunto: </label>
                <textarea class="form-control" id="mensagem" name="item" rows="4"  required><?php echo $row_usuario['ITEM']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="mensagem">Localização: </label>
                <input class="form-control" id="mensagem" name="local" rows="4" value="<?php echo $row_usuario['LOCALIZACAO']; ?>" required></input>
            </div>
            <div class="form-group">
              <label for="selectOption" class="form-label">Urgência: </label>
                <select name='urgencia' class="form-select " style="width: 200px;" id="selectOption" required>
            
                        <?php
                        $prioridade = $row_usuario['PRIORIDADE'];
                        switch ($prioridade) {
                            case 'ALTA':
                                ?>
                                <option value="ALTA" selected>ALTA</option>
                                <option value="MEDIA">MÉDIA</option>
                                <option value="BAIXA">BAIXA</option>
                                <?php
                                break;
                            case 'MEDIA':
                                ?>
                                <option value="MEDIA" selected>MÉDIA</option>
                                <option value="ALTA">ALTA</option>
                                <option value="BAIXA">BAIXA</option>
                                <?php
                                break;
                            case 'BAIXA':
                                ?>
                                <option value="BAIXA" selected>BAIXA</option>
                                <option value="ALTA">ALTA</option>
                                <option value="MEDIA">MÉDIA</option>
                                <?php
                                break;
                            default:
                                // Caso não corresponda a nenhum dos casos anteriores, exibe as opções padrão
                                ?>
                                <option value="ALTA">ALTA</option>
                                <option value="MEDIA">MÉDIA</option>
                                <option value="BAIXA">BAIXA</option>
                                <?php
                                break;
                        }
                        ?>
                </select>
            </div>
            <div class="form-group ">
              <label for="">Data Final: <span id="asterisco">*</span></label><br>
              <input type="date" name='prazo' id="inputDate" value="<?php echo $row_usuario['PRAZO']; ?>" min="<?php echo date("Y-m-d");?>" required>
            </div>
            <div class="form-group">
                <label for="selectOption" class="form-label">Funcionario: </label>
                <select class="form-select " name='funcionario' style="width: 200px;" id="selectOption" required>
                                
                                <?php 

                                  $resultados_funcionarios = "SELECT * FROM funcionarios WHERE STATUS_FUNCIONARIO = 'ATIVO'";
                                  $query_funcionarios = mysqli_query($conn, $resultados_funcionarios);

                                  $funcionarios = " ";
                                  while($row_funcionarios = mysqli_fetch_assoc($query_funcionarios)){
                        
                                      $funcionario = $row_funcionarios['NOME_FUNCIONARIO'];
                                      $sobrenome = $row_funcionarios['SOBRENOME_FUNCIONARIO'];
                                                  
                                      $funcionarios .= "<option value='$funcionario  $sobrenome' name='funcionario'>$funcionario  $sobrenome</option>";        
                                  };
                                  
                                  $result_funcionario_ordem = "SELECT * FROM ordem INNER JOIN rel ON ID_ORDEM = FK_ORDEM INNER JOIN historico_ordem ON rel.FK_HISTORICO = historico_ordem.ID_HISTORICO  INNER JOIN funcionarios ON FK_FUNCIONARIO = ID_FUNCIONARIO WHERE ID_ORDEM = '$id'";
                                  $query_funcionario_ordem = mysqli_query($conn, $result_funcionario_ordem);
                                  $funcionario_ordem = mysqli_fetch_assoc($query_funcionario_ordem);

                                  $nome_funcionario = $funcionario_ordem['NOME_FUNCIONARIO'];
                                  $sobrenome_funcionario = $funcionario_ordem['SOBRENOME_FUNCIONARIO'];

                                  echo "<option value='$nome_funcionario $sobrenome_funcionario'>$nome_funcionario $sobrenome_funcionario</option>";
                                  echo $funcionarios;

                                  $_SESSION['id_rel'] = $funcionario_ordem['ID_REL'];
                                  
                            
                                ?>
                  </select>
              </div>
                          <div class="form-group">
                              <label for="selectOption" class="form-label">Status Ordem: </label>
                              <select class="form-select " name='status' style="width: 200px;" id="selectOption" required>
                               

                                  <?php $status_select = $row_usuario['STATUS'];

                                  if ($status_select == 'PENDENTE') {
                                    echo '<option value="PENDENTE" selected>PENDENTE</option>';
                                    echo '<option value="EM ANDAMENTO">EM ANDAMENTO</option>';
                                    echo '<option value="CONCLUIDO">CONCLUÍDO</option>'; 
                                    echo '<option value="CANCELADO">CANCELADO</option>'; 

                                  }

                                  if ($status_select == 'EM ANDAMENTO') {
                                    echo '<option value="EM ANDAMENTO" selected>EM ANDAMENTO</option>';
                                    echo '<option value="PENDENTE">PENDENTE</option>';
                                    echo '<option value="CONCLUIDO">CONCLUÍDO</option>'; 
                                    echo '<option value="CANCELADO">CANCELADO</option>'; 
                                  }

                                  if ($status_select == 'CONCLUIDO') {
                                    echo '<option value="CONCLUIDO" selected>CONCLUÍDO</option>';
                                    echo '<option value="PENDENTE">PENDENTE</option>';
                                    echo '<option value="EM ANDAMENTO">EM ANDAMENTO</option>'; 
                                    echo '<option value="CANCELADO">CANCELADO</option>'; 
                                  }

                                  if ($status_select == 'CANCELADO') {
                                    echo '<option value="CANCELADO" selected>CANCELADO</option>';
                                    echo '<option value="PENDENTE">PENDENTE</option>';
                                    echo '<option value="EM ANDAMENTO">EM ANDAMENTO</option>'; 
                                    echo '<option value="CONCLUIDO">CONCLUÍDO</option>'; 
                                  }              
                                  ?>

                              </select>
                          </div>

                        <div class="d-flex justify-content-center align-items-center" style="margin-top: 50px;">
                            <button type="submit" class="btn ">Enviar</button>
                        </div>
                      </div>
          </form>
        </div>
      </div>
    </div>

    <footer class="footer">
        <div>
            <img id="logo_equipe" src="../../assets/images/logo_equipe.png" alt="">
        </div> 
        <div class="container">
          <p id="p_footer" class="d-flex justify-content-center align-items-center">© ProTask. Todos os direitos reservados.</p>

        </div>                
    </footer>
    
    
    <script src="../styles/bootstrap/dist/js/jquery-3.5.1.min.js"></script>
    <script src="../styles/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

      
    
</body>
</html>






