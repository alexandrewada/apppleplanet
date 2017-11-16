<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */


	public function Abas($id_usuario) {

		$os_vinculadas = $this->db->query("SELECT tb_os.data_entrada, tb_os.id_os, tb_os.nome, tb_os_status.status FROM tb_os LEFT JOIN tb_os_status ON tb_os_status.id_os_status = tb_os.status WHERE id_cliente = ?",array($id_usuario))->num_rows(); 

		$view['id_usuario'] 		= $id_usuario;
		$view['os_vinculadas']		= $os_vinculadas;
		$this->load->view('Usuario/Abas',$view);
	}

	public function Gerenciar() {

		$this->load->model('Usuario_Model');


		$view['ListarUsuarios'] = $this->Usuario_Model->ListarClientes();
		$this->template->set('titulo','Gerenciar Usuário');
		$this->template->load('template','Usuario/Gerenciar',$view);
	}


	public function Editar($id_usuario) {
		if($this->input->post() == true) {
				
				header("Content-type: application/json");

				$this->load->model("Usuario_Model");


				$dadosUserAtual = $this->Usuario_Model->getByID($id_usuario);


			 	$this->form_validation->set_rules('nome', 'Nome', 'required|min_length[5]|max_length[30]');
				$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			 	$this->form_validation->set_rules('senha', 'Senha', 'required|min_length[6]|max_length[12]');
			 	$this->form_validation->set_rules('telefone', 'Telefone', 'required|min_length[14]|max_length[14]');
			 	$this->form_validation->set_rules('celular', 'Celular', 'min_length[16]|max_length[16]');
				$this->form_validation->set_rules('sexo', 'Sexo', 'required');
				$this->form_validation->set_rules('tipo_usuario', 'Tipo Usuário', 'required');
				// $this->form_validation->set_rules('data_nascimento', 'Data de nascimento', 'required|min_length[10]|max_length[10]');

				if($dadosUserAtual->id_perfil != $this->input->post('perfil')){
					if($_SESSION['id_perfil'] != 2){
						echo json_encode(array('erro' => true, 'msg' => 'Você não tem permissão para alterar o perfil.'));
						exit;
					}
				}
				
				if($this->input->post('tipo_usuario') == 'pf'){
					$this->form_validation->set_rules('cpf', 'CPF', 'required|min_length[14]|max_length[14]');
				} else if($this->input->post('tipo_usuario') == 'pj') {
					$this->form_validation->set_rules('cnpj', 'CNPJ', 'required|exact_length[18]');
				}

				$this->form_validation->set_rules('perfil', 'Perfil', 'required','integer');
				$this->form_validation->set_rules('cep', 'CEP', 'min_length[9]|max_length[9]');

				$this->form_validation->set_error_delimiters();


				if(valid_email($this->input->post('email')) != true) {
					echo json_encode(array('erro' => true, 'msg' => 'O email '. $this->input->post('email') . ' está errado.'));
					exit;
				}				


                if ($this->form_validation->run() == FALSE)
                {
             		echo json_encode(array('erro' => true, 'msg' => validation_errors()));
             		exit;
                }
                	else
                {

                	$dados = array();
                	$dados['nome'] 						= ucwords($this->input->post('nome'));
                	$dados['id_perfil'] 				= $this->input->post('perfil');
                	$dados['id_loja']					= $_SESSION['id_loja'];
                	$dados['id_criador']				= $_SESSION['id_criador'];
                	$dados['email'] 					= $this->input->post('email');
                	$dados['cpf'] 						= $this->input->post('cpf');
                	$dados['cnpj'] 						= $this->input->post('cnpj');
                	$dados['sexo'] 						= $this->input->post('sexo');
                	$dados['senha'] 					= $this->input->post('senha');
                	$dados['status']					= $this->input->post('status');
                	$dados['telefone'] 					= $this->input->post('telefone');
                	$dados['celular'] 					= $this->input->post('celular');
                	$dados['cep']						= $this->input->post('cep');
                   	$dados['cidade']					= $this->input->post('cidade');
                   	$dados['uf']						= $this->input->post('uf');
                   	$dados['ie']						= $this->input->post('ie');
                   	$dados['complemento']				= $this->input->post('complemento');
                   	$dados['rua']						= $this->input->post('rua');
                   	$dados['rua_numero']				= $this->input->post('rua_numero');
                   	$dados['bairro']					= $this->input->post('bairro');
                	$dados['ip']						= $_SERVER['HTTP_X_FORWARDED_FOR'];
                	$dados['data_nascimento'] 			= date('Y-m-d',strtotime($this->input->post('data_nascimento')));
                	$dados['data_criacao'] 				= date('Y-m-d H:i:s');
                	$dados['data_ultimo_acesso'] 		= date('Y-m-d H:i:s');
                	
                	if($this->Usuario_Model->update($dados,"id_usuario = $id_usuario")){
               			echo json_encode(array('erro' => false, 'msg' => 'Cliente atualizado com sucesso.'));
                	}
                }

		} else {
			$this->load->model('Usuario_Model');
			

			$user = $this->Usuario_Model->getByID($id_usuario);

			if($user != false) { 
				$view['usuario'] = $user;
				$this->load->model("Perfil_Model");
				$view['perfil'] = $this->Perfil_Model->getAll();
				$this->load->view('Usuario/Editar',$view);		
			} else {
				echo 'Usuário não encontrado';
			}
		}
	}


	public function Cadastrar()
	{
		
		if($this->input->post() == true) {

				header("Content-type: application/json");

				$this->load->model("Usuario_Model");

			 	$this->form_validation->set_rules('nome', 'Nome', 'required|min_length[5]|max_length[40]');
				$this->form_validation->set_rules('tipo_usuario', 'Tipo de usuário', 'required|exact_length[2]');
				$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			 	$this->form_validation->set_rules('senha', 'Senha', 'required|min_length[6]|max_length[12]');
			 	$this->form_validation->set_rules('telefone', 'Telefone', 'required|min_length[14]|max_length[14]');
			 	$this->form_validation->set_rules('celular', 'Celular', 'min_length[16]|max_length[16]');
				$this->form_validation->set_rules('sexo', 'Sexo', 'required');
				// $this->form_validation->set_rules('data_nascimento', 'Data de nascimento', 'required|min_length[10]|max_length[10]');
				
				if($this->input->post('tipo_usuario') == 'pj'){
					$this->form_validation->set_rules('cnpj', 'CNPJ', 'required|exact_length[18]');
					// $this->form_validation->set_rules('ie', 'IE', 'required');
			
					if($this->Usuario_Model->getByCNPJ($this->input->post('cnpj')) != false) {
						echo json_encode(array('erro' => true, 'msg' => 'O CNPJ '. $this->input->post('cnpj') . ' já existe em nosso banco de dados.'));
						exit;
					}
				}

				if($this->input->post('tipo_usuario') == 'pf'){
					$this->form_validation->set_rules('cpf', 'CPF', 'required|min_length[14]|max_length[14]');
				}

				$this->form_validation->set_rules('perfil', 'Perfil', 'required','integer');
				$this->form_validation->set_rules('cep', 'CEP', 'min_length[9]|max_length[9]');

				$this->form_validation->set_error_delimiters();

				if($this->Usuario_Model->UsuarioExiste($this->input->post('email')) != false) {
					echo json_encode(array('erro' => true, 'msg' => 'O email '. $this->input->post('email') . ' já existe em nosso banco de dados.'));
					exit;
				}

				if($this->input->post('tipo_usuario') == 'pf'){
					if($this->Usuario_Model->getByCPF($this->input->post('cpf')) != false) {
						echo json_encode(array('erro' => true, 'msg' => 'O CPF '. $this->input->post('cpf') . ' já existe em nosso banco de dados.'));
						exit;
					}
				}

				if(valid_email($this->input->post('email')) != true) {
					echo json_encode(array('erro' => true, 'msg' => 'O email '. $this->input->post('email') . ' está errado.'));
					exit;
				}				


                if ($this->form_validation->run() == FALSE)
                {
             		echo json_encode(array('erro' => true, 'msg' => validation_errors()));
             		exit;
                }
                	else
                {

                	$dados = array();
                	$dados['nome'] 						= ucwords($this->input->post('nome'));
                	$dados['id_perfil'] 				= $this->input->post('perfil');
                	$dados['id_loja']					= ($this->input->post('loja_id')) ? $_SESSION['id_loja'] : $this->input->post('loja_id');
                	$dados['id_criador']				= $_SESSION['id_criador'];
                	$dados['email'] 					= $this->input->post('email');
                	
                	if($this->input->post('tipo_usuario') == 'pf'){
                		$dados['cpf'] 						= $this->input->post('cpf');
                	} else 	if($this->input->post('tipo_usuario') == 'pj'){ 
                		$dados['cnpj'] 						= $this->input->post('cnpj');
                	}
                
                	$dados['tipo_usuario']				= $this->input->post('tipo_usuario');
                	$dados['sexo'] 						= $this->input->post('sexo');
                	$dados['senha'] 					= $this->input->post('senha');
                	$dados['telefone'] 					= $this->input->post('telefone');
                	$dados['celular'] 					= $this->input->post('celular');
                	$dados['cep']						= $this->input->post('cep');
                   	$dados['cidade']					= $this->input->post('cidade');
                   	$dados['uf']						= $this->input->post('uf');
                   	$dados['rua']						= $this->input->post('rua');
                   	$dados['ie']						= $this->input->post('ie');
                   	$dados['complemento']				= $this->input->post('complemento');
                   	$dados['rua_numero']				= $this->input->post('rua_numero');
                   	$dados['bairro']					= $this->input->post('bairro');
                	$dados['ip']						= $_SERVER['HTTP_X_FORWARDED_FOR'];
                	// $dados['data_nascimento'] 			= date('Y-m-d',strtotime($this->input->post('data_nascimento')));
                	$dados['data_criacao'] 				= date('Y-m-d H:i:s');
                	$dados['data_ultimo_acesso'] 		= date('Y-m-d H:i:s');
                	
                	if($this->Usuario_Model->insert($dados)){
               			echo json_encode(array('erro' => false, 'msg' => 'Cliente cadastrado com sucesso redirecionando <script>window.location.href = "'.base_url('usuario/gerenciar').'"; </script>.'));
                	}
                }


		// Visualização
		} else {
			$this->load->model("Loja_Model");
			$this->load->model("Perfil_Model");

			$view['lojas'] 	= $this->Loja_Model->getAll();
			$view['perfil'] = $this->Perfil_Model->getAll();

			$this->template->set('titulo','Cadastrar Usuário');
			$this->template->load('template','Usuario/Cadastrar',$view);
		}
	}
}
