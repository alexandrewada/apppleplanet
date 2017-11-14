<?php

class Login_Model extends CI_Model {
	public function Login($email,$senha) {
		
		$this->db->where('email',$email);
		$this->db->where('senha',$senha);
		$this->db->where('status','1');
	    
	    $query = $this->db->get('tb_usuario');
	    
	    if($query->num_rows() > 0) {
	    	return $query->row_array();
	    } else {
	    	return false;
	    }
	}
}