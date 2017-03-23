<?php

include 'dbconn.php';
include 'commonutil.class.php';

session_start();
if(isset($_SESSION['user_id'])){
    $sessionUserId = $_SESSION['user_id'];
}else{
    $sessionUserId = 0;
}

$article_id = $_POST['id'];

mysqli_select_db($conn, "drawing_vote");

// 此处需要添加验证：同一IP地址只能对同一作品投五次票
$util = new CommonUtil();
$ip = $util->getIP();

$checkSql = "select * from operation_log where article_id = $article_id and is_deleted = '0' and op_IP = '$ip' and DATEDIFF(op_time, SYSDATE()) = 0";
$chk_result = mysqli_query($conn, $checkSql);
$chk_count = mysqli_num_rows($chk_result);

$sql = "SELECT id, vote_num from article where id = $article_id";
$result = mysqli_query($conn, $sql);
$article = mysqli_fetch_array($result);

if($chk_count >= 5){
    $voteNum = $article['vote_num'];
    $info = '一天只能对同一个作品投5票';
    $flag = '0';
}else{
    $usql = "update article set vote_num = vote_num + 1 where id = $article_id";
    mysqli_query($conn, $usql);
    
    $logSql = "insert into operation_log(user_id, article_id, op_type, op_IP, op_time, is_deleted) values($sessionUserId, $article_id, 'vote', '$ip', SYSDATE(), '0')";
    mysqli_query($conn, $logSql);
    
    $voteNum = $article['vote_num'];
    $info = '投票成功';
    $flag = '1';
} 
$json_array = array(
    "id" => $article_id,
    "voteNum" => $voteNum,
    "flag" => $flag,
    "info" => $info
);
mysqli_close($conn);
$json_obj = json_encode($json_array);
echo $json_obj;
?>