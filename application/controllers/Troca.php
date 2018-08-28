<?php

class Troca extends CI_Controller {



	private function upload_files($path, $title, $files)
    {
        $config = array(
            'upload_path'   => $path,
            'allowed_types' => 'gif|jpg|png|JPEG|jpeg|bmp',
            'overwrite'     => 1,                       
        );

        $this->load->library('upload', $config);

        $images = array();

        foreach ($files['name'] as $key => $image) {
            $_FILES['fotos[]']['name']= $files['name'][$key];
            $_FILES['fotos[]']['type']= $files['type'][$key];
            $_FILES['fotos[]']['tmp_name']= $files['tmp_name'][$key];
            $_FILES['fotos[]']['error']= $files['error'][$key];
            $_FILES['fotos[]']['size']= $files['size'][$key];

            $fileName = $title .'_'. $image;

            $images[] = $fileName;

            $config['file_name'] = $fileName;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('fotos[]')) {
                $this->upload->data();
            } else {
                return false;
            }
        }

        return $images;
    }



	public function Cadastrar(){



		if($this->input->post()){


				header("Content-Type: application/json");
				$this->load->model("Usuario_Model");
				$this->load->model("Produto_Model");

			 	$this->form_validation->set_rules('nome', 'Nome', 'required|min_length[5]|max_length[40]');
				$this->form_validation->set_rules('tipo_usuario', 'Tipo de usuário', 'required|exact_length[2]');
				$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			 	$this->form_validation->set_rules('senha', 'Senha', 'required|min_length[6]|max_length[12]');
			 	$this->form_validation->set_rules('telefone', 'Telefone', 'required|min_length[14]|max_length[14]');
			 	$this->form_validation->set_rules('celular', 'Celular', 'min_length[16]|max_length[16]');
				$this->form_validation->set_rules('sexo', 'Sexo', 'required');
				$this->form_validation->set_rules('nome_produto', 'Nome do produto', 'required|min_length[6]|max_length[40]');
			 	// $this->form_validation->set_rules('marca_produto', 'Marca do produto', 'required');
			 	$this->form_validation->set_rules('modelo_produto', 'Modelo do produto', 'required');
			 	$this->form_validation->set_rules('estado', 'Estado do produto', 'required');
				$this->form_validation->set_rules('id_categoria', 'Categoria', 'required|integer');
			 	$this->form_validation->set_rules('preco_compra', 'Preço de Negociação', 'required|decimal|greater_than[0]');

				$this->form_validation->set_rules('cep', 'CEP', 'required|min_length[9]|max_length[9]');
				$this->form_validation->set_rules('cidade', 'Cidade', 'required');
				$this->form_validation->set_rules('id_categoria', 'Categoria', 'required');
				$this->form_validation->set_rules('uf', 'UF', 'required');
				$this->form_validation->set_rules('rua', 'Rua', 'required');
				$this->form_validation->set_rules('bairro', 'Bairro', 'required');
				$this->form_validation->set_rules('forma_pagamento', 'Forma Pagamento', 'required');


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
					$this->form_validation->set_rules('rg', 'RG', 'required|min_length[12]|max_length[12]');
			
					if($this->Usuario_Model->getByCPF($this->input->post('cpf')) != false AND strlen($this->input->post('cpf')) >= 10) {
						echo json_encode(array('erro' => true, 'msg' => 'O CPF '. $this->input->post('cpf') . ' já existe em nosso banco de dados.'));
						exit;
					}

				}



			 	if($this->input->post('garantia') == 'on'){
			 		$this->form_validation->set_rules('nome_cliente_garantia', 'Nome garantia', 'required');
			 		$this->form_validation->set_rules('email_cliente_garantia', 'Email garantia', 'required');
			 		$this->form_validation->set_rules('cpf_cliente_garantia', 'CPF garantia', 'required');
			 		$this->form_validation->set_rules('meses_cliente_garantia', 'Meses cliente garantia', 'required|numeric');
			 	}

				
			 	if($this->input->post('notafiscal') == 'on'){
				 	$this->form_validation->set_rules('cpf_cliente', 'CPF Cliente', 'required'); 		
				 	$this->form_validation->set_rules('cnpj_cliente', 'CNPJ Cliente', 'required'); 		
    			}        
				
	
				if($this->Usuario_Model->UsuarioExiste($this->input->post('email')) != false) {
					echo json_encode(array('erro' => true, 'msg' => 'O email '. $this->input->post('email') . ' já existe em nosso banco de dados.'));
					exit;
				}

				if($this->input->post('perfil') == 2 AND $_SESSION['id_perfil'] != 2){
					echo json_encode(array('erro' => true, 'msg' => 'Você não tem permissão para criar um usuário admin.'));
					exit;
				}

			
				// if(valid_email($this->input->post('email')) != true) {
				// 	echo json_encode(array('erro' => true, 'msg' => 'O email '. $this->input->post('email') . ' está errado.'));
				// 	exit;
				// }				


                if ($this->form_validation->run() == FALSE)
                {
             		echo json_encode(array('erro' => true, 'msg' => validation_errors()));
             		exit;
                } else {


                    $dadosProdutoTroca = $this->Produto_Model->getByID($this->input->post('id_produto_troca'));

    

                	$dadosUsuario 								= array();
                	$dadosUsuario['nome'] 						= ucwords($this->input->post('nome'));
                	$dadosUsuario['id_perfil'] 					= $this->input->post('perfil');
                	$dadosUsuario['id_loja']					= ($this->input->post('id_loja')) ? $_SESSION['id_loja'] : $this->input->post('id_loja');
                	$dadosUsuario['id_criador']					= $_SESSION['id_usuario'];
                	$dadosUsuario['email'] 						= $this->input->post('email');
                	
                	if($this->input->post('tipo_usuario') == 'pf'){
                		$dadosUsuario['cpf'] 					= $this->input->post('cpf');
                	} else 	if($this->input->post('tipo_usuario') == 'pj'){ 
                		$dadosUsuario['cnpj'] 					= $this->input->post('cnpj');
                	}
                
                	$dadosUsuario['tipo_usuario']				= $this->input->post('tipo_usuario');
                	$dadosUsuario['sexo'] 						= $this->input->post('sexo');
                	$dadosUsuario['senha'] 						= $this->input->post('senha');
                	$dadosUsuario['telefone'] 					= $this->input->post('telefone');
                	$dadosUsuario['celular'] 					= $this->input->post('celular');
                	$dadosUsuario['cep']						= $this->input->post('cep');
                   	$dadosUsuario['cidade']						= $this->input->post('cidade');
                   	$dadosUsuario['uf']							= $this->input->post('uf');
                   	$dadosUsuario['rua']						= $this->input->post('rua');
                   	$dadosUsuario['ie']							= $this->input->post('ie');
                   	$dadosUsuario['complemento']				= $this->input->post('complemento');
                   	$dadosUsuario['rua_numero']					= $this->input->post('rua_numero');
                   	$dadosUsuario['bairro']						= $this->input->post('bairro');
                	$dadosUsuario['ip']							= $_SERVER['HTTP_X_FORWARDED_FOR'];
                	$dadosUsuario['data_criacao'] 				= date('Y-m-d H:i:s');
                	$dadosUsuario['data_ultimo_acesso'] 		= date('Y-m-d H:i:s');


                	$CodigoBarras 							   = time();
                	$dadosProduto 							   = array();
                    $dadosProduto['id_categoria']              = $this->input->post('id_categoria');
                    $dadosProduto['id_usuario']                = $this->session->userdata()['id_usuario'];
                    $dadosProduto['id_loja']      	           = $_SESSION['id_loja'];
                    $dadosProduto['nome']                      = ucwords($this->input->post('nome_produto'));
                    $dadosProduto['marca']                     = $this->input->post('marca_produto');
                    $dadosProduto['estado']                    = $this->input->post('estado');
                    $dadosProduto['modelo']                    = $this->input->post('modelo_produto');
                    $dadosProduto['codigo_barra']              = $CodigoBarras;
                    $dadosProduto['cor']                       = $this->input->post('cor_produto');
                    $dadosProduto['imei']                      = $this->input->post('imei_produto');
                    $dadosProduto['estoque_atual']             = 1;
                    $dadosProduto['estoque_cadastrado']        = 1;
                    $dadosProduto['preco_compra']              = $this->input->post('preco_compra');
                    $dadosProduto['estoque_minimo_aviso']      = 1;
                	$dadosProduto['descricao']                 = $this->input->post('descricao_produto');
                	$dadosProduto['ncm']					   = $this->input->post('ncm');
                    $dadosProduto['extipi']					   = $this->input->post('extipi');
                    $dadosProduto['data_cadastro']             = date('Y-m-d H:i:s');
                    $dadosProduto['data_ultima_modificacao']   = date('Y-m-d H:i:s');
                


                	if($this->Produto_Model->insert($dadosProduto)) {
               		 	$id_produto_new = $this->db->insert_id();
               		}
 	
                	if($this->Usuario_Model->insert($dadosUsuario)) {
                		$id_usuario_new = $this->db->insert_id();
                	}


                    switch ($this->input->post('forma_pagamento')) {
                    	case '5':
                    		$status_saida = 3;
                    	break;

                    	case '6':
                    		$status_saida = 4;
                    	break;
                    	
                    	default:
                    		$status_saida = 5;
                    	break;
                    }

                    $valor_diferenca = $this->input->post('preco_compra')-$dadosProdutoTroca->preco_troca;
                    $valor_lucro     = ($dadosProdutoTroca->preco_troca-$dadosProdutoTroca->preco_compra)-$this->input->post('preco_compra');

            		$insertSaida = array();
    				$insertSaida['id_vendedor']			                =	   $this->session->userdata()['id_usuario'];
    				$insertSaida['id_produto'] 			                = 	   $this->input->post('id_produto_troca');
                    $insertSaida['id_nfe'] 			                    =      $id_nfe;
                    $insertSaida['id_formapagamento']                   =      $this->input->post('forma_pagamento');
                    $insertSaida['parcela']                             =      $this->input->post('numero_parcelas');
                    $insertSaida['desconto']                            =      $this->input->post('desconto');
                  	$insertSaida['id_loja'] 			                =      $_SESSION['id_loja'];
    				$insertSaida['quantidade'] 			                =      1;
    				$insertSaida['valor_unitario'] 		                =      $dadosProdutoTroca->preco_troca;
    	            $insertSaida['status']                              =      $status_saida;
                 	$insertSaida['valor_total']			                =  	   $dadosProdutoTroca->preco_troca;
                    $insertSaida['valor_lucro_unitario']                =      $valor_lucro;
                    $insertSaida['valor_lucro_total']                   =      $valor_lucro;
                    $insertSaida['juros_cartao']						= 	   $JurosCartao;
                    $insertSaida['data_saida']			                =      date('Y-m-d H:i:s');
                    $insertSaida['nome_comprador']						=  	   $this->input->post('nome_cliente_garantia');
                    $insertSaida['cpf_comprador']						= 	   $this->input->post('cpf_cliente_garantia');
                    $insertSaida['garantia_comprador']                  =      $this->input->post('meses_cliente_garantia');
    		
    				$this->db->insert('tb_saida_produto',$insertSaida);

                    echo json_encode(array('erro' => false, 'msg' => 'Troca efetuada com sucesso.'));
                    exit;


                }

		} else {

			$this->load->model("Loja_Model");
			$this->load->model("Perfil_Model");
			$this->load->model("Categoria_Model");
			$this->load->model("Produto_Model");
				

			$view['lojas'] 				= $this->Loja_Model->getAll();
			$view['perfil'] 			= $this->Perfil_Model->getAll();
			$view['Categorias'] 		= $this->Categoria_Model->getAll();
			$view['produtos_troca']		= $this->Produto_Model->getProdutosTrocas();
			$view['formapagamentos'] 	= $this->db->query("SELECT * FROM appleplanet.tb_formapagamento ORDER BY tipo")->result();
		

			$this->template->set('titulo','Troca');
			$this->template->load('template','Troca/Cadastrar',$view);
		
		}

	}
}