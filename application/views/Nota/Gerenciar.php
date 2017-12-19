<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="x_title">
			<h2>Lista Notas Emitidas</h2>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			
			<table id="tabela" class="ui celled table" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>ID</th>
						<th>PDF</th>
						<th>Vendedor</th>
						<th>Comprador</th>
						<th>Valor</th>
						<th>Data</th>
					</tr>
				</thead>
				<tfoot>
				<tr>
					<th>ID</th>
					<th>PDF</th>
					<td>Atendente</td>
					<td>Comprador</td>
					<td>Valor</td>
					<th>Data</th>
				</tr>
				</tfoot>
				<tbody>
					<?foreach ($lista as $key => $v):?>
					<tr>
						<td><?=$v->id_nfe;?></td>
						<td><a target="_BLANK" href='<?=$v->url_pdf;?>'>PDF</a></td>
						<td><?=$v->nome;?></td>
						<td><?=$v->nome_comprador;?></td>
						<td><?=$v->valor_total;?></td>
						<td><?=$v->data;?></td>
					</td>
						
					</tr>
					<?endforeach;?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<link rel="stylesheet" type="text/css" href="<?=base_url('public/css/datatable/semantic-table.css');?>">
<link rel="stylesheet" type="text/css" href="<?=base_url('public/css/datatable/semantic-min.css');?>">
<script type="text/javascript" src="<?=base_url('public/vendors/datatables.net/js/jquery.dataTables.min.js');?>"></script>
<script type="text/javascript" src="<?=base_url('public/js/datatable/dataTables.semanticui.min.js');?>"></script>
<script type="text/javascript" src="<?=base_url('public/js/datatable/semantic.min.js');?>" ></script>
<script type="text/javascript">
	$(document).ready(function() {
	$('#tabela tfoot th').each( function () {
var title = $(this).text();
$(this).html( '<input type="text" placeholder="Procurar '+title+'" style="border: 0px;border-radius: 4px;width: 93%;border: 1px solid #ccc;padding: 5px;"/>' );
});
	var table = $('#tabela ').DataTable({
		dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
	"oLanguage": {
"sProcessing": "Aguarde enquanto os dados são carregados ...",
"sLengthMenu": "Mostrar _MENU_ registros por página",
"sZeroRecords": "Nenhum registro correspondente ao criterio encontrado",
"sInfoEmtpy": "Exibindo 0 a 0 de 0 registros",
"sInfo": "Exibindo de _START_ a _END_ de _TOTAL_ registros",
"sInfoFiltered": "",
"sSearch": "Procurar",
"oPaginate": {
"sFirst":    "Primeiro",
"sPrevious": "Anterior",
"sNext":     "Próximo",
"sLast":     "Último"
}
}
	});
	table.columns().every(function() {
var that = this;
$('input', this.footer() ).on( 'keyup change', function () {
if(that.search() !== this.value) {
that.search(this.value).draw();
}
});
});
});
</script>