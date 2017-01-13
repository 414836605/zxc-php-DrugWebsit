<?php
defined('BASEPATH') OR exit('No direct script access allowed');


Class Home extends Admin_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('goods_model');
		$this->load->library('pagination');
	}
	public function index($offset=0){
		$good_all=array();
		if($this->input->post('like',true) != null){
			$this->session->set_userdata('like', $this->input->post('like',true));
			$like = $this->session->userdata('like');
			$good_all = $this->goods_model->select_all($like);
			$str = json_encode($good_all,true);
			file_put_contents('./good_all.json', $str);
		}else{
			$this->session->set_userdata('like', null);
		}
		if($this->input->post('like2',true) != null){
			$this->session->set_userdata('like2', $this->input->post('like2',true));
			$like2 = $this->session->userdata('like2');
			$good_all = $this->goods_model->select_all2($like2);
			$str = json_encode($good_all,true);
			file_put_contents('./good_all.json', $str);
		}else{
			$this->session->set_userdata('like2', null);
		}
		$message = file_get_contents('./good_all.json');
		$good_all = json_decode($message, true);

		$data['admin'] = $this->session->userdata('admin');
		$data['permission'] = $this->session->userdata('permission');
		$like = $this->session->userdata('like');
		$data['like'] = $this->session->userdata('like');
		$data['like2'] = $this->session->userdata('like2');

		$config['base_url'] = site_url('home/index').'/';
		$config['total_rows'] = count($good_all);
		$config['per_page'] = 8;
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['next_link'] = '&gt;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		$this->pagination->initialize($config);
		$data['page'] = $this->pagination->create_links();
		$data['goods'] = $this->goods_model->select($good_all, $config['per_page'], $offset);
		
		$this->load->view('header.inc.html', $data);
		$this->load->view('home.html');
		$this->load->view('footer.inc.html');
	}
	// public function select(){
	// 	$like = $this->input->post('like',true);
	// 	$data['admin'] = $this->session->userdata('admin');
	// 	$data['permission'] = $this->session->userdata('permission');
	// 	$data['goods'] = $this->goods_model->select($like);
	// 	$this->load->view('header.inc.html', $data);
	// 	$this->load->view('home.html');
	// }
	public function manage(){
		$data['admin'] = $this->session->userdata('admin');
		$data['permission'] = $this->session->userdata('permission');
		$data['admins'] = $this->get_admins();
		if ($data['permission'] == 0) {
			$this->load->view('header.inc.html', $data);
			$this->load->view('manage.html');
			$this->load->view('footer.inc.html');
		}else{
			$mes['message'] = "权限不足";
			$mes['url'] = site_url('home/index');
			$this->load->view('message.html', $mes);
		}
		
	}
	public function addmanager(){
		$data['admin'] = $this->session->userdata('admin');
		$data['permission'] = $this->session->userdata('permission');
		$data['admins'] = $this->get_admins();
		if ($data['permission'] == 0) {
			$this->load->view('header.inc.html', $data);
			$this->load->view('addmanager.html');
			$this->load->view('footer.inc.html');
		}else{
			$mes['message'] = "权限不足";
			$mes['url'] = site_url('home/index');
			$this->load->view('message.html', $mes);
		}
	}
	public function upload($id = null){
		$data['admin'] = $this->session->userdata('admin');
		$data['permission'] = $this->session->userdata('permission');
		$data['id'] = $id;
		$data['selected'] = $this->goods_model->get_sel($id);
		if($data['permission'] == 0 || $data['permission'] == 1){
			$this->load->view('header.inc.html', $data);
			$this->load->view('upload.html');
			$this->load->view('footer.inc.html');

		}else{
			$mes['message'] = "权限不足";
			$mes['url'] = site_url('home/index');
			$this->load->view('message.html', $mes);
		}
	}
	public function download($id = null){
		$data['admin'] = $this->session->userdata('admin');
		$data['permission'] = $this->session->userdata('permission');
		$data['goods'] = $this->goods_model->get_all();
		if($id == null){
			$data['id'] = $data['goods']['0']['id'];
		}else{
			$data['id'] = $id;
		}
		$data['selected'] = $this->goods_model->get_sel($data['id']);
		$this->load->view('header.inc.html', $data);
		$this->load->view('download.html');
		$this->load->view('footer.inc.html');
	}

	function get_admins(){
		$filename = base_url('admin.json');
		$message = file_get_contents($filename);
		return json_decode($message,true);
	}
}