
<script type="text/javascript">
	
	$(function(){
		$("input[name='id_venda']").blur(function(){
			$.post(base_url+"produto/getvenda",{id_saida:$(this).val()},function(e){

				$("#status_retorno").html("Aguarde estmaos processando.");

				if(e.result == true) {
					$("#status_retorno").html("Resultado encontrado.");

					var dados = e.data;

					$("#detalhes_retorno").show("slow");
					$("input[name='produto']").val(dados.Produto);
					$("input[name='vendedor']").val(dados.Vendedor);
					$("input[name='preco']").val(dados.valor_total);	
					$("input[name='validade_garantia']").val(dados.validade_garantia);
					$("input[name='data_venda']").val(dados.data_venda);
				} else {
					$("#status_retorno").html("Nada foi encontrado.");

					$("#detalhes_retorno").hide();
				}
			});
		});
	});

</script>



<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="x_title">
			<h2>Retorno de Produto</h2>
			
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			

		<form action="<?=base_url('produto/retorno');?>" method="POST" enctype="multipart/form-data" class="form-horizontal form-label-left">


		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">Digite o número venda.<span class="required">*</span>
			</label>
			<div class="col-md-4 col-sm-6 col-xs-12">
				<input type="text" name='id_venda' placeholder='Ex: 32242' class="form-control col-md-7 col-xs-12">
				<span id='status_retorno'></span>
			</div>
		</div>

		<div hidden id='detalhes_retorno'>


			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Atendente que efetuou a saída<span class="required">*</span>
				</label>
				<div class="col-md-4 col-sm-6 col-xs-12">
					<input type="text" disabled name='vendedor' class="form-control col-md-7 col-xs-12">
				</div>
			</div>


			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Produto<span class="required">*</span>
				</label>
				<div class="col-md-4 col-sm-6 col-xs-12">
					<input type="text" disabled name='produto' class="form-control col-md-7 col-xs-12">
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Preço<span class="required">*</span>
				</label>
				<div class="col-md-4 col-sm-6 col-xs-12">
					<input type="text" disabled name='preco' class="form-control col-md-7 col-xs-12">
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Data da Venda<span class="required">*</span>
				</label>
				<div class="col-md-4 col-sm-6 col-xs-12">
					<input type="text" disabled name='data_venda' class="form-control col-md-7 col-xs-12">
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Garantia até<span class="required">*</span>
				</label>
				<div class="col-md-4 col-sm-6 col-xs-12">
					<input type="text" disabled name='validade_garantia' class="form-control col-md-7 col-xs-12">
				</div>
			</div>



		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">Anexe um comprovante para o retorno.<span class="required">*</span>
			</label>
			<div class="col-md-4 col-sm-6 col-xs-12">
				<input type="file" name='comprovante_garantia'>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">Motivo do Retorno<span class="required">*</span>
			</label>
			<div class="col-md-4 col-sm-6 col-xs-12">
				<textarea name='motivo_retorno' class="form-control"></textarea>
			<div>
		</div>


		</form>
		<br>
		<button class="center-block btn btn-primary" id='retornar'>Retornar Produto</button>
		
		</div>
		
	</div>
	
</div>
<?if(!empty($retorno)):?>
	<div class="alert alert-success" id="retorno">
		<?=$retorno;?>
	</div>
<?endif;?>

<?if(!empty($erro)):?>
	<div class="alert alert-danger" id="retorno">
		<?=$erro;?>
	</div>
<?endif;?>
