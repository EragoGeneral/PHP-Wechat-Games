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

</head>
<body>
        <?php
            include 'header.php';
        ?>
        <?php
            include 'tabs.php';
        ?>
        <?php 
            include 'dbconn.php';
            $article_id = $_GET['id'];
            
            mysqli_select_db($conn, "drawing_vote");
            
            $sql = "select id, code, name, path, author, vote_num, declaration from article where id = $article_id";
            $result = mysqli_query($conn, $sql);
            $article = mysqli_fetch_array($result);
            // echo "article id:".$article['id'].", name:".$article['name'].", path:".$article['path'];        	    
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
				<span><i></i>12</span>
			</div>
			<div class="leftName">
				<h2>
					<em>14号</em><?php echo $article['name'] ?></h2>
			</div>
		</div>
		<div class="blank10"></div>
		<p>与上一名差距：118票</p>
		<div class="blank10"></div>
		<p>拉票宣言：<?php echo $article['declaration'] ?></p>
		<div class="blank10"></div>
		<div id="content_pic" style="margin-top: 20px; border: solid 1px #fff;">
			<img src="<?php echo $article['path'] ?>" style="width: 100%">
		</div>
	</div>
	<div class="blank10"></div>
	<div class="abtn_box">
		<a href="javascript:wait_vote();" class="a_btn toupiao vote" id="vote"
			style="background-color: #ccc;">我要投票</a> <a href="javascript:;"
			style="background-color: #ccc;" onclick="wait_vote();"
			class="a_btn canjia">给TA拉票</a> <a href="javascript:;"
			onclick="window.location.href='/index.php?g=Wap&amp;m=Voteimg&amp;a=index&amp;id=7&amp;token=rowbhj1484111879'"
			class="a_btn look">查看其他选项</a>
	</div>
	</section>
	<div style="height: 60px; width: 100%; display: block;"></div>
        <?php
            include 'footer.php';
        ?>
    </body>
</html>