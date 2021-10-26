<?php
    session_start();

    include_once('../DAL/db.php');
    include_once('../DAL/database.php');

        
    if(isset($_POST['submit'])){
        $nome = $_POST['userName'] ? $_POST['userName'] : false;
        $email = $_POST['userEmail'] ? $_POST['userEmail'] : false;
        $pswd = $_POST['userPassword'] ? $_POST['userPassword'] : false;
        $pswd_confirm = $_POST['userPasswordConfirm'] ? $_POST['userPasswordConfirm'] : false;
        $adm_padrao = "N";
        $usuario_desc = "";
    
        if (($nome) && ($email) && ($pswd) && ($pswd_confirm)) {
            if (($pswd == $pswd_confirm)) {
                $result = mysqli_query($conexao,
                "INSERT INTO usuarios(usuario_id, usuario_nome, usuario_email, usuario_senha, usuario_admin, usuario_descricao) 
                VALUES (null, '$nome', '$email', '$pswd', '$adm_padrao', '$usuario_desc');");
                header('Location: ./login.php');
            }
        }
        /*
        //Fazendo email para confirmar a criação da conta
        $id = "SELECT usuario_id FROM usuarios WHERE usuario_nome ='$nome'";

        $resultId = mysqli_query ($conexao, $id);
        $row = mysqli_num_rows($resultId);
        var_dump($row);

        //Preparando mensagem
        $assunto = "Confirme seu cadastro";
        $link = "http://localhost/virtual_library_v1/views/confirmar.php?";
        $mensagem = "Clique aqui para confirmar seu cadastro ". $link;
        $header = "From: Virtual Library";

        mail($email, $assunto, $mensagem, $header);
        */
    
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="./img/icone-pagina.png" type="image/x-icon">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/criar_conta.css">
    <title>Virtual Library - criar conta</title>
</head>
<body>

<main>
        <a href="./login.php" style="color: #2227F0;">
            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="voltar bi bi-arrow-left-short" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
            </svg>
        </a>

        <section>
            <h1>Criar conta</h1>
            <form action="" method="post" name="criarConta">
                <div>
                    <label for="userName">Nome:</label>
                    <input type="text" id="userName" name="userName" autocomplete="off">
                </div>

                <div>
                    <label for="userEmail">Email:</label>
                    <input type="email" id="userEmail" name="userEmail" autocomplete="off">
                </div>

                <div>
                    <label for="userPassword">Senha:</label>
                    <div class="olho">
                        <input type="password" id="userPassword" name="userPassword">
                        <svg xmlns="http://www.w3.org/2000/svg" onclick="mudarTipoCriarConta(1)" width="25" height="25" fill="currentColor" class="bi bi-eye-fill olho" viewBox="0 0 16 16">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                            </svg>
                    </div>
                </div>

                <div>
                    <label for="userPasswordConfirm">Confirmar senha:</label>
                    <div class="olho">
                        <input type="password" id="userPasswordConfirm" name="userPasswordConfirm">
                        <svg xmlns="http://www.w3.org/2000/svg" onclick="mudarTipoCriarConta(2)" width="25" height="25" fill="currentColor" class="bi bi-eye-fill olho" viewBox="0 0 16 16">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                            </svg>
                    </div>
                </div>

                <div>
                    <input type="submit" name="submit" value="Criar conta">
                </div>
            </form>
        </section>
    </main>

    <script src="./js/alterarTipoCampo.js"></script>
</body>
</html>