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

<h3 class='text-center'>
	Acompanhamento de Ordens de Serviço.
</h3>



<div class='row-fluid'>
	<div class='col-md-12 quadrado-status'>

		<ul class='filtro-lista'>
			
			<li>
				<label>
					<input type="checkbox" >
					Aguardando Análise.
				</label>
			</li><li>
				<label>
					<input type="checkbox" >
					Aguardando Aprovação do Orçamento.
				</label>
			</li><li>
				<label>
					<input type="checkbox" >
					Orçamento Aprovado.
				</label>
			</li><li>
				<label>
					<input type="checkbox" >
					Sem Reparo.
				</label>
			</li><li>
				<label>
					<input type="checkbox" >
					Aguardando Retirada.
				</label>
			</li>

		</ul>

	</div>
</div>

<div class='row-fluid'>
	
	<!-- Tabela Analise -->
	<div class='col-md-2 col-md-offset-1'>
		<table class='tabela-mcdonalds'>
		  <tbody>
		  	<tr>
		  		<td colspan="2">
		  			<h5 class='tabela-mcdonalds-titulo'>Aguardando Análise</h5>
		  		</td>
		  	</tr>

		  	<tr class='tabela-mcdonalds-codos'>
		  		<td>31231</td>
		  		<td>3213</td>
		  	</tr>		 

		  </tbody>
		</table>
	</div>

	<!-- Tabela Aprovacao -->
	<div class='col-md-2'>
		<table class='tabela-mcdonalds'>
		  <tbody>
		  	<tr>
		  		<td colspan="2">
		  			<h5 class='tabela-mcdonalds-titulo'>Apr do Orçamento.</h5>
		  		</td>
		  	</tr>

		  	<tr class='tabela-mcdonalds-codos'>
		  		<td>31231</td>
		  		<td>3213</td>
		  	</tr>		 

		  </tbody>
		</table>
	</div>

	<!-- Orcamento aprovado -->
	<div class='col-md-2'>
		<table class='tabela-mcdonalds'>
		  <tbody>
		  	<tr>
		  		<td colspan="2">
		  			<h5 class='tabela-mcdonalds-titulo'>Orçamento Aprovado.</h5>
		  		</td>
		  	</tr>

		  	<tr class='tabela-mcdonalds-codos'>
		  		<td>31231</td>
		  		<td>3213</td>
		  	</tr>		 

		  </tbody>
		</table>
	</div>

	<!-- Sem reparo -->
	<div class='col-md-2'>
		<table class='tabela-mcdonalds'>
		  <tbody>
		  	<tr>
		  		<td colspan="2">
		  			<h5 class='tabela-mcdonalds-titulo'>Sem Reparo.</h5>
		  		</td>
		  	</tr>

		  	<tr class='tabela-mcdonalds-codos'>
		  		<td>31231</td>
		  		<td>3213</td>
		  	</tr>		 

		  </tbody>
		</table>
	</div>

	<!-- Aguardando Retirada -->
	<div class='col-md-2'>
		<table class='tabela-mcdonalds'>
		  <tbody>
		  	<tr>
		  		<td colspan="2">
		  			<h5 class='tabela-mcdonalds-titulo'>Aguardando retirada.</h5>
		  		</td>
		  	</tr>

		  	<tr class='tabela-mcdonalds-codos'>
		  		<td>31231</td>
		  		<td>3213</td>
		  	</tr>		 

		  </tbody>
		</table>
	</div>
</div>

