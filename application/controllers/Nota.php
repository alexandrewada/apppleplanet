<?php

class Nota extends CI_Controller {
	
	public function Cancelar() {
		$this->template->load('template','Nota/Cancelar');
	}

	public function Gerenciar() {
		$query = $this->db->query("SELECT 
										    nfe.id_nfe,
										    nfe.url_pdf,
										    nfe.chave,
										    nfe.data,
										    user.nome,
										    sp.nome_comprador,
										    sp.cpf_comprador,
										    sp.valor_total
										FROM
										    tb_nfe nfe
										        LEFT JOIN
										    tb_saida_produto sp ON nfe.id_nfe = sp.id_nfe
												LEFT JOIN
											tb_usuario user ON user.id_usuario = sp.id_vendedor
										WHERE sp.id_saida_produto is not null ORDER BY nfe.id_nfe");

		$view['lista'] = $query->result();
		$this->template->load('template','Nota/Gerenciar',$view);
	}

	public function Cancelarnota()
	{
		if($this->input->post() == true) {
				header("Content-type: application/json");
			 	$this->form_validation->set_rules('chave', 'Chave de acesso', 'required|numeric|exact_length[44]');
			 	$this->form_validation->set_rules('nprot', 'Número do protocolo', 'required|numeric|min_length[15]');	
			 	$this->form_validation->set_rules('motivo', 'Motivo do cancelamento', 'required|min_length[15]');
    		
	    		if($this->form_validation->run() == FALSE)
	            {
	                echo json_encode(array('erro' => true, 'msg' => validation_errors()));
	                exit;
	            } else {
	            
	        	   	$this->load->library('Notafiscal');
        			$nota 		= new Notafiscal();
        			$retorno 	= $nota->cancelarNota($this->input->post('chave'),$this->input->post('nprot'),$this->input->post('motivo'));
	            	echo json_encode(array('erro' => false, 'msg' => $retorno[evento][0][xMotivo] . '<br> cStat é '.$retorno[evento][0][cStat]. ' procure no google'));
	                exit;
	            }
		}
	}		 	
}