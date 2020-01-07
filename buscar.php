<?php
session_start();

require "assets/classes/imagens.class.php";
require "assets/classes/notas.class.php";
require "assets/classes/usuarios.class.php";

$u = new Usuarios();
$n = new Notas();

if(isset($_GET['nick']) && !empty($_GET['nick'])){
    $nick = addslashes($_GET['nick']);
    $user = $u->getUsuarioByNick($nick);
    $id_destinatario = $u->getIdByNick($nick);
    $avaliacoes = $n->getTodasAvaliacoes($id_destinatario);

    echo '{
            "nome": "'.$user['nome'].'",
            "img_url": "'.$user['img_url'].'",
            "media":'.$user['media'].',
            "nick": "'.$user['nick'].'",
            "avaliacoes":"'.$avaliacoes.'"
    }';
}

?>