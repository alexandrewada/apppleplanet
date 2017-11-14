<script src="<?=base_url();?>public/js/peca/saida.js?v=<?=rand(1000,10000);?>"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url('public/css/peca/saida.css');?>">
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="x_title">
			<h2>Saída de Peças</h2>
			
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<img class='center-block img-responsive' src='<?=base_url('public/images/peca/codigo_barras.png');?>'/>
			<hr></hr>
			
			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Digite o código de barras<span class="required">*</span>
			</label>
			<div class="col-md-4 col-sm-6 col-xs-12">
				<input type="text" name='codigo_barras' placeholder='Ex: 142318739312' class="form-control col-md-7 col-xs-12">
			</div>
		</div>
		<button class="center-block btn btn-primary" id='adicionar_pecas'>Adicionar Peça</button>
		
		
	</div>
	
</div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
	<div class="x_title">
		<h2>Resumo de Peças</h2>
		
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<div class='table-responsive'>
			<table id='resumo_peca' class='table table-striped'>
				<thead>
					<tr>
						<td>ID Peça</td>
						<td>Peça</td>
						<td>Modelo</td>
						<td>Marca</td>
						<td>Quantidade</td>
						<td>Preço Unitário</td>
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
					<td></td>
					<td></td>
				</tr>
				</tfoot>
				<tbody>
					
				</tbody>
			</table>
		</div>
	</div>
	
	<div class="clearfix"></div>
	
</div>
</div>
<div id='faturamento' class="col-md-12 col-sm-12 col-xs-12" hidden>
<div class="x_panel">
	<div class="x_title">
		<h2>Informações para o faturamento</h2>
		
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<br>
		<form  id="ajaxForm" action='<?=base_url('peca/saida');?>'' method='POST' class="form-horizontal form-label-left" >
			
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
					<?for($i=1; $i <=  10; $i++):?>
						<option value='<?=$i;?>'><?=$i;?>%</option>
					<?endfor;?>
				</select>
			</div>
		</div>
		

		<div id='parcelamento' class="form-group" hidden>
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
			<label class="control-label col-md-3 col-sm-3 col-xs-12">Emitir nota? <input type="checkbox" name='notafiscal'>
				<span class="required">*</span>
			</label>
			<div class="col-md-4 col-sm-6 col-xs-12">
				<input type='text' name='cpf_cliente' class='form-control' data-inputmask="'mask': '999.999.999.99'" maxlength="14" placeholder="CPF do Cliente" style="display: none;">
			</div>
		</div>
		
		
		<div class="x_title">
			<div class="clearfix"></div>
		</div>
		<div class='alert' id='retorno'>
		</div>
			<h3 class='text-right'>Total <span id='total_peca'>0.00</span></h3>
		<div class="form-group">
			<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">
				<input type="hidden" value='false' name="peca">
				<input type='hidden' value='0' name="valorjurosparcelamento">
				<button type="submit" id='efetuarSaida' class="btn btn-primary">Efetuar Saída de Peças</button>
				<!-- <button id='limpar' class="btn btn-primary">Limpar</button> -->
				
			</div>
		</div>
	</form>
</div>
</div>
</div>