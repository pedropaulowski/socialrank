<?php
class Comentarios {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO("mysql:dbname=socialrank;host=localhost", "root", "");
    }

    public function comentar($id_remetente, $id_destinatario, $comentario) {
        
        if($this->existeComentario($id_remetente, $id_destinatario) == false) {
            $sql = "INSERT INTO comentarios SET id_remetente = :id_remetente, id_destinatario = :id_destinatario, comentario = :comentario, hora = NOW()";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":id_remetente", $id_remetente);
            $sql->bindValue(":id_destinatario", $id_destinatario);
            $sql->bindValue(":comentario", $comentario);
            $sql->execute();
            
            return true;
        } else {
            $sql = "UPDATE comentarios SET comentario = :comentario, hora = NOW() WHERE id_remetente = :id_remetente AND id_destinatario = :id_destinatario";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":comentario", $comentario);
            $sql->bindValue(":id_remetente", $id_remetente);
            $sql->bindValue(":id_destinatario", $id_destinatario);
            $sql->execute();

            return true;
        }

        
    }

    public function getComentarios($pagina, $id_destinatario) {
        $sql = "SELECT * FROM comentarios WHERE id_destinatario = :id_destinatario ORDER BY hora DESC LIMIT $pagina, 5";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_destinatario", $id_destinatario);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetchAll();
        } else {
            return false;
        }
    }
        
    private function existeComentario($id_remetente, $id_destinatario) {
        $sql = "SELECT * FROM comentarios WHERE id_remetente = :id_remetente AND id_destinatario = :id_destinatario";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_remetente", $id_remetente);
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