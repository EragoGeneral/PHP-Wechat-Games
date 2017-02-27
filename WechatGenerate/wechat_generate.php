<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //header( "Content-Type:text/html; charset=UTF-8 ");
    //定义输出图像类型
    header("content-type:image/png");
    
    $basePath = dirname(__FILE__).'/';
    
    $name = $_POST['name'];
    $mingxing = $_POST['mingxing'];
    
    //echo $name;
    //echo $mingxing;
    
    //载入照片
    $im = imagecreatefromjpeg("img/".$mingxing.".jpg");
    //设置字段颜色为蓝色
    $textcolor = imagecolorallocate($im, 252, 252, 252);
    //定义字体 
    $fnt = "font/QNHGJHC.TTF";
    $fnt1 = "font/DroidSansFallback.ttf";
    //定义输出字体串
    $text = $name; //iconv("GBK", "UTF-8", $name);
    $text1 = $mingxing; //iconv("GBK", "UTF-8", $message);
    //echo $text;
    
    $savepath = 'img/'.date('Ym');
    $savename = md5($name.$mingxing).'.png';
    $savefile = $savepath .'/'. $savename;
    
    if(!is_dir($basePath.$savepath)){
        mkdir($basePath.$savepath,0777,true);
    }
    if(file_exists($savefile)){
        echo $savefile;
        exit();
    }
    
    $curDate = date('m')."月".date("d")."日";
    $curTime = date('H').":".date("i");
    //echo $curDate;

    imagettftext($im, 108, 0, 140, 220, $textcolor, $fnt1, $curTime);
    imagettftext($im, 24, 0, 240, 290, $textcolor, $fnt1, $curDate);
    //写TTF文字到图中
    if($mingxing == "wyf"){
        imagettftext($im, 20, 0, 290, 840, $textcolor, $fnt1, $name);
    }elseif ($mingxing == "my"){
        imagettftext($im, 20, 0, 360, 840, $textcolor, $fnt1, $name);
    }else {
        imagettftext($im, 20, 0, 425, 840, $textcolor, $fnt1, $name);
    }
    
    $logo = imagecreatefrompng("img/qcode.png");
    imagecopy($im,$logo,520,950,0,0,100,100);
    
    //建立 jpeg 图形
    imagepng($im, $basePath.$savefile);
    //释放资源
    imagedestroy($im);
    
    echo $savefile;
}else{
    echo -1;
}
?>