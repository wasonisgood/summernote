<?php
/* 請依實際狀況修改*/
$save_url="http://localhost/web/summernote/upload/";//圖片上傳資料夾之絕對路徑，請依實際狀況填寫
$use_url="upload/";//圖片上傳資料夾之相對路徑，請依實際狀況填寫


$str = md5(uniqid(mt_rand(), true));
$ext = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
$filesName = $str . "." . $ext;  //文件名数组
$filesTmpName = $_FILES['file']['tmp_name'];  //临时文件名数组

$filePath = $use_url . $filesName; //文件路径
$po_name = $ext;

$type= $_FILES['file']['type']; //圖片類型
$str = md5(uniqid(mt_rand(), true)); //生成唯一ID  


if (!file_exists($save_url . $filesName)) {
    if ($po_name == "webp") {
        if (move_uploaded_file($filesTmpName, $filePath)) {
            echo $filePath;
        } else {
            echo "移动文件失败";
        }
    } else {
        $zz = base64EncodeImage($type, $filesTmpName, $str,$filePath,$save_url,$use_url);
        echo $zz;
       
    }
} else {
    echo "图片已存在！插入失败";
}
//echo   "<img src= '".$filePath ."'>";
function base64EncodeImage($houzhui,$dizhi,$str,$filePath,$save_url,$use_url)
{
    

    switch ($houzhui) {
	case 'image/png':
		$im = imagecreatefrompng($dizhi);
		break;
	case 'image/gif':
		$im = imagecreatefromgif($dizhi);
		break;
	case 'image/jpeg':
		$im = imagecreatefromjpeg($dizhi);
		break;
	case 'image/jpg':
		$im = imagecreatefromjpeg($dizhi);
		break;	
	default:
		exit("上傳文件格式不正確");
		break;
	}
	
    if(imagewebp($im,$use_url.$str.'.webp',75))
    {
       
        echo $save_url . $str . '.webp';

    }
    else
    {
        if (move_uploaded_file($dizhi, $filePath)) {
            echo $filePath;
        } else {
            echo "移动文件失败";
        }
        
    }
	imagedestroy($im);

}