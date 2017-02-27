$(document).ready(function(){
	$('#mingxing').on('change',function(){
		var mingxing = $("#mingxing").val();
		$('#emptyPicture').attr('src', 'img/'+mingxing+".jpg");
	});
});

var waitHandler = null;

function createImage() {
	var name = $('#name').val();
	if(name == '') {
		alert('请输入姓名');return;
	}
	
	var mingxing = $("#mingxing").val();
	
	$('.transparent-float').css('display', 'block');
	$('.float').css('display', 'block');
	$('.scan').css('display', 'block');
	
	$('#ok_btn').css('display', 'none');
	$('.ui-form').css('display', 'none');
	$('#emptyPicture').css('display', 'none');
	$.ajax({
		type:'POST',
		url:'wechat_generate.php',
		data:'name='+ name+"&mingxing="+mingxing,
		timeout:6000,
		success:function(response){		
			if(response != '-1') {
				$('#mypicture').attr('src',response); 
			}
		},
		error:function(){}
	})

	waitHandler = setInterval("waitLoading()", 1200);
}

var waitText = ['正在为你签名...'];
var waitNum = 0;
function waitLoading() {
	if(waitNum == waitText.length) {
		clearInterval(waitHandler);
		waitNum = 0;

		var imgUrl = $('#mypicture').attr('src');

		if(imgUrl == '') {
			$('.scan').html("<br/><br/><br/><br/>&nbsp;&nbsp;Sorry，本次签名生成失败");

			return;
		}
		else {
			$('#mypicture').css('display', 'block');
			$('.scan').html('');
			$('.scan').css('display', 'none');

			return;
		}
	}

	var content = $('.scan').html();
		content += "<br/><br/><br/><br/>";
		content += waitText[waitNum];

	$('.scan').html(content);
	
	waitNum++;
}