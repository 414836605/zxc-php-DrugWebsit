<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Upload extends Admin_Controller {
  public function do_upload($id){
  	$upload_dir = './uploads/'.$id.'/';
  	if(!is_dir($upload_dir)){
  		mkdir($upload_dir);
  	}
    $temp_name = $_FILES['file_data']['tmp_name'];
    $file_name = iconv('utf-8', 'gb2312', $_FILES['file_data']['name']);
    move_uploaded_file($temp_name, $upload_dir.$file_name);
    
    $dst_path = $upload_dir.$file_name;
    $src_path = './dst.png';

    //创建图片的实例
    $dst = imagecreatefromstring(file_get_contents($dst_path));
    $dst_info = getimagesize($dst_path);
    $src = imagecreatefromstring(file_get_contents($src_path));
    $src_info = getimagesize($src_path);


    //将水印图片复制到目标图片上，最后个参数50是设置透明度，这里实现半透明效果
    imagecopy($dst, $src, ($dst_info[0]-$src_info[0])/2, ($dst_info[1]-$src_info[1])/2, 0, 0, $src_info[0], $src_info[1]);
    //如果水印图片本身带透明色，则使用imagecopy方法
    //imagecopy($dst, $src, 10, 10, 0, 0, $src_w, $src_h);

    //输出图片
    list($dst_w, $dst_h, $dst_type) = getimagesize($dst_path);
    switch ($dst_type) {
        case 1://GIF
            imagegif($dst, $dst_path);
            break;
        case 2://JPG
            imagejpeg($dst, $dst_path);
            break;
        case 3://PNG
            imagepng($dst, $dst_path);
            break;
        default:
            break;
    }

    imagedestroy($dst);
    imagedestroy($src);

    echo "{}";

  }

}