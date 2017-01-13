<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Controller extends CI_Controller{
		public function __construct(){
		parent::__construct();

		#权限验证
		if (! $this->session->userdata('admin')){
			redirect('admin/login');
		}
	}
}