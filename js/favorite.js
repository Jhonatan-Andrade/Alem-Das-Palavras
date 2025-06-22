
const ul = document.createElement("ul") 
ul.className = "booksList"
     
const url = window.location.href.split("favorite.php")[0]+"book.php?id="
const ulList = document.querySelector(".booksList")
if(ulList !== null){
    while(ulList.children.length > 0) {
        ulList.removeChild(ulList.children[0]);
    }
}

if (JSON.parse(localStorage.getItem("favorite")).length === 0 ) {
    document.querySelector("#books").innerHTML = `
    <p>Sua lista de favoritos está vazia. Que tal adicionar alguns livros?</p>
    <a href="./home.php">Biblioteca</a>
    `
}

const favorite = JSON.parse(localStorage.getItem("favorite"))
favorite.map((book)=>{
    console.log(book);
    
    const li = document.createElement("li") 
    li.className = "booksListItem"
    li.innerHTML = `
        <button class="deleteFavorite" onclick="deleteFavorite('${book.id}')" type="button"></button>
        <a class="booksListItemLinkGoogle" href="${url+book.id}">
            <div class="book">
                <img class="imgBook" src="${book.image}" alt="imagem do livro ${book.title}">
                <div class="booksListItemAbout">
                    <h2 class="booksListItemTitle"> ${book.title}</h2>
                    <div class="booksListItemDescription">
                        <p>${book.description?book.description:""}</p>
                    </div>
                </div>
            </div>
        </a>
    `
    ul.appendChild(li)
})
document.querySelector("#books").appendChild(ul)
    
function deleteFavorite(id){
    const deleteFavoriteData = JSON.parse(localStorage.getItem("favorite"))
    let arr = deleteFavoriteData.filter(item => item.id !== id)
    localStorage.setItem("favorite",JSON.stringify(arr))
    window.location.href = "./favorite.php"
}

    