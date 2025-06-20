
window.onload = function() {
  const imageData = localStorage.getItem('imgUser');
  if (imageData) {
    exibirImagem(imageData);
  }
};


function salvarImagem() {
  const fileInput = document.getElementById('imagem');
  const file = fileInput.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      const imageData = e.target.result; 
      localStorage.setItem('imgUser', imageData);
      exibirImagem(imageData);
    }
    reader.readAsDataURL(file);
  }
  document.querySelector('.uploadConteiner').style="display:none"
}
function exibirImagem(imageData) {
  const imagemExibida = document.querySelector('.user');
  imagemExibida.style= `background-image: url(${imageData});`;
}

document.querySelector(".fileUpload").addEventListener("click",(e)=>{
  const img = document.querySelector(".imagem")
  img.click();
})

const inputImg = document.querySelector(".imagem")
inputImg.addEventListener('change', () => {
    if (inputImg.files.length !== 0) {
      if (inputImg.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
          const imageData = e.target.result; 
          document.querySelector(".fileUpload").style=`
            background-image: url(${imageData});
            border: solid;
          `
        }
        reader.readAsDataURL(inputImg.files[0]);
      }
      nomeArquivoSelecionado.textContent=""
    }
});



function logout(){
    localStorage.setItem("nav","sign-in")
    window.location.href = "user.php"
}
function openModalUpload(){

    document.querySelector('.uploadConteiner').style.display = "flex"
}
function closeModalUpload(){

    document.querySelector('.uploadConteiner').style.display = "none"
}