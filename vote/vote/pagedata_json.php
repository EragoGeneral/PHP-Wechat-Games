<?php
header("Content-type:text/html;charset=utf-8");
include 'article_obj.php';

$host = '139.199.191.210';
$user_name = 'root';
$password = 'root';

$conn = mysqli_connect($host, $user_name, $password);

if(!$conn){
    die('数据库连接失败: '.mysql_error());
}

//echo "数据库连接成功!";

mysqli_select_db($conn, "drawing_vote");

$sql = "select id from article where is_deleted = '0' and is_passed = '1'";
$result = mysqli_query($conn, $sql);
$total = mysqli_num_rows($result);

//允许最多加载次数
$loadtimes = $total/10;

$loadIndex = $_POST['load_index'];

// $age = $_POST['age'];
// $job = $_POST['job'];

// $json_arr = array(
//     "index" => $article->getIndex(),
//     "path" => $article->getPath()
// );

$json_array = [];
$flag='';
$msg='';
if($loadIndex>$loadtimes){
    $flag = '0';
    $msg = '图片已全部显示';
}else{
    $loadIndex = $loadIndex*10;
    
    mysqli_query($conn, "set names 'utf8'");
    $sql = "SELECT a.id, a.code, a.name, a.path FROM article a WHERE is_deleted = '0' and is_passed = '1' LIMIT $loadIndex, 10";
    $result = mysqli_query($conn, $sql);
    
    if($num = mysqli_num_rows($result)){
        while ($row = mysqli_fetch_array($result)){
            $article = new Article();
            $article->setIndex($row['code']);
            $article->setPath($row['path']); //("http://localhost:8082/Projects/vote/vote/images/drawing/$imgIdx.jpg");
            $article->setName($row['name']);
            $json_arr = array(
                "index" => $article->getIndex(),
                "path" => $article->getPath(),
                "name" => $article->getName(),
                "detail" => "http://vote.wxsxz117.cc/vote/article_detail.php?id=".$row['id']
            );
            array_push($json_array, $json_arr);
        }
    }
//     for($i=$loadIndex; $i<$loadIndex+10;$i++){
//         $article = new Article();
//         $imgIdx = $i+1;
//         $article->setIndex($imgIdx);
//         $article->setPath("http://localhost:8082/Projects/vote/vote/images/drawing/$imgIdx.jpg");
//         $json_arr = array(
//             "index" => $article->getIndex(),
//             "path" => $article->getPath()
//         );
//         array_push($json_array, $json_arr);
//     } 
    $flag = '1';
    $msg = '';
}
mysqli_close($conn);

//echo $json_array;

//$json_obj = json_encode(array('list'=>$json_array));
$json_obj = json_encode(array('list'=>$json_array,'flag'=>$flag,'msg'=>$msg));
echo $json_obj;
?>