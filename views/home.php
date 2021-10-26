<?php
    session_start();
    include_once('../DAL/db.php');
    include_once('../DAL/database.php');

//Olhando qtd de usuarios online ---------------------------------
    //obter a data atual
    $data['atual'] = date('Y-m-d H:i:s');
    $dataAtual = $data['atual'];

    //Diminuir 20 segundos
    $data['online'] = strtotime ($data['atual'] . "-20 seconds");
    $data['online'] = date('Y-m-d H:i:s', $data['online']);

    //Pesquisar os últimos usuários online nos 20 segundos
    $queryQtdVisitas = "SELECT COUNT(id_visitas) AS  online  FROM visitas WHERE data_final = '".$data['online']."';";
    $resultQtdVisitas = mysqli_query($conexao, $queryQtdVisitas);

    $rowsQtdVisitas = mysqli_fetch_assoc($resultQtdVisitas  );

// ---------------------------------------------------------------

    //Confirmando se houve um submit
    $confirm = $_SESSION['descConfirm'];

    //Pegando o id do usuário
    $usu_idAray = $_SESSION['id'];
    $usu_id = $usu_idAray['usuario_id'];

    //Pegando o nome do usuário
    $usu = $_SESSION['usuario'];

    $usu_desc = "";

    //Pegando a descrição do usuário
    $desc = "SELECT usuario_descricao FROM usuarios WHERE usuario_id = $usu_id";
    $resultDescQuery = mysqli_query ($conexao, $desc);

    $rowDesc = mysqli_num_rows ($resultDescQuery);

    //Se houver retorno armazenar o retorno da descriçao
    if ($rowDesc == 1) {
        $usu_desc = mysqli_fetch_assoc($resultDescQuery);
        $descricao = $usu_desc['usuario_descricao'];
        
    }

    //Se houver um POST para trocar de descrição
    if ($confirm == 1) { 

        $usu_desc = $_SESSION['desc'];

        $queryDesc = "UPDATE usuarios
        SET usuario_descricao = '$usu_desc'
        WHERE usuario_id = '$usu_id'";

        $resultDesc = mysqli_query($conexao, $queryDesc);
        
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./css/home_new.css">
    <link rel="shortcut icon" href="./img/icone-pagina.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">

    <title>Virtual Library - Home</title>
</head>
<body>

    <div id="conteudo">

        <header>    

            <div class="desc-usuario">
                <!-- Nome do usuário -->
                <h1 id = "usu_name" style="text-transform: uppercase;"><?php echo "{$usu}"; ?></h1>
                <!-- Descrição do usuário -->
                <h3><?= $descricao;?></h3>

            </div>

            <div class="logo">
                <img src="./img/icone-pagina.png" alt="Logo do site">
            </div>

        </header>

        <nav>
            <ul>
                <li><a href="#" id="item-1" class="linha" onclick="mudarIframe(1)"><ion-icon name="search-outline"></ion-icon> Buscar Livro</a></li>
                <li><a href="#" id="item-2" onclick="mudarIframe(2)"><ion-icon name="chatbox-outline"></ion-icon> Comentários</a></li>
                <li><a href="#" id="item-3" onclick="mudarIframe(3)"><ion-icon name="settings-outline"></ion-icon> Configurações</a></li>
                <li><a href="#" id="item-4" onclick="mudarIframe(4)"><ion-icon name="newspaper-outline"></ion-icon> Sobre</a></li>
                <li><a href="./login.php"> <ion-icon name="log-out-outline"></ion-icon> Sair da Conta</a></li>
            </ul>
            <label>Usuários online: <span id = "online"><?= $rowsQtdVisitas['online']; ?> </span></label>
        </nav>

        <main>
            <section class="tela">
                <iframe src="./mini-views/home-1/home-1.php" frameborder="0" id="frame"></iframe>
            </section>    
        </main>

    </div>

    <script>
        function mudarIframe(pag) {
            if (pag == 1) {
                document.getElementById('frame').src = './mini-views/home-1/home-1.php'
                document.getElementById('item-1').classList.add('linha')
                document.getElementById('item-2').classList.remove('linha')
                document.getElementById('item-3').classList.remove('linha')
                document.getElementById('item-4').classList.remove('linha')
            }
            if (pag == 2) {
                document.getElementById('frame').src = './mini-views/home-2/home-2.php'
                document.getElementById('item-1').classList.remove('linha')
                document.getElementById('item-2').classList.add('linha')
                document.getElementById('item-3').classList.remove('linha')
                document.getElementById('item-4').classList.remove('linha')
            }
            if (pag == 3) {
                document.getElementById('frame').src = './mini-views/home-3/home-3.php'
                document.getElementById('item-1').classList.remove('linha')
                document.getElementById('item-2').classList.remove('linha')
                document.getElementById('item-3').classList.add('linha')
                document.getElementById('item-4').classList.remove('linha')
            }
            if (pag == 4) {
                document.getElementById('frame').src = './mini-views/home-4/home-4.php'
                document.getElementById('item-1').classList.remove('linha')
                document.getElementById('item-2').classList.remove('linha')
                document.getElementById('item-3').classList.remove('linha')
                document.getElementById('item-4').classList.add('linha')
            }
        }


        

        
    
    </script>
   <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
   <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    //Executar a cada 02s , para atualizar a quantidade dew usuarios online
    setInterval(function(){
        //Incluir e enviar o POST para o arquivo responsável em fazer a contagem
        $.post("auxiliar/processa_vis.php", {contar: 'online'}, function(data){
            $('#online').text(data);
        })
    }, 2000);
</script>
   
</body>
</html>