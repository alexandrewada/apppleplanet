<table class='table table-bordered'>
	<tbody>
		<tr>
			<td>N° OS</td>
			<td>APARELHO</td>
			<td>DATA</td>
			<td>STATUS</td>
			<td></td>
		</tr>

		<?if($os_vinculadas != false):?>
			<?foreach ($os_vinculadas as $key => $v):?>
				<tr class="text-center">
					<td><?=$v->id_os;?></td>
					<td><?=$v->nome;?></td>
					<td><?=date('d/m H:i:s',strtotime($v->data_entrada));?></td>
					<td><?=$v->status;?></td>
					<td>
						<button onclick="modalAjax('http://sistema.appleplanet.com.br/os/abas/<?=$v->id_os;?>/<?=$id_cliente;?>');" class='btn btn-primary'>
							Abrir OS
						</button>
					</td>
				</tr>			
			<?endforeach;?>
		<?else:?>
			<h3 class="text-center">Não existe nenhuma ordem de serviço cadastrada.</h3>
		<?endif;?>

	</tbody>
</table>