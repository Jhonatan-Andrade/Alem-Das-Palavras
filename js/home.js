if (!localStorage.getItem("data")) {
    localStorage.setItem("data",JSON.stringify([]))
}
if (!localStorage.getItem("favorite")) {
    localStorage.setItem("favorite","[]" )
}


const ul = document.createElement("ul") 
ul.className = "booksList"
let searshValue ;
     
searchBooks()
function searchBooks() {
    const url = window.location.href.split("home.php")[0]+"book.php?id="
    const ulList = document.querySelector(".booksList")

    if (searshValue === document.querySelector("#search").value) {return}
    if(ulList !== null){
        while(ulList.children.length > 0) {
            ulList.removeChild(ulList.children[0]);
        }
    }
    searshValue = document.querySelector("#search").value
    if(!searshValue){
        
        const bookData = JSON.parse(localStorage.getItem("data"))
        if (!bookData) {return}
        

        bookData.map((book)=>{
            const li = document.createElement("li") 
            li.className = "booksListItem"
            li.innerHTML = `
                <a class="booksListItemLinkGoogle" href="${url+book.id}">
                    <div class="book">
                        <img class="imgBook" src="${book.imageLinks}" alt="imagem do livro ${book.title}">
                        <div class="booksListItemAbout">
                            <h2 class="booksListItemTitle"> ${book.title}</h2>
                            <p class="booksListItemAuthors"> ${book.authors?book.authors:""}</p>
                            <p class="booksListItemPublishedDate">${book.publishedDate?book.publishedDate:""}</p>
                        </div>
                    </div>
                </a>
            `
            ul.appendChild(li)
        })
        document.querySelector("#books").appendChild(ul)
        return
    }
    try {
        fetch(`https://www.googleapis.com/books/v1/volumes?q=${searshValue}`)
        .then(res=>res.json())
        .then((data)=>{
            if(data.totalItems === 0){
                ulList.innerHTML=`<h4>Ops! Parece que sua busca </h4><h5>${searshValue}</h5><h4>não retornou resultados.</h4>`
                return
            }
            
            const bookList = []
            data.items.map((item)=>{
                const bookAbout = {
                    id:item.id,
                    title : item.volumeInfo.title,
                    authors : item.volumeInfo.authors,
                    imageLinks : item.volumeInfo.imageLinks.smallThumbnail,
                    publishedDate:item.volumeInfo.publishedDate
                }
                bookList.push(bookAbout)
                const li = document.createElement("li") 
                li.className = "booksListItem"
                li.innerHTML = `
                    <a class="booksListItemLinkGoogle" href="${url+bookAbout.id}">
                        <div class="book">
                            <img class="imgBook" src="${bookAbout.imageLinks}" alt="imagem do livro ${bookAbout.title}">
                            <div class="booksListItemAbout">
                                <h2 class="booksListItemTitle"> ${bookAbout.title}</h2>
                                <p class="booksListItemAuthors"> ${bookAbout.authors?bookAbout.authors:""}</p>
                                <p class="booksListItemPublishedDate">${bookAbout.publishedDate?bookAbout.publishedDate:""}</p>
                            </div>
                        </div>
                    </a>
                `
                ul.appendChild(li)
            })
            localStorage.setItem("data",JSON.stringify(bookList))
        })
        document.querySelector("#books").appendChild(ul)     
    } catch (error) {
        console.log(error);
    }
}
    