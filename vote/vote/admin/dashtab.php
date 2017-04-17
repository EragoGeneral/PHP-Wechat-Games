<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title>控制台</title>
<style>
    .text-box i.user-icon{
    	background-image: url(images/icons.png);
    	background-position: 10px 20px;
    }
</style>
<script src="../js/jquery-1.7.2.min.js"></script>
<style>
    .item{
        width: 33%;
        height: 120px;
        border-left: solid 1px #DEDEDE;
        border-bottom: solid 1px #dedede;
        background-color: #fff;
        float: left;
    }
    
    .item .name{text-align: center; width: 100%; display: inline-block; font-size: 1em; cursor: pointer;}
    
</style>


</head>

<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
       echo "<script>window.location.href='login.php';</script>";
    }

?>

<body style="background-color: #F2F4F3; margin:0px;">
    <div>
        <div class="item" onclick="javascript:window.location.href='reward.php';">
            <div style="text-align: center; padding: 10px;">
                <img src="../images/admin/reward.png" alt="" />
            </div>
            <span class="name">设置奖品</span>
        </div>
        <div class="item" onclick="javascript:window.location.href='rules.php';">
            <div style="text-align: center; padding: 10px;">
                <img src="../images/admin/rules.png" alt="" />
            </div>
            <span class="name">投票说明</span>
        </div>
        <div class="item" onclick="javascript:window.location.href='../approve.php';">
            <div style="text-align: center; padding: 10px;">
                <img src="../images/admin/approve.png" alt="" />
            </div>
            <span class="name">审批作品</span>
        </div>
    </div>
</body>

</html>