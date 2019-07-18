<?php
/* 請依實際狀況修改*/
$use_url="upload/";//圖片上傳資料夾之相對路徑，請依實際狀況填寫

	$imgSrc =$use_url.$_POST['imgSrc'];
    if(file_exists($imgSrc)) //
    {
    	if(unlink($imgSrc))
		  echo "图片删除成功！";  //php删除文件函数unlink();
		else
			echo "删除不成功！";
	}
	else
		echo "delete操作失败！";
?>