<?php
    include '../dbconn.php';
    if (isset($_POST['rid'])) {
        $id = $_POST['rid'];
        mysqli_select_db($conn, 'drawing_vote');
        $sql = "update reward set is_deleted = '1' where id = $id";
        mysqli_query($conn, $sql);
        
        $flag = false;
        if (mysqli_affected_rows($conn)) {
            $flag = true;
        }
        
        mysqli_close($conn);
        
        $json_obj = json_encode(array(
            'flag' => $flag
        ));
        echo $json_obj;
    }

?>