 <!-- jQuery -->
    <script src="<?=base_url();?>public/vendors/jquery/dist/jquery.min.js"></script>
 <!-- barcode -->
    <script type="text/javascript" src="<?=base_url('public/js/template/barcode.js');?>"></script>


 <script type="text/javascript">
 	$(function(){
 		$(".b").barcode("<?=$codigo;?>", "<?=$tipo;?>",{produto:'<?=$nome_produto;?>', fontSize:8, preco:'<?=$preco;?>'});     
 		window.print();
 	});
 </script>

 <style>
 	.b {
 		float: left;
 		margin: 5px;
 		width: 4cm;
  	}
 </style>


 	<?for($x=0; $i < $qtd; $i++):?>

	 	<div>
	 		<div class='b'>
	 			
	 		</div>
	 	</div>

 	<?endfor;?>