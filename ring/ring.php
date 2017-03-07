<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){    
    //定义输出图像类型
    header("content-type:image/jpeg");
    
    $basePath = dirname(__FILE__).'/';
    
    $name = $_POST['name'];
    $index = $_POST['option'];
    
    $textOptions = array("陪伴是最长情的告白，我想陪你一辈子。", "我希望以后可以不用送你回家，而是和你一起回家。",
    "只要和你在一起就是我今生最大的幸福。","乘风破浪, 幸福的航行。亲爱的，嫁给我吧！","我想有个家，一个有你的家，嫁给我吧!");
    $message = $textOptions[$index-1];
    
    //载入照片
    $im = imagecreatefromjpeg("img/ring.jpg");
    //设置字段颜色为蓝色
    $textcolor = imagecolorallocate($im, 8, 9, 9);
    //定义字体 
    $fnt = "font/MNJYBHS.TTF";
    //定义输出字体串
    $text = $name; //iconv("GBK", "UTF-8", $name);
    $text1 = $message; //iconv("GBK", "UTF-8", $message);
    
    $savepath = 'img/'.date('Ym');
    $savename = md5($name.$message).'.jpg';
    $savefile = $savepath .'/'. $savename;
    
    if(!is_dir($basePath.$savepath)){
        mkdir($basePath.$savepath,0777,true);
    }
    if(file_exists($savefile)){
        echo $savefile;
        exit();
    }
    
    //写TTF文字到图中
    $row1 = substr($text1, 0, 30);
    $row2 = substr($text1, 30, strlen($text1));
    imagettftext($im, 10, 0, 40, 55, $textcolor, $fnt, $text);
    imagettftext($im, 10, 0, 40, 80, $textcolor, $fnt, $row1);
    imagettftext($im, 10, 0, 40, 100, $textcolor, $fnt, $row2);
    
    $logo = imagecreatefrompng("img/qcode.png");
    imagecopy($im,$logo,255,195,0,0,60,60);
    
    //建立 jpeg 图形
    imagejpeg($im, $basePath.$savefile);
    //释放资源
    imagedestroy($im);
    
    echo $savefile;
}else{
    echo -1;
}
?>