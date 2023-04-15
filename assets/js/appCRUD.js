/*jshint -W033 */
var sesion = localStorage.getItem('UserName');
var email = localStorage.getItem('correo');

const checkSesion = () => {
    if (sesion != null) {
        window.location.href = "index.php";
    }
    document.querySelector('#user').innerHTML = sesion;
}

const closeSesion = () => {
    localStorage.clear();
    //window location in php/user
    window.location.href = "logOut.php";
}

