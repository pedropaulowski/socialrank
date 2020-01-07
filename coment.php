<?php
session_start();

if(!isset($_SESSION['nick']) || empty($_SESSION['nick']) || !isset($_GET['nick']) || empty($_GET['nick'])){
    header("Location:index.php");
    exit;
} else {
    require "assets/classes/comentarios.class.php";
    require "assets/classes/usuarios.class.php";
    
    $u = new Usuarios();
    $c = new Comentarios();
    $nick = addslashes($_GET['nick']);
    $id_destinatario = $u->getIdByNick($nick);
    $nick = $_SESSION['nick'];
    if(isset($_GET['comentario']) && !empty($_GET['comentario'])){
        $comentario = addslashes($_GET['comentario']);
        $id_remetente = $u->getIdByNick($nick);
    
        $c->comentar($id_remetente, $id_destinatario, $comentario);
    } 
    

}