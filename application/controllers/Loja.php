<?php

class Loja extends CI_Controller {



    public function Gerenciar() {
    	$this->load->model('Loja_Model');
        $view['Listarlojas'] = $this->Loja_Model->getAll();
        $this->template->load('template','Loja/Gerenciar',$view);
    }

    public function Editar($id_loja)
	{
		
		if($this->input->post() == true) {

				header("Content-type: application/json");

				$this->load->model("Loja_Model");

			 	$this->form_validation->set_rules('nome', 'Nome da loja', 'required');
			    $this->form_validation->set_rules('email', 'Email da loja', 'required');
                $this->form_validation->set_rules('telefone', 'Telefone da loja', 'required');
                // $this->form_validation->set_rules('celular', 'Celular da loja', 'required');
                $this->form_validation->set_rules('cep', 'Cep da loja', 'required');
                $this->form_validation->set_rules('cnpj', 'CNPJ da loja', 'required');
                $this->form_validation->set_rules('cidade', 'Cidade da loja', 'required');
                $this->form_validation->set_rules('uf', 'UF da loja', 'required');
			    $this->form_validation->set_rules('rua', 'Rua da loja', 'required');
                $this->form_validation->set_rules('rua_numero', 'Número da rua da loja', 'required|numeric');
                $this->form_validation->set_rules('bairro', 'Bairro da loja', 'required');

                if ($this->form_validation->run() == FALSE)
                {
             		echo json_encode(array('erro' => true, 'msg' => validation_errors()));
             		exit;
                }
                	else
                {

                	$dados = array();
                    $dados['nome']                      = ucwords($this->input->post('nome'));
                    $dados['cnpj']                      = $this->input->post('cnpj');
                    $dados['email']                     = $this->input->post('email');
                    $dados['telefone']                  = $this->input->post('telefone');
                    $dados['celular']                   = $this->input->post('celular');
                    $dados['descricao']                 = $this->input->post('descricao');
                    $dados['rua']                       = $this->input->post('rua');
                    $dados['rua_numero']                = $this->input->post('rua_numero');
                    $dados['cidade']                    = $this->input->post('cidade');
                    $dados['uf']                        = $this->input->post('uf');
                    $dados['cep']                       = $this->input->post('cep');
                    $dados['bairro']                    = $this->input->post('bairro');
                       
                	if($this->Loja_Model->update($dados,"id_loja = $id_loja")){
               			echo json_encode(array('erro' => false, 'msg' => 'Loja atualizada com sucesso. <script>window.location.reload();</script>'));
                	}
                }


		// Visualização
		} else {

			$this->load->model("Loja_Model");

			$loja = $this->Loja_Model->getByID($id_loja);

			if($loja != false) {
				$view['loja'] = $loja;
				$this->load->view('Loja/Editar',$view);
			} else {
				echo "Id da loja não existe";
				exit;
			}
		}
	}

	public function Cadastrar()
	{
		
		if($this->input->post() == true) {

				header("Content-type: application/json");

				$this->load->model("Loja_Model");

			 	$this->form_validation->set_rules('nome', 'Nome da loja', 'required');
			    $this->form_validation->set_rules('email', 'Email da loja', 'required');
                $this->form_validation->set_rules('telefone', 'Telefone da loja', 'required');
                // $this->form_validation->set_rules('celular', 'Celular da loja', 'required');
                $this->form_validation->set_rules('cep', 'Cep da loja', 'required');
                $this->form_validation->set_rules('cnpj', 'CNPJ da loja', 'required');
                $this->form_validation->set_rules('cidade', 'Cidade da loja', 'required');
                $this->form_validation->set_rules('uf', 'UF da loja', 'required');
			    $this->form_validation->set_rules('rua', 'Rua da loja', 'required');
                $this->form_validation->set_rules('rua_numero', 'Número da rua da loja', 'required|numeric');
                $this->form_validation->set_rules('bairro', 'Bairro da loja', 'required');

                if ($this->form_validation->run() == FALSE)
                {
             		echo json_encode(array('erro' => true, 'msg' => validation_errors()));
             		exit;
                }
                	else
                {

                	$dados = array();
                    $dados['id_criador']                = $this->session->userdata()['id_usuario'];
                    $dados['nome']                      = ucwords($this->input->post('nome'));
                    $dados['cnpj']                      = $this->input->post('cnpj');
                    $dados['email']                     = $this->input->post('email');
                    $dados['telefone']                  = $this->input->post('telefone');
                    $dados['celular']                   = $this->input->post('celular');
                    $dados['descricao']                 = $this->input->post('descricao');
                    $dados['rua']                       = $this->input->post('rua');
                    $dados['rua_numero']                = $this->input->post('rua_numero');
                    $dados['cidade']                    = $this->input->post('cidade');
                    $dados['uf']                        = $this->input->post('uf');
                    $dados['cep']                       = $this->input->post('cep');
                    $dados['bairro']                    = $this->input->post('bairro');
                    $dados['data_cadastro']             = date('Y-m-d H:i:s');
                       
                	if($this->Loja_Model->insert($dados)){
               			echo json_encode(array('erro' => false, 'msg' => 'Loja cadastrado com sucesso.'));
                	}
                }


		// Visualização
		} else {


			$this->template->set('titulo','Dados da loja');
			$this->template->load('template','Loja/Cadastrar');
		}
	}
}