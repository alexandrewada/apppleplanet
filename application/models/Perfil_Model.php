<?php

class Perfil_Model extends CI_Model{

	public function getAll() {
		$query = $this->db->query("SELECT * FROM appleplanet.tb_perfil");

		if($query->num_rows() > 0 ) {
			return $query->result();
		} else {
			return false;
		}
	}

}