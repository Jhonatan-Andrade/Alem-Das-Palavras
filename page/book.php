<?php
    session_start();
    if ((!isset($_SESSION["username"]))) {
        header("location: ./user.php"); 
        exit();
    }else{
        $username = $_SESSION["username"];
    }
    function logout() {
        $_SESSION["username"] = null;
        header("location: ./user.php"); 
        exit();
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Book</title>
        
        <link rel="stylesheet" href="../css/header.css">
        <link rel="stylesheet" href="../css/book.css">
    </head>
    <body>
        <header>
            <a class="beyondwords" href="./home.php">Beyond words</a>
            <nav>
                <ul>
                    <li id="userMenuItem"><button onclick="openModalUpload()" class="user menuItem" type="button"></button></li>
                    <li id="olaMenuItem"><p class="ola">Olá  <?php if (isset($username)) echo $username; ?></p></li>
                    <li id="favoriteMenuItem"><a class="favorite menuItem" href="favorite.php"></a></li>
                    <li id="logoutMenuItem"><a class="logout menuItem" type="button" href="goback.php" ></a></li>
                </ul>
            </nav>
        </header>
        <main>
            <div class="bookConteiner">

            </div>
        </main>
        <div class="uploadConteiner">
            <div class="upload" >
                <button class="closeModalUpload" onclick="closeModalUpload()" type="button"></button>
                <div class="fileUpload">
                    <p id="nomeArquivoSelecionado">Click aqui para selecionar uma imagem</p>
                </div>
                <div id="inputImagemBox">
                    <input class="imagem" type="file" name="imagem" id="imagem" style="display:none">
                </div>
                <button class="submit" onclick="salvarImagem()">Enviar</button>
            </div>
        </div>
         
    </body>
    <script src="../js/imgUpLoad.js" ></script>
    <script src="../js/book.js"></script>
</html>