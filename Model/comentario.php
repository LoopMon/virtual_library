<?php

class Comentario{
    private $id;
    private $nome;
    private $mensagem;
    private $link;
    private $id_comentario;

    function getId(){
        return $this->id;
    }

    function getNome(){
        return $this->nome;
    }

    function getMensagem(){
        return $this->mensagem;
    }

    function getLink(){
        return $this->link;
    }

    function getId_comentario(){
        return $this->id_comentario;
    }

    function setId($Id){
        $this->id = $Id;
    }

    function setNome($nome){
        $this->nome = $nome;
    }

    function setMensagem($mensagem){
        $this->mensagem = $mensagem;
    }

    function setLink($link){
        $this->link = $link;
    }

    function setId_comentario($Id_comentario){
        $this->Id_comentario = $Id_comentario;
    }

}


?>