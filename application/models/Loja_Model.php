<?php

class Loja_Model extends CI_Model {
	private $table = 'tb_loja';



    public function getAll() {
        $query = $this->db->get($this->table);

        if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getByID($id_loja) {  
        $query = $this->db->get_where($this->table, array('id_loja' => $id_loja));
        if($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }



    public function insert($data)
    {
        if($this->db->insert($this->table, $data)) {
            return true;
        } else {
            return false;
        }
    }

    
    public function update($data,$where)
    {
        if($this->db->update($this->table, $data, $where)) {
            return true;
        } else {
            return false;
        }
    }
}