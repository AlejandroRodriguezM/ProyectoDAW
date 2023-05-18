/*jshint -W033 */
/**
 * Valida si una dirección de correo electrónico es válida.
 * @param {string} email - La dirección de correo electrónico a validar.
 * @returns {boolean} - Devuelve true si la dirección de correo electrónico es válida, de lo contrario devuelve false.
 */
const validateEmail = (email) => {
    return /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/.test(email.trim());
}

/**
 * Valida si una contraseña cumple con los requisitos mínimos de seguridad.
 * @param {string} password - La contraseña a validar.
 * @returns {boolean} - Devuelve true si la contraseña cumple con los requisitos, de lo contrario devuelve false.
 */
const validatePassword = (password) => {
    return /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])([a-zA-Z0-9]{8,16})$/.test(password.trim());
}

/**
 * Valida si un nombre de usuario cumple con los requisitos establecidos.
 * @param {string} userName - El nombre de usuario a validar.
 * @returns {boolean} - Devuelve true si el nombre de usuario cumple con los requisitos, de lo contrario devuelve false.
 */
const validar_nombre = (userName) => {
    return /^[a-z ñáéíóú-]{2,60}$/i.test(userName.trim());
}

/**
 * Carga un archivo y muestra su vista previa en un elemento de imagen.
 * @param {Event} event - El evento de carga de archivo.
 */
var loadFile = function (event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function () {
        URL.revokeObjectURL(output.src); // Liberar memoria
    }
}

/**
 * Muestra una imagen de perfil de usuario en un modal.
 */
var pictureProfileUser = () => {
    var modal = document.getElementById("myModal");
    // Obtener la imagen e insertarla dentro del modal, utilizando el texto "alt" como leyenda.
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

/**
 * Muestra una imagen de perfil de avatar en un modal.
 */
function pictureProfileAvatar() {
    var modal = document.getElementById("myModal");
    // Obtener la imagen e insertarla dentro del modal, utilizando el texto "alt" como leyenda.
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

/**
 * Cuenta la cantidad de caracteres en un textarea y muestra el conteo de caracteres actual.
 */
function countChar() {
    $('textarea').keyup(function () {

        var characterCount = $(this).val().length,
            current = $('#current'),
            maximum = $('#maximum'),
            theCount = $('#the-count');

        current.text(characterCount);

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

/**
 * Maneja la selección de una imagen de perfil.
 */
function profileImage() {
    function handleFileSelect(evt) {
        var f = evt.target.files[0]; // Objeto FileList
        var reader = new FileReader();
        // Cierre para capturar la información del archivo.
        reader.onload = (function (theFile) {
            return function (e) {
                var binaryData = e.target.result;
                // Convertir datos binarios a base 64
                var base64String = window.btoa(binaryData);
                // Guardar la cadena base64 en una variable global
                image = base64String;
            };
        })(f);
        // Leer el archivo de imagen como una URL de datos
        reader.readAsBinaryString(f);
    }
    document.getElementById('file-input').addEventListener('change', handleFileSelect, false);
}


/**
 * Busca usuarios en función del valor ingresado en el campo de búsqueda.
 */
function buscarUsuarios() {
    $("#search-data").keyup(function () {
        var input = $(this).val();
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

// /**
//  * Busca cómics en función del valor ingresado en el campo de búsqueda.
//  */
// function buscarComics() {
//     $("#search-data").keyup(function () {
//         var input = $(this).val();
//         if (input != "") {
//             $.ajax({
//                 url: "php/apis/search_comics.php",
//                 method: "POST",
//                 data: { input: input },
//                 success: function (data) {
//                     mostrarDatos(data);
//                 }
//             });
//         } else {
//             $("#search-result").css("display", "none");
//         }
//     });
// }

/**
 * Realiza una búsqueda general en función del valor ingresado en el campo de búsqueda.
 */
function buscar_todo() {
    $("#search-data").keyup(function () {
        var input = $(this).val();
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

/**
 * Muestra los datos en el resultado de búsqueda.
 * @param {string} data - Los datos a mostrar.
 */
function mostrarDatos(data) {
    $("#search-result").css("display", "block");
    $("#search-result").html(data);
}




/**
 * Alterna la visualización del fieldset de búsqueda.
 */
function toggleFieldset() {
    var fieldset = document.getElementById("searchFieldset");
    if (fieldset.style.display === "none") {
        fieldset.style.display = "block";
    } else {
        fieldset.style.display = "none";
    }
}

/**
 * Muestra los resultados seleccionados al presionar la tecla "Enter" en el campo de búsqueda.
 */
function showSelected() {
    document.getElementById("search-data").addEventListener("keydown", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            const searchData = document.getElementById("search-data").value;
            window.location.href = "search_data.php?search=" + encodeURIComponent(searchData);
        }
    });
}

/**
 * Confirma la eliminación de una lista y llama a la función "eliminar_lista" si se confirma.
 * @param {string} id_lista - El ID de la lista a eliminar.
 * @param {string} id_user - El ID del usuario.
 */
function confirmar_eliminacion(id_lista, id_user) {
    if (confirm("¿Estás seguro de que deseas eliminar esta lista?")) {
        eliminar_lista(id_lista, id_user);
    }
}

/**
 * Confirma la eliminación de un usuario y llama a la función "eliminar_usuario" si se confirma.
 * @param {string} id_user - El ID del usuario a eliminar.
 * @param {string} emailUser - El correo electrónico del usuario.
 */
function confirmar_eliminacion_usuario(id_user, emailUser) {
    if (confirm("¿Estás seguro de que deseas eliminar a este usuario?")) {
        eliminar_usuario(id_user, emailUser);
    }
}

/**
 * Cambia el estado de autorización de una cuenta y llama a la función "desautorizar_usuario" según corresponda.
 * @param {boolean} boolean - El estado de autorización (true o false).
 * @param {string} email - El correo electrónico del usuario.
 */
function cambiar_autorizacion(boolean, email) {
    if (confirm("¿Estás seguro de quieres cambiar el estado de la cuenta?")) {
        if (boolean) {
            desautorizar_usuario(boolean, email);
        } else {
            desautorizar_usuario(boolean, email);
        }
    }
}


/**
 * Confirma la desactivación de un usuario y llama a la función "desactivar_cuenta" si se confirma.
 */
function desactivar_usuario() {
    if (confirm("¿Estás seguro de que deseas desactivar el usuario?")) {
        desactivar_cuenta();
    }
}

/**
 * Cambia el estado de privacidad y llama a la función "cambiar_privacidad_usuario" según corresponda.
 * @param {boolean} boolean - El estado de privacidad (true o false).
 */
function cambiar_privacidad(boolean) {
    if (confirm("¿Estás seguro de que deseas cambiar tu estado actual de privacidad?")) {
        if (boolean) {
            cambiar_privacidad_usuario(true);
        } else {
            cambiar_privacidad_usuario(false);
        }
    }
}

/**
 * Confirma el envío de una petición de cómic y llama a la función "confirmar_peticion_comic" si se confirma.
 */
function confirmar_envio_peticion_comic() {
    if (confirm("¿Aceptar la petición?")) {
        confirmar_peticion_comic();
    }
}

/**
 * Confirma el envío del formulario de petición de cómic y llama a la función "mandar_peticion_comic" si se confirma.
 */
function peticion_comic_formulario() {
    if (confirm("¿Estás seguro que quieres mandar la petición?")) {
        mandar_peticion_comic();
    }
}

/**
 * Confirma la cancelación de una petición de cómic y llama a la función "cancelar_peticion_comic" si se confirma.
 * @param {string} id - El ID de la petición de cómic.
 */
function cancelar_peticion_usuario(id) {
    if (confirm("¿Estás seguro de que deseas eliminar la petición?")) {
        cancelar_peticion_comic(id);
    }
}

/**
 * Confirma la eliminación de una petición de cómic y llama a la función "eliminar_peticion_comic" si se confirma.
 * @param {string} id - El ID de la petición de cómic.
 */
function eliminar_peticion_usuario(id) {
    if (confirm("¿Estás seguro de que deseas eliminar la petición?")) {
        eliminar_peticion_comic(id);
    }
}

/**
 * Abre el modal de modificar lista y muestra el nombre de la lista correspondiente.
 * @param {string} id_lista - El ID de la lista a modificar.
 */
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

/**
 * Actualiza el filtrado de cómics al cargar la página.
 */
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

/**
 * Actualiza el filtrado de cómics según el usuario especificado.
 * @param {string} id_user - El ID del usuario.
 */
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

/**
 * Actualiza el filtrado de cómics según la lista de usuario especificada.
 * @param {string} id_lista - El ID de la lista de usuario.
 */
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

/**
 * Actualiza el filtrado completo de cómics al cargar la página.
 */
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

/**
 * Maneja el cambio de estado de los checkboxes.
 */
function handleCheckboxChange() {
    var checkboxes = document.querySelectorAll('input[type=checkbox]');

    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].removeEventListener('change', checkboxChanged);
        checkboxes[i].addEventListener('change', checkboxChanged);
    }
}

/**
 * Maneja el cambio de estado de un checkbox y realiza las acciones correspondientes.
 */
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

/**
 * Alterna la visualización de un menú desplegable.
 * @param {HTMLElement} element - El elemento que activa el menú desplegable.
 */
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

/**
 * Cierra el menú desplegable especificado.
 * @param {HTMLElement} dropdownContent - El contenido del menú desplegable a cerrar.
 */
function closeDropdown(dropdownContent) {
    dropdownContent.style.display = "none";
}

/**
 * Cierra los menús desplegables al hacer clic fuera de ellos.
 */
document.addEventListener("click", function (event) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    for (var i = 0; i < dropdowns.length; i++) {
        var dropdown = dropdowns[i];
        if (event.target.closest(".dropdown") !== dropdown.parentNode && event.target !== dropdown.parentNode) {
            dropdown.style.display = "none";
        }
    }
});

/**
 * Realiza una búsqueda en una tabla según el texto ingresado.
 * @param {string} id - El ID del elemento de entrada de búsqueda.
 */
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
