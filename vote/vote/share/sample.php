<?php
require_once "jssdk.php";
$jssdk = new JSSDK("wxf7ec914a4a6ea4ff", "6849da739c9a75d63410611fe3f87cad");
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
	content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <title></title>
</head>
<body>
    <div>
		<img src="../images/others/sun.jpg" /> <input id="btnShare" type="button"
			value="Share" />
	</div>
</body>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
  /*
   * 注意：
   * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
   * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
   * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
   *
   * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
   * 邮箱地址：weixin-open@qq.com
   * 邮件主题：【微信JS-SDK反馈】具体问题
   * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
   */
  wx.config({
    debug: false,
    appId: '<?php echo $signPackage["appId"];?>',
    timestamp: <?php echo $signPackage["timestamp"];?>,
    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
    signature: '<?php echo $signPackage["signature"];?>',
    jsApiList: [
       // 所有要调用的 API 都要加到这个列表中
       /* 'checkJsApi',  //判断当前客户端版本是否支持指定JS接口
       'onMenuShareTimeline', //分享给好友
       'onMenuShareAppMessage', //分享到朋友圈
       'onMenuShareQQ',  //分享到QQ
       'onMenuShareWeibo' //分享到微博 */
       // 所有要调用的 API 都要加到这个列表中
       'checkJsApi',
       'openLocation',
       'getLocation'
    ]
  });
  wx.ready(function () {
      /* // 在这里调用 API
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
        }); */
	  wx.checkJsApi({
		    jsApiList: [
		        'getLocation'
		    ],
		    success: function (res) {
		        // alert(JSON.stringify(res));
		        // alert(JSON.stringify(res.checkResult.getLocation));
		        if (res.checkResult.getLocation == false) {
		            alert('你的微信版本太低，不支持微信JS接口，请升级到最新的微信版本！');
		            return;
		        }
		    }
		});

	  wx.getLocation({
		    success: function (res) {
		        var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
		        var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
		        var speed = res.speed; // 速度，以米/每秒计
		        var accuracy = res.accuracy; // 位置精度
		        alert(latitude+", "+longitude+", "+speed+", "+accuracy);
		    },
		    cancel: function (res) {
		        alert('用户拒绝授权获取地理位置');
		    }
		});
  });
</script>
</html>
