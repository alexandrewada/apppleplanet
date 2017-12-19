

<div class="col-md-12 col-sm-12 col-xs-12">



	<div class="x_panel">

		<div class="x_title">
			<h2>Relatório de Vendas</h2>
			<div class="clearfix"></div>
		</div>

		<div class="x_content">


		<div class='form-group col-md-3'>
			<labe>Filtrar por datas.</labe>
			<input id="date_range" placeholder="Filtrar por data" value='<?=date('Y-m-d').' to '.date('Y-m-d');?>'' class='form-control' type="text">
		</div>

			<br><br><br>
			<table id="tabela" class="ui celled table" cellspacing="0" width="100%">
		        <thead>
		            <tr>
		            	<th>ID Venda</th>
		            	<th>Produto</th>
		                <th>Qtd</th>
		                <th>Custo</th>
		                <th>Venda</th>
		                <th>Desconto</th>
		            	<th>Lucro</th>
		            	<th>Loja</th>
		            	<th>Vendedor</th>
		            	<th>Status</th>
		            	<th>Data Venda</th>
		            </tr>
		        </thead>
		      <tfoot>
	            <tr>
	            		<th>ID Venda</th>
		            	<th>Produto</th>
		                <th>Qtd</th>
		                <th>Custo</th>
		                <th>Venda</th>
		                <th>Desconto</th>
		            	<th>Lucro</th>
		            	<th>Loja</th>
		            	<th>Vendedor</th>
		            	<th>Status</th>
		            	<th>Data</th>
	            </tr>
	        </tfoot>
		        <tbody>
		       		<?foreach ($VendasProdutos as $key => $v):?>

		       		<? switch ($v->status_venda) {
		       			case '1':
		       				$status_venda = 'VENDA';
		       			break;

		       			case '2':
		       				$status_venda = 'RETORNO';
		       			break;
	
		       			default:
							$status_venda = 'ERRO';
	       				break;
		       		}
		       		?>

		       			<tr>
		       				<td><?=$v->id_saida_produto;?></td>
		       				<td><?=$v->Produto;?></td>
		       				<td><?=$v->Quantidade;?></td>
		       				<td><?=number_format($v->Quantidade*$v->Custo,2);?></td>
		       				<td><?=number_format($v->Quantidade*$v->Venda,2);?></td>
		       				<td><?=number_format($v->Desconto,2);?></td>
		       				<td><?=$v->Liquido;?></td>
		       				<td><?=$v->loja;?></td>
		       				<td><?=$v->Vendedor;?></td>
		       				<td><?=$status_venda;?></td>
		       				<td><?=date('Y-m-d',strtotime($v->Data));?></td>
		       
		       			</tr>
		       		<?endforeach;?>
		       </tbody>
	    	</table>



		</div>

		<h3 class='text-left' id='informacoes'></h3>
	</div>







</div>



<script src="<?=base_url();?>public/js/relatorio/vendas.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?=base_url('public/css/datatable/semantic-table.css');?>">
<link rel="stylesheet" type="text/css" href="<?=base_url('public/css/datatable/semantic-min.css');?>">
<script type="text/javascript" src="<?=base_url('public/vendors/datatables.net/js/jquery.dataTables.min.js');?>"></script>
<script type="text/javascript" src="<?=base_url('public/js/datatable/dataTables.semanticui.min.js');?>"></script>
<script type="text/javascript" src="<?=base_url('public/js/datatable/semantic.min.js');?>" ></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>



<script type="text/javascript">


	$(document).ready(function() {

	// Filtro para localizar
	$('#tabela tfoot th').each(function(){
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Procurar '+title+'" style="float: right; border: 0px;border-radius: 4px;width: 100%;border: 1px solid #ccc;padding: 5px;"/>' );
    });


	// Plugin Para filtros
	$.fn.dataTableExt.afnFiltering.push(
		function( oSettings, aData, iDataIndex ) {
			
			var grab_daterange = $("#date_range").val();
			var give_results_daterange = grab_daterange.split(" to ");
		    var filterstart = give_results_daterange[0];
		    var filterend = give_results_daterange[1];
		    var iStartDateCol = 10; //using column 2 in this instance
		    var iEndDateCol = 10;
		    var tabledatestart = aData[iStartDateCol];
		    var tabledateend= aData[iEndDateCol];
			
		    if ( !filterstart && !filterend )
		    {
		        return true;
		    }
		    else if ((moment(filterstart).isSame(tabledatestart) || moment(filterstart).isBefore(tabledatestart)) && filterend === "")
		    {
		        return true;
		    }
		    else if ((moment(filterstart).isSame(tabledatestart) || moment(filterstart).isAfter(tabledatestart)) && filterstart === "")
		    {
		        return true;
		    }
		    else if ((moment(filterstart).isSame(tabledatestart) || moment(filterstart).isBefore(tabledatestart)) && (moment(filterend).isSame(tabledateend) || moment(filterend).isAfter(tabledateend)))
		    {
		        return true;
		    }
		    return false;
		}
	);

	// Plugin para somar 
	$.fn.dataTable.Api.register( 'sum()', function ( ) {
	    return this.flatten().reduce( function ( a, b ) {
	        if ( typeof a === 'string' ) {
	            a = a.replace(/[^\d.-]/g, '') * 1;
	        }
	        if ( typeof b === 'string' ) {
	            b = b.replace(/[^\d.-]/g, '') * 1;
	        }
	 
	        return a + b;
	    }, 0 );
	} );



	// Traducação da tablea
	var table = $('#tabela').DataTable({
		 "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
        },
		drawCallback: function () {
	      var api = this.api();
	      $("#informacoes").html('Total de Venda: R$ ' + (api.column( 4, {page:'current'} ).data().sum()).toFixed(2)+'<br>Total de Lucro Liquido: R$ ' + (api.column(6, {page:'current'} ).data().sum()).toFixed(2));
	    },
		dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        exportOptions: {
            modifier: {
                page: 'current'
            }
        }
	});


	

    $('tfoot th input').on('keyup change', function(){
    	table.columns($(this).index('tfoot th input')).search(this.value).draw();
    });


    // Data range para filtrar por datas
	$("#date_range").daterangepicker({
		autoUpdateInput: false,
		showDropdowns: true,
		opens: 'left',
		locale: {
			"cancelLabel": "Limpar",
	        }
	});

	$("#date_range").on('apply.daterangepicker', function(ev, picker) {
	      $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));
		  table.draw();
	});
	$("#date_range").on('cancel.daterangepicker', function(ev, picker) {
	      $(this).val('');
		  table.draw();
	});

    table.draw();

});
</script>