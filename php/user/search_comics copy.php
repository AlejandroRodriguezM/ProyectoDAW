<?php
session_start();
include_once '../inc/header.inc.php';

if (isset($_POST['input'])) {

    $input = $_POST['input'];
    $count = countComicSearch($input);
    if ($count > 0) {
?>
        <div style="margin-left: auto; margin-right: auto; width: 80%">
            <div class="card-body">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <td>Portada</td>
                            <td>Nombre del comic</td>
                            <td>Numero</td>
                            <td>Variante</td>
                            <td>Editorial</td>
                            <td>Formato</td>
                            <td>Procedencia</td>
                            <td>Fecha de publicacion</td>
                            <td>Nombre del guionista</td>
                            <td>Nombre del dibujante</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <?php
                                $registros = search_comics($input);
                                $comics = $registros->fetch();
                                while ($comics != null) {
                                ?>
                        <tr>
                            <td>
                                <a href="searchInfoComic.php?IDcomic=<?php echo $comics['IDcomic']; ?>">
                                    <img src="<?php echo $comics['Cover']; ?>" alt="profile picture" class="avatarPicture" name="avatarUser" id="avatar" alt="Avatar" style="width: 100px; height: 100px; border-radius: 50%;">
                                </a>
                            </td>
                            <td><?php echo $comics['nomComic']; ?></td>
                            <td><?php echo $comics['numComic']; ?></td>
                            <td><?php echo $comics['nomVariante']; ?></td>
                            <td><?php echo $comics['nomEditorial']; ?></td>
                            <td><?php echo $comics['Formato']; ?></td>
                            <td><?php echo $comics['Procedencia']; ?></td>
                            <td><?php echo $comics['date_published']; ?></td>
                            <td><?php echo $comics['nomGuionista']; ?></td>
                            <td><?php echo $comics['nomDibujante']; ?></td>
                            <input type='hidden' name='IDcomic' id='emailUser' value='<?php echo $comics['IDcomic'] ?>'>
                        <?php

                                    echo "</tr>";
                                    $comics = $registros->fetch();
                                }
                        ?>
                        </form>
                        </tr>
                    </tbody>
                </table>
                <h5 class="card-title"></h5>
                <p class="card-text"></p>
            </div>
        </div>
<?php
    } else {
        echo "<h6 class='text-danger text-center mt-3 >No data found</h6>";
    }
}

?>