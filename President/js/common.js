var waitHandler = null;

function createImage() {
	var name = $('#name').val();
	if(name == '') {
		alert('请输入姓名');return;
	}
	
	var message = $('#message').val();
	
	$('.transparent-float').css('display', 'block');
	$('.float').css('display', 'block');
	$('.scan').css('display', 'block');

	//$('#emptyPicture').attr('src', '');
	//$('#emptyPicture').css('display', 'none');
	$('#ok_btn').css('display', 'none');
	$('.ui-form').css('display', 'none');
	
	$.ajax({
		type:'POST',
		url:'president.php',
		data:'name='+ name +'&message='+ message,
		timeout:6000,
		success:function(response){		
			if(response != '-1') {
				$('#mypicture').attr('src',response); 
				//$('#mypicture').css('display', 'block'); 
				$('#emptyPicture').css('display', 'none');
			}
		},
		error:function(){}
	})

	waitHandler = setInterval("waitLoading()", 1200);
}

var waitText = ['总统正在为你签名...'];
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