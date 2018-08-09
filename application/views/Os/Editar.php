<script src="<?=base_url();?>public/js/os/editar.js"></script>
    <script type="text/javascript" src="<?=base_url('public/js/template/ajaxPost.js');?>"></script>


<script type="text/javascript" src="<?=base_url('public/js/upload/jquery.ui.js');?>"></script>
<script type="text/javascript" src="<?=base_url('public/js/upload/jquery.iframe-transport.js');?>"></script>
<script type="text/javascript" src="<?=base_url('public/js/upload/jquery.fileupload.js');?>"></script>



<div class="col-md-12 col-sm-12 col-xs-12">

   <?if(!empty($os_existente[id_os_orcamento])):?>
		<div class="x_title">
			<h2>Histórico de orçamento</h2>
			
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<?
				$pecas_usadas = json_decode($os_existente[pecas_usados]);
				
				if($os_existente[status] == '0') {
					$os_existente[status] = 'pendente';
				} elseif($os_existente[status] == '1') {
					$os_existente[status] = 'aprovado';
				} elseif($os_existente[status] == '2') {
					$os_existente[status] = 'negado';
				} elseif($os_existente[status] == '3') {
					$os_existente[status] = 'faturado';
				}

			?>
			<ul style="list-style: none; float: left;">
				

				<li><h3>Dados do orçamento</h3><br></li>
        <li><b>ID OS:</b> <?=$Os->id_os;?></li>
				<li><b>CLIENTE:</b> <?=$os_existente[nome];?></li>
				<li><b>TELEFONE:</b> <?=$os_existente[telefone];?></li>
				<li><b>CELULAR:</b> <?=$os_existente[celular];?></li>
				<li><b>ID ORÇAMENTO:</b> <?=$os_existente[id_os_orcamento];?></li>
				<li><b>DATA:</b> <?=date('d/m/Y H:i:s',strtotime($os_existente[data]));?></li>
				<li><b>STATUS ORÇAMENTO:</b> <?=$os_existente[status];?></li>
				<li><b>APARELHO:</b> <?=$os_existente[aparelho];?></li>
				<li><b>PEÇAS DO ORÇAMENTO:</b></li>
			</ul>

			 <ul style="float: right; list-style: none; ">
				
				<?if($pecas_usadas == false):?>
				<p style="color: red;">Nenhuma peça foi adicionada neste orçamento.</p>
				<?else:?>
				<p style="margin-left: 10px;">
				<li><h3>Peças usadas no orçamento</h3></li>
				<?foreach ($pecas_usadas as $key => $v):?>
					<br>
					<b>ID PEÇA:</b> <?=$v->id_peca;?> <br> <b>PEÇA:</b> <?=$v->quantidade;?> x <?=$v->nome_peca;?> <br> <b>VALOR DA PEÇA:</b> R$ <?=number_format($v->valor,2);?>
					<br>
					<b>VALOR TOTAL DO ORÇAMENTO:</b> R$ <?=number_format($v->valorTotal,2);?>
					<br>
				<?endforeach;?>
				<?endif;?>
				</p>
				</div>
				</li>
		
			</ul>
			<br><br>
		</div>
	<?endif;?>


                <div class="x_panel">
                  <div class="x_title">
                    <h2>Editar Ordem de Serviço #<?=$Os->id_os;?></h2>
                    <span style="float: right;"><a target="_BLANK" href='<?=base_url("os/imprimir/$Os->id_os");?>'>Imprimir Ordem de Serviço</a><br></span>
                    <div class="clearfix"></div>

                  </div>
                  <div class="x_content">
                <!--     <div class='alert alert-warning'>
                    Para cadastrar uma Ordem de Serviço, você precisa criar um usuário como cliente primeiro. <br> <a target="_blank" href='<?=base_url("usuario/cadastrar");?>'> Clicando Aqui</a>.
                    </div> -->
                    <form  id="ajaxForm" action='<?=base_url('os/editar/'.$Os->id_os.'');?>' method='POST' class="form-horizontal form-label-left" >
                    	<?if($Os->valor_orcamento != NULL):?>
	                    	<div style="text-align: right;margin-bottom: 20px;">
	   					 		Valor do orçamento<br>
	   					 		<b>R$ <?=$Os->valor_orcamento;?></b>
	    						<br><br>
	    						<?if($Os->status_orcamento == 0):?>
	    						Orçamento ainda não foi aprovado desaja aprovar ou negar pelo cliente?<br>
	    	<div  class='btn btn-primary' style="background-color: green;" data-id_orcamento='<?=$Os->id_os_orcamento;?>' data-id_os='<?=$Os->id_os;?>' id='aprovar'>
	 								Aprovar Orçamento
								</div>

				<div class='btn btn-primary' style="background-color: red;" data-id_orcamento='<?=$Os->id_os_orcamento;?>' data-id_os='<?=$Os->id_os;?>' id='negar'>
									 Negar Orçamento
								</div>

	    						<?elseif($Os->status_orcamento == 1):?>
	    						   Peças para o conserto.<br>
                    <?
                      $pecas = json_decode($Os->pecas_usados);
                      foreach ($pecas as $key => $v) {
                        echo '<b>'.$v->quantidade.' x '.$v->nome_peca . '</b> <br> ';
                      }
                    ?>

                    <br>

                    Orçamento foi Aprovado.

	    						<?elseif($Os->status_orcamento == 2):?>
	    							Orçamento foi Negado.
	    						<?elseif($Os->status_orcamento == 3):?>
	    							Orcamento foi Faturado.
	    						<?endif;?>
	    					
	  						</div>
	  					<?else:?>
	  						<div style="text-align: right;margin-bottom: 20px;">
	   					 		<h4>Orçamento não definido.</h4>
	  						</div>
	  					<?endif;?>

                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Enviar Fotos<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="fileupload" type="file" name="file">
                                    <!-- The global progress bar -->
                      <div id="progress" class="progress">
                      <div class="progress-bar progress-bar-success"></div>
                      </div>
                      <!-- The container for the uploaded files -->
                      <a href="javascript: atualizarFotos(<?=$Os->id_os;?>);">Atualizar Fotos</a>
                      <div id="fotos" class="fotos" style="display: block;/* overflow-x: scroll; */height: 76px;overflow: auto;">
                        
                      </div>

                        </div>
                      </div>

               

                      <?if($Os->status == 10):?>
	                      <script type="text/javascript">
	                      	$(function(){
	                      		$("#ajaxForm input,select,textarea").attr('disabled','disable');
	                      	});
	                      </script>
	                  <?endif;?>

	                  
	                       <div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status do OS<span class="required">*</span>
	                        </label>
	                        <div class="col-md-4 col-sm-6 col-xs-12">
	                          <!-- <select name='status' class='form-control'>
	                            <?foreach ($Status as $key => $v):?>
	                              <option <?=($Os->status == $key) ? 'selected' : '';?>  value='<?=$key;?>'><?=$v;?></option>
	                            <?endforeach;?>
	                          </select> -->
                              <select name="status" class="form-control">
                                <option <?=($Os->status == 1) ? 'selected' : '';?>  value="1">Aberto</option>
                                <option <?=($Os->status == 2) ? 'selected' : '';?>  value="2">Técnico(a) está analisando para fazer o orçamento</option>
                                <option <?=($Os->status == 3) ? 'selected' : '';?>  value="3">Técnico(a) está consertando</option>
                                <option <?=($Os->status == 4) ? 'selected' : '';?>  value="4">Aguardando a aprovação do orçamento</option>
                                <option <?=($Os->status == 5) ? 'selected' : '';?>  value="5">Serviço Concluído (Aguardando retirada)</option>
                                <option <?=($Os->status == 6) ? 'selected' : '';?>  value="6">Não foi possível consertar o aparelho (Aguardando retirada)</option>
                                <option <?=($Os->status == 11) ? 'selected' : '';?>  value="11">Entrar em contato com assistência</option>
                                <option <?=($Os->status == 9) ? 'selected' : '';?>  value="9">Orçamento aprovado.</option>
                                <option <?=($Os->status == 13) ? 'selected' : '';?>  value="13">Cliente retirou antes.</option>
                              </select>
	                        </div>
	                      </div>




                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Observações sobre o status OS
                        </label>
                        <div class="col-md-5 col-sm-6 col-xs-12">
                          <textarea name='observacao_status' rows="5"  class='form-control' placeholder="Comente algo sobre status do os, exemplo se o status for 'Não foi possível concertar' você escreve , O aparelho não foi possível concertar porquê a placa mãe queimou, terá que comprar um aparelho novo."></textarea>
                        </div>
                      </div>



                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nome do Equipamento<span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="text" name='nome' value='<?=$Os->nome;?>' placeholder='Ex: Samsung s6' class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Categoria do Equipamento<span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <select name='id_categoria' class='form-control'>
                            <?foreach ($Categorias as $key => $v):?>
                              <option <?=($Os->id_categoria == $v->id_categoria) ? 'selected' : '';?>  value='<?=$v->id_categoria;?>'><?=$v->nome;?></option>
                            <?endforeach;?>
                          </select>
                        </div>
                      </div>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Marca & Fabricante<span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="text" name='marca' value='<?=$Os->marca;?>' placeholder='Ex: Samsung' class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Modelo<span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="text" name='modelo' value='<?=$Os->modelo;?>' placeholder='Ex: S6' class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Série
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="text" name='serie' value='<?=$Os->serie;?>' placeholder='Ex: 428490209274204' class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">IMEI
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="text" name='imei' value='<?=$Os->imei;?>' placeholder='Ex: 350845555897085' class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Senha do Equipamento
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="text" name='senha_aparelho' value='<?=$Os->senha_aparelho;?>' placeholder='Ex: 1234senha' class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Data de previsão de Orçamento.<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                          <input type="date" name='data_previsao_orcamento'  value='<?=$Os->data_previsao_orcamento;?>'  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Qual é o defeito relatado ?<span class="required">*</span>
                        </label>
                        <div class="col-md-5 col-sm-6 col-xs-12">
                          <textarea name='defeito_declarado' rows="8" class='form-control'><?=$Os->defeito_declarado;?></textarea>
                        </div>
                      </div>

                      <?if(!empty($Os->defeito_encontrado)):?>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Qual é o defeito encontrado ?
                        </label>
                        <div class="col-md-5 col-sm-6 col-xs-12">
                          <textarea name='defeito_encontrado' rows="8" class='form-control'><?=$Os->defeito_encontrado;?></textarea>
                        </div>
                      </div>

                     <?endif;?>


                      <?if(!empty($Os->defeito_solucao)):?>


	                       <div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Qual é a solução para o defeito ?
	                        </label>
	                        <div class="col-md-5 col-sm-6 col-xs-12">
	                          <textarea name='defeito_solucao' rows="8" class='form-control'><?=$Os->defeito_solucao;?></textarea>
	                        </div>
	                      </div>

                     <?endif;?>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Observações
                        </label>
                        <div class="col-md-5 col-sm-6 col-xs-12">
                          <textarea name='observacao' rows="8" class='form-control' placeholder="Ex: Itens inclusos bateria,carregador."><?=$Os->observacoes;?></textarea>
                        </div>
                      </div>

                   
         
                    <div class="x_title">
                      <div class="clearfix"></div>
                    </div>
                          <div class='alert' id='retorno'>

                          </div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">
                         
                          <?if($Os->status != 10):?>
                            <button type="submit" class="btn btn-primary">Editar Ordem de Serviço</button>
                          <!-- <button id='limpar' class="btn btn-primary">Limpar</button> -->
                          <?endif;?>

                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>


<script>

$(function(){

    atualizarFotos(<?=$Os->id_os;?>);;

    'use strict';

    $('#fileupload').fileupload({
    // Change this to the location of your server-side upload handler:
        url: '<?=base_url("os/upload/".$Os->id_os."");?>',
        dataType: 'json',
        done: function (e, data) {
          atualizarFotos(<?=$Os->id_os;?>);
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }

    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});
</script>