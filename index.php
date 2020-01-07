<?php
session_start();

require "assets/classes/imagens.class.php";
require "assets/classes/notas.class.php";
require "assets/classes/usuarios.class.php";
require "assets/classes/posts.class.php";
require "assets/classes/curtidas.class.php";

$p = new Posts();
$u = new Usuarios();
$i = new Imagens();
$c = new Curtidas();



$id_user = $u->getIdByNick($_SESSION['nick']);

if(!isset($_SESSION['nick']) || empty($_SESSION['nick'])){
    header("Location:login.php");
}
$id_user = $u->getIdByNick($_SESSION['nick']);
$img_url = $u->getImgUrlById($id_user);
$nick = $u->getNickById($id_user);

$ultimo_acesso = $u->getUltimoAcesso($id_user);
?>

<html>
<head>
    <title>Beetle</title>
    <meta charset="UTF-8" />
    <meta name="title" content="Beetle" />
    <meta id="viewport" name="viewport" content="width=device-width, user-scalable=no" />
    <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
    <link rel="stylesheet" href="./assets/css/style.css" />

</head>

<body class="bg-black" onload="atualizar()"id="body">
    <header class="flex flex-column align-items-center bg-white">
        <div><h1><a class="title text-black"href="./">Beetle</a></h1></div>
        <div class="flex">
            <form method="GET" id="form">
                <input class="search text-black" type="text" name="nick" placeholder="Procurar perfil..."/>
                <input class="submit"type="submit" value=">" />
            </form>
        </div>
    </header>
    
    <div class="flex justify-content-center mg-t30 hidden" id="perfil">
        <div class="flex justify-content-between">
            <div class="flex">
                <div class="img-circle" >
                    <img id="img">
                </div>
            </div>
            <div class="flex flex-column mg-l30 border2-white width-stats ">
                <div>
                    <a href="" id="redirect" class="text-white"><b id="nome"></b></a>
                </div>
                <div class="flex">
                    <a class="text-white mg-t5" >Nota: <b id="media"></b></a>
                    <a><img id="estrelas"/></a>
                </div>
                <div class="flex">
                    <a class="text-white mg-t5">Avaliações: <b id="avaliacoes"></b></a>
                </div>
            </div>    
        </div>
    </div>
    <div class="flex-column border2-white mg-t5">
        <div class="flex" >
            <div class="img-circle">
               <img src="<?php echo $img_url;?>" class="img"/>
            </div>
            <div class="mg-t30 mg-l30">
                <a class="text-white"href="<?php echo "perfil.php?nick=".$nick."&&pagina=0";?>" >
                    <b>Qual a boa?</b>
                </a>
            </div>
        </div>
        <div class="text-center mg-b10">
            <div class="width-315">
                <form class="width-320 margin-auto" method="POST" id="description">
                    <input type="text" name="nick" id="nick" value="<?php echo $nick;?>"hidden/>
                    <textarea id="textarea_post"class="bg-black text-white form-description" name="texto" maxlength="140" placeholder="Qual a boa?" required autofocus>
                    </textarea>
                    <button class="submit"type="submit"></button>
                </form>
            </div>
        </div>
    </div>
    <div class="flex-column mg-t30" id="posts-content">
    </div>

    <div class="flex-column mg-t30" id="posts-content-antigos">
    <?php
        $lista = $p->arrayPostsAntigos($id_user, $ultimo_acesso);

        foreach($lista as $post):

            if ($c->existeCurtida($post['id_post'], $id_user) == true)
                $cor_coracao = "red";
            else 
                $cor_coracao = "white";
    ?>  
    <div class="border2-white flex-column post  mg-t5 mg-b120">
        <div class="flex" >
            <div class="img-circle">
                <img src="<?php echo $u->getImgUrlById($post['id_criador']);?>" class="img" id="img-profile-post"/>
            </div>
            <div class="mg-t30 mg-l30">
                <a class="text-white"href="perfil.php?nick=<?php echo $post['nick'];?>&&pagina=0"><b>@<?php echo $post['nick'];?></b></a>
            </div>
        </div>
        <div class="text-center mg-b10">
            <p class="text-white"><?php echo $post['texto'];?></p>
        </div>
        <div class="flex justify-content-around mg-b10">
            <button onclick="curtir(<?php echo $post['id_post'];?>)" class="curtir refresh" id="<?php echo $post['id_post'];?>">
                <div>
                    <i id="coracao_post<?php echo $post['id_post'];?>"class="fa fa-heart" <?php echo "style=font-size:28px;color:".$cor_coracao;?>></i>
                </div>
                <div style="color:white" id="curtidas_post<?php echo $post['id_post'];?>">
                    <?php echo $post['curtidas'];?>
                </div>
            </button>
            <div>
            <p class="text-white font-12"><?php 
            
            echo  date("d-m h:i:s",strtotime( $post['hora']));?></p>
            </div>
        </div>
    </div>
    <?php
        endforeach;
    ?>
    </div>
    <form class="width-320 margin-auto" method="POST" id="atualizar">
        <input type="text" name="nick" id="nick_bottom" value="<?php echo $nick;?>"hidden/>
        <footer class="witdth flex justify-content-around bg-white fixed-bottom height">
            <button type="submit" class="refresh"><a class="text-black mg-t5" >FEED</a></button>

            <a class="text-black mg-t5" href="rank.php?qtde=10">RANK</a>
            <a class="text-black mg-t5" href="perfil.php?nick=<?php echo $_SESSION['nick']."&&pagina=0";?>">PERFIL</a>
        </footer>
    </form>
    <script type="text/javascript" src="./assets/js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="./assets/js/script.js"></script>
    <script type="text/javascript" src="./assets/js/actions.js"></script>
    
</body>

</html>