<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Admin extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
	}
	public function login(){
		$this->load->view('login.html');
	}
	#处理登录
	public function signin(){
		$singin = false;
		$permission = -1;
		$admins[] = $this->get_admins();
		#设置验证规则
		$this->form_validation->set_rules('name','用户名','required');
		$this->form_validation->set_rules('password','密码','required');

		#验证用户名和密码
		if ($this->form_validation->run() == false){
			echo validation_errors();
		} else{
			$name = $this->input->post('name',true);
			$password = $this->input->post('password',true);
			foreach($admins['0'] as $admin){
				if($admin['name'] == $name && $admin['password'] == $password){
					$singin = true;
					$permission = $admin['permission'];
				}
			}
			if($singin == true){
				echo "ok";
				$this->session->set_userdata('admin',$name);
				$this->session->set_userdata('permission',$permission);
			}else{
				echo "用户名或密码错误";
			}
		}
	}
	public function addmanager(){
		#设置验证规则
		$this->form_validation->set_rules('name','用户名','required');
		$this->form_validation->set_rules('password','密码','required');
		$this->form_validation->set_rules('permission','权限','required');
		if ($this->form_validation->run() == false){
			echo validation_errors();
		} else{
			$data['name'] = $this->input->post('name',true);
			$data['password'] = $this->input->post('password',true);
			$data['permission'] = $this->input->post('permission',true);
			$admins[] = $this->get_admins();
			array_push($admins['0'], $data);
			$str = json_encode($admins['0'],true);
			$this->add_admin($str);
			echo "ok";
		}
	}
	public function delmanager($sel){
		$admins[] = $this->get_admins();
		unset($admins['0'][$sel]);
		$str = json_encode($admins['0'],true);
		$this->add_admin($str);
		echo "ok";
	}

	public function logout(){
		$this->session->unset_userdata('admin');
		$this->session->unset_userdata('permission');
		$this->session->sess_destroy();
		redirect('admin/login');
	}
	function get_admins(){
		ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 5.00; Windows 98)');
		$filename = base_url('admin.json');
		$message = file_get_contents($filename);
		return json_decode($message,true);
	}
	function add_admin($str){
		$filename = base_url('admin.json');
		file_put_contents('./admin.json', $str);
	}
	public function test(){
		$filename = base_url('admin.json');
		$message = file_get_contents($filename);
		$a['s1'] = $message;
		$data['name'] = '123';
		$data['password'] = '123';
		$data['permission'] = '132';
		$admins[] = $this->get_admins();
		$a['t1'] = $admins;
		array_push($admins['0'], $data);
		$a['t2'] = $admins;

		$a['s2'] = json_encode($admins['0'],true);
		$this->load->view('test.html',$a);
	}
	public function test2(){
		$this->load->view('test2.html');
	}

}