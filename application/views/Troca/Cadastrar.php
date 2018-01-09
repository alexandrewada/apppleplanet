
<script src="<?=base_url();?>public/js/troca/troca.js?v=<?=rand(1000,10000);?>"></script>


<script type="text/javascript">
  
</script>


<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Dados do cliente</h2>
                  
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br>
                    <form  id="ajaxForm" action='<?=base_url('troca/cadastrar');?>'' method='POST' class="form-horizontal form-label-left" >
                      
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
                        <span class="required">*</span> 
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
                            <input type="text" class="form-control preco" value="10.00" name='preco_compra' placeholder="Ex: 1.50">
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Aparelho <span class="required">*</span>
                    </label>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                      <select name='id_produto_troca' class='form-control'>
                        <?foreach ($produtos_troca as $key => $v):?>
                          <option value="<?=$v->id_produto;?>" data-json='<?=json_encode($v);?>' ><?=$v->nome;?> (<?=$v->estoque_atual;?>) - <?=$v->cor;?> - R$ <?=$v->preco_troca;?></option>
                        <?endforeach;?>
                                 
                      </select>
                    </div>
                  </div>


                  <div class="x_title">
                    <h2>Pagamento</h2>
                  
                    <div class="clearfix"></div>
                  </div>

      
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Forma de Pagamento<span class="required">*</span>
      </label>
      <div class="col-md-4 col-sm-6 col-xs-12">
        <select name='forma_pagamento' class="form-control col-md-7 col-xs-12">
          <?if($formapagamentos != false):?>
          <option value='' selected>Escolha a forma de pagamento.</option>
          <?foreach ($formapagamentos as $key => $v):?>
          <option value='<?=$v->id_formapagamento;?>'><?=$v->tipo;?></option>
          <?endforeach;?>
          <?endif;?>
        </select>
      </div>
    </div>
    
    <div id='desconto' class="form-group" hidden>
      <label class="control-label col-md-3 col-sm-3 col-xs-12">Desconto
        <span class="required">*</span>
      </label>
      <div class="col-md-4 col-sm-6 col-xs-12">
        <select name='desconto' class='form-control'>
          <option value='0'>Sem desconto</option>
          

                    <?if(in_array($this->session->userdata()[id_perfil],array(2)) == true):?>
            <?for($i=1; $i <= 50; $i++):?>
              <option value='<?=$i;?>'><?=$i;?>%</option>
            <?endfor;?>
          <?else:?>
            <?for($i=1; $i <= 5; $i++):?>
              <option value='<?=$i;?>'><?=$i;?>%</option>
            <?endfor;?>
          <?endif;?>
            




        </select>
      </div>
    </div>
    

    <div id='parcelamento' class="form-group" >
      <label class="control-label col-md-3 col-sm-3 col-xs-12">Parcelamento
        <span class="required">*</span>
      </label>
      <div class="col-md-4 col-sm-6 col-xs-12">
        <select name='numero_parcelas' class='form-control'>
          <option value='1'>À vista</option>
          <?for($i=2; $i < 13; $i++):?>
            <option value='<?=$i;?>'><?=$i;?>x no cartão de crédito</option>
          <?endfor;?>
        </select>
        <input type="checkbox" name='jurosparcelamento'> <label>Aplicar Juros por parcela para o cliente ?</label>
      </div>
    </div>
    

    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">Imprimir a garantia? <input type="checkbox" name='garantia'>
        <span class="required">*</span>
      </label>

            <div class="col-md-3 col-sm-6 col-xs-12">
        <input type='text' name='nome_cliente_garantia' class='form-control' placeholder="Nome do Cliente" style="display: none;">
      </div>

      <div class="col-md-3 col-sm-1 col-xs-1">
        <input type='text' name='email_cliente_garantia' class='form-control' placeholder="Email" style="display: none;">
      </div>

      <div class="col-md-3 col-sm-6 col-xs-12">
        <input type='text' name='cpf_cliente_garantia' class='form-control' data-inputmask="'mask': '999.999.999.99'" maxlength="14" placeholder="CPF do Cliente" style="display: none;">
      </div>


      <div class="col-md-1 col-sm-1 col-xs-1">
        <input type='number' name='meses_cliente_garantia' class='form-control' placeholder="Meses de Garantia" style="display: none;">
      </div>
    </div>
        


    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">Emitir nota? <input type="checkbox" name='notafiscal'>
        <span class="required">*</span>
      </label>

      <div class="col-md-4 col-sm-6 col-xs-12">
        <input type='text' name='cpf_cliente' class='form-control' data-inputmask="'mask': '999.999.999.99'" maxlength="14" placeholder="CPF do Cliente" style="display: none;">
      
      </div>
      
      <div class="col-md-4 col-sm-6 col-xs-12">
        <input type='text' name='cnpj_cliente' class='form-control' data-inputmask="'mask': '99.999.999/9999-99'" maxlength="18" placeholder=" OU CNPJ do Cliente" style="display: none;">
      </div>
    </div>
    
    
    <h3 class='text-right'>Total diferencia á pagar <br><br><span id='total_produto'>0.00</span></h3>
  

                      
                    <div class="x_title">
                      <div class="clearfix"></div>
                    </div>
                          <div class='alert' id='retorno'>

                          </div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">

                          <input type="hidden" name="perfil" value="1">
                          <input type="hidden" name="id_loja" value="1">
                          

                          <button type="submit" class="btn btn-primary">Efetuar Troca</button>
                          <!-- <button id='limpar' class="btn btn-primary">Limpar</button> -->
               
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>


