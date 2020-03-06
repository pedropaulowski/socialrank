<?php
    date_default_timezone_set("America/Sao_Paulo");
class Notificacoes{
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO("mysql:dbname=socialrank;host=localhost", "root", "");
    }

    public function jsonNovosComentariosPosts($ultima_hr,$id_post) {
        $sql = "SELECT * FROM comentarios WHERE id_post IN(".implode(',',$id_post).") AND hora >= :hora LIMIT 1000";
        
        
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":hora", $ultima_hr);
        $sql->execute();

        if($sql->rowCount() > 0) {            
            echo json_encode($sql->fetchAll(PDO::FETCH_ASSOC));
        }
    }

    public function arrayNovosComentariosPosts($ultima_hr, $id_post) {
        $sql = "SELECT * FROM comentarios WHERE id_post IN(".implode(',',$id_post).") AND hora >= :hora LIMIT 1000";
        
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":hora", $ultima_hr);
        $sql->execute();

        if($sql->rowCount() > 0) {            
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return array();
        }
     }

    public function postsDoUsuario($id_user) {
        $sql = "SELECT * FROM posts WHERE id_criador = :id_criador";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_criador", $id_user);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $qtd = $sql->rowCount();
            $sql = $sql->fetchAll(PDO::FETCH_ASSOC);

            for($i = 0; $i < $qtd; $i++)
                $array[] = $sql[$i]['id_post'];
                
            return $array;
        } else {
            return array();
        }
    }

    public function jsonNovasCurtidasPosts($ultima_hr,$id_post) {
        $sql = "SELECT * FROM curtidas WHERE id_post IN(".implode(',',$id_post).") AND hora >= :hora LIMIT 1000";
        
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":hora", $ultima_hr);
        $sql->execute();

        if($sql->rowCount() > 0) {            
            echo json_encode($sql->fetchAll(PDO::FETCH_ASSOC));
        }
    }

    public function arrayNovasCurtidasPosts($ultima_hr, $id_post) {
        $sql = "SELECT * FROM curtidas WHERE id_post IN(".implode(',',$id_post).") AND hora >= :hora LIMIT 1000";
        
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":hora", $ultima_hr);
        $sql->execute();
        
        if($sql->rowCount() > 0) {            
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return array();
        }
    }

    public function arrayAntigasNotificacoes($hora_curtida, $hora_coment, $id_post) {
        $sql = "SELECT curtidas.id_post as postcurtido, 
        curtidas.hora as horacurtida, 
        curtidas.id_user as usuariocurtida, 
        comentarios.id_post as postcomentado, 
        comentarios.hora as horacomentario, 
        comentarios.id_remetente as usuariocomentario, 
        comentarios.comentario as comentario
        FROM curtidas, comentarios 
        WHERE curtidas.id_post IN(".implode(',',$id_post).")
        AND comentarios.id_post IN(".implode(',',$id_post).")
        AND curtidas.hora <= :hora_curtida 
        AND comentarios.hora <= :hora_coment
        AND comentarios.id_post != 0 
        ORDER BY curtidas.hora DESC,comentarios.hora DESC
        LIMIT 100";

        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":hora_curtida", $hora_curtida);
        $sql->bindValue(":hora_coment", $hora_coment);
        $sql->execute();
        if($sql->rowCount() > 0) {            
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return array();
        }
     }
}





