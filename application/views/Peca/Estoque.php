<h3 class='text-center'>Visualização rápida de estoque de Peças</h3>
<hr>
<table class='table text-center table-striped'>
	<thead>
		<tr>
			<td>Peça</td>
			<td>Estoque Mínimo</td>
			<td>Estoque Atual</td>
		</tr>
	</thead>
	<tbody>

		<?foreach ($Listar as $key => $v):?>
		      			
		<tr>
			<td>
				<a href='javascript: modalAjax("<?=base_url('peca/editar/'.$v->id_peca);?>");'>
					<?=$v->nome;?>		
				</a>
			</td>
			<td><?=$v->estoque_minimo_aviso;?></td>
			<td><?=$v->estoque_atual;?></td>
		</tr>

		<?endforeach;?>

	</tbody>
</table>