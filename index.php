<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Incluindo os arquivos CSS do Bootstrap -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <link rel="shortcut icon" type="png" href="./assets/images/icone_logo.png">
    <link rel="stylesheet" href="src/styles/tela_inicial/styles.css">
    <title>Tela Inicial</title>

</head>

<body>

<nav class="navbar navbar-expand-lg ">

<div class="container">

    <a class="navbar-brand" href="index.php">

      <img src="assets/images/logo.png" id="logo" alt="Logo" width="30" height="30">

    
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

       <div class="collapse navbar-collapse justify-content-end header" id="navbarNav">
   
    </div>
  </nav>
</div>
<main>
    <div class="card">
    <a href="src/pages/tela_principal.php">
        <div class="imgBX">
            <img src="assets/images/telaInicial/funcionario.png" alt="Funcionário">
        </div>
        <div class="content">
            <div class="details">
                <h2>Funcionário</h2>
            </div>
        </div>
    </div>
    
    <div class="card">
    <a href="src/pages/login.php">
        <div class="imgBX">
            <img src="assets/images/telaInicial/administrador.png" alt="Administrador">
        </div>
        <div class="content">
            <div class="details">
                <h2>Administrador</h2>
            </div>
        </div>
    </div>
</main>

<footer class="mt-5">

    <p>&copy; ProTask . Todos os direitos reservados.</p>

</footer>
    
 
    <!-- Incluindo os arquivos JavaScript do Bootstrap (opcional) -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>







