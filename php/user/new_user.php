<?php

require_once '../inc/header.inc.php';

$validate['success'] = array('success'=>false, 'message'=>"");

if($_POST){
    $email = $_POST['email'];
    $password = md5($_POST['pass']);
    $userName = $_POST['userName'];

    $sql = "SELECT * FROM user where Email = '$email'";
    $result = $conection->query($sql);
	if ($result->fetchColumn()) {
		$validate['success'] = false;
        $validate['message'] = 'ERROR. The email is used';
	}else{
        try{
            $insertData = $conection->prepare("INSERT INTO user VALUES(null,'$userName','$password','$email')");
            $insertData->execute();
            $count = $insertData->rowCount();
            if($count != 0){
                $validate['success'] = true;
                $validate['message'] = 'The user save correctly';
            }else{
                $validate['success'] = false;
                $validate['message'] = 'ERROR. The user dont save correctly';
            }
        }
        catch(PDOException $e){
            $error_Code = $e->getCode();
            $message = $e->getMessage();
            die("Code: " . $error_Code . "\nMessage: " . $message);
        }
        
    }
}else{
    $validate['success'] = false;
    $validate['message'] = 'ERROR. The user is not save in database';
}
echo json_encode($validate);

?>