<?php
// if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = 'ľľ'; //$_POST['name'];
    $message = '�й���ǿ��'; //$_POST['message'];
    
    $basePath = dirname(__FILE__).'/'; 
    
    header( "Content-Type:text/html; charset=UTF-8 ");
    //�������ͼ������
    header("content-type:image/png");
    //������Ƭ
    $im = imagecreatefrompng("img/president.png");
    //�����ֶ���ɫΪ��ɫ
    $textcolor = imagecolorallocate($im, 8, 9, 9);
    //�������� 
    $fnt = "font/QNHGJHC.TTF";
    //����������崮
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
    
    //дTTF���ֵ�ͼ��
    imagettftext($im, 24, -5, 380, 330, $textcolor, $fnt, $text);
    imagettftext($im, 24, -5, 350, 400, $textcolor, $fnt, $text1);
    
    //���� jpeg ͼ��
    imagepng($im, $basePath.$savefile);
    
    //�ͷ���Դ
    imagedestroy($im);
    
    echo $savefile;
// }else{
//     echo -1;
// }

?>