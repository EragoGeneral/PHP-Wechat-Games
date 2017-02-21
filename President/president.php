<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //header( "Content-Type:text/html; charset=UTF-8 ");
    //�������ͼ������
    header("content-type:image/png");
    
    $basePath = dirname(__FILE__).'/';
    
    $name = $_POST['name'];
    $message = $_POST['message'];
    
    
    //������Ƭ
    $im = imagecreatefrompng("img/president.png");
    //�����ֶ���ɫΪ��ɫ
    $textcolor = imagecolorallocate($im, 8, 9, 9);
    //�������� 
    $fnt = "font/QNHGJHC.TTF";
    //����������崮
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
    
    //дTTF���ֵ�ͼ��
    imagettftext($im, 24, -5, 360, 330, $textcolor, $fnt, $text);
    imagettftext($im, 24, -5, 330, 400, $textcolor, $fnt, $text1);
    
    $logo = imagecreatefrompng("img/qcode.png");
    imagecopy($im,$logo,335,450,0,0,60,60);
    
    //���� jpeg ͼ��
    imagepng($im, $basePath.$savefile);
    //�ͷ���Դ
    imagedestroy($im);
    
    echo $savefile;
}else{
    echo -1;
}
?>