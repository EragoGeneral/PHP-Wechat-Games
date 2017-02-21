<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //header( "Content-Type:text/html; charset=UTF-8 ");
    //定义输出图像类型
    header("content-type:image/png");
    
    $basePath = dirname(__FILE__).'/';
    
    $name = $_POST['name'];
    $message = $_POST['message'];
    
    
    //载入照片
    $im = imagecreatefrompng("img/president.png");
    //设置字段颜色为蓝色
    $textcolor = imagecolorallocate($im, 8, 9, 9);
    //定义字体 
    $fnt = "font/QNHGJHC.TTF";
    //定义输出字体串
    $text = $name; //iconv("GBK", "UTF-8", $name);
    $text1 = $message; //iconv("GBK", "UTF-8", $message);
    //echo $text;
    
    $savepath = 'img/'.date('Ym');
    $savename = md5($name.$message).'.png';
    $savefile = $savepath .'/'. $savename;
    
    if(!is_dir($basePath.$savepath)){
        mkdir($basePath.$savepath,0777,true);
    }
    if(file_exists($savefile)){
        echo $savefile;
        exit();
    }
    
    //写TTF文字到图中
    imagettftext($im, 24, -5, 360, 330, $textcolor, $fnt, $text);
    imagettftext($im, 24, -5, 330, 400, $textcolor, $fnt, $text1);
    
    $logo = imagecreatefrompng("img/qcode.png");
    imagecopy($im,$logo,335,450,0,0,60,60);
    
    //建立 jpeg 图形
    imagepng($im, $basePath.$savefile);
    //释放资源
    imagedestroy($im);
    
    echo $savefile;
}else{
    echo -1;
}
?>