<?php


class Perfil_Model extends CI_Model{

	public function getAll() {
		$query = $this->db->query("SELECT * FROM appleplanet.tb_perfil WHERE tb_perfil.id_loja = ?",array($_SESSION['id_loja']));

		if($query->num_rows() > 0 ) {


			return $query->result();
		} else {
			return false;
		}
	}

}