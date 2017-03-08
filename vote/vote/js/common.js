$(document).ready(function(){
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
				    $('#load_index').val(parseInt(loadIndex)+10);
			    }
			}); 
			return $(html);
		},
		auto_imgHeight : true,
		insert_type : 1
	}
	$('#waterfall').waterfall(opt);
	
	$(window).trigger('scroll');
});