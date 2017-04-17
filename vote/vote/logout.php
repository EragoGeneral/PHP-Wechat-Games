<?php

if(isset($_POST['sessionUser'])){
    $sessionUser = $_POST['sessionUser'];
    session_start();
    $flag = false; 
    if($sessionUser == $_SESSION['login_name']){
        $_SESSION['user_id'] = '0';
        $_SESSION['login_name'] = '';
        
        $flag = true;
    }
    $json_obj = json_encode(array('flag' => $flag));
    echo $json_obj;
}

?>