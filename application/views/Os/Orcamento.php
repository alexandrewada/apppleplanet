<script src="<?=base_url();?>public/js/os/orcamento.js?v=<?=rand(1000,10000);?>"></script>
<script type="text/javascript" src="<?=base_url('public/js/template/ajaxPost.js');?>"></script>
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">



	


		<div class="x_title">
			<h2>Enviar um Orçamento</h2>
			
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<!--     <div class='alert alert-warning'>
				Para cadastrar uma Ordem de Serviço, você precisa criar um usuário como cliente primeiro. <br> <a target="_blank" href='<?=base_url("usuario/cadastrar");?>'> Clicando Aqui</a>.
			</div> -->
			
			<div class='alert alert-warning'>
				<b>ALERTA! </b><br>È muito importante adicionar as peças que vão ser usadas para o conserto, para o sistema automatizar a retirada da peças do estoque após o serviço ser concluído, os detalhes das peças não será mostrada para o cliente.
			</div>

			<h2>Peças a serem usadas para o conserto.</h2>
			
			<hr></hr>

			<form  id="ajaxForm" action='<?=base_url('os/orcamento/'.$id_os.'');?>' method='POST' class="form-horizontal form-label-left" >
				<input type="hidden" name="id_os" value="<?=$id_os;?>">



			<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Código de barra da peça.<span class="required">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<div class="input-group">
						<input type="text" class="form-control" name="codigo_barras" placeholder="Ex: 321398219308219301298">
					</div>
				</div>
			</div>

			<div class='text-right'>
			<div class="btn btn-primary" id='adicionar_pecas' >Adicionar Peça</div>
			</div>
			<div class='table-responsive'>
			<table id='resumo_peca' class='table table-striped'>
				<thead>
					<tr>
						<td>ID Peça</td>
						<td>Peça</td>
						<td>Modelo</td>
						<td>Marca</td>
						<td>Quantidade</td>
						<td>Preço Venda</td>
						<td>Ações</td>
					</tr>
				</thead>
				<tfoot>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td><h3>Total <span id='total_peca'>0.00</span></h3></td>
					<td></td>
				</tr>
				</tfoot>
				<tbody>
					
				</tbody>
			</table>
		</div>





			<h2>Dados para o Orçamento.</h2>
			
			<hr></hr>


				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Valor da Mão de obra<span class="required">*</span>
				</label>
				<div class="col-md-2 col-sm-6 col-xs-12">
					<div class="input-group">
						<div class="input-group-addon" style="background-color: #51d453;color: white;" >R$</div>
						<input type="text" class="form-control preco" name='valor_mao_obra' placeholder="Ex: 1.50">
						<input type='hidden' name='valor_pecas' value='0'/>
						<input type='hidden' name='valor_total' value='0'/>
						<input type="hidden" name='pecas_usados' value=''>
					</div>
				</div>
			</div>

	                <div class="form-group">
	            <label class="control-label col-md-3 col-sm-3 col-xs-12">Qual foi o defeito encontrado ?
	            </label>
	            <div class="col-md-5 col-sm-6 col-xs-12">
	              <textarea name='defeito_encontrado' rows="8" class='form-control'><?=$Os->defeito_encontrado;?></textarea>
	            </div>
	          </div>

           <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Qual será a solução para o defeito encontrado ?
            </label>
            <div class="col-md-5 col-sm-6 col-xs-12">
              <textarea name='defeito_solucao' rows="8" class='form-control'><?=$Os->defeito_solucao;?></textarea>
            </div>
          </div>

			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Detalhes do Orçamento
				</label>
				<div class="col-md-5 col-sm-6 col-xs-12">
					<textarea name='datalhes_orcamento' rows="8" class='form-control'></textarea>
				</div>
			</div>
			
			
			<div class="x_title">
				<div class="clearfix"></div>
			</div>
			<div class='alert' id='retorno'>
			</div>


			<h3 class="text-center">Valor Total do Orçamento é R$ <span id='valor_total_orcamento'>0.00</span></h3>


			<div class="form-group">
				<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">
					<button type="submit" class="btn btn-primary" onmouseover="getValorTotalOrcamento();">Enviar Orçamento</button>
					<!-- <button id='limpar' class="btn btn-primary">Limpar</button> -->
				</div>
			</div>
		</form>
	</div>
</div>
</div>