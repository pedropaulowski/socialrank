<?php
class Comentarios {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO("mysql:dbname=socialrank;host=localhost", "root", "");
    }

    public function denunciar($id_user, $id_destinatario, $denuncia) {
        
        if($this->existeDenuncia($id_user, $id_destinatario) == false) {
            $sql = "INSERT INTO denuncias (id_remetente, id_destinario, denuncia) 
            VALUES (:id_remetente, :id_destinatario, :denuncia, NOW())";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":id_remetente", $id_user);
            $sql->bindValue(":id_destinatario", $id_destinatario);
            $sql->bindValue(":comentario", $denuncia);
            $sql->execute();
            
            return true;
        } else {
            $sql = "UPDATE denuncias SET  denuncia = :denuncia WHERE id_remetente = :id_remetente AND id_destinatario = :id_destinatario";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":cometario", $denuncia);
            $sql->bindValue(":id_remetente", $id_user);
            $sql->bindValue(":id_destinatario", $id_destinatario);
            $sql->execute();

            return true;
        }
    }
        
    private function existeDenuncia($id_user, $id_destinatario) {
        $sql = "SELECT * FROM notas WHERE id_rementente = :id_remetente AND id_destinatario = id_destinatario";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_remetente", $id_user);
        $sql->bindValue("id_destinatario", $id_destinatario);
        $sql->execute();

        if($sql->rowCount() > 0) {
            return true;
        } else {
            return false;
        }

    }
}
?>