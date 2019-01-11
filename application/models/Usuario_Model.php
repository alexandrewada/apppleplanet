<?php

class Usuario_Model extends CI_Model
{

    private $table = 'tb_usuario';

    public function UsuarioExiste($email) {
   		$query = $this->db->get_where($this->table, array('id_loja' => $_SESSION['id_loja'], 'email' => $email));
   		if($query->num_rows() > 0) {
   			return $query->row();
   		} else {
   			return false;
   		}
    }

    public function getAll() {
    	$query = $this->db->get($this->table);
    	$this->db->order_by("id_usuario", "desc");
    	if($query->num_rows() > 0) {
    		return $query->result();
    	} else {
    		return false;
    	}
    }

    public function getByID($id_usuario) {  
        $query = $this->db->get_where($this->table, array('id_usuario' => $id_usuario));
        if($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function getByCPF($cpf) {  
        $query = $this->db->get_where($this->table, array('id_loja' => $_SESSION['id_loja'], 'cpf' => $cpf, 'status' => 1));
        if($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function getByCNPJ($cnpj) {  
        $query = $this->db->get_where($this->table, array('id_loja' => $_SESSION['id_loja'], 'cnpj' => $cnpj, 'status' => 1));
        if($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function ListarClientes() {
        $query = $this->db->query("SELECT tb_usuario.*, tb_perfil.nome AS 'perfil', tb_loja.nome AS 'loja'FROM appleplanet.tb_usuario LEFT JOIN tb_perfil ON tb_perfil.id_perfil = tb_usuario.id_perfil LEFT JOIN tb_loja ON tb_loja.id_loja = tb_usuario.id_loja WHERE tb_loja.id_loja = ?",array($_SESSION['id_loja'])); 
        if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getClientesLoja() {

        $wheres['id_loja']      = $_SESSION['id_loja'];
        $wheres['id_perfil']    = 1;
        
        $query = $this->db->get_where($this->table, $wheres);
        if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function contarAcesso($id_usuario) {
    	$query = $this->db->query("UPDATE $this->table SET data_ultimo_acesso = '".date('Y-m-d H:i:s')."' , acessos = acessos + 1 WHERE id_usuario = ?",array($id_usuario));
    	if($query) {
    		return true;
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
