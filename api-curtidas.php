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
    $nick = $_POST['nick'];
    $id = $u->getIdByNick($nick);

    $ult_att = $u->getCurtidasHora($id);
    

    while(isset($_SESSION['nick'])) {
        session_write_close();

        $id_posts = $n->postsDoUsuario($id);
        $curtidas = $n->arrayNovasCurtidasPosts($ult_att, $id_posts);

        if(count($curtidas) > 0) {
            $ult_att = date("Y-m-d H:i:s");
            $u->setCurtidasHora($id);
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