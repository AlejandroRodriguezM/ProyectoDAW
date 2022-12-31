<?php
session_start();
include_once '../inc/header.inc.php';

if (isset($_POST['input'])) {

    $input = $_POST['input'];
    $count = countUserSearch($input);
    if ($count > 0) {
?>
        <table class="table table-bordered table-striped mt-4">
            <thead class="table-dark">
                <tr>
                    <td>Imagen de perfil</td>
                    <td>Nombre</td>
                    <td>Correo</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $registros = searchUser($input);
                $user = $registros->fetch();
                while ($user != null) {
                ?>
                    <tr>
                        <td><input type="hidden" name="avatarUser"><input type="image" src="<?php echo $user['userPicture'] ?>" class="avatarPicture" name="avatarUser" id="avatar" alt="Avatar" style="width: 100px; height: 100px; border-radius: 50%;"></td>
                        <td><?php echo $user['userName']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                    </tr>
                <?php
                    $user = $registros->fetch();
                }

                ?>
        </table>
<?php
    } else {
        echo "<h6 class='text-danger text-center mt-3 >No data found</h6>";
    }
}

?>