<?php
session_start();
include_once("../../DAL/database.php");
include_once("../../DAL/db.php");

if (isset ($_POST['contar'])){
    //obter a data atual
    $data['atual'] = date('Y-m-d H:i:s');
    $dataAtual = $data['atual'];

    $visitante = $_SESSION['visitante'];

    //Diminuir 20 segundos
    $data['online'] = strtotime ($data['atual'] . "-10 seconds");
    $data['online'] = date('Y-m-d H:i:s', $data['online']);
    $dataOnline = $data['online'];

    if ( (isset ($_SESSION['visitante'])) AND (!empty ($_SESSION['visitante']))){
        $query_upd_visitas = "UPDATE visitas SET 
                              data_final = '$dataAtual' 
                              WHERE  id_visitas = '$visitante';";

        

        $resultUpdVisitas = mysqli_query($conexao, $query_upd_visitas);

    }else{
        //Salvar no banco de dados
         $queryVisitas = "INSERT INTO visitas (data_inicio, data_final) VALUES ('".$data['atual']."', '".$data['atual']."');";
         $resultVisitas = mysqli_query($conexao, $queryVisitas);

         $_SESSION['visitante'] = mysqli_insert_id ($conexao);

    }

    //Pesquisar os últimos usuários online nos 20 segundos
    $queryQtdVisitas = "SELECT COUNT(id_visitas) AS online FROM visitas WHERE data_final >= '$dataOnline';";
    $resultQtdVisitas = mysqli_query($conexao, $queryQtdVisitas);

    $rowsQtdVisitas = mysqli_fetch_assoc($resultQtdVisitas);

    echo $rowsQtdVisitas['online'];
}
?>