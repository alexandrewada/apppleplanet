<?php

class Fornecedor extends CI_Controller {


    public function Gerenciar() {

        $this->load->model('Fornecedor_Model');
        $view['Listarfornecedores'] = $this->Fornecedor_Model->getAll();
        $this->template->load('template','Fornecedor/Gerenciar',$view);
    }

    public function Editar($id_fornecedor)
    {
        
        if($this->input->post() == true) {

                header("Content-type: application/json");

                $this->load->model("Fornecedor_Model");

                $this->form_validation->set_rules('nome', 'Nome do Fornecedor', 'required');
                $this->form_validation->set_rules('email', 'Email do Fornecedor', 'required');
                $this->form_validation->set_rules('telefone', 'Telefone do Fornecedor', 'required');
                $this->form_validation->set_rules('celular', 'Celular do Fornecedor', 'required');
                $this->form_validation->set_rules('cep', 'Cep do Fornecedor', 'required');
                $this->form_validation->set_rules('cidade', 'Cidade do Fornecedor', 'required');
                $this->form_validation->set_rules('uf', 'UF do Fornecedor', 'required');
                $this->form_validation->set_rules('rua', 'Rua do Fornecedor', 'required');
                $this->form_validation->set_rules('rua_numero', 'Número da rua do Fornecedor', 'required|numeric');
                $this->form_validation->set_rules('bairro', 'Bairro do Fornecedor', 'required');

                if ($this->form_validation->run() == FALSE)
                {
                    echo json_encode(array('erro' => true, 'msg' => validation_errors()));
                    exit;
                }
                    else
                {

                    $dados = array();
                    $dados['id_categoria']              = $this->input->post('id_categoria');
                    $dados['nome']                      = ucwords($this->input->post('nome'));
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
                       
                    if($this->Fornecedor_Model->update($dados,"id_fornecedor = $id_fornecedor")){
                        echo json_encode(array('erro' => false, 'msg' => 'Fornecedor atualizado com sucesso. <script>window.location.reload();</script>'));
                    }
                }


        // Visualização
        } else {

            $this->load->model("Fornecedor_Model");
            $this->load->model("Categoria_Model");
            
            $view['Categorias'] = $this->Categoria_Model->getAll();

            $fornecedor = $this->Fornecedor_Model->getByID($id_fornecedor);

            if($fornecedor != false) { 
                $view['fornecedor'] = $fornecedor;
                $this->load->view('Fornecedor/Editar',$view);
            } else {
                echo 'Nenhuma fornecedor encontrada';
            }

        }
    }

	public function Cadastrar()
	{
		
		if($this->input->post() == true) {

				header("Content-type: application/json");

				$this->load->model("Fornecedor_Model");

			 	$this->form_validation->set_rules('nome', 'Nome do Fornecedor', 'required');
			    $this->form_validation->set_rules('email', 'Email do Fornecedor', 'required');
                $this->form_validation->set_rules('telefone', 'Telefone do Fornecedor', 'required');
                $this->form_validation->set_rules('celular', 'Celular do Fornecedor', 'required');
                $this->form_validation->set_rules('cep', 'Cep do Fornecedor', 'required');
                $this->form_validation->set_rules('cidade', 'Cidade do Fornecedor', 'required');
                $this->form_validation->set_rules('uf', 'UF do Fornecedor', 'required');
			    $this->form_validation->set_rules('rua', 'Rua do Fornecedor', 'required');
                $this->form_validation->set_rules('rua_numero', 'Número da rua do Fornecedor', 'required|numeric');
                $this->form_validation->set_rules('bairro', 'Bairro do Fornecedor', 'required');

                if ($this->form_validation->run() == FALSE)
                {
             		echo json_encode(array('erro' => true, 'msg' => validation_errors()));
             		exit;
                }
                	else
                {

                	$dados = array();
                    $dados['id_categoria']              = $this->input->post('id_categoria');
                    $dados['id_loja']             		= $_SESSION['id_loja'];
                    $dados['id_criador']                = $this->session->userdata()['id_usuario'];
                    $dados['nome']                      = ucwords($this->input->post('nome'));
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
                       
                	if($this->Fornecedor_Model->insert($dados)){
               			echo json_encode(array('erro' => false, 'msg' => 'Fornecedor cadastrado com sucesso.'));
                	}
                }


		// Visualização
		} else {

            $this->load->model("Categoria_Model");
            $view['Categorias'] = $this->Categoria_Model->getAll();

			$this->template->set('titulo','Dados do Fornecedor');
			$this->template->load('template','Fornecedor/Cadastrar',$view);
		}
	}
}