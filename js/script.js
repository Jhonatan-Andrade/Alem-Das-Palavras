
document.querySelector(".goToSignUp").addEventListener("click", function() {
    document.querySelector(".containerSignIn").style.display = "none";
    document.querySelector(".containerSignUp").style.display = "flex";
})
document.querySelector(".goToSignIn").addEventListener("click", function() {
    document.querySelector(".containerSignIn").style.display = "flex";
    document.querySelector(".containerSignUp").style.display = "none";
})
