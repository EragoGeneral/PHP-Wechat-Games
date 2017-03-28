<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title>注册</title>
<style>
    .text-box i.user-icon{
    	background-image: url(images/icons.png);
    	background-position: 10px 20px;
    }
    
    .text-user{margin: 0px auto; border: solid 2px #ccc; width: 80%; height: 30px; background:url(images/user.png) no-repeat 0 center;}
    .text-pwd{margin: 0px auto; border: solid 2px #ccc; width: 80%; height: 30px; background:url(images/password.png) no-repeat 0 center;}
    .text-user input, .text-pwd input{float:left;border:none;background:none;height:30px;line-height:30px;width:100%; text-indent:32px;}
</style>
<script src="js/jquery-1.7.2.min.js"></script>
</head>

<?php 
    include 'dbconn.php';
    
    if(isset($_POST["ok"])){
        $name = '';
        $pwd = '';
        if(isset($_POST['username'])){
            $name = $_POST['username'];
        }
        if(isset($_POST['password'])){
            $pwd = $_POST['password'];
        }
        
         if($name != '' && $pwd != ''){
            mysqli_query($conn, "set names 'utf8'");
            mysqli_select_db($conn, "drawing_vote");
            
            $sql = "select id, login_name, nick_name, photo from member where login_name = '$name' and is_deleted = '0' ";
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_array($result);
            $total = mysqli_num_rows($result);
            if($total > 0){
                echo '<div style="text-align: center; padding-top: 50px;">用户名已被注册 <br/ ><br/ > <a href="register.php" style="text-decoration: none;">重新注册</a></div>';
                exit;
            }
            
            $isql = "insert into member(login_name, password, created_time, created_by, updated_time, updated_by, is_deleted) 
                values('$name', '$pwd', SYSDATE(), 0, SYSDATE(), 0, '0')";
            mysqli_query($conn, $isql);
            $userId=mysqli_insert_id($conn);
            
            session_start();
            $_SESSION['user_id'] = $userId;
            $_SESSION['login_name'] = $name;
            
            mysqli_close($conn);
            echo "<script>window.location.href='main.php';</script>";
         }
    }
?>

<body style="text-align: center; margin:0px;background-image: -webkit-linear-gradient(left, #f1a548 0%, #b23f2b 100% ); color: #fff;">
    <div class="portrait-box" style="margin-top:80px;">
        <div class=header-img style="width: 75px; height: 75px;padding: 5px;background: rgba(0,0,0,0.3);display: inline-block;border-radius: 50%;margin: 0 auto;overflow: hidden;">
			<img src="images/nobody.jpg" style="idth: 75px;height: 75px;border-radius: 50%;overflow: hidden;"/>
		</div>
    </div>
    <form id="form1" name="form1" method="post" action="register.php">
        <div class="text-box" style="margin-top: 30px;">
            <span style="display:inline-block; margin-bottom: 20px; width: 80%;">
                <div class="text-user">
                    <input type="text" name="username" id="username" />
                </div>    
            </span>
            <span style="display:inline-block; width: 80%;">
                <div class="text-pwd">
                    <input type="password" name="password" id="password" />
                </div>
            </span>
        </div>    
        <div class="login-btn" style="margin-top: 35px; font-size: 20px; color: #fff;">
            <!-- <span onclick="login();" style="display: inline-block; width: 50%; background-image: -webkit-linear-gradient(left, #e7b992 0%, #DAA08C 50% ); border: solid 1px; border-radius: 45px; height: 45px; line-height: 45px;">登               录</span>   -->
            <input type="submit" name="ok" id="ok" value="注      册" style="display: inline-block; width: 60%; background-image: -webkit-linear-gradient(left, #e7b992 0%, #DAA08C 50% ); border-radius: 45px; height: 45px; line-height: 45px; border: none; color: #fff; font-size: 20px;" />
        </div>
    </form>
    <div class="link-box" style="position: absolute; bottom: 60px; width: 100%;">
        <a href="login.php" style="position: absolute; left: 30px; color:#fff; text-decoration: none; border-bottom: solid 1px #f7b581;">已有账号?</a>
    </div>
    
</body>

</html>