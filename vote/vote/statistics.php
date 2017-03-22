<?php
    include 'dbconn.php';
    include 'commonutil.class.php';
    
    if(isset($_GET['visitor'])){
        $calVisitor = '1';
    }else{
        $calVisitor = '0';
    }
    
    mysqli_query($conn, "set names 'utf8'");
    mysqli_select_db($conn, "drawing_vote");
    
    if($calVisitor == '1'){
       $opIP = CommonUtil::getIP(); 
       $addsql = "insert into operation_log(op_type, op_IP, op_time, is_deleted) values('visit', '$opIP', SYSDATE(), '0')";
    }
    
    //统计参加作品数
    $sql = "select id from article";
    $article_result = mysqli_query($conn, $sql);
    $article_count = mysqli_num_rows($article_result);
    
    //统计参与者
    $sql = "SELECT COUNT(author) FROM article GROUP BY author";
    $attender_result = mysqli_query($conn, $sql);
    $attender_count = mysqli_num_rows($attender_result);
    
    //统计访问者
    $sql = "SELECT id FROM operation_log WHERE op_type = 'visit' AND is_deleted = '0'";
    $visitor_result = mysqli_query($conn, $sql);
    $visitor_count = mysqli_num_rows($visitor_result);
    
    mysqli_close($conn);
    
    $json_obj = json_encode(array('article_count' => $article_count, 'attender_count' => $attender_count, 'visitor_count' => $visitor_count,));
    echo $json_obj;
?>