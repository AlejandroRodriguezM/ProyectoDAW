<?php
session_start();
include_once '../inc/header.inc.php';
global $conection;
$email = $_SESSION['email'];
$userData = getUserData($email);
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


// if (isset($_GET['comic'])) {
//     $search = urldecode(trim($_GET['comic']));
//     echo "<h1>$search</h1>";
//     $where_clause = " WHERE nomGuionista LIKE '%" . $search . "%' OR nomDibujante LIKE '%" . $search . "%' OR nomVariante LIKE '%" . $search . "%' OR nomEditorial = '" . $search . "'";
//     $comics = $conection->prepare("SELECT * FROM comics" . $where_clause);
//     $comics->execute();
// } else {
//     $comics = return_comic_published($limit, $offset);
// }


$contador = 0;
$total_comics = numComics();
echo "<input type='hidden' id='id_user' value='$id_user'>";
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

    if ($userPrivilege != 'guest') {
        if (check_guardado($id_user, $id_comic)) {
            echo "<button data-item-id='yXwd2' class='rem' >
                            <span class='sp-icon'>Lo tengo</span>
                        </button>";
        } else {
            echo "<button data-item-id='yXwd2' class='add' >
                            <span class='sp-icon'>Lo tengo</span>
                            </button>";
        }
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
        buttons.forEach(function(button) {
            button.addEventListener('click', function() {
                const id_comic = button.previousElementSibling.value;
                if (button.classList.contains('add')) {
                    button.classList.toggle('add');
                    button.classList.toggle('rem');
                    guardar_comic(id_comic);
                } else if (button.classList.contains('rem')) {
                    button.classList.toggle('rem');
                    button.classList.toggle('add');
                    quitar_comic(id_comic);
                }
            });
        });
    })();
</script>