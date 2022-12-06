
var sesion = localStorage.getItem('UserName');

const checkSesion=()=>{
    if(sesion == null){
        window.location.href="index.html";
    }
    document.querySelector('#user').innerHTML = sesion;
}

const closeSesion =()=>{
    localStorage.clear();
    window.location.href="index.html";
}