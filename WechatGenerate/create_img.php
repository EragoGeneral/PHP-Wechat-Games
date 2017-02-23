<?php
// if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = '木木'; //$_POST['name'];
    $message = '中国最强音'; //$_POST['message'];
    
    $basePath = dirname(__FILE__).'/'; 
    
    header( "Content-Type:text/html; charset=UTF-8 ");
    //定义输出图像类型
    header("content-type:image/png");
    //载入照片
    $im = imagecreatefrompng("img/president.png");
    //设置字段颜色为蓝色
    $textcolor = imagecolorallocate($im, 8, 9, 9);
    //定义字体 
    $fnt = "font/QNHGJHC.TTF";
    //定义输出字体串
    $text = iconv("GBK", "UTF-8", $name);
    $text1 = iconv("GBK", "UTF-8", $message);
//     echo $text;
//     echo $text1;
    
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
    imagettftext($im, 24, -5, 380, 330, $textcolor, $fnt, $text);
    imagettftext($im, 24, -5, 350, 400, $textcolor, $fnt, $text1);
    
    //建立 jpeg 图形
    imagepng($im, $basePath.$savefile);
    
    //释放资源
    imagedestroy($im);
    
    echo $savefile;
// }else{
//     echo -1;
// }

?>