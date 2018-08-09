<?php

class Comment_Model extends CI_Model
{

    private $table = 'tb_comment';


    public function getAll() {
    	$this->db->order_by('nome','ASC');
    	$query = $this->db->get($this->table);

    	if($query->num_rows() > 0) {
    		return $query->result();
    	} else {
    		return false;
    	}

    }

     public function getByID($id) {  
        $query = $this->db->get_where($this->table, array('id_categoria' => $id));
        if($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function getComments($tipo,$id_ref){

        $this->db->select("c.*, u.nome as author ");
        $this->db->from($this->table . ' as c');
        $this->db->join('tb_usuario as u', 'u.id_usuario = c.id_author', 'left');
        $this->db->where(array('c.id_ref' => $id_ref,'c.origem' => $tipo));
        $this->db->order_by('c.data','DESC');
        
        $query = $this->db->get();

    	if($query->num_rows() > 0) {
    		return $query->result();
    	} else {
    		return false;
    	}
    }

    public function Comentar($tipo,$id_author,$id_ref,$texto) {
        $ins = [
            'origem'        => $tipo,
            'id_author'     => $id_author,
            'id_ref'        => $id_ref,
            'mensagem'      => $texto,
            'data'          => date('Y-m-d H:i:s')
        ];

        return $this->insert($ins);
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
