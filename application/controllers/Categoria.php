<?php

class Categoria extends CI_Controller {


    public function Gerenciar() {

        $this->load->model('Categoria_Model');
        $view['Listarcategorias'] = $this->Categoria_Model->getAll();
        $this->template->load('template','Categoria/Gerenciar',$view);
    }

    public function Editar($id_categoria)
    {
        
        if($this->input->post() == true) {

                header("Content-type: application/json");

                $this->load->model("Categoria_Model");

                $this->form_validation->set_rules('nome_categoria', 'Nome da Categoria', 'required');
                
            
                if ($this->form_validation->run() == FALSE)
                {
                    echo json_encode(array('erro' => true, 'msg' => validation_errors()));
                    exit;
                }
                    else
                {



                    $dados = array();
                    $dados['nome']                      = ucwords($this->input->post('nome_categoria'));
                   
                    if($this->Categoria_Model->update($dados,"id_categoria = $id_categoria")){
                        echo json_encode(array('erro' => false, 'msg' => 'Categoria atualizado com sucesso. <script>window.location.reload();</script>'));
                    }
                }


        // Visualização
        } else {

            $this->load->model('Categoria_Model');
         

            $categoria = $this->Categoria_Model->getByID($id_categoria);

            if($categoria != false) { 
                $view['Categoria'] = $categoria;
                $this->load->view('Categoria/Editar',$view);
            } else {
                echo 'Nenhuma categoria encontrada';
            }

        }
    }

	public function Cadastrar()
	{
		
		if($this->input->post() == true) {

				header("Content-type: application/json");

				$this->load->model("Categoria_Model");

			 	$this->form_validation->set_rules('nome_categoria', 'Nome da Categoria', 'required');
			 	
			
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
                    $dados['id_usuario']                = $this->session->userdata()['id_usuario'];
                    $dados['nome']                      = ucwords($this->input->post('nome_categoria'));
                    $dados['data_cadastro']             = date('Y-m-d H:i:s');
                   
                	if($this->Categoria_Model->insert($dados)){
               			echo json_encode(array('erro' => false, 'msg' => 'Categoria cadastrado com sucesso.'));
                	}
                }


		// Visualização
		} else {
			$this->template->set('titulo','Cadastrar Categoria');
			$this->template->load('template','Categoria/Cadastrar');
		}
	}
}