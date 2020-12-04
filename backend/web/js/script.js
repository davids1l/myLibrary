function mostrarImagem() {
   document.getElementById("image").src = document.getElementById("files").value;
}

document.getElementById("files").addEventListener('change', mostrarImagem);
document.getElementById("files").addEventListener('paste', mostrarImagem);
document.getElementById("files").addEventListener('click', mostrarImagem);
