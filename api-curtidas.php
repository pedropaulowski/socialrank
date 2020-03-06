<?php

session_start();
date_default_timezone_set('America/Sao_Paulo');
require 'assets/classes/usuarios.class.php';
require 'assets/classes/notificacoes.class.php';
require 'assets/classes/posts.class.php';

$p = new Posts();
$n = new Notificacoes();
$u = new Usuarios();

$hora = date('Y-m-d H:i:s');
if(isset($_SESSION['nick'])) {
    set_time_limit(60);
    $nick = $_SESSION['nick'];
    $id = $u->getIdByNick($nick);

    $ult_att = $u->getCurtidasHora($id);
    $id_posts = $n->postsDoUsuario($id);

    while(true) {
        session_write_close();

        $curtidas = $n->arrayNovasCurtidasPosts($ult_att, $id_posts);

        if(count($curtidas) > 0 && isset($_SESSION['nick']) && !empty($_SESSION['nick'])) {
            $ult_att = date("Y-m-d H:i:s");
            $u->setCurtidasHora($id, $ult_att);
            break;
        } else {
            sleep(2);
            continue;
        }

    }

    echo json_encode($curtidas);
    exit();
}

?>