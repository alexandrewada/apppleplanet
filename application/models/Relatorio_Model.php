<?php


class Relatorio_Model extends CI_Model {

	public function getTotalVendasHoje() {
		$query = $this->db->query("SELECT COUNT(*) as 'TotalVenda' FROM appleplanet.tb_saida_produto WHERE status = 1 AND date_format(data_saida,'%Y-%m-%d') = curdate()");
		if($query->num_rows() > 0) {
			return $query->row()->TotalVenda;
		} else {
			return 0;
		}
	}	

	public function getTotalProdutoBrindeHoje() {
		$query = $this->db->query("SELECT COUNT(*) as 'Brinde' FROM appleplanet.tb_saida_produto WHERE status = 3 AND date_format(data_saida,'%Y-%m-%d') = curdate()");
		if($query->num_rows() > 0) {
			return $query->row()->Brinde;
		} else {
			return 0;
		}
	}

	public function getTotalPecaBrindeHoje() {
		$query = $this->db->query("SELECT COUNT(*) as 'Brinde' FROM appleplanet.tb_saida_peca WHERE status = 3 AND date_format(data_saida,'%Y-%m-%d') = curdate()");
		if($query->num_rows() > 0) {
			return $query->row()->Brinde;
		} else {
			return 0;
		}
	}

	public function getTotalPecaGarantiaHoje() {
		$query = $this->db->query("SELECT COUNT(*) as 'Garantia' FROM appleplanet.tb_saida_peca WHERE status = 4 AND date_format(data_saida,'%Y-%m-%d') = curdate()");
		if($query->num_rows() > 0) {
			return $query->row()->Garantia;
		} else {
			return 0;
		}
	}	

	public function getTotalProdutoGarantiaHoje() {
		$query = $this->db->query("SELECT COUNT(*) as 'Garantia' FROM appleplanet.tb_saida_produto WHERE status = 4 AND date_format(data_saida,'%Y-%m-%d') = curdate()");
		if($query->num_rows() > 0) {
			return $query->row()->Garantia;
		} else {
			return 0;
		}
	}




	public function getTotalProdutos() {
		$query = $this->db->query("SELECT COUNT(*) as 'TotalProdutos' FROM appleplanet.tb_produto");
		if($query->num_rows() > 0) {
			return $query->row()->TotalProdutos;
		} else {
			return 0;
		}
	}

	public function getTotalPecas() {
		$query = $this->db->query("SELECT COUNT(*) as 'TotalPecas' FROM appleplanet.tb_peca");
		if($query->num_rows() > 0) {
			return $query->row()->TotalPecas;
		} else {
			return 0;
		}
	}


	public function getOsAberta($de=NULL,$ate=NULL) {

		if($de != NULL AND $ate != NULL) {
			$data = " AND data between '$de' AND '$ate' ";
		} else {
			$data = '';
		}

		$query = $this->db->query("SELECT count(*) as 'Total' FROM appleplanet.tb_os WHERE status != 10 $data");
		if($query->num_rows() > 0) {
			return $query->row();
		} else {
			return 0;
		}	
	}


	public function getOsFaturadas($de=NULL,$ate=NULL) {


		if($de != NULL AND $ate != NULL) {
			$data = " AND data between '$de' AND '$ate' ";
		} else {
			$data = '';
		}

		$query = $this->db->query("SELECT count(*) as 'Total' ,if(sum(valor_orcamento_total) is null,0.00,sum(valor_orcamento_total)) as 'ValorTotal' FROM appleplanet.tb_saida_os WHERE status = 1 AND date_format(data_saida,'%Y-%m-%d') = curdate()");
		if($query->num_rows() > 0) {
			return $query->row();
		} else {
			return 0;
		}	
	}

	public function getValorTotalVendasHoje() {
		$query = $this->db->query("SELECT if(sum(valor_total) is null,0.00,sum(valor_total)) as 'ValorTotal' FROM appleplanet.tb_saida_produto WHERE status = 1 AND date_format(data_saida,'%Y-%m-%d') = curdate()");
		if($query->num_rows() > 0) {
			return $query->row()->ValorTotal;
		} else {
			return false;
		}
	}

	public function getValorTotalLucroHoje() {
		$query = $this->db->query("SELECT if(sum(valor_lucro_total) is null,0.00,sum(valor_lucro_total)) as 'ValorTotal' FROM appleplanet.tb_saida_produto WHERE status = 1 AND date_format(data_saida,'%Y-%m-%d') = curdate()");
		if($query->num_rows() > 0) {
			return $query->row()->ValorTotal;
		} else {
			return false;
		}
	}

	public function getTotalClientes() {
		$query = $this->db->query("SELECT if(COUNT(*) is null,0,COUNT(*)) as TotalClientes FROM appleplanet.tb_usuario where id_perfil = 1");
		if($query->num_rows() > 0) {
			return $query->row()->TotalClientes;
		} else {
			return false;
		}
	}


	public function VendasProdutos($filtros=NULL) {
		$sql = "SELECT 
					saida_produto.id_saida_produto,
				    loja.id_loja,
				    usuario.id_usuario,
				    loja.nome as 'loja',
				    usuario.nome as 'Vendedor',
				    produto.nome as 'Produto',
				    saida_produto.quantidade as 'Quantidade',
				    produto.preco_compra as 'Custo',
				    produto.preco_venda as 'Venda',
				    saida_produto.desconto as 'Desconto',
				    saida_produto.valor_lucro_total as 'Liquido',
					formapagamento.tipo as 'FormaPagamento',
				    saida_produto.parcela as 'Parcela',
				    saida_produto.data_saida as 'Data',
				    saida_produto.status as 'status_venda'
				FROM
				    appleplanet.tb_saida_produto saida_produto
				LEFT JOIN tb_usuario usuario ON usuario.id_usuario = saida_produto.id_vendedor
				LEFT JOIN tb_produto produto ON produto.id_produto = saida_produto.id_produto
				LEFT JOIN tb_loja loja ON loja.id_loja = saida_produto.id_loja
				LEFT JOIN tb_formapagamento formapagamento ON formapagamento.id_formapagamento = saida_produto.id_formapagamento
				WHERE saida_produto.status = 1

				";

		$query = $this->db->query($sql);

		if($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}


	}

	public function AssistenciasFaturadas($filtros=NULL) {
		$sql = "SELECT 
					saida_os.id_saida_os,
				    loja.id_loja,
				    usuario.id_usuario,
				    saida_os.id_os,
				    loja.nome as 'loja',
				    usuario.nome as 'Tecnico',
				    saida_os.valor_orcamento_total as 'Venda',
				    saida_os.desconto as 'Desconto',
				    saida_os.valor_orcamento_lucro as 'Liquido',
					formapagamento.tipo as 'FormaPagamento',
				    saida_os.parcela as 'Parcela',
				    saida_os.data_saida as 'Data',
				    saida_os.status as 'status'
				FROM
				    appleplanet.tb_saida_os saida_os
				LEFT JOIN tb_usuario usuario ON usuario.id_usuario = saida_os.id_tecnico
				LEFT JOIN tb_loja loja ON loja.id_loja = saida_os.id_loja
				LEFT JOIN tb_formapagamento formapagamento ON formapagamento.id_formapagamento = saida_os.id_formapagamento";

		$query = $this->db->query($sql);

		if($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}


	}

	

}

?>