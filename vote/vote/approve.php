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
	<title>待审核作品</title>
	<link href="css/waterfall.css" type="text/css" rel="stylesheet" />
    <script src="js/jquery-1.7.2.min.js"></script>
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
        $per = 10;
    }
    
    mysqli_query($conn, "set names 'utf8'");
    mysqli_select_db($conn, "drawing_vote");
    
    $sql = "select id from article where is_deleted = '0' and is_passed = '0' order by vote_num desc";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    
    $start = ($curPage-1)*$per;
    $pageSql = "SELECT id, code, name, vote_num from article WHERE is_deleted = '0' and is_passed = '0' order by vote_num desc limit $start, $per";
    $pageResult = mysqli_query($conn, $pageSql);
?>
<div class="blank20"></div>

<div class="rank300" id="top300">
	<ul>
		<li class="rank-head">
		  <span style="display: inline-block; width: 18%">编号</span>
		  <span style="display: inline-block; width: 40%">选项标题</span>
		  <span style="width: 40%; color: #f67685">操作</span>
		</li>
		<?php 
                if(mysqli_num_rows($pageResult)){
                    $num = ($curPage-1)*$per+1;
                    while ($row = mysqli_fetch_array($pageResult)){
            ?>
                        <li class="list">
                		  <span style="display: inline-block; width: 18%"><?php echo $row['code']?></span>
                		  <span style="display: inline-block; width: 40%"><?php echo $row['name']?></span>
                		  <span style="width: 40%; color: #f67685">
                		      <a href="article_detail.php?id=<?php echo $row['id']?>&isApproved=1">查看</a>&nbsp;
                		      <a href="javascript:agree(<?php echo $row['id']?>);">通过</a>&nbsp;
                		      <a href="javascript:reject(<?php echo $row['id']?>);">不通过</a>
                		  </span>
                		</li>  
            <?php 
                    $num++;
                    }
                }
            ?>
	</ul>
</div>

<?php 
echo CommonUtil::getValue('article_ranking.php', $count, $curPage, $per);
mysqli_close($conn);
?>
<?php
include 'footer.php';
?>
<script src="js/jquery-1.7.2.min.js"></script>
<script>
function agree(articleId){
	//var articleId= $('#artile_id').val();
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

function reject(articleId){
	//var articleId= $('#artile_id').val();
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
</script>

</html>
