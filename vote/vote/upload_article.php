<?php

// 允许上传的图片后缀
$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["weixin_image"]["name"]);
//echo $_FILES["weixin_image"]["size"];
$extension = end($temp);     // 获取文件后缀名
if ((($_FILES["weixin_image"]["type"] == "image/gif")
|| ($_FILES["weixin_image"]["type"] == "image/jpeg")
|| ($_FILES["weixin_image"]["type"] == "image/jpg")
|| ($_FILES["weixin_image"]["type"] == "image/pjpeg")
|| ($_FILES["weixin_image"]["type"] == "image/x-png")
|| ($_FILES["weixin_image"]["type"] == "image/png"))
&& ($_FILES["weixin_image"]["size"] < 204800)   // 小于 200 kb
&& in_array($extension, $allowedExts))
{
	if ($_FILES["weixin_image"]["error"] > 0)
	{
		echo "error" . $_FILES["weixin_image"]["error"] . "<br>";
	}
	else
	{
		
		// 判断当期目录下的 upload 目录是否存在该文件
		// 如果没有 upload 目录，你需要创建它，upload 目录权限为 777
		if (file_exists("upload/" . $_FILES["weixin_image"]["name"]))
		{
			echo $_FILES["weixin_image"]["name"] . " 文件已经存在。 ";
		}
		else
		{
			// 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
			move_uploaded_file($_FILES["weixin_image"]["tmp_name"], "upload/" . $_FILES["weixin_image"]["name"]);
			//echo "文件存储在: " . "upload/" . $_FILES["weixin_image"]["name"];
		}
		$imgUrl = "upload/" . $_FILES["weixin_image"]["name"];
		//将文件路径保存在session中
		session_start();
		$_SESSION['1123_article_path'] = $imgUrl;
		$json_obj = json_encode(array('id'=>'123','imgUrl'=>$imgUrl));
		echo $json_obj;
	}
}
else
{
	echo "非法的文件格式";
}
?>