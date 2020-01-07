<?php
session_start();

if(empty($_SESSION['nick']) || !isset($_SESSION['nick']) || !isset($_POST['description']) || empty($_POST['description']) || $_POST['description'] == ''){
    exit;
}

require "assets/classes/usuarios.class.php";
$u = new Usuarios();
$nick = $_SESSION['nick'];

$id_user = $u->getIdByNick($nick);
$descricao = $_POST['description'];

$u->editarDescricao($id_user,$descricao);

$descricao = $u->getDescricaoByNick($nick);
echo '{
  "descricao":"'.utf8_encode($descricao).'"  
}';
?>