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
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <?php
                                $registros = search_comics($input);
                                while ($registros != null) {
                                ?>
                        <tr>
                            <td>
                                <a href="infoComic.php?IDcomic=<?php echo $comics['IDcomic']; ?>">
                                    <img src="<?php echo $comics['Cover']; ?>" alt="profile picture" class="avatarPicture" name="avatarUser" id="avatar" alt="Avatar" style="width: 100px; height: 100px; border-radius: 50%;">
                                </a>
                            </td>
                            <input type='hidden' name='IDcomic' id='emailUser' value='<?php echo $comics['IDcomic'] ?>'>
                            <td id='nameComic' name='nameComic'><?php echo $comics['nomComic']; ?></td>
                        <?php

                                    echo "</tr>";
                                    $registros = search_comics($input);
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