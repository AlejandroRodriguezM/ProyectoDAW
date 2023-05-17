/*jshint -W033 */
var sesion = localStorage.getItem('UserName');
var image;

const checkSesion = () => {
    if (sesion != null) {
        window.location.href = "index.php";
    }
}

const checkSesionUpdate = () => {
    // if (sesion != null) {
    //     document.querySelector('#user').innerHTML = sesion;
    // } else {
    //     document.querySelector('#user').innerHTML = 'Invitado';
    // }
}

/**
 * Cierra la sesión actual y redirige al usuario a la página de cierre de sesión.
 */
const closeSesion = () => {
    localStorage.clear();
    // Redirige a logOut.php
    window.location.href = "logOut.php";
}

/**
 * Inicia sesión y redirige al usuario a la página de cierre de sesión.
 */
const iniciar_sesion = () => {
    localStorage.clear();
    // Redirige a logOut.php
    window.location.href = "logOut.php";
}

/**
 * Muestra una notificación de error cuando un usuario no ha iniciado sesión.
 * Recarga la página después de 2 segundos y establece el nombre de usuario como "Invitado" en el almacenamiento local.
 */
const no_logueado = async () => {
    Swal.fire({
        icon: "error",
        title: "ERROR.",
        text: "You have to log in to access this page",
        footer: "Web Comics"
    });
    setTimeout(() => {
        window.location.reload();
        localStorage.setItem('UserName', 'Invitado');
    }, 2000);
}

/**
 * Crea un nuevo usuario con los datos proporcionados.
 * Valida los campos del formulario y realiza una solicitud de inserción a través de AJAX.
 * Si el usuario se crea correctamente, se muestra una notificación de éxito y se redirige a la página de inicio de sesión.
 * En caso de error, se muestra una notificación de error.
 */
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

    // Insertar en la base de datos en caso de que todo esté correcto.
    const data = new FormData();
    data.append("email", email);
    data.append("pass", password);
    data.append("userName", name);
    // Si la imagen no está disponible, se guarda una imagen predeterminada
    if (image == null) {
        data.append("userPicture", "");
    } else {
        data.append("userPicture", image);
    }

    // Enviar datos al api
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

/**
 * Realiza el inicio de sesión del usuario con los datos proporcionados.
 * Valida los campos del formulario y realiza una solicitud de inicio de sesión a través de AJAX.
 * Si el inicio de sesión es exitoso, se muestra una notificación de éxito y se redirige a la página principal.
 * En caso de error, se muestra una notificación de error.
 */
const login_user = async () => {
    var acceso = document.querySelector("#acceso").value;
    var password = document.querySelector('#password_user').value;
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
    // Insertar en la base de datos en caso de que todo esté correcto.
    const data = new FormData();
    data.append('acceso', acceso);
    data.append('pass', password);

    // Enviar datos al archivo PHP
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

/**
 * Permite a un usuario iniciar sesión como invitado.
 * Realiza una solicitud de inicio de sesión de invitado a través de AJAX.
 * Si el inicio de sesión de invitado es exitoso, se muestra una notificación de éxito y se redirige a la página principal.
 * En caso de error, se muestra una notificación de error.
 */
const guest_User = async () => {
    // Enviar datos al archivo PHP
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

/**
 * Actualiza los datos del usuario con los datos proporcionados.
 * Valida los campos del formulario y realiza una solicitud de actualización a través de AJAX.
 * Si la actualización es exitosa, se muestra una notificación de éxito y se redirige a la página de modificación de perfil.
 * En caso de error, se muestra una notificación de error.
 */
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

    // Insertar en la base de datos en caso de que todo esté correcto.
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

/**
 * Envía una solicitud para restablecer la contraseña del usuario con el correo electrónico proporcionado.
 * Realiza una solicitud de restablecimiento de contraseña a través de AJAX.
 * Si la solicitud es exitosa, se muestra una notificación de éxito y se redirige a la página de inicio de sesión.
 * En caso de error, se muestra una notificación de error.
 */
const solicitud_password = async () => {
    var email = document.querySelector("#correo").value;

    // Insertar en la base de datos en caso de que todo esté correcto.
    const data = new FormData();
    data.append('email', email);

    // Enviar datos al archivo PHP
    var respond = await fetch("php/apis/solicitar_pass.php", {
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
        document.querySelector('#form_pass_olvidada').reset();
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

/**
 * Actualiza la contraseña del usuario con el ID de activación y la nueva contraseña proporcionados.
 * Valida los campos del formulario y realiza una solicitud de actualización de contraseña a través de AJAX.
 * Si la actualización es exitosa, se muestra una notificación de éxito y se redirige a la página de inicio de sesión.
 * En caso de error, se muestra una notificación de error.
 */
const new_password = async () => {
    var id_activacion = document.querySelector("#id_activacion").value;
    var password = document.querySelector("#password_user").value;
    var repassword = document.querySelector("#repassword_user").value;

    if (password.trim() === '' | repassword.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "Debes de rellenar todos los campos",
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

    if (password != repassword) {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "La contraseña no coincide",
            footer: "Web Comics"
        })

        document.querySelector("#password_user").style.border = "1px solid red";
        document.querySelector("#repassword_user").style.border = "1px solid red";
        document.querySelector("#password_user").value = "";
        document.querySelector("#repassword_user").value = "";
        return;
    }

    // Insertar en la base de datos en caso de que todo esté correcto.
    const data = new FormData();
    data.append("pass", password);
    data.append("id_activacion", id_activacion);

    // Enviar datos al archivo PHP
    var respond = await fetch("php/apis/password_recuperada.php", {
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
        document.querySelector('#form_new_pass').reset();
        setTimeout(() => {
            window.location.href = "login.php";
        }, 10000);
    } else {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: result.message,
            footer: "Web Comics"
        })
    }
}

/**
 * Modifica los datos del usuario administrador con los datos proporcionados.
 * Valida los campos del formulario y realiza una solicitud de modificación a través de AJAX.
 * Si la modificación es exitosa, se muestra una notificación de éxito y se redirige al panel de administrador de usuarios.
 * En caso de error, se muestra una notificación de error.
 */
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

    // Insertar en la base de datos en caso de que todo esté correcto.
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

    // Enviar datos al archivo PHP
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

/**
 * Desactiva la cuenta de usuario asociada al correo electrónico proporcionado.
 * Realiza una solicitud de desactivación de cuenta a través de AJAX.
 * Si la desactivación es exitosa, se muestra una notificación de éxito y se redirige a la página de cierre de sesión.
 * En caso de error, se muestra una notificación de error.
 */
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

/**
 * Desautoriza al usuario con el correo electrónico y el estado proporcionados.
 * Realiza una solicitud de desautorización de usuario a través de AJAX.
 * Si la desautorización es exitosa, se muestra una notificación de éxito y se recarga la página.
 * En caso de error, se muestra una notificación de error.
 * @param {boolean} estado - Estado de desautorización del usuario.
 * @param {string} email - Correo electrónico del usuario.
 */
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

/**
 * Cambia el estado de privacidad del usuario asociado al correo electrónico proporcionado.
 * Realiza una solicitud de cambio de privacidad a través de AJAX.
 * Si el cambio es exitoso, se muestra una notificación de éxito y se recarga la página.
 * En caso de error, se muestra una notificación de error.
 * @param {boolean} estado - Estado de privacidad del usuario.
 */
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

/**
 * Envía un nuevo ticket al sistema con la información proporcionada.
 * Realiza una solicitud de creación de ticket a través de AJAX.
 * Si la creación es exitosa, se muestra una notificación de éxito, se reinicia el formulario y se recarga la página.
 * En caso de error, se muestra una notificación de error.
 */
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



/**
 * Envía un nuevo ticket de bloqueo al sistema con la información proporcionada.
 * Realiza una solicitud de creación de ticket a través de AJAX.
 * Si la creación es exitosa, se muestra una notificación de éxito, se reinicia el formulario y se redirige a la página de cierre de sesión.
 * En caso de error, se muestra una notificación de error.
 */
const mandar_ticket_bloqueo = async () => {
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
            window.location.href = 'logOut.php';
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

/**
 * Envía un nuevo mensaje al destinatario especificado.
 * Realiza una solicitud de envío de mensaje a través de AJAX.
 * Si el envío es exitoso, se reinicia el formulario y se recarga la página.
 * En caso de error, se muestra una notificación de error.
 */
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

/**
 * Envía una nueva denuncia al sistema con la información proporcionada.
 * Realiza una solicitud de creación de denuncia a través de AJAX.
 * Si la creación es exitosa, se muestra una notificación de éxito y se recarga la página.
 * En caso de error, se muestra una notificación de error y se recarga la página.
 */
const mandar_denuncia = async () => {
    var id_usuario_denunciante = document.querySelector("#id_usuario_denunciante").value;
    var id_usuario_denunciado = document.querySelector("#id_usuario_denunciado").value;
    var mensaje = document.querySelector("#contexto_denuncia_usuario").value;
    var motivoDenuncia = document.querySelector("#motivo_denuncia").value;

    if (mensaje.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "Tienes que darle contexto",
            footer: "Web Comics"
        })
        return;
    }
    if (motivoDenuncia.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "Tienes que añadir un motivo",
            footer: "Web Comics"
        })
        return;
    }

    //insert to data base in case of everything go correct.
    const data = new FormData();
    data.append('id_usuario_denunciante', id_usuario_denunciante);
    data.append("id_usuario_denunciado", id_usuario_denunciado);
    data.append("mensaje", mensaje);
    data.append("motivo_denuncia", motivoDenuncia);

    //pass data to php file
    var respond = await fetch("php/apis/crear_denuncia.php", {
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
        setTimeout(() => {
            window.location.reload();
        }, 2000);
    }
}

/**
 * Modifica el estado de un mensaje en la base de datos.
 * Realiza una solicitud de modificación de estado a través de AJAX.
 * Si la modificación es exitosa, se muestra una notificación de éxito y se recarga la página.
 * En caso de error, se muestra una notificación de error y se recarga la página.
 * @param {string} id_conversacion - El ID de la conversación del mensaje.
 */
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

/**
 * Responde a un ticket con la respuesta especificada.
 * Realiza una solicitud de respuesta de ticket a través de AJAX.
 * Si la respuesta es exitosa, se muestra una notificación de éxito y se recarga la página.
 * En caso de error, se muestra una notificación de error.
 * @param {string} ticket_id - El ID del ticket.
 */
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

/**
 * Crea una nueva opinión de un cómic.
 * Realiza una solicitud de creación de opinión a través de AJAX.
 * Si la creación es exitosa, se muestra una notificación de éxito y se recarga la página.
 * En caso de error, se muestra una notificación de error y se recarga la página.
 */
const nueva_opinion = async () => {
    var id_user = document.querySelector("#id_user_opinion").value;
    var id_comic = document.querySelector("#id_comic").value;
    var opinion = document.querySelector("#opinion").value;
    const puntuacionInput = document.querySelector('input[name="rating"]:checked');

    if (puntuacionInput === null) {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "Debes de poner la puntuación.",
            footer: "Web Comics"
        })
        return;
    }
    const puntuacion = puntuacionInput.value;

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

/**
 * Crea una nueva opinión de una página de cómic.
 * Realiza una solicitud de creación de opinión a través de AJAX.
 * Si la creación es exitosa, se muestra una notificación de éxito y se recarga la página.
 * En caso de error, se muestra una notificación de error y se recarga la página.
 */
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

/**
 * Crea una nueva lista.
 * Realiza una solicitud de creación de lista a través de AJAX.
 * Si la creación es exitosa, se muestra una notificación de éxito y se recarga la página.
 * En caso de error, se muestra una notificación de error.
 */
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

/**
 * Modifica una lista existente.
 * Realiza una solicitud de modificación de lista a través de AJAX.
 * Si la modificación es exitosa, se muestra una notificación de éxito y se recarga la página.
 * En caso de error, se muestra una notificación de error.
 */
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

/**
 * Guarda un cómic en la lista de un usuario.
 * Realiza una solicitud para guardar el cómic a través de AJAX.
 * Si la operación es exitosa, se muestra una notificación de éxito y se ejecuta el callback (si está definido).
 * En caso de error, se muestra una notificación de error.
 * @param {string} id_comic - ID del cómic a guardar.
 * @param {function} callback - Función de callback a ejecutar después de guardar el cómic (opcional).
 */
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

/**
 * Quita un cómic de la lista de un usuario.
 * Realiza una solicitud para quitar el cómic de la lista a través de AJAX.
 * Si la operación es exitosa, se muestra una notificación de éxito y se ejecuta el callback (si está definido).
 * En caso de error, se muestra una notificación de error.
 * @param {string} id_comic - ID del cómic a quitar.
 * @param {function} callback - Función de callback a ejecutar después de quitar el cómic (opcional).
 */
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

/**
 * Guarda un cómic en una lista específica.
 * Realiza una solicitud para guardar el cómic en la lista a través de AJAX.
 * Si la operación es exitosa, se muestra una notificación de éxito y se ejecuta el callback (si está definido).
 * En caso de error, se muestra una notificación de error.
 * @param {string} id_comic - ID del cómic a guardar.
 * @param {string} id_lista - ID de la lista en la que se va a guardar el cómic.
 * @param {function} callback - Función de callback a ejecutar después de guardar el cómic en la lista (opcional).
 */
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

/**
 * Quita un cómic de una lista específica.
 * Realiza una solicitud para quitar el cómic de la lista a través de AJAX.
 * Si la operación es exitosa, se muestra una notificación de éxito y se ejecuta el callback (si está definido).
 * En caso de error, se muestra una notificación de error.
 * @param {string} id_comic - ID del cómic a quitar.
 * @param {string} id_lista - ID de la lista de la que se va a quitar el cómic.
 * @param {function} callback - Función de callback a ejecutar después de quitar el cómic de la lista (opcional).
 */
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

/**
 * Elimina una lista de un usuario.
 * Realiza una solicitud para eliminar la lista a través de AJAX.
 * Si la operación es exitosa, se muestra una notificación de éxito y se reinicia el formulario.
 * En caso de error, se muestra una notificación de error y se recarga la página después de 2 segundos.
 * @param {string} id_lista - ID de la lista a eliminar.
 * @param {string} id_user - ID del usuario propietario de la lista.
 */
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

/**
 * Elimina un usuario.
 * Realiza una solicitud para eliminar al usuario a través de AJAX.
 * Si la operación es exitosa, se muestra una notificación de éxito, se reinicia el formulario y se recarga la página después de 2 segundos.
 * En caso de error, se muestra una notificación de error y se recarga la página después de 2 segundos.
 * @param {string} id_user - ID del usuario a eliminar.
 * @param {string} emailUser - Correo electrónico del usuario a eliminar.
 */
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

/**
 * Acepta una solicitud de amistad.
 * Realiza una solicitud para aceptar la solicitud de amistad a través de AJAX.
 * Si la operación es exitosa, se muestra una notificación de éxito y se recarga la página después de 2 segundos.
 * En caso de error, se muestra una notificación de error y se recarga la página después de 2 segundos.
 * @param {string} id_solicitante - ID del usuario que envió la solicitud.
 * @param {string} id_destinatario - ID del usuario que recibió la solicitud.
 */
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

/**
 * Envía una solicitud de amistad.
 * Realiza una solicitud para enviar una solicitud de amistad a través de AJAX.
 * Si la operación es exitosa, se muestra una notificación de éxito y se recarga la página después de 2 segundos.
 * En caso de error, se muestra una notificación de error y se recarga la página después de 2 segundos.
 * @param {string} id_solicitante - ID del usuario que envía la solicitud.
 * @param {string} id_destinatario - ID del usuario al que se envía la solicitud.
 */
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

/**
 * Rechaza una solicitud de amistad.
 * Realiza una solicitud para rechazar la solicitud de amistad a través de AJAX.
 * Si la operación es exitosa, se muestra una notificación de éxito y se recarga la página después de 2 segundos.
 * En caso de error, se muestra una notificación de error y se recarga la página después de 2 segundos.
 * @param {string} id_solicitante - ID del usuario que envió la solicitud.
 * @param {string} id_destinatario - ID del usuario que recibió la solicitud.
 */
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

/**
 * Cancela una solicitud de amistad.
 * Realiza una solicitud para cancelar la solicitud de amistad a través de AJAX.
 * Si la operación es exitosa, se muestra una notificación de éxito y se recarga la página después de 2 segundos.
 * En caso de error, se muestra una notificación de error y se recarga la página después de 2 segundos.
 * @param {string} id_solicitante - ID del usuario que envió la solicitud.
 * @param {string} id_destinatario - ID del usuario que recibió la solicitud.
 */
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

/**
 * Elimina a un amigo.
 * Realiza una solicitud para eliminar a un amigo a través de AJAX.
 * Si la operación es exitosa, se muestra una notificación de éxito y se recarga la página después de 2 segundos.
 * En caso de error, se muestra una notificación de error y se recarga la página después de 2 segundos.
 * @param {string} id_solicitante - ID del usuario que realiza la acción.
 * @param {string} id_destinatario - ID del usuario que se eliminará como amigo.
 */
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

/**
 * Bloquea a un usuario.
 * Realiza una solicitud para bloquear a un usuario a través de AJAX.
 * Si la operación es exitosa, se muestra una notificación de éxito y se recarga la página después de 2 segundos.
 * En caso de error, se muestra una notificación de error y se recarga la página después de 2 segundos.
 * @param {string} id_solicitante - ID del usuario que realiza la acción.
 * @param {string} id_destinatario - ID del usuario que se bloqueará.
 */
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

/**
 * Desbloquea a un usuario.
 * Realiza una solicitud para desbloquear a un usuario a través de AJAX.
 * Si la operación es exitosa, se muestra una notificación de éxito y se recarga la página después de 2 segundos.
 * En caso de error, se muestra una notificación de error y se recarga la página después de 2 segundos.
 * @param {string} id_solicitante - ID del usuario que realiza la acción.
 * @param {string} id_destinatario - ID del usuario que se desbloqueará.
 */
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

/**
 * Envía una petición de cómic.
 * Realiza una solicitud para enviar una petición de cómic a través de AJAX.
 * Valida los campos del formulario antes de realizar la solicitud.
 * Si la validación es exitosa y la operación es exitosa, se muestra una notificación de éxito y se recarga la página después de 2 segundos.
 * En caso de error, se muestra una notificación de error y se recarga la página después de 2 segundos.
 */
const mandar_peticion_comic = () => {
    var nombre_comic = document.getElementById("nombre_comic").value;
    var nombre_variante = document.getElementById("variante_comic").value;
    var numero = document.getElementById("numero_comic").value;

    var formato = document.getElementById("formato_comic").value;
    var editorial = document.getElementById("editorial_comic").value;
    var fecha = document.getElementById("fecha_comic").value;

    var guionista = document.getElementById("guionista_comic").value;
    var procedencia = document.getElementById("procedencia_comic").value;
    var dibujante = document.getElementById("dibujante_comic").value;

    var descripcion = document.getElementById("descripcion_comic").value;

    if (nombre_comic.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "Debes de introducir el nombre del comic",
            footer: "Web Comics"
        })
        document.getElementById("nombre_comic").classList.add("error"); // Agregar clase 'error' al input
        return;
    }

    if (nombre_variante.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "Debes de introducir el nombre de la variante",
            footer: "Web Comics"
        })
        document.getElementById("nombre_variante").classList.add("error"); // Agregar clase 'error' al input

        return;
    }

    if (numero.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "Debes de introducir el numero del comic",
            footer: "Web Comics"
        })
        document.getElementById("numero_comic").classList.add("error"); // Agregar clase 'error' al input
        return;
    }

    if (formato.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "Debes de introducir el formato del comic",
            footer: "Web Comics"
        })
        document.getElementById("formato_comic").classList.add("error"); // Agregar clase 'error' al input
        return;
    }

    if (editorial.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "Debes de introducir la editorial del comic",
            footer: "Web Comics"
        })
        document.getElementById("editorial_comic").classList.add("error"); // Agregar clase 'error' al input

        return;
    }

    if (fecha.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "Debes de introducir la fecha del comic",
            footer: "Web Comics"
        })
        document.getElementById("fecha_comic").classList.add("error"); // Agregar clase 'error' al input

        return;
    }

    if (guionista.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "Debes de introducir el guionista del comic",
            footer: "Web Comics"
        })
        document.getElementById("guionista_comic").classList.add("error"); // Agregar clase 'error' al input

        return;
    }

    if (procedencia.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "Debes de introducir la procedencia del comic",
            footer: "Web Comics"
        })
        document.getElementById("procedencia_comic").classList.add("error"); // Agregar clase 'error' al input

        return;
    }

    if (dibujante.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "Debes de introducir el dibujante del comic",
            footer: "Web Comics"
        })
        document.getElementById("dibujante_comic").classList.add("error"); // Agregar clase 'error' al input

        return;
    }

    if (descripcion.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "Debes de introducir la descripcion del comic",
            footer: "Web Comics"
        })
        document.getElementById("descripcion_comic").classList.add("error"); // Agregar clase 'error' al input

        return;
    }

    const data = new FormData();
    data.append("nombre_comic", nombre_comic);
    data.append("nombre_variante", nombre_variante);
    data.append("numero", numero);
    data.append("formato", formato);
    data.append("editorial", editorial);
    data.append("fecha", fecha);
    data.append("guionista", guionista);
    data.append("procedencia", procedencia);
    data.append("dibujante", dibujante);
    data.append("descripcion", descripcion);
    data.append("portada_comic", image);


    fetch("php/apis/enviar_peticion_comic.php", {
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

/**
 * Confirma una petición de cómic.
 * Realiza una solicitud para confirmar una petición de cómic a través de AJAX.
 * Valida los campos del formulario antes de realizar la solicitud.
 * Si la validación es exitosa y la operación es exitosa, se muestra una notificación de éxito y se recarga la página después de 2 segundos.
 * En caso de error, se muestra una notificación de error y se recarga la página después de 2 segundos.
 */
const confirmar_peticion_comic = () => {
    var id_comic = document.getElementById("id_comic_peticion").value;
    var nombre_comic = document.getElementById("nombre_comic").value;
    var nombre_variante = document.getElementById("variante_comic").value;
    var numero = document.getElementById("numero_comic").value;

    var formato = document.getElementById("formato_comic").value;
    var editorial = document.getElementById("editorial_comic").value;
    var fecha = document.getElementById("fecha_comic").value;

    var guionista = document.getElementById("guionista_comic").value;
    var procedencia = document.getElementById("procedencia_comic").value;
    var dibujante = document.getElementById("dibujante_comic").value;

    var descripcion = document.getElementById("descripcion_comic").value;

    if (nombre_comic.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "Debes de introducir el nombre del comic",
            footer: "Web Comics"
        })
        document.getElementById("nombre_comic").classList.add("error"); // Agregar clase 'error' al input
        return;
    }

    if (nombre_variante.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "Debes de introducir el nombre de la variante",
            footer: "Web Comics"
        })
        document.getElementById("nombre_variante").classList.add("error"); // Agregar clase 'error' al input

        return;
    }

    if (numero.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "Debes de introducir el numero del comic",
            footer: "Web Comics"
        })
        document.getElementById("numero_comic").classList.add("error"); // Agregar clase 'error' al input
        return;
    }

    if (formato.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "Debes de introducir el formato del comic",
            footer: "Web Comics"
        })
        document.getElementById("formato_comic").classList.add("error"); // Agregar clase 'error' al input
        return;
    }

    if (editorial.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "Debes de introducir la editorial del comic",
            footer: "Web Comics"
        })
        document.getElementById("editorial_comic").classList.add("error"); // Agregar clase 'error' al input

        return;
    }

    if (fecha.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "Debes de introducir la fecha del comic",
            footer: "Web Comics"
        })
        document.getElementById("fecha_comic").classList.add("error"); // Agregar clase 'error' al input

        return;
    }

    if (guionista.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "Debes de introducir el guionista del comic",
            footer: "Web Comics"
        })
        document.getElementById("guionista_comic").classList.add("error"); // Agregar clase 'error' al input

        return;
    }

    if (procedencia.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "Debes de introducir la procedencia del comic",
            footer: "Web Comics"
        })
        document.getElementById("procedencia_comic").classList.add("error"); // Agregar clase 'error' al input

        return;
    }

    if (dibujante.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "Debes de introducir el dibujante del comic",
            footer: "Web Comics"
        })
        document.getElementById("dibujante_comic").classList.add("error"); // Agregar clase 'error' al input

        return;
    }

    if (descripcion.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "Debes de introducir la descripcion del comic",
            footer: "Web Comics"
        })
        document.getElementById("descripcion_comic").classList.add("error"); // Agregar clase 'error' al input

        return;
    }

    const data = new FormData();
    data.append("id_comic_peticion", id_comic);
    data.append("nombre_comic", nombre_comic);
    data.append("nombre_variante", nombre_variante);
    data.append("numero", numero);
    data.append("formato", formato);
    data.append("editorial", editorial);
    data.append("fecha", fecha);
    data.append("guionista", guionista);
    data.append("procedencia", procedencia);
    data.append("dibujante", dibujante);
    data.append("descripcion", descripcion);
    data.append("portada_comic", image);


    fetch("php/apis/confirmar_peticion_comic.php", {
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

/**
 * Cancela una petición de cómic.
 * Realiza una solicitud para cancelar una petición de cómic a través de AJAX.
 * Recibe el ID del cómic como parámetro.
 * Si la operación es exitosa, se muestra una notificación de éxito y se recarga la página después de 2 segundos.
 * En caso de error, se muestra una notificación de error y se recarga la página después de 2 segundos.
 * @param {string} id - ID del cómic a cancelar la petición.
 */
const cancelar_peticion_comic = (id) => {

    const data = new FormData();
    data.append("id_comic", id);
    //pass data to php file
    fetch("php/apis/cancelar_peticion_comic.php", {
        method: 'POST',
        body: data
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

/**
 * Elimina una petición de cómic.
 * Realiza una solicitud para eliminar una petición de cómic a través de AJAX.
 * Recibe el ID del cómic como parámetro.
 * Si la operación es exitosa, se muestra una notificación de éxito y se redirige al panel de administración de peticiones de cómic después de 2 segundos.
 * En caso de error, se muestra una notificación de error y se recarga la página después de 2 segundos.
 * @param {string} id - ID del cómic a eliminar la petición.
 */
const eliminar_peticion_comic = (id) => {

    const data = new FormData();
    data.append("id_comic", id);
    //pass data to php file
    fetch("php/apis/eliminar_peticion_comic.php", {
        method: 'POST',
        body: data
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
                    window.location.href = 'admin_panel_peticiones_comic.php';
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

/**
 * Elimina un comentario de la página.
 * Realiza una solicitud para eliminar un comentario de la página a través de AJAX.
 * Recibe el ID del comentario como parámetro.
 * Si la operación es exitosa, se muestra una notificación de éxito y se recarga la página después de 2 segundos.
 * En caso de error, se muestra una notificación de error y se recarga la página después de 2 segundos.
 * @param {string} id_comentario - ID del comentario a eliminar.
 */
function eliminarComentario(id_comentario) {
    const data = new FormData();
    data.append("id_comentario", id_comentario);

    //pass data to php file
    fetch("php/apis/eliminar_comentario_pag.php", {
        method: 'POST',
        body: data
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

/**
 * Elimina un comentario de un cómic.
 * Realiza una solicitud para eliminar un comentario de un cómic a través de AJAX.
 * Recibe el ID del comentario como parámetro.
 * Si la operación es exitosa, se muestra una notificación de éxito y se recarga la página después de 2 segundos.
 * En caso de error, se muestra una notificación de error y se recarga la página después de 2 segundos.
 * @param {string} id_comentario - ID del comentario a eliminar.
 */
function eliminar_comentario_comic(id_comentario) {
    const data = new FormData();
    data.append("id_comentario", id_comentario);

    //pass data to php file
    fetch("php/apis/eliminar_comentario_comic.php", {
        method: 'POST',
        body: data
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

/**
 * Elimina un cómic.
 * Realiza una solicitud para eliminar un cómic a través de AJAX.
 * Recibe el ID del cómic como parámetro.
 * Si la operación es exitosa, se muestra una notificación de éxito y se redirige a la página principal después de 2 segundos.
 * En caso de error, se muestra una notificación de error y se recarga la página después de 2 segundos.
 * @param {string} id_comic - ID del cómic a eliminar.
 */
function eliminar_comic(id_comic) {
    const data = new FormData();
    data.append("id_comic", id_comic);

    //pass data to php file
    fetch("php/apis/eliminar_comic.php", {
        method: 'POST',
        body: data
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
                    window.location.href = 'index.php';
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