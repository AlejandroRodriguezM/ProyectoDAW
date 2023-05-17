<?php
session_start();
include_once '../inc/header.inc.php'; // Incluye un archivo de cabecera común.
global $conection; // Permite acceder a la conexión de la base de datos.

if(isset($_GET['id_lista'])){
  $email = $_SESSION['email']; // Obtiene el correo electrónico del usuario actualmente autenticado.
  $userData = obtener_datos_usuario($email); // Obtiene los datos del usuario basados en el correo electrónico.
  $limit = intval($_GET['limit']); // Obtiene el límite de resultados de la URL y lo convierte en un entero.
  $offset = intval($_GET['offset']); // Obtiene el desplazamiento de resultados de la URL y lo convierte en un entero.
  $id_lista = $_GET['id_lista']; // Obtiene el ID de la lista de la URL.
}else{
  header("Location: ../../index.php");
}


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
  // Recorre cada cómic obtenido.

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

if ($contador2 >= 8 && $total_comics > 8 && ceil($total_comics / 8) > 1) {
  echo "<div class='navigation-buttons'>";
  if ($contador2 % $total_comics != 1) {
    echo '<button id="cargar-mas" name="cargar-mas" onclick="cargarMasComics(); ocultarBotones()">Cargar más</button>';
  }

  if ($contador2 >= 8) { // Solo muestra el botón 'Atrás' si se han cargado al menos 2 páginas completas
    echo '<button id="cargar-menos" onclick="cargarComicsAnteriores(); ocultarBotones()">Atras</button>';
  }

  echo "</div>";
  echo "<div id='paginas'></div>";
} elseif ($contador2 >= 1 && $contador2 < 8 && $total_comics > $contador2 && ceil($total_comics / 8) > 1) {
  echo "<div class='navigation-buttons'>";
  echo '<button id="cargar-mas" onclick="cargarMasComics(); ocultarBotones()">Cargar más</button>';
  echo "</div>";
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
              // Función de devolución de llamada para cargarComics después de eliminar el cómic de la lista              loadComics();
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
    $('.navigation-buttons').hide(); // Oculta los botones de navegación
  }

  function cargarMasComics() {
    offset_lista += 16; // Incrementa el valor de offset_lista en 16 para obtener los siguientes cómics
    limit_lista = 16; // Establece el límite en 16 para la carga de cómics
    loadComics(offset_lista); // Carga los cómics utilizando el nuevo valor de offset_lista
    $('.comic-list').remove(); // Elimina los cómics existentes en la lista
  }

  function cargarComicsAnteriores() {
    offset_lista -= 16; // Actualiza el valor de offset_lista restando 16 para obtener los cómics anteriores
    limit_lista = 16; // Establece el límite en 16 para la carga de cómics
    loadComics(offset_lista); // Carga los cómics utilizando el nuevo valor de offset_lista
    $('.comic-list').remove(); // Elimina los cómics existentes en la lista
  }
</script>