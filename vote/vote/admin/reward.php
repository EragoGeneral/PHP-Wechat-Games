<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title>奖品列表</title>
<style>
    
</style>
<link href="../css/bootstrap.min.css" type="text/css" rel="stylesheet" />
<link href="../css/waterfall.css" type="text/css" rel="stylesheet" />
<script src="../js/jquery-1.7.2.min.js"></script>
</head>

<?php 
    include '../dbconn.php';
    mysqli_query($conn, "set names 'utf8'");
    mysqli_select_db($conn, "drawing_vote");
    
    $sql = "select id, name, level, 
            case when level = 0 then '特等奖' when level = 1 then '一等奖' when level = 2 then '二等奖' when level = 3 then '三等奖' end as levelName, 
            total_num, left_num from reward where is_deleted = '0' order by level";
    $result = mysqli_query($conn, $sql);
?>

<body style="margin:0px;">
    <div style="margin: 15px auto; text-align: right; padding-right: 10px;">
        <span style="padding: 2px 5px; display: inline-block; font-size: 1.2em; border: solid 1px blue;">
            <a href="reward_setting.php">添加奖品</a>
        </span>
    </div>
    <div class="rank300" id="top300" style="text-align: center; ">
    	<ul>
    		<li class="rank-head">
    		  <span>名称</span><span>等级</span>
    		  <span style="width: 8%; color: #f67685">数量</span>
    		  <span>操作</span>
    		</li>
    		<?php 
    		  if(mysqli_num_rows($result)){
                while($row = mysqli_fetch_array($result)){
    		?>
    		      <li class="list">
            		  <span><?php echo $row['name'] ?></span><span><?php echo $row['levelName']?></span>
            		  <span style="width: 8%; color: #f67685"><?php echo $row['total_num']?></span>
            		  <span>
                		      <a href="reward_setting.php?rid=<?php echo $row['id']?>">编辑</a>&nbsp;
                		      <a href="javascript:removeReward(<?php echo $row['id']?>);">删除</a>
                		  </span>
            		</li> 
    		<?php
                }  
    		  }
    		?>
    	</ul>
    </div>
    
    <div style="width: 60%; margin: 15px auto; text-align: center;">
        <span style="padding: 2px 5px; display: inline-block; font-size: 1.2em; border: solid 1px blue;">
            <a href="dashtab.php">返回控制台</a>
        </span>
    </div>
    
    <script type="text/javascript">
		function removeReward(rewardId){
			$.ajax({
			    url:'reward_remove.php',
			    type:'post',
			    dataType:'json',
			    data:{"rid":rewardId},
			    async:false,
			    success:function(data){
			    	var flag = data.flag;
			    	if(flag == 1){
		    	    	window.location.href= 'reward.php';
		    	    }
			    }
			});
		}
    </script>
    
</body>

</html>