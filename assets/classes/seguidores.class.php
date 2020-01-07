<?php
class Seguidores {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO("mysql:dbname=socialrank;host=localhost", "root", "");
    }

    public function seguir($id_dad, $id_son) {
        if($this->alreadyFollow($id_dad, $id_son) == true) {
            $sql = "DELETE FROM seguidores WHERE id_dad = :id_dad AND id_son = :id_son";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":id_dad", $id_dad);
            $sql->bindValue(":id_son", $id_son);
            $sql->execute();
            
            return true;
        } else {
            $sql = "INSERT INTO seguidores SET id_dad = :id_dad, id_son = :id_son, hora = NOW()";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":id_dad", $id_dad);
            $sql->bindValue(":id_son", $id_son);
            $sql->execute();
            
            if($this->alreadyFollow($id_dad, $id_son) == true) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function alreadyFollow($id_dad, $id_son) {
        $sql = "SELECT * FROM seguidores WHERE id_dad = :id_dad AND id_son = :id_son";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_dad", $id_dad);
        $sql->bindValue(":id_son", $id_son);
        $sql->execute();

        if($sql->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getTotalSegs($id_dad) {
        $sql = "SELECT * FROM seguidores WHERE id_dad = :id_dad";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_dad", $id_dad);
        $sql->execute();

        return $sql->rowCount();
    }

    public function getQuemSegue($id_son) {
        $sql = "SELECT * FROM seguidores WHERE id_son = :id_son";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_son", $id_son);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $qtd = $sql->rowCount();
            $sql = $sql->fetchAll(PDO::FETCH_ASSOC);

            for($i = 0; $i < $qtd; $i++)
                $array[] = $sql[$i]['id_dad'];
                
            return $array;
        } else {
            return array();
        }
    }

    public function getQtdSeguidos($id_son) {
        $sql = "SELECT * FROM seguidores WHERE id_son = :id_son";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id_son", $id_son);
        $sql->execute();
        
        return $sql->rowCount();
    }
}
?>