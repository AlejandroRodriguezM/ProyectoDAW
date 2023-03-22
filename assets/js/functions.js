/*jshint -W033 */
const validateEmail = (email) => {
    return /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/.test(email.trim());
}

const validatePassword = (password) => {
    return /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])([a-zA-Z0-9]{8,16})$/.test(password.trim());
}

const validateUserNAme = (userName) => {
    return /^[a-z ñáéíóú-]{2,60}$/i.test(userName.trim());
}

var loadFile = function (event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function () {
        URL.revokeObjectURL(output.src) // free memory
    }
}

var pictureProfileUser = () => {
    var modal = document.getElementById("myModal");
    // Get the image and insert it inside the modal - use its "alt" text as a caption
    var img = document.getElementById("avatarUser");
    var modalImg = document.getElementById("img01");
    img.onclick = function () {
        modal.style.display = "block";
        modalImg.src = this.src;
    }

    modal.addEventListener('click', function () {
        this.style.display = "none";
    })
}

function pictureProfileAvatar() {
    var modal = document.getElementById("myModal");
    // Get the image and insert it inside the modal - use its "alt" text as a caption
    var img = document.getElementById("avatar");
    var modalImg = document.getElementById("img01");
    img.onclick = function () {
        modal.style.display = "block";
        modalImg.src = this.src;
    }

    modal.addEventListener('click', function () {
        this.style.display = "none";
    })
}

function countChar() {
    $('textarea').keyup(function () {

        var characterCount = $(this).val().length,
            current = $('#current'),
            maximum = $('#maximum'),
            theCount = $('#the-count');

        current.text(characterCount);


        /*This isn't entirely necessary, just playin around*/
        if (characterCount < 70) {
            current.css('color', '#666');
        }
        if (characterCount > 70 && characterCount < 90) {
            current.css('color', '#6d5555');
        }
        if (characterCount > 90 && characterCount < 100) {
            current.css('color', '#793535');
        }
        if (characterCount > 100 && characterCount < 120) {
            current.css('color', '#841c1c');
        }
        if (characterCount > 120 && characterCount < 139) {
            current.css('color', '#8f0001');
        }

        if (characterCount >= 140 && characterCount < 450) {
            maximum.css('color', '#8f0001');
            current.css('color', '#8f0001');
            theCount.css('font-weight', 'bold');
        } else {
            maximum.css('color', 'red');
            current.css('color', 'red');
            theCount.css('font-weight', 'bold');
        }


    });
}

function profileImage() {
    function handleFileSelect(evt) {
        var f = evt.target.files[0]; // FileList object
        var reader = new FileReader();
        // Closure to capture the file information.
        reader.onload = (function (theFile) {
            return function (e) {
                var binaryData = e.target.result;
                //Converting Binary Data to base 64
                var base64String = window.btoa(binaryData);
                //save into var globally string
                image = base64String;
            };
        })(f);
        // Read in the image file as a data URL
        reader.readAsBinaryString(f);
    }
    document.getElementById('file-input').addEventListener('change', handleFileSelect, false);
}

function buscarUsuarios() {
    $("#search-data").keyup(function () {
        var input = $(this).val();
        // alert(input);
        if (input != "") {
            $.ajax({
                url: "php/apis/search_user.php",
                method: "POST",
                data: { input: input },
                success: function (data) {
                    mostrarDatos(data);
                }
            });
        } else {
            $("#search-result").css("display", "none");
        }
    });
}

function buscarComics() {
    $("#search-data").keyup(function () {
        var input = $(this).val();
        // alert(input);
        if (input != "") {
            $.ajax({
                url: "php/apis/search_comics.php",
                method: "POST",
                data: { input: input },
                success: function (data) {
                    mostrarDatos(data);
                }
            });
        } else {
            $("#search-result").css("display", "none");
        }
    });
}

function buscar_todo() {
    $("#search-data").keyup(function () {
        var input = $(this).val();
        // alert(input);
        if (input != "") {
            $.ajax({
                url: "php/apis/search_datos.php",
                method: "POST",
                data: { input: input },
                success: function (data) {
                    mostrarDatos(data);
                }
            });
        } else {
            $("#search-result").css("display", "none");
        }
    });
}

function mostrarDatos(data) {
    $("#search-result").css("display", "block");
    $("#search-result").html(data);
}



function toggleFieldset() {
    var fieldset = document.getElementById("searchFieldset");
    if (fieldset.style.display === "none") {
        fieldset.style.display = "block";
    } else {
        fieldset.style.display = "none";
    }
}

function showSelected() {
    // const span1 = document.getElementById('span1');
    // const span2 = document.getElementById('span2');
    // const span3 = document.getElementById('span3');
    // const respuesta = document.getElementById('show_information');

    // span1.classList.add('selected');
    // respuesta.style.display = 'block';
    // buscar_todo();

    // const removeSelected = () => {
    //     span1.classList.remove('selected');
    //     span2.classList.remove('selected');
    //     span3.classList.remove('selected');
    // }

    // span1.addEventListener('load', function () {
    //     removeSelected();
    //     span1.classList.add('selected');
    //     respuesta.style.display = 'block';
    //     buscar_todo();
    // });

    // span1.addEventListener('click', () => {
    //     removeSelected();
    //     span1.classList.add('selected');
    //     respuesta.style.display = 'block';
    //     buscar_todo();
    // });

    // span2.addEventListener('click', () => {
    //     removeSelected();
    //     span2.classList.add('selected');
    //     respuesta.style.display = 'block';
    //     buscarUsuarios();
    // });

    // span3.addEventListener('click', () => {
    //     removeSelected();
    //     span3.classList.add('selected');
    //     respuesta.style.display = 'block';
    //     buscarComics();
    // });


    document.getElementById("search-data").addEventListener("keydown", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            const searchData = document.getElementById("search-data").value;
            window.location.href = "search_data.php?search=" + encodeURIComponent(searchData);
        }
    });
}

// Misma funcion pero asincrona
// async function buscarUsuarios() {
//     try {
//         const input = $("#search-data").val();
//         if (input !== "") {
//             const data = await $.ajax({
//                 url: "php/apis/search_user.php",
//                 method: "POST",
//                 data: { input: input }
//             });
//             mostrarUsuarios(data);
//         } else {
//             $("#search-result").css("display", "none");
//         }
//     } catch (error) {
//         console.error(error);
//     }
// }

function confirmar_eliminacion(id_lista, id_user) {
    if (confirm("¿Estás seguro de que deseas eliminar esta lista?")) {
        eliminar_lista(id_lista, id_user);
    }
}

function confirmar_eliminacion_usuario(id_user, emailUser) {
    if (confirm("¿Estás seguro de que deseas eliminar a este usuario?")) {
        eliminar_usuario(id_user, emailUser);
    }
}

function cambiar_estado(boolean) {
    if (confirm("¿Estás seguro de que deseas cambiar el estado del usuario?")) {
        if (boolean) {
            cambiar_estado_usuario(true)
        }
        else {
            cambiar_estado_usuario(false)
        }
    }
}

function desactivar_usuario(){
    if (confirm("¿Estás seguro de que deseas desactivar el usuario?")) {
        cambiar_estado_usuario('desactivar')
    }
}

function abrir_modal_modificar(id_lista) {
    // Obtener el nombre de la lista a partir del atributo data-nombre-lista del botón
    var nombre_lista = $("#edit-button-" + id_lista).data("nombre-lista");

    // Cargar el nombre de la lista en el campo correspondiente del modal
    $("#nombre_lista_modificar").val(nombre_lista);

    // Guardar el ID de la lista en un campo oculto del modal
    $("#id_lista_modificar").val(id_lista);

    // Abrir el modal de modificar
    $("#modificar_lista").modal("show");
}

//Otra forma de realizar la misma muestra de datos
// function buscarUsuarios() {
//     $(document).ready(function () {
//         $("#search-data").keyup(function () {
//             var input = $(this).val();

//             if (input != "") {
//                 $.ajax({
//                     url: 'php/apis/search_user_test.php',
//                     type: 'GET',
//                     dataType: 'json',
//                     // data: { send_obj: JSON.stringify(input) },
//                     success: function (data) {
//                         // Create an empty string to store the table HTML
//                         var tableHTML = '';
//                         tableHTML += '<table class="table table-hover">';
//                         tableHTML += '<thead class="table-dark">';
//                         tableHTML += '<tr>';
//                         tableHTML += '<th>Avatar</th>';
//                         tableHTML += '<th>Nombre</th>';
//                         tableHTML += '<th>Email</th>';
//                         tableHTML += '</tr>';
//                         tableHTML += '</thead>';
//                         tableHTML += '<tbody>';
//                         tableHTML += '<form class="table table-hover" method="post">';
//                         // Loop through the data and build the table rows
//                         for (var i = 0; i < data.length; i++) {
//                             tableHTML += '<tr>';
//                             tableHTML += '<td>';
//                             tableHTML += '<a href="searchInfoUser.php?email="' + data[i].email + '">';
//                             tableHTML += '<img src="' + data[i].userPicture + '" alt="profile picture" class="avatarPicture" name="avatarUser" id="avatar" alt="Avatar" style="width: 100px; height: 100px; border-radius: 50%;">';
//                             tableHTML += '</a>';
//                             tableHTML += '</td>';
//                             tableHTML += '<td id="nameUser" name="nameUser">' + data[i].userName + '</td>';
//                             tableHTML += '<td id="emailUser" name="emailUser">' + data[i].email + '</td>';
//                             tableHTML += '</tr>';
//                         }
//                         tableHTML += '</form>';
//                         tableHTML += '</tbody>';
//                         tableHTML += '</table>';
//                         // Add the table rows to the table body
//                         $("#search-result").html(tableHTML);
//                     }
//                 });
//             } else {
//                 $("#search-result").css("display", "none");
//             }
//         });
//     });
// }





