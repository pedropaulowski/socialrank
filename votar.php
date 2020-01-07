<?php
session_start();

if(!isset($_SESSION['nick']) || empty($_SESSION['nick']) || !isset($_GET['nick']) || empty($_GET['nick'])){
    header("Location:index.php");
    exit;
} 

require "assets/classes/notas.class.php";
require "assets/classes/usuarios.class.php";

$u = new Usuarios();
$n = new Notas();
$nick = addslashes($_GET['nick']);
$id_destinatario = $u->getIdByNick($nick);
$nick = $_SESSION['nick'];
if(isset($_GET['nota']) && $_GET['nota'] <= 5 && $_GET['nota'] >= 1){
    $nota = intval(addslashes($_GET['nota']));
}


$id_remetente = $u->getIdByNick($nick);

$n->votar($id_remetente, $id_destinatario, $nota);

$nota1 = $n->getNotasUm($id_destinatario);
$nota2 = $n->getNotasDois($id_destinatario);
$nota3 = $n->getNotasTres($id_destinatario);
$nota4 = $n->getNotasQuatro($id_destinatario);
$nota5 = $n->getNotasCinco($id_destinatario);

$media = number_format($u->getMedia($id_destinatario), 2, '.', '');
echo '{"media":"'.$media.'",
    "nota1":"'.$nota1.'",
    "nota2":"'.$nota2.'",
    "nota3":"'.$nota3.'",
    "nota4":"'.$nota4.'",
    "nota5":"'.$nota5.'"
    }'
;

?>