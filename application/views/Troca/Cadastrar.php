<script src="<?=base_url();?>public/js/usuario/cadastrar.js"></script>
    
<script type="text/javascript">
  $(function(){

    $("select[name='tipo_usuario']").change(function(){
        var tipo = $(this).val();

        if(tipo == 'pj') {
          $(".hiddenCNPJ,.hiddenIE").show();
          $(".hiddenCPF").hide();
         
          $("input[name='cnpj']").prop('disabled',false);
          $("input[name='ie']").prop('disabled',false);
          $("input[name='cpf']").prop('disabled',true);
         

        } else if(tipo == 'pf') {
          $(".hiddenCNPJ,.hiddenIE").hide();
          $(".hiddenCPF").show();
          $("input[name='ie']").prop('disabled',true);
          $("input[name='cnpj']").prop('disabled',true);
          $("input[name='cpf']").prop('disabled',false);
         
        }

    });
  });
</script>


<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Dados do cliente</h2>
                  
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br>
                    <form  id="ajaxForm" action='<?=base_url('usuario/cadastrar');?>'' method='POST' class="form-horizontal form-label-left" >
                      
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tipo<span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <select  name='tipo_usuario'  class="form-control col-md-7 col-xs-12">
                            <option value=''> Selecione um tipo de pessoa.</option>
                            <option value='pj'>Pessoa Jurídica</option>
                            <option value='pf'>Pessoa Física</option>
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nome completo<span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="text" name='nome'  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Email<span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="text" name='email'  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Senha<span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="password" name='senha'  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Telefone<span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="text" name='telefone'  data-inputmask="'mask': '(99) 9999-9999'"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Celular
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="text" name='celular'  data-inputmask="'mask': '(99) 9 9999-9999'" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Sexo<span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <select  name='sexo'  class="form-control col-md-7 col-xs-12">
                            <option value='Masculino'>Masculino</option>
                            <option value='Feminino'>Feminino</option>
                          </select>
                        </div>
                      </div>

         
      <!--                 <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Data de nascimento<span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="date" name='data_nascimento'  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div> -->


   



                      <div class="form-group hiddenCPF" hidden>
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">CPF<span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="text" name='cpf'  data-inputmask="'mask': '999.999.999.99'" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group hiddenCPF" hidden>
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">RG<span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="text" name='rg'  data-inputmask="'mask': '99.999.999-*'" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group hiddenCNPJ" hidden>
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">CNPJ<span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="text" name='cnpj'  data-inputmask="'mask': '99.999.999/9999-99'" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group hiddenIE" hidden>
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">IE<span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="text" name='ie'  data-inputmask="'mask': '999.999.999.999'" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>


                    <div class="x_title">
                      <h2>Endereço</h2>                
                      <div class="clearfix"></div>
                    </div>
                      
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">CEP
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="text" name='cep' data-inputmask="'mask': '99999-999'" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div hidden id='aposCEP'>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Cidade
                          </label>
                          <div class="col-md-2 col-sm-6 col-xs-12">
                            <input  type="text" name='cidade'  class="form-control col-md-7 col-xs-12">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">UF
                          </label>
                          <div class="col-md-1 col-sm-6 col-xs-12">
                            <input  type="text" name='uf'  class="form-control col-md-7 col-xs-12">
                          </div>
                        </div>

                         <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Rua
                          </label>
                          <div class="col-md-3 col-sm-6 col-xs-12">
                            <input   type="text" name='rua'  class="form-control col-md-7 col-xs-12">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">N°
                          </label>
                          <div class="col-md-1 col-sm-6 col-xs-12">
                            <input  type="text" name='rua_numero'  class="form-control col-md-7 col-xs-12">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Complemento
                          </label>
                          <div class="col-md-3 col-sm-6 col-xs-12">
                            <input  type="text" name='complemento'  class="form-control col-md-7 col-xs-12">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Bairro
                          </label>
                          <div class="col-md-3 col-sm-6 col-xs-12">
                            <input  type="text" name='bairro'  class="form-control col-md-7 col-xs-12">
                          </div>
                        </div>

                      </div>

                    <div class="x_title">
                      <h2>Dados do aparelho do cliente</h2>                
                      <div class="clearfix"></div>
                    </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nome do Produto<span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="text" name='nome_produto' placeholder='Ex: Iphone 6s' class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Anexar fotos<span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="file" name='fotos[]' multiple  class="form-control col-md-7 col-xs-12">
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Preço Negociado<span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <div class="input-group">
                            <div class="input-group-addon" style="background-color: #e45f5c;color: white;">R$</div>
                            <input type="text" class="form-control preco" name='preco_compra' placeholder="Ex: 1.50">
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
                    <h2>Selecione o aparelho á ser trocado.</h2>
                  
                    <div class="clearfix"></div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Aparelho
                    </label>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                      <select class='form-control'>
                        <?foreach ($produtos_troca as $key => $v):?>
                          <option data-json="<?=json_encode($v);?>" ><?=$v->nome;?> - <?=$v->cor;?> - <?=$v->preco_venda;?></option>
                        <?endforeach;?>
                                 
                      </select>
                    </div>
                  </div>


              


                      
                    <div class="x_title">
                      <div class="clearfix"></div>
                    </div>
                          <div class='alert' id='retorno'>

                          </div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">
                          <button type="submit" class="btn btn-primary">Cadastrar Usuário</button>
                          <!-- <button id='limpar' class="btn btn-primary">Limpar</button> -->
               
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>


