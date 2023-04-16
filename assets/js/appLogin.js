/*jshint -W033 */
var sesion = localStorage.getItem('UserName');
var image;

const checkSesion = () => {
    if (sesion != null) {
        window.location.href = "index.php";
    }
}

const checkSesionUpdate = () => {
    if (sesion != null) {
        document.querySelector('#user').innerHTML = sesion;
    }else{
        document.querySelector('#user').innerHTML = 'Invitado';
    }
}

const closeSesion = () => {
    localStorage.clear();
    //window location in php/user
    window.location.href = "logOut.php";
}

const iniciar_sesion = () => {
    localStorage.clear();
    //window location in php/user
    window.location.href = "logOut.php";
}

const no_logueado = async () => {
    Swal.fire({
        icon: "error",
        title: "ERROR.",
        text: "You have to log in to access this page",
        footer: "Web Comics"
    })
    setTimeout(() => {
        window.location.reload();
        localStorage.setItem('UserName', 'Invitado');
    }, 2000);
}

const crear_usuario = async () => {

    var email = document.querySelector("#correo").value;
    var password = document.querySelector("#password").value;
    var repassword = document.querySelector("#repassword").value;
    var name = document.querySelector("#name").value;
    //checkbox
    var check = document.querySelector("#checkbox");

    if (email.trim() === '' | password.trim() === '' | name.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "You have to fill all the camps",
            footer: "Web Comics"
        })
        return;
    }

    if (!check.checked) {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "You have to accept the terms and conditions",
            footer: "Web Comics"
        })
        return;
    }

    if (!validateEmail(email)) {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "The email introduce is not valite, please, enter a correct email.",
            footer: "Web Comics"
        })
        return;
    }

    if (!validatePassword(password)) {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "You have to introduce a valid password (upperCase,lowerCase,numer and min 8 characters)",
            footer: "Web Comics"
        })
        return;
    }

    if (!validateUserNAme(name)) {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "You have introduce a valid Name",
            footer: "Web Comics"
        })
        return;
    }

    if (password != repassword) {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "The password doesn't match",
            footer: "Web Comics"
        })

        document.querySelector("#password").style.border = "1px solid red";
        document.querySelector("#repassword").style.border = "1px solid red";
        document.querySelector("#password").value = "";
        document.querySelector("#repassword").value = "";
        return;
    }

    //insert to data base in case of everything go correct.
    const data = new FormData();
    data.append("email", email);
    data.append("pass", password);
    data.append("userName", name);
    //if image is unvaliable, send 0
    if (image == null) {
        data.append("userPicture", "");
    } else {
        data.append("userPicture", image);
    }

    //pass data to php file
    var respond = await fetch("php/apis/crear_usuario.php", {
        method: 'POST',
        body: data
    });

    var result = await respond.json();

    if (result.success == true) {
        Swal.fire({
            icon: "success",
            title: "GREAT",
            text: result.message,
            footer: "Web Comics"
        })
        document.querySelector('#formInsert').reset();
        setTimeout(() => {
            window.location.href = "login.php";
        }, 2000);
    } else {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: result.message,
            footer: "Web Comics"
        })
    }
}

const login_user = async () => {
    var acceso = document.querySelector("#acceso").value;
    var password = document.querySelector('#password_user').value;
    // var repassword = document.querySelector('#repassword_user').value;
    if (acceso.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "You have to fill the email",
            footer: "Web Comics"
        })
        document.querySelector("#acceso").style.border = "1px solid red";
        document.querySelector("#correo").value = acceso;
        return;
    }

    if (password.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "You have to fill the password",
            footer: "Web Comics"
        })
        document.querySelector("#password_user").style.border = "1px solid red";
        document.querySelector("#password_user").value = "";
        return;
    }
    //insert to data base in case of everything go correct.
    const data = new FormData();
    data.append('acceso', acceso);
    data.append('pass', password);

    //pass data to php file
    var respond = await fetch("php/apis/login_user.php", {
        method: 'POST',
        body: data
    });

    var result = await respond.json();

    if (result.success == true) {
        Swal.fire({
            icon: "success",
            title: "GREAT",
            text: result.message,
            footer: "Web Comics"
        })
        document.querySelector('#formIniciar').reset();
        localStorage.setItem('UserName', result.userName);

        setTimeout(() => {
            window.location.href = "index.php";
        }, 2000);
    } else {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: result.message,
            footer: "Web Comics"
        })
        document.querySelector("#acceso").value = "";
        document.querySelector("#password_user").value = "";
        document.querySelector("#acceso").style.border = "1px solid red";
    }
}

const guest_User = async () => {
    //pass data to php file
    var respond = await fetch("php/apis/guest_user.php", {
        method: 'POST'
    });

    var result = await respond.json();

    if (result.success == true) {
        Swal.fire({
            icon: "success",
            title: "GREAT",
            text: result.message,
            footer: "Web Comics"
        })
        localStorage.setItem('UserName', 'Invitado');
        setTimeout(() => {
            window.location.href = "index.php";
        }, 2000);
    } else {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: result.message,
            footer: "Web Comics"
        })
    }
}

const actualizar_usuario = async () => {
    var email = document.querySelector("#correo").value;
    var password = document.querySelector("#password").value;
    var repassword = document.querySelector("#repassword").value;
    var name = document.querySelector("#name").value;
    var nameUSer = document.querySelector("#nameUser").value;
    var lastNameUSer = document.querySelector("#lastnameUser").value;
    var textArea = document.querySelector("#field").value;

    if (password.trim() === '' | repassword.trim() === '' | name.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "You have to fill all the camps",
            footer: "Web Comics"
        })
        return;
    }

    if (!validatePassword(password)) {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "You have to introduce a valid password (upperCase,lowerCase,numer and min 8 characters)",
            footer: "Web Comics"
        })
        return;
    }

    if (!validateUserNAme(name)) {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "You have introduce a valid Name",
            footer: "Web Comics"
        })
        return;
    }

    if (password != repassword) {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "The password doesn't match",
            footer: "Web Comics"
        })

        document.querySelector("#password").style.border = "1px solid red";
        document.querySelector("#repassword").style.border = "1px solid red";
        document.querySelector("#password").value = "";
        document.querySelector("#repassword").value = "";
        return;
    }

    //insert to data base in case of everything go correct.
    const data = new FormData();
    data.append('email', email);
    data.append("pass", password);
    data.append("userName", name);
    data.append("field", textArea);
    data.append("nameUser", nameUSer);
    data.append("lastnameUser", lastNameUSer);
    //if image is unvaliable, send 0
    if (image == null) {
        data.append("userPicture", "");
    } else {
        data.append("userPicture", image);
    }

    //pass data to php file
    var respond = await fetch("php/apis/actualizar_usuario.php", {
        method: 'POST',
        body: data
    });

    var result = await respond.json();

    if (result.success == true) {
        Swal.fire({
            icon: "success",
            title: "GREAT",
            text: result.message,
            footer: "Web Comics"
        })
        document.querySelector('#formUpdate').reset();
        localStorage.setItem('UserName', name);
        setTimeout(() => {
            window.location.href = "modificar_perfil.php";
        }, 2000);
    } else {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: result.message,
            footer: "Web Comics"
        })
    }
}

const modificar_usuario_administrador = async () => {
    var email = document.querySelector("#email_usuario").value;
    var nombre_cuenta = document.querySelector("#nombre_cuenta").value;
    var nombre_usuario = document.querySelector("#nombre_usuario").value;
    var apellido_usuario = document.querySelector("#apellido_usuario").value;
    var id_usuario = document.querySelector("#id_usuario").value;

    if (email.trim() === '' | nombre_cuenta.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "ERROR. Debes de rellenar tanto el nombre de usuario como el mail",
            footer: "Web Comics"
        })
        return;
    }

    if (!validateUserNAme(nombre_cuenta)) {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "ERROR. Nombre no valido, introduce otro nombre",
            footer: "Web Comics"
        })
        return;
    }

    if (!validateUserNAme(nombre_usuario)) {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "ERROR. Nombre de usuario no valido, introduce otro nombre",
            footer: "Web Comics"
        })
        return;
    }

    if (!validateUserNAme(apellido_usuario)) {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "ERROR. Introduce un apellido correcto.",
            footer: "Web Comics"
        })
        return;
    }

    //insert to data base in case of everything go correct.
    const data = new FormData();
    data.append('email', email);
    data.append("nombre_cuenta", nombre_cuenta);
    data.append("nombre_usuario", nombre_usuario);
    data.append("apellido_usuario", apellido_usuario);
    data.append("id_usuario", id_usuario);

    //if image is unvaliable, send 0
    if (image == null) {
        data.append("userPicture", "");
    } else {
        data.append("userPicture", image);
    }

    //pass data to php file
    var respond = await fetch("php/apis/modificar_usuario_administrador.php", {
        method: 'POST',
        body: data
    });

    var result = await respond.json();

    if (result.success == true) {
        Swal.fire({
            icon: "success",
            title: "GREAT",
            text: result.message,
            footer: "Web Comics"
        })
        document.querySelector('#formUpdate').reset();
        setTimeout(() => {
            window.location.href = "admin_panel_usuario.php";
        }, 2000);
    } else {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: result.message,
            footer: "Web Comics"
        })
    }
}

const desactivar_cuenta = async () => {
    var email = document.querySelector("#email_usuario").value;
    const data = new FormData();
    data.append('email', email);
    //pass data to php file
    var respond = await fetch("php/apis/desactivar_cuenta.php", {
        method: 'POST',
        body: data
    });

    var result = await respond.json();

    if (result.success == true) {
        Swal.fire({
            icon: "success",
            title: "GREAT",
            text: result.message,
            footer: "Web Comics"
        })
        setTimeout(() => {
            window.location.href = "logOut.php";
        }, 2000);
    } else {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: result.message,
            footer: "Web Comics"
        })
    }
}

const desautorizar_usuario = async (estado, email) => {
    const data = new FormData();
    data.append('email', email);
    data.append('estado', estado);
    console.log(estado);
    //pass data to php file
    var respond = await fetch("php/apis/desautorizar_usuario.php", {
        method: 'POST',
        body: data
    });

    var result = await respond.json();

    if (result.success == true) {
        Swal.fire({
            icon: "success",
            title: "GREAT",
            text: result.message,
            footer: "Web Comics"
        })
        setTimeout(() => {
            window.location.reload();
        }, 2000);
    } else {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: result.message,
            footer: "Web Comics"
        })
    }
}

const cambiar_privacidad_usuario = async (estado) => {
    var email = document.querySelector("#email_usuario").value;
    const data = new FormData();
    data.append('email', email);
    if (estado == true) {
        data.append('estado', true)
    }
    else if (estado == false) {
        data.append('estado', false)
    }
    //pass data to php file
    var respond = await fetch("php/apis/cambiar_privacidad.php", {
        method: 'POST',
        body: data
    });

    var result = await respond.json();

    if (result.success == true) {
        Swal.fire({
            icon: "success",
            title: "GREAT",
            text: result.message,
            footer: "Web Comics"
        })
        setTimeout(() => {
            window.location.reload();
        }, 2000);
    } else {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: result.message,
            footer: "Web Comics"
        })
    }
}

const mandar_ticket = async () => {
    var id = document.querySelector("#id_user_ticket").value;
    var asunto = document.querySelector("#asunto_usuario").value;
    var mensaje = document.querySelector("#mensaje_usuario").value;


    if (asunto.trim() === '' | mensaje.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "You have to fill all the camps",
            footer: "Web Comics"
        })
        return;
    }

    //insert to data base in case of everything go correct.
    const data = new FormData();
    data.append('idUser', id);
    data.append("asunto_ticket", asunto);
    data.append("mensaje", mensaje);

    //pass data to php file
    var respond = await fetch("php/apis/new_ticket.php", {
        method: 'POST',
        body: data
    });

    var result = await respond.json();

    if (result.success == true) {
        Swal.fire({
            icon: "success",
            title: "GREAT",
            text: result.message,
            footer: "Web Comics"
        })
        document.querySelector('#form_ticket').reset();
        setTimeout(() => {
            window.location.reload();
        }, 2000);
    } else {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: result.message,
            footer: "Web Comics"
        })
    }
}

const mandar_mensaje = async () => {
    var id_usuario_destinatario = document.querySelector("#id_usuario_destinatario").value;
    var id_usuario_remitente = document.querySelector("#id_usuario_remitente").value;
    var mensaje = document.querySelector("#mensaje_usuario_enviar").value;



    if (mensaje.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "You have to fill all the camps",
            footer: "Web Comics"
        })
        return;
    }

    //insert to data base in case of everything go correct.
    const data = new FormData();
    data.append('id_usuario_destinatario', id_usuario_destinatario);
    data.append("id_usuario_remitente", id_usuario_remitente);
    data.append("mensaje", mensaje);

    //pass data to php file
    var respond = await fetch("php/apis/new_mensaje.php", {
        method: 'POST',
        body: data
    });

    var result = await respond.json();

    if (result.success == true) {
        document.querySelector('#form_ticket').reset();
        setTimeout(() => {
            window.location.reload();
        }, 2000);
    } else {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: result.message,
            footer: "Web Comics"
        })
    }
}

const modificar_estado_mensaje = async (id_conversacion) => {

    //insert to data base in case of everything go correct.
    const data = new FormData();
    data.append('id_conversacion', id_conversacion);
    console.log(id_conversacion)
    //pass data to php file
    var respond = await fetch("php/apis/cambiar_estado_mensajes.php", {
        method: 'POST',
        body: data
    });

    var result = await respond.json();

    if (result.success == false) {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: result.message,
            footer: "Web Comics"
        })
        document.querySelector('#form_lista').reset();
        setTimeout(() => {
            window.location.reload();
        }, 2000);
    }
}

const responder_ticket = async (ticket_id) => {
    var id_ticket = document.querySelector("#ticket_id_" + ticket_id).value;
    var id_usuario = document.querySelector("#user_id_" + ticket_id).value;
    var estado = document.querySelector("#estado_" + ticket_id).value;
    var respuesta = document.querySelector("#respuesta_" + ticket_id).value;

    if (respuesta.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "You have to fill all the camps",
            footer: "Web Comics"
        })
        return;
    }

    //insert to data base in case of everything go correct.
    const data = new FormData();
    data.append('ticket_id', id_ticket);
    data.append("user_id", id_usuario);
    data.append("estado", estado);
    data.append("mensaje", respuesta);

    //pass data to php file
    var respond = await fetch("php/apis/respon_ticket.php", {
        method: 'POST',
        body: data
    });

    var result = await respond.json();

    if (result.success == true) {
        Swal.fire({
            icon: "success",
            title: "GREAT",
            text: result.message,
            footer: "Web Comics"
        })
        document.querySelector('#form_ticket_respond');
        setTimeout(() => {
            window.location.reload();
        }, 2000);
    } else {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: result.message,
            footer: "Web Comics"
        })
    }
}

const nueva_opinion = async () => {
    var id_user = document.querySelector("#id_user_opinion").value;
    var id_comic = document.querySelector("#id_comic").value;
    var opinion = document.querySelector("#opinion").value;
    const puntuacion = document.querySelector('input[name="rating"]:checked').value;

    if (opinion.trim() === '' | puntuacion.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "You have to fill all the camps",
            footer: "Web Comics"
        })
        return;
    }

    //insert to data base in case of everything go correct.
    const data = new FormData();
    data.append('idUser', id_user);
    data.append("idComic", id_comic);
    data.append("opinion", opinion);
    data.append("puntuacion", puntuacion);

    //pass data to php file
    var respond = await fetch("php/apis/nueva_opinion.php", {
        method: 'POST',
        body: data
    });

    var result = await respond.json();

    if (result.success == true) {
        Swal.fire({
            icon: "success",
            title: "GREAT",
            text: result.message,
            footer: "Web Comics"
        })
        document.querySelector('#form_opinion').reset();
        setTimeout(() => {
            window.location.reload();
        }, 2000);
    }
    else {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: result.message,
            footer: "Web Comics"
        })
        setTimeout(() => {
            window.location.reload();
        }, 2000);
    }
}

const nueva_opinion_pagina = async () => {
    var opinion = document.querySelector("#opinion").value;
    var id_user = document.querySelector("#id_user_opinion").value;

    console.log(id_user)

    if (opinion.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "You have to fill all the camps",
            footer: "Web Comics"
        })
        return;
    }

    //insert to data base in case of everything go correct.
    const data = new FormData();
    data.append('idUser', id_user);
    data.append("opinion", opinion);

    //pass data to php file
    var respond = await fetch("php/apis/nueva_opinion_pagina.php", {
        method: 'POST',
        body: data
    });

    var result = await respond.json();

    if (result.success == true) {
        Swal.fire({
            icon: "success",
            title: "GREAT",
            text: result.message,
            footer: "Web Comics"
        })
        document.querySelector('#form_opinion').reset();
        setTimeout(() => {
            window.location.reload();
        }, 2000);
    }
    else {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: result.message,
            footer: "Web Comics"
        })
        setTimeout(() => {
            window.location.reload();
        }, 2000);
    }
}

const nueva_lista = async () => {
    var nombre_lista = document.querySelector("#nombre_lista").value;
    var id_user = document.querySelector("#id_user").value;


    if (nombre_lista.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "You have to fill all the camps",
            footer: "Web Comics"
        })
        return;
    }

    //insert to data base in case of everything go correct.
    const data = new FormData();
    data.append('nombre_lista', nombre_lista);
    data.append("id_user", id_user);

    //pass data to php file
    var respond = await fetch("php/apis/new_lista.php", {
        method: 'POST',
        body: data
    });

    var result = await respond.json();

    if (result.success == true) {
        Swal.fire({
            icon: "success",
            title: "GREAT",
            text: result.message,
            footer: "Web Comics"
        })
        document.querySelector('#form_lista').reset();
        setTimeout(() => {
            window.location.reload();
        }, 2000);
    } else {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: result.message,
            footer: "Web Comics"
        })
    }
}

const modificar_lista = async () => {
    var nombre_lista = document.querySelector("#nombre_lista_modificar").value;
    var id_lista = document.querySelector("#id_lista_modificar").value;


    if (nombre_lista.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "You have to fill all the camps",
            footer: "Web Comics"
        })
        return;
    }

    //insert to data base in case of everything go correct.
    const data = new FormData();
    data.append('nombre_lista', nombre_lista);
    data.append("id_lista", id_lista);
    //pass data to php file
    var respond = await fetch("php/apis/modificar_lista.php", {
        method: 'POST',
        body: data
    });

    var result = await respond.json();

    if (result.success == true) {
        Swal.fire({
            icon: "success",
            title: "GREAT",
            text: result.message,
            footer: "Web Comics"
        })
        document.querySelector('#form_lista').reset();
        setTimeout(() => {
            window.location.reload();
        }, 2000);
    } else {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: result.message,
            footer: "Web Comics"
        })
    }
}

const guardar_comic = async (id_comic, callback) => {
    const id_user = document.querySelector("#id_user").value;

    const data = new FormData();
    data.append("id_comic", id_comic);
    data.append("id_user", id_user);

    const respond = await fetch("php/apis/guardar_comic.php", {
        method: "POST",
        body: data,
    });

    const result = await respond.json();

    if (result.success == false) {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: result.message,
            footer: "Web Comics"
        })
        setTimeout(() => {
            window.location.reload();
        }, 2000);
    }

    if (callback) {
        callback();
    }

};

const quitar_comic = async (id_comic, callback) => {
    const id_user = document.querySelector("#id_user").value;

    const data = new FormData();
    data.append("id_comic", id_comic);
    data.append("id_user", id_user);

    const respond = await fetch("php/apis/quitar_comic.php", {
        method: "POST",
        body: data,
    });

    const result = await respond.json();

    if (result.success == false) {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: result.message,
            footer: "Web Comics"
        })
        setTimeout(() => {
            window.location.reload();
        }, 2000);
    }

    if (callback) {
        callback();
    }
};


const guardar_comic_lista = async (id_comic, id_lista, callback) => {
    const data = new FormData();
    data.append("id_comic", id_comic);
    data.append("id_lista", id_lista);

    const respond = await fetch("php/apis/guardar_comic_lista.php", {
        method: "POST",
        body: data,
    });

    const result = await respond.json();

    if (result.success == false) {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: result.message,
            footer: "Web Comics"
        })
        setTimeout(() => {
            window.location.reload();
        }, 2000);
    }

    if (callback) {
        callback();
    }
};

const quitar_comic_lista = async (id_comic, id_lista, callback) => {

    const data = new FormData();
    data.append("id_comic", id_comic);
    data.append("id_lista", id_lista);

    const respond = await fetch("php/apis/quitar_comic_lista.php", {
        method: "POST",
        body: data,
    });

    const result = await respond.json();

    if (result.success == false) {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: result.message,
            footer: "Web Comics"
        })
        setTimeout(() => {
            window.location.reload();
        }, 2000);
    }

    if (callback) {
        callback();
    }
};


const eliminar_lista = async (id_lista, id_user) => {
    const data = new FormData();
    data.append("id_lista", id_lista);
    data.append("id_user", id_user);

    const respond = await fetch("php/apis/eliminar_lista.php", {
        method: "POST",
        body: data,
    });

    const result = await respond.json();

    if (result.success == true) {
        Swal.fire({
            icon: "success",
            title: "GREAT",
            text: result.message,
            footer: "Web Comics"
        })
        document.querySelector('#form_lista').reset();
        setTimeout(() => {
            window.location.reload();
        }, 2000);
    } else {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: result.message,
            footer: "Web Comics"
        })
        setTimeout(() => {
            window.location.reload();
        }, 2000);
    }
}

const eliminar_usuario = async (id_user, emailUser) => {
    const data = new FormData();
    data.append("id_user", id_user);
    data.append("emailUser", emailUser);

    const respond = await fetch("php/apis/eliminar_usuario.php", {
        method: "POST",
        body: data,
    });

    const result = await respond.json();

    if (result.success == true) {
        Swal.fire({
            icon: "success",
            title: "GREAT",
            text: result.message,
            footer: "Web Comics"
        })
        document.querySelector('#form_lista').reset();
        setTimeout(() => {
            window.location.reload();
        }, 2000);
    } else {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: result.message,
            footer: "Web Comics"
        })
        setTimeout(() => {
            window.location.reload();
        }, 2000);
    }
}

const aceptar_solicitud = (id_solicitante, id_destinatario) => {
    const data = new FormData();
    data.append("id_solicitante", id_solicitante);
    data.append("id_destinatario", id_destinatario);

    fetch("php/apis/aceptar_solicitud.php", {
        method: "POST",
        body: data,
    })
        .then((response) => response.json())
        .then((result) => {
            if (result.success == true) {
                Swal.fire({
                    icon: "success",
                    title: "GREAT",
                    text: result.message,
                    footer: "Web Comics"
                })
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                Swal.fire({
                    icon: "error",
                    title: "ERROR.",
                    text: result.message,
                    footer: "Web Comics"
                })
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            }
        })
        .catch((error) => {
            console.error("Error:", error);
        });

}

const enviar_solicitud = (id_solicitante, id_destinatario) => {
    const data = new FormData();
    data.append("id_solicitante", id_solicitante);
    data.append("id_destinatario", id_destinatario);

    fetch("php/apis/enviar_solicitud.php", {
        method: "POST",
        body: data,
    })
        .then((response) => response.json())
        .then((result) => {
            if (result.success == true) {
                Swal.fire({
                    icon: "success",
                    title: "GREAT",
                    text: result.message,
                    footer: "Web Comics"
                })
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                Swal.fire({
                    icon: "error",
                    title: "ERROR.",
                    text: result.message,
                    footer: "Web Comics"
                })
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            }
        })
        .catch((error) => {
            console.error("Error:", error);
        });

}

const rechazar_solicitud = (id_solicitante, id_destinatario) => {
    const data = new FormData();
    data.append("id_solicitante", id_solicitante);
    data.append("id_destinatario", id_destinatario);

    fetch("php/apis/rechazar_solicitud.php", {
        method: "POST",
        body: data,
    })
        .then((response) => response.json())
        .then((result) => {
            if (result.success == true) {
                Swal.fire({
                    icon: "success",
                    title: "GREAT",
                    text: result.message,
                    footer: "Web Comics"
                })
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                Swal.fire({
                    icon: "error",
                    title: "ERROR.",
                    text: result.message,
                    footer: "Web Comics"
                })
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            }
        })
        .catch((error) => {
            console.error("Error:", error);
        });
}

const cancelar_solicitud = (id_solicitante, id_destinatario) => {
    const data = new FormData();
    data.append("id_solicitante", id_solicitante);
    data.append("id_destinatario", id_destinatario);

    fetch("php/apis/cancelar_solicitud.php", {
        method: "POST",
        body: data,
    })
        .then((response) => response.json())
        .then((result) => {
            if (result.success == true) {
                Swal.fire({
                    icon: "success",
                    title: "GREAT",
                    text: result.message,
                    footer: "Web Comics"
                })
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                Swal.fire({
                    icon: "error",
                    title: "ERROR.",
                    text: result.message,
                    footer: "Web Comics"
                })
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            }
        })
        .catch((error) => {
            console.error("Error:", error);
        });
}

const eliminar_amigo = (id_solicitante, id_destinatario) => {
    const data = new FormData();
    data.append("id_solicitante", id_solicitante);
    data.append("id_destinatario", id_destinatario);

    fetch("php/apis/eliminar_amigo.php", {
        method: "POST",
        body: data,
    })
        .then((response) => response.json())
        .then((result) => {
            if (result.success == true) {
                Swal.fire({
                    icon: "success",
                    title: "GREAT",
                    text: result.message,
                    footer: "Web Comics"
                })
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                Swal.fire({
                    icon: "error",
                    title: "ERROR.",
                    text: result.message,
                    footer: "Web Comics"
                })
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            }
        })
        .catch((error) => {
            console.error("Error:", error);
        });
}

const bloquear_usuario = (id_solicitante, id_destinatario) => {
    const data = new FormData();
    data.append("id_solicitante", id_solicitante);
    data.append("id_destinatario", id_destinatario);

    fetch("php/apis/bloquear_user.php", {
        method: "POST",
        body: data,
    })
        .then((response) => response.json())
        .then((result) => {
            if (result.success == true) {
                Swal.fire({
                    icon: "success",
                    title: "GREAT",
                    text: result.message,
                    footer: "Web Comics"
                })
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                Swal.fire({
                    icon: "error",
                    title: "ERROR.",
                    text: result.message,
                    footer: "Web Comics"
                })
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            }
        })
        .catch((error) => {
            console.error("Error:", error);
        });
}

const desbloquear_usuario = (id_solicitante, id_destinatario) => {
    const data = new FormData();
    data.append("id_solicitante", id_solicitante);
    data.append("id_destinatario", id_destinatario);

    fetch("php/apis/desbloquear_user.php", {
        method: "POST",
        body: data,
    })
        .then((response) => response.json())
        .then((result) => {
            if (result.success == true) {
                Swal.fire({
                    icon: "success",
                    title: "GREAT",
                    text: result.message,
                    footer: "Web Comics"
                })
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                Swal.fire({
                    icon: "error",
                    title: "ERROR.",
                    text: result.message,
                    footer: "Web Comics"
                })
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            }
        })
        .catch((error) => {
            console.error("Error:", error);
        });
}




// const eliminar_usuario = async () => {
//     var id = document.querySelector("#IDuser").value;
//     const data = new FormData();
//     data.append("id", id);
//     //pass data to php file
//     var respond = await fetch("php/apis/eliminar_usuario.php", {
//         method: 'POST',
//         body: data
//     });

//     var result = await respond.json();

//     if (result.success == true) {
//         Swal.fire({
//             icon: "success",
//             title: "GREAT",
//             text: result.message,
//             footer: "Web Comics"
//         })
//         document.querySelector('#formUpdate').reset();
//         localStorage.setItem('UserName', name);
//         setTimeout(() => {
//             window.location.href = "admin_panel_usuario.php";
//         }, 2000);
//     } else {
//         Swal.fire({
//             icon: "error",
//             title: "ERROR.",
//             text: result.message,
//             footer: "Web Comics"
//         })
//     }
// }



