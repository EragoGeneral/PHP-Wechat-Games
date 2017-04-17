<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title>设置奖品</title>
<style>
    
</style>
<script src="../js/jquery-1.7.2.min.js"></script>
</head>

<?php 
    include '../dbconn.php';

    if(isset($_POST["saveReward"])){
        $code = '';
        $name = '';
        $number = '';
        $level = '';
        if(isset($_POST['code'])){
            $code = $_POST['code'];
        }
        if(isset($_POST['name'])){
            $name = $_POST['name'];
        }
        if(isset($_POST['number'])){
            $number = $_POST['number'];
        }
        if(isset($_POST['level'])){
            $level = $_POST['level'];
        }
        
        session_start();
        $sessionUserId = $_SESSION['user_id'];
        //$file = $_SESSION[$sessionUserId.'_reward_path'];
        
        
        if($code != '' && $name != '' && $number != '' && $level != ''){ // && $file != ''){
            mysqli_query($conn, "set names 'utf8'");
            mysqli_select_db($conn, "drawing_vote");
            
            //判断当前设置的奖品是否已经添加过
            $sql = "select id from reward where name = '$name' and is_deleted = '0'";
            $result = mysqli_query($conn, $sql);
           // $reward = mysqli_fetch_array($result);
            $total = mysqli_num_rows($result);
            if($total > 0){
                echo '<div style="text-align: center; padding-top: 50px;">该奖品名称已经使用</div>';
                exit;
            }
            
            if(isset($_POST['rid'])){
                $id = $_POST['rid'];
                if($id != ''){
                    $ssql = "update reward set code = '$code', name = '$name', level = '$level', total_num = '$number', updated_time = SYSDATE()
                    where id = $id";
                }else{
                    $ssql = "insert into reward(code, name, total_num, level, created_time, created_by, updated_time, updated_by, is_deleted)
                    values('$code', '$name', '$number', '$level', SYSDATE(), 0, SYSDATE(), 0, '0')";
                }
            }
                
            mysqli_query($conn, $ssql);
            $rid=mysqli_insert_id($conn);
            
            //$_SESSION[$sessionUserId.'_reward_path'] = '';
            
            mysqli_close($conn);
            echo "<script>window.location.href='reward.php';</script>";
        }
    }
    
    if(isset($_GET["rid"])){
        $id = $_GET["rid"];
        mysqli_query($conn, "set names 'utf8'");
        mysqli_select_db($conn, "drawing_vote");
        
        $sql = "select id, code, name, level, total_num from reward where is_deleted = '0' and id = $id";
        $result = mysqli_query($conn, $sql);
        $reward = mysqli_fetch_array($result);
    }
?>

<body style="text-align: center; margin:0px;">
    <h1>添加奖品</h1>
    <div>
        <form id="rewardForm" action="reward_setting.php" method="post">
            <input type="hidden" name="rid" id="rid" value="<?php if(isset($reward['id'])) {echo $reward['id']; } ?>" />
                        编号：<input type="text" name="code" value="<?php if(isset($reward['code'])) {echo $reward['code']; } ?>" />    <br/>
                        名称：<input type="text" name="name" value="<?php if(isset($reward['name'])) {echo $reward['name']; } ?>" />    <br/>
                        等级：<select name="level" value="<?php if(isset($reward['level'])) {echo $reward['level']; } ?>">
                    <option value="0">特等奖</option>
                    <option value="1">一等奖</option>
                    <option value="2">二等奖</option>
                    <option value="3">三等奖</option>        
                 </select>           <br/>            
                        数量：<input type="text" name="number" value="<?php if(isset($reward['total_num'])) {echo $reward['total_num']; } ?>" />  <br/>
                        图片：<input type="file" name="image" />   <br/>
            <input type="submit" id="saveReward" name="saveReward" /> 
            <input type="button" id="return" name="return" onclick="gotoRewards();" value="返回" />
        </form>
    </div>
    <script>
		function gotoRewards(){
			window.location.href = 'reward.php';
		}
    </script>
</body>

</html>