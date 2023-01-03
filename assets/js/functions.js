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

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    modal.addEventListener('click', function () {
        this.style.display = "none";
    })
}
function countChar(val) {
    var len = val.value.length;
    if (len >= 451) {
        val.value = val.value.substring(0, 451);
    } else {
        $('#charNum').text(1 + len + '/450');
    }
    if (len == 449) {
        $('#charNum').text("450/450 Has llegado al maximo");
        $('#charNum').css("color", "red");
        //add style text area
        $('#field').css("border-color", "red");
    }
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
                url: "php/user/search_user.php",
                method: "POST",
                data: { input: input },
                success: function (data) {
                    mostrarUsuarios(data);
                }
            });
        } else {
            $("#search-result").css("display", "none");
        }
    });
}

function mostrarUsuarios(data) {
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



// Misma funcion pero asincrona
// async function buscarUsuarios() {
//     try {
//         const input = $("#search-data").val();
//         if (input !== "") {
//             const data = await $.ajax({
//                 url: "php/user/search_user.php",
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

//Otra forma de realizar la misma muestra de datos
// function buscarUsuarios() {
//     $(document).ready(function () {
//         $("#search-data").keyup(function () {
//             var input = $(this).val();

//             if (input != "") {
//                 $.ajax({
//                     url: 'php/user/search_user_test.php',
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





