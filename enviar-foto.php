<?php
session_start();
if(!isset($_SESSION['nick']) || empty($_SESSION['nick'])){
    header("Location:index.php");
    exit;
}
require "assets/classes/imagens.class.php";
require "assets/classes/usuarios.class.php";

$i = new Imagens();
$u = new Usuarios();
$nick = $_SESSION['nick'];
$id_user = $u->getIdByNick($nick); 
if(isset($_FILES['imagem']) && !empty($_FILES['imagem'])){
    $path = $_FILES['imagem']['name'];
    $ext = pathinfo($path, PATHINFO_EXTENSION);

    if($ext == "bmp" ||$ext == "jpg" || $ext == "tiff" || $ext == "jpeg" || $ext == "gif" || $ext == "png" || $ext == "eps" || $ext == "svg"){
        $imagem = $_FILES['imagem'];
        $name = md5($imagem['name'].$nick);
        $img_url = "imagens/".$name.".".$ext;
    
         if(isset($imagem['tmp_name']) && !empty($imagem['tmp_name'])){
            move_uploaded_file($imagem['tmp_name'], $img_url);
            $i->setImagem($id_user, $img_url);
            $u->editarImg($id_user, $img_url);
    
            header("Location:perfil.php?nick=".$nick."&&pagina=0");
         }
    } else {
        header("Location:perfil.php?nick=".$nick."&&pagina=0");
    }

} else {
    header("Location:index.php");
    exit;
}

?>