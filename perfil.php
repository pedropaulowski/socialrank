<?php
session_start();

require "assets/classes/imagens.class.php";
require "assets/classes/seguidores.class.php";
require "assets/classes/notas.class.php";
require "assets/classes/usuarios.class.php";
require "assets/classes/comentarios.class.php";

if(!isset($_SESSION['nick']) || empty($_SESSION['nick'])){
    $_SESSION['nick'] = '';
}
$s = new Seguidores();
$c = new Comentarios();
$n = new Notas();
$u = new Usuarios();
$img = new Imagens();

$nick = addslashes($_GET['nick']);
$descricao = utf8_encode($u->getDescricaoByNick($nick));
$id_user = $u->getIdByNick($nick);
$foto = $u->getImgUrlByNick($nick);
$media = number_format($u->getMedia($id_user), 2, '.', '');
$cinco = $n->getNotasCinco($id_user);
$quatro = $n->getNotasQuatro($id_user);
$tres = $n->getNotasTres($id_user);
$dois = $n->getNotasDois($id_user);
$um = $n->getNotasUm($id_user);
$nome = $u->getNomeByNick($nick);
$id_dad = $id_user;

if($_SESSION['nick'] != ''){
    $id_son = $u->getIdByNick($_SESSION['nick']);
}
$qtde_segs = $s->getTotalSegs($id_dad);


$pagina = $_GET['pagina'];
$proximapagina = $pagina+5;
$entrada = $u->getEntradaByNick($nick);
$entrada = strtotime($entrada);
$entrada = date('F y', $entrada);

?>
<html>
<head>
    <title>
        <?php 
            if($_GET['nick'] == $_SESSION['nick']){ 
                echo "Meu Perfil";
            } else {
                echo $nome;
            }
        ?>
        </title>
    <meta charset="UTF-8"/>
    <meta name="title" content="
        <?php 
            if($_GET['nick'] == $_SESSION['nick']){ 
                echo "Meu Perfil";
            } else {
                echo $nome;
            }
        ?>" />
    <meta id="viewport" name="viewport" content="width=device-width, user-scalable=no" />
    <link rel="stylesheet" href="./assets/css/style.css" />
    
</head>

<body class="bg-white">
    <header class="witdth flex justify-content-center bg-black fixed-top height">
        <div>
            <h1 class="title text-white"> 
            <?php 
                if($_GET['nick'] == $_SESSION['nick']){ 
                    echo "Meu Perfil";
                } else {
                    echo $nome;
                }
            ?>
            </h1>
        </div>
    </header>
    
    <div class="mg-b120 flex flex-column justify-content-center mg-t50">
        <div>
            <div class="flex flex-column align-items-center">
                <div class="img-circle-profile">
                    <img class="img-profile"<?php if($_GET['nick'] == $_SESSION['nick']) echo 'onclick="abrirForm()"';?>  src="<?php echo $foto;?>">
                </div>	
                <?php if($_GET['nick'] == $_SESSION['nick']) echo '<a onclick="abrirForm()"  id="mudarfoto" class="mg-t20 text-black"><b>Mudar foto</b></a>';?>
                <?php echo '<a class="mg-t20 text-black"><a id="segs" class="mg-t20 text-black">'.$qtde_segs.'</a> Seguidores</a>';?>
                <div class="flex justify-content-around follow align-items-center">
                    <div>
                    <?php echo '<a class="mg-t20 text-black"><b>@<a id="nick" class="mg-t20 text-black">'.$nick.'</a></b></a>';?>
                    </div>
                    <?php if($_SESSION['nick'] != $_GET['nick'] && $_SESSION['nick'] != ''):?>
                        <div>
                            <form id="follow-form" method="GET">
                                <input type="text" name="id_dad" id ="id_dad" value="<?php echo $id_dad;?>" hidden />
                                <input type="number" name="pagina"  value="<?php echo $pagina;?>" hidden />
                                <input type="text" name="id_son" id ="id_son"value="<?php echo $id_son;?>" hidden />
                                <input type="checkbox" id="follow" <?php if($s->alreadyFollow($id_dad, $id_son) == true) echo "checked"; ?>/>
                            </form>
                        </div>
                    <?php endif;?>
                </div>
                <?php if($_GET['nick'] == $_SESSION['nick']) echo '<button onclick="fecharForm()"  id="fecharfoto" class="hidden mg-l300 text-black">X</button>';?>
                <form class="hidden" id="form-foto" method="POST" enctype="multipart/form-data" action="enviar-foto.php"> 
                    <a class="text-black">Imagens ou GIFs</a>
                    <input type="file" name="imagem" accept="image/*" required /><br/><br/>
                    <input <?php if($_GET['nick'] == $_SESSION['nick']) echo 'onclick="fecharForm()"';?> type="submit" value="Mudar"/>
                </form>
                
            </div>
        </div>
        <div class="flex justify-content-around" id="five">
            <a>
                <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="42px" height="59px" version="1.1" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
                    viewBox="0 0 42 59.4"
                    xmlns:xlink="http://www.w3.org/1999/xlink">
                    <defs>
                    <clipPath id="id0">
                        <rect x="5.15" y="13.92" width="33.13" height="31.18"/>
                    </clipPath>
                    </defs>
                    <g id="Camada_x0020_1">
                    <metadata id="CorelCorpID_0Corel-Layer"/>
                    <g style="clip-path:url(#id0)">
                    <image x="5.15" y="13.92" width="33.13" height="31.18" />
                    </g>
                    <path class="fil0 str0" id="nota1" d="M17.27 25.28l-12.12 0 0 0.27c0.12,0.03 1.05,0.8 1.17,0.9 0.21,0.16 0.38,0.3 0.58,0.45 0.58,0.44 1.2,0.97 1.76,1.38 0.11,0.08 0.19,0.15 0.29,0.23 0.1,0.09 0.18,0.14 0.29,0.23l4.67 3.67c0.75,0.62 0.65,0.26 0.39,1.19 -0.07,0.26 -0.14,0.48 -0.22,0.73l-0.42 1.46c-0.42,1.41 -0.91,2.99 -1.29,4.38 -0.14,0.48 -0.28,0.97 -0.43,1.46 -0.08,0.23 -0.14,0.48 -0.22,0.73l-0.63 2.19c0.1,-0.02 0.22,-0.13 0.32,-0.19l9.97 -6.66 9.01 6.01c0.19,0.13 1.18,0.81 1.31,0.84l-1.28 -4.38c-0.47,-1.67 -1.03,-3.41 -1.51,-5.1 -0.07,-0.25 -0.13,-0.48 -0.21,-0.73 -0.08,-0.25 -0.14,-0.48 -0.21,-0.73l-0.23 -0.75c0.12,-0.03 1.59,-1.22 1.81,-1.39l3.03 -2.39c0.1,-0.07 0.19,-0.14 0.29,-0.22l2.41 -1.89c0.11,-0.09 0.19,-0.15 0.3,-0.24l1.22 -0.96c0.12,-0.1 0.53,-0.4 0.59,-0.49l-12.39 0 -1.37 -3.9c-0.04,-0.11 -0.08,-0.23 -0.13,-0.36 -0.05,-0.12 -0.08,-0.22 -0.12,-0.34l-0.38 -1.08c-0.44,-1.26 -0.96,-2.64 -1.38,-3.89 -0.09,-0.27 -0.6,-1.65 -0.61,-1.79l-0.27 0 -0.61 1.76c-0.43,1.28 -0.95,2.63 -1.39,3.91l-1.99 5.69z"/>
                    </g>
                </svg>
            </a>
            <a> 
                <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="42px" height="59px" version="1.1" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
                    viewBox="0 0 42 59.4"
                    xmlns:xlink="http://www.w3.org/1999/xlink">
                    <defs>
                    <clipPath id="id0">
                        <rect x="5.15" y="13.92" width="33.13" height="31.18"/>
                    </clipPath>
                    </defs>
                    <g id="Camada_x0020_1">
                    <metadata id="CorelCorpID_0Corel-Layer"/>
                    <g style="clip-path:url(#id0)">
                    <image x="5.15" y="13.92" width="33.13" height="31.18" />
                    </g>
                    <path class="fil0 str0" id="nota2" d="M17.27 25.28l-12.12 0 0 0.27c0.12,0.03 1.05,0.8 1.17,0.9 0.21,0.16 0.38,0.3 0.58,0.45 0.58,0.44 1.2,0.97 1.76,1.38 0.11,0.08 0.19,0.15 0.29,0.23 0.1,0.09 0.18,0.14 0.29,0.23l4.67 3.67c0.75,0.62 0.65,0.26 0.39,1.19 -0.07,0.26 -0.14,0.48 -0.22,0.73l-0.42 1.46c-0.42,1.41 -0.91,2.99 -1.29,4.38 -0.14,0.48 -0.28,0.97 -0.43,1.46 -0.08,0.23 -0.14,0.48 -0.22,0.73l-0.63 2.19c0.1,-0.02 0.22,-0.13 0.32,-0.19l9.97 -6.66 9.01 6.01c0.19,0.13 1.18,0.81 1.31,0.84l-1.28 -4.38c-0.47,-1.67 -1.03,-3.41 -1.51,-5.1 -0.07,-0.25 -0.13,-0.48 -0.21,-0.73 -0.08,-0.25 -0.14,-0.48 -0.21,-0.73l-0.23 -0.75c0.12,-0.03 1.59,-1.22 1.81,-1.39l3.03 -2.39c0.1,-0.07 0.19,-0.14 0.29,-0.22l2.41 -1.89c0.11,-0.09 0.19,-0.15 0.3,-0.24l1.22 -0.96c0.12,-0.1 0.53,-0.4 0.59,-0.49l-12.39 0 -1.37 -3.9c-0.04,-0.11 -0.08,-0.23 -0.13,-0.36 -0.05,-0.12 -0.08,-0.22 -0.12,-0.34l-0.38 -1.08c-0.44,-1.26 -0.96,-2.64 -1.38,-3.89 -0.09,-0.27 -0.6,-1.65 -0.61,-1.79l-0.27 0 -0.61 1.76c-0.43,1.28 -0.95,2.63 -1.39,3.91l-1.99 5.69z"/>
                    </g>
                </svg>
            </a>
            <a>                
                <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="42px" height="59px" version="1.1" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
                        viewBox="0 0 42 59.4"
                        xmlns:xlink="http://www.w3.org/1999/xlink">
                        <defs>
                        <clipPath id="id0">
                            <rect x="5.15" y="13.92" width="33.13" height="31.18"/>
                        </clipPath>
                        </defs>
                        <g id="Camada_x0020_1">
                        <metadata id="CorelCorpID_0Corel-Layer"/>
                        <g style="clip-path:url(#id0)">
                        <image x="5.15" y="13.92" width="33.13" height="31.18" />
                        </g>
                        <path class="fil0 str0" id="nota3" d="M17.27 25.28l-12.12 0 0 0.27c0.12,0.03 1.05,0.8 1.17,0.9 0.21,0.16 0.38,0.3 0.58,0.45 0.58,0.44 1.2,0.97 1.76,1.38 0.11,0.08 0.19,0.15 0.29,0.23 0.1,0.09 0.18,0.14 0.29,0.23l4.67 3.67c0.75,0.62 0.65,0.26 0.39,1.19 -0.07,0.26 -0.14,0.48 -0.22,0.73l-0.42 1.46c-0.42,1.41 -0.91,2.99 -1.29,4.38 -0.14,0.48 -0.28,0.97 -0.43,1.46 -0.08,0.23 -0.14,0.48 -0.22,0.73l-0.63 2.19c0.1,-0.02 0.22,-0.13 0.32,-0.19l9.97 -6.66 9.01 6.01c0.19,0.13 1.18,0.81 1.31,0.84l-1.28 -4.38c-0.47,-1.67 -1.03,-3.41 -1.51,-5.1 -0.07,-0.25 -0.13,-0.48 -0.21,-0.73 -0.08,-0.25 -0.14,-0.48 -0.21,-0.73l-0.23 -0.75c0.12,-0.03 1.59,-1.22 1.81,-1.39l3.03 -2.39c0.1,-0.07 0.19,-0.14 0.29,-0.22l2.41 -1.89c0.11,-0.09 0.19,-0.15 0.3,-0.24l1.22 -0.96c0.12,-0.1 0.53,-0.4 0.59,-0.49l-12.39 0 -1.37 -3.9c-0.04,-0.11 -0.08,-0.23 -0.13,-0.36 -0.05,-0.12 -0.08,-0.22 -0.12,-0.34l-0.38 -1.08c-0.44,-1.26 -0.96,-2.64 -1.38,-3.89 -0.09,-0.27 -0.6,-1.65 -0.61,-1.79l-0.27 0 -0.61 1.76c-0.43,1.28 -0.95,2.63 -1.39,3.91l-1.99 5.69z"/>
                        </g>
                </svg>
            </a>
            <a>                
                <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="42px" height="59px" version="1.1" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
                    viewBox="0 0 42 59.4"
                    xmlns:xlink="http://www.w3.org/1999/xlink">
                    <defs>
                    <clipPath id="id0">
                        <rect x="5.15" y="13.92" width="33.13" height="31.18"/>
                    </clipPath>
                    </defs>
                    <g id="Camada_x0020_1">
                    <metadata id="CorelCorpID_0Corel-Layer"/>
                    <g style="clip-path:url(#id0)">
                    <image x="5.15" y="13.92" width="33.13" height="31.18" />
                    </g>
                    <path class="fil0 str0" id="nota4" d="M17.27 25.28l-12.12 0 0 0.27c0.12,0.03 1.05,0.8 1.17,0.9 0.21,0.16 0.38,0.3 0.58,0.45 0.58,0.44 1.2,0.97 1.76,1.38 0.11,0.08 0.19,0.15 0.29,0.23 0.1,0.09 0.18,0.14 0.29,0.23l4.67 3.67c0.75,0.62 0.65,0.26 0.39,1.19 -0.07,0.26 -0.14,0.48 -0.22,0.73l-0.42 1.46c-0.42,1.41 -0.91,2.99 -1.29,4.38 -0.14,0.48 -0.28,0.97 -0.43,1.46 -0.08,0.23 -0.14,0.48 -0.22,0.73l-0.63 2.19c0.1,-0.02 0.22,-0.13 0.32,-0.19l9.97 -6.66 9.01 6.01c0.19,0.13 1.18,0.81 1.31,0.84l-1.28 -4.38c-0.47,-1.67 -1.03,-3.41 -1.51,-5.1 -0.07,-0.25 -0.13,-0.48 -0.21,-0.73 -0.08,-0.25 -0.14,-0.48 -0.21,-0.73l-0.23 -0.75c0.12,-0.03 1.59,-1.22 1.81,-1.39l3.03 -2.39c0.1,-0.07 0.19,-0.14 0.29,-0.22l2.41 -1.89c0.11,-0.09 0.19,-0.15 0.3,-0.24l1.22 -0.96c0.12,-0.1 0.53,-0.4 0.59,-0.49l-12.39 0 -1.37 -3.9c-0.04,-0.11 -0.08,-0.23 -0.13,-0.36 -0.05,-0.12 -0.08,-0.22 -0.12,-0.34l-0.38 -1.08c-0.44,-1.26 -0.96,-2.64 -1.38,-3.89 -0.09,-0.27 -0.6,-1.65 -0.61,-1.79l-0.27 0 -0.61 1.76c-0.43,1.28 -0.95,2.63 -1.39,3.91l-1.99 5.69z"/>
                    </g>
                </svg>
            </a>
            <a>                
                <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="42px" height="59px" version="1.1" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
                    viewBox="0 0 42 59.4"
                    xmlns:xlink="http://www.w3.org/1999/xlink">
                    <defs>
                    <clipPath id="id0">
                        <rect x="5.15" y="13.92" width="33.13" height="31.18"/>
                    </clipPath>
                    </defs>
                    <g id="Camada_x0020_1">
                    <metadata id="CorelCorpID_0Corel-Layer"/>
                    <g style="clip-path:url(#id0)">
                    <image x="5.15" y="13.92" width="33.13" height="31.18" />
                    </g>
                    <path class="fil0 str0" id="nota5" d="M17.27 25.28l-12.12 0 0 0.27c0.12,0.03 1.05,0.8 1.17,0.9 0.21,0.16 0.38,0.3 0.58,0.45 0.58,0.44 1.2,0.97 1.76,1.38 0.11,0.08 0.19,0.15 0.29,0.23 0.1,0.09 0.18,0.14 0.29,0.23l4.67 3.67c0.75,0.62 0.65,0.26 0.39,1.19 -0.07,0.26 -0.14,0.48 -0.22,0.73l-0.42 1.46c-0.42,1.41 -0.91,2.99 -1.29,4.38 -0.14,0.48 -0.28,0.97 -0.43,1.46 -0.08,0.23 -0.14,0.48 -0.22,0.73l-0.63 2.19c0.1,-0.02 0.22,-0.13 0.32,-0.19l9.97 -6.66 9.01 6.01c0.19,0.13 1.18,0.81 1.31,0.84l-1.28 -4.38c-0.47,-1.67 -1.03,-3.41 -1.51,-5.1 -0.07,-0.25 -0.13,-0.48 -0.21,-0.73 -0.08,-0.25 -0.14,-0.48 -0.21,-0.73l-0.23 -0.75c0.12,-0.03 1.59,-1.22 1.81,-1.39l3.03 -2.39c0.1,-0.07 0.19,-0.14 0.29,-0.22l2.41 -1.89c0.11,-0.09 0.19,-0.15 0.3,-0.24l1.22 -0.96c0.12,-0.1 0.53,-0.4 0.59,-0.49l-12.39 0 -1.37 -3.9c-0.04,-0.11 -0.08,-0.23 -0.13,-0.36 -0.05,-0.12 -0.08,-0.22 -0.12,-0.34l-0.38 -1.08c-0.44,-1.26 -0.96,-2.64 -1.38,-3.89 -0.09,-0.27 -0.6,-1.65 -0.61,-1.79l-0.27 0 -0.61 1.76c-0.43,1.28 -0.95,2.63 -1.39,3.91l-1.99 5.69z"/>
                    </g>
                </svg>
            </a>
        </div>
        <div class="flex text-black width-315 flex-column justify-content-center margin-auto mg-t10 mg-l3">
            <a><b>Média: <a id="media" ><?php echo $media;?></a></b></a>
            <a class="mg-t10">Since <?php echo $entrada;?></a>
            <h3 <?php if($_GET['nick'] == $_SESSION['nick']) echo 'onclick="editDescription()"';?>class=" mg-t10">Descrição:</h3>
            <div class="descricao-div mg-t20 text-14pt" id="descricaoatt">
                    <?php echo $descricao; ?>
            </div>
            <div class="width-315">
                <button onclick="fecharFormDescription()" id="fechar" class="hidden mg-l300 text-black">X</button>
                <form class="hidden width-320 mg-l20 margin-auto" method="POST" id="description">
                    <input type="text" name="nick" id="nick" value="<?php echo $nick;?>"hidden/>
                    <textarea id="textarea_description"class="mg-l20 bg-white text-black form-description" name="description" maxlength="140" placeholder="Descrição com no máximo 140 caracteres" required autofocus>
                    </textarea>
                    <button onclick="fecharFormDescription()" class="mg-l300 submit"type="submit"></button>
                </form>
            </div>
        </div>
        <div class="width-315 margin-auto mg-t20">
            <div class="flex flex-column align-items-end mg-r3 text-black">
                <div class="flex">
                    <a id="notas5" class="mg-t5"><?php echo $cinco;?></a><img src="imagens/5stars.png"/>
                </div>
                <div class="flex">
                    <a id="notas4" class="mg-t5"><?php echo $quatro;?></a><img src="imagens/4stars.png"/>
                </div>
                <div class="flex">
                    <a id="notas3" class="mg-t5"><?php echo $tres;?></a><img src="imagens/3stars.png"/>
                </div>
                <div class="flex">
                    <a id="notas2" class="mg-t5"><?php echo $dois;?></a><img src="imagens/2stars.png"/>
                </div>
                <div class="flex">
                    <a id="notas1" class="mg-t5"><?php echo $um;?></a><img src="imagens/1star.png"/>
                </div>
            </div>
        <div>
        <div class="flex flex-column align-content-center align-items-center">
        <h3 class="title text-black mg-t20">Comentários</h3>
        <a class="text-black mg-t20" id="msg"></a>
        <?php if($_GET['nick'] != $_SESSION['nick'] && !empty($_SESSION['nick'])):?>
            <div class="coments text-black mg-t10 mg-b10">
                <form method="GET" id="coment">
                    <input type="text" name="nick" id="nick" value="<?php echo $nick;?>"hidden/>
                    <textarea id="comentario-now" class="mg-l20 bg-white text-black form-description" name="comentario" placeholder="Escreva um comentário... Max(140 caracteres)" maxlength="140"></textarea>
                    <button class="submit"type="submit"></button>
                </form>
            </div>
            <div class="coments text-black mg-t10 mg-b10 hidden" id="live">
                <p id="texto-coment"></p>
                <p class="coments-hora" id="hora-coment"></p> 
            </div>
        <?php endif;?>
        <?php
            $id_destinatario = $id_user;
            if($c->getComentarios($pagina, $id_destinatario) != false){
                $lista = $c->getComentarios($pagina, $id_destinatario);
            foreach($lista as $comentario):?>
                <div class="coments text-black mg-t10 mg-b10 word-break-break">
                        <p><?php echo $comentario['comentario'];?>
                        </p>
                        <p class="coments-hora">
                            <?php 
                                $hora = strtotime($comentario['hora']);
                                $hora = date('d/m/y à\s H:i  ', $hora);
                                echo $hora;
                            ?>
                        </p> 
                </div>
        <?php endforeach;}else{?>
            
        <?php }?>

        </div>        
    </div>
    <footer class="witdth flex justify-content-around bg-white fixed-bottom height">
    <?php if(!isset($_SESSION['nick']) || empty($_SESSION['nick'])):?>
        <a class="text-black mg-t5"href="login.php">LOGIN</a>
        <a class="text-black mg-t5" href="cadastrar.php">CADASTRE-SE</a>
    <?php else:?>
        <a class="text-black mg-t5"href="./">FEED</a>
        <a class="text-black mg-t5" href="rank.php?qtde=10">RANK</a>
        <?php if($_SESSION['nick'] == $_GET['nick']) echo '<a class="text-black mg-t5" href="logout.php">LOG OUT</a>'; else echo '<a class="text-black mg-t5" href="perfil.php?nick='.$_SESSION['nick'].'&&pagina=0">PERFIL</a>'; ?>
    <?php endif;?>
    </footer>
    <?php if($_GET['nick'] == $_SESSION['nick']):?>
    <script type="text/javascript" src="./assets/js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="./assets/js/perfil.js"></script>
    <?php else:?>
    <script type="text/javascript" src="./assets/js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="./assets/js/coment.js"></script>
    <?php endif;?>
    <script type="text/javascript" src="./assets/js/voto.js"></script>
</body>
</html>