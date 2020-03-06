<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
require 'assets/classes/usuarios.class.php';
$u = new Usuarios();

if(isset($_GET['id'])) {
    set_time_limit(60);
    $id = $_GET['id'];
    $nick = $u->getNickById($id);
    $arr = array('nick' => $nick);
    echo json_encode($arr);
}


   