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
    <tr style="background-color:rgb(77,81,84)">
        <td>
            <a href="infoComic.php?IDcomic=<?php echo $id_comic; ?>">
                <img src="<?php echo $cover ?>" alt="profile picture" class="avatarPicture" name="avatarComic" id="avatar" alt="Avatar" style="width: 140px; height: 210px; border-radius: 0;">
            </a>
        </td>
        <td>
            <div>
                <?php
                $titulo = str_replace(' ', ' ', $titulo);
                echo "<span class='comic-value'>
                <a href='infoComic.php?IDcomic=" . urlencode(trim($id_comic)) . "'>$titulo</a>
                </span>";
                ?>
            </div>
        </td>
        <td><?php echo $numero ?></td>
        <td>
            <div>
                <?php
                $variantes = explode('-', $variante);
                foreach ($variantes as $variante) {
                    echo "<span class='comic-value'><a href='search_data.php?search=" . urlencode(trim($variante)) . "'>" . $variante . "</a></span>";
                }
                ?>
            </div>
        </td>
        <td>
            <div>
                <?php
                $nomEditorial = str_replace(' ', '-', $editorial);
                echo "<span class='comic-value'><a href='search_data.php?search=$nomEditorial'>$nomEditorial</a></span>";
                ?>
            </div>
        </td>
        <td>
            <div>
                <?php
                $formato = str_replace(' ', '-', $formato);
                echo "<span class='comic-value'><a href='search_data.php?search=$formato'>$formato</a></span>";
                ?>
            </div>
        </td>
        <td>
            <div>
                <?php
                $procedencia = str_replace(' ', '-', $procedencia);
                echo "<span class='comic-value'><a href='search_data.php?search=$procedencia'>$procedencia</a></span>";
                ?>
            </div>
        </td>
        <td>
            <div>
                <?php
                echo "<span class='comic-value'><a href='search_data.php?search=$fecha'>$fecha</a></span>";
                ?>
            </div>
        </td>
        <td>
            <div>
                <?php
                $guionistas = explode('-', $guionista);
                foreach ($guionistas as $guionista) {
                    echo "<span class='comic-value'><a href='search_data.php?search=" . urlencode(trim($guionista)) . "'>" . $guionista . "</a></span>";
                }
                ?>
            </div>
        </td>
        <td>
            <div>
                <?php
                $dibujantes = explode('-', $dibujante);
                foreach ($dibujantes as $dibujante) {
                    echo "<span class='comic-value'><a href='search_data.php?search=" . urlencode(trim($dibujante)) . "'>" . $dibujante . "</a></span>";
                }
                ?>
            </div>
        </td>
        <input type='hidden' name='IDcomic' id='IDcomic' value='<?php echo $id_comic ?>'>
    <?php

    echo "</tr>";
}
    ?>