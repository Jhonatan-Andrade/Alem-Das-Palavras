        function showBook(book){
            const boolView = `
                <div class="bookBox">
                    <div class="bookImgAndLinks">
                        <img src="${book.image}" alt="${book.title}" >
                        <div class="bookDownload">
                            ${book.pdf?`<a href="${book.pdf}">PDF</a>`:""}
                            ${book.epub?`<a href="${book.epub}">EPUB</a>`:""}
                        </div> 
                        <div class="bookFavoriteAndStore">
                            ${book.buyLink?`<a class="storeButton" href="${book.buyLink}" target="_blank">Loja Google</a>`:""}
                            <button class="addFavorite" onClick="addFavorite()"></button>
                        </div> 
                    </div>
                    <div class="bookAbout">
                        <div class="bookInfo">
                            <p>Titulo : ${book.title}</p>
                            ${book.authors?`<p>Autor : ${book.authors}</p>`:``}
                            ${book.pageNumber?`<p>Nº de Páginas : ${book.pageNumber}</p>`:``}
                        </div>
                        ${book.description?`
                            <p>Descrição</p>
                            <div class="bookDescription">
                                <p>${book.description}</p>
                            </div>
                        `:``}
                    </div>                
                </div>
            `
            document.querySelector(".bookConteiner").innerHTML = boolView;
        }
        
        const id = window.location.href.split("?id=")[1];
        const url = `https://www.googleapis.com/books/v1/volumes/${id}`;
        let dataFavorite;
        fetch(url)
        .then(res=>res.json())
        .then((data)=>{
            const book = {
                id:data.id,
                title:data.volumeInfo.title,
                description:data.volumeInfo.description,
                authors:data.volumeInfo.authors,
                pageNumber:data.volumeInfo.printedPageCount,
                image:data.volumeInfo.imageLinks.thumbnail,
                epub:data.accessInfo.epub.acsTokenLink,
                pdf:data.accessInfo.pdf.acsTokenLink,
                buyLink:data.saleInfo.buyLink
            }
            dataFavorite = book
            showBook(book)
        })

        function addFavorite(){
            const favorite = JSON.parse(localStorage.getItem("favorite"))
            let arr = favorite.filter((i)=>i.id === dataFavorite.id)
            favorite.push(dataFavorite)
            if (arr.length !== 0) {
                alert("Você já favoritou este item")
                return
            }
            localStorage.setItem("favorite",JSON.stringify(favorite))
        }