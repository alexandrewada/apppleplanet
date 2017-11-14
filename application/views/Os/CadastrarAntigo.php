<script src="<?=base_url();?>public/js/os/ordemdeservico.js"></script>
    

<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Cadastrar Ordem de Serviço</h2>
                  
                    <div class="clearfix"></div>

                  </div>
                  <div class="x_content">
                    <div class='alert alert-warning'>
                    Para cadastrar uma Ordem de Serviço, você precisa criar um usuário como cliente primeiro. <br> <a target="_blank" href='<?=base_url("usuario/cadastrar");?>'> Clicando Aqui</a>.
                    </div>
                    <form  id="ajaxForm" action='<?=base_url('os/cadastrar');?>'' method='POST' class="form-horizontal form-label-left" >




                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Email do cliente<span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="text" list="emaildatalist" name='email_cliente'  placeholder='' class="form-control col-md-7 col-xs-12">
                            <datalist id="emaildatalist">
                              <?foreach ($Clientes as $key => $v):?>
                                <option  value='<?=$v->email;?>'> <?=$v->nome;?></option>
                              <?endforeach;?>
                            </datalist>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nome do Equipamento<span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="text" name='nome' placeholder='Ex: Samsung s6' class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Categoria do Equipamento<span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <select name='id_categoria' class='form-control'>
                            <?foreach ($Categorias as $key => $v):?>
                              <option value='<?=$v->id_categoria;?>'><?=$v->nome;?></option>
                            <?endforeach;?>
                          </select>
                        </div>
                      </div>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Marca & Fabricante<span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="text" name='marca' placeholder='Ex: Samsung' class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Modelo<span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="text" name='modelo' placeholder='Ex: S6' class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Série
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="text" name='serie' placeholder='Ex: 428490209274204' class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">IMEI
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="text" name='imei' placeholder='Ex: 350845555897085' class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Senha do Equipamento
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="text" name='senha_aparelho' placeholder='Ex: 1234senha' class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Data de previsão de Orçamento.<span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="date" name='data_previsao_orcamento'   class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Qual é o defeito relatado ?<span class="required">*</span>
                        </label>
                        <div class="col-md-5 col-sm-6 col-xs-12">
                          <textarea name='defeito_declarado' rows="8" class='form-control'></textarea>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Observações
                        </label>
                        <div class="col-md-5 col-sm-6 col-xs-12">
                          <textarea name='observacao' rows="8" class='form-control' placeholder="Ex: Itens inclusos bateria,carregador."></textarea>
                        </div>
                      </div>

                   
         
                    <div class="x_title">
                      <div class="clearfix"></div>
                    </div>
                          <div class='alert' id='retorno'>

                          </div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">
                          <button type="submit" class="btn btn-primary">Cadastrar Ordem de Serviço</button>
                          <!-- <button id='limpar' class="btn btn-primary">Limpar</button> -->
               
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>


