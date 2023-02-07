<?php
include_once '../inc/header.inc.php';
global $conection;
$limit = intval($_GET['limit']);
$offset = intval($_GET['offset']);
if (isset($_GET['checkboxChecked'])) {
    $search = explode(",", $_GET['checkboxChecked']);
    $search = array_map('trim', $search);
    $search = array_map('urldecode', $search);
    $search_count = count($search);

    if ($search_count > 0) {
        $where_clauses = [];
        $where_params = [];
        for ($i = 0; $i < $search_count; $i++) {
            $where_clauses[] = "(nomGuionista LIKE ? OR nomDibujante LIKE ? OR nomEditorial = ?)";
            $where_params = array_merge($where_params, ["%".$search[$i]."%", "%".$search[$i]."%", $search[$i]]);
        }
        $comics = $conection->prepare("SELECT * FROM comics WHERE " . implode(' OR ', $where_clauses));
        $comics->execute($where_params);
    }
} else {
    $comics = return_comic_published($limit, $offset);
}
$contador = 0;
$total_comics = numComics();

while ($data_comic = $comics->fetch(PDO::FETCH_ASSOC)) {
    $id = $data_comic['IDcomic'];
    $numero = $data_comic['numComic'];
    $titulo = $data_comic['nomComic'];
    $numComic = $data_comic['numComic'];
    $variante = $data_comic['nomVariante'];
    $fecha = $data_comic['date_published'];
    echo "<li id='comicyXwd2' class='get-it'><a href='infoComic.php?IDcomic=$id' title='$titulo - Variante: $variante / $numComic' class='title'>
        <span class='cover'>";
    echo "<img src='./assets/covers_img/$id.jpg' alt='$titulo - $variante / #$numComic'> ";
    echo "</span>
        <strong>$titulo</strong>
        <span class='issue-number issue-number-l1'>$numComic</span>
        </a>
        <button data-item-id='yXwd2' class='add'><span class='sp-icon'>Lo tengo</span></button>
        </li>";
    $contador++;
    if ($contador % 10 === 0) {
        echo "<ul></ul>";
    }
}
