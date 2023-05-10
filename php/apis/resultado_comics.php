<?php
include_once '../inc/header.inc.php';
global $conection;
$limit = intval($_GET['limit']);
$offset = intval($_GET['offset']);
$search = $_GET['search'];

$comics = return_comic_search($limit, $offset, $search);


$total_comics = numComics();
while ($data_comic = $comics->fetch(PDO::FETCH_ASSOC)) {
    $cover = $data_comic['Cover'];
    $titulo = $data_comic['nomComic'];
    $numero = $data_comic['numComic'];
    $variante = $data_comic['nomVariante'];
    $editorial = $data_comic['nomEditorial'];
    $formato = $data_comic['Formato'];
    $procedencia = $data_comic['Procedencia'];
    $fecha = $data_comic['date_published'];
    $guionista = $data_comic['nomGuionista'];
    $dibujante = $data_comic['nomDibujante'];
    $id_comic = $data_comic['IDcomic'];

?>
    <tr style="background-color:rgb(77,81,84); color:white;">
        <td class=="py-0" style="padding: 2;">
            <a href="infoComic.php?IDcomic=<?php echo $id_comic; ?>">
                <img src="<?php echo $cover ?>" alt="profile picture" class="img-fluid" style="border-radius: 0; max-width: 100px;">
            </a>
        </td>


        <td class="text-wrap">
            <div class="comic-value">
                <a href="infoComic.php?IDcomic=<?php echo urlencode(trim($id_comic)); ?>" style="color:white;">
                    <div class="d-inline-block text-truncate" style="max-width: 200px;"><?php echo $titulo; ?></div>
                </a>
            </div>
        </td>

        <td class="text-nowrap" style="color:white;" align="center"><?php echo $numero ?></td>

        <td class="d-none d-md-table-cell">
            <div>
                <?php
                $variantes = explode('-', $variante);
                foreach ($variantes as $variante) {
                    echo "<li><span class='comic-value'><a href='search_data.php?search=" . urlencode(trim($variante)) . "' style='color:white;'>" . $variante . "</a></span></li>";
                }
                ?>
            </div>
        </td>
        <td class="d-none d-md-table-cell" align="center">
            <div>
                <?php
                $nomEditorial = str_replace(' ', '-', $editorial);
                echo "<span class='comic-value'><a href='search_data.php?search=$nomEditorial' style='color:white;'>$nomEditorial</a></span>";
                ?>
            </div>
        </td>
        <td class="d-none d-md-table-cell" align="center">
            <div>
                <?php
                $formato = str_replace(' ', '-', $formato);
                echo "<span class='comic-value'><a href='search_data.php?search=$formato' style='color:white;'>$formato</a></span>";
                ?>
            </div>
        </td>
        <td class="d-none d-md-table-cell" align="center">
            <div>
                <?php
                $procedencia = str_replace(' ', '-', $procedencia);
                echo "<span class='comic-value'><a href='search_data.php?search=$procedencia' style='color:white;'>$procedencia</a></span>";
                ?>
            </div>
        </td>
        <td class="d-none d-md-table-cell" align="center">
            <div>
                <?php
                echo "<span class='comic-value'><a href='search_data.php?search=$fecha' style='color:white;'>$fecha</a></span>";
                ?>
            </div>
        </td>
        <td class="d-none d-md-table-cell">
            <div>
                <?php
                $guionistas = explode('-', $guionista);
                foreach ($guionistas as $guionista) {
                    echo "<li><span class='comic-value'><a href='search_data.php?search=" . urlencode(trim($guionista)) . "' style='color:white;'>" . $guionista . "</a></span></li>";
                }
                ?>
            </div>
        </td>
        <td class="d-none d-md-table-cell">
            <div>
                <?php
                $dibujantes = explode('-', $dibujante);
                foreach ($dibujantes as $dibujante) {
                    echo "<li><span class='comic-value'><a href='search_data.php?search=" . urlencode(trim($dibujante)) . "' style='color:white;'>" . $dibujante . "</a></span></li>";
                }
                ?>
            </div>
        </td>
        <input type='hidden' name='IDcomic' id='IDcomic' value='<?php echo $id_comic ?>'>
    <?php

    echo "</tr>";
}
    ?>