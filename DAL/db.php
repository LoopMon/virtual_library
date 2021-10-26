<?php

    ## Variáveis
    $dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = 'root';
    $dbName = 'virtual_library';

    ## Variável de conexão
    $conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
   
?>