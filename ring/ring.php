<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //header( "Content-Type:text/html; charset=UTF-8 ");
    //�������ͼ������
    header("content-type:image/jpeg");
    
    $basePath = dirname(__FILE__).'/';
    
    $name = $_POST['name'];
    $message = '1234';//$_POST['option'];
    
    
    //������Ƭ
    $im = imagecreatefromjpeg("img/icon.jpg");
    //�����ֶ���ɫΪ��ɫ
    $textcolor = imagecolorallocate($im, 8, 9, 9);
    //�������� 
    $fnt = "font/QNHGJHC.TTF";
    //����������崮
    $text = $name; //iconv("GBK", "UTF-8", $name);
    $text1 = $message; //iconv("GBK", "UTF-8", $message);
    //echo $text;
    
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
    
    //дTTF���ֵ�ͼ��
    imagettftext($im, 12, -5, 30, 30, $textcolor, $fnt, $text);
    imagettftext($im, 12, -5, 130, 130, $textcolor, $fnt, $text1);
    
    $logo = imagecreatefrompng("img/qcode.png");
    imagecopy($im,$logo,235,250,0,0,60,60);
    
    //���� jpeg ͼ��
    imagejpeg($im, $basePath.$savefile);
    //�ͷ���Դ
    imagedestroy($im);
    
    echo $savefile;
}else{
    echo -1;
}
?>