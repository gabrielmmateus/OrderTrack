
<?php
  session_start();
  if(isset($_SESSION['login'])){
    if($_SESSION['login'] == 1){
      header('Location: ./menu.php');
    }
  }

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Incluindo os arquivos CSS do Bootstrap -->
    <link rel="shortcut icon" type="png" href="../../assets/images/icone_logo.png">
    <link href="../styles/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="../styles/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../src/styles/cadastro_funcionario/styles.css">

    <title>Login</title>

</head>

<body>

  <nav class="navbar navbar-expand-lg ">

    <div class="container">

      <a class="navbar-brand" href="../../index.php">

        <img src="../../assets/images/logo.png" id="logo" alt="Logo" width="30" height="30">

      
      </a>

    </div>
  </nav>
    
    <main>
          <div class="login-form">
              <h2>Login</h2>
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
              <form action="../api/controller/proc_login.php" method="post">
                  <input type="text" name="usuario" placeholder="Nome de Usuário" required>
                  <input type="password" name="senha" placeholder="Senha" required>
                  <div>
                      <a href="recuperar_senha.php" class="forget"> Esqueceu a senha?</a>
                  </div>
                  <button type="submit">Entrar</button>
              </form>
          </div>
        
    </main>
    
    <footer>
        <p>&copy; ProTask . Todos os direitos reservados.</p>
    </footer>

    <!-- Incluindo os arquivos JavaScript do Bootstrap (opcional) -->
    <script src="../styles/bootstrap/dist/js/jquery-3.5.1.min.js"></script>
    <script src="../styles/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
