<script src="<?=base_url();?>public/js/os/saida.js?v=<?=rand(1000,10000);?>"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url('public/css/os/saida.css');?>">
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="x_title">
			<h2>Saída de Ordem de Serviço</h2>
			
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			
			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Digite número da O.S<span class="required">*</span>
			</label>
			<div class="col-md-4 col-sm-6 col-xs-12">
				<input type="text" name='id_os' placeholder='Ex: 321312' class="form-control col-md-7 col-xs-12">
			</div>
		</div>
		<button class="center-block btn btn-primary" id='adicionar_oss'>Adicionar O.S</button>
		
		
	</div>
	
</div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
	<div class="x_title">
		<h2>Resumo de Orçamento</h2>
		
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<div class='table-responsive'>
			<table id='resumo_os' class='table table-striped'>
				<thead>
					<tr>
						<td>ID OS</td>
						<td>Serviço</td>
						<td>Preço Orçamento</td>
						<td>Ações</td>
					</tr>
				</thead>
				<tfoot>
				<tr>
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
		<h2>Informações para o faturamento da Ordem de Serviço</h2>
		
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<br>
		<form  id="ajaxForm" action='<?=base_url('os/saida');?>'' method='POST' class="form-horizontal form-label-left" >
			
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
						<?for($i=1; $i <= 15; $i++):?>
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
			<label class="control-label col-md-3 col-sm-3 col-xs-12">Imprimir a garantia? <input type="checkbox" name='garantia'>
				<span class="required">*</span>
			</label>

		</div>
				

		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">Emitir nota peças usadas? <input type="checkbox" name='notafiscal'>
				<span class="required">*</span>
			</label>
			<div class="col-md-4 col-sm-6 col-xs-12">
				<input type='text' name='cpf_cliente' class='form-control' data-inputmask="'mask': '999.999.999.99'" maxlength="14" placeholder="CPF do Cliente" style="display: none;">
			</div>

			<div class="col-md-4 col-sm-6 col-xs-12">
				<input type='text' name='cnpj_cliente' class='form-control' data-inputmask="'mask': '99.999.999/9999-99'" maxlength="18" placeholder=" OU CNPJ do Cliente" style="display: none;">
			</div>

		</div>
		
		
		<div class="x_title">
			<div class="clearfix"></div>
		</div>
		<div class='alert' id='retorno'>
		</div>
			<h3 class='text-right'>Total <span id='total_os'>0.00</span></h3>
		<div class="form-group">
			<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">
				<input type="hidden" value='false' name="os">
				<input type='hidden' value='0' name="valorjurosparcelamento">
				<button type="submit" id='efetuarSaida' class="btn btn-primary">Faturar Orçamento</button>
				<!-- <button id='limpar' class="btn btn-primary">Limpar</button> -->
				
			</div>
		</div>
	</form>
</div>
</div>
</div>

<div id='devolucao' class="col-md-12 col-sm-12 col-xs-12" hidden>
<div class="x_panel">
	<div class="x_title">
		<h2>Informações para o devolução</h2>
		
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<br>
		<form  id="ajaxForm" action='<?=base_url('os/DevolucaoPost');?>'' method='POST' class="form-horizontal form-label-left" >
			
	
		
		<div class="x_title">
			<div class="clearfix"></div>
		</div>
		<div class='alert' id='retorno'>
		</div>
		<div class="form-group">
			<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">
				<input type="hidden" value='false' name="os">
				<button type="submit" id='efetuarDevolucao' class="btn btn-primary">Efetuar Devolução</button>
				<!-- <button id='limpar' class="btn btn-primary">Limpar</button> -->
				
			</div>
		</div>
	</form>
</div>
</div>
</div>