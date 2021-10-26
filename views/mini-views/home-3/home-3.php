<?php
    session_start();
    include_once("../../../DAL/db.php");

    //Pegando o id do usuário
    $usu_idAray = $_SESSION['id'];
    $usu_id = $usu_idAray['usuario_id'];

    //Altereando o nome do usuário
    if (isset ($_POST['submitNomeNovo'])){
        $nomeOld = $_SESSION['usuario'];
        $nomeNew = $_POST['nomeNEW'];
        $senha = $_POST['senhaParaNome'];
        
        $queryNome = "SELECT usuario_nome FROM usuarios WHERE usuario_nome = '$nomeOld' AND usuario_id = '$usu_id' 
        AND usuario_senha = '$senha';";
        $resultNome = mysqli_query($conexao, $queryNome);
        
        $rowsNome = mysqli_num_rows($resultNome);

        if ($rowsNome == 1){
            $queryMudarNome = "UPDATE usuarios
            SET usuario_nome = '$nomeNew'
            WHERE usuario_id = '$usu_id' AND usuario_senha = '$senha';";

            $resultMudarNome = mysqli_query($conexao, $queryMudarNome);
        }
        
    }

    //Alterar senha
    if (isset ($_POST['submitSenhaNova'])) {
        $senha_old = $_POST['senhaOld'];
        $senha_new = $_POST['senhaNew'];
        $senha_new_confirm = $_POST['senhaNewConfirm'];

        //Pegando a senha atual no banco de dados
        $query = "SELECT usuario_senha FROM usuarios WHERE usuario_id = $usu_id AND $senha_old = usuario_senha";
        $result = mysqli_query($conexao, $query);

        $rows = mysqli_num_rows($result);
        var_dump($rows);

        //Se haver resultado na consulta, fazer o update
        if ($rows == 1) {
            if ($senha_new == $senha_new_confirm) {
                $queryMudarSenha = "UPDATE usuarios
                SET usuario_senha = '$senha_new'
                WHERE usuario_id = '$usu_id' and usuario_senha = '$senha_old';";

                $resultMudarSenha = mysqli_query($conexao, $queryMudarSenha);


            }
        }
    }


    //Descrição do usuario
    if (isset ($_POST['submitDesc'])){
        $_SESSION['desc'] = $_POST['desc_usu'];
        $_SESSION['descConfirm'] = 1;
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Document</title>

    <link rel="stylesheet" href="./style.css">

</head>
<body>
    <!-- Área de configuração -->
    <div class="config">

        <!-- função de alterar nome do usuário -->
        <form action = "" method = "POST">
            <label for = "nomeUsuarioNovo" class="lb1">Alterar nome de usuário:</label>
            <input type = "text" id="nomeUsuarioNovo" name = "nomeNEW">

            <label for="nomeUsuarioNovo" class="lb2">Senha:</label>
            <input type="password" id="senhaUsuario" name = "senhaParaNome">

            <input type = "submit" class="btn" name = "submitNomeNovo" value = "Confirmar">
        </form>

        <!-- função de alterar o email do usuário -->
        <form action="" method="POST">
            <label for="emailUsuarioNovo">Alterar e-mail:</label>
            <input type="email" id="emailUsuarioNovo">
            
            <button>Alterar</button>    
        </form>

        <!-- função de alterar a senha do usuário com confirmação de senha -->
        <!-- Senha antiga -->
        <form action = "" method = "POST">
            <label for="senhaUsuarioAntiga" class="label1">Senha antiga:</label>
            <input type="password" id="senhaUsuarioAntiga" name = "senhaOld">

            <!-- Senha nova -->
            <label for="senhaUsuarioNovo" class="label2">Nova senha:</label>
            <input type="password" id="senhaUsuarioNovo" name = "senhaNew">

            <!-- Confirmando senha nova -->
            <label for="senhaUsuarioNovoConfirma" class="label3">Confirmação de nova senha:</label>
            <input type="password" id="senhaUsuarioNovoConfirma" name = "senhaNewConfirm">

            <input type = "submit" name = "submitSenhaNova" value = "Confirmar">
        </form>

        <!-- função de modo escuro/noturno -->
        <div class="modoNoturno">
            <label for = "modoNoturnoC" id = "modoNoturno">Modo escuro:
                <input type = "checkbox" name = "" id = "modoNoturnoC">
                <span></span>
            </label>
        </div>

        <form action = "" method = "POST">
            <label for = "desc_usu" id = "descUsu">Descrição:</label>
            <input type = "text" name = "desc_usu" id="desc_usu">

            <input type = "submit" name = "submitDesc" value = "Alterar">
        </form>
    </div>
</body>
</html>