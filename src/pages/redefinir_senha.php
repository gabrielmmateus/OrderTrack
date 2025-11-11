<!DOCTYPE html>

<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Incluindo os arquivos CSS do Bootstrap -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="../../src/styles/redefinir_senha/styles.css">
    <link rel="shortcut icon" type="png" href="../../assets/images/icone_logo.png">
    <title>Redefinição de Senha</title>

</head>

<body>

  <nav class="navbar navbar-expand-lg ">

    <div class="container">

      <a class="navbar-brand" href="menu.php">

        <img src="../../assets/images/logo.png" id="logo" alt="Logo" width="30" height="30">

      
      </a>

    </div>
  </nav>
    
    <main>
          <div class="login-form">
              <h2>Redefinição de Senha</h2>
              <?php
                session_start();
                if (isset($_SESSION['msg'])) {
                    echo($_SESSION['msg'] . "<br>");
                    unset($_SESSION['msg']);
                }
              ?>
              <form action="../api/controller/proc_login.php" method="post">
                  <input type="password" name="password" placeholder="Digite a nova Senha" required>

                  <input type="password" name="password" placeholder="Digite novamente a nova Senha" required>
                  <button type="submit">Redefinir Senha</button>
              </form>
          </div>
        
    </main>
    
    <footer>
        <p>&copy; ProTask . Todos os direitos reservados.</p>
    </footer>
    <!-- Incluindo os arquivos JavaScript do Bootstrap (opcional) -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
