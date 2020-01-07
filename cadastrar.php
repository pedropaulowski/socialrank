<?php
session_start();

if(isset($_SESSION['nick']) && !empty($_SESSION['nick'])) {
    header("Location:index.php");
}
require "assets/classes/usuarios.class.php";

$u = new Usuarios();


if(isset($_POST['nick']) && isset($_POST['senha'])) {
    $nick = addslashes(strtolower($_POST['nick']));
    $senha = addslashes($_POST['senha']);
    $senha = password_hash($senha, PASSWORD_BCRYPT);
    $email = addslashes($_POST['email']);
    $nome = addslashes($_POST['nome']);
    $media = 5;
    $descricao = "Hey there! I'm using Beetle";
    $qr_code = "http:socialrank.test/perfil.php?".$nick."&&pagina=0";

    $nicklength = strlen ($nick);
    $aux = 0;

    for($i=0; $i < $nicklength; $i++){
        if($nick[$i] == ' ' || (($nick[$i] >= ":" && $nick[$i] <= "`") || ($nick[$i] >= "{" && $nick[$i] <= "_")) || $nick[$i] == '-'){
            $aux++;
        }
        if($nick[$i] == "_" && $aux > 0){
            $aux -= 1;
        }
    }
    if($aux == 0){
        if($u->setUsuario($email, $senha, $nome, $nick, $qr_code, $media, $descricao) == true) {
            $_SESSION['nick'] = $nick;
            header("Location:perfil.php?nick=".$nick."&&pagina=0");
        } else {
            echo "<a class='text-white'>Nick ou e-mail já utilizados/inválidos</a><pre clas='text-white'>";
            print_r($u->setUsuario($email, $senha, $nome, $nick, $qr_code, $media, $descricao));
            echo "</pre>";
        }
    } else {
        echo "<a class='text-white'>Não é permitido caracteres especiais</a><pre clas='text-white'>";
        /*print_r($u->setUsuario($email, $senha, $nome, $nick, $qr_code, $media, $descricao));
        echo "</pre>";*/
    }


}
?>
<html>
<head>
    <title>Beetle</title>
    <meta charset="UTF-8"/>
    <meta name="title" content="Beetle" />
    <meta id="viewport" name="viewport" content="width=device-width, user-scalable=no" />
    <link rel="stylesheet" href="./assets/css/style.css" />
    <script type="text/javascript">
        function mostrarSenha() {
            let senha = document.querySelector("#senha");

            senha.removeAttribute("type", "password");
            senha.setAttribute("type", "text");
            setTimeout(esconderSenha, 1000);
        }
        function esconderSenha() {
            let senha = document.querySelector("#senha");

            senha.removeAttribute('type', 'text');
            senha.setAttribute('type', 'password');
        }
    </script>
</head>

<body class="bg-black">
    <header class="flex justify-content-around bg-white">
        <div><h1 class="title text-black"><a class="title text-black"href="./">Beetle</a></h1></div>
    </header>
    <div class="flex flex-column align-items-center align-content-center text-white mg-t50">
        <form method="POST">
            <div>
                <h3>Nick:<h3>
                <input class="login text-black title" type="text" name="nick" placeholder="Sem caracteres especiais." maxlength="20"required/>
            </div>  
            <div>
                <h3>Nome:<h3>
                <input class="login text-black mg-t10 title" type="text" name="nome" placeholder="Nome" required/>
            </div>
            <div>
                <h3>E-mail:<h3>
                <input class="login text-black mg-t10 title" type="email" name="email" placeholder="E-mail..." required/>
            </div>
            <div>
                <h3>Senha:<h3>
                <input class="login text-black mg-t10 title" type="password" name="senha" id="senha" placeholder="Sua senha..." required/>
                <img onclick="mostrarSenha()" src="imagens/olho.png" width="20"/>
                </textarea>
            
            </div>
            <div class="flex justify-content-center mg-t10">
            <button type="submit" class="btn">CADASTRAR</button>
            </div>
        </form>
    </div>
    <footer class="witdth flex justify-content-around bg-white fixed-bottom height">
        <a class="text-black mg-t5" href="rank.php?pagina=1">RANK</a>
    </footer>
</body>

</html>