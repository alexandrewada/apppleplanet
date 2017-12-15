<?php

class Produto_Model extends CI_Model
{

    private $table = 'tb_produto';


    public function getAll() {
        $query = $this->db->get($this->table);
        if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

     public function getByID($id_produto) {  
        $query = $this->db->get_where($this->table, array('id_produto' => $id_produto, 'status' => 1));
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

     public function getBySaida($id_saida) {  
        $query = $this->db->query("SELECT saida_produto.id_saida_produto, produto.nome as 'Produto', saida_produto.quantidade as 'Qtd', saida_produto.valor_total, usuario.nome 'Vendedor' ,     DATE_FORMAT(DATE_ADD(saida_produto.data_saida, INTERVAL 3 MONTH),'%d/%m/%Y') as 'validade_garantia' , DATE_FORMAT(saida_produto.data_saida,'%d/%m/%Y') as 'data_venda' FROM appleplanet.tb_saida_produto saida_produto LEFT JOIN tb_produto produto ON produto.id_produto = saida_produto.id_produto LEFT JOIN tb_usuario usuario ON usuario.id_usuario = saida_produto.id_vendedor LEFT JOIN tb_loja loja ON loja.id_loja = saida_produto.id_loja WHERE saida_produto.id_saida_produto = ? AND saida_produto.status = 1",$id_saida);

        if($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function getInfoGarantia($id_saida_produto) {
        $query = $this->db->query("SELECT saida_produto.garantia_comprador, saida_produto.nome_comprador, saida_produto.cpf_comprador,  produto.modelo, produto.marca, produto.cor, produto.id_produto,saida_produto.id_saida_produto as id_saida , produto.nome as 'nome_produto', usuario.nome as 'nome_cliente', usuario.sexo, usuario.telefone, usuario.email, usuario.cep, usuario.celular, usuario.senha, usuario.bairro, usuario.rua, usuario.cidade, usuario.rua_numero, produto.imei, usuario.cpf, saida_produto.data_saida FROM appleplanet.tb_saida_produto saida_produto LEFT JOIN tb_produto produto ON produto.id_produto = saida_produto.id_produto LEFT JOIN tb_usuario usuario ON usuario.id_usuario = saida_produto.id_vendedor WHERE saida_produto.id_saida_produto = ? and saida_produto.status = 1",array($id_saida_produto));
    
        if($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }


    public function getProdutos() {
        $query = $this->db->query("SELECT tb_produto.*, tb_categoria.nome as 'categoria', tb_fornecedor.nome as 'fornecedor'FROM appleplanet.tb_produto LEFT JOIN tb_categoria ON tb_categoria.id_categoria = tb_produto.id_categoria LEFT JOIN tb_fornecedor ON tb_produto.id_fornecedor = tb_fornecedor.id_fornecedor");

        if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getProdutosEstoque() {
        $query = $this->db->query("SELECT tb_produto.*, tb_categoria.nome as 'categoria', tb_fornecedor.nome as 'fornecedor'FROM appleplanet.tb_produto LEFT JOIN tb_categoria ON tb_categoria.id_categoria = tb_produto.id_categoria LEFT JOIN tb_fornecedor ON tb_produto.id_fornecedor = tb_fornecedor.id_fornecedor WHERE tb_produto.estoque_minimo_aviso <= tb_produto.estoque_atual ORDER BY tb_produto.estoque_atual ASC,tb_produto.estoque_minimo_aviso DESC");

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
