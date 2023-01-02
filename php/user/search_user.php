<?php
session_start();
include_once '../inc/header.inc.php';

if (isset($_POST['input'])) {

    $input = $_POST['input'];
    $count = countUserSearch($input);
    if ($count > 0) {
?>
        <div style="margin-left: auto; margin-right: auto; width: 80%">
            <div class="card-body">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <td>Imagen de perfil</td>
                            <td>Nombre</td>
                            <td>Correo</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <?php
                                $registros = searchUser($input);
                                $user = $registros->fetch();
                                while ($user != null) {
                                ?>
                        <tr>
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <td><input type="hidden" name="avatarUser"> <input type="image" src="<?php echo $user['userPicture'] ?>" class="avatarPicture" name="avatarUser" id="avatar" alt="Avatar" style="width: 100px; height: 100px; border-radius: 50%;"></td>
                                <input type='hidden' name='emailUser' id='emailUser' value='<?php echo $user['email'] ?>'>
                            </form>
                            <td id='nameUser' name='nameUser'><?php echo $user['userName'] ?></td>
                            <td id='emailUser' name='emailUser'><?php echo $user['email'] ?></td>

                        <?php

                                    echo "</tr>";
                                    $user = $registros->fetch();
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