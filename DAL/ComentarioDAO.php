<?php
require_once("db.php");
require_once("database.php");

//Criando uma classe 
class ComentarioDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = new Database();
    }

    //Um metodo para cadastrar os comentários, que pega os dados e trata-os
    public function Cadastrar (Comentario $comentario){
        try{
            $sql = "INSERT INTO comentarios (nome, mensagem, link, id_comentario) VALUES (:nome, :mensagem, :link, :id_comentario)";

            //Tratando dados (segurança)
            $param = array(
                ":nome" => $comentario->getNome(),
                ":mensagem"=> $comentario->getMensagem(),
                ":link"=> $comentario->getLink(),
                ":id_comentario"=> $comentario->getId_comentario()
            );

            //Retornando os dados
            return $this->pdo->ExecuteNonQuery($sql, $param);

        } catch (PDOException $ex){
            echo "ERRO: {$ex->getMessage()}";
        }
    }


    //Retornar os comentários
    public function RetornarComentario (string $link){
        try{
            $sql = "SELECT id, nome, mensagem FROM comentarios WHERE link = :link";
            $param = array(
                ":link"=> $link,
            );

            $dt = $this->pdo->ExecuteQuery ($sql, $param);    
            $listaComentario = [];

            foreach($dt as $dr){
                $comentario = new Comentario();
                $comentario->setId ($dr["id"]);
                $comentario->setNome ($dr["nome"]);
                $comentario->setMensagem ($dr["mensagem"]);
 
                $listaComentario[] = $comentario;
            }
            //Retornando os comentários por meio da váriavel
            return $listaComentario;

        }catch (PDOException $ex){ //Tratando erros
            echo "ERRO: {$ex->getMessage()}";
        }

    }

}
?>