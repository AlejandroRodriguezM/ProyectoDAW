// var timeoutInMiliseconds = 3600000; // 60 minutos
// var timeoutWarningInMiliseconds = 300000; // 5 minutos

var timeoutInMiliseconds = 3600000; // 60 minutos
var timeoutWarningInMiliseconds = 300000; // 5 minutos
var timeoutLogoutInMiliseconds = 20000; // 5 segundos

var timeoutId;
var timeoutWarningId;
var timeoutLogoutId;
var messageDisplayed = false;

function startTimeout() {
    timeoutId = setTimeout(doInactive, timeoutInMiliseconds);
}

function startWarningTimeout() {
    timeoutWarningId = setTimeout(showWarning, timeoutWarningInMiliseconds);
}

function resetTimeout() {
    clearTimeout(timeoutId);
    clearTimeout(timeoutWarningId);
    clearTimeout(timeoutLogoutId);
    startTimeout();
    startWarningTimeout();
}

function doInactive() {
    // localStorage.clear();
    // window.location.href = 'sesion_caducada.php';
}

function showWarning() {
    if (!messageDisplayed) {
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

        var p = document.createElement('p');
        p.innerHTML = 'Su sesión está a punto de caducar. ¿Desea continuar conectado?';
        p.style.fontSize = '20px';
        p.style.marginBottom = '20px';

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

        messageDiv.appendChild(p);
        messageDiv.appendChild(continueBtn);
        messageDiv.appendChild(logoutBtn);
        div.appendChild(messageDiv);
        document.body.appendChild(div);

        timeoutLogoutId = setTimeout(function () {
            div.parentNode.removeChild(div);
            doInactive();
        }, timeoutLogoutInMiliseconds);
        messageDisplayed = true;
    }
}

document.addEventListener('mousemove', resetTimeout);
document.addEventListener('keypress', resetTimeout);

startTimeout();
startWarningTimeout();