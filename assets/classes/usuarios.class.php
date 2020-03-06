<?php
class Usuarios{
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO("mysql:dbname=socialrank;host=localhost", "root", "");
    }

    //SETTERS

    public function setUsuario($email, $senha, $nome, $nick, $qr_code, $media, $descricao) {
        
        if($this->existeUsuario($email)==false && $this->existeNick($nick) == false) {
            $sql = "INSERT INTO usuarios (email, img_url, senha, nome, nick, qr_code, media, descricao, hora, ult_acesso) 
            VALUES (:email, :img_url, :senha, :nome, :nick, :qr_code, :media, :descricao, NOW(), NOW())";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":email", $email);
            $sql->bindValue(":img_url", 'imagens/3a4e09be45efd325e35c1aab218b354c.gif');
            $sql->bindValue(":senha", $senha);
            $sql->bindValue(":nome", $nome);
            $sql->bindValue(":nick", $nick);
            $sql->bindValue(":qr_code", $qr_code);
            $sql->bindValue(":media", $media);
            $sql->bindValue(":descricao", $descricao);

            $sql->execute();

            if($this->existeUsuario($email)== false) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    public function editarEmail($id_user, $email) {
        if($this->existeUsuarioById($id_user) == true){
            $sql = "UPDATE usuarios SET email = :email WHERE id_user = :id_user";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":email", $email);
            $sql->bindValue(":id_user", $id_user);
            $sql->execute();

            if($this->existeUsuario($email) == true) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    public function logIn($nick) {
        $sql = "SELECT * FROM usuarios WHERE nick = :nick";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":nick", $nick);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $sql = $sql->fetch();
            return $sql['senha'];
        } else {
            return false;
        }
    }

    public function editarNick($id_user, $nick) {
        if($this->existeUsuarioById($id_user) == true) {
            $sql = "UPDATE usuarios SET nick = :nick WHERE id_user = :id_user";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":nick", $nick);
            $sql->bindValue(":id_user", $id_user);
            $sql->execute();

            return true;
        } else {
            return false;
        }
    }

    public function editarImg($id_user, $img_url) {
        if($this->existeUsuarioById($id_user) == true) {
            $sql = "UPDATE usuarios SET img_url = :img_url WHERE id_user = :id_user";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":img_url", $img_url);
            $sql->bindValue(":id_user", $id_user);
            $sql->execute();

            return true;
        } else {
            return false;
        }
    }

    public function editarDescricao($id_user, $descricao) {
        if($this->existeUsuarioById($id_user) == true) {
            $sql = "UPDATE usuarios SET descricao = :descricao WHERE id_user = :id_user";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":descricao", utf8_decode($descricao));
            $sql->bindValue(":id_user", $id_user);
            $sql->execute();

            return true;
        } else {
            return false;
        }
    }
    
    // GETTERS
    public function getUsuarioById($id_user) {
        $sql = "SELECT * FROM usuarios WHERE id_user = :id_usuario";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_usuario", $id_user);
        $sql->execute();

        if($sql->rowCount() > 0) {
            return $sql->fetch();
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

    public function getUltimoAcesso($id_user) {
        $sql = "SELECT * FROM usuarios WHERE id_user = :id_usuario";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_usuario", $id_user);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $sql = $sql->fetch();
            return $sql['ult_acesso'];
        } else {
            return false;
        }
    }

    
    public function setUltimoAcesso($id_user, $ult_acesso) {
        $sql = "UPDATE usuarios SET ult_acesso = '".$ult_acesso."' WHERE id_user = :id_usuario";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_usuario", $id_user);
        $sql->execute();

        return true;
    }

    public function getNotificacoesHora($id_user) {
        $sql = "SELECT * FROM usuarios WHERE id_user = :id_usuario";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_usuario", $id_user);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $sql = $sql->fetch();
            return $sql['notificacoes'];
        } else {
            return false;
        }
    }

    public function getCurtidasHora($id_user) {
        $sql = "SELECT * FROM usuarios WHERE id_user = :id_usuario";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_usuario", $id_user);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $sql = $sql->fetch();
            return $sql['curtidas_hr'];
        } else {
            return false;
        }
    }

    public function setCurtidasHora($id_user, $curtidas_hr) {
        $sql = "UPDATE usuarios SET curtidas_hr = '".$curtidas_hr."' WHERE id_user = :id_usuario";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_usuario", $id_user);
        $sql->execute();

        return true;
    }

    public function setNotificacoesHora($id_user, $notificacoes) {
        $sql = "UPDATE usuarios SET notificacoes = '".$notificacoes."' WHERE id_user = :id_usuario";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_usuario", $id_user);
        $sql->execute();

        return true;
    }

    public function getEntradaByNick($nick) {
        $sql = "SELECT * FROM usuarios WHERE nick = :nick";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":nick", $nick);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $sql = $sql->fetch();
            return $sql['hora'];
        } else {
            return false;
        }
    }
    public function getUsuarioByNick($nick) {
        $sql = "SELECT * FROM usuarios WHERE nick = :nick";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":nick", $nick);
        $sql->execute();

        if($sql->rowCount() > 0) {
            return $sql->fetch();
        } else {
            return false;
        }
    }
    public function getImgUrlByNick($nick) {
        $sql = "SELECT * FROM usuarios WHERE nick = :nick";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":nick", $nick);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $sql = $sql->fetch();
            return $sql['img_url'];
        } else {
            return false;
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
    public function getDescricaoByNick($nick) {
        $sql = "SELECT * FROM usuarios WHERE nick = :nick";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":nick", $nick);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $sql = $sql->fetch();
            return $sql['descricao'];
        } else {
            return false;
        }
    }

    public function getUsuarioByEmail($email) {
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":email", $email);
        $sql->execute();

        if($sql->rowCount() > 0) {
            return $sql->fetch();
        } else {
            return false;
        }
    }
    public function ranking($qtde) {
        $sql = "SELECT * FROM usuarios ORDER BY media DESC limit 0, $qtde";
        $sql = $this->pdo->query($sql);
        
        if($sql->rowCount() > 0) {
            return $sql->fetchAll();
        } else {
            return false;
        }
    }

    public function paginacao($pagina) {
        $sql = "SELECT * FROM usuarios ORDER BY media DESC LIMIT $pagina, 5";
        $sql = $this->pdo->query($sql);
        
        if($sql->rowCount() > 0){
            return $sql->fetchAll();
        } else {
            return array();
        }
    }

    public function getMedia($id_user) {
        $sql = "SELECT * FROM usuarios WHERE id_user = :id_user";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_user", $id_user);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $sql = $sql->fetch();

            return $sql['media'];
        } else {
            return false;
        }
    }
    public function getIdByNick($nick){
        $sql = "SELECT * FROM usuarios WHERE nick = :nick";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":nick", $nick);
        $sql->execute();

        if($sql->rowCount() > 0){
            $sql = $sql->fetch();

            return $sql['id_user'];
        } else {
            return false;
        }
    }

    public function getNomeByNick($nick){
        $sql = "SELECT * FROM usuarios WHERE nick = :nick";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":nick", $nick);
        $sql->execute();

        if($sql->rowCount() > 0){
            $sql = $sql->fetch();

            return $sql['nome'];
        } else {
            return false;
        }
    }

    //METODOS PRIVADOS
    private function existeUsuario($email) {
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":email", $email);
        $sql->execute();

        if($sql->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    private function existeNick($nick) {
        $sql = "SELECT * FROM usuarios WHERE nick = :nick";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":nick", $nick);
        $sql->execute();

        if($sql->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    private function existeUsuarioById($id_user) {
        $sql = "SELECT * FROM usuarios WHERE id_user = :id_user";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_user", $id_user);
        $sql->execute();

        if($sql->rowCount() > 0){
            return true;
        } else {
            return false;
        }
    }
}
?>