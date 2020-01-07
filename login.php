<?php
session_start();

if(isset($_SESSION['nick']) && !empty($_SESSION['nick'])) {
    header("Location:index.php");
}
require "assets/classes/usuarios.class.php";

$u = new Usuarios();
if(isset($_POST['nick']) && isset($_POST['senha'])) {
    $nick = addslashes($_POST['nick']);
    $senha = addslashes($_POST['senha']);

    $senha_db = $u->logIn($nick);

    if(password_verify($senha, $senha_db) == 1) {
        $_SESSION['nick'] = $nick;
        header("Location:index.php");
    } else {
        header("Location:login.php");
    }

}
?>
<html>
<head>
    <title>Beetle</title>
    <meta charset="UTF-8" />
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
    <h2>LOG IN</h2>
    <div class="flex flex-column align-items-center align-content-center text-white mg-t50">
        <form method="POST">
            <div>
            <input class="login text-black title" type="text" name="nick" placeholder="Seu nick..."/>
            </div>  
            <div>
            <input class="login text-black mg-t10 title" onclick="mostrarSenha()" id="senha" type="password" name="senha" placeholder="Sua senha..."/>
            </div>
            <div class="flex justify-content-center mg-t10">
            <button type="submit" class="btn">LOG IN</button>
            </div>
        </form>
    </div>
    <footer class="witdth flex justify-content-around bg-white fixed-bottom height">
        <a class="text-black mg-t5" href="rank.php?pagina=1">RANK</a>
        <a class="text-black mg-t5" href="cadastrar.php?">CADASTRAR</a>
    </footer>
</body>

</html>