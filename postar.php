<?php
session_start();
require "assets/classes/usuarios.class.php";
require "assets/classes/posts.class.php";

$u = new Usuarios();
$p = new Posts();



if(isset($_POST['nick']) && isset($_POST['texto']) && !empty($_POST['texto'])) {
    $nick = addslashes(strtolower($_POST['nick']));
    $id_user = $u->getIdByNick($nick);
    $texto = $_POST['texto'];
    $img_url = '';
    if($p->postar($id_user, $texto, $img_url) == true){
        $arr = array('resultado' => 0, 'curtidas' => 0);
        echo json_encode($arr);
    };


}
?>