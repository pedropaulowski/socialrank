<?php
date_default_timezone_set('America/Sao_Paulo');

class Comentarios {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO("mysql:dbname=socialrank;host=localhost", "root", "");
    }

    public function comentar($id_remetente, $id_destinatario, $comentario, $id_post) {
        $hora = date("Y-m-d H:i:s");
        if ($this->comentarioVazio($comentario) == true) {
            return false;
        } else {
            if ($id_post == '') {
        
                $sql = "INSERT INTO comentarios SET id_remetente = :id_remetente, id_destinatario = :id_destinatario, comentario = :comentario, hora = :hora";
                $sql = $this->pdo->prepare($sql);
                $sql->bindValue(":id_remetente", $id_remetente);
                $sql->bindValue(":id_destinatario", $id_destinatario);
                $sql->bindValue(":comentario", $comentario);
                $sql->bindValue(":hora", $hora);
                $sql->execute();

                return true;

            } else if ($id_destinatario == '') {
                
                $sql = "INSERT INTO comentarios SET id_remetente = :id_remetente, comentario = :comentario, hora = :hora, id_post = :id_post";
                $sql = $this->pdo->prepare($sql);
                $sql->bindValue(":id_remetente", $id_remetente);
                $sql->bindValue(":comentario", $comentario);
                $sql->bindValue(":id_post", $id_post);
                $sql->bindValue(":hora", $hora);
                $sql->execute();

                return true;
            }
        }

    }

    public function getComentarios($pagina, $id_destinatario, $tipo, $ult_acesso) {
        $pagina = 100;

        if($tipo == 'maior'){
            $sql = "SELECT * FROM comentarios WHERE id_destinatario = :id_destinatario AND hora > :hora ORDER BY hora DESC LIMIT ".$pagina;
        } else {
            $sql = "SELECT * FROM comentarios WHERE id_destinatario = :id_destinatario AND hora <= :hora ORDER BY hora DESC LIMIT ".$pagina;
        }
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_destinatario", $id_destinatario);
        $sql->bindValue(":hora", $ult_acesso);

        $sql->execute();
        $sql = $sql->fetchAll(PDO::FETCH_ASSOC);
        
        return $sql;

    }
    public function getComentariosPosts($id_post, $pagina) {
        $sql = "SELECT * FROM comentarios WHERE id_post = :id_post ORDER BY curtidas DESC LIMIT ".$pagina;
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_post", $id_post);
        $sql->execute();
        $sql = $sql->fetchAll(PDO::FETCH_ASSOC);
        
        return $sql;
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

    private function comentarioVazio($texto) {
        $tam = strlen($texto);
        $aux = 0;
        for($i=0; $i<$tam; $i++) {
            if($texto[$i] == '' || $texto[$i] == ' ')
                $aux++;
        }

        if($aux == $tam || $aux == $tam-1) {
            return true;
        } else {
            return false;
        }
    }

    public function jsonComentarios($id_destinatario, $tipo, $ult_acesso) {
        echo json_encode($this->getComentarios(100, $id_destinatario, $tipo, $ult_acesso));
    }

    public function arrayComentarios($id_destinatario, $tipo, $ult_acesso) {
        return $this->getComentarios(100, $id_destinatario, $tipo, $ult_acesso);
    }
}
?>