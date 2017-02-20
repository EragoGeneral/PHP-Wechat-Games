<?php
header( "Content-Type:text/html; charset=UTF-8 ");
//定义输出图像类型
header("content-type:image/jpeg");
//载入照片
$im = imagecreatefromjpeg("img/toutu.jpg");
//设置字段颜色为蓝色
$textcolor = imagecolorallocate($im, 8, 9, 9);
//定义字体 
$fnt = "font/QNHGJHC.TTF";
//定义输出字体串
$text = iconv("GBK", "UTF-8", "林汉锐");
$text1 = iconv("GBK", "UTF-8", "中国最强大脑");
//echo $text;

//写TTF文字到图中
imagettftext($im, 24, -5, 380, 330, $textcolor, $fnt, $text);
imagettftext($im, 24, -5, 350, 400, $textcolor, $fnt, $text1);

//建立 jpeg 图形
imagejpeg($im);
//释放资源
imagedestroy($im);

?>