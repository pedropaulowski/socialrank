<?php
session_start();

require "assets/classes/usuarios.class.php";
require "assets/classes/notas.class.php";
$n = new Notas();
$u = new Usuarios();

if(!isset($_SESSION['nick']) || empty($_SESSION['nick'])){
    $_SESSION['nick'] = '';
}
if(isset($_GET['qtde'])){
    $qtde = addslashes(intval($_GET['qtde']));
    if($qtde==0){
        $qtde = 1;
    }
} else {
    $_GET['qtde'] = 10;
    $qtde = addslashes(intval($_GET['qtde']));
}

$qtdenova = $qtde+10;

?>
<html>
<head>
    <title>Ranking</title>
    <meta charset="UTF-8"/>
    <meta name="title" content="Ranking" />
    <meta id="viewport" name="viewport" content="width=device-width, user-scalable=no" />
    <link rel="stylesheet" href="./assets/css/style.css" />
    
</head>

<body class="bg-black">
    <header class="witdth flex justify-content-center bg-black fixed-top height">
        <div>
            <h1 class="title text-white">Ranking</h1>
        </div>
    </header>
    <div id="perfis" class="text-white mg-t20 mg-b120">
    <?php 
        $aux = 0;
        $lista = $u->ranking($qtde);
        foreach($lista as $user):?>
        <!--QTDE DE AVALIAÇÕES PARA ENTRAR NO RANK-->
        <?php if($n->getTodasAvaliacoes($user['id_user']) >= 2):?>
        <?php $aux++; ?>
        <div class="flex justify-content-center mg-t30">
            <div class="flex justify-content-between">
                <div class="flex">
                    <div class="img-circle" >
                        <img class="img"src="<?php echo $user['img_url'];?>">
                    </div>
                </div>
                <div class="flex flex-column mg-l30 border2-white width200">
                    <div>
                        <a href="<?php echo "perfil.php?nick=".$user['nick']."&&pagina=0"?>" class="text-white"><b><?php echo $user['nome'];?></b></a>
                    </div>
                    <div class="flex">
                        <a class="text-white mg-t5" >Nota: 
                            <b>
                                <?php 
                                $media = number_format($user['media'], 2, '.', '');
                                echo $media ;?>
                            </b>
                        </a>
                        <a><img id="estrelas" src="<?php
                        if($user['media'] >= 1 && $user['media'] < 1.5){
                            echo "./imagens/1star.png";
                        } else if($user['media'] >= 1.5 && $user['media'] < 2.0){
                            echo "./imagens/1-5stars.png";
                        } else if($user['media'] >=2 && $user['media'] < 2.5){
                            echo "./imagens/2stars.png";
                        }   else if($user['media'] >= 2.5 && $user['media'] < 3.0){
                            echo "./imagens/2-5stars.png";
                        }  else if($user['media'] >= 3.0 && $user['media'] < 3.5){
                            echo "./imagens/3stars.png";
                        } else if($user['media'] >= 3.5 && $user['media'] < 4.0){
                            echo "./imagens/3-5stars.png";
                        } else if($user['media'] >= 4.0 && $user['media'] < 4.5){
                            echo "./imagens/4stars.png";
                        } else if($user['media'] >= 4.5 && $user['media'] < 5){
                            echo "./imagens/4-5stars.png";
                        } else if($user['media'] == 5){
                            echo "./imagens/5stars.png";
                        }
                        ?>"/></a>
                    </div>
                    <div class="flex flex-column">
                        <a class="text-white mg-t5">Avaliações: <b><?php echo $n->getTodasAvaliacoes($user['id_user']);?></b></a>
                        <a class="text-white mg-t5">Posição: <b><?php echo $aux;?></b></a>
                    </div>
                </div>    
            </div>
        </div>

        <?php endif;endforeach;?>
    </div>

    <footer class="witdth flex justify-content-around bg-white fixed-bottom height">
    <?php if(!isset($_SESSION['nick']) || empty($_SESSION['nick'])):?>
        <a class="text-black mg-t5"href="login.php">LOGIN</a>
        <a class="text-black mg-t5" href="cadastrar.php">CADASTRE-SE</a>
    <?php else:?>
        <a class="text-black mg-t5"href="./">FEED</a>
        <a class="text-black mg-t5" href="<?php echo "rank.php?qtde=".$qtdenova;?>">VER MAIS</a>
    <?php endif;?>
    </footer>
    <?php if(isset($_SESSION['nick'])):?>
    <script type="text/javascript" src="./assets/js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="./assets/js/rank.js"></script>
    <?php else:?>
    <script type="text/javascript" src="./assets/js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="./assets/js/rank.js"></script>
    <?php endif;?>
</body>
</html>