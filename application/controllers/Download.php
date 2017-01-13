<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Download extends Admin_Controller {
public function do_download($id)
{ 
    $path = './uploads/'.$id.'/';
    if(!is_dir($path)){
        mkdir($path);
    }
    if($this->dir_is_empty($path)){
        $mes['message'] = "里面没有图片";
        $mes['url'] = site_url('home/index');
        $this->load->view('message.html',$mes);
    }else{
        $this->load->library('zip');
        $this->zip->read_dir($path);
        $this->zip->download('img_'.$id.'.zip');
    }
}

    function dir_is_empty($dir){
    if($handle = opendir($dir)){  
        while($item = readdir($handle)){  
         if ($item != '.' && $item != '..')
            return false;  
            } 
         } return true;
    }
}