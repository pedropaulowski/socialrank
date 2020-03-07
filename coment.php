<?php
session_start();

if(!isset($_SESSION['nick']) || empty($_SESSION['nick'])) {
    header("Location:index.php");
    exit;
} else {
    require "assets/classes/comentarios.class.php";
    require "assets/classes/usuarios.class.php";
    
    $u = new Usuarios();
    $c = new Comentarios();
    if(isset($_GET['nick'])){
        $nick = addslashes($_GET['nick']);
        $id_destinatario = $u->getIdByNick($nick);
    } else {
        $id_destinatario = 0;   
    }
    $id_post = '';
    $nick = $_SESSION['nick'];
    $id_remetente = $u->getIdByNick($nick);
    $ult_acesso = $u->getUltimoAcesso($id_remetente);
    
    session_write_close();

    if(!isset($_GET['id_post']) || empty($_GET['id_post']) || isset($_GET['tipo']) || !empty($_GET['tipo'])) {
        $tipo = $_GET['tipo'];
        if(isset($_GET['comentario']) && !empty($_GET['comentario'])){
            $comentario = $_GET['comentario'];
            $c->comentar($id_remetente, $id_destinatario, $comentario, $id_post);
            $c->jsonComentarios($id_destinatario, $tipo, $ult_acesso);
            if($tipo != 'menor') {
                $ult_acesso = date("Y-m-d H:i:s");
                $u->setUltimoAcesso($id_remetente, $ult_acesso);
            }
            exit;
    
        } else {
            $c->jsonComentarios($id_destinatario, $tipo, $ult_acesso);
            $u->setUltimoAcesso($id_remetente, $ult_acesso);
            if($tipo != 'menor') {
                $ult_acesso = date("Y-m-d H:i:s");
                $u->setUltimoAcesso($id_remetente, $ult_acesso);
            }
            exit;
        }
    } else if(isset($_GET['comentario']) && !empty($_GET['comentario'])){
        $id_post = $_GET['id_post'];
        $comentario = $_GET['comentario'];
        $c->comentar($id_remetente, $id_destinatario, $comentario, $id_post);
        exit;
    }
    
    

}