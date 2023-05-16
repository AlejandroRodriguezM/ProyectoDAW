// Tiempo de espera en milisegundos antes de la desconexión automática (60 minutos)
var timeoutInMiliseconds = 3600000;

// Tiempo de espera en milisegundos antes de mostrar el mensaje de advertencia (5 minutos)
var timeoutWarningInMiliseconds = 300000;

// Tiempo de espera en milisegundos antes de cerrar la sesión automáticamente (5 segundos)
var timeoutLogoutInMiliseconds = 20000;

var timeoutId;
var timeoutWarningId;
var timeoutLogoutId;
var messageDisplayed = false;

// Iniciar el temporizador de inactividad
function startTimeout() {
    timeoutId = setTimeout(doInactive, timeoutInMiliseconds);
}

// Iniciar el temporizador de advertencia
function startWarningTimeout() {
    timeoutWarningId = setTimeout(showWarning, timeoutWarningInMiliseconds);
}

// Reiniciar los temporizadores
function resetTimeout() {
    clearTimeout(timeoutId);
    clearTimeout(timeoutWarningId);
    clearTimeout(timeoutLogoutId);
    startTimeout();
    startWarningTimeout();
}

// Acción a realizar cuando se detecta inactividad
function doInactive() {
    localStorage.clear();
    window.location.href = 'sesion_caducada.php';
}

// Mostrar el mensaje de advertencia
function showWarning() {
    if (!messageDisplayed) {
        // Crear un elemento de div oscuro para cubrir toda la pantalla
        var div = document.createElement('div');
        div.setAttribute('id', 'session-expiration');
        div.style.position = 'fixed';
        div.style.top = '0';
        div.style.left = '0';
        div.style.width = '100%';
        div.style.height = '100%';
        div.style.background = 'rgba(0, 0, 0, 0.5)';
        div.style.display = 'flex';
        div.style.justifyContent = 'center';
        div.style.alignItems = 'center';
        div.style.zIndex = '9999';

        // Crear un mensaje de advertencia en un div centrado
        var messageDiv = document.createElement('div');
        messageDiv.setAttribute('id', 'session-expiration-message');
        messageDiv.style.background = '#fff';
        messageDiv.style.padding = '20px';
        messageDiv.style.borderRadius = '5px';
        messageDiv.style.textAlign = 'center';
        messageDiv.style.boxShadow = '0 2px 8px rgba(0, 0, 0, 0.3)';
        messageDiv.style.display = 'flex';
        messageDiv.style.flexDirection = 'column';
        messageDiv.style.alignItems = 'center';

        // Agregar el texto de advertencia
        var p = document.createElement('p');
        p.innerHTML = 'Su sesión está a punto de caducar. ¿Desea continuar conectado?';
        p.style.fontSize = '20px';
        p.style.marginBottom = '20px';

        // Botón para continuar la sesión
        var continueBtn = document.createElement('button');
        continueBtn.innerHTML = 'Continuar';
        continueBtn.style.padding = '10px';
        continueBtn.style.border = 'none';
        continueBtn.style.background = '#0066ff';
        continueBtn.style.color = '#fff';
        continueBtn.style.borderRadius = '5px';
        continueBtn.style.cursor = 'pointer';
        continueBtn.onclick = function () {
            resetTimeout();
            messageDisplayed = false;
            div.parentNode.removeChild(div);
        }

        // Botón para cerrar la sesión
        var logoutBtn = document.createElement('button');
        logoutBtn.innerHTML = 'Cerrar sesión';
        logoutBtn.style.padding = '10px';
        logoutBtn.style.border = 'none';
        logoutBtn.style.background = '#ff0000';
        logoutBtn.style.color = '#fff';
        logoutBtn.style.borderRadius = '5px';
        logoutBtn.style.cursor = 'pointer';
        logoutBtn.onclick = function () {
            window.location.href = 'sesion_caducada.php';
        }

        // Agregar elementos al div del mensaje
        messageDiv.appendChild(p);
        messageDiv.appendChild(continueBtn);
        messageDiv.appendChild(logoutBtn);
        div.appendChild(messageDiv);
        document.body.appendChild(div);

        // Temporizador para cerrar la sesión automáticamente
        timeoutLogoutId = setTimeout(function () {
            div.parentNode.removeChild(div);
            doInactive();
        }, timeoutLogoutInMiliseconds);
        messageDisplayed = true;
    }
}

// Restablecer temporizadores al detectar movimiento del mouse o pulsación de tecla
document.addEventListener('mousemove', resetTimeout);
document.addEventListener('keypress', resetTimeout);

// Iniciar los temporizadores
startTimeout();
startWarningTimeout();