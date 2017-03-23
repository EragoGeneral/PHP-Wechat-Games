<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport"
		content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<style type="text/css">
body {
	position: relative;
	margin: 0;
	padding: 10px 0 0 0;
}
</style>
	<title>作品详情</title>
	<link href="css/waterfall.css" type="text/css" rel="stylesheet" />
    <script src="js/jquery-1.7.2.min.js"></script> 
</head>
<body>
    <img id="share_pic" src="images/others/33.jpg" width="0" height="0"/>
    <?php
        include 'header.php';
    ?>
    <?php
        include 'tabs.php';
    ?>
    <?php 
        include 'dbconn.php';
        $article_id = $_GET['id'];
        if(isset($_GET['isApproved'])){       //由GET方法获得每页记录数
            $is_approved = $_GET['isApproved'];
        }else{
            $is_approved = 0;
        }
        
        mysqli_select_db($conn, "drawing_vote");
        
        //$sql = "select id, code, name, path, author, vote_num, declaration from article where id = $article_id";
        
        $sql = "SELECT t2.rownum, t2.id, t2.code, t2.name, t2.path, t2.author, t2.declaration, t2.is_passed, IFNULL(t2.vote_num,0) as vote_num , IFNULL((t11.vote_num-t2.vote_num),0) as diff FROM (SELECT @rownum:=@rownum+1 rownum, id, CODE, NAME, path, author, vote_num, declaration, is_passed FROM (SELECT @rownum:=0,article.* FROM article WHERE is_deleted = '0' ORDER BY vote_num DESC) t)t2 LEFT JOIN (SELECT t1.rownum, t1.vote_num FROM (SELECT @rownum:=@rownum+1 rownum, id, CODE, NAME, vote_num FROM (SELECT @rownum:=0,article.* FROM article WHERE is_deleted = '0' ORDER BY vote_num DESC) t) t1)t11 ON t2.rownum - 1= t11.rownum WHERE id = $article_id";
        
        $result = mysqli_query($conn, $sql);
        $article = mysqli_fetch_array($result);
        //echo "article id:".$article['id'].", name:".$article['name'].", path:".$article['path'].", diff:".$article['diff'];        	    
    ?>
    <div class="blank20"></div>
	<section class="content"> <!-- 
          <div class="text_a clearfix" id="sort"> 
            <a href="javascript:;" class="active" onclick="window.location.href = &quot;/index.php?g=Wap&amp;m=Voteimg&amp;a=index&amp;id=7&amp;token=rowbhj1484111879&amp;type=all&quot;;">全部参赛</a> <a href="javascript:;" onclick="window.location.href = &quot;/index.php?g=Wap&amp;m=Voteimg&amp;a=index&amp;id=7&amp;token=rowbhj1484111879&amp;type=new&quot;;">最新参赛</a>  <a href="javascript:;" onclick="window.location.href = &quot;/index.php?g=Wap&amp;m=Voteimg&amp;a=rules&amp;id=7&amp;token=rowbhj1484111879&quot;;">活动规则</a> </div>
          <div class="blank20"></div>
           -->

	<div id="content_tab" class="main_content">
		<div class="newTit">
			<div class="rightInfo">
				<span><i></i><span id="vote_count"><?php echo $article['vote_num'] ?></span></span>
				<span><i></i><span id="pos"><?php echo $article['rownum'] ?></span></span>
			</div>
			<div class="leftName">
				<h2>
					<em><?php echo $article['code'] ?>号</em><?php echo $article['name'] ?></h2>
			</div>
		</div>
		<div class="blank10"></div>
		<input type="hidden" name="article_id" id="artile_id" value="<?php echo  $article['id'] ?>"/>		   
		<p>
		      与上一名差距：<span id="diff"><?php if($article['diff'] < 0) { echo 0; }else{ echo $article['diff'];}  ?></span>票
		</p>
		<div class="blank10"></div>
		<p>拉票宣言：<?php echo $article['declaration'] ?></p>
		<div class="blank10"></div>
		<div id="content_pic" style="margin-top: 20px; border: solid 1px #fff;">
			<img id="article_img" src="<?php echo $article['path'] ?>" style="width: 100%">
		</div>
	</div>
	<div class="blank10"></div>
	<?php 
	   if($is_approved == '0' && $article['is_passed'] == '1'){
	?>
    	<div class="abtn_box">
    		<a href="javascript:vote();" class="a_btn toupiao vote" id="vote">我要投票</a> 
    		<a href="javascript:addTicket();" class="a_btn canjia">给TA拉票</a> 
    	</div>
	<?php 
	   }else if($is_approved == '1'){
	?>
	    <div class="abtn_box">
    		<a href="javascript:agree();" class="a_btn toupiao vote" id="vote">通过</a> 
    		<a href="javascript:reject();" class="a_btn canjia">不通过</a> 
    		<a href="approve.php" class="a_btn canjia">返回</a>
    	</div>
    <?php 
	   }
    ?>	
	</section>
    <script>
    	function vote(){
        	var articleId= $('#artile_id').val();
        	console.log(articleId);
            $.ajax({
        	    url:'vote.php',
        	    type:'post',
        	    dataType:'json',
        	    data:{"id":articleId},
        	    async:false,
        	    success:function(data){
        	    	console.log(data);
        	    	var flag = data.flag;
        	    	if(flag == 1){
        	    		//window.location.reload();
        	    		$('#vote_count').text(data.voteNum);
        	    		var diff = $('#diff').text();
						var gap = parseInt(diff)-1;
						if(gap < 0){
							var pos = $('#pos').text();
							var pos1 = parseInt(pos)-1;
							if(pos1 > 0){
								$('#pos').text(pos1);
							} 
							window.location.reload();
						}else{
							$('#diff').text(gap);        	    		
						}						
            	    }
            	    alert(data.info);                	
        	    }
        	});  
       	}

       	function addTicket(){
           	document.title = '我在萌宝绘画参加比赛，<?php echo $article['code'] ?>号作品，快来给我投上宝贵的一票吧';
           	$('#image-bg').css('height', (document.body.scrollTop+window.innerHeight)+'px');
			$('#share').show();
			$('#image-bg').show();
        }

        function agree(){
        	var articleId= $('#artile_id').val();
        	$.ajax({
        	    url:'article_update.php',
        	    type:'post',
        	    dataType:'json',
        	    data:{"id":articleId, "status":"1"},
        	    async:false,
        	    success:function(data){
        	    	var flag = data.flag;
        	    	if(flag == 1){
            	    	alert('approved');
            	    	window.location.href= 'approve.php';
            	    }
        	    }
        	}); 
        }

        function reject(){
        	var articleId= $('#artile_id').val();
        	$.ajax({
        	    url:'article_update.php',
        	    type:'post',
        	    dataType:'json',
        	    data:{"id":articleId, "status":"2"},
        	    async:false,
        	    success:function(data){
        	    	var flag = data.flag;
        	    	if(flag == 1){
            	    	alert('reject');
            	    	window.location.href= 'approve.php';
            	    }
        	    }
        	}); 
        }

        $(document).ready(function(){
            console.log($('#article_img').attr('src'));
			$('#share_pic').attr('src', 'images/others/33.jpg');
			document.title = '我在萌宝绘画参加比赛，<?php echo $article['code'] ?>号作品，快来给我投上宝贵的一票吧';

			$('#image-bg').bind('click', function(){
				$('#share').hide();
				$('#image-bg').hide();
			});
        });
    </script>  
    <?php
        include 'footer.php';
    ?>  
    <div id="share" style="display: none; background: black; filter": "Alpha(opacity=90); z-index:1000;">
			<img width="100%" src="images/share_tips.png"
			style="position: fixed; z-index: 999; top: 0; left: 0; display:''; height: 100%;"
			ontouchstart="document.getElementById('share').style.display='none';" />
	</div>
	<div id="image-bg" style="display:none; width: 100%; height: 100%; z-index: 999; background-color: #000; opacity: 0.6; position: absolute; top: 0px; left: 0px;">
	</div>
    </body>
</html>