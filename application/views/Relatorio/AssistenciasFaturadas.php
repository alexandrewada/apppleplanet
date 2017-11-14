

<div class="col-md-12 col-sm-12 col-xs-12">



	<div class="x_panel">

		<div class="x_title">
			<h2>Relatório de Assistências faturadas</h2>
			<div class="clearfix"></div>
		</div>

		<div class="x_content">


		<div class='form-group col-md-3'>
			<labe>Filtrar por datas.</labe>
			<input id="date_range" placeholder="Filtrar por data" value='<?=date('Y-m-d',strtotime('-1 month')).' to '.date('Y-m-d',strtotime('+1 month'));?>'' class='form-control' type="text">
		</div>

			<br><br><br>
			<table id="tabela" class="ui celled table" cellspacing="0" width="100%">
		        <thead>
		            <tr>
		            	<th>ID OS</th>
		                <th>Loja</th>
		                <th>Técnico</th>
		                <th>Orçamento</th>
		                <th>Desconto</th>
		            	<th>Lucro</th>
		            	<th>Data Faturamento</th>
		            	<th>Status</th>
		            </tr>
		        </thead>
		      <tfoot>
	            <tr>
		            	<th>ID OS</th>
		                <th>Loja</th>
		                <th>Técnico</th>
		                <th>Orçamento</th>
		                <th>Desconto</th>
		            	<th>Lucro</th>
		            	<th>Data Faturamento</th>
		            	<th>Status</th>
		      
	            </tr>
	        </tfoot>
		         <tbody>
		       		<?foreach ($AssistenciasFaturadas as $key => $v):?>
		       			
		       			<?
		       			switch ($v->status) {
		       				case '0':
		       					$status = 'pendente';
		       				break;

		       				case '1':
		       					$status = 'venda';
		       				break;

		       				case '2':
		       					$status = 'retorno';
		       				break;

		       				case '3':
		    					$status = 'devolvido';
		       				break;
		      
		       				default:
		       					$status = 'indefinido';	
		       				break;
		       			}

		       			$status = strtoupper($status);

		       			?>


		       			<tr>
			   	         	<td><?=$v->id_os;?></td>
			                <td><?=$v->loja;?></td>
			                <td><?=$v->Tecnico;?></td>
			                <td><?=$v->Venda;?></td>
			                <td><?=$v->Desconto;?></td>
			            	<td><?=$v->Liquido;?></td>
		       				<td><?=date('Y-m-d',strtotime($v->Data));?></td>
		       				<td><?=$status;?></td>
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
	$('#tabela tfoot th').each( function () {
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
		    var iStartDateCol = 6; //using column 2 in this instance
		    var iEndDateCol = 6;
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
		"lengthMenu": [100000],
		 "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
        },
		drawCallback: function () {
	      var api = this.api();
	      $("#informacoes").html('Total de Bruto: R$ ' + (api.column( 3, {page:'current'} ).data().sum()).toFixed(2)+'<br>Total de Lucro Liquido: R$ ' + (api.column( 5, {page:'current'} ).data().sum()).toFixed(2));
	    },
	    // dom: 'Bfrtip',
        buttons: [
            'csv'
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