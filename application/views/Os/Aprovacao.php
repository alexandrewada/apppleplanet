<script type="text/javascript" src="<?=base_url('public/js/os/aprovacao.js');?>"></script>
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
    		<h1>Aguardando a Aprovação de Orçamento...</h1>
      <div class="clearfix"></div>
    </div>
  		<h4>
    Olá, <b><?=$_SESSION['nome'];?></b> o orçamento do seu aparelho <b><?=$os->aparelho;?></b> da ordem de serviço número <b><?=$os->id_os;?></b> ficou pronto, vamos repassar todos os detalhes que o técnico(a) analisou sobre o seu aparelho, confira os detalhes logo abaixo.
    </h4>


	<div class='x_title'>
	</div>  	


	<div class="panel panel-default">
	  <div class="panel-heading">Problema relatado.</div>
	  <div class="panel-body">
	  	<?=$os->defeito_declarado;?>
	  </div>
	</div>

	<div class="panel panel-default">
	  <div class="panel-heading">Defeito encontrado pelo técnico(a).</div>
	  <div class="panel-body">
	  	<?=$os->defeito_encontrado;?>
	  </div>
	</div>


	<div class="panel panel-default">
	  <div class="panel-heading">Solução para o conserto.</div>
	  <div class="panel-body">
	  	<?=$os->defeito_solucao;?>
	  </div>
	</div>

	<div class="panel panel-default">
	  <div class="panel-heading">Detalhes do Orçamento.</div>
	  <div class="panel-body">
	  	<?=$os->detalhes;?>
	  	<br><br><br>

	<h3 class="text-center">O Valor do Orçamento ficou em <br> <b>R$ <?=$os->valor;?></b><br><br> O que você deseja fazer ?</h3>

	<div class="text-center">
	<div  class='btn btn-primary' style="background-color: green;" data-id_orcamento='<?=$os->id_os_orcamento;?>' data-id_os='<?=$os->id_os;?>' id='aprovar'>
	 Aprovar Orçamento
	</div>

	<div class='btn btn-primary' style="background-color: red;" data-id_orcamento='<?=$os->id_os_orcamento;?>' data-id_os='<?=$os->id_os;?>' id='negar'>
	 Negar Orçamento
	</div>

	</div>
	  </div>
	</div>




  </div>
</div>
</div>