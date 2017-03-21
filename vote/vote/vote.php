<?php

include 'dbconn.php';

$article_id = $_POST['id'];

mysqli_select_db($conn, "drawing_vote");

$usql = "update article set vote_num = vote_num + 1 where id = $article_id";
mysqli_query($conn, $usql);

$sql = "SELECT id, vote_num from article where id = $article_id";
$result = mysqli_query($conn, $sql);
$article = mysqli_fetch_array($result);

// 此处需要添加验证：同一IP地址只能对同一作品投五次票


$json_array = array(
    "id" => $article_id,
    "voteNum" => $article['vote_num'],
    "flag" => "1"
);
mysqli_close($conn);

$json_obj = json_encode($json_array);
echo $json_obj;

?>