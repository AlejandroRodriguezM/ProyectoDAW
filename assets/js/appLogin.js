
var sesion = localStorage.getItem('UserName');
var image;
var imageData;
const checkSesion = () => {
    if (sesion != null) {
        window.location.href = "inicio.php";
    }
}

const checkSesionUpdate = () => {
    if (sesion != null) {
        document.querySelector('#user').innerHTML = sesion;
    }
}

const closeSesion =()=>{
    localStorage.clear();
    //window location in php/user
    window.location.href="logOut.php";
}

const new_User = async () => {

    var email = document.querySelector("#correo").value;
    var password = document.querySelector("#password").value;
    var repassword = document.querySelector("#repassword").value;
    var name = document.querySelector("#name").value;

    if (email.trim() === '' | password.trim() === '' | name.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "You have to fill all the camps",
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
    } else{
        data.append("userPicture", image);
        console.log(image);
    }

//pass data to php file
var respond = await fetch("php/user/new_user.php", {
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


const login_User = async () => {
    var email = document.querySelector("#correo").value;
    var password = document.querySelector('#password_user').value;
    var repassword = document.querySelector('#repassword_user').value;
    if (email.trim() === '' | password.trim() === '' | repassword.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "You have to fill all the camps",
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
            text: "You have to introduce a valid password (upperCase,lowerCase,number and min 8 characters)",
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
    data.append('pass', password);

    //pass data to php file
    var respond = await fetch("php/user/login_user.php", {
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
            window.location.href = "inicio.php";
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

const guest_User = async () => {

    var email = "guest@webComics.com";
    var password = "guest";

    const data = new FormData();
    data.append('email', email);
    data.append('pass', password);
    //pass data to php file
    var respond = await fetch("php/user/guest_user.php", {
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
            window.location.href = "inicio.php";
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

const update_user = async () => {
    
    var email = document.querySelector("#correo").value;
    var password = document.querySelector("#password").value;
    var repassword = document.querySelector("#repassword").value;
    var name = document.querySelector("#name").value;

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
    //if image is unvaliable, send 0
    if (image == null) {
        data.append("userPicture", "");
    } else{
        data.append("userPicture", image);
    }

//pass data to php file
var respond = await fetch("php/user/update_user.php", {
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
    localStorage.setItem('UserName', result.userName);
    setTimeout(() => {
        window.location.href = "settingsProfile.php";
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