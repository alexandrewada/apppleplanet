<?php

class Os extends CI_Controller {

        public function Monitoramento(){
            $this->load->model('Os_Model');
            $view['status_pendente'] = $this->Os_Model->getOsByStatus(1);
            $view['status_aprovado'] = $this->Os_Model->getOsByStatus(9);
            $view['status_semreparo'] = $this->Os_Model->getOsByStatus(6);
            $view['status_aguardando_aprovacao'] = $this->Os_Model->getOsByStatus(4);
            $view['status_aguardando_retirada'] = $this->Os_Model->getOsByStatus(5);

            $this->template->load('template','Os/Monitoramento',$view);      
        }


		public function Vinculadas($id_cliente) {
			$query = $this->db->query("SELECT tb_os.data_entrada, tb_os.id_os, tb_os.nome, tb_os_status.status FROM tb_os LEFT JOIN tb_os_status ON tb_os_status.id_os_status = tb_os.status WHERE id_cliente = ?",array($id_cliente)); 

			$view['os_vinculadas'] = $query->result();
            $view['id_cliente']    = $id_cliente;
			$this->load->view('Os/Vinculadas',$view);
		}


		public function getPecasRetorno($id_os=NULL) {
			header("Content-type: application/json");

	        $this->form_validation->set_rules('id_os', 'ID da Os', 'required|numeric');
	        
	        if ($this->form_validation->run() == FALSE)  { 
	            $json = array();
	            $json['result'] = false;
	            echo json_encode($json);
	        	exit;
	        } else {
		        $this->load->model('Peca_Model');
		        if($id_os == NULL) {
		        	$id_os = $this->input->post('id_os');
		        } else {
		        	$id_os = $id_os;
		        }
	       
		        $osRetornoPecas = $this->Peca_Model->getPecasRetorno($id_os);

		        if($osRetornoPecas == false) {
		            $json = array();
		            $json['result'] = false;
		            echo json_encode($json);
		        } else {
		            $json = array();
		            $json['result'] = true;
		            $json['data']   = $osRetornoPecas;
		            echo json_encode($json);
		        }

	        }
		}

		public function Retorno() {
		if($this->input->post() == true) {
			$this->form_validation->set_rules('id_venda', 'ID da Venda', 'required|numeric');
			$this->form_validation->set_rules('motivo_retorno', 'Motivo do Retorno', 'required');

			if ($this->form_validation->run() == FALSE)  { 
		        $this->template->load('template','Os/Retorno',array('erro' => validation_errors()));
			} else {
			
                
			}

	    	} else {
	    		$this->template->load('template','Os/Retorno',$view);
	    	}
		}


        public function getidos() {
            header("Content-type: application/json");

            $this->load->model('Os_Model');

            $id_os = $this->input->post('id_os');
            // $codigoBarras = '1473037190';

            $Orcamento = $this->Os_Model->getOrcamentoByIdOSSaida($id_os);

            if($Orcamento == false) {
                $json = array();
                $json['result'] = false;
                echo json_encode($json);
            } else {
                $json = array();
                $json['result'] = true;
                $json['data']   = $Orcamento;
                echo json_encode($json);
            }

        }

             public function DevolucaoPost() {
		         if($this->input->post() == true) {
		            header("Content-type: application/json");

		            $this->load->model("Os_Model");
		            $this->load->model("Usuario_Model");

		            $os = $this->input->post('os');

				    if($os == 'false') {
		                $erros[] = "Você precisa adicionar algum os para efetuar está operação.";
		            }

		            
		            $os = json_decode($os,true);
		            $os = $os[0];

		           
		            if(count($erros) > 0) {
		                echo json_encode(array('erro' => true, 'msg' => implode("<br>",$erros)));
		                exit;
		            } else {


		                    $ValorTotal             = $os[valor];	
		                    $ValorLucroUnitario     = $os[valor];
		                    $ValorLucroTotal        = ($ValorTotal- $JurosCartao);


		                    $insertSaida = array();
		                    $insertSaida['id_tecnico']                          =      $this->session->userdata()['id_usuario'];
		                    $insertSaida['id_os']                             	=      $os[id_os];
		                    $insertSaida['id_os_orcamento']						= 	   $os[id_os_orcamento];
		                    $insertSaida['id_nfe']                              =      $id_nfe;
		                	$insertSaida['id_loja']                             =      $this->session->userdata()['id_loja'];
		                    $insertSaida['quantidade']                          =      $os[quantidade];
		                    $insertSaida['valor_orcamento_total']               =      $os[valor];
		                    $insertSaida['status']                              =      3;
		                    $insertSaida['data_saida']                          =      date('Y-m-d H:i:s');
		                    $this->db->insert('tb_saida_os',$insertSaida);
		                    $id_saida_os = $this->db->insert_id();

		                    $this->db->update('tb_os',array('status' => 10),array('id_os' => $os[id_os]));
               
		        	        redirect(base_url('os/devolucao/'.$os[id_os]),refresh);
		            }
		         }
   		 }



       public function Saida() {
         if($this->input->post() == true) {
            header("Content-type: application/json");

            $this->load->model("Os_Model");
            $this->load->model("Usuario_Model");
            $this->load->library('Sendemail');
			


            $os = $this->input->post('os');


            $erros = array();
            // Se a forma de pagamento for c´redito numero de parcela obrigatorio e maior que 0 e inteiro
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
            
            
            if($os == 'false') {
                $erros[] = "Você precisa adicionar algum peça para efetuar está operação.";
            }


            
            $os 	 = json_decode($os,true);
            $os 	 = $os[0];
           	$dadosOs = $this->Os_Model->getByID($os[id_os]);


            
            if ($this->form_validation->run() == FALSE)
            {
                echo json_encode(array('erro' => true, 'msg' => validation_errors()));
                exit;
            }
           
            if(count($erros) > 0) {
                echo json_encode(array('erro' => true, 'msg' => implode("<br>",$erros)));
                exit;
            } else {


                    //Regras de negocio para emitir notas
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
                            


                            // $dadosCliente = $this->Usuario_Model->getByCPF(trim($this->input->post('cpf_cliente')));
                            if($ok == true){
                                $this->load->library('Notafiscal');
                                
                                
                                $notaFiscal = new Notafiscal();

                                if(!empty($dadosCliente->cpf)){
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
                                } else {
                                    $notaFiscal->destinatario(array(
                                        'nome'              => removerAcento(trim($dadosCliente->nome)),
                                        'cnpj'              => preg_replace("/[^0-9]/", "", trim($dadosCliente->cnpj)),
                                        'ie'                => preg_replace("/[^0-9]/", "", trim($dadosCliente->ie)),
                                        'endereco_rua'      => removerAcento(trim($dadosCliente->rua)),
                                        'endereco_numero'   => removerAcento(trim($dadosCliente->rua_numero)),
                                        'bairro'            => removerAcento(trim($dadosCliente->bairro)),
                                        'codigo_municipio'  => '3550308',
                                        'municipio'         => removerAcento(trim($dadosCliente->cidade)),
                                        'uf'                => strtoupper(removerAcento(trim($dadosCliente->uf)))
                                    ));
                                }


                                $ossArray = array();

                                foreach ($os['pecas_usadas'] as $key => $v) {
                                    $osPeca = $v;
                                    $ossArray[$key]['id_produto']          = $osPeca[id_peca];
                                    $ossArray[$key]['nome_produto']        = strtoupper(removerAcento($osPeca[nome_peca]));
                                    $ossArray[$key]['unidade_produto']     = $osPeca[quantidade];
                                    $ossArray[$key]['preco_produto']       = $osPeca[valor];
                                       
                                }

								

                                $notaFiscal->addProduto($ossArray);
                                $resultadoNota = $notaFiscal->gerarNF();




                                $urlNotaFiscal      = $resultadoNota[msg][urlPdf];
                                $chaveNotaFiscal    = $resultadoNota[msg][aProt][0][chNFe];
                                $reciboNotaFiscal   = $resultadoNota[msg][nRec];


                                $dadosNfe = array(
                                                'url_pdf' => $urlNotaFiscal,
                                                'chave'   => $chaveNotaFiscal,
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





            		// Se a forma do pagamento cartao adicionar juros do cartao
                    if($this->input->post('forma_pagamento') != '3') {
                        $this->load->model("Juros_Model");
                        $JurosCartao = $this->Juros_Model->jurosCartao($this->input->post('forma_pagamento'),$this->input->post('numero_parcelas'),($os[valor]));
                    } else {
                        $JurosCartao = 0;
                    }


                    $ValorTotal             = $os[valor];	
                        
                    // Se a opção tiver juros 
                    if($this->input->post('jurosparcelamento') == 'on') {
                        $ValorTotal = $ValorTotal + $this->input->post('valorjurosparcelamento');
                    }

                    // Se tiver desconto aplica 
                    if($this->input->post('desconto') != '0') {
                        $ValorTotal = $ValorTotal - (($osBd->preco_venda*$this->input->post('desconto'))/100);
                    }

                    $ValorLucroUnitario     = $os[valor];
                    $ValorLucroTotal        = ($ValorTotal- $JurosCartao);


                    $insertSaida = array();
                    $insertSaida['id_tecnico']                          =      $this->session->userdata()['id_usuario'];
                    $insertSaida['id_os']                             	=      $os[id_os];
                    $insertSaida['id_os_orcamento']						= 	   $os[id_os_orcamento];
                    $insertSaida['id_nfe']                              =      $id_nfe;
                    $insertSaida['id_formapagamento']                   =      $this->input->post('forma_pagamento');
                    $insertSaida['parcela']                             =      $this->input->post('numero_parcelas');
                    $insertSaida['desconto']                            =      $this->input->post('desconto');
                    $insertSaida['valor_desconto']                      =      ($this->input->post('desconto') != '0') ? ($os[valor]*$this->input->post('desconto'))/100 : 0;
                    $insertSaida['id_loja']                             =      $this->session->userdata()['id_loja'];
                    $insertSaida['quantidade']                          =      $os[quantidade];
                    $insertSaida['valor_orcamento_total']               =      $os[valor];
                    $insertSaida['valor_orcamento_lucro']               =      $ValorLucroTotal;
                    $insertSaida['status']                              =      1;
                    $insertSaida['juros_cartao']                        =      $JurosCartao;
                    $insertSaida['data_saida']                          =      date('Y-m-d H:i:s');
                    $this->db->insert('tb_saida_os',$insertSaida);
                    $id_saida_os = $this->db->insert_id();

                    // Adiciona status faturado no tabela os e os_orcamento
                    $this->db->update('tb_os',array('status' => 10),array('id_os' => $os[id_os]));
                    $this->db->update('tb_os_orcamento',array('status' => 3),array('id_os_orcamento' => $os[id_os_orcamento]));

                    // Adiciona no historico que orçamento foi faturado....
                    $dadosHistorico = array();
                    $dadosHistorico['id_os']                 = $os[id_os];
                    $dadosHistorico['id_usuarioEditou']      = $this->session->userdata()['id_usuario'];
                    $dadosHistorico['status']                = 10;
                    $dadosHistorico['data']                  = date('Y-m-d H:i:s');
                    $dadosHistorico['observacao']            = 'O orçamento foi faturado.';
                    $this->db->insert('tb_os_historico',$dadosHistorico);

                if($this->input->post('garantia') == 'on') {
                    $garantia = "<a target='_BLANK' href='".base_url('os/garantia/'.$os[id_os])."'>Clique aqui parar Imprimir a Garantia do Cliente</a>";
                }

                $this->sendemail->toEmail = "$dadosOs->email";
                $this->sendemail->toNome  = 'Apple Planet';
                $this->sendemail->assunto = '[Apple Planet] Garantia da Apple Planet.';
                $this->sendemail->msg     = 'Segue o link contendo sua garantia <a href="'.base_url('os/garantia/'.$os[id_os]).'">Clique Aqui</a>';
                $this->sendemail->Enviar();

                    
                if($this->input->post('notafiscal') == 'on') {
                     echo json_encode(array('erro' => false, 'msg' => '<script>posSucesso();</script> Operação feita com sucesso...<br><a target="_BLANK" href="'.$urlNotaFiscal.'">Clique aqui parar imprimir a nota do cliente</a> <br>'.$garantia));
                } else {
                     echo json_encode(array('erro' => false, 'msg' => '<script>posSucesso();</script> Operação feita com sucesso... <br>'.$garantia));
                }
                exit;
                }

            }

          else {
            $view['formapagamentos'] = $this->db->query("SELECT * FROM appleplanet.tb_formapagamento ORDER BY tipo")->result();
            $this->template->load('template','Os/Saida',$view);   
         }
    }


    public function Abas($id_os,$id_cliente) {
        $this->load->model("Os_Model");
        $view['id_os']          = $id_os;
        $view['id_cliente']     = $id_cliente;
        $view['os_detalhes']	= $this->Os_Model->getByID($id_os);
        $this->load->view('Os/Abas',$view);
    }


    public function Detalhes($id_os) {
        $this->load->model('Os_Model');

        $os = $this->Os_Model->getByID($id_os);

        if($os != false) {
            $view['os'] = $os;
            $this->load->view('Os/Detalhes',$view);
        } else {
            echo 'Os não encontrada.';
        }
    }    


    public function ListarFotos($id_os) {

        echo '
            <style>
                img {
                    margin: 3px;
                }
            </style>
        ';
        
        $dir = "/var/www/html/public/images/os/fotos/".$id_os;

        if(file_exists($dir) == true) {
            $fotos = scandir($dir,1);
            foreach ($fotos as $key => $v) {
                if(file_exists($dir.'/'.$v) == true AND !in_array($v,array(".",".."))) {
                    echo "<a target='_BLANK' href='".base_url('public/images/os/fotos/'.$id_os.'/'.$v)."'><img width='50px' src='".base_url('public/images/os/fotos/'.$id_os.'/'.$v)."'/></a>";
                }
            }
        } else {
            echo 'Nenhuma foto cadastrada.';
        }
    }

    public function Upload($id_os) {



        $config['upload_path']          = '/var/www/html/public/images/os/fotos/'.$id_os;
        $config['allowed_types']        = 'gif|jpg|png|JPEG|jpeg|bmp';

        if(file_exists($config['upload_path']) == false) {
            mkdir($config['upload_path'],0777, true);
        }

        $config['file_name'] = time();

       
        $this->load->library('upload', $config);


        if ( ! $this->upload->do_upload('file'))
        {
                $error = array('error' => $this->upload->display_errors());
                var_dump($error);
               // $this->load->view('upload_form', $error);
        }
        else
        {
                $data = array('upload_data' => $this->upload->data());
                var_dump($data);
                //$this->load->view('upload_success', $data);
        }
    }


    public function Imprimir($id_os) {
        $this->load->model('Os_Model');

        $os = $this->Os_Model->getByID($id_os);

        if($os != false) {
            $view['os'] = $os;
            $this->load->view('Os/Imprimir',$view);
        } else {
        	echo 'Os não encontrada.';
        }
    }


    public function Garantia($id_os) {
        $this->load->model('Os_Model');
        $this->load->model('Peca_Model');

        $os 		= $this->Os_Model->getByID($id_os);
        $pecas 		= $this->Peca_Model->getPecasRetorno($id_os);

        if($os != false) {
            $view['os'] 				= $os;
           	$view['pecasGarantia']		= $pecas;
            $this->load->view('Os/Garantia',$view);
        } else {
            echo 'Os não encontrada.';
        }
    }

    public function Devolucao($id_os) {
        $this->load->model('Os_Model');

        $os = $this->Os_Model->getByID($id_os);

        if($os != false) {
            $view['os'] = $os;
            $this->load->view('Os/Devolucao',$view);
        } else {
            echo 'Os não encontrada.';
        }
    }


    public function Aprovacao() {

        $this->load->model("Os_Model");
        $this->load->model("Peca_Model");

        if($this->input->post() == false) {
            $dadosOs = $this->Os_Model->aprovacaoOrcamento($_SESSION['id_usuario']);
            if($dadosOs != false) {
                $view['os']          = $dadosOs;
                $this->template->load('template','Os/Aprovacao',$view);         
            } else {
                redirect(base_url('os/acompanhamento'));
            }
        } else {

            header("Content-type: application/json");

            $this->form_validation->set_rules('id_orcamento', 'Id do orçamento', 'required|numeric');
            $this->form_validation->set_rules('status_aprovacao', 'Aprovação', 'required|numeric');
            $this->form_validation->set_rules('id_os', 'Id da ordem de serviço', 'required|numeric');
                        

            if($this->form_validation->run() == FALSE) {
                echo json_encode(array('erro' => true, 'msg' => validation_errors()));
            } else {

                $id_orcamento = $this->input->post('id_orcamento');
                $status       = $this->input->post('status_aprovacao');
                $id_os        = $this->input->post('id_os');

                if($status == '0') {
                    $this->db->update('tb_os_orcamento',array('status' => 2),array('id_os_orcamento' => $id_orcamento));
                    $this->db->update('tb_os',array('status' => 7),array('id_os' => $id_os));

                    $dadosHistorico = array();
                    $dadosHistorico['id_os']                 = $id_os;
                    $dadosHistorico['id_usuarioEditou']      = $this->session->userdata()['id_usuario'];
                    $dadosHistorico['status']                = 7;
                    $dadosHistorico['data']                  = date('Y-m-d H:i:s');
                    $dadosHistorico['observacao']            = 'O orçamento não foi aprovado, aguardando a retirada do aparelho.';
                    $this->db->insert('tb_os_historico',$dadosHistorico);
                    echo json_encode(array('erro' => false, 'msg' => 'O seu orçamento foi negado com sucesso.'));
          
                } else if($status == '1'){
                    $dados_orcamento = $this->Os_Model->getByID($id_os);
               		$retirar_pecas_estoque = json_decode($dados_orcamento->pecas_usados);	


                    if($dados_orcamento->pecas_usados == 'false') {
                        echo json_encode(array('erro' => true, 'msg' => 'Não foi possível aprovar o orçamento, não existe peças cadastradas no orçamento, adicione as peças e tente novamente'));
                        exit;
                    }
               
                    foreach ($retirar_pecas_estoque as $key => $v) {
                   		$pecaBd  			   = $this->Peca_Model->getByID($v->id_peca);
                    	$id_peca 			   = $v->id_peca;
                    	$qtd_peca 			   = $v->quantidade;
						

	                    $ValorTotal             = $pecaBd->preco_venda*$qtd_peca;
	                        
	                 
	                    $ValorLucroUnitario     = ($pecaBd->preco_venda) - ($pecaBd->preco_compra);
	                    $ValorPrecoCusto        = $pecaBd->preco_compra*$qtd_peca;
	                    $ValorLucroTotal        = (($ValorTotal) - ($ValorPrecoCusto));


	            		$insertSaida = array();
	    				$insertSaida['id_vendedor']			                =	   $this->session->userdata()['id_usuario'];
	    				$insertSaida['id_peca'] 			                = 	   $id_peca;
	                    $insertSaida['id_loja'] 			                =      $this->session->userdata()['id_loja'];
	    				$insertSaida['quantidade'] 			                =      $qtd_peca;
	    				$insertSaida['valor_unitario'] 		                =      $pecaBd->preco_venda;
	    	            $insertSaida['status']                              =      1;
	                 	$insertSaida['valor_total']			                =  	   $ValorTotal;
	                    $insertSaida['valor_lucro_unitario']                =      $ValorLucroUnitario;
	                    $insertSaida['valor_lucro_total']                   =      $ValorLucroTotal;
	                    $insertSaida['data_saida']			                =      date('Y-m-d H:i:s');
	                    $insertSaida['id_os_orcamento']						=	   $id_orcamento;
	    				$this->db->insert('tb_saida_peca',$insertSaida);
                    
                    }

                    $this->db->update('tb_os_orcamento',array('status' => 1),array('id_os_orcamento' => $id_orcamento));
                    $this->db->update('tb_os',array('status' => 9),array('id_os' => $id_os));
                
                    $dadosHistorico = array();
                    $dadosHistorico['id_os']                 = $id_os;
                    $dadosHistorico['id_usuarioEditou']      = $this->session->userdata()['id_usuario'];
                    $dadosHistorico['status']                = 9;
                    $dadosHistorico['data']                  = date('Y-m-d H:i:s');
                    $dadosHistorico['observacao']            = 'Orçamento aprovado, agora é só acompanhar a próxima posição do técnico :)';
                    $this->db->insert('tb_os_historico',$dadosHistorico);
                    echo json_encode(array('erro' => false, 'msg' => 'O seu orçamento foi aprovado com sucesso.'));
                } 

            }

        }
    }

    public function Acompanhamento() {
    	$this->load->model('Os_Model');
        $view['acompanhamento'] = $this->Os_Model->getAcompanhamento();
        $this->template->load('template','Os/Acompanhamento',$view);
    }

    public function Historico($id_usuario) {
        $this->load->model('Os_Model');
        $view['historico'] = $this->Os_Model->getHistorico($id_usuario);
        $this->load->view('Os/Historico',$view);
    }


    public function Orcamento($id_orcamento) {

        if($this->input->post() == false) {
	    	$view['id_os']				= $id_orcamento;
	        $this->load->view('Os/Orcamento',$view);
    	} else {

		    header("Content-type: application/json");

    		$this->form_validation->set_rules('valor_total', 'Valor Total do Orçamento', 'required|numeric');    		
    		$this->form_validation->set_rules('valor_mao_obra','Valor da mão de obra','numeric');
            $this->form_validation->set_rules('defeito_encontrado','Defeito encontrado','required');
            $this->form_validation->set_rules('defeito_solucao','Defeito Solução','required');
    		$this->form_validation->set_rules('id_os', 'ID Orcamento', 'required|numeric');    		

    		if($this->form_validation->run() == FALSE) {
    			echo json_encode(array('erro' => true, 'msg' => validation_errors()));
    		} else {

    			$this->load->model("Os_Model");


    			$dadosOrcamento = array();
    			$dadosOrcamento['id_os']				= $this->input->post('id_os');
                $dadosOrcamento['id_loja']              = $this->session->userdata()['id_loja'];
                $dadosOrcamento['id_usuario']           = $this->session->userdata()['id_usuario'];
    			$dadosOrcamento['valor']				= $this->input->post('valor_total');
    			$dadosOrcamento['pecas_usados']			= $this->input->post('pecas_usados');
    			$dadosOrcamento['status']				= '0';
    			$dadosOrcamento['data']					= date('Y-m-d H:i:s');
    			$dadosOrcamento['detalhes']				= $this->input->post('datalhes_orcamento');


                $atualizarDadosOs = array();
                $atualizarDadosOs['defeito_encontrado'] = $this->input->post('defeito_encontrado');
                $atualizarDadosOs['defeito_solucao']    = $this->input->post('defeito_solucao');
                $this->db->update('tb_os',$atualizarDadosOs,array('id_os' => $this->input->post('id_os')));

    			$OrcamentoExistente = $this->Os_Model->getOrcamentoExistente($this->input->post('id_os'));

    			if($OrcamentoExistente != false) {

    				if($this->db->update("tb_os_orcamento",$dadosOrcamento,"id_os = ".$this->input->post('id_os')) == true) {
	    				
	  				    $dadosHistorico = array();
	                    $dadosHistorico['id_os'] 				 = $this->input->post('id_os');
                        $dadosHistorico['id_usuarioEditou']		 = $this->session->userdata()['id_usuario'];
                        $dadosHistorico['id_loja']               = $this->session->userdata()['id_loja'];
	                    $dadosHistorico['status']				 = 4;
	                    $dadosHistorico['data']				 	 = date('Y-m-d H:i:s');
	                    $dadosHistorico['observacao']        	 = 'Um novo orçamento foi enviado, aguardando a aprovação do cliente.';
	                    $this->db->insert('tb_os_historico',$dadosHistorico);



                        $atualizarDadosOs = array();
                        $atualizarDadosOs['defeito_encontrado'] = $this->input->post('defeito_encontrado');
                        $atualizarDadosOs['status']             = 4;
                        $atualizarDadosOs['defeito_solucao']    = $this->input->post('defeito_solucao');
                        $this->db->update('tb_os',$atualizarDadosOs,array('id_os' => $this->input->post('id_os')));

	                    echo json_encode(array('erro' => false, 'msg' => 'Orçamento atualizado. <script>window.location.href = "'.base_url('os/gerenciar').'";</script>'));

	    			}


    			} else {

	    			if($this->db->insert("tb_os_orcamento",$dadosOrcamento)){
	    				$id_orcamento = $this->db->insert_id();
			
			   			$dadosUpdate = array();
		    			$dadosUpdate['status']					= 4;
		    			$dadosUpdate['id_os_orcamento']			= $id_orcamento;

		    			if($this->Os_Model->update($dadosUpdate,"id_os = ".$this->input->post('id_os')) == true) {
		    				echo json_encode(array('erro' => false, 'msg' => 'Orçamento novo adicionado. <script>window.location.href = "'.base_url('os/gerenciar').'";</script> '));
		    			}

	  				    $dadosHistorico = array();
	                    $dadosHistorico['id_os'] 				 = $this->input->post('id_os');
	                    $dadosHistorico['id_usuarioEditou']		 = $this->session->userdata()['id_usuario'];
                        $dadosHistorico['id_loja']               = $this->session->userdata()['id_loja'];
	                    $dadosHistorico['status']				 = 4;
	                    $dadosHistorico['data']				 	 = date('Y-m-d H:i:s');
	                    $dadosHistorico['observacao']        	 = 'Um orçamento foi criado, aguardando a aprovação do cliente.';
	                    $this->db->insert('tb_os_historico',$dadosHistorico);

	    			}

    			}
    		}
    	}
    }

    public function Gerenciar() {

        $this->load->model('Os_Model');
        $view['ListarOs'] = $this->Os_Model->getAll();
        $view['Status']   = $this->Os_Model->StatusTradutorArray();

        $this->template->load('template','Os/Gerenciar',$view);
    }

        public function Editar($id_os)
    {
        
        if($this->input->post() == true) {

                header("Content-type: application/json");

                $this->load->model("Os_Model");
                $StatusTraducao   = $this->Os_Model->StatusTradutorArray();
                

                $this->form_validation->set_rules('nome', 'Nome do Equipamento', 'required');
                $this->form_validation->set_rules('id_categoria', 'Categoria do Equipamento', 'required');
                $this->form_validation->set_rules('marca', 'Marca do Equipamento', 'required');
                $this->form_validation->set_rules('status','Status do OS','required|numeric');
                $this->form_validation->set_rules('modelo', 'Modelo de Equipamento', 'required');
                $this->form_validation->set_rules('defeito_declarado','Defeito do Equipamento','required|min_length[6]');
                $this->form_validation->set_rules('data_previsao_orcamento','Data de previsão','required');
                // $this->form_validation->set_rules('observacao_status','Observação do Status','required');

               


                if ($this->form_validation->run() == FALSE)
                {
                    echo json_encode(array('erro' => true, 'msg' => validation_errors()));
                    exit;
                }
                    else
                {

                    $this->load->model('Usuario_Model');


                    $dadosOsAntigo = $this->Os_Model->getByID($id_os);

                    $dados = array();
                    $dados['id_categoria']              = $this->input->post('id_categoria');
                    $dados['nome']                      = ucwords($this->input->post('nome'));
                    $dados['marca']                     = $this->input->post('marca');
                    $dados['status']                    = $this->input->post('status');
                    $dados['modelo']                    = $this->input->post('modelo');
                    $dados['serie']                     = $this->input->post('serie');
                    $dados['imei']                      = $this->input->post('imei');
                    $dados['senha_aparelho']            = $this->input->post('senha_aparelho');
                    $dados['defeito_declarado']         = $this->input->post('defeito_declarado');
                    $dados['observacoes']               = $this->input->post('observacao');
                    // $dados['defeito_encontrado']        = $this->input->post('defeito_encontrado');
                    // $dados['defeito_solucao']           = $this->input->post('defeito_solucao');
                    $dados['data_ultima_modificacao']   = date('Y-m-d H:i:s');
                    $dados['data_previsao_orcamento']   = date('Y-m-d',strtotime($this->input->post('data_previsao_orcamento')));
                     

                    if($this->Os_Model->update($dados,"id_os = $id_os")){
                        echo json_encode(array('erro' => false, 'msg' => 'Ordem de Servico cadastrada com sucesso. <script>window.location.reload(); </script>'));
                    }


                    if($dadosOsAntigo->status_os != $this->input->post('status')) {
                        $dadosHistorico = array();
                        $dadosHistorico['id_os'] 				 = $id_os;
                        $dadosHistorico['id_usuarioEditou']		 = $this->session->userdata()['id_usuario'];
                        $dadosHistorico['id_loja']		 		 = $this->session->userdata()['id_loja'];
                        $dadosHistorico['status']				 = $this->input->post('status');
                        $dadosHistorico['data']				 	 = date('Y-m-d H:i:s');
                        $dadosHistorico['observacao']        	 = $this->input->post('observacao_status');
                        // echo '<pre>';
                        // var_dump($dadosHistorico);
                        $this->db->insert('tb_os_historico',$dadosHistorico);
                    }

                }


        // Visualização
        } else {

            $this->load->model('Categoria_Model');
            $this->load->model('Usuario_Model');
            $this->load->model('Os_Model');

            $os = $this->Os_Model->getByID($id_os);

            if($os != false) {
                $view['Status']   		= $this->Os_Model->StatusTradutorArray();
                $view['Os']             = $os;
                $view['Categorias']     = $this->Categoria_Model->getAll();
   	 			$view['os_existente']	= $this->Os_Model->getOrcamentoByIdOS($id_os);	
                $this->load->view('Os/Editar',$view);
            } else {
                echo 'O id do os não existe';
                exit;
            }

        }
    }















public function Cadastrar($id_usuario)
    {
        
        if($this->input->post() == true) {

                header("Content-type: application/json");

                $this->load->model("Os_Model");

                // $this->form_validation->set_rules('email_cliente', 'Email do cliente', 'required|valid_email');
                $this->form_validation->set_rules('nome', 'Nome do Equipamento', 'required');
                $this->form_validation->set_rules('id_categoria', 'Categoria do Equipamento', 'required');
                $this->form_validation->set_rules('marca', 'Marca do Equipamento', 'required');
                $this->form_validation->set_rules('modelo', 'Modelo de Equipamento', 'required');
                $this->form_validation->set_rules('defeito_declarado','Defeito do Equipamento','required|min_length[6]');
                $this->form_validation->set_rules('data_previsao_orcamento','Data de previsão','required');




                if ($this->form_validation->run() == FALSE)
                {
                    echo json_encode(array('erro' => true, 'msg' => validation_errors()));
                    exit;
                }
                    else
                {

                    $this->load->model('Usuario_Model');
                    $this->load->model("Os_Model");
                    $this->load->library('Sendemail');

                    $dadosCliente     = $this->Usuario_Model->getByID($this->input->post('id_usuario'));
			
                    $StatusTraducao   = $this->Os_Model->StatusTradutorArray();
                                

                    $dados = array();
                    $dados['id_categoria']              = $this->input->post('id_categoria');
                    $dados['id_cliente']                = $this->input->post('id_usuario');
                    $dados['id_loja']                   = $this->session->userdata()['id_loja'];
                    $dados['id_criador']                = $this->session->userdata()['id_usuario'];
                    $dados['nome']                      = ucwords($this->input->post('nome'));
                    $dados['marca']                     = $this->input->post('marca');
                    $dados['modelo']                    = $this->input->post('modelo');
                    $dados['cor']                       = $this->input->post('cor');
                    $dados['serie']                     = $this->input->post('serie');
                    $dados['imei']                      = $this->input->post('imei');
                    $dados['senha_aparelho']            = $this->input->post('senha_aparelho');
                    $dados['defeito_declarado']         = $this->input->post('defeito_declarado');
                    $dados['observacoes']               = $this->input->post('observacao');
                    $dados['data_entrada']              = date('Y-m-d H:i:s');
                    $dados['data_ultima_modificacao']   = date('Y-m-d H:i:s');
                    $dados['data_previsao_orcamento']   = date('Y-m-d',strtotime($this->input->post('data_previsao_orcamento')));
                       
                    if($this->Os_Model->insert($dados)){

			            $this->sendemail->toEmail = "$dadosCliente->email";
				        $this->sendemail->toNome  = 'Apple Planet';
				        $this->sendemail->assunto = '[Apple Planet] Sua ordem de serviço.';
				        $this->sendemail->msg     = 'Segue o link contendo sua ordem de serviço <a href="'.base_url("os/imprimir/{$this->Os_Model->lastID}").'">Clique Aqui</a>';
				        $this->sendemail->Enviar();


     echo json_encode(array('erro' => false, 'msg' => 'Ordem de Serviço cadastrada com sucesso.<br><a target="_BLANK" href="'.base_url("os/imprimir/{$this->Os_Model->lastID}").'">Clique aqui para imprimir a via do cliente</a>'));


 					

                        $dadosHistorico = array();
                        $dadosHistorico['id_os']                 = $this->Os_Model->lastID;
                        $dadosHistorico['id_usuarioEditou']      = $this->session->userdata()['id_usuario'];
                        $dadosHistorico['status']                = 1;
                        $dadosHistorico['data']                  = date('Y-m-d H:i:s');
                        $dadosHistorico['observacao']            = 'Sua ordem de serviço foi cadastrada, aguarde novas alterações de status.';
                        $this->db->insert('tb_os_historico',$dadosHistorico);
                    }
                }


        // Visualização
        } else {

            $this->load->model('Categoria_Model');
            $this->load->model('Usuario_Model');

            $view['Clientes']   = $this->Usuario_Model->getClientesLoja();
            $view['Categorias'] = $this->Categoria_Model->getAll();
            $view['id_usuario'] = $id_usuario;
            $this->load->view('Os/Cadastrar',$view);
        }
    





	// public function Cadastrar()
	// {
		
	// 	if($this->input->post() == true) {

	// 			header("Content-type: application/json");

	// 			$this->load->model("Os_Model");

	// 		 	$this->form_validation->set_rules('email_cliente', 'Email do cliente', 'required|valid_email');
	// 		    $this->form_validation->set_rules('nome', 'Nome do Equipamento', 'required');
 //                $this->form_validation->set_rules('id_categoria', 'Categoria do Equipamento', 'required');
 //                $this->form_validation->set_rules('marca', 'Marca do Equipamento', 'required');
 //                $this->form_validation->set_rules('modelo', 'Modelo de Equipamento', 'required');
 //         		$this->form_validation->set_rules('defeito_declarado','Defeito do Equipamento','required|min_length[6]');
 //                $this->form_validation->set_rules('data_previsao_orcamento','Data de previsão','required');

 //                if(valid_email($this->input->post('email_cliente')) != true) {
 //                    echo json_encode(array('erro' => true, 'msg' => 'O email '. $this->input->post('email_cliente') . ' está errado.'));
 //                    exit;
 //                }               



 //                if ($this->form_validation->run() == FALSE)
 //                {
 //             		echo json_encode(array('erro' => true, 'msg' => validation_errors()));
 //             		exit;
 //                }
 //                	else
 //                {

 //                	$this->load->model('Usuario_Model');
 //                	$this->load->model("Os_Model");

 //                	$StatusTraducao   = $this->Os_Model->StatusTradutorArray();
                

 //                    $DadosCliente = $this->Usuario_Model->UsuarioExiste($this->input->post('email_cliente'));

 //                	if($DadosCliente == false) {
 //                		echo json_encode(array('erro' => true, 'msg' => 'O email do cliente '. $this->input->post('email_cliente') . ' não foi encontrado.'));
 //                		exit;	
 //                	}

                

 //                	$dados = array();
 //                    $dados['id_categoria']              = $this->input->post('id_categoria');
 //                    $dados['id_cliente']				= $DadosCliente->id_usuario;
 //                    $dados['id_loja']             		= $this->session->userdata()['id_loja'];
 //                    $dados['id_criador']                = $this->session->userdata()['id_usuario'];
 //                    $dados['nome']                      = ucwords($this->input->post('nome'));
 //                    $dados['marca']                     = $this->input->post('marca');
 //                    $dados['modelo']                    = $this->input->post('modelo');
 //                    $dados['serie']                     = $this->input->post('serie');
 //                    $dados['imei']                      = $this->input->post('imei');
 //                    $dados['senha_aparelho']            = $this->input->post('senha_aparelho');
 //                    $dados['defeito_declarado']         = $this->input->post('defeito_declarado');
 //                    $dados['observacoes']               = $this->input->post('observacao');
 //                    $dados['data_entrada']              = date('Y-m-d H:i:s');
 //                    $dados['data_ultima_modificacao']   = date('Y-m-d H:i:s');
 //                    $dados['data_previsao_orcamento']   = date('Y-m-d',strtotime($this->input->post('data_previsao_orcamento')));
                       
 //                	if($this->Os_Model->insert($dados)){
 //     echo json_encode(array('erro' => false, 'msg' => 'Ordem de Serviço cadastrada com sucesso.<br><a target="_BLANK" href="'.base_url("os/imprimir/{$this->Os_Model->lastID}").'">Clique aqui para imprimir a via do cliente</a>'));
 //                        $dadosHistorico = array();
 //                        $dadosHistorico['id_os']                 = $this->Os_Model->lastID;
 //                        $dadosHistorico['id_usuarioEditou']      = $this->session->userdata()['id_usuario'];
 //                        $dadosHistorico['status']                = 1;
 //                        $dadosHistorico['data']                  = date('Y-m-d H:i:s');
 //                        $dadosHistorico['observacao']            = 'Sua ordem de serviço foi cadastrada, aguarde novas alterações de status.';
 //                        $this->db->insert('tb_os_historico',$dadosHistorico);
 //                	}
 //                }


	// 	// Visualização
	// 	} else {

	// 		$this->load->model('Categoria_Model');
	// 		$this->load->model('Usuario_Model');


	// 		$view['Clientes']	= $this->Usuario_Model->getClientesLoja();
	// 		$view['Categorias'] = $this->Categoria_Model->getAll();

	// 		$this->template->set('titulo','Cadastrar Ordem Serviço');
	// 		$this->template->load('template','Os/Cadastrar',$view);
	// 	}
	}
}