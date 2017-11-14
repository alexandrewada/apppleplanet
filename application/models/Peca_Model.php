<?php

class Peca_Model extends CI_Model
{

    private $table = 'tb_peca';


    public function getAll() {
        $query = $this->db->get($this->table);
        if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getPecasRetorno($id_os) {
        $query = $this->db->query("SELECT tb_saida_peca.id_saida_peca, tb_saida_peca.id_peca, tb_peca.nome AS 'nome_peca'FROM tb_saida_peca LEFT JOIN tb_peca ON tb_peca.id_peca = tb_saida_peca.id_peca LEFT JOIN tb_os ON tb_os.id_os_orcamento = tb_saida_peca.id_os_orcamento WHERE tb_os.id_os = ?",$id_os);

        // $query = $this->db->query("SELECT * FROM appleplanet.tb_saida_peca LEFT JOIN tb_peca ON tb_peca.id_peca = tb_saida_peca.id_peca WHERE id_os_orcamento = ? ",$id_os);
        if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getBySaida($id_saida) {  
        $query = $this->db->query("SELECT saida_peca.id_saida_peca, peca.nome as 'peca', saida_peca.quantidade as 'Qtd', saida_peca.valor_total, usuario.nome 'Vendedor' ,     DATE_FORMAT(DATE_ADD(saida_peca.data_saida, INTERVAL 3 MONTH),'%d/%m/%Y') as 'validade_garantia' , DATE_FORMAT(saida_peca.data_saida,'%d/%m/%Y') as 'data_venda' FROM appleplanet.tb_saida_peca saida_peca LEFT JOIN tb_peca peca ON peca.id_peca = saida_peca.id_peca LEFT JOIN tb_usuario usuario ON usuario.id_usuario = saida_peca.id_vendedor LEFT JOIN tb_loja loja ON loja.id_loja = saida_peca.id_loja WHERE saida_peca.id_saida_peca = ? AND saida_peca.status = 1",$id_saida);

        if($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

     public function getByID($id_peca) {  
        $query = $this->db->get_where($this->table, array('id_peca' => $id_peca, 'status' => 1));
        if($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function getByCodigoBarras($codigobarra) {  
        $query = $this->db->get_where($this->table, array('codigo_barra' => $codigobarra));
        if($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function getPecas() {
        $query = $this->db->query("SELECT tb_peca.*, tb_categoria.nome as 'categoria', tb_fornecedor.nome as 'fornecedor'FROM appleplanet.tb_peca LEFT JOIN tb_categoria ON tb_categoria.id_categoria = tb_peca.id_categoria LEFT JOIN tb_fornecedor ON tb_peca.id_fornecedor = tb_fornecedor.id_fornecedor");

        if($query->num_rows() > 0) {
            return $query->result();
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
