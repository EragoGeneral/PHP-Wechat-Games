<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title>Insert title here</title>
</head>

<body>
	<div>
		<img src="http://wxsxz117.cc:8080/games/games/zhaowifi/logo.jpg" width="0" height="0"/>
		<input id="btnShare" type="button" value="Share" />
	</div>
	<?php
        include "jssdk/jssdk.php"; // 表示主机根目录下jssdk文件夹内jssdk.php文件
        $jssdk = new JSSDK("wxf7ec914a4a6ea4ff", "6849da739c9a75d63410611fe3f87cad"); // 填写开发者中心你的开发者ID
        $signPackage = $jssdk->GetSignPackage();
    ?>
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

	<script>
         wx.config({
           debug:  false,  //调式模式，设置为ture后会直接在网页上弹出调试信息，用于排查问题
           appId: '<?php echo $signPackage["appId"];?>',
           timestamp: <?php echo $signPackage["timestamp"];?>,
           nonceStr: '<?php echo $signPackage["nonceStr"];?>',
           signature: '<?php echo $signPackage["signature"];?>',
           jsApiList: [  //需要使用的网页服务接口
               'checkJsApi',  //判断当前客户端版本是否支持指定JS接口
               'onMenuShareTimeline', //分享给好友
               'onMenuShareAppMessage', //分享到朋友圈
               'onMenuShareQQ',  //分享到QQ
               'onMenuShareWeibo' //分享到微博
           ]
         });
         wx.ready(function () {   //ready函数用于调用API，如果你的网页在加载后就需要自定义分享和回调功能，需要在此调用分享函数。//如果是微信游戏结束后，需要点击按钮触发得到分值后分享，这里就不需要调用API了，可以在按钮上绑定事件直接调用。因此，微信游戏由于大多需要用户先触发获取分值，此处请不要填写如下所示的分享API
            wx.onMenuShareTimeline({  //例如分享给好友的API  
               title: '小画家比赛', // 分享标题
               desc: '快来给我投上一票吧', // 分享描述
               link: 'http://vote.wxsxz117.cc/vote/main.php', // 分享链接
               imgUrl: 'http://vote.wxsxz117.cc/vote/images/drawing/33.jpg', // 分享图标
               success: function () {
                   alert('分享成功');
               },
               cancel: function () {
                   // 用户取消分享后执行的回调函数
            	   alert('分享 Fail');
               }
            });

            wx.onMenuShareAppMessage({  //例如分享到朋友圈的API  
                title: '小画家比赛', // 分享标题
                link: 'http://vote.wxsxz117.cc/vote/main.php', // 分享链接
                imgUrl: 'http://vote.wxsxz117.cc/vote/images/drawing/33.jpg', // 分享图标
                success: function () {
                	alert('分享成功');
                },
                cancel: function () {
                    // 用户取消分享后执行的回调函数
                }
             });
         });	
         wx.error(function (res) {
           alert(res.errMsg);  //打印错误消息。及把 debug:false,设置为debug:ture就可以直接在网页上看到弹出的错误提示
         });
        </script>

	<!-- 
	<script>
		 var dataForWeixin = {
		  appId: "",
		  MsgImg: "Christmas/201012189457639.gif",//显示图片
		  TLImg: "Christmas/201012189457639.gif",//显示图片
		  url: "http://vote.wxsxz117.cc/vote/main.php",//跳转地址
		  title: "将我的思念和祝福送给您,颐养源祝大家圣诞快乐",//标题内容
		  desc: "将我的思念和祝福送给您,颐养源祝大家圣诞快乐",//描述内容
		  fakeid: "",
		  callback: function () { }
		 };
		 (function () {
		  var onBridgeReady = function () {
		  WeixinJSBridge.on('menu:share:appmessage', function (argv) {
		   WeixinJSBridge.invoke('sendAppMessage', {
		   "appid": dataForWeixin.appId,
		   "img_url": dataForWeixin.MsgImg,
		   "img_width": "120",
		   "img_height": "120",
		   "link": dataForWeixin.url,
		   "desc": dataForWeixin.desc,
		   "title": dataForWeixin.title
		   }, function (res) { (dataForWeixin.callback)(); });
		  });
		  WeixinJSBridge.on('menu:share:timeline', function (argv) {
		   (dataForWeixin.callback)();
		   WeixinJSBridge.invoke('shareTimeline', {
		   "img_url": dataForWeixin.TLImg,
		   "img_width": "120",
		   "img_height": "120",
		   "link": dataForWeixin.url,
		   "desc": dataForWeixin.desc,
		   "title": dataForWeixin.title
		   }, function (res) { });
		  });
		  WeixinJSBridge.on('menu:share:weibo', function (argv) {
		   WeixinJSBridge.invoke('shareWeibo', {
		   "content": dataForWeixin.title,
		   "url": dataForWeixin.url
		   }, function (res) { (dataForWeixin.callback)(); });
		  });
		  WeixinJSBridge.on('menu:share:facebook', function (argv) {
		   (dataForWeixin.callback)();
		   WeixinJSBridge.invoke('shareFB', {
		   "img_url": dataForWeixin.TLImg,
		   "img_width": "120",
		   "img_height": "120",
		   "link": dataForWeixin.url,
		   "desc": dataForWeixin.desc,
		   "title": dataForWeixin.title
		   }, function (res) { });
		  });
		  };
		  
		  if (document.addEventListener) {
		  document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
		  } else if (document.attachEvent) {
		  document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
		  document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
		  }
		 })();
		</script>
    -->
	<!-- <script type="text/javascript">
	/*******************************
	 * Author:Mr.Think
	 * Description:微信分享通用代码
	 * 使用方法：_WXShare('分享显示的LOGO','LOGO宽度','LOGO高度','分享标题','分享描述','分享链接','微信APPID(一般不用填)');
	 *******************************/
	function _WXShare(img,width,height,title,desc,url,appid){
	    //初始化参数
	    img=img||'http://vote.wxsxz117.cc/vote/images/drawing/33.jpg';
	    width=width||100;
	    height=height||100;
	    title=title||document.title;
	    desc=desc||document.title;
	    url=url||document.location.href;
	    appid=appid||'';
	    //微信内置方法
	    function _ShareFriend() {
	        WeixinJSBridge.invoke('sendAppMessage',{
	              'appid': appid,
	              'img_url': img,
	              'img_width': width,
	              'img_height': height,
	              'link': url,
	              'desc': desc,
	              'title': title
	              }, function(res){
	                _report('send_msg', res.err_msg);
	          })
	    }
	    function _ShareTL() {
	        WeixinJSBridge.invoke('shareTimeline',{
	              'img_url': img,
	              'img_width': width,
	              'img_height': height,
	              'link': url,
	              'desc': desc,
	              'title': title
	              }, function(res) {
	              _report('timeline', res.err_msg);
	              });
	    }
	    function _ShareWB() {
	        WeixinJSBridge.invoke('shareWeibo',{
	              'content': desc,
	              'url': url,
	              }, function(res) {
	              _report('weibo', res.err_msg);
	              });
	    }
	    // 当微信内置浏览器初始化后会触发WeixinJSBridgeReady事件。
	    document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
	            // 发送给好友
	            WeixinJSBridge.on('menu:share:appmessage', function(argv){
	                _ShareFriend();
	          });
	            // 分享到朋友圈
	            WeixinJSBridge.on('menu:share:timeline', function(argv){
	                _ShareTL();
	                });
	            // 分享到微博
	            WeixinJSBridge.on('menu:share:weibo', function(argv){
	                _ShareWB();
	           });
	    }, false);
	}
	</script> -->
</body>
</html>