<div class="m_head clearfix">
	<div class="addWrap">
		<div class="swipe" id="mySwipe" style="visibility: visible;">
			<div class="swipe-wrap" style="width: 100%;">
				<div style="width: 100%; overflow: hidden; left: 0px; transition-duration: 0ms; transform: translate(0px, 0px) translateZ(0px);" data-index="0">
					<img src="images/banner.jpg" width="100%;" />
				</div>	
			</div>
		</div>
		<ul id="position">
		</ul>
		<script src="js/swipe.js"></script> 
		<script type="text/javascript"> 
		  var bullets = document.getElementById('position').getElementsByTagName('li');
		  var banner = Swipe(document.getElementById('mySwipe'), {
			auto: 2000,
			continuous: true,
			disableScroll:false,
			callback: function(pos) {
				h = $(".swipe-wrap img").eq(pos).height();
				$(".swipe-wrap div").css("height",h);
			  var i = bullets.length;
			  while (i--) {
				bullets[i].className = ' ';
			  }
			  bullets[pos].className = 'cur';
			}
		  });
		  </script>
	</div>
	<div class="bigBtn"> 
		<a href="javascript:uploadPic();" onclick="">我要报名</a> 
	</div>    

	<div class="search">
      <form action="article_search.php" id="search_form" method="post">
        <div class="search_con">
          <div class="btn">
            <input type="submit" name="seachid" id="searchBtn" value="搜索">
          </div>
          <div class="text_box">
            <input type="text" id="searchText" value="" name="key_word" placeholder="请输入选项标题或编号" autocomplete="off">
          </div>
        </div>
      </form>
    </div>
	<div class="num_box">
      <ul class="num_box_ul">
        <li> <span class="text">统计参与者</span> <span id="main_a">0</span> </li>
        <li> <span class="text">统计投票数</span> <span id="main_b">0</span> </li>
        <li> <span class="text">统计访问量</span> <span id="main_c">0</span> </li>
      </ul>
    </div>  
    <div id="popup_search" class="search" style="display:none; position: absolute; top: 63px; left: 0px; z-index: 1000; width: 100%; padding-left: 10px; padding-right: 10px;">
	 <form action="article_search.php" method="post" style="width: 97%;">
        <div class="search_con">
          <div class="btn">
            <input type="submit" name="seachid" id="searchBtn" value="搜索">
          </div>
          <div class="text_box">
            <input id="pop_search_text" type="text" value="" name="key_word" placeholder="请输入选项标题或编号" autocomplete="off">
          </div>
        </div>
      </form>
	</div>
	<div id="cover" style="display:none; width: 100%; height: 100%; z-index: 999; background-color: #000; opacity: 0.6; position: absolute; top: 0px; left: 0px;">
	</div>
</div>
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
<script>
    $(document).ready(function(){
    	$.ajax({
    	    url:'statistics.php',
    	    type:'post',
    	    dataType:'json',
    	    data:{"visitor":"1"},
    	    async:false,
    	    success:function(data){
    	    	$('#main_a').text(data.article_count);
    			$('#main_b').text(data.attender_count);
    			$('#main_c').text(data.visitor_count);
    	    }
    	}); 
    });

    function uploadPic(){
		var sessionId = '<?php echo $sessionUserId?>';
		console.log(sessionId);
		if(sessionId != 0){
			window.location.href = 'upload_article.html';
		}else{
			window.location.href = 'login.php';
		}	
    }
</script>