<?php
session_start();
include_once '../inc/header.inc.php';
global $conection;
$email = $_SESSION['email'];
$userData = obtener_datos_usuario($email);
$id_user = $userData['IDuser'];
$limit = intval($_GET['limit']);
$offset = intval($_GET['offset']);

$comics = comics_lista($userData, $limit, $offset, $conection);

$contador = 0;
$contador2 = 8; // contador para mostrar los botones de navegación
$total_comics_agregar = numComics_usuario($id_user);
$id_lista = $_GET['id_lista'];
echo "<input type='hidden' class='id_lista' id='id_lista' value='$id_lista'>";
echo "<input type='hidden' id='total_comics_agregar' value='$total_comics_agregar'>";

while ($data_comic = $comics->fetch(PDO::FETCH_ASSOC)) {
  $id_comic = $data_comic['IDcomic'];
  $numero = $data_comic['numComic'];
  $titulo = $data_comic['nomComic'];
  $numComic = $data_comic['numComic'];
  $variante = $data_comic['nomVariante'];
  $fecha = $data_comic['date_published'];
  $cover = $data_comic['Cover'];

  $id_unico = "id_comic_$id_comic";
  echo "<input type='hidden' id='$id_unico' value='$id_comic'>";
  echo "<li data-id-comic='$id_comic' class='get-it'>
                <a href='infoComic.php?IDcomic=$id_comic' title='$titulo - Variante: $variante / $numComic' class='title'>
                  <span class='cover'>
                    <img src='$cover' alt='$titulo - $variante / #$numComic'>
                  </span>
                  <strong>$titulo</strong>
                  <span class='issue-number issue-number-l1'>$numComic</span>
                </a>";
  if (check_guardado_lista($id_lista, $id_comic)) {
    echo "<button data-item-id='yXwd2' class='rem' >
                    <span class='sp-icon'>Lo tengo</span>
                </button>";
  } else {
    echo "<button data-item-id='yXwd2' class='add' >
                    <span class='sp-icon'>Lo tengo</span>
                    </button>";
  }
  echo "</li>";
  $contador++;
  if ($contador % 8 === 0) {
    echo "<ul></ul>";
  }
}

if ($contador2 >= 8 && $total_comics_agregar > 8 && ceil($total_comics_agregar / 8) > 1) {
  echo "<div class='navigation-buttons_agregar'>";
  if ($contador2 % $total_comics_agregar != 1) {
    echo '<button id="cargar-mas-agregar" name="cargar-mas-agregar" onclick="cargarMasComics_agregar(); ocultarBotones()">Cargar más</button>';
  }

  if ($contador2 >= 8) { // Solo muestra el botón 'Atrás' si se han cargado al menos 2 páginas completas
    echo '<button id="cargar-menos-agregar" onclick="cargarComicsAnteriores_agregar(); ocultarBotones()">Atras</button>';
  }

  echo "</div>";
  echo "<div id='paginas'></div>";
} elseif ($contador2 >= 1 && $contador2 < 8 && $total_comics_agregar > $contador2 && ceil($total_comics_agregar / 8) > 1) {
  echo "<div class='navigation-buttons_agregar'>";
  echo '<button id="cargar-mas-agregar" onclick="cargarMasComics_agregar(); ocultarBotones()">Cargar más</button>';
  echo "</div>";
}

?>

<script>
  (function() {
    const buttons = document.querySelectorAll('.add, .rem');
    const id_lista = document.getElementById('id_lista');
    buttons.forEach(function(button) {
      const id_comic = button.parentElement.dataset.idComic;
      const id_unico = button.dataset.itemId;

      if (id_comic) {
        button.addEventListener('click', function() {
          if (!button.classList.contains('invisible')) {
            button.classList.add('invisible');

            if (button.classList.contains('add')) {
              guardar_comic_lista(id_comic, id_lista.value, function() {
                console.log('guardar');
                loadComics();
                button.classList.remove('invisible');
                button.classList.toggle('add');
                button.classList.toggle('rem');
              });
            } else {
              quitar_comic_lista(id_comic, id_lista.value, function() {
                console.log('quitar');

                loadComics();
                button.classList.remove('invisible');
                button.classList.toggle('add');
                button.classList.toggle('rem');
              });
            }
          }
          limit_agregar = 16;
          offset_agregar = 0;
        });
      }
    });
  })();
</script>

<script>
  var btnAtras_agregar = document.getElementById('cargar-menos-agregar');
  var btnMas_agregar = document.getElementById('cargar-mas-agregar');
  var total_comics_agregar = document.getElementById('total_comics_agregar').value;

  if (btnAtras_agregar && offset_agregar < 16) {
    btnAtras_agregar.classList.add('invisible');

    if (btnMas_agregar) {
      btnMas_agregar.style.display = 'flex';
      btnMas_agregar.style.margin = '0 auto';
      btnMas_agregar.style.justifyContent = 'center';
    }
  } else if (btnAtras_agregar) {
    btnAtras_agregar.classList.remove('invisible');

    if (btnMas_agregar) {
      btnMas_agregar.style.margin = '';
    }
  }

  if (btnMas_agregar && (offset_agregar + 16) > total_comics_agregar) {
    btnMas_agregar.classList.add('invisible');

    if (btnAtras_agregar) {
      btnAtras_agregar.style.display = 'flex';
      btnAtras_agregar.style.margin = '0 auto';
      btnAtras_agregar.style.justifyContent = 'center';
    }
  } else if (btnMas_agregar) {
    btnMas_agregar.classList.remove('invisible');

    if (btnAtras_agregar) {
      btnAtras_agregar.style.margin = '';
    }
  }

  function ocultarBotones() {
    $('.navigation-buttons_agregar').hide();
  }

  function cargarMasComics_agregar() {
    offset_agregar += 16;
    limit_agregar = 16; // aumentar el límite
    $('.new-comic-list').remove();

    addComic(offset_agregar);

    // $('.comic-list').remove();
  }

  function cargarComicsAnteriores_agregar() {
    offset_agregar -= 16; // actualizar el offset_agregar
    limit_agregar = 16; // disminuir el límite
    $('.new-comic-list').remove();
    addComic(offset_agregar);


  }

</script>