
<?php
    session_start();//permitir que os valores das variaveis,para poder ser transportados os valores da variaveis
    include_once("../../../conection.php");//inserindo o caminho do banco,no caso o mapeamento,a senha,usuario,nome do banco.
    //receber o id que vem com a url
    $id= filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);//pega o id externo no caso filtra//esse sanitazine tira qualquer sujeira

    if(!empty($id)){//significa se o campo id não estiver vazio ele vai executar//no caso esse empty significa vazio

        $result_usuario="UPDATE funcionarios SET STATUS_FUNCIONARIO = 'INATIVO' WHERE ID_FUNCIONARIO = '$id' ";//deletar da tabela cliente no campo id deletar no caso o id

        $resultado_usuario=mysqli_query($conn,$result_usuario); //variavel (conn) verifica se tem conexao do banco, query significa executar
        if(mysqli_affected_rows($conn)){//se eu encontar a conexao e realmente for modificado o registro 
            $_SESSION['msg'] = '<div class="notificacao">
            <div class="notificacao-div">
                <i class="bi bi-check-lg"></i>
                <div class="mensagem">
                    <span class="text text-1">Funcionario Desativado com Sucesso!</span>
                </div>
            </div>
            <i class="bi bi-x close"></i>
            <div class="tempo"></div>
        </div>';
            header("location: ../../pages/lista_funcionarios.php");//no casso aonde eu quero que apareça a mensagem de usuario deletado com sucesso
        }else{
            $_SESSION['msg'] = '<div class="notificacao" style="border-left: 6px solid red;">
                                    <div class="notificacao-div">
                                        <i class="bi bi-x-circle-fill"  style="color: red;"></i>
                                        <div class="mensagem">
                                            <span class="text text-1">Erro Funcionario NÃO foi Desativado!</span>
                                        </div>
                                    </div>
                                    <i class="bi bi-x close"  style="color: red;"></i>
                                    <div class="tempo tempo_error" style="background-color: #ddd;"></div>
                                </div>';
            header("location: ../../pages/lista_funcionarios.php");
        }

    }else{
        $_SESSION['msg'] = '<div class="notificacao" style="border-left: 6px solid red;">
                                <div class="notificacao-div">
                                    <i class="bi bi-x-circle-fill" style="color: red;"></i>
                                    <div class="mensagem">
                                        <span class="text text-1">Selecione um Funcionário!</span>
                                    </div>
                                </div>
                                <i class="bi bi-x close"  style="color: red;"></i>
                                <div class="tempo tempo_error" style="background-color: #ddd;"></div>
                            </div>';
        header("location: ../../pages/lista_funcionarios.php");
    }




?>