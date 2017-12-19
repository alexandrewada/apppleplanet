<script src="<?=base_url();?>public/js/produto/cadastrar.js"></script>
    

<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Cadastrar Produto</h2>
                  
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br>
                    <form  id="ajaxForm" action='<?=base_url('produto/cadastrar');?>'' method='POST' class="form-horizontal form-label-left" >
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nome do Produto<span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="text" name='nome_produto' placeholder='Ex: Iphone 6s' class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Categoria<span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <select name='id_categoria' class='form-control'>
                            <?foreach ($Categorias as $key => $v):?>
                            	<option value='<?=$v->id_categoria;?>'><?=$v->nome;?></option>
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
                            	<option value='<?=$v->id_fornecedor;?>'><?=$v->nome;?></option>
                            <?endforeach;?>
                          </select>
                        </div>
                      </div>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Marca 
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="text" name='marca_produto' placeholder="Ex: Apple"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Estado 
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="text" name='estado' placeholder="Ex: Novo, Semi-novo, Usado"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">IMEI
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="text" name='imei_produto' placeholder="Ex: 371263781637861"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Cor 
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="text" name='cor_produto' placeholder="Ex: Azul"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">NCM 
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="text" name='ncm' placeholder="Ex: 8544.42.00 "  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">ExTIPI 
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="text" name='extipi' placeholder="Ex: 01"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Modelo <span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="text" name='modelo_produto' placeholder="Ex: S6 PLUS 126 GB"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
<!-- 
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Código de barras
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="text" name='codigobarras_produto' placeholder="Ex: 839127892313"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
 -->
                    
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Qtd. Estoque Inicial<span class="required">*</span>
                        </label>
                        <div class="col-md-1 col-sm-6 col-xs-12">
                          <input type="number" value='1' name='estoque_atual'  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Qtd. Estoque Min Alerta
                        </label>
                        <div class="col-md-1 col-sm-6 col-xs-12">
                          <input type="number" value='1' name='estoque_minimo_aviso'  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Desconto Máximo<span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <div class="input-group">
                            <div class="input-group-addon" style="background-color: green; color: white;">%</div>
                            <select name='desconto_maximo' class='form-control'>
                              <?for($i=5; $i <= 15; $i++):?>
                                <option value='<?=$i;?>'><?=$i;?>%</option>
                              <?endfor;?>
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Preço de Custo<span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <div class="input-group">
                            <div class="input-group-addon" style="background-color: #e45f5c;color: white;">R$</div>
                            <input type="text" class="form-control preco" name='preco_compra' placeholder="Ex: 1.50">
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Preço de Venda<span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <div class="input-group">
                            <div class="input-group-addon" style="background-color: #51d453;color: white;" >R$</div>
                            <input type="text" class="form-control preco" name='preco_venda' placeholder="Ex: 1.50">
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Descrição do Produto
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <textarea name='descricao_produto' rows="5" class='form-control'></textarea>
                        </div>
                      </div>

         
                      


                    <div class="x_title">
                      <div class="clearfix"></div>
                    </div>
                          <div class='alert' id='retorno'>

                          </div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">
                          <button type="submit" class="btn btn-primary">Cadastrar Produto</button>
                          <!-- <button id='limpar' class="btn btn-primary">Limpar</button> -->
               
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>


