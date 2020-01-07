<?php
class Notas {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO("mysql:dbname=socialrank;host=localhost", "root", "");
    }

    public function votar($id_remetente, $id_destinatario, $nota) {
        
        if($this->existeVoto($id_remetente, $id_destinatario) == true) {
            $sql = "UPDATE notas SET nota = :nota WHERE id_remetente = :id_remetente AND id_destinatario = :id_destinatario";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":nota", $nota);
            $sql->bindValue(":id_remetente", $id_remetente);
            $sql->bindValue(":id_destinatario", $id_destinatario);
            $sql->execute();

            $this->setMedia($id_destinatario);

            
            return true;
        } else {
            $sql = "INSERT INTO notas SET id_remetente = :id_remetente, id_destinatario = :id_destinatario, nota = :nota";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":id_remetente", $id_remetente);
            $sql->bindValue(":id_destinatario", $id_destinatario);
            $sql->bindValue(":nota", $nota);
            $sql->execute();
            
            $this->setMedia($id_destinatario);

            return true;
        }
    }

    public function setMedia($id_destinatario) {
        $sql = "UPDATE usuarios SET media = 
        (select (SUM(nota)/COUNT(*)) from notas where notas.id_destinatario = usuarios.id_user) WHERE id_user = :id_destinatario";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_destinatario", $id_destinatario);
        $sql->execute();

        return true;
    }

    public function getNotasCinco($id_destinatario) {
        $sql = "SELECT * FROM notas WHERE nota = 5 AND id_destinatario = :id_destinatario";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_destinatario", $id_destinatario);
        $sql->execute();

        return $sql->rowCount();
    }

    public function getNotasQuatro($id_destinatario) {
        $sql = "SELECT * FROM notas WHERE nota = 4 AND id_destinatario = :id_destinatario";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_destinatario", $id_destinatario);
        $sql->execute();

        return $sql->rowCount();
    }

    public function getNotasTres($id_destinatario) {
        $sql = "SELECT * FROM notas WHERE nota = 3 AND id_destinatario = :id_destinatario";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_destinatario", $id_destinatario);
        $sql->execute();

        return $sql->rowCount();
    }

    public function getNotasDois($id_destinatario) {
        $sql = "SELECT * FROM notas WHERE nota = 2 AND id_destinatario = :id_destinatario";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_destinatario", $id_destinatario);
        $sql->execute();

        return $sql->rowCount();
    }

    public function getNotasUm($id_destinatario) {
        $sql = "SELECT * FROM notas WHERE nota = 1 AND id_destinatario = :id_destinatario";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_destinatario", $id_destinatario);
        $sql->execute();

        return $sql->rowCount();
    }
    
    public function getTodasAvaliacoes($id_destinatario) {
        $sql = "SELECT * FROM notas WHERE id_destinatario = :id_destinatario";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_destinatario", $id_destinatario);
        $sql->execute();

        return $sql->rowCount();
    }

    private function existeVoto($id_remetente, $id_destinatario) {
        $sql = "SELECT * FROM notas WHERE id_remetente = :id_remetente AND id_destinatario = :id_destinatario";
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