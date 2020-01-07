<?php
session_start();

require 'assets/classes/usuarios.class.php';
$u = new Usuarios();

if(isset($_GET['nick'])){
    $nick = $_GET['nick'];
    $img_url = $u->getImgUrlByNick($nick);
    $arr = ['img_url' => $img_url];

    echo json_encode($arr);
}
?>