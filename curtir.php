<?php
session_start();
require "assets/classes/usuarios.class.php";
require "assets/classes/posts.class.php";
require "assets/classes/curtidas.class.php";

$u = new Usuarios();
$p = new Posts();
$c = new Curtidas();


if(isset($_SESSION['nick']) && !empty($_POST['id_post'])) {
    $id_user = $u->getIdByNick($_SESSION['nick']);
    $id_post = $_POST['id_post'];

    if ($c->curtir($id_post, $id_user) == true) {
        session_write_close();
        $qtd_curtidas = $p->getQtdCurtidas($id_post);

        $arr = array("qtd_curtidas" => $qtd_curtidas);

        echo json_encode($arr);

    }


}
?>