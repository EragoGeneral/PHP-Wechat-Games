<?php
    include 'dbconn.php';
    
    $article_id = $_POST['id'];
    $status = $_POST['status'];
    
    mysqli_select_db($conn, 'drawing_vote');
    
    $sql = "update article set is_passed = $status, pass_time = SYSDATE() where id = $article_id";
    
    mysqli_query($conn, $sql);
    
    $flag = false;
    if(mysqli_affected_rows($conn)){
        $flag = true;   
    }
    
    mysqli_close($conn);
    
    $json_obj = json_encode(array('flag' => $flag));
    echo $json_obj;
?>