const signIn = document.querySelector(".sign-in-form")
const signUp = document.querySelector(".sign-up-form")

if (!localStorage.getItem("nav")) {
    localStorage.setItem("nav","sign-in")
    signIn.style.display = "flex"
    signUp.style.display = "none"  
}else{
    const page = localStorage.getItem("nav")
    if (page === "sign-up") {
        signIn.style.display = "none"
        signUp.style.display = "flex"
    }else if (page === "sign-in"){
        signIn.style.display = "flex"
        signUp.style.display = "none"  
    }
}

function navigate() {
    const page = localStorage.getItem("nav")
    if (page === "sign-in") {
        signIn.style.display = "none"
        signUp.style.display = "flex"
        localStorage.setItem("nav","sign-up")
    }else if (page === "sign-up"){
        signIn.style.display = "flex"
        signUp.style.display = "none"   
        localStorage.setItem("nav","sign-in")
    }

}
const submitButton = document.querySelectorAll(".navButton")
submitButton[0].addEventListener("click",(e)=>{
    e.preventDefault()
})
submitButton[1].addEventListener("click",(e)=>{
    e.preventDefault()
})

