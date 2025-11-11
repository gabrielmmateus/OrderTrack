<?php
  include_once('../../conection.php');
  session_start();
  if ($_SESSION['login'] != 1) {
      header("Location: ./login.php");
      exit;
  }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Funcionários</title>
    <link rel="shortcut icon" type="png" href="../../assets/images/icone_logo.png">
    <link href="../styles/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="../styles/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../styles/lista_funcionarios/styles.css">
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
       

        <!-- Div com a Tabela de Chamados -->
        <div class="tabela">
            <div class="container cont_table">
                <div class="titulo">
                    <h1>Lista de Funcionários</h1>
                    <?php
                      if(isset($_SESSION['msg'])){//serve para dar a mensagem de cadastrado ou não//isset = basicamente verifica a existência de uma variável
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);//unset tira o valor da variavel ou finalizar
                    }
                    ?>
                </div>

        <?php


            // Select para pegar os dados de Todos os Funcionarios
            $result_usuario = "SELECT * FROM funcionarios";
        
            // QUERY COM O BANCO
            $resultado_usuario = mysqli_query($conn, $result_usuario);

            // Variavel $dados com os campos e dados da tabela
            $dados = "  
                        <div class='table-responsive'>
                            <table class='table  text-center' >
                                <thead class='th-heads'>
                                    <tr>
                                        <th style='background-color: #8CB2B0; color: #fff;' scope='col'>ID</th>
                                        <th style='background-color: #8CB2B0; color: #fff;'  scope='col'>Nome</th>
                                        <th style='background-color: #8CB2B0; color: #fff;'  scope='col'>Sobrenome</th>
                                        <th style='background-color: #8CB2B0; color: #fff;'  scope='col'>Status</th>
                                        <th style='background-color: #8CB2B0; color: #fff;'  scope='col'></th>
                                    </tr>
                                </thead>
                                <tbody>
            ";

            // Laço de Repetição para mostar todos os dados
            while($row_usuario = mysqli_fetch_assoc($resultado_usuario)){
                
                // id do Funcionario
                $id = $row_usuario['ID_FUNCIONARIO'];

                // Nome Completo do Funcionario
                $funcionario = $row_usuario['NOME_FUNCIONARIO'];
                $sobrenome = $row_usuario['SOBRENOME_FUNCIONARIO'];

                // Usuario
                $usuario = $row_usuario['USUARIO_FUNCIONARIO'];

                // Status do Funcionario
                $status = $row_usuario['STATUS_FUNCIONARIO']; 
                 
                // Concatenar a variavel $dados com os dados do laço de Repetição e criar uma <tr> para cada Funcionario
                $dados .= "
                            <tr class='tr-dados' style='font-size: 15px;'>
                                <td>$id</td>
                                <td>$funcionario</td>                          
                                <td>$sobrenome</td>                          
                        ";
                
                // Mudar a cor do Status da Ordem 
                if($status == "ATIVO"){

                  // ATIVO = VERDE
                  $dados .= "   <td style='color: green;'>$status</td>
                             ";

                }elseif($status == "INATIVO"){

                  // INATIVO = VERMELHO
                  $dados .= "   <td style='color: red;'>$status</td>
                              ";

                }

                // Verificar se o Funcionario esta Ativo ou Inativo, para alterar o link de Desativar e Ativar o funcionario
                if($status == "ATIVO"){
                    $dados .= " <td>
                                    <div class='btn-group dropend drop' >
                                        <button class='btn  dropdown-toggle' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-three-dots' viewBox='0 0 16 16'>
                                            <path d='M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z'/>
                                            </svg>
                                        </button>
                                        <ul class='dropdown-menu'>
                                            <li><a class='dropdown-item' href='./editar_funcionario.php?id=$id'>Editar Funcionário</a></li>
                                            <li><a class='dropdown-item' href='../api/controller/proc_desativar_usuario.php?id=$id'>Desativar Funcionário</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>";
                } elseif($status == "INATIVO"){
                    $dados .= " <td>
                                    <div class='dropdown drop' >
                                        <button class='btn  dropdown-toggle' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-three-dots' viewBox='0 0 16 16'>
                                            <path d='M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z'/>
                                            </svg>
                                        </button>
                                        <ul class='dropdown-menu'>
                                            <li><a class='dropdown-item' href='./editar_funcionario.php?id=$id'>Editar Funcionário</a></li>
                                            <li><a class='dropdown-item' href='../api/controller/proc_ativar_usuario.php?id=$id'>Ativar Funcionário</a></li>
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

            // Mostrar Todos o dados da variavel $dados
            echo $dados;

        ?>

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