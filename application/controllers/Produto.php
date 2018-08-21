<?php

class Produto extends CI_Controller {


	public function Retorno() {
		if($this->input->post() == true) {
			$this->form_validation->set_rules('id_venda', 'ID da Venda', 'required|numeric');
			$this->form_validation->set_rules('motivo_retorno', 'Motivo do Retorno', 'required');

			if ($this->form_validation->run() == FALSE)  { 
		        $this->template->load('template','Produto/Retorno',array('erro' => validation_errors()));
			} else {
				$this->load->model('Produto_Model');
				
				$dadosSaidaProduto = $this->Produto_Model->getBySaida($this->input->post('id_venda'));

				

                $config['upload_path']          = '/var/www/html/public/images/produto/retorno';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['file_name']            =  $dadosSaidaProduto['id_saida_produto'];


                if(file_exists($config['upload_path']) == false) {
                    mkdir($config['upload_path'],0777, true);
                }

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('comprovante_garantia'))
                {
                    $this->template->load('template','Produto/Retorno',array('erro' => $this->upload->display_errors()));
                }
             

                $this->db->update('tb_saida_produto',array('status' => 2),array('id_saida_produto' => $dadosSaidaProduto['id_saida_produto']));
			    
			    $dadosInsert = array(
			    				'id_loja' 				=> $this->session->userdata()['id_loja'],
			    				'id_saida_produto'		=> $dadosSaidaProduto['id_saida_produto'],
			    				'id_usuario_efetuou'	=> $this->session->userdata()['id_usuario'],
			    				'motivo'				=> $this->input->post('motivo_retorno'),
			    				'data'					=> date('Y-m-d H:i:s'),
                                'comprovante'           => base_url('public/images/produto/retorno/'.$this->upload->data()[file_name])
			    			   );

			    $this->db->insert('tb_retorno_produto',$dadosInsert);


			    $this->template->load('template','Produto/Retorno',array('retorno' => 'Produto retornada com sucesso...'));
			}


    	} else {
    		$this->template->load('template','Produto/Retorno',$view);
    	}
	}




        public function Garantia($id_saida_produto) {
            $this->load->model('Produto_Model');

            $produto = $this->Produto_Model->getInfoGarantia($id_saida_produto);

            if($produto != false) {
                $view['produto'] = $produto;
                $this->load->view('Produto/Garantia',$view);
            } else {
                echo 'Produto nao encontrado.';
            }
        }


	 public function getVenda($id_saida_produto_get=NULL) {
        header("Content-type: application/json");

        $this->form_validation->set_rules('id_saida', 'ID da Venda', 'required|numeric');
        

        if ($this->form_validation->run() == FALSE)  { 
            $json = array();
            $json['result'] = false;
            echo json_encode($json);
        	exit;
        } else {
	        $this->load->model('Produto_Model');
	        if($id_saida_produto_get == NULL) {
	        	$id_saida_produto = $this->input->post('id_saida');
	        } else {
	        	$id_saida_produto = $id_saida_produto_get;
	        }
       

	        $Produto = $this->Produto_Model->getBySaida($id_saida_produto);

	        if($Produto == false) {
	            $json = array();
	            $json['result'] = false;
	            echo json_encode($json);
	        } else {
	            $json = array();
	            $json['result'] = true;
	            $json['data']   = $Produto;
	            echo json_encode($json);
	        }

        }

    }

    public function Saida() {
    	 if($this->input->post() == true) {
    		header("Content-type: application/json");

            $this->load->model("Produto_Model");
            $this->load->model("Usuario_Model");
            $this->load->library('Sendemail');

    		$produto = $this->input->post('produto');


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
            

            
    		if($produto == 'false') {
    			$erros[] = "Você precisa adicionar algum produto para efetuar está operação.";
    		}

            $produto = json_decode($produto);

            
            if ($this->form_validation->run() == FALSE)
            {
                echo json_encode(array('erro' => true, 'msg' => validation_errors()));
                exit;
            }

            // Validação de Saída de Produtos
            foreach ($produto as $key => $v) {
                $produtoCli = $v;
                $produtoBd  = $this->Produto_Model->getByID($v->id_produto);
                
                if(!is_int($produtoCli->id_produto)) {
                    $erros[] = "O id ".$produtoCli->id_produto." do produto precisa ser inteiro.";
                }

                if($produtoBd == false) {
                    $erros[] = "O Produto id '".$produtoCli->id_produto."' não existe";
                }

                if($produtoBd->preco_venda != $produtoCli->valor) {
                    $erros[] = "O Preço do Produto R$ ".$produtoCli->valor." está diferente com a do banco de dados";
                }

                if($produtoBd->estoque_atual == 0) {
                    $erros[] = "O Produto id ".$produtoCli->id_produto." não tem estoque.";
                }

                if($produtoCli->quantidade > $produtoBd->estoque_atual) {
                    $erros[] = "A quantidade id do produto ".$produtoCli->id_produto." não pode ser maior que a do estoque.";
                }

            }

    		if(count($erros) > 0) {
    			echo json_encode(array('erro' => true, 'msg' => implode("<br>",$erros)));
    			exit;
    		} else {


                    // Regras de negocio para emitir notas
                    if($this->input->post('notafiscal') == 'on') {


                        if(!empty($this->input->post('cpf_cliente') AND !empty($this->input->post('cnpj_cliente') ) )) {
                      		echo json_encode(array('erro' => true, 'msg' => 'Só é possível emitir a nota, se for PF ou PJ'));
                        	exit;
                        }
                  

                        if(!empty($this->input->post('cpf_cliente'))) {
                        		$this->form_validation->set_rules('cpf_cliente', 'CPF do Cliente', 'required|min_length[14]|max_length[14]');
                       	} 

                       	if(!empty($this->input->post('cnpj_cliente'))) {
                        		$this->form_validation->set_rules('cnpj_cliente', 'CNPJ do Cliente', 'required|exact_length[18]');
                       	} 

                        if ($this->form_validation->run() == FALSE){
                            echo json_encode(array('erro' => true, 'msg' => validation_errors()));
                            exit;
                        } else {
                            if(!empty($this->input->post('cpf_cliente'))) {
                            $dadosCliente = $this->Usuario_Model->getByCPF(trim($this->input->post('cpf_cliente')));
	                            if($dadosCliente == false) {
	                                echo json_encode(array('erro' => true, 'msg' => 'O CPF Informado '.$this->input->post('cpf_cliente').' não foi encontrado em nosso banco de dados <a target="_blank" href="'.base_url("usuario/cadastrar").'">Clique aqui para cadastrar um cpf</a>.'));
	                                exit;
	                                $ok = false;
	                            } else {
	                            	$ok = true;
	                            }
	                        } else if(!empty($this->input->post('cnpj_cliente'))) {
	                        	$dadosCliente = $this->Usuario_Model->getByCNPJ(trim($this->input->post('cnpj_cliente')));
	                            if($dadosCliente == false) {
	                                echo json_encode(array('erro' => true, 'msg' => 'O CNPJ Informado '.$this->input->post('cnpj_cliente').' não foi encontrado em nosso banco de dados <a target="_blank" href="'.base_url("usuario/cadastrar").'">Clique aqui para cadastrar um cpf</a>.'));
	                                exit;
	                                $ok = false;
	                            } else {
	                            	$ok = true;
	                            }
	                        }
                            
                            if($ok == true){
                                $this->load->library('Notafiscal');
                
                                
                                $notaFiscal = new Notafiscal();


                                if(!empty($dadosCliente->cpf)){
	                                $notaFiscal->destinatario(array(
	                                    'nome'              => removerAcento(trim($dadosCliente->nome)),
	                                    'cpf'               => preg_replace("/[^0-9]/", "", trim($dadosCliente->cpf)),
	                                    'endereco_rua'      => removerAcento(trim($dadosCliente->rua)),
	                                    'cep'               => removerAcento(trim($dadosCliente->cep)),
	                                    'endereco_numero'   => removerAcento(trim($dadosCliente->rua_numero)),
	                                    'bairro'            => removerAcento(trim($dadosCliente->bairro)),
	                                    'codigo_municipio'  => '3550308',
	                                    'cidade'            => removerAcento(trim($dadosCliente->cidade)),
	                                    'uf'                => strtoupper(removerAcento(trim($dadosCliente->uf)))
	                                ));
                                } else {
                                	$notaFiscal->destinatario(array(
	                                    'nome'              => removerAcento(trim($dadosCliente->nome)),
	                                    'cnpj'              => preg_replace("/[^0-9]/", "", trim($dadosCliente->cnpj)),
	                                    'ie'				=> preg_replace("/[^0-9]/", "", trim($dadosCliente->ie)),
	                                    'endereco_rua'      => removerAcento(trim($dadosCliente->rua)),
	                                    'endereco_numero'   => removerAcento(trim($dadosCliente->rua_numero)),
	                                    'bairro'            => removerAcento(trim($dadosCliente->bairro)),
	                                    'codigo_municipio'  => '3550308',
	                                    'cidade'         => removerAcento(trim($dadosCliente->cidade)),
	                                    'uf'                => strtoupper(removerAcento(trim($dadosCliente->uf)))
	                                ));
                                }

                                $produtosArray = array();

                                foreach ($produto as $key => $v) {
                                    $produtoCli = $v;
                                    $produtoBd  = $this->Produto_Model->getByID($v->id_produto);
                   
                                    $produtosArray[$key]['id_produto']          = $produtoBd->id_produto;

                                    if(empty($produtoBd->imei)){
                                        $produtosArray[$key]['nome_produto']        = removerAcento($produtoBd->nome);
                                    } else {
                                        $produtosArray[$key]['nome_produto']        = removerAcento($produtoBd->nome) . ' IMEI '.$produtoBd->imei;
                                    }


                                    $produtosArray[$key]['unidade_produto']     = $produtoCli->quantidade;
                                    $produtosArray[$key]['preco_produto']       = $produtoBd->preco_venda;
                                    $produtosArray[$key]['ncm_produto']         = $produtoBd->ncm;
                                       
                                }


                                $notaFiscal->addProduto($produtosArray);
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




						  		$this->sendemail->toEmail = $dadosCliente->email;
					            $this->sendemail->toNome  = 'Apple Planet';
					            $this->sendemail->assunto = '[NF-e] Sua nota fiscal da Apple Planet '.$reciboNotaFiscal;
					            $this->sendemail->msg     = 'Segue o link contendo NF-e <a href="'.$urlNotaFiscal.'">Clique Aqui</a>';
					            $this->sendemail->Enviar();


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







                    $id_vendas = array();


                foreach ($produto as $key => $v) {
    		      
                    $produtoCli = $v;
                    $produtoBd  = $this->Produto_Model->getByID($v->id_produto);
                    $venda      = ($this->input->post('venda') == true) ? 1 : 0;


                    if($this->input->post('forma_pagamento') != '3') {
                    	$this->load->model("Juros_Model");
                    	$JurosCartao = $this->Juros_Model->jurosCartao($this->input->post('forma_pagamento'),$this->input->post('numero_parcelas'),($produtoBd->preco_venda*$produtoCli->quantidade));
                    } else {
                    	$JurosCartao = 0;
                    }


                    $ValorTotal             = $produtoBd->preco_venda*$produtoCli->quantidade;
                        
                    if($this->input->post('jurosparcelamento') == 'on') {
                        $ValorTotal = $ValorTotal + $this->input->post('valorjurosparcelamento');
                    }

                    if($this->input->post('desconto') != '0') {
                        $ValorTotal = $ValorTotal - (($produtoBd->preco_venda*$this->input->post('desconto'))/100);
                    }

                    $ValorLucroUnitario     = ($produtoBd->preco_venda) - ($produtoBd->preco_compra);
                    $ValorPrecoCusto        = $produtoBd->preco_compra*$produtoCli->quantidade;
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
    				$insertSaida['id_produto'] 			                = 	   $produtoBd->id_produto;
                    $insertSaida['id_nfe'] 			                    =      $id_nfe;
                    $insertSaida['id_formapagamento']                   =      $this->input->post('forma_pagamento');
                    $insertSaida['parcela']                             =      $this->input->post('numero_parcelas');
                    $insertSaida['desconto']                            =      $this->input->post('desconto');
                    $insertSaida['valor_desconto']                      =      ($this->input->post('desconto') != '0') ? ($produtoBd->preco_venda*$this->input->post('desconto'))/100 : 0;
                	$insertSaida['id_loja'] 			                =      $this->session->userdata()['id_loja'];
    				$insertSaida['quantidade'] 			                =      $produtoCli->quantidade;
    				$insertSaida['valor_unitario'] 		                =      $produtoBd->preco_venda;
    	            $insertSaida['status']                              =      $status_saida;
                 	$insertSaida['valor_total']			                =  	   $ValorTotal;
                    $insertSaida['valor_lucro_unitario']                =      $ValorLucroUnitario;
                    $insertSaida['valor_lucro_total']                   =      $ValorLucroTotal;
                    $insertSaida['juros_cartao']						= 	   $JurosCartao;
                    $insertSaida['data_saida']			                =      date('Y-m-d H:i:s');
                    $insertSaida['nome_comprador']						=  	   $this->input->post('nome_cliente_garantia');
                    $insertSaida['cpf_comprador']						= 	   $this->input->post('cpf_cliente_garantia');
                    $insertSaida['garantia_comprador']                  =      $this->input->post('meses_cliente_garantia');
    		
    				$this->db->insert('tb_saida_produto',$insertSaida);

    				$id_vendas[] = array('nome_produto' => $produtoBd->nome, 'id_produto' => $this->db->insert_id());
    			}

    			 if($this->input->post('garantia') == 'on') {

    		
    			 	foreach ($id_vendas as $key => $v) {
                    	$garantia[] = "<br><a target='_BLANK' href='".base_url('produto/garantia/'.$v[id_produto])."?cliente=".$this->input->post('nome_cliente_garantia')."&cpf=".$this->input->post('cpf_cliente_garantia')."&meses=".$this->input->post('meses_cliente_garantia')."'>Clique aqui parar Imprimir a Garantia do Produto $v[nome_produto]</a><br>";

		                $this->sendemail->toEmail = $this->input->post('email_cliente_garantia');
		                $this->sendemail->toNome  = 'Apple Planet';
		                $this->sendemail->assunto = '[Apple Planet] Garantia da Apple Planet.';
		                $this->sendemail->msg     = "Segue o link contendo sua garantia <a  href='".base_url('produto/garantia/'.$v[id_produto])."?cliente=".$this->input->post('nome_cliente_garantia')."&cpf=".$this->input->post('cpf_cliente_garantia')."&meses=".$this->input->post('meses_cliente_garantia')."'>Clique aqui</a>";
		                $this->sendemail->Enviar();

                	} 
                }

                if($this->input->post('notafiscal') == 'on') {
    			     echo json_encode(array('erro' => false, 'msg' => '<br><script>posSucesso();</script> Produto foi faturado com sucesso...<br><a target="_BLANK" href="'.$urlNotaFiscal.'">Clique aqui parar imprimir a nota do cliente</a>'.implode("",$garantia)));
    			} else {
                     echo json_encode(array('erro' => false, 'msg' => '<br><script>posSucesso();</script> Produto foi faturado com sucesso...<br>'.implode("",$garantia)));
                }
                exit;

    		}

    	 } else {
            $view['formapagamentos'] = $this->db->query("SELECT * FROM appleplanet.tb_formapagamento ORDER BY tipo")->result();
		    $this->template->load('template','Produto/Saida',$view); 	
    	 }
    }

    public function getprodutocodigobarras() {
        header("Content-type: application/json");

        $this->load->model('Produto_Model');

        $codigoBarras = $this->input->post('codigobarra');
        $codigoBarras = preg_replace("/[^0-9]/","",$codigoBarras);
        // $codigoBarras = '1473037190';

        $Produto = $this->Produto_Model->getByCodigoBarras($codigoBarras);

        if($Produto == false) {
            $json = array();
            $json['result'] = false;
            echo json_encode($json);
        } else {
            $json = array();
            $json['result'] = true;
            $json['data']   = $Produto;
            echo json_encode($json);
        }

    }

    public function CodigoBarras($qtd=1,$codigo,$nome,$preco,$tipo='codabar') {
        $view['tipo']           = $tipo;
        $view['codigo']         = $codigo;
        $view['qtd']            = $qtd;
        $view['nome_produto']   = urldecode($nome);
        $view['preco']          = (empty($preco)) ? '0.00' : $preco;
        $this->load->view('Produto/Codigobarras',$view);
    }

    public function Gerenciar() {
        $this->load->model('Produto_Model');
        $view['ListarProdutos'] = $this->Produto_Model->getProdutos();
        $this->template->load('template','Produto/Gerenciar',$view);
    }

    public function Estoque() {
        $this->load->model('Produto_Model');
        $view['ListarProdutos'] = $this->Produto_Model->getProdutosEstoque();
        $this->template->load('template','Produto/Estoque',$view);
    }

    public function Editar($id_produto)
    {
        
        if($this->input->post() == true) {

                header("Content-type: application/json");

                $this->load->model("Produto_Model");

                $this->form_validation->set_rules('nome_produto', 'Nome do produto', 'required|min_length[6]|max_length[40]');
                // $this->form_validation->set_rules('marca_produto', 'Marca do produto', 'required');
                $this->form_validation->set_rules('modelo_produto', 'Mordelo do produto', 'required');
                $this->form_validation->set_rules('id_categoria', 'Categoria', 'required|integer');
                $this->form_validation->set_rules('id_fornecedor', 'Fornecedor', 'required|integer');
                $this->form_validation->set_rules('estoque_atual', 'Estoque Inicial', 'required|integer|less_than[1000]');
                $this->form_validation->set_rules('preco_compra', 'Preço de Custo', 'required|decimal|greater_than[0]');
                $this->form_validation->set_rules('preco_venda', 'Preço de Venda', 'required|decimal|greater_than[0]');
           

            
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

                    if($this->input->post('excluir') == 'on'){
                        $this->db->delete('tb_produto',array('id_produto' =>   $id_produto));
                        echo json_encode(array('erro' => false, 'msg' => 'Produto deletado com sucesso. <script>window.location.reload();</script>'));
                        exit;
                    }


                    $dados = array();
                    $dados['id_categoria']              = $this->input->post('id_categoria');
                    $dados['id_fornecedor']             = $this->input->post('id_fornecedor');
                    $dados['estado']                    = $this->input->post('estado');
                    $dados['id_usuario']                = $this->session->userdata()['id_usuario'];
                    $dados['nome']                      = ucwords($this->input->post('nome_produto'));
                    $dados['marca']                     = $this->input->post('marca_produto');
                    $dados['modelo']                    = $this->input->post('modelo_produto');
                    $dados['codigo_barra']              = $this->input->post('codigobarras_produto');
                    $dados['preco_venda']               = $this->input->post('preco_venda');
                    $dados['cor']                       = $this->input->post('cor_produto');
                    $dados['imei']                      = $this->input->post('imei_produto');
                    $dados['preco_compra']              = $this->input->post('preco_compra');
                    $dados['estoque_atual']             = $this->input->post('estoque_atual');
                    $dados['preco_troca']               = $this->input->post('preco_troca');
                    
                    $dados['ncm']						= $this->input->post('ncm');
                    $dados['extipi']					= $this->input->post('extipi');

                    $dados['estoque_cadastrado']        = $this->input->post('estoque_atual');
                    $dados['estoque_minimo_aviso']      = $this->input->post('estoque_minimo_aviso');
                    $dados['descricao']                 = $this->input->post('descricao_produto');
                    $dados['data_ultima_modificacao']   = date('Y-m-d H:i:s');
                
                    if($this->Produto_Model->update($dados,"id_produto = $id_produto")){
                        echo json_encode(array('erro' => false, 'msg' => 'Produto atualizado com sucesso. <script>window.location.reload();</script>'));
                    }
                }


        // Visualização
        } else {
            $this->load->model("Produto_Model");
            $this->load->model("Categoria_Model");
            $this->load->model("Fornecedor_Model");

            $produto = $this->Produto_Model->getByID($id_produto);

            $CodigoBarrasUrl        = base_url('produto/codigobarras/'.$produto->estoque_atual.'/'.$produto->codigo_barra.'/'.ucwords($produto->nome).'/'.$produto->preco_venda);

            
            if($produto != false) {

                $view['Categorias']     = $this->Categoria_Model->getAll();
                $view['Fornecedor']     = $this->Fornecedor_Model->getAll();
                $view['codigo_barra']   = $CodigoBarrasUrl;
                $view['Produto']    = $produto;

                $this->load->view('Produto/Editar',$view);
            } else {
                echo 'Produto não existe';
            } 
        }
    }

	public function Cadastrar()
	{
		
		if($this->input->post() == true) {

				header("Content-type: application/json");

				$this->load->model("Produto_Model");

			 	$this->form_validation->set_rules('nome_produto', 'Nome do produto', 'required|min_length[6]|max_length[40]');
			 	// $this->form_validation->set_rules('marca_produto', 'Marca do produto', 'required');
			 	$this->form_validation->set_rules('modelo_produto', 'Mordelo do produto', 'required');
				$this->form_validation->set_rules('id_categoria', 'Categoria', 'required|integer');
			 	$this->form_validation->set_rules('id_fornecedor', 'Fornecedor', 'required|integer');
			 	$this->form_validation->set_rules('estoque_atual', 'Estoque Inicial', 'required|integer|greater_than[0]|less_than[1000]');
			 	$this->form_validation->set_rules('preco_compra', 'Preço de Custo', 'required|decimal|greater_than[0]');
                $this->form_validation->set_rules('preco_venda', 'Preço de Venda', 'required|decimal|greater_than[0]');
                $this->form_validation->set_rules('desconto_maximo', 'Desconto Máximo', 'numeric|greater_than[0]|less_than[16]');
            
			
		

                if ($this->form_validation->run() == FALSE)
                {
             		echo json_encode(array('erro' => true, 'msg' => validation_errors()));
             		exit;
                }
                	else
                {

                	$CodigoBarras 			= time();
                	$CodigoBarrasUrl		= base_url('produto/codigobarras/'.$this->input->post('estoque_atual').'/'.$CodigoBarras.'/'.ucwords($this->input->post('nome_produto')).'/'.$this->input->post('preco_venda'));

                	$dados = array();
                    $dados['id_categoria']              = $this->input->post('id_categoria');
                    $dados['id_fornecedor']             = $this->input->post('id_fornecedor');
                    $dados['id_usuario']                = $this->session->userdata()['id_usuario'];
                    $dados['id_loja']                	= $this->session->userdata()['id_loja'];
                    $dados['nome']                      = ucwords($this->input->post('nome_produto'));
                    $dados['marca']                     = $this->input->post('marca_produto');
                    $dados['estado']                    = $this->input->post('estado');
                    $dados['modelo']                    = $this->input->post('modelo_produto');
                    $dados['codigo_barra']              = $CodigoBarras;
                    $dados['desconto_max']              = $this->input->post('desconto_maximo');
                    $dados['preco_venda']               = $this->input->post('preco_venda');
                    $dados['preco_troca']               = $this->input->post('preco_troca');
                    $dados['cor']                       = $this->input->post('cor_produto');
                    $dados['imei']                      = $this->input->post('imei_produto');
                    $dados['preco_compra']              = $this->input->post('preco_compra');
                    $dados['estoque_atual']             = $this->input->post('estoque_atual');
                    $dados['estoque_cadastrado']        = $this->input->post('estoque_atual');
                    $dados['estoque_minimo_aviso']      = $this->input->post('estoque_minimo_aviso');
                	$dados['descricao']                 = $this->input->post('descricao_produto');
                	$dados['ncm']						= $this->input->post('ncm');
                    $dados['extipi']					= $this->input->post('extipi');
                    $dados['data_cadastro']             = date('Y-m-d H:i:s');
                    $dados['data_ultima_modificacao']   = date('Y-m-d H:i:s');
                
                	if($this->Produto_Model->insert($dados)){
               			echo json_encode(array('erro' => false, 'msg' => 'Produto cadastrado com sucesso. <a href="'.$CodigoBarrasUrl.'" target="_BLANK" >Imprimir Código de Barras</a>'));
                	}
                }


		// Visualização
		} else {

			$this->load->model("Categoria_Model");
			$this->load->model("Fornecedor_Model");


			$view['Categorias'] = $this->Categoria_Model->getAll();
			$view['Fornecedor'] = $this->Fornecedor_Model->getAll();
			
			$this->template->set('titulo','Cadastrar Produto');
			$this->template->load('template','Produto/Cadastrar',$view);
		}
	}
}