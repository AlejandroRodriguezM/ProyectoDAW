const buttons = document.querySelectorAll('#add, #rem');
const id_lista = document.querySelector('#id_lista').value;

function handleButtonClick(button) {
    const id_comic = button.parentElement.dataset.idComic;
    const id_unico = button.dataset.itemId;
    if (id_comic) {
        if (button.classList.contains('#add')) {
            button.classList.remove('#add');
            button.classList.add('#rem');
            guardar_comic_lista(id_comic, id_lista.value, function () {
                // Callback function to trigger loadComics after adding comic to list
                loadComics();
            });
        } else {
            button.classList.remove('#rem');
            button.classList.add('#add');

            quitar_comic_lista(id_comic, id_lista.value, function () {
                // Callback function to trigger loadComics after removing comic from list
                loadComics();
            });
        }
    }
}

buttons.forEach(function (button) {
    button.addEventListener('click', function () {
        handleButtonClick(button);
    });
});
