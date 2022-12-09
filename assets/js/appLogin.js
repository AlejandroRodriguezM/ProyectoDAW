
var sesion = localStorage.getItem('UserName');
var image;
var imageData;
const checkSesion = () => {
    if (sesion != null) {
        window.location.href = "inicio.html";
    }
}

// transform code to function

// if (window.File && window.FileReader && window.FileList && window.Blob) {
//     document.getElementById('files').addEventListener('change', handleFileSelect, false);
// } else {
//     alert('The File APIs are not fully supported in this browser.');
// }

// function checkFileAPI() {
//     if (window.File && window.FileReader && window.FileList && window.Blob) {
//         document.getElementById('files').addEventListener('change', handleFileSelect, false);
//     } else {
//         alert('The File APIs are not fully supported in this browser.');
//     }
// }


// function handleFileSelect(evt) {
//     var f = evt.target.files[0]; // FileList object
//     var reader = new FileReader();
//     // Closure to capture the file information.
//     reader.onload = (function (theFile) {
//         return function (e) {
//             var binaryData = e.target.result;
//             //Converting Binary Data to base 64
//             var base64String = window.btoa(binaryData);
//             //save into var globally string
//             image = base64String;
//         };
//     })(f);
//     // Read in the image file as a data URL
//     reader.readAsBinaryString(f);
// }


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
            footer: "CRUD CONTACTOS"
        })
        return;
    }

    if (!validateEmail(email)) {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "The email introduce is not valite, please, enter a correct email.",
            footer: "CRUD CONTACTOS"
        })
        return;
    }

    if (!validatePassword(password)) {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "You have to introduce a valid password (upperCase,lowerCase,numer and min 8 characters)",
            footer: "CRUD CONTACTOS"
        })
        return;
    }

    if (!validateUserNAme(name)) {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "You have introduce a valid Name",
            footer: "CRUD CONTACTOS"
        })
        return;
    }

    if (password != repassword) {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "The password dosnt match",
            footer: "CRUD CONTACTOS"
        })
        //input password border red
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
    data.append("userPicture", image);

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
            footer: "CRUD CONTACTOS"
        })
        document.querySelector('#formInsert').reset();
        setTimeout(() => {
            window.location.href = "index.html";
        }, 2000);
    } else {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: result.message,
            footer: "CRUD CONTACTOS"
        })
    }
}


const login_User = async () => {
    var email = document.querySelector("#correo").value;
    var password = document.querySelector("#password").value;
    if (email.trim() === '' | password.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "You have to fill all the camps",
            footer: "CRUD CONTACTOS"
        })
        return;
    }

    if (!validateEmail(email)) {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "The email introduce is not valite, please, enter a correct email.",
            footer: "CRUD CONTACTOS"
        })
        return;
    }

    if (!validatePassword(password)) {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: "You have to introduce a valid password (upperCase,lowerCase,numer and min 8 characters)",
            footer: "CRUD CONTACTOS"
        })
        return;
    }

    //insert to data base in case of everything go correct.
    const data = new FormData();
    data.append("email", email);
    data.append("pass", password);

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
            footer: "CRUD CONTACTOS"
        })
        document.querySelector('#formIniciar').reset();
        localStorage.setItem('UserName', result.userName);
        setTimeout(() => {
            window.location.href = "inicio.html";
        }, 2000);
    } else {
        Swal.fire({
            icon: "error",
            title: "ERROR.",
            text: result.message,
            footer: "CRUD CONTACTOS"
        })
    }

}
