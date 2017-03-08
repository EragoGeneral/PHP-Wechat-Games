<?php
header("Content-type:text/html;charset=utf-8");
include 'article_obj.php';


$loadIndex = $_POST['load_index'];
// $age = $_POST['age'];
// $job = $_POST['job'];

// $json_arr = array(
//     "index" => $article->getIndex(),
//     "path" => $article->getPath()
// );

$json_array = [];
$loadIndex = ($loadIndex-1)*10+1;
for($i=$loadIndex; $i<$loadIndex+10;$i++){
    $article = new Article();
    $article->setIndex($i);
    $article->setPath("http://localhost:8082/PHP-Wechat-Games/vote/vote/images/drawing/$i.jpg");
    //echo $article->getPath();
    $json_arr = array(
        "index" => $article->getIndex(),
        "path" => $article->getPath()
    );
    array_push($json_array, $json_arr);
}
//echo $json_array;

//$json_obj = json_encode(array('list'=>$json_array));
$json_obj = json_encode(array('list'=>$json_array));
echo $json_obj;
?>