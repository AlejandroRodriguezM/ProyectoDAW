<?php
session_start();
include_once '../inc/header.inc.php';
global $conection;
$email = $_SESSION['email'];
$userData = obtener_datos_usuario($email);
$userPrivilege = $userData['privilege'];

$id_user = $userData['IDuser'];
$limit = intval($_GET['limit']);
$offset = intval($_GET['offset']);

if (isset($_GET['checkboxChecked'])) {
    $search = explode(",", $_GET['checkboxChecked']);
    $search = array_map('trim', $search);
    $search = array_map('urldecode', $search);
    $search_count = count($search);
    //make for and show all $search
    for ($i = 0; $i < $search_count; $i++) {
        echo "<h1>$search[$i]</h1>";
    }
    if ($search_count == 1) {
        $where_clause = " WHERE nomGuionista LIKE '%" . $search[0] . "%' OR nomDibujante LIKE '%" . $search[0] . "%' OR nomVariante LIKE '%" . $search[0] . "%' OR nomEditorial = '" . $search[0] . "'";
    } else {
        $where_clauses = [];
        for ($i = 0; $i < $search_count; $i++) {
            $where_clauses[] = "(nomGuionista LIKE '%" . $search[$i] . "%' OR nomDibujante LIKE '%" . $search[$i] . "%' OR nomVariante LIKE '%" . $search[$i] . "%' OR nomEditorial = '" . $search[$i] . "')";
        }
        $where_clause = " WHERE " . implode(' OR ', $where_clauses);
    }

    $comics = $conection->prepare("SELECT * FROM comics" . $where_clause);
    $comics->execute();
} else {
    $comics = return_comic_published($limit, $offset);
}


$contador = 0;
$contador2 = 24; // contador para mostrar los botones de navegación
$total_comics = numComics();
echo "<input type='hidden' id='id_user' value='$id_user'>";
echo "<input type='hidden' id='total_comics' value='$total_comics'>";
while ($data_comic = $comics->fetch(PDO::FETCH_ASSOC)) {
    $id_comic = $data_comic['IDcomic'];
    $numero = $data_comic['numComic'];
    $titulo = $data_comic['nomComic'];
    $numComic = $data_comic['numComic'];
    $variante = $data_comic['nomVariante'];
    $fecha = $data_comic['date_published'];
    $cover = $data_comic['Cover'];

    echo "<li id='comicyXwd2' class='get-it'>
            <a href='infoComic.php?IDcomic=$id_comic' title='$titulo - Variante: $variante / $numComic' class='title'>
              <span class='cover'>
                <img src='$cover' alt='$titulo - $variante / #$numComic'>
              </span>
              <strong>$titulo</strong>
              <span class='issue-number issue-number-l1'>$numComic</span>
            </a>
            <input type='hidden' name='id_grapa' id='id_grapa' value='$id_comic'>";


    if (check_guardado($id_user, $id_comic)) {
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
    $contador2++;
    if ($contador % 8 === 0) {
        echo "<ul></ul>";
    }
}


if ($contador2 >= 24 && $total_comics > 24 && ceil($total_comics / 24) > 1) {
    echo "<div class='navigation-buttons'>";
    if ($contador2 % $total_comics != 1) {
        echo '<button class="navigation-buttons" id="cargar-mas" name="cargar-mas" onclick="cargarMasComics(); ocultarBotones()">Cargar más</button>';
    }

    if ($contador2 >= 24) { // Solo muestra el botón 'Atrás' si se han cargado al menos 2 páginas completas
        echo '<button class="navigation-buttons" id="cargar-menos" onclick="cargarComicsAnteriores(); ocultarBotones()">Atras</button>';
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
        const buttons = document.querySelectorAll('.add, .rem');

        buttons.forEach(function(button) {
            const id_comic = button.previousElementSibling.value;

            button.addEventListener('click', function() {
                if (!button.classList.contains('invisible')) {
                    button.classList.add('invisible');

                    if (button.classList.contains('add')) {
                        guardar_comic(id_comic, function() {

                            button.classList.remove('invisible');
                            button.classList.toggle('add');
                            button.classList.toggle('rem');
                        });
                    } else {
                        quitar_comic(id_comic, function() {

                            button.classList.remove('invisible');
                            button.classList.toggle('add');
                            button.classList.toggle('rem');
                        });
                    }
                }
            });
        });
    })();
</script>

<script>
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
</script>

<script>
    var btnAtras = document.getElementById('cargar-menos');
    var btnMas = document.getElementById('cargar-mas');
    var total_comics = document.getElementById('total_comics').value;
    if (btnAtras && offset <= 8) {
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

    if (btnMas && (offset + 24) > total_comics) {
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
        offset += 24;
        limit = 24; // aumentar el límite
        loadComics(offset);
        $('.new-comic-list').remove();
    }

    function cargarComicsAnteriores() {
        offset -= 24; // actualizar el offset
        limit = 24; // disminuir el límite
        loadComics(offset);
        $('.new-comic-list').remove();
    }
</script>