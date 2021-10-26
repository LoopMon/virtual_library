<?php
    session_start();
    include_once('../DAL/db.php');



    if(isset($_POST['submit'])){

        $nome = $_POST['userName'] ? $_POST['userName'] : false;
        $pswd = $_POST['userPassword'] ? $_POST['userPassword'] : false;
        $id = 0;

        

        //Se um campo estiver vazio o login não ocorrerá
        if (($nome) && ($pswd)){
            $query = "SELECT usuario_id, usuario_nome FROM usuarios WHERE usuario_nome = '{$nome}' AND usuario_senha = '{$pswd}';";

            $result = mysqli_query($conexao, $query);

            $row = mysqli_num_rows($result);
        
            //VALIDAÇÃO
            if($row ==1){
                $_SESSION['usuario'] = $nome;
                $_SESSION['id'] = mysqli_fetch_assoc($result);
                $_SESSION['desc'] = "";
                $_SESSION['descConfirm'] = 0;
                header('Location: ./home.php');
                exit();
            }
        }

    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="./img/icone-pagina.png" type="image/x-icon">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/login.css">
    <title>Virtual Library - Login</title>
</head>
<body>
    
<main>
        <section class="area-1">
            <img src="./img/icone-grande.png" alt="icone VL">
        </section>

        <section class="area-2">
            <h1>Login</h1>
            <form action="" method="post" name="login">

                <div class="nome-usuario">
                    <label for="userName">Nome de usuário:</label>
                    <input type="text" id="userName" name="userName">
                </div>

                <div class="senha-usuario">
                    <label for="userPassword">Senha:</label>
                    <div>
                        <input type="password" name="userPassword" id="userPassword">
                        <svg xmlns="http://www.w3.org/2000/svg" onclick="mudarTipoLogin(this)" width="20" height="20" fill="currentColor" class="bi bi-eye-fill olho" viewBox="0 0 16 16">
                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                        </svg>
                    </div>
                </div>

                <input id="btSb" type="button" name="submit" value="Acessar" onclick="validarCampos()">

                <footer>
                    <p>Sua primeira vez aqui? <a href="./criar-conta.php">Criar uma conta.</a></p>
                    <p>Esqueceu a senha? <a href="#">link</a></p>
                </footer>

            </form>
        </section>
        
        <div id="aviso" class="aviso avisoOff" onclick="esconderElemento()"><span class="txt">Usuário ou senha inválido!</span> <span>(clique para retornar)</span></div>

    </main>

    <script src="./js/alterarTipoCampo.js"></script>
    <script src="./js/validarCampos.js"></script>
    <script src="./js/aviso.js"></script>

</body>

</html>
