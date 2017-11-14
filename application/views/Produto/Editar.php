<script src="<?=base_url();?>public/js/produto/editar.js"></script>
<!-- AjaxPost -->
<script src="<?=base_url('public/js/template/ajaxPost.js');?>"></script>


<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Editar produtos</h2>
                  
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br>
                    <form  id="ajaxForm" action='<?=base_url('produto/editar/'.$Produto->id_produto.'');?>'' method='POST' class="form-horizontal form-label-left" >
                      
					<div class="form-group" <?=(!in_array($this->session->userdata()[id_perfil],array(2,5,6)) ? 'hidden' : '');?> >
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Excluir Produto? <input type="checkbox" name='excluir'>
							<span class="required">*</span>
						</label>
					</div>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nome do produto<span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="text" name='nome_produto' value='<?=$Produto->nome;?>' placeholder='Ex: Iphone 6s' class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Categoria<span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <select name='id_categoria' class='form-control'>
                            <?foreach ($Categorias as $key => $v):?>
                            	<option <?=($v->id_categoria == $Produto->id_categoria) ? 'selected' : '';?> value='<?=$v->id_categoria;?>'><?=$v->nome;?></option>
                            <?endforeach;?>
                          </select>
                        </div>
                      </div>

                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Fornecedor<span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <select name='id_fornecedor' class='form-control'>
                            <?foreach ($Fornecedor as $key => $v):?>
                            	<option <?=($v->id_fornecedor == $Produto->id_fornecedor) ? 'selected' : '';?> value='<?=$v->id_fornecedor;?>'><?=$v->nome;?></option>
                            <?endforeach;?>
                          </select>
                        </div>
                      </div>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Marca <span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="text" name='marca_produto' value='<?=$Produto->marca;?>' placeholder="Ex: Apple"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">IMEI
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="text" name='imei_produto' value='<?=$Produto->imei;?>' placeholder="Ex: 371263781637861"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Cor 
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="text" name='cor_produto' value='<?=$Produto->cor;?>' placeholder="Ex: Azul"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">NCM 
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="text" name='ncm' value='<?=$Produto->ncm;?>'  placeholder="Ex: 8544.42.00 "  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">ExTIPI 
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="text" name='extipi' value='<?=$Produto->extipi;?>'  placeholder="Ex: 01"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Modelo <span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="text" name='modelo_produto' value='<?=$Produto->modelo;?>' placeholder="Ex: S6 PLUS 126 GB"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Código de barras
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="text" name='codigobarras_produto' value='<?=$Produto->codigo_barra;?>' placeholder="Ex: 839127892313"  class="form-control col-md-7 col-xs-12">
                          <br>
                          <a target="_BLANK" href='<?=$codigo_barra;?>'>Imprimir Código de Barra's</a>
                        </div>
                      </div>

				          <div class="form-group" <?=(!in_array($this->session->userdata()[id_perfil],array(2,5,6)) ? 'hidden' : '');?> >
	                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Qtd. Estoque Inicial<span class="required">*</span>
	                        </label>
	                        <div class="col-md-1 col-sm-6 col-xs-12">
	                          <input type="number" name='estoque_atual' value='<?=$Produto->estoque_atual;?>'  class="form-control col-md-7 col-xs-12">
	                          <input type="number" name='estoque_gravado' value='<?=$Produto->estoque_atual;?>' hidden>
                          </div>
	                      </div>
                
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Qtd. Estoque Min Alerta
                        </label>
                        <div class="col-md-1 col-sm-6 col-xs-12">
                          <input type="number" name='estoque_minimo_aviso' value='<?=$Produto->estoque_minimo_aviso;?>'  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Preço de Custo<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                          <div class="input-group">
                            <div class="input-group-addon" style="background-color: #e45f5c;color: white;">R$</div>
                            <input type="text" class="form-control preco" name='preco_compra' value='<?=$Produto->preco_compra;?>' placeholder="Ex: 1.50">
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Preço de Venda<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                          <div class="input-group">
                            <div class="input-group-addon" style="background-color: #51d453;color: white;" >R$</div>
                            <input type="text" class="form-control preco" name='preco_venda' value='<?=$Produto->preco_venda;?>' placeholder="Ex: 1.50">
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Descrição do Produto
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <textarea name='descricao_produto' rows="5" class='form-control'><?=$Produto->descricao;?></textarea>
                        </div>
                      </div>

         
                      


                    <div class="x_title">
                      <div class="clearfix"></div>
                    </div>
                          <div class='alert' id='retorno'>

                          </div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">
                          <button type="submit" class="btn btn-primary">Editar Produto</button>
                          <!-- <button id='limpar' class="btn btn-primary">Limpar</button> -->
               
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>


<script type="text/javascript">
  $(function(){
    $(":input").inputmask({greedy: false,placeholder:""});
  });
</script>