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