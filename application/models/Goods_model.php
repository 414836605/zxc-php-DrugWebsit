<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Goods_model extends CI_Model{
	const TBL_A = 'spzl';
	const TBL_B = 'phspkc';
	public function select_all($like){
		$sql = "select a.spbh,a.spmch,a.shpgg,a.dw,a.shengccj,b.pihao,b.sxrq,a.spid from spzl a(nolock) inner join phspkc b(nolock) on a.spid=b.spid group by a.spid,a.spbh,a.spmch,a.shpgg,a.dw,a.shengccj,b.pihao,b.sxrq";
		// $this->db->select('*');
		// $this->db->from(self::TBL_A);
		// $this->db->join(self::TBL_B, self::TBL_A.'.spid='.self::TBL_B.'.spid', 'inner');
		// $this->db->like(self::TBL_A.'.pym', $like);
		// $this->db->limit(500, 0);
		// $query = $this->db->get();
		$query = $this->db->query($sql,array($like,$like,$like));
		$result = $query->result_array();
		foreach ($result as $key => $value) {
			$result[$key]['spmch'] = preg_replace("/ ([\s\S]*)$/", '', $value['spmch']);
			$result[$key]['shpgg'] = preg_replace("/ ([\s\S]*)$/", '', $value['shpgg']);
			$result[$key]['dw'] = preg_replace("/ ([\s\S]*)$/", '', $value['dw']);
			$result[$key]['shengccj'] = preg_replace("/ ([\s\S]*)$/", '', $value['shengccj']);
		}
		return $result;
	}
	public function select_all2($like){
		$sql = "select a.spbh,a.spmch,a.shpgg,a.dw,a.shengccj,b.pihao,b.sxrq,a.spid from spzl a(nolock) inner join phspkc b(nolock) on a.spid=b.spid where b.pihao like '%$like%' group by a.spid,a.spbh,a.spmch,a.shpgg,a.dw,a.shengccj,b.pihao,b.sxrq";
		// $this->db->select('*');
		// $this->db->from(self::TBL_A);
		// $this->db->join(self::TBL_B, self::TBL_A.'.spid='.self::TBL_B.'.spid', 'inner');
		// $this->db->like(self::TBL_A.'.pym', $like);
		// $this->db->limit(500, 0);
		// $query = $this->db->get();
		$query = $this->db->query($sql,array($like,$like,$like));
		$result = $query->result_array();
		foreach ($result as $key => $value) {
			$result[$key]['spmch'] = preg_replace("/ ([\s\S]*)$/", '', $value['spmch']);
			$result[$key]['shpgg'] = preg_replace("/ ([\s\S]*)$/", '', $value['shpgg']);
			$result[$key]['dw'] = preg_replace("/ ([\s\S]*)$/", '', $value['dw']);
			$result[$key]['shengccj'] = preg_replace("/ ([\s\S]*)$/", '', $value['shengccj']);
		}
		return $result;
	}
	public function select($like, $limit, $offset){
		// $this->db->select('*');
		// $this->db->from(self::TBL_A);
		// $this->db->join(self::TBL_B, self::TBL_A.'.spid='.self::TBL_B.'.spid', 'inner');
		// $this->db->like(self::TBL_A.'.pym', $like);
		// $this->db->or_like(self::TBL_A.'.sptm', $like);
		// $this->db->limit(500);
		// $query = $this->db->get();
		return $this->arr_limit($like, $limit, $offset);
	}
	public function get_all(){
		$this->db->select('*');
		$this->db->from(self::TBL_A);
		$this->db->join(self::TBL_B, self::TBL_A.'.spid='.self::TBL_B.'.spid', 'inner');
		$this->db->limit(500, 0);
		$query = $this->db->get();
		$result = $query->result_array();
		foreach ($result as $key => $value) {
			$result[$key]['spmch'] = preg_replace("/ ([\s\S]*)$/", '', $value['spmch']);
			$result[$key]['shpgg'] = preg_replace("/ ([\s\S]*)$/", '', $value['shpgg']);
			$result[$key]['dw'] = preg_replace("/ ([\s\S]*)$/", '', $value['dw']);
			$result[$key]['shengccj'] = preg_replace("/ ([\s\S]*)$/", '', $value['shengccj']);
		}
		return $result;
	}

	public function get_sel($id){
		$this->db->select('*');
		$this->db->from(self::TBL_A);
		$this->db->join(self::TBL_B, self::TBL_A.'.spid='.self::TBL_B.'.spid', 'inner');
		$this->db->where(self::TBL_A.'.spid=',$id);
		$this->db->limit(500, 0);
		$query = $this->db->get();
		$result = $query->row_array();

		$result['spmch'] = preg_replace("/ ([\s\S]*)$/", '', $result['spmch']);
		$result['shpgg'] = preg_replace("/ ([\s\S]*)$/", '', $result['shpgg']);
		$result['dw'] = preg_replace("/ ([\s\S]*)$/", '', $result['dw']);
		$result['shengccj'] = preg_replace("/ ([\s\S]*)$/", '', $result['shengccj']);
		
		return $result;
	}
	private function arr_limit($arr, $limit, $offset){
		$array = array();
		for($i = 0; $i < $limit; $i++){
			if(($offset+$i)>=count($arr)) return $array;
			$array[$i] = $arr[$offset+$i];
		}
		return $array;
	}

	
}