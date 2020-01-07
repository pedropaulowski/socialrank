<?php
    date_default_timezone_set("America/Sao_Paulo");
class Curtidas{
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO("mysql:dbname=socialrank;host=localhost", "root", "");
    }

    public function curtir($id_post, $id_user){
        $hora = date("Y-m-d H:i:s");
        if($this->existeCurtida($id_post, $id_user) == false){
            $sql = "INSERT INTO curtidas (id_post, hora, id_user) VALUES (:id_post, :hora, :id_user)";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":id_post", $id_post);
            $sql->bindValue(":hora", $hora);
            $sql->bindValue(":id_user", $id_user);
            $sql->execute();
            
            if($this->existeCurtida($id_post, $id_user) == false){

                $qtd_curtidas = $this->getQtdCurtidas($id_post);
                $this->setQtdCurtidas($id_post, $qtd_curtidas);

                return false;
            } else {
                $qtd_curtidas = $this->getQtdCurtidas($id_post);
                $this->setQtdCurtidas($id_post, $qtd_curtidas);
                return true;
            }

        } else {
            $sql = "DELETE FROM curtidas WHERE id_post = :id_post AND id_user = :id_user";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":id_post", $id_post);
            $sql->bindValue(":id_user", $id_user);
            $sql->execute();

            if($this->existeCurtida($id_post, $id_user) == true){

                $qtd_curtidas = $this->getQtdCurtidas($id_post);
                $this->setQtdCurtidas($id_post, $qtd_curtidas);

                return false;
            } else {

                $qtd_curtidas = $this->getQtdCurtidas($id_post);
                $this->setQtdCurtidas($id_post, $qtd_curtidas);

                return true;
            }
        }
    }

    public function existeCurtida($id_post, $id_user){
        $sql = "SELECT * FROM curtidas WHERE id_post = :id_post AND id_user = :id_user";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_post", $id_post);
        $sql->bindValue(":id_user", $id_user);
        $sql->execute();

        if($sql->rowCount() > 0){
            return true;
        } else {
            return false;
        }
    }


    private function setQtdCurtidas($id_post, $qtd_curtidas){
        $sql = "UPDATE posts SET curtidas = :qtd_curtidas WHERE id_post = :id_post";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":qtd_curtidas", $qtd_curtidas);
        $sql->bindValue(":id_post", $id_post);
        $sql->execute();

        return true;
    }

    private function getQtdCurtidas($id_post) {
        $sql = "SELECT * FROM curtidas WHERE id_post = :id_post";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_post", $id_post);
        $sql->execute();

        return $sql->rowCount();
    }

}