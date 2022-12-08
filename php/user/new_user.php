<?php

require_once '../inc/header.inc.php';

$validate['success'] = array('success'=>false, 'message'=>"");


if($_POST){
    
    $userName = $_POST['userName'];
    $password = md5($_POST['pass']);
    $email = $_POST['email'];
    $image = $_POST['userPicture'];
    $blob = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image));

    // print_r($imageBlob);

    $sql = "SELECT * FROM user where Email = '$email'";
    $result = $conection->query($sql);
	if ($result->fetchColumn()) {
		$validate['success'] = false;
        $validate['message'] = 'ERROR. The email is used';
	}else{
        try{
            $insertData = $conection->prepare("INSERT INTO user (UserName,Pass,Email,userPicture) VALUES(?,?,?,?)");
            $insertData->bindParam(1, $userName);
            $insertData->bindParam(2, $password);
            $insertData->bindParam(3, $email);
            $insertData->bindParam(4, $blob);

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