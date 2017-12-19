
<script type="text/javascript">
	$(function(){

		$("input[type='checkbox']").change(function(){
			$("#filtros").submit();
		});


		var autoRefresh = 320;
			var cicloAuto = setInterval(function(){
				if(autoRefresh < 1){
					clearInterval(cicloAuto);
					window.location.reload();
				}
				autoRefresh--;
				$("#autorefresh").html(autoRefresh);
				console.log(autoRefresh);
			},1000);
		});
</script>

<style type="text/css">
	.quadrado-status {
		padding: 10px;
		border: 3px solid black;
		background-color: white;
		margin-bottom: 20px;
	}

	.filtro-lista {
		list-style: none;
		margin: 0px;
		padding: 0px;
	}

	.filtro-lista li {
		float: left;
		margin-right: 50px;
	}

	.tabela-mcdonalds{
		background-color: white;
		width: 100%;	
		border: 3px solid black;
	}
	
	.tabela-mcdonalds-titulo {
		text-align: center;
	    font-size: 13px;
	    font-weight: 800;
	    color: black;
	    font-family: cursive;
	}

	.tabela-mcdonalds-codos td {
		text-align: right;
		border: 3px solid black;
		padding-right: 5px;
		color: black;
		font-family: Verdana;
		font-weight: 900;
	}

</style>
<div class='container'>
<div class='row-fluid'>

<h1 class='text-center'>
	Monitoramento	de	Ordens	de	Serviço.
</h1>

<h5 class="text-center">
	A página será atualizada automaticamente em <span id='autorefresh'></span> segundos, caso queira atualizar manualmente aperte F5.
</h5>


<form id='filtros' method="GET" action="<?=base_url('os/monitoramento');?>">
	<div class='col-md-12 quadrado-status'>

		<ul class='filtro-lista'>
			
			<li>
				<label>
					<input type="checkbox" <?=($_GET['status'][1]) ? 'checked' : '';?> name='status[1]' >
					Aguardando Análise
				</label>
			</li><li>
				<label>
					<input type="checkbox" <?=($_GET['status'][4]) ? 'checked' : '';?> name='status[4]' >
					Aguardando Aprovação do Orçamento
				</label>
			</li><li>
				<label>
					<input type="checkbox" <?=($_GET['status'][9]) ? 'checked' : '';?> name='status[9]' >
					Orçamento Aprovado
				</label>
			</li><li>
				<label>
					<input type="checkbox" <?=($_GET['status'][6]) ? 'checked' : '';?> name='status[6]' >
					Sem Reparo
				</label>
			</li><li>
				<label>
					<input type="checkbox" <?=($_GET['status'][5]) ? 'checked' : '';?> name='status[5]' >
					Aguardando Retirada
				</label>
			</li>

		</ul>

	</div>
</div>
</form>
<br><br>
<div class='row-fluid'>
	
	<!-- Tabela Analise -->
	
	<div class='col-md-2' <?=($_GET['status'][1]) ? '' : 'hidden';?> >
		<table class='tabela-mcdonalds'>
		  <tbody>
		  	<tr>
		  		<td colspan="3">
		  			<h5 class='tabela-mcdonalds-titulo'>Aguardando Análise</h5>
		  		</td>
		  	</tr>

		  	<?foreach (array_chunk($status_pendente, 3) as $row):?>
			  	<tr class='tabela-mcdonalds-codos'>
			  		<?foreach($row as $value):?>
        				<td>
        					<a href="javascript: modalAjax('<?=base_url("os/abas/".$value->id_os."/".$value->id_cliente."/");?>');">
        						<?=($value->id_os);?>		
        					</a>
        				</td>
  					<?endforeach;?>
			  	</tr>		 
		  	<?endforeach;?>

		  </tbody>
		</table>
	</div>


	<!-- Tabela Aprovacao -->
	<div class='col-md-2' <?=($_GET['status'][4]) ? '' : 'hidden';?>>
		<table class='tabela-mcdonalds'>
		  <tbody>
		  	<tr>
		  		<td colspan="3">
		  			<h5 class='tabela-mcdonalds-titulo'>Aguardando Aprovação do Orçamento</h5>
		  		</td>
		  	</tr>

		  	<tr class='tabela-mcdonalds-codos'>
			  	<?foreach (array_chunk($status_aguardando_aprovacao, 3) as $row):?>
				  	<tr class='tabela-mcdonalds-codos'>
				  		<?foreach($row as $value):?>
	        				<td>
	        				<a href="javascript: modalAjax('<?=base_url("os/abas/".$value->id_os."/".$value->id_cliente."/");?>');">
        						<?=($value->id_os);?>		
        					</a>
	        				</td>
	  					<?endforeach;?>
				  	</tr>		 
			  	<?endforeach;?>
		  	</tr>		 

		  </tbody>
		</table>
	</div>

	<!-- Orcamento aprovado -->
	<div class='col-md-2' <?=($_GET['status'][9]) ? '' : 'hidden';?>>
		<table class='tabela-mcdonalds'>
		  <tbody>
		  	<tr>
		  		<td colspan="3">
		  			<h5 class='tabela-mcdonalds-titulo'>Orçamento Aprovado</h5>
		  		</td>
		  	</tr>

		  	<?foreach (array_chunk($status_aprovado, 3) as $row):?>
			  	<tr class='tabela-mcdonalds-codos'>
			  		<?foreach($row as $value):?>
        				<td>
        					<a href="javascript: modalAjax('<?=base_url("os/abas/".$value->id_os."/".$value->id_cliente."/");?>');">
        						<?=($value->id_os);?>		
        					</a>
        				</td>
  					<?endforeach;?>
			  	</tr>		 
		  	<?endforeach;?> 

		  </tbody>
		</table>
	</div>

	<!-- Sem reparo -->
	<div class='col-md-2' <?=($_GET['status'][6]) ? '' : 'hidden';?>>
		<table class='tabela-mcdonalds'>
		  <tbody>
		  	<tr>
		  		<td colspan="3">
		  			<h5 class='tabela-mcdonalds-titulo'>Sem Reparo</h5>
		  		</td>
		  	</tr>

		  	<tr class='tabela-mcdonalds-codos'>
	  		<?foreach (array_chunk($status_semreparo, 3) as $row):?>
			  	<tr class='tabela-mcdonalds-codos'>
			  		<?foreach($row as $value):?>
        				<td>
        	<a href="javascript: modalAjax('<?=base_url("os/abas/".$value->id_os."/".$value->id_cliente."/");?>');">
        						<?=($value->id_os);?>		
        					</a>
        				</td>
  					<?endforeach;?>
			  	</tr>		 
		  	<?endforeach;?> 
		  	</tr>		 

		  </tbody>
		</table>
	</div>

	<!-- Aguardando Retirada -->
	<div class='col-md-2' <?=($_GET['status'][5]) ? '' : 'hidden';?>>
		<table class='tabela-mcdonalds'>
		  <tbody>
		  	<tr>
		  		<td colspan="3">
		  			<h5 class='tabela-mcdonalds-titulo'>Aguardando Retirada</h5>
		  		</td>
		  	</tr>

		  	<tr class='tabela-mcdonalds-codos'>
	  		<?foreach (array_chunk($status_aguardando_retirada, 3) as $row):?>
			  	<tr class='tabela-mcdonalds-codos'>
			  		<?foreach($row as $value):?>
        				<td>
        			<a href="javascript: modalAjax('<?=base_url("os/abas/".$value->id_os."/".$value->id_cliente."/");?>');">
        						<?=($value->id_os);?>		
        					</a>
        				</td>
  					<?endforeach;?>
			  	</tr>		 
		  	<?endforeach;?> 
		  	</tr>		 

		  </tbody>
		</table>
	</div>
</div>

</div>