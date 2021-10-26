<?php
    session_start();
    include_once('../../../DAL/db.php');

    //Pegando o nome do usuário
    $usu = $_SESSION['usuario'];

    //Pegando o id do usuário
    $usu_idAray = $_SESSION['id'];
    $usu_id = $usu_idAray['usuario_id'];

    $livroId = [];

    //Se haver um envio pelo botão na barra de pesquisa vai pegar o que está escrito por meio do método GET. 
    if (isset ($_GET['nome_livro'])) {
        $pesquisa = $_GET['nome_livro'];
        $query = "SELECT * FROM livro WHERE livro_nome LIKE '%$pesquisa%';";
        $result = mysqli_query($conexao, $query);

        $row = mysqli_num_rows($result);
    }

    //Pesquisa filtrada por autor ou gênero
    if (isset ($_POST['submitAutorGenero'])) {
        $pesquisaSelect = $_POST['txtSelect'];
        $metodoBusca = $_POST['buscaSelect'];

        $querySelect = "";
        if ($metodoBusca == "Autor"){
            $querySelect = "SELECT * FROM livro WHERE livro_autor LIKE '%$pesquisaSelect%';";
        }
        if($metodoBusca == "Genero"){
            $querySelect = "SELECT * FROM livro WHERE livro_genero LIKE '%$pesquisaSelect%';";
        }
        
        $resultSelect = mysqli_query($conexao, $querySelect);

        $rowSelect = mysqli_num_rows($resultSelect);
        var_dump($rowSelect);

    }

    //Exibindo autores
    if (isset ($_POST['submitAutores'])){
        $queryAutores = "SELECT DISTINCT livro_autor, count(*) FROM livro
        GROUP BY livro_autor
        ORDER BY livro_autor;";

        $resultAutores = mysqli_query($conexao, $queryAutores);

        $rowsAutores = mysqli_num_rows($resultAutores);

        $contAutores = "SELECT count(distinct livro_autor) AS count FROM livro;";
        $resultContAutores = mysqli_query($conexao, $contAutores);

        $rowsContAutores = mysqli_num_rows($resultContAutores);
    }

    //Exibe o acervo da biblioteca
    if (isset ($_POST['submitBiblioteca'])){
        $queryAcervo = "SELECT count(distinct livro_nome) AS count FROM livro;";
        $resultAcervo = mysqli_query($conexao, $queryAcervo);
    }

    //Função favoritos / Retorna os livros marcados como favoritos
    if (isset ($_POST['fav'])){
        $queryFav = "SELECT l.livro_nome from usuarios u
        inner join status_livro s
        on  u.usuario_nome = '$usu' and u.usuario_id = s.id_usuario and s.livro_fav = 'V'
        inner join livro l
        on s.id_livro = l.livro_id;";

        $resultFav = mysqli_query ($conexao, $queryFav);

        $rowFav = mysqli_num_rows ($resultFav);
    }

    //Função de livros lido / Retorna os livros marcados como lidos
    if (isset ($_POST['lido'])){
        $queryLido = "SELECT l.livro_nome from usuarios u
        inner join status_livro r
        on  u.usuario_nome = '$usu' and u.usuario_id = r.id_usuario and r.livro_visualizado = 'V'
        inner join livro l
        on r.id_livro = l.livro_id;";

        $resultLido = mysqli_query($conexao, $queryLido);

        $rowLido = mysqli_num_rows($resultLido);
    }

    //Função de livros não lido / Retorna os livros marcados como não lidos
    if (isset ($_POST['naoLido'])){
        $queryFav = "SELECT l.livro_nome from usuarios u
        inner join status_livro s
        on u.usuario_nome = '$usu' and u.usuario_id = s.id_usuario and s.livro_visualizado = 'F'
        inner join livro l
        on s.id_livro = l.livro_id;";

        $resultNaoLido = mysqli_query($conexao, $queryFav);

        $rowNaoLido = mysqli_num_rows($resultNaoLido);
    }

    //Função de visualizado e não visualizado
    if(isset($_POST['submitVisualizacao'])){
        $id = $usu_id;
        $opt = $_POST['submitLidoMarca'];
        $id_livro = $_POST['labelIdVisu'];
        
        $queryMarcar = "UPDATE status_livro
        SET livro_visualizado = '$opt'
        WHERE id_usuario = '$id' and id_livro = '$id_livro';";

        $resultMarcar = mysqli_query($conexao, $queryMarcar);
    }

    //Função de favorito
    if(isset($_POST['submitFav'])){
        $id = $usu_id;
        $opt = $_POST['submitFavMarcar'];
        $id_livro = $_POST['labelIdFav'];
        
        $queryMarcar = "UPDATE status_livro
        SET livro_fav = '$opt'
        WHERE id_usuario = '$id' and id_livro = '$id_livro';";

        $resultMarcar = mysqli_query($conexao, $queryMarcar);
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="./style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    
    <div class="filtragem">

        <div class = "filtragem-1">
            <form action = "" method="GET">
                <label for="nomeLivro">Pesquisar livro</label>
                <input type="text" id="nomeLivro" name="nome_livro" placeholder="Nome do Livro">
                <button>Buscar</button>
            </form>
        </div>
        
        <div class="filtragem-2">

            <!-- Pesquisa por filtro (Autor ou Gênero) -->
            <form action = "" method = "POST">
                <select name = "buscaSelect" id = "">
                    <option value="Autor">Autor</option>
                    <option value="Genero">Gênero</option>
                </select>

                <input type="text" name = "txtSelect">
                <input type = "submit" name = "submitAutorGenero" value = "Filtrar">

            </form>

            <form action = "" method = "POST">
                <!-- Botão que retorna o total de autores e quantos livros cada um possui -->
                <input type = "submit" name = "submitAutores" value = "Autores">
                <!-- Botão que retorna todos os livros -->
                <input type = "submit" name = "submitLivros" value = "Livros">
                <!-- Exibe quantos livros a biblioteca possui -->
                <input type = "submit" name = "submitBiblioteca" value = "Acervo da biblioteca">
            </form>

        </div>

        <div class="filtragem-3">
            <form action="" method="POST">

                <input type = "submit" name = "ordemAsc" value = "Ordem Alfabética">
                <input type = "submit" name = "fav" value = "Favoritos">
                <input type = "submit" name = "lido" value = "Lidos">
                <input type = "submit" name = "naoLido" value = "Não lidos">

            </form>
        </div>

    </div>

    <div class="resultados">
        <?php
            //Retorna o livro que o usuario pesquisou
            if(isset($_GET['nome_livro'])){
                //Verificando se há retorno de ao menos uma linha de resultado no SELECT do banco de dados
                if($row == 0){
                    echo "<ul><li>Nenhum resultado encontrado.</li></ul>";
                }else{
                    echo "<ol>";
                    while($visu = mysqli_fetch_assoc($result)){
                        $id_livroVisu = $visu['livro_id'];
                        echo "<li value = '$id_livroVisu'>";
                        echo $visu['livro_nome']." | Gênero: ".$visu['livro_genero']. " | Autor: ". $visu['livro_autor']. " <a href= '{$visu["livro_link"]}'>Acessar</a>";
                        echo "<form action = '' method = 'POST'>";
                        $id_visu = $visu['livro_id'];
                        $ids [] = $id_visu;

                        //Visualizado ou não
                        echo "<select name = 'submitLidoMarca' id = '$id_visu'>";
                        echo "<option value = 'F'>Não visualizado</option>";
                        echo "<option value = 'V'>Visualizado</option>";
                        echo "</select>";

                        //Confirmação
                        echo "<input type = 'submit' name = 'submitVisualizacao' id = '$id_visu' value = 'Confirmar'>";  
                        echo "<input type = 'text' style = 'display:none;' name = 'labelIdVisu' value = '$id_visu'>";

                        //Favoritos
                        echo "<select name = 'submitFavMarcar' id = '$id_visu'>";
                        echo "<option value = 'F'>Não favorito</option>";
                        echo "<option value = 'V'>Favorito</option>";
                        echo "</select>";

                        //Confirmação
                        echo "<input type = 'submit' name = 'submitFav' id = '$id_visu' value = 'Confirmar'>";  
                        echo "<input type = 'text' style = 'display:none;' name = 'labelIdFav' value = '$id_visu'>";

                        echo "</form>";
                        echo "</li>";
        
                    }
                    echo "</ol>";
                    
                }
            }
            
            //Filtrando a pesquisa
            //Retorna o livro que o usuario pesquisou por meio do filtro
            if (isset ($_POST['submitAutorGenero'])){
                //Verificando se há retorno de ao menos uma linha de resultado no SELECT do banco de dados
                if($rowSelect == 0){
                    echo "<ul><li>Nenhum resultado encontrado.</li></ul>";
                }else{
                    echo "<ol>";
                    while($visuS = mysqli_fetch_assoc($resultSelect)){
                        $id_livroVisuS = $visuS['livro_id'];
                        echo "<li value = '$id_livroVisuS'>";
                        echo $visuS['livro_nome']." | Gênero: ".$visuS['livro_genero']. " | Autor: ". $visuS['livro_autor']. " <a href= '{$visuS["livro_link"]}'>Acessar</a>";
                        echo "<form action = '' method = 'POST'>";
                        $id_visuS = $visuS['livro_id'];
                        $idsS [] = $id_visuS;

                        //Visualizado ou não
                        echo "<select name = 'submitLidoMarca' id = '$id_visuS'>";
                        echo "<option value = 'F'>Não visualizado</option>";
                        echo "<option value = 'V'>Visualizado</option>";
                        echo "</select>";

                        //Confirmação
                        echo "<input type = 'submit' name = 'submitVisualizacao' id = '$id_visuS' value = 'Confirmar'>";  
                        echo "<input type = 'text' style = 'display:none;' name = 'labelIdVisu' value = '$id_visuS'>";

                        //Favoritos
                        echo "<select name = 'submitFavMarcar' id = '$id_visuS'>";
                        echo "<option value = 'F'>Não favorito</option>";
                        echo "<option value = 'V'>Favorito</option>";
                        echo "</select>";

                        //Confirmação
                        echo "<input type = 'submit' name = 'submitFav' id = '$id_visuS' value = 'Confirmar'>";  
                        echo "<input type = 'text' style = 'display:none;' name = 'labelIdFav' value = '$id_visuS'>";

                        echo "</form>";
                        echo "</li>";
        
                    }
                    echo "</ol>";
                    
                }
            }

            //Quantos livros a biblioteca possui
            if (isset ($_POST['submitBiblioteca'])){
                $visuAcervo = mysqli_fetch_assoc($resultAcervo);
                echo "<ul><li>Há um total de {$visuAcervo['count']} livros na biblioteca atualmente.</li></ul>";
            }

            //Ao clicar em "Autores", deve retornar o número total de autores e os autores com o número de livros (presente no banco de dados)
            if (isset ($_POST['submitAutores'])){
                if($rowsAutores == 0){
                    echo "<ul><li>Nenhum resultado encontrado.</li></ul>";
                }else{
                    echo "<ol>";
                    $visuC = mysqli_fetch_assoc($resultContAutores);
                    echo "<ul><li>Total de autores: {$visuC['count']}</li></ul>";
                    
                    while($visuA = mysqli_fetch_assoc($resultAutores)){
                        echo "<li>";
                        echo "Autor: ". $visuA['livro_autor']." | Livros: ".$visuA['count(*)'];
                        echo "</li>";
        
                    }
                    echo "</ol>";
                    
                }
            }

            //Resultado ao clicar no botão de favoritos. Deve retornar os livros marcados pelo usuário como favorito.
            if (isset($_POST['fav'])){
                if($rowFav == 0){
                    echo "<ul><li>Nenhum resultado encontrado.</li></ul>";
                }else{
                    echo "<ol>";
                    while($visuFav = mysqli_fetch_assoc($resultFav)){
                        echo "<li>";
                        echo $visuFav['livro_nome'];
                        echo "</li>";
                    }
                    echo "</ol>";
                }
            }

            //Resultado ao clicar no botão de lidos. Deve retornar os livros marcados como lidos.
            if (isset($_POST['lido'])){
                if($rowLido == 0){
                    echo "<ul><li>Nenhum resultado encontrado.</li></ul>";
                }else{
                    echo "<ol>";
                    while($visuLido = mysqli_fetch_assoc($resultLido)){
                        echo "<li>";
                        echo $visuLido['livro_nome'];
                        echo "</li>";
                    }
                    echo "</ol>";
                }
            }

            //Resultado ao clicar no botão de não lidos. Deve retornar os livros marcados como não lidos.
            if (isset($_POST['naoLido'])){
                if($rowNaoLido == 0){
                    echo "<ul><li>Nenhum resultado encontrado.</li></ul>";
                }else{
                    echo "<ol>";
                    while($visuNaoLido = mysqli_fetch_assoc($resultNaoLido)){
                        echo "<li>";
                        echo $visuNaoLido['livro_nome'];
                        echo "</li>";
                    }
                    echo "</ol>";
                }
            }
        ?>

    </div>

</body>

<script>
    async function main() {
        let result = document.getElementsByClassName('resultados')[0]
        let resultFilhos = result.children.length
        for (let i = 0; i < resultFilhos; i++) {
            const filho = result.children[0]
            await result.removeChild(filho)
            
            let resultFilhos = result.children.length
            if ( resultFilhos <= 1 ) {
                console.log('boa')
                break
            }
        }
    }
</script>

</html>