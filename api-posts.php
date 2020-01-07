<?php

session_start();
date_default_timezone_set('America/Sao_Paulo');
require 'assets/classes/usuarios.class.php';
require 'assets/classes/posts.class.php';
$p = new Posts();
$u = new Usuarios();

if(isset($_SESSION['nick'])) {
    set_time_limit(60);
    $nick = $_SESSION['nick'];
    $id = $u->getIdByNick($nick);

    $ult_att = $u->getUltimoAcesso($id);
    while(true) {
        session_write_close();
        $posts = $p->arrayPosts($id, $ult_att);
        
        if(count($posts) > 0) {
            $ult_att = date("Y-m-d H:i:s");
            $u->setUltimoAcesso($id, $ult_att);
            break;
        } else {
            sleep(2);
            continue;
        }

    }

    echo json_encode($posts);
    exit();
}

?>
