<?php
//header('Content-type: image/png');
//mb_internal_encoding("UTF-8");
header("Content-type:text/html;charset=utf-8");
$img = imagecreatetruecolor(400, 200);
$width = 400;
$height = 200;
// $radio = $width/$height;
$white = imagecolorallocate($img, 255, 255, 255);
$fontfile = 'font/msyhbd.ttf';

$text = '没有时间。没有时间。没有时间。没有时间。没有时间。没有时间。';
$text_len = mb_strwidth($text)/2; // 这是中文字符的个数
echo "text_len=" . $text_len . "<br />";
// $text_str =mb_strlen($text);
// echo "text_str=".$text_str."<br />";

/* $x = sqrt($text_len); // 获得一个初始的字数安排
echo "x=" . $x . "<br />";

$px = ceil($width / (2 * $x)); // 获得一个初始的像素
echo "px=" . $px . "<br />";

$fontsize = ceil($px * 72 / 96); // 获得一个初始的字体磅值
echo "fontsize=" . $fontsize . "<br />";

function autowrap($fontsize, $angle, $fontface, $string, $width)
{
    // 这几个变量分别是 字体大小, 角度, 字体名称, 字符串, 预设宽度
    $content = "";
    
    // 将字符串拆分成一个个单字 保存到数组 letter 中
    for ($i = 0; $i < mb_strlen($string); $i ++) {
        $letter[] = mb_substr($string, $i, 1);
    }
    foreach ($letter as $l) {
        $teststr = $content . " " . $l;
        $testbox = imagettfbbox($fontsize, $angle, $fontface, $teststr); // 这个里面是磅值
                                                                         // 判断拼接后的字符串是否超过预设的宽度
        if ((($testbox[2] - $testbox[0]) > $width) && ($content !== "")) {
            $content .= "\n";
        }
        $content .= $l;
    }
    return $content;
}

$a = autowrap($fontsize, 0, $fontfile, $text, $width);
$text_change = $a;
// $line_numbers = $a[1];

$text_fontBox = imagettfbbox($fontsize, 0, $fontfile, $text_change);
$text_height = $text_fontBox[1] - $text_fontBox[7];
$text_width = $text_fontBox[2] - $text_fontBox[0];

while ($text_height > $height || $text_height < ($height - round($fontsize * 96 / 72) * 1.8)) {
    if ($text_height > $height) {
        $fontsize = $fontsize - 1;
    } elseif ($text_height < ($height - round($fontsize * 96 / 72) * 1.8)) {
        $fontsize = $fontsize + 1;
    }
    $a = autowrap($fontsize, 0, $fontfile, $text, $width);
    $text_fontBox = imagettfbbox($fontsize, 0, $fontfile, $text_change);
    $text_height = $text_fontBox[1] - $text_fontBox[7];
    $text_width = $text_fontBox[2] - $text_fontBox[0];
}
$text_width = $text_fontBox[2] - $text_fontBox[0];
if ($text_width > $width || $width - $text_width > $fontsize * 96 / 72 * 1.2) {
    $fontsize = $fontsize - 2;
}
echo "最终的字体大小:" . $fontsize . "<br />";
imagettftext($img, $fontsize, 0, 0, (imagettfbbox($fontsize, 0, $fontfile, "的")[1] - imagettfbbox($fontsize, 0, $fontfile, "的")[7]), $white, $fontfile, $text_change);

$name = time().rand(0, 1000);

imagejpeg($img, './' . $name . '.jpg');
imagedestroy($img); */

?> 