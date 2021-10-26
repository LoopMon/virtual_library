<?php
    session_start();
    //Includes e requires
    include_once('../../../DAL/db.php');
    require_once("../../../Controller/ComentarioController.php");
    require_once("../../../Model/comentario.php");

    //Pegando o nome do usuário pela sessão
    $usu = $_SESSION['usuario'];


    //Instanciando um objeto da classe ComentarioController
    $comentarioController = new ComentarioController();

    $result = "";

    //Filtrando o que entra de valor
    if (filter_input (INPUT_POST, "btnSubmit", FILTER_SANITIZE_STRING)) {
        $comentario = new Comentario();

        $comentario->setNome ($usu);
        $comentario->setMensagem (filter_input(INPUT_POST, "txtComentario", FILTER_SANITIZE_STRING));
        $comentario->setLink ('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);

        $comentarioController->Cadastrar($comentario);

    }

    //Retornando comentários
    $listaComentario = $comentarioController->RetornarComentario('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset = "UTF-8">
    <title>Document</title>

    <link rel="stylesheet" href="./style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    
</head>
<body>
    <div class="conteudo">
        <!-- Área onde as mensagens são exibidas -->
        <div class = "mensagens">
            <?php
                foreach ($listaComentario as $comentario) {
            ?>
            <div class="mensagem-usuario">
                <h3> <?= $comentario->getNome() ?> </h3>
                <p> <?= $comentario->getMensagem() ?> </p>
            </div>
            <?php
            }
            ?>
        </div>

        <!-- Área de digitação do comentário -->
        <div class = "digitar-texto">
            <form method = "POST" class = "botoes" name = "frmComentario" if= "frmComentario">
                
                <label> <?php echo "{$usu}: "; ?> </label>

                <textarea name = "txtComentario" id = "txtComentario"> </textarea>
                    
                <input type = "submit" name = "btnSubmit" id = "btnSubmit" value = "Enviar">
                
            </form>
        </div>
    </div>
</body>
</html>