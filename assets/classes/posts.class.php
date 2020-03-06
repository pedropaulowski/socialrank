<?php
require "C:/laragon/www/socialrank/assets/classes/seguidores.class.php";


?>
<?php

class Posts {
    private $pdo;
    private $s;

    public function __construct() {
        $this->pdo = new PDO("mysql:dbname=socialrank;host=localhost", "root", "");
        $this->s = new Seguidores;
    }

    public function getPostByIdCriador($id_criador) {

        $sql = "SELECT * FROM posts WHERE id_criador = :id_criador";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_criador", $id_criador);
        $sql->execute();
        
        $sql = $sql->fetchAll(PDO::FETCH_ASSOC);
            
        return $sql;

    }
    public function getPostToSegsLimited($id_criador, $ultima) {
        $limit = 100;
        $sql = "SELECT * FROM posts WHERE hora > :ultima AND  id_criador IN(".implode(',',$id_criador).")ORDER BY hora DESC LIMIT ".$limit;
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":ultima", $ultima);
        $sql->execute();
        $sql = $sql->fetchAll(PDO::FETCH_ASSOC);
            
        return $sql;

    }

    public function getPostsAntigos($id_criador, $ultima) {
        $limit = 100;
        $sql = "SELECT * FROM posts WHERE hora < :ultima AND  id_criador IN(".implode(',',$id_criador).")ORDER BY hora DESC LIMIT ".$limit;
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":ultima", $ultima);
        $sql->execute();
        $sql = $sql->fetchAll(PDO::FETCH_ASSOC);
            
        return $sql;

    }

    public function postar($id_criador, $texto, $img_url) {
        date_default_timezone_set('America/Sao_Paulo');
        $hora = date("Y-m-d H:i:s");
        $nick = $this->getNickById($id_criador);
        if($this->postVazio($texto) == false){
            if($img_url != '') {    
                $sql = "INSERT INTO posts SET id_criador = :id_criador, texto = :texto, hora = :hora, nick = :nick";
                $sql = $this->pdo->prepare($sql);
                $sql->bindValue(":id_criador", $id_criador);
                $sql->bindValue(":texto", $texto);
                $sql->bindValue(":hora", $hora);
                $sql->bindValue(":nick", $nick);
                $sql->execute();

                return true;
            } else {
                $sql = "INSERT INTO posts SET id_criador = :id_criador, img_url = :img_url, texto = :texto, hora = :hora, nick = :nick";
                $sql = $this->pdo->prepare($sql);
                $sql->bindValue(":id_criador", $id_criador);
                $sql->bindValue(":img_url", $img_url);            
                $sql->bindValue(":texto", $texto);
                $sql->bindValue(":hora", $hora);
                $sql->bindValue(":nick", $nick);

                $sql->execute();

                return true;
            }
        } else {
            return false;
        }
    }

    public function arrepender($id_post, $id_criador) {
        $sql = "UPDATE posts SET estado = 1 WHERE id_post = :id_post AND id_criador = :id_criador";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_post", $id_post);
        $sql->bindValue(":id_criador", $id_criador);
        $sql->execute();

        if($this->verificarArrependimento($id_post, $id_criador) == true) {
            return true;
        } else {
            return false;
        }

    }

    public function verificarArrependimento($id_post, $id_criador) {
        $sql = "SELECT * FROM posts WHERE id_post = :id_post AND id_criador = :id_criador AND estado = 1";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_post", $id_post);
        $sql->bindValue(":id_criador", $id_criador);
        $sql->execute();

        if($sql->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function jsonPosts($id_usuario, $ultima) {
        $users = $this->s->getQuemSegue($id_usuario);
        $users[] = $id_usuario;
        if($this->s->getQtdSeguidos($id_usuario) >= 0){
            $array = $this->getPostToSegsLimited($users, $ultima);
            echo json_encode($array);
        } 
    }

    public function arrayPosts($id_usuario, $ultima) {
        $users = $this->s->getQuemSegue($id_usuario);
        $users[] = $id_usuario;
        if($this->s->getQtdSeguidos($id_usuario) >= 0){
            $array = $this->getPostToSegsLimited($users, $ultima);
            return $array;
            //return $this->getPostToSegsLimited($users);
        }
    }

    public function arrayPostsAntigos($id_usuario, $ultima) {
        $users = $this->s->getQuemSegue($id_usuario);
        $users[] = $id_usuario;
        if($this->s->getQtdSeguidos($id_usuario) >= 0){
            $array = $this->getPostsAntigos($users, $ultima);
            return $array;
            //return $this->getPostToSegsLimited($users);
        } 
    }

    public function getImgUrlById($id_user) {
        $sql = "SELECT * FROM usuarios WHERE id_user = :id_user";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_user", $id_user);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $sql = $sql->fetch();
            return $sql['img_url'];
        } else {
            return false;
        }
    }

    public function getNickById($id_user) {
        $sql = "SELECT * FROM usuarios WHERE id_user = :id_usuario";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_usuario", $id_user);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $sql = $sql->fetch();
            return $sql['nick'];
        } else {
            return false;
        }
    }

    public function postVazio($texto){
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

    public function getQtdCurtidas($id_post) {
        $sql = "SELECT curtidas FROM posts WHERE id_post = :id_post";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_post", $id_post);
        $sql->execute();

        if($sql->rowCount() > 0){
            $sql = $sql->fetch();

            return $sql['curtidas'];
       } else {
           return false;
       }
    }

    public function postAgora($id_criador, $hora) {
        $sql = "SELECT * FROM posts WHERE id_criador = :id_criador AND hora >= :hora";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_criador", $id_criador);
        $sql->bindValue(":hora", $hora);
        $sql->execute();

        if($sql->rowCount() > 0){
            return true;
       } else {
           return false;
       }
    }
}

?>