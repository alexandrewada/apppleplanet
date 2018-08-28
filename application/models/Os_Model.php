<?php

class Os_Model extends CI_Model
{

    private $table = 'tb_os';
    public  $lastID;

    public function getOsByStatus($status){

        $query = $this->db->query("
            SELECT 
                os.id_os,
                os.id_cliente
            FROM
                tb_os os
            WHERE
                os.status = ? AND
                os.id_loja = ?
            ORDER BY os.data_entrada DESC",array($status,$_SESSION['id_loja']));
        
        if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }

       
    }

    public function getAcompanhamento() {
       
    	$id_cliente = $this->session->userdata()[id_usuario];

        $query = $this->db->query("SELECT historico.id_os, os_status.status, historico.id_os_historico, os.id_cliente, usuario.nome AS 'alterado_por', perfil.nome AS 'perfil', historico.data, historico.observacao FROM appleplanet.tb_os_historico historico LEFT JOIN tb_usuario usuario ON usuario.id_usuario = historico.id_usuarioEditou LEFT JOIN tb_os os ON os.id_os = historico.id_os LEFT JOIN tb_perfil perfil ON usuario.id_perfil = perfil.id_perfil LEFT JOIN tb_os_status os_status ON os_status.id_os_status = historico.status WHERE os.status != 10 AND os.id_cliente = $id_cliente AND os.id_loja =  ".$_SESSION['id_loja']." ORDER BY historico.data DESC");
        if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }


    public function getOrcamentoByIdOS($id_os) {  
        $query = $this->db->query("SELECT usuario.id_usuario, usuario.nome,  usuario.telefone, usuario.celular, os_orcamento.status, os_orcamento.data, os_orcamento.id_os_orcamento, os.nome as 'aparelho', os.id_os, os_orcamento.pecas_usados, os_orcamento.valor FROM tb_os os LEFT JOIN tb_os_orcamento os_orcamento ON os.id_os_orcamento = os_orcamento.id_os_orcamento LEFT JOIN tb_usuario usuario ON usuario.id_usuario = os.id_cliente WHERE os.id_os = $id_os AND os.id_loja = ".$_SESSION['id_loja']);
         
        if($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function getOrcamentoByIdOSSaida($id_os) {  
        $query = $this->db->query("SELECT os.status as 'status_os' , os_orcamento.id_os_orcamento, os.nome as 'aparelho', os.id_os, os_orcamento.pecas_usados, os_orcamento.valor FROM tb_os os LEFT JOIN tb_os_orcamento os_orcamento ON os.id_os_orcamento = os_orcamento.id_os_orcamento LEFT JOIN tb_usuario usuario ON usuario.id_usuario = os.id_cliente WHERE os.id_loja = ".$_SESSION['id_loja']." AND os.id_os = $id_os AND os.status in(5,6,7,13)");
         
        if($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }


    public function getHistorico($id_user) {

        $id_cliente = $id_user;

        $query = $this->db->query("SELECT historico.id_os, os_status.status, historico.id_os_historico, os.id_cliente, usuario.nome AS 'alterado_por', perfil.nome AS 'perfil', historico.data, historico.observacao FROM appleplanet.tb_os_historico historico LEFT JOIN tb_usuario usuario ON usuario.id_usuario = historico.id_usuarioEditou LEFT JOIN tb_os os ON os.id_os = historico.id_os LEFT JOIN tb_perfil perfil ON usuario.id_perfil = perfil.id_perfil LEFT JOIN tb_os_status os_status ON os_status.id_os_status = historico.status WHERE os.id_cliente = $id_cliente AND os.id_loja = ". $_SESSION['id_loja']." ORDER BY historico.data DESC");
        if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getStatusOS($id) {
        $query = $this->db->query("SELECT * FROM appleplanet.tb_os_status WHERE id_os_status = ?",array($id));
       
        if($query->num_rows() > 0) {
            return $query->row()->status;
        } else {
            return false;
        }
    }

    

    public function aprovacaoOrcamento($id_cliente) {
        $query = $this->db->query("SELECT 
                        os_orcamento.id_os_orcamento,
                        usuario.id_usuario,
                        usuario.nome,
                        usuario.email,
                        os.nome as 'aparelho',
                        os.id_os,
                        os.defeito_declarado,
                        os.defeito_encontrado,
                        os.defeito_solucao,
                        os_orcamento.detalhes,
                        os_orcamento.pecas_usados,
                        os_orcamento.valor
                    FROM
                        tb_os os
                            LEFT JOIN
                        tb_os_orcamento os_orcamento ON os.id_os_orcamento = os_orcamento.id_os_orcamento
                            LEFT JOIN
                        tb_usuario usuario ON usuario.id_usuario = os.id_cliente
                    WHERE 
                    os.status = 4 
                    AND
                    os_orcamento.status = 0
                    AND
                    usuario.id_usuario = $id_cliente
                    AND
                    os.id_loja = ".$_SESSION['id_loja']);

        if($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }

    }

    public function getOrcamentoExistente($id) {
        $query = $this->db->query("SELECT * FROM appleplanet.tb_os_orcamento where id_os = ? and id_loja = ?",array($id,$_SESSION['id_loja']));
    
        if($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function StatusTradutorArray() {
                
        $query = $this->db->query("SELECT * FROM tb_os_status")->result();

        $status = array();

        foreach ($query as $key => $v) {
            $status[$v->id_os_status] = $v->status;
        }

        return $status;
    }


    public function getByID($id) {  
         $query = $this->db->query("SELECT tb_os.cor, tb_os.garantia_apple, tb_os.status AS 'status_os', tb_usuario.nome AS 'nome_cliente', tb_usuario.cpf AS 'cpf', tb_usuario.email, tb_usuario.senha, tb_usuario.sexo, tb_usuario.cep, tb_usuario.bairro, tb_usuario.cidade, tb_usuario.telefone, tb_usuario.celular, tb_usuario.rua, tb_usuario.rua_numero, tb_categoria.nome AS 'categoria', tb_os.*, tb_os_orcamento.valor AS 'valor_orcamento', tb_os_orcamento.status AS 'status_orcamento', tb_os_orcamento.data AS 'data_orcamento', tb_os_orcamento.pecas_usados, os_saida.data_saida FROM tb_os LEFT JOIN tb_usuario ON tb_usuario.id_usuario = tb_os.id_cliente LEFT JOIN tb_categoria ON tb_categoria.id_categoria = tb_os.id_categoria LEFT JOIN tb_os_orcamento ON tb_os_orcamento.id_os_orcamento = tb_os.id_os_orcamento LEFT JOIN tb_saida_os os_saida ON tb_os_orcamento.id_os_orcamento = os_saida.id_os_orcamento WHERE tb_os.id_os = ? AND tb_os.id_loja = ?",array($id,$_SESSION['id_loja']));
        if($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function getAll() {
        // $query = $this->db->query("SELECT  FROM tb_os LEFT JOIN tb_usuario ON tb_usuario.id_usuario = tb_os.id_cliente");
     
        $this->db->select("tb_usuario.id_usuario as id_cliente, tb_usuario.nome as nome_cliente, tb_usuario.cpf as cpf, tb_usuario.email, tb_os.*");
        $this->db->from('tb_os');
        $this->db->join('tb_usuario','tb_usuario.id_usuario = tb_os.id_cliente','left');

        if($_GET['status']){
            $this->db->where('tb_os.status',$_GET['status']);
        }

        if($_GET['orderBy']){
            $this->db->order_by($_GET['orderBy'], $_GET['order']);
        }

        $this->db->where('tb_os.id_loja',$_SESSION['id_loja']);
     

        $query = $this->db->get();

        if($query->num_rows() > 0) {

            return $query->result();
        } else {
            return false;
        }
    }
  
    public function insert($data)
    {
        if($this->db->insert($this->table, $data)) {
            $this->lastID = $this->db->insert_id();
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
