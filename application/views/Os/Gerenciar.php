<script src="<?=base_url();?>public/js/os/cadastrar.js"></script>



<div class="col-md-12 col-sm-12 col-xs-12">



	<div class="x_panel">

		<div class="x_title">
			<h2>Lista de Ordem de Serviço</h2>
			<div class="clearfix"></div>
		</div>

		<div class="x_content">


	
			<table id="tabela" class="ui celled table" cellspacing="0" width="100%">
		        <thead>
		            <tr>
		            	<th>ID OS</th>
		                <th>Nome cliente</th>
		                <th>Aparelho</th>
		                <th>CPF</th>
		                <th>IMEI</th>
		           <!--      <th>Aparelho</th>
		                <th>Marca</th>
		            	<th>Modelo</th>
		            --> 	<th>Data Entrada</th>
		            	<th>Data Prev Orc</th>
		            	<th>Status</th>
		            	<th>Ações</th>
		            </tr>
		        </thead>
		      <tfoot>
	            <tr>
						<th>ID OS</th>
		                <th>Nome cliente</th>
		                <th>Aparelho</th>
		                <th>CPF</th>
		                <th>IMEI</th>
		           <!--      <th>Aparelho</th>
		                <th>Marca</th>
		            	<th>Modelo</th>
		            --> 	<th>Data Entrada</th>
		        		<th>Data Prev Orc</th>
		            	<th>Status</th>
	            
						<th hidden></th>
	            </tr>
	        </tfoot>
		        <tbody>

		       		<?foreach ($ListarOs as $key => $v):?>

		       			<?
		       				if(strtotime($v->data_previsao_orcamento) <= time() AND $v->id_os_orcamento == NULL AND $v->id_os_orcamento == NULL AND $v->status != 7 AND $v->status != 10 AND $v->status != 6) {
		       					// Notificacao('Alerta Orçamento',"Orçamento do número <b>$v->id_os</b> precisa ser enviado imediatamente, previsão venceu.");
		       					$corStyle = " style='background-color: rgb(252, 190, 186);' ";
		       				} else {
		       					$corStyle = "";
		       				}
		       			?>

		       			<tr <?=$corStyle;?> >
		       				<td><?=$v->id_os;?></td>
		       				<td>
		       					<a href="javascript: modalAjax('<?=base_url('usuario/abas/'.$v->id_cliente);?>');">
		       						<?=$v->nome_cliente;?>
		       					</a>
		       					
		       					</td>
				       		<td><a title="<?=$v->defeito_declarado;?>"><?=$v->nome;?></a></td>
			                <td><?=$v->cpf;?></td>
			                <td><?=$v->imei;?></td>
			        <!--         <td><?=$v->nome;?></td>
			                <td><?=$v->marca;?></td>
			                <td><?=$v->modelo;?></td>
		       		 -->	    <td><?=date('d/m - H:i',strtotime($v->data_entrada));?></td>
		       			    <td><?=date('d/m',strtotime($v->data_previsao_orcamento));?></td>
		       			    <td><?=$Status[$v->status];?></td>
		       				<td style="text-align: center;"><i onclick="modalAjax('<?=base_url('os/abas/'.$v->id_os.'/'.$v->id_cliente.'/'.'');?>');" class="fa fa-edit"></i></td>
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
	"oLanguage": {
    "sProcessing": "Aguarde enquanto os dados são carregados ...",
    "sLengthMenu": "Mostrar _MENU_ registros por pagina",
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