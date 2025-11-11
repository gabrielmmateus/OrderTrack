<?php
  session_start();
  if ($_SESSION['login'] != 1) {
    header("Location: ./login.php");
    exit;
  }
  include_once('../../conection.php');
  
  $id = $_GET['id'];
  $result_funcionario = "SELECT * FROM funcionarios WHERE ID_FUNCIONARIO = '$id'";
  $query_funcionario = mysqli_query($conn, $result_funcionario);
  $row_funcionario = mysqli_fetch_assoc($query_funcionario);
  $_SESSION['id'] = $id;
?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="png" href="../../assets/images/icone_logo.png">
    <title>Editar Funcionários</title>
    <link href="../styles/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="../styles/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../styles/editar_funcionario/styles.css">

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

    <div class="container container-form col-6">

      <h2 class="d-flex justify-content-center align-items-center titulo">Editar Funcionário</h2>

      <form class="cont-form" method="post" action="../../src/api/controller/proc_edit_funcionario.php" enctype="multipart/form-data">

          <div class="form-group">

              <label for="nomeFuncionario">Nome do Funcionário:</label>

              <input type="text" class="form-control" id="nomeFuncionario" name="nome" value="<?php echo $row_funcionario['NOME_FUNCIONARIO'] ." ". $row_funcionario['SOBRENOME_FUNCIONARIO'] ?>" required>

          </div>



          <div style="display: flex; flex-direction: column; justify-content: center;">

              <div>

                  <label for="imagemUpload" class="form-label">Foto:</label>

                  <div class="div_foto">
                  
                  <!-- printar imagem -->
                    <?php
                           // Verifique se a imagem não está vazia
                      if (!empty($row_funcionario['IMAGEM_FUNCIONARIO'])) {
                        $tipo_mime = 'image/png'; // Defin4 o tipo MIME correto aqui (exemplo: image/png)
                        $imagem_base64 = base64_encode($row_funcionario['IMAGEM_FUNCIONARIO']);//Codifica a imagem do funcionário em uma representação em base64.
                        echo '<img src="data:' . $tipo_mime . ';base64,' . $imagem_base64 . '" alt="' . $row_funcionario['NOME_FUNCIONARIO'] . '" class="funcionario-img">';
                    } else {
                        // Caso a imagem esteja vazia, você pode exibir uma imagem padrão ou uma mensagem de erro.
                        echo '<img src="../../assets/images/telaPrincipal/funcionario.png" alt="' . $row_funcionario['NOME_FUNCIONARIO'] . '" class="funcionario-img">';
                    }
                    ?>
                    

                  </div>
                  
                  <div class="input_imagem">
                    <input type="file" id="imagem" name="imagem" accept="image/*">
                  </div>

              </div>

              <div>

                <div class="form-group status">
                  <label for="statusSelect">Status:</label>
                    <select class="form-select" name='status' style="width: 200px;" id="status">
                        <?php
                        $statusFuncionario = $row_funcionario['STATUS_FUNCIONARIO'];

                        if ($statusFuncionario == 'ATIVO') {
                            echo '<option value="ATIVO">ATIVO</option>';
                            echo '<option value="INATIVO">DESATIVAR</option>';
                        } else {
                            echo '<option value="INATIVO">INATIVO</option>';
                            echo '<option value="ATIVO">ATIVAR</option>';
                        }
                        ?>
                    </select>
                </div>

              </div>

          </div>



          <div class="d-flex justify-content-center align-items-center" style="margin-top: 50px;">

              <button type="submit" class="btn">Enviar</button>

          </div>

      </form>


    </div>

</div>

 

<script>

function displayFileName() {
  const fileInput = document.getElementById('imagem');
  const fileNameDisplay = document.getElementById('file-name');

  if (fileInput.files.length > 0) {
    fileNameDisplay.textContent = fileInput.files[0].name;
    fileNameDisplay.style.display = 'block';
  } else {
    fileNameDisplay.textContent = 'Nenhum arquivo escolhido';
    fileNameDisplay.style.display = 'none';
  }
}

    function previewImagem(input) {

        var imagemPreview = document.getElementById('imagemPreview');

        if (input.files && input.files[0]) {

            var reader = new FileReader();

            reader.onload = function (e) {

                imagemPreview.src = e.target.result;

            };

            reader.readAsDataURL(input.files[0]);

        }

    }

</script>

 

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