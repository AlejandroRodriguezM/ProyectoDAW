<?php
session_start();
include_once '../inc/header.inc.php';

if (isset($_POST['input'])) {
    $input = $_POST['input'];
    $countComics = countComicSearch($input);
    $countUsers = countUserSearch($input);
    if ($countComics > 0 || $countUsers > 0) {
?>
        <div style="margin-left: auto; margin-right: auto; width: 80%">
            <div class="card-body">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <td>Imagen</td>
                            <td>Tipo</td>
                            <td>Nombre</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <?php
                                if ($countComics > 0) {
                                    $registros = search_comics($input);
                                    $comics = $registros->fetch();
                                    while ($comics != null) {
                                ?>
                        <tr>
                            <td>
                                <a href="infoComic.php?IDcomic=<?php echo $comics['IDcomic']; ?>">
                                    <img src="<?php echo $comics['Cover']; ?>" alt="profile picture" class="avatarPicture" name="avatarUser" id="avatar" alt="Avatar" style="width: 100px; height: 100px; border-radius: 50%;">
                                </a>
                            </td>
                            <td>Comic</td>
                            <td><?php echo $comics['nomComic']; ?></td>
                            <input type='hidden' name='IDcomic' id='IDcomic' value='<?php echo $comics['IDcomic'] ?>'>
                        </tr>
                    <?php
                                        $comics = $registros->fetch();
                                    }
                                }
                                if ($countUsers > 0) {
                                    $registros = search_user($input);
                                    $user = $registros->fetch();
                                    while ($user != null) {
                    ?>
                        <tr>
                            <td>
                                <a href="infoUser.php?userName=<?php echo $user['userName']; ?>">
                                    <img src="<?php echo $user['userPicture']; ?>" alt="profile picture" class="avatarPicture" name="avatarUser" id="avatar" alt="Avatar" style="width: 100px; height: 100px; border-radius: 50%;">
                                </a>
                            </td>
                            <td>Usuario</td>
                            <input type='hidden' name='emailUser' id='emailUser' value='<?php echo $user['email'] ?>'>
                            <td id='nameUser' name='nameUser'><?php echo $user['userName'] ?></td>
                        </tr>
                <?php
                                        $user = $registros->fetch();
                                    }
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
