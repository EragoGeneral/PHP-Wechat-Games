<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport" />
<title>个人中心</title>
<link href="css/style.css" type="text/css" rel="stylesheet" />
<script src="js/jquery-1.7.2.min.js"></script>
</head>
<body style="margin: 0px;">
    <?php 
        session_start();
        if(isset($_SESSION['user_id'])){
            $sessionUserId = $_SESSION['user_id'];
            $sessionUserName = $_SESSION['login_name'];
        }else{
            $sessionUserId = 0;
            $sessionUserName = '';
        }
    ?>
	<div id="user_center">
		<div class="header">
			<div class="clearfix" style="width: 100%;padding-top: 20px;">
				<div class="header-info">
					<span title="返回" class="icon" style="top:20px;" onclick="window.location.href='main.php';"><i style="background-image: url(images/jiantou.png); left:-6px; top:-1px;"></i></span>
					<span title="刷新" class="icon" style="top:70px;" onclick="window.location.reload();"><i style="background-image: url(images/reload.png); left:-5px; top:-1px;"></i></span>
				</div>
				<div>
					<div class=header-img style="width: 75px; height: 75px;padding: 5px;background: rgba(0,0,0,0.3);display: inline-block;border-radius: 50%;margin: 0 auto;overflow: hidden;">
						<img src="images/nobody.jpg" style="idth: 75px;height: 75px;border-radius: 50%;overflow: hidden;"/>
					</div>
				</div>
				<div class="header-info"></div>
			</div>
			<div style="width:100%;">
				<h1 class="name" style="font-size: 0.67rem;line-height: 26px;font-weight: normal;">
				    <?php echo $sessionUserName?>
				</h1>
			</div>
			<div class="operation">
				<button class="baoming" style="margin-top:20px;background: #DAA08C; color:#fff; width: 100px;line-height: 20px;border-radius: 20px;font-size: 0.67rem;color: #000;border: none;" onclick="logout();">注销</button>
			</div>
		</div>
		<menu>
		    <ul class="clearfix" id="c_foot">
		        <li class="active" id="foot_bu">
		            <h2>谁给我投票</h2>
		            <p>0票</p>
		        </li>
		        <li id="foot_bu">
		            <h2>我给谁投票</h2>
		            <p>0票 </p>
		        </li>
		     </ul>   
		</menu>
		<article>
		    <ul class="menu_list">
		        <li style="display: none;">
		            <section>
		            	<div class="blank give_blank"><a></a></div>
					</section>
		        </li>
		        <li style="display: list-item;">
		            <section>
		            	<div class="blank vote_blank">
		            		<a></a>
		            	</div>            
		           	</section>
		        </li>
		    </ul>
		</article>
	</div>
	<?php 
	   if($sessionUserName == 'admin'){
	?>
    	<div style="position: absolute; bottom: 10px; right: 10px;">
    	   <span onclick="javascript:window.location.href='admin/dashtab.php';" style="display: inline-block; background: #DAA08C; color:#fff; height: 36px; width: 90px; text-align: center; line-height: 36px; padding: 0px 20px; border-radius: 24px; letter-spacing: 5px;">
                    控制台&gt;&gt;
           </span>
    	</div>
	<?php 
	   }
	?>
	<script>
		$(document).ready(function(){
			$('#c_foot li').bind('click',function(){
				$('#c_foot li').removeClass('active');
				$(this).addClass('active');
			});
		});

		function logout(){
			var sessionUser = '<?php echo $sessionUserName?>';
			$.ajax({
			    url:'logout.php',
			    type:'post',
			    dataType:'json',
			    data:{"sessionUser":sessionUser},
			    async:false,
			    success:function(data){
			    	var flag = data.flag;
			    	if(flag == 1){
		    	    	window.location.href= 'main.php';
		    	    }
			    }
			}); 
		}
	</script>
</body>
</html>