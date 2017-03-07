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
		<script src="http://s.404.cn/tpl/static/voteimg/js/swipe.js"></script> 
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
		<a href="javascript:;" onclick="apply();">我要报名</a> 
	</div>    

	<div class="search">
      <form action="/index.php?g=Wap&amp;m=Voteimg&amp;a=index&amp;id=7&amp;token=rowbhj1484111879" id="search_form" method="post">
	  <input type="hidden" name="id" value="7">
	  <input type="hidden" name="token" value="rowbhj1484111879">
        <div class="search_con">
          <div class="btn">
            <input type="submit" name="seachid" id="searchBtn" value="搜索">
          </div>
          <div class="text_box">
            <input type="search" id="searchText" value="" name="key_word" placeholder="请输入选项标题或编号" autocomplete="off">
          </div>
        </div>
      <input type="hidden" name="__hash__" value="069ffdd99a05bbeab696412e46f812df_178ec19e0791594d25d383eacce79bfa"></form>
    </div>
	<div class="num_box">
      <ul class="num_box_ul">
        <li> <span class="text">统计参与者</span> <span id="main_a">262</span> </li>
        <li> <span class="text">统计投票数</span> <span id="main_b">49259</span> </li>
        <li> <span class="text">统计访问量</span> <span id="main_c">45542</span> </li>
      </ul>
    </div>  
</div>
