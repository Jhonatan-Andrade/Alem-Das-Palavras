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
    <title>Home</title>
    <link rel="stylesheet" href="../css/home.css">
</head>
<body>
    <header>
        <h1>Beyond words</h1>
        <nav>
            <ul>
                <li><button onclick="openModalUpload()" class="user" type="button"></button></li>
                <li><p class="ola">Olá  <?php if (isset($username)) echo $username; ?></p></li>
                <li><button class="favorite" type="button"></button></li>
                <li><a class="logout" type="button" href="goback.php" ></a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="search-box">
            <div class="search">
                <input id="search" autocomplete="off" type="text">
                <button onclick="searchBooks()">Search</button>
            </div>
        </div>
        <h1 class="titleList">Lista de livros</h1>
        <div class="booksbox" id="books">
            
        </div>
    </main>
    <div class="uploadConteiner">
        <div class="upload" >
            <button class="closeModalUpload" onclick="closeModalUpload()" type="button">voltar</button>
            <div class="fileUpload">
                <p id="nomeArquivoSelecionado">Selecione uma imagem</p>
            </div>
            <div id="inputImagemBox">
                 <input class="imagem" type="file" name="imagem" id="imagem" style="display:none">
            </div>
            <button class="submit" onclick="salvarImagem()">Enviar</button>
        </div>
    </div>
</body>
    <script src="../js/imgUpLoad.js" ></script>
<script>
    const ul = document.createElement("ul") 
    ul.className = "booksList"

    let searshValue ;

    function searchBooks() {
        const ulList = document.querySelector(".booksList")
  
        if (searshValue === document.querySelector("#search").value) {return}
        if(ulList !== null){
            while(ulList.children.length > 0) {
                ulList.removeChild(ulList.children[0]);
            }
        }
        
        searshValue = document.querySelector("#search").value
        if(!searshValue){searshValue = "html css"}

        fetch(`https://www.googleapis.com/books/v1/volumes?q=${searshValue}`)
            .then(res=>res.json())
            .then((data)=>{
                
            data.items.map((item)=>{
                const bookAbout = {
                    title : item.volumeInfo.title,
                    authors : item.volumeInfo.authors,
                    description : item.volumeInfo.description,
                    imageLinks : item.volumeInfo.imageLinks.smallThumbnail,
                    linkGoogle : item.volumeInfo.canonicalVolumeLink,
                    categories : item.volumeInfo.categories,
                    previewLink : item.volumeInfo.previewLink,
                    publisher : item.volumeInfo.publisher,
                    publishedDate:item.volumeInfo.publishedDate
                }
                const li = document.createElement("li") 
                li.className = "booksListItem"
                li.innerHTML = `
                        <div class="book">
                            <img class="imgBook" src="${bookAbout.imageLinks}" alt="imagem do livro ${bookAbout.title}">
                            <div class="booksListItemAbout">
                                <h2 class="booksListItemTitle"> ${bookAbout.title}</h2>
                                <p class="booksListItemAuthors"> ${bookAbout.authors?bookAbout.authors:""}</p>
                                <p class="booksListItemPublishedDate">${bookAbout.publishedDate?bookAbout.publishedDate:""}</p>
                            </div>
                        </div>
                        <a class="booksListItemLinkGoogle" href="${bookAbout.linkGoogle}"target="_blank">Acessar</a>
                `
                ul.appendChild(li)
            })
        })
        document.querySelector("#books").appendChild(ul)
    }
    

  </script>
</html>