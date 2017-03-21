<?php
include 'dbconn.php';

session_start();

$article_name = $_POST['article_name'];
$declaration = $_POST['declaration'];
$file = $_SESSION['1123_article_path'];

if(empty($article_name) || empty($declaration)){
    echo '请填写用户名和宣言!<a href="upload_article.html">返回/a>';
    exit;
}

mysqli_select_db($conn, 'drawing_vote');

$sql = "INSERT INTO article(NAME, path, author, publish_time, declaration, vote_num, is_passed, created_time, created_by, updated_time, updated_by, is_deleted)"
    ."values('".$article_name."', '".$file."', 1123, SYSDATE(), '".$declaration."', 0, '0', SYSDATE(), 1123, SYSDATE(), 1123, '0')";

mysqli_query($conn, $sql);
$article_id=mysqli_insert_id($conn);

$usql = "update article set code = $article_id where id = $article_id";
mysqli_query($conn, $usql);

mysqli_close($conn);

echo '<div style="padding-top:50px;text-align:center;font-size:16px;"><a href="article_detail.php?id='.$article_id.'">作品发布成功,请耐心等待管理员审批</a></div>';
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title>保存作品</title>
<link href="css/bootstrap.min.css" rel="stylesheet">  
<script src="js/jquery-1.7.2.min.js"></script>  
</head>
<body>
</body>
</html>
