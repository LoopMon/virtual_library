<?php
require_once(dirname(__DIR__) . "\DAL\ComentarioDAO.php");

class ComentarioController {
    private $comentarioDAO;

    public function __construct() {
        $this->comentarioDAO = new ComentarioDAO();
    }

    //Cadastrando o comentário se a mensagem tiver no mínimo dois caracteres
    public function Cadastrar (Comentario $comentario){
        if (strlen ($comentario->getNome()) >= 2 && strlen ($comentario->getNome()) <= 50) {
            if (strlen ($comentario->getMensagem() ) >= 2 && strlen ($comentario->getMensagem()) <= 500){
                return $this->comentarioDAO->Cadastrar ($comentario);
            }else{
                return false;
            }

        }else{
            return false;
        }

    }
    
    //Método para retornar o comentário apenas se houver no mínimo dois caracteres
    public function RetornarComentario (string $link){
        if(strlen($link) >=2){
            return $this->comentarioDAO->RetornarComentario($link);
        }else{
            return null;
        }
    }
}
?>