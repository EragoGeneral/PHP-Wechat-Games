<div style="height: 60px; width: 100%; display: block;"></div>
<div>
	<ul style="width:100%; margin:0 auto;" class="bot_main" id="c_foot">
		<li class="ico_2" id="foot_bu_search" style="width: 33%;">
			<span class="ico">
				<img src="images/daohang_02.png" width="20" height="20">
			</span>
			<span class="txt">搜索</span>
		</li>	
		<li class="ico_3" id="foot_bu_ranking" style="width: 33%;">
			<a href="javascript:;" onclick="window.location.href = &quot;article_ranking.php&quot;">
			<span class="ico">
				<img src="images/daohang_03.png" width="20" height="20"></span>
				<span class="txt">排行</span>
			</a>
		</li>	
		<li class="ico_4" id="foot_bu_mine" style="width: 33%;">
		    <input type="hidden" id="sessionUserId" value="<?php echo $sessionUserId?>" />
		    <input type="hidden" id="sessionUserName" value="<?php echo $sessionUserName?>" />
		    <a onclick="javascript:gotoDash();">
			<span class="ico">
				<img src="images/daohang_04.png" width="20" height="20">
			</span>
			<span class="txt">我的</span>
		</li>  
	</ul>
</div>
<script>
	function gotoDash(){
		var sessionUserId = $('#sessionUserId').val();
		if(sessionUserId != 0){
			window.location.href = "user_center1.php";
		}else{
			window.location.href = "login.php";
		}
	}

	$(document).ready(function(){
		$('#foot_bu_search').bind('click', function(){
			$('#cover').css('height', (document.body.scrollTop+window.innerHeight)+'px');
			$('#popup_search').css('top',(document.body.scrollTop+63)+'px');
			$('#popup_search').show();
			$('#cover').show();
		});

		$('#cover').bind('click', function(){
			
			$('#popup_search').hide();
			$('#cover').hide();
		});
	});
</script>