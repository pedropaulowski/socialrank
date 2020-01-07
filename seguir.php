<?php
session_start();
require "assets/classes/seguidores.class.php";
require "assets/classes/usuarios.class.php";

$u = new Usuarios();
$s = new Seguidores();


if(!empty($_GET['id_dad']) && !empty($_GET['id_son'])) {
    $id_dad = addslashes($_GET['id_dad']);
    $id_son = addslashes($_GET['id_son']);
    if($id_dad != $id_son) {
        $id_session = $u->getIdByNick($_SESSION['nick']);
        if($id_session >= 1) {
            $user_session = $u->getUsuarioById($id_session);
            $user_son = $u->getUsuarioById($id_son);
            if($user_session == $user_son) {
                if($s->seguir($id_dad, $id_son) == true) {
                    $nick = $u->getNickById($id_dad);
                    $total = $s->getTotalSegs($id_dad);
                    echo '{"total":"'.$total.'"}';
                }
            }
        }

    }
} 