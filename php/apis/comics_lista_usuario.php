<?php
session_start();
include_once '../inc/header.inc.php';
global $conection;
$email = $_SESSION['email'];
$userData = obtener_datos_usuario($email);
$limit = intval($_GET['limit']);
$offset = intval($_GET['offset']);
$id_lista = $_GET['id_lista'];

if (isset($_GET['checkboxChecked'])) {
  $search = explode(",", $_GET['checkboxChecked']);
  $search = array_map('trim', $search);
  $search = array_map('urldecode', $search);
  $search_count = count($search);

  if ($search_count == 1) {
    $where_clause = " WHERE contenido_listas.id_comic = comics.IDcomic AND contenido_listas.id_lista = $id_lista AND (nomVariante LIKE '%" . $search[0] . "%' OR nomGuionista LIKE '%" . $search[0] . "%' OR nomDibujante LIKE '%" . $search[0] . "%' OR nomEditorial = '" . $search[0] . "')";
  } else {
    $where_clauses = [];
    for ($i = 0; $i < $search_count; $i++) {
      $where_clauses[] = "(nomGuionista LIKE '%" . $search[$i] . "%' OR nomDibujante LIKE '%" . $search[$i] . "%' OR nomVariante LIKE '%" . $search[$i] . "%' OR nomEditorial = '" . $search[$i] . "')";
    }
    $where_clause = " WHERE contenido_listas.id_comic = comics.IDcomic AND contenido_listas.id_lista = $id_lista AND (" . implode(' OR ', $where_clauses) . ")";
  }
  $comics = $conection->prepare("SELECT * FROM contenido_listas,comics" . $where_clause);
  $comics->execute();
} else {
  $comics = get_comics_lista($limit, $offset, $id_lista);
}


$contador = 0;
$contador2 = 8; // contador para mostrar los botones de navegación
$total_comics = numero_comics_lista($id_lista);
echo "<input type='hidden' id='id_lista' value='$id_lista'>";
echo "<input type='hidden' id='total_comics' value='$total_comics'>";
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
                </a>
                <input type='hidden' name='id_grapa' id='id_grapa' value='$id_comic'>";

  echo "</li>";
  $contador++;
  if ($contador % 8 === 0) {
    echo "<ul></ul>";
  }
}

?>


<script>
  (function() {
    const buttons = document.querySelectorAll('.activate, .desactivate');
    const id_lista = document.getElementById('id_lista');

    buttons.forEach(function(button) {
      const id_comic = button.parentElement.dataset.idComic;
      const id_unico = button.dataset.itemId;

      if (id_comic) {
        button.addEventListener('click', function() {
          if (button.classList.contains('activate')) {
            quitar_comic_lista(id_comic, id_lista.value, function() {
              // Callback function to trigger loadComics after removing comic from list
              loadComics();
              limit_lista = 16;
              offset_lista = 0;
            });
          }

        });
      }
    });
  })();
</script>

<script>
  var btnAtras = document.getElementById('cargar-menos');
  var btnMas = document.getElementById('cargar-mas');
  var total_comics = document.getElementById('total_comics').value;

  if (btnAtras && offset_lista < 8) {
    btnAtras.classList.add('invisible');

    if (btnMas) {
      btnMas.style.display = 'flex';
      btnMas.style.margin = '0 auto';
      btnMas.style.justifyContent = 'center';
    }
  } else if (btnAtras) {
    btnAtras.classList.remove('invisible');

    if (btnMas) {
      btnMas.style.margin = '';
    }
  }

  if (btnMas && (offset_lista + 16) > total_comics) {
    btnMas.classList.add('invisible');

    if (btnAtras) {
      btnAtras.style.display = 'flex';
      btnAtras.style.margin = '0 auto';
      btnAtras.style.justifyContent = 'center';
    }
  } else if (btnMas) {
    btnMas.classList.remove('invisible');

    if (btnAtras) {
      btnAtras.style.margin = '';
    }
  }

  function ocultarBotones() {
    $('.navigation-buttons').hide();
  }

  function cargarMasComics() {
    offset_lista += 16;
    limit_lista = 16; // aumentar el límite
    loadComics(offset_lista);
    // addComic(offset_agregar);
    $('.comic-list').remove();
    // $('.new-comic-list').remove();

  }

  function cargarComicsAnteriores() {
    offset_lista -= 16; // actualizar el offset_lista
    limit_lista = 16; // disminuir el límite
    loadComics(offset_lista);
    // addComic(offset_agregar);
    $('.comic-list').remove();
    // $('.new-comic-list').remove();

  }
</script>