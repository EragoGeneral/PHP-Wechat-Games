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
	<title>作品列表</title>
	<link href="css/waterfall.css" type="text/css" rel="stylesheet" />
	<script src="js/jquery-1.7.2.min.js"></script>
	<script>
		var screenWidth = screen.width;
		var columnSpace = 10;
		var columnWidth = (screenWidth-columnSpace)/2-5;
		(function($) {
			var
			//参数
			setting = {
				column_width : columnWidth,//列宽
				column_className : 'waterfall_column',//列的类名
				column_space : columnSpace,//列间距
				cell_selector : '.cell',//要排列的砖块的选择器，context为整个外部容器
				img_selector : 'img',//要加载的图片的选择器
				auto_imgHeight : true,//是否需要自动计算图片的高度
				fadein : true,//是否渐显载入
				fadein_speed : 600,//渐显速率，单位毫秒
				insert_type : 1, //单元格插入方式，1为插入最短那列，2为按序轮流插入
				getResource : function(index) {
				} //获取动态资源函数,必须返回一个砖块元素集合,传入参数为加载的次数
			},
			//
			waterfall = $.waterfall = {}, //对外信息对象
			$waterfall = null;//容器
			waterfall.load_index = 0, //加载次数
			$.fn.extend({
				waterfall : function(opt) {
					opt = opt || {};
					setting = $.extend(setting, opt);
					$waterfall = waterfall.$waterfall = $(this);
					waterfall.$columns = creatColumn();
					render($(this).find(setting.cell_selector).detach(), false); //重排已存在元素时强制不渐显
					waterfall._scrollTimer2 = null;
					$(window).bind('scroll',function() {
						clearTimeout(waterfall._scrollTimer2);
						waterfall._scrollTimer2 = setTimeout(onScroll, 300);
					});
					waterfall._scrollTimer3 = null;
					$(window).bind('resize',function() {
						clearTimeout(waterfall._scrollTimer3);
						waterfall._scrollTimer3 = setTimeout(onResize, 300);
					});
				}
			});
			function creatColumn() {//创建列
				waterfall.column_num = calculateColumns();//列数
				//循环创建列
				var html = '';
				for (var i = 0; i < waterfall.column_num; i++) {
					html += '<div class="'+setting.column_className+'" style="width:'+setting.column_width+'px; display:inline-block; *display:inline;zoom:1; margin-left:'+setting.column_space/2+'px;margin-right:'+setting.column_space/2+'px; vertical-align:top; overflow:hidden"></div>';
				}
				$waterfall.prepend(html);//插入列
				return $('.' + setting.column_className, $waterfall);//列集合
			}
			function calculateColumns() {
				//此处不再计算，默认展示2列
				return 2;
				
				//计算需要的列数
				/* var num = Math.floor((screen.width)
						/ (setting.column_width + setting.column_space));
				if (num < 1) {
					num = 1;
				} //保证至少有一列
				return num; */
			}
			function render(elements, fadein) {//渲染元素
				if (!$(elements).length)
					return;//没有元素
				var $columns = waterfall.$columns;
				$(elements)
						.each(
								function(i) {
									if (!setting.auto_imgHeight
											|| setting.insert_type == 2) {//如果给出了图片高度，或者是按顺序插入，则不必等图片加载完就能计算列的高度了
										if (setting.insert_type == 1) {
											insert($(elements).eq(i),
													setting.fadein && fadein);//插入元素
										} else if (setting.insert_type == 2) {
											insert2($(elements).eq(i), i,
													setting.fadein && fadein);//插入元素	 
										}
										return true;//continue
									}
									if ($(this)[0].nodeName.toLowerCase() == 'img'
											|| $(this).find(
													setting.img_selector).length > 0) {//本身是图片或含有图片
										var image = new Image;
										var src = $(this)[0].nodeName
												.toLowerCase() == 'img' ? $(
												this).attr('src') : $(this)
												.find(setting.img_selector)
												.attr('src');
										image.onload = function() {//图片加载后才能自动计算出尺寸
											image.onreadystatechange = null;
											if (setting.insert_type == 1) {
												insert($(elements).eq(i),
														setting.fadein
																&& fadein);//插入元素
											} else if (setting.insert_type == 2) {
												insert2($(elements).eq(i), i,
														setting.fadein
																&& fadein);//插入元素	 
											}
											image = null;
										}
										image.onreadystatechange = function() {//处理IE等浏览器的缓存问题：图片缓存后不会再触发onload事件
											if (image.readyState == "complete") {
												image.onload = null;
												if (setting.insert_type == 1) {
													insert($(elements).eq(i),
															setting.fadein
																	&& fadein);//插入元素
												} else if (setting.insert_type == 2) {
													insert2($(elements).eq(i),
															i, setting.fadein
																	&& fadein);//插入元素	 
												}
												image = null;
											}
										}
										image.src = src;
									} else {//不用考虑图片加载
										if (setting.insert_type == 1) {
											insert($(elements).eq(i),
													setting.fadein && fadein);//插入元素
										} else if (setting.insert_type == 2) {
											insert2($(elements).eq(i), i,
													setting.fadein && fadein);//插入元素	 
										}
									}
								});
			}
			function public_render(elems) {//ajax得到元素的渲染接口
				render(elems, true);
			}
			function insert($element, fadein) {//把元素插入最短列
				if (fadein) {//渐显
					$element.css('opacity', 0).appendTo(
							waterfall.$columns.eq(calculateLowest())).fadeTo(
							setting.fadein_speed, 1);
				} else {//不渐显
					$element.appendTo(waterfall.$columns.eq(calculateLowest()));
				}
			}
			function insert2($element, i, fadein) {//按序轮流插入元素
				if (fadein) {//渐显
					$element.css('opacity', 0).appendTo(
							waterfall.$columns.eq(i % waterfall.column_num))
							.fadeTo(setting.fadein_speed, 1);
				} else {//不渐显
					$element.appendTo(waterfall.$columns.eq(i
							% waterfall.column_num));
				}
			}
			function calculateLowest() {//计算最短的那列的索引
				var min = waterfall.$columns.eq(0).outerHeight(), min_key = 0;
				waterfall.$columns.each(function(i) {
					if ($(this).outerHeight() < min) {
						min = $(this).outerHeight();
						min_key = i;
					}
				});
				return min_key;
			}
			function getElements() {//获取资源
				$.waterfall.load_index++;
				return setting.getResource($.waterfall.load_index,
						public_render);
			}
			waterfall._scrollTimer = null;//延迟滚动加载计时器
			function onScroll() {//滚动加载
				clearTimeout(waterfall._scrollTimer);
				waterfall._scrollTimer = setTimeout(function() {
					var $lowest_column = waterfall.$columns
							.eq(calculateLowest());//最短列
					var bottom = $lowest_column.offset().top
							+ $lowest_column.outerHeight();//最短列底部距离浏览器窗口顶部的距离
					var scrollTop = document.documentElement.scrollTop
							|| document.body.scrollTop || 0;//滚动条距离
					var windowHeight = document.documentElement.clientHeight
							|| document.body.clientHeight || 0;//窗口高度
					if (scrollTop >= bottom - windowHeight) {
						render(getElements(), true);
					}
				}, 100);
			}
			function onResize() {//窗口缩放时重新排列
				if (calculateColumns() == waterfall.column_num)
					return; //列数未改变，不需要重排
				var $cells = waterfall.$waterfall.find(setting.cell_selector);
				waterfall.$columns.remove();
				waterfall.$columns = creatColumn();
				render($cells, false); //重排已有元素时强制不渐显
			}
		})(jQuery);
	</script>
</head>

<body>
    <?php
    include 'header.php';
    ?>
    <?php
        include 'tabs.php';
    ?>
	<div class="blank20"></div>
	<div id="waterfall">
	   <div class="cell">
			<i class="number">9号</i>
			<a href="http://www.5icool.org/special/pinterest/"><img
				src="images/drawing/9.jpg" /></a>
			<p>
				<a href="http://www.5icool.org/special/pinterest/">jQuery瀑布流特效</a>
			</p>
		</div>
		<div class="cell">
			<i class="number">10号</i>
			<a href="http://www.5icool.org/special/pinterest/"><img
				src="images/drawing/10.jpg" /></a>
			<p>
				<a href="http://www.5icool.org/special/pinterest/">jQuery瀑布流特效</a>
			</p>
		</div>
		<div class="cell">
			<i class="number">11号</i>
			<a href="http://www.5icool.org/special/pinterest/"><img
				src="images/drawing/11.jpg" /></a>
			<p>
				<a href="http://www.5icool.org/special/pinterest/">jQuery瀑布流特效</a>
			</p>
		</div>
		<div class="cell">
			<i class="number">12号</i>
			<a href="http://www.5icool.org/special/pinterest/"><img
				src="images/drawing/12.jpg" /></a>
			<p>
				<a href="http://www.5icool.org/special/pinterest/">jQuery瀑布流特效</a>
			</p>
		</div>
		<div class="cell">
			<i class="number">9号</i>
			<a href="http://www.5icool.org/special/pinterest/"><img
				src="images/drawing/9.jpg" /></a>
			<p>
				<a href="http://www.5icool.org/special/pinterest/">jQuery瀑布流特效</a>
			</p>
		</div>
		<div class="cell">
			<i class="number">10号</i>
			<a href="http://www.5icool.org/special/pinterest/"><img
				src="images/drawing/10.jpg" /></a>
			<p>
				<a href="http://www.5icool.org/special/pinterest/">jQuery瀑布流特效</a>
			</p>
		</div>
		<div class="cell">
			<i class="number">11号</i>
			<a href="http://www.5icool.org/special/pinterest/"><img
				src="images/drawing/11.jpg" /></a>
			<p>
				<a href="http://www.5icool.org/special/pinterest/">jQuery瀑布流特效</a>
			</p>
		</div>
		<div class="cell">
			<i class="number">12号</i>
			<a href="http://www.5icool.org/special/pinterest/"><img
				src="images/drawing/12.jpg" /></a>
			<p>
				<a href="http://www.5icool.org/special/pinterest/">jQuery瀑布流特效</a>
			</p>
		</div>
	</div>
	<div>
		<ul style="width:100%; margin:0 auto;" class="bot_main" id="c_foot">
			<li class="ico_2" id="foot_bu" style="width: 33%;">
				<span class="ico">
					<img src="images/daohang_02.png" width="20" height="20">
				</span>
				<span class="txt">搜索</span>
			</li>	
			<li class="ico_3" id="foot_bu" style="width: 33%;">
				<a href="javascript:;" onclick="window.location.href = &quot;/index.php?g=Wap&amp;m=Voteimg&amp;a=vote_ranking&amp;id=7&amp;token=rowbhj1484111879&quot;;">
				<span class="ico">
					<img src="images/daohang_03.png" width="20" height="20"></span>
					<span class="txt">排行</span>
				</a>
			</li>	
			<li class="ico_4" id="foot_bu" style="width: 33%;">
				<span class="ico">
					<img src="images/daohang_04.png" width="20" height="20">
				</span>
				<span class="txt">拉票</span>
			</li>  
		</ul>
	</div>
	<input type="hidden" id="load_index" name="load_index" value="1" />
	<script>
		var opt = {
			getResource : function(index, render) {//index为已加载次数,render为渲染接口函数,接受一个dom集合或jquery对象作为参数。通过ajax等异步方法得到的数据可以传入该接口进行渲染，如 render(elem)
				var html = '';
				var loadIndex= $('#load_index').val();
				$.ajax({
				    url:'pagedata_json.php',
				    type:'post',
				    dataType:'json',
				    data:{"load_index":loadIndex},
				    async:false,
				    success:function(data){
					    var rets = data.list;
					    for(var idx = 0; idx < rets.length; idx++){
					    	var k = rets[idx].index;
					    	var src = rets[idx].path;
					    	html += '<div class="cell"><i class="number">'+k+'号</i><a href="#"><img src="'+src+'" /></a><p><a>'
							+ k + '</a></p></div>';
					    }
				        //var str = data.index + "," + data.path;
				        //console.log(str);
					    $('#load_index').val(parseInt(loadIndex)+1);
				    }
				}); 

// 				if (index >= 7)
// 					index = index % 7 + 1;
// 				var html = '';
// 				for (var i = 20 * (index - 1); i < 20 * (index - 1) + 20; i++) {
// 					var k = '';
// 					for (var ii = 0; ii < 3 - i.toString().length; ii++) {
// 						k += '0';
// 					}
// 					k += i;
// 					var src = "http://cued.xunlei.com/demos/publ/img/P_" + k
// 							+ ".jpg";
// 					html += '<div class="cell"><i class="number">'+k+'号</i><a href="#"><img src="'+src+'" /></a><p><a>'
// 							+ k + '</a></p></div>';
// 				}
				return $(html);
			},
			auto_imgHeight : true,
			insert_type : 1
		}
		$('#waterfall').waterfall(opt);		
	</script>
	<div style=" height:60px; width:100%; display:block;"></div>
    <?php
        include 'footer.php';
    ?>   <!-- 
    <script type="text/javascript" src="js/common.js"></script> -->
</body>
</html>