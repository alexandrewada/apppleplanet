<?php

class Peca extends CI_Controller {


	public function Retorno() {
		if($this->input->post() == true) {
			$this->form_validation->set_rules('id_venda', 'ID da Venda', 'required|numeric');
			$this->form_validation->set_rules('motivo_retorno', 'Motivo do Retorno', 'required');

			if ($this->form_validation->run() == FALSE)  { 
		        $this->template->load('template','Peca/Retorno',array('erro' => validation_errors()));
			} else {
				$this->load->model('Peca_Model');
				
				$dadosSaidaPeca = $this->Peca_Model->getBySaida($this->input->post('id_venda'));

				

                $config['upload_path']          = '/var/www/html/public/images/produto/retorno';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['file_name']            =  $dadosSaidaPeca['id_saida_peca'];


                if(file_exists($config['upload_path']) == false) {
                    mkdir($config['upload_path'],0777, true);
                }

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('comprovante_garantia'))
                {
                    $this->template->load('template','Peca/Retorno',array('erro' => $this->upload->display_errors()));
                }
             

                $this->db->update('tb_saida_peca',array('status' => 2),array('id_saida_peca' => $dadosSaidaPeca['id_saida_peca']));
			    
			    $dadosInsert = array(
			    				'id_loja' 				=> $_SESSION['id_loja'],
			    				'id_saida_peca'			=> $dadosSaidaPeca['id_saida_peca'],
			    				'id_usuario_efetuou'	=> $this->session->userdata()['id_usuario'],
			    				'motivo'				=> $this->input->post('motivo_retorno'),
			    				'data'					=> date('Y-m-d H:i:s'),
                                'comprovante'           => base_url('public/images/peca/retorno/'.$this->upload->data()[file_name])
			    			   );

			    $this->db->insert('tb_retorno_peca',$dadosInsert);


			    $this->template->load('template','Peca/Retorno',array('retorno' => 'Peça retornada com sucesso...'));
			}


    	} else {
    		$this->template->load('template','Peca/Retorno',$view);
    	}
	}

	public function getVenda($id_saida_peca_get=NULL) {
        header("Content-type: application/json");

        $this->form_validation->set_rules('id_saida', 'ID da Saída Peça', 'required|numeric');
        

        if ($this->form_validation->run() == FALSE)  { 
            $json = array();
            $json['result'] = false;
            echo json_encode($json);
        	exit;
        } else {
	        $this->load->model('Peca_Model');
	        if($id_saida_peca_get == NULL) {
	        	$id_saida_peca = $this->input->post('id_saida');
	        } else {
	        	$id_saida_peca = $id_saida_peca_get;
	        }
       

	        $peca = $this->Peca_Model->getBySaida($id_saida_peca);

	        if($peca == false) {
	            $json = array();
	            $json['result'] = false;
	            echo json_encode($json);
	        } else {
	            $json = array();
	            $json['result'] = true;
	            $json['data']   = $peca;
	            echo json_encode($json);
	        }

        }

    }




    public function Saida() {
    	 if($this->input->post() == true) {
    		header("Content-type: application/json");

            $this->load->model("Peca_Model");
            $this->load->model("Usuario_Model");

    		$peca = $this->input->post('peca');


            $erros = array();

            switch ($this->input->post('forma_pagamento')) {
                // cartao de crédito
                case '2':
                    $this->form_validation->set_rules('numero_parcelas','required|numeric|greater_than[0]|integer');
                break;
                
                default:
                    # code...
                    break;
            }

            if($this->input->post('notafiscal')) {

            }

            $this->form_validation->set_rules('forma_pagamento', 'Forma de pagamento', 'required|numeric');
            $this->form_validation->set_rules('desconto', 'Desconto', 'required|numeric');
            

            
    		if($peca == 'false') {
    			$erros[] = "Você precisa adicionar algum peça para efetuar está operação.";
    		}

            $peca = json_decode($peca);

            
            if ($this->form_validation->run() == FALSE)
            {
                echo json_encode(array('erro' => true, 'msg' => validation_errors()));
                exit;
            }

            // Validação de Saída de pecas
            foreach ($peca as $key => $v) {
                $pecaCli = $v;
                $pecaBd  = $this->Peca_Model->getByID($v->id_peca);
                
                if(!is_int($pecaCli->id_peca)) {
                    $erros[] = "O id ".$pecaCli->id_peca." do peça precisa ser inteiro.";
                }

                if($pecaBd == false) {
                    $erros[] = "O peça id '".$pecaCli->id_peca."' não existe";
                }

                if($pecaBd->preco_venda != $pecaCli->valor) {
                    $erros[] = "O Preço do peça R$ ".$pecaCli->valor." está diferente com a do banco de dados";
                }

                if($pecaBd->estoque_atual == 0) {
                    $erros[] = "O peça id ".$pecaCli->id_peca." não tem estoque.";
                }

                if($pecaCli->quantidade > $pecaBd->estoque_atual) {
                    $erros[] = "A quantidade id do peça ".$pecaCli->id_peca." não pode ser maior que a do estoque.";
                }

            }

    		if(count($erros) > 0) {
    			echo json_encode(array('erro' => true, 'msg' => implode("<br>",$erros)));
    			exit;
    		} else {


                    // Regras de negocio para emitir notas
                    if($this->input->post('notafiscal') == 'on') {
                        $this->form_validation->set_rules('cpf_cliente', 'CPF do Cliente', 'required|min_length[14]|max_length[14]');
                        if ($this->form_validation->run() == FALSE){
                            echo json_encode(array('erro' => true, 'msg' => validation_errors()));
                            exit;
                        } else {
                            $dadosCliente = $this->Usuario_Model->getByCPF(trim($this->input->post('cpf_cliente')));
                            if($dadosCliente == false) {
                                echo json_encode(array('erro' => true, 'msg' => 'O CPF Informado '.$this->input->post('cpf_cliente').' não foi encontrado em nosso banco de dados <a target="_blank" href="'.base_url("usuario/cadastrar").'">Clique aqui para cadastrar um cpf</a>.'));
                                exit;
                            } else {
                                $this->load->library('Notafiscal');
                                
                                
                                $notaFiscal = new Notafiscal();

                                $notaFiscal->destinatario(array(
                                    'nome'              => removerAcento(trim($dadosCliente->nome)),
                                    'cpf'               => preg_replace("/[^0-9]/", "", trim($dadosCliente->cpf)),
                                    'endereco_rua'      => removerAcento(trim($dadosCliente->rua)),
                                    'endereco_numero'   => removerAcento(trim($dadosCliente->rua_numero)),
                                    'bairro'            => removerAcento(trim($dadosCliente->bairro)),
                                    'codigo_municipio'  => '3550308',
                                    'municipio'         => removerAcento(trim($dadosCliente->cidade)),
                                    'uf'                => strtoupper(removerAcento(trim($dadosCliente->uf)))
                                ));

                                $pecasArray = array();

                                foreach ($peca as $key => $v) {
                                    $pecaCli = $v;
                                    $pecaBd  = $this->Peca_Model->getByID($v->id_peca);
                   
                                    $pecasArray[$key]['id_produto']          = $pecaBd->id_peca;
                                    $pecasArray[$key]['nome_produto']        = removerAcento($pecaBd->nome);
                                    $pecasArray[$key]['unidade_produto']     = $pecaCli->quantidade;
                                    $pecasArray[$key]['preco_produto']       = $pecaBd->preco_venda;
                                       
                                }


                                $notaFiscal->addProduto($pecasArray);
                                $resultadoNota = $notaFiscal->gerarNF();




                                $urlNotaFiscal      = $resultadoNota[msg][urlPdf];
                                $chaveNotaFiscal    = $resultadoNota[msg][aProt][0][chNFe];
                                $reciboNotaFiscal   = $resultadoNota[msg][nRec];


                                $dadosNfe = array(
                                				'url_pdf' => $urlNotaFiscal,
                                				'chave'	  => $chaveNotaFiscal,
                                				'recibo'  => $reciboNotaFiscal,
                                                'data'    => date('Y-m-d H:i:s')
                                			);

                                if($this->db->insert('tb_nfe',$dadosNfe) == true) {
                                	$id_nfe = $this->db->insert_id();
                                }

                                if($resultadoNota['erro'] == true) {
                                    echo json_encode(array('erro' => true, 'msg' => $resultadoNota['msg']));
                                    exit;
                                }
                            }
                        }
                    }










                foreach ($peca as $key => $v) {
    		      
                    $pecaCli = $v;
                    $pecaBd  = $this->Peca_Model->getByID($v->id_peca);
                    $venda      = ($this->input->post('venda') == true) ? 1 : 0;


                    if($this->input->post('forma_pagamento') != '3') {
                    	$this->load->model("Juros_Model");
                    	$JurosCartao = $this->Juros_Model->jurosCartao($this->input->post('forma_pagamento'),$this->input->post('numero_parcelas'),($pecaBd->preco_venda*$pecaCli->quantidade));
                    } else {
                    	$JurosCartao = 0;
                    }


                    $ValorTotal             = $pecaBd->preco_venda*$pecaCli->quantidade;
                        
                    if($this->input->post('jurosparcelamento') == 'on') {
                        $ValorTotal = $ValorTotal + $this->input->post('valorjurosparcelamento');
                    }

                    if($this->input->post('desconto') != '0') {
                        $ValorTotal = $ValorTotal - (($pecaBd->preco_venda*$this->input->post('desconto'))/100);
                    }

                    $ValorLucroUnitario     = ($pecaBd->preco_venda) - ($pecaBd->preco_compra);
                    $ValorPrecoCusto        = $pecaBd->preco_compra*$pecaCli->quantidade;
                    $ValorLucroTotal        = (($ValorTotal) - ($ValorPrecoCusto)) - $JurosCartao;

                    switch ($this->input->post('forma_pagamento')) {
                    	case '5':
                    		$status_saida = 3;
                    	break;

                    	case '6':
                    		$status_saida = 4;
                    	break;
                    	
                    	default:
                    		$status_saida = 1;
                    	break;
                    }

            		$insertSaida = array();
    				$insertSaida['id_vendedor']			                =	   $this->session->userdata()['id_usuario'];
    				$insertSaida['id_peca'] 			                = 	   $pecaBd->id_peca;
                    $insertSaida['id_nfe'] 			                    =      $id_nfe;
                    $insertSaida['id_formapagamento']                   =      $this->input->post('forma_pagamento');
                    $insertSaida['parcela']                             =      $this->input->post('numero_parcelas');
                    $insertSaida['desconto']                            =      $this->input->post('desconto');
                    $insertSaida['valor_desconto']                      =      ($this->input->post('desconto') != '0') ? ($pecaBd->preco_venda*$this->input->post('desconto'))/100 : 0;
                	$insertSaida['id_loja'] 			                =      $_SESSION['id_loja'];
    				$insertSaida['quantidade'] 			                =      $pecaCli->quantidade;
    				$insertSaida['valor_unitario'] 		                =      $pecaBd->preco_venda;
    	            $insertSaida['status']                              =      $status_saida;
                 	$insertSaida['valor_total']			                =  	   $ValorTotal;
                    $insertSaida['valor_lucro_unitario']                =      $ValorLucroUnitario;
                    $insertSaida['valor_lucro_total']                   =      $ValorLucroTotal;
                    $insertSaida['juros_cartao']						= 	   $JurosCartao;
                    $insertSaida['data_saida']			                =      date('Y-m-d H:i:s');
    		
    				$this->db->insert('tb_saida_peca',$insertSaida);
    			}

                if($this->input->post('notafiscal') == 'on') {
    			     echo json_encode(array('erro' => false, 'msg' => '<script>posSucesso();</script> Operação feita com sucesso...<br><a target="_BLANK" href="'.$urlNotaFiscal.'">Clique aqui parar imprimir a nota do cliente</a>'));
    			} else {
                     echo json_encode(array('erro' => false, 'msg' => '<script>posSucesso();</script> Operação feita com sucesso...'));
                }
                exit;

    		}

    	 } else {
            $view['formapagamentos'] = $this->db->query("SELECT * FROM appleplanet.tb_formapagamento ORDER BY tipo")->result();
		    $this->template->load('template','Peca/Saida',$view); 	
    	 }
    }

    public function getpecacodigobarras() {
        header("Content-type: application/json");

        $this->load->model('Peca_Model');

        $codigoBarras = $this->input->post('codigobarra');
        $codigoBarras = preg_replace("/[^0-9]/","",$codigoBarras);

        // $codigoBarras = '1473037190';

        $peca = $this->Peca_Model->getByCodigoBarras($codigoBarras);

        if($peca == false) {
            $json = array();
            $json['result'] = false;
            echo json_encode($json);
        } else {
            $json = array();
            $json['result'] = true;
            $json['data']   = $peca;
            echo json_encode($json);
        }

    }

    public function CodigoBarras($qtd=1,$codigo,$nome,$preco,$tipo='codabar') {
        $view['tipo']           = $tipo;
        $view['codigo']         = $codigo;
        $view['qtd']            = $qtd;
        $view['nome_peca']      = urldecode($nome);
        $view['preco']          = (empty($preco)) ? '0.00' : $preco;
        $this->load->view('Peca/Codigobarras',$view);
    }

    public function Gerenciar() {
        $this->load->model('Peca_Model');
        $view['Listarpecas'] = $this->Peca_Model->getpecas();
        $this->template->load('template','Peca/Gerenciar',$view);
    }    

    public function Estoque() {
        $this->load->model('Peca_Model');
        $view['Listar'] = $this->Peca_Model->getpecasEstoque();
        $this->template->load('template','Peca/Estoque',$view);
    }

    public function Editar($id_peca)
    {
        
        if($this->input->post() == true) {

                header("Content-type: application/json");

                $this->load->model("Peca_Model");

                $this->form_validation->set_rules('nome_peca', 'Nome do Peça', 'required|min_length[6]|max_length[40]');
                $this->form_validation->set_rules('marca_peca', 'Marca do Peça', 'required');
                $this->form_validation->set_rules('modelo_peca', 'Mordelo do Peça', 'required');
                $this->form_validation->set_rules('id_categoria', 'Categoria', 'required|integer');
                $this->form_validation->set_rules('id_fornecedor', 'Fornecedor', 'required|integer');
                $this->form_validation->set_rules('estoque_atual', 'Estoque Inicial', 'required|integer|less_than[1000]');
                $this->form_validation->set_rules('preco_compra', 'Preço de Custo', 'required|decimal|greater_than[0]');
                $this->form_validation->set_rules('preco_venda', 'Preço de Venda', 'required|decimal|greater_than[0]');
            

                if($this->input->post('excluir') == 'on'){
                    $this->db->delete('tb_peca',array('id_peca' =>   $id_peca));
                    echo json_encode(array('erro' => false, 'msg' => 'Peça deletada com sucesso. <script>window.location.reload();</script>'));
                    exit;
                }

                if($this->session->userdata()['id_perfil'] == 3){
                    echo json_encode(array('erro' => true, 'msg' => 'Você não tem acesso a editar a peça.'));
                    exit;
                }

            
        		if($this->input->post('estoque_atual') < $this->input->post('estoque_gravado') AND $this->session->userdata()['id_perfil'] != 2) {
                    echo json_encode(array('erro' => true, 'msg' => 'Você não pode diminuir o estoque inicial, somente aumentar.'));
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
                    $dados['id_categoria']              = $this->input->post('id_categoria');
                    $dados['id_fornecedor']             = $this->input->post('id_fornecedor');
                    $dados['id_usuario']                = $this->session->userdata()['id_usuario'];
                    $dados['nome']                      = ucwords($this->input->post('nome_peca'));
                    $dados['marca']                     = $this->input->post('marca_peca');
                    $dados['modelo']                    = $this->input->post('modelo_peca');
                    $dados['codigo_barra']              = $this->input->post('codigobarras_peca');
                    $dados['preco_venda']               = $this->input->post('preco_venda');
                    $dados['preco_compra']              = $this->input->post('preco_compra');
                    $dados['estoque_atual']             = $this->input->post('estoque_atual');
                    $dados['estoque_minimo_aviso']      = $this->input->post('estoque_minimo_aviso');
                    $dados['descricao']                 = $this->input->post('descricao_peca');
                    $dados['data_ultima_modificacao']   = date('Y-m-d H:i:s');
                
                    if($this->Peca_Model->update($dados,"id_peca = $id_peca")){
                        echo json_encode(array('erro' => false, 'msg' => 'Peça atualizado com sucesso. <script>window.location.reload();</script>'));
                    }
                }


        // Visualização
        } else {
            $this->load->model("Peca_Model");
            $this->load->model("Categoria_Model");
            $this->load->model("Fornecedor_Model");

            $peca = $this->Peca_Model->getByID($id_peca);

            $CodigoBarrasUrl        = base_url('Peca/codigobarras/'.$peca->estoque_atual.'/'.$peca->codigo_barra.'/'.ucwords($peca->nome).'/'.$peca->preco_venda);

            
            if($peca != false) {

                $view['Categorias']     = $this->Categoria_Model->getAll();
                $view['Fornecedor']     = $this->Fornecedor_Model->getAll();
                $view['codigo_barra']   = $CodigoBarrasUrl;
                $view['peca']    = $peca;

                $this->load->view('Peca/Editar',$view);
            } else {
                echo 'A peça não existe';
            } 
        }
    }

	public function Cadastrar()
	{
		
		if($this->input->post() == true) {

				header("Content-type: application/json");

				$this->load->model("Peca_Model");

			 	$this->form_validation->set_rules('nome_peca', 'Nome do Peça', 'required|min_length[6]|max_length[40]');
			 	$this->form_validation->set_rules('marca_peca', 'Marca do Peça', 'required');
			 	$this->form_validation->set_rules('modelo_peca', 'Mordelo do Peça', 'required');
				$this->form_validation->set_rules('id_categoria', 'Categoria', 'required|integer');
			 	$this->form_validation->set_rules('id_fornecedor', 'Fornecedor', 'required|integer');
			 	$this->form_validation->set_rules('estoque_atual', 'Estoque Inicial', 'required|integer|greater_than[0]|less_than[1000]');
			 	$this->form_validation->set_rules('preco_compra', 'Preço de Custo', 'required|decimal|greater_than[0]');
                $this->form_validation->set_rules('preco_venda', 'Preço de Venda', 'required|decimal|greater_than[0]');
                $this->form_validation->set_rules('desconto_maximo', 'Desconto Máximo', 'numeric|greater_than[0]|less_than[11]');
            
			
		

                if ($this->form_validation->run() == FALSE)
                {
             		echo json_encode(array('erro' => true, 'msg' => validation_errors()));
             		exit;
                }
                	else
                {

                	$CodigoBarras 			= time();
                	$CodigoBarrasUrl		= base_url('Peca/codigobarras/'.$this->input->post('estoque_atual').'/'.$CodigoBarras.'/'.ucwords($this->input->post('nome_peca')).'/'.$this->input->post('preco_venda'));

                	$dados = array();
                    $dados['id_categoria']              = $this->input->post('id_categoria');
                    $dados['id_fornecedor']             = $this->input->post('id_fornecedor');
                    $dados['id_usuario']                = $this->session->userdata()['id_usuario'];
                    $dados['id_loja']                   = $_SESSION['id_loja'];
                    $dados['nome']                      = ucwords($this->input->post('nome_peca'));
                    $dados['marca']                     = $this->input->post('marca_peca');
                    $dados['modelo']                    = $this->input->post('modelo_peca');
                    $dados['codigo_barra']              = $CodigoBarras;
                    $dados['desconto_max']              = $this->input->post('desconto_maximo');
                    $dados['preco_venda']               = $this->input->post('preco_venda');
                    $dados['preco_compra']              = $this->input->post('preco_compra');
                    $dados['estoque_atual']             = $this->input->post('estoque_atual');
                    $dados['estoque_cadastrado']        = $this->input->post('estoque_atual');
                    $dados['estoque_minimo_aviso']      = $this->input->post('estoque_minimo_aviso');
                	$dados['descricao']                 = $this->input->post('descricao_peca');
                    $dados['data_cadastro']             = date('Y-m-d H:i:s');
                    $dados['data_ultima_modificacao']   = date('Y-m-d H:i:s');
                
                	if($this->Peca_Model->insert($dados)){
               			echo json_encode(array('erro' => false, 'msg' => 'Peça cadastrado com sucesso. <a href="'.$CodigoBarrasUrl.'" target="_BLANK" >Imprimir Código de Barras</a>'));
                	}
                }


		// Visualização
		} else {

			$this->load->model("Categoria_Model");
			$this->load->model("Fornecedor_Model");


			$view['Categorias'] = $this->Categoria_Model->getAll();
			$view['Fornecedor'] = $this->Fornecedor_Model->getAll();
			
			$this->template->set('titulo','Cadastrar peca');
			$this->template->load('template','Peca/Cadastrar',$view);
		}
	}
}