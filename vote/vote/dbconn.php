<?php
$host = '139.199.191.210';
$user_name = 'root';
$password = 'root';

$conn = mysqli_connect($host, $user_name, $password);
if(!$conn){
    die('���ݿ�����ʧ��: '.mysql_error());
}
mysqli_query($conn, "set names 'utf8'");

?>