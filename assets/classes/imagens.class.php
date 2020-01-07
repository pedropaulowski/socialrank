<?php
class Imagens {

    public function __construct() {
        $this->pdo = new PDO("mysql:dbname=socialrank;host=localhost", "root", "");
    }

    public function setImagem($id_user, $img_url) {
        if($this->existeImagem($id_user) == false) {
            $sql = "INSERT INTO imagens (id_user, img_url) VALUES (:id_user, :img_url)";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":id_user", $id_user);
            $sql->bindValue(":img_url", $img_url);
            $sql->execute();
            
            return true;

        } else {
            $sql = "UPDATE imagens SET img_url = :img_url WHERE id_user = :id_user";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":img_url", $img_url);
            $sql->execute();
            
            return true;
        }
    }

    public function getUrlImagemByIdUser($id_user) {
        $sql = "SELECT * FROM imagens WHERE id_user = :id_user";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_user", $id_user);
        $sql->execute();

        $sql->fetch();

        return $sql['img_url'];
    }

    private function existeImagem($id_user) {
        $sql = "SELECT * FROM imagens WHERE id_user = :id_user";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_user", $id_user);
        $sql->execute();

        if($sql->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
?>