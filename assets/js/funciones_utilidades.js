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

    // document.getElementById("search-data").addEventListener("submit", function (event) {
    //     event.preventDefault();
    //     const searchData = document.getElementById("search-data").value;
    //     window.location.href = "search_data.php?search=" + encodeURIComponent(searchData);
    // });
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

function cambiar_autorizacion(boolean, email) {
    if (confirm("¿Estás seguro de quieres cambiar el estado de la cuenta?")) {
        if (boolean) {
            desautorizar_usuario(boolean, email)
        }
        else {
            desautorizar_usuario(boolean, email)
        }
    }
}

function desactivar_usuario() {
    if (confirm("¿Estás seguro de que deseas desactivar el usuario?")) {
        desactivar_cuenta();
    }
}

function cambiar_privacidad(boolean) {
    if (confirm("¿Estás seguro de que deseas cambiar tu estado actual de privacidad?")) {
        if (boolean) {
            cambiar_privacidad_usuario(true)
        }
        else {
            cambiar_privacidad_usuario(false)
        }

    }
}

function confirmar_envio_peticion_comic() {
    if (confirm("¿Aceptar la petición?")) {
        confirmar_peticion_comic();
    }
}

function peticion_comic_formulario() {
    if (confirm("¿Estás seguro que quieres mandar la petición?")) {
        mandar_peticion_comic();
    }
}

function cancelar_peticion_usuario(id) {
    if (confirm("¿Estás seguro de que deseas eliminar la petición?")) {
        cancelar_peticion_comic(id);
    }
}

function eliminar_peticion_usuario(id) {
    if (confirm("¿Estás seguro de que deseas eliminar la petición?")) {
        eliminar_peticion_comic(id);
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

function actualizar_filtrado() {
    $(document).ready(function () {
        $.ajax({
            url: 'php/apis/filtrador_comics.php',
            type: 'GET',
            success: function (response) {
                $('.filtrado_comics').html(response);
            }
        });
    });
}

function actualizar_filtrado_usuario(id_user) {
    $.ajax({
        url: 'php/apis/filtrador_comics_usuario.php',
        type: 'POST',
        data: {
            id_user: id_user
        },
        success: function (response) {
            $('.filtrado_comics').html(response);
        }
    });
}

function actualizar_filtrado_lista_usuario(id_lista) {
    $.ajax({
        url: 'php/apis/filtrador_comics_lista_usuario.php',
        type: 'POST',
        data: {
            id_lista: id_lista
        },
        success: function (response) {
            $('.filtrado_comics').html(response);
        }
    });
}


function actualizar_filtrado_completo() {
    $(document).ready(function () {
        $.ajax({
            url: 'php/apis/filtrador_comics_completo.php',
            type: 'GET',
            success: function (response) {
                $('.filtrado_comics').html(response);
            }
        });
    });
}

function handleCheckboxChange() {
    var checkboxes = document.querySelectorAll('input[type=checkbox]');

    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].removeEventListener('change', checkboxChanged);
        checkboxes[i].addEventListener('change', checkboxChanged);
    }
}

function checkboxChanged() {
    offset = 0;
    if ($("input[type='checkbox']:checked").length > 0) {
        checkboxChecked = $("input[type='checkbox']:checked").val();
    }
    if (checkboxChecked) {
        $('.new-comic-list').html('');
        $('.comic-list').html('');
        loadComics(checkboxChecked);
        if (document.getElementById('contenido')) {
            addComic(checkboxChecked);
        }
    } else {
        $('.new-comic-list').html('');
        $('.comic-list').html('');
        loadComics(checkboxChecked);
        if (document.getElementById('contenido')) {
            addComic(checkboxChecked);
        }
    }
}

function toggleDropdown(element) {
    var dropdownContent1 = document.getElementById("dropdownContent1");
    var dropdownContent2 = document.getElementById("dropdownContent2");
    var dropdownContent3 = document.getElementById("dropdownContent3");
    var dropdownContent4 = document.getElementById("dropdownContent4");

    if (element.querySelector(".dropdown-content").style.display === "block" && event.target.tagName !== 'INPUT') {
        dropdownContent1.style.display = "none";
        dropdownContent2.style.display = "none";
        dropdownContent3.style.display = "none";
        dropdownContent4.style.display = "none";
    } else {
        dropdownContent1.style.display = "none";
        dropdownContent2.style.display = "none";
        dropdownContent3.style.display = "none";
        dropdownContent4.style.display = "none";
        element.querySelector(".dropdown-content").style.display = "block";
    }
}

function closeDropdown(dropdownContent) {
    dropdownContent.style.display = "none";
}

document.addEventListener("click", function (event) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    for (var i = 0; i < dropdowns.length; i++) {
        var dropdown = dropdowns[i];
        if (event.target.closest(".dropdown") !== dropdown.parentNode && event.target !== dropdown.parentNode) {
            dropdown.style.display = "none";
        }
    }
});

function searchData(id) {
    let input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput" + id);
    filter = input.value.toUpperCase();
    table = document.getElementById("dropdownContent" + id);
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}