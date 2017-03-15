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
	<title>投票排名</title>
	<link href="css/waterfall.css" type="text/css" rel="stylesheet" />

</head>
<?php
    include 'header.php';
    include 'tabs.php';
    include 'dbconn.php';
    
    include 'commonutil.class.php';
    
    //$curPage = $_GET['curPage'];
    //$count = $_GET['count'];
    if(isset($_GET['curPage'])){       //由GET方法获得当前页数
        $curPage = $_GET['curPage'];
    }else{
        $curPage = 1;
    }
    
    if(isset($_GET['per'])){       //由GET方法获得每页记录数
        $per = $_GET['per'];
    }else{
        $per = 5;
    }
    
    mysqli_query($conn, "set names 'utf8'");
    mysqli_select_db($conn, "drawing_vote");
    
    $sql = "select id from article where is_deleted = '0' and is_passed = '1' order by vote_num desc";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    
    $start = ($curPage-1)*$per;
    $pageSql = "SELECT id, code, name, vote_num from article WHERE is_deleted = '0' and is_passed = '1' order by vote_num desc limit $start, $per";
    $pageResult = mysqli_query($conn, $pageSql);
?>
<div class="blank20"></div>

<div class="rank300" id="top300">
	<ul>
		<li class="rank-head">
		  <span>排名</span><span>编号</span>
		  <span style="display: inline-block; width: 40%">选项标题</span>
		  <span style="width: 18%; color: #f67685">票数</span>
		</li>
		<?php 
                if(mysqli_num_rows($pageResult)){
                    $num = ($curPage-1)*$per+1;
                    while ($row = mysqli_fetch_array($pageResult)){
            ?>
                        <li class="list">
                		  <span><?php echo $num ?></span><span><?php echo $row['code']?></span>
                		  <span style="display: inline-block; width: 40%"><?php echo $row['name']?></span>
                		  <span style="width: 18%; color: #f67685"><?php echo $row['vote_num']?></span>
                		</li>  
            <?php 
                    $num++;
                    }
                }
            ?>
		<!--  
		<li class="list">
		  <span>1</span><span>150</span>
		  <span style="display: inline-block; width: 40%">梦幻美少女</span>
		  <span style="width: 18%; color: #f67685">6947</span>
		</li>
		<li class="list">
		  <span>2</span><span>92</span>
		  <span style="display: inline-block; width: 40%">充满幻想的世界</span>
		  <span style="width: 18%; color: #f67685">5595</span></li>
		<li class="list">
		  <span>3</span><span>107</span>
		  <span style="display: inline-block; width: 40%">冬、夏</span>
		  <span style="width: 18%; color: #f67685">5365</span>
		</li>
		 -->
	</ul>
</div>

<?php 
echo CommonUtil::getValue('article_ranking.php', $count, $curPage, $per);
mysqli_close($conn);
?>
<!-- 
<div class="pagination pagination-centered" style="margin-top: 20px;">
	<span class="current">1</span><a
		href="/index.php?g=Wap&amp;m=Voteimg&amp;a=vote_ranking&amp;id=7&amp;token=rowbhj1484111879&amp;mk=d542b3e8fb172a397d1d2da7e9decd21&amp;p=2">2</a><a
		href="/index.php?g=Wap&amp;m=Voteimg&amp;a=vote_ranking&amp;id=7&amp;token=rowbhj1484111879&amp;mk=d542b3e8fb172a397d1d2da7e9decd21&amp;p=3">3</a><a
		href="/index.php?g=Wap&amp;m=Voteimg&amp;a=vote_ranking&amp;id=7&amp;token=rowbhj1484111879&amp;mk=d542b3e8fb172a397d1d2da7e9decd21&amp;p=4">4</a><a
		href="/index.php?g=Wap&amp;m=Voteimg&amp;a=vote_ranking&amp;id=7&amp;token=rowbhj1484111879&amp;mk=d542b3e8fb172a397d1d2da7e9decd21&amp;p=5">5</a>
	<a
		href="/index.php?g=Wap&amp;m=Voteimg&amp;a=vote_ranking&amp;id=7&amp;token=rowbhj1484111879&amp;mk=d542b3e8fb172a397d1d2da7e9decd21&amp;p=2">&gt;&gt;</a>
</div>
-->
<div style="height: 60px; width: 100%; display: block;"></div>
<?php
include 'footer.php';
?>
</html>
