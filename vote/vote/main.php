<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title>作品列表</title>
<style>
body {
	background-color: #eee;
	font-size: 84%;
	text-align: justify;
}
.column {
	display: inline-block;
	vertical-align: top;
}
.pic_a {
	display: block;
	padding: 5px;
	margin-bottom: 10px;
	border: 1px solid #ccc;
	background-color: #fff;
	text-decoration: none;
}
.pic_a img {
	display: block;
	margin: 0 auto 5px;
	border: 0;
	vertical-align: bottom;
	width:100%;
}
.pic_a strong {
	color: #333;
}
</style>
<link href="css/waterfall.css" type="text/css" rel="stylesheet" />
</head>

<body>
<?php
    include 'header.php';
?>
<?php
    include 'tabs.php';
    
    $loadLatest = 0;
    if(isset($_GET['load_latest'])){
        $loadLatest = 1;
    }
?>
<div id="container"></div>
<script src="js/jquery-1.7.2.min.js"></script>
<script>
var waterFall = {
	container: document.getElementById("container"),
	columnNumber: 2,
	columnWidth: 160,
	// P_001.jpg ~ P_160.jpg
	rootImage: "http://cued.xunlei.com/demos/publ/img/",
	indexImage: 0,
	
	scrollTop: document.documentElement.scrollTop || document.body.scrollTop,
	detectLeft: 0,
	
	loadFinish: false,
	loadIndex:0,
	loadLatest:<?php echo $loadLatest;?>,
	// 返回固定格式的图片名
	getIndex: function() {
		var index = this.indexImage;
		if (index < 10) {
			index = "00" + index;	
		} else if (index < 100) {
			index = "0" + index;	
		}
		return index;
	},
	
	// 是否滚动载入的检测
	appendDetect: function() {
		var start = 0;
		for (start; start < this.columnNumber; start++) {
			var eleColumn = document.getElementById("waterFallColumn_" + start);
			if (eleColumn && !this.loadFinish) {
				if (eleColumn.offsetTop + eleColumn.clientHeight < this.scrollTop + (window.innerHeight || document.documentElement.clientHeight)) {
					//this.append(eleColumn);
					this.appendNew();
				}
			}			
		}
		
		return this;
	},

	appendNew: function(){
		this.indexImage += 1;
		var html = '', index = this.getIndex();
		var that = this;
		//请求后台获取批量数据，遍历数据，比较两列中哪一列的高度较小，将元素拼接到该列上
		$.ajax({
		    url:'pagedata_json.php',
		    type:'post',
		    dataType:'json',
		    data:{"load_index":that.loadIndex, "load_latest":that.loadLatest},
		    async:false,
		    success:function(data){
		    	console.log(data);
		    	var flag = data.flag;
				if(flag == '0'){
					that.loadFinish = true;
				}
				
			    var rets = data.list;
			    for(var idx = 0; idx < rets.length; idx++){
			    	var index = rets[idx].index;
			    	var imgUrl = rets[idx].path;
					var link = rets[idx].detail;
					var name = rets[idx].name;
			    	var column;
			    	var column0 = document.getElementById("waterFallColumn_0");
			    	var column1 = document.getElementById("waterFallColumn_1");
					if(column0.offsetTop + column0.clientHeight < column1.offsetTop + column1.clientHeight){
						column = column0;
					}else{
						column = column1;
					}    	
			    	
			    	// 图片尺寸
					var iEle = document.createElement("i");
					iEle.className="number";
					iEle.innerHTML = index+"号";
					column.appendChild(iEle);
					var aEle = document.createElement("a");
					aEle.href = link;
					aEle.className = "pic_a";
					aEle.innerHTML = '<img src="'+ imgUrl +'" /><strong>'+ name +'</strong>';
					column.appendChild(aEle);
			    }
			    that.loadIndex++;
		    }
		}); 
		
// 		if (index >= 160) {
// 			alert("图片加载光光了！");
// 			this.loadFinish = true;
// 		}
		
		return this;
	},
	
	// 滚动载入
	append: function(column) {
		this.indexImage += 1;
		var html = '', index = this.getIndex(), imgUrl = this.rootImage + "P_" + index + ".jpg";

		// 图片尺寸
		var iEle = document.createElement("i");
		iEle.className="number";
		iEle.innerHTML = index+"号";
		column.appendChild(iEle);
		var aEle = document.createElement("a");
		aEle.href = "###";
		aEle.className = "pic_a";
		aEle.innerHTML = '<img src="'+ imgUrl +'" /><strong>'+ index +'</strong>';
		column.appendChild(aEle);

		if (index >= 160) {
			alert("图片加载光光了！");
			this.loadFinish = true;
		}
		
		return this;
	},
	
	// 页面加载初始创建
	create: function() {
		//this.columnNumber = Math.floor(document.body.clientWidth / this.columnWidth);
		this.columnWidth = Math.floor((document.body.clientWidth-10) / this.columnNumber);

		var result = [];
		var that = this;
		$.ajax({
		    url:'pagedata_json.php',
		    type:'post',
		    dataType:'json',
		    data:{"load_index":that.loadIndex, "load_latest":that.loadLatest},
		    async:false,
		    success:function(data){		
		    	console.log(data);
				var flag = data.flag;
				if(flag == '0'){
					that.loadFinish = true;
				}
		    	var rets = data.list;	    
		    	 for(var idx = 0; idx < rets.length; idx++){
			    	var obj = {"index":rets[idx].index, "imgUrl":rets[idx].path, "link":rets[idx].detail, "name":rets[idx].name};
			    	result.push(obj);
		    	 }  
		    	 that.loadIndex++; 	
		    }
		});

		var start = 0, htmlColumn = '', self = this;
		for (start; start < this.columnNumber; start+=1) {
			htmlColumn = htmlColumn + '<span id="waterFallColumn_'+ start +'" class="column" style="width:'+ this.columnWidth +'px;">'+ 
				function() {
					var html = '', i = 0;
					for (i=0; i<result.length/2; i+=1) {
// 						self.indexImage = start + self.columnNumber * i;
// 						var index = self.getIndex();
// 						html = html + '<i class="number">'+index+'号</i><a href="###" class="pic_a"><img src="'+ self.rootImage + "P_" + index +'.jpg" /><strong>'+ index +'</strong></a>';
						var obj = result[start + self.columnNumber * i];
						html = html + '<i class="number">'+obj.index+'号</i><a href="'+ obj.link +'" class="pic_a"><img src="'+ obj.imgUrl +'" /><strong>'+ obj.name +'</strong></a>';
					}
					return html;	
				}() +
			'</span> ';	
		}
		htmlColumn += '<span id="waterFallDetect" class="column" style="width:'+ this.columnWidth +'px;"></span>';
		
		this.container.innerHTML = htmlColumn;
		
		this.detectLeft = document.getElementById("waterFallDetect").offsetLeft;
		return this;
	},
	
	refresh: function() {
		var arrHtml = [], arrTemp = [], htmlAll = '', start = 0, maxLength = 0;
		for (start; start < this.columnNumber; start+=1) {
			var arrColumn = document.getElementById("waterFallColumn_" + start).innerHTML.match(/<a(?:.|\n|\r|\s)*?a>/gi);
			if (arrColumn) {
				maxLength = Math.max(maxLength, arrColumn.length);
				// arrTemp是一个二维数组
				arrTemp.push(arrColumn);
			}
		}
		
		// 需要重新排序
		var lengthStart, arrStart;
		for (lengthStart = 0; lengthStart<maxLength; lengthStart++) {
			for (arrStart = 0; arrStart<this.columnNumber; arrStart++) {
				if (arrTemp[arrStart][lengthStart]) {
					arrHtml.push(arrTemp[arrStart][lengthStart]);	
				}
			}	
		}
		
		
		if (arrHtml && arrHtml.length !== 0) {
			// 新栏个数		
			//this.columnNumber = Math.floor(document.body.clientWidth / this.columnWidth);
			this.columnWidth = Math.floor((document.body.clientWidth-10) / this.columnNumber);
			
			// 计算每列的行数
			// 向下取整
			var line = Math.floor(arrHtml.length / this.columnNumber);
			
			// 重新组装HTML
			var newStart = 0, htmlColumn = '', self = this;
			for (newStart; newStart < this.columnNumber; newStart+=1) {
				htmlColumn = htmlColumn + '<span id="waterFallColumn_'+ newStart +'" class="column" style="width:'+ this.columnWidth +'px;">'+ 
					function() {
						var html = '', i = 0;
						for (i=0; i<line; i+=1) {
							html += arrHtml[newStart + self.columnNumber * i];
						}
						// 是否补足余数
						html = html + (arrHtml[newStart + self.columnNumber * line] || '');
						
						return html;	
					}() +
				'</span> ';	
			}
			htmlColumn += '<span id="waterFallDetect" class="column" style="width:'+ this.columnWidth +'px;"></span>';
		
			this.container.innerHTML = htmlColumn;
			
			this.detectLeft = document.getElementById("waterFallDetect").offsetLeft;
			
			// 检测
			this.appendDetect();
		}
		return this;
	},
	
	// 滚动加载
	scroll: function() {
		var self = this;
		window.onscroll = function() {
			// 为提高性能，滚动前后距离大于100像素再处理
			// 此处有一个BUG，图片经常无法加载，暂时去掉
			/* var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
			if (!this.loadFinish && Math.abs(scrollTop - self.scrollTop) > 100) {
				self.scrollTop = scrollTop;
				self.appendDetect();	
			} */
			var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
			self.scrollTop = scrollTop;
			self.appendDetect();	
		};
		return this;
	},
	
	// 浏览器窗口大小变换
	resize: function() {
		var self = this;
		window.onresize = function() {
			var eleDetect = document.getElementById("waterFallDetect"), detectLeft = eleDetect && eleDetect.offsetLeft;
			if (detectLeft && Math.abs(detectLeft - self.detectLeft) > 50) {
				// 检测标签偏移异常，认为布局要改变
				self.refresh();	
			}
		};
		return this;
	},
	init: function() {
		if (this.container) {
			this.create().scroll().resize();	
		}
	}
};
waterFall.init();

    var tabType = '<?php echo $loadLatest;?>';
    if(tabType==1){
    	$('#latest_tab').siblings().removeClass('active');
    	$('#latest_tab').addClass('active');
    }

</script>
<?php
    include 'footer.php';
?>
</body>
</html>
