<?php
session_start();
include_once '../inc/header.inc.php';
global $conection;
$email = $_SESSION['email'];
$userData = getUserData($email);
$id_user = $userData['IDuser'];
$limit = intval($_GET['limit']);
$offset = intval($_GET['offset']);
$id_lista = $_GET['id_lista'];

if (isset($_GET['checkboxChecked'])) {
    $search = explode(",", $_GET['checkboxChecked']);
    $search = array_map('trim', $search);
    $search = array_map('urldecode', $search);
    $search_count = count($search);

    if ($search_count == 1) {
        $where_clause = " WHERE comics_guardados.comic_id = comics.IDcomic AND comics_guardados.user_id = $id_user AND (nomVariante LIKE '%" . $search[0] . "%' OR nomGuionista LIKE '%" . $search[0] . "%' OR nomDibujante LIKE '%" . $search[0] . "%' OR nomEditorial = '" . $search[0] . "')";
    } else {
        $where_clauses = [];
        for ($i = 0; $i < $search_count; $i++) {
            $where_clauses[] = "(nomGuionista LIKE '%" . $search[$i] . "%' OR nomDibujante LIKE '%" . $search[$i] . "%' OR nomVariante LIKE '%" . $search[$i] . "%' OR nomEditorial = '" . $search[$i] . "')";
        }
        $where_clause = " WHERE comics_guardados.comic_id = comics.IDcomic AND comics_guardados.user_id = $id_user AND (" . implode(' OR ', $where_clauses) . ")";
    }
    $comics = $conection->prepare("SELECT * FROM comics_guardados,comics" . $where_clause);
    $comics->execute();
} else {
    $comics = get_comics_guardados($limit, $offset, $id_user);
}

$contador = 0;
$total_comics = numComics();
echo "<input type='hidden' id='id_lista' value='$id_lista'>";
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
                    if (button.classList.contains('add')) {
                        button.classList.remove('add');
                        button.classList.add('rem');
                        guardar_comic_lista(id_comic, id_lista.value);
                    } else {
                        button.classList.remove('rem');
                        button.classList.add('add');
                        quitar_comic_lista(id_comic, id_lista.value);
                    }
                });
            }
        });
    })();
</script>