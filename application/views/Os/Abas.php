<script type="text/javascript" src="<?=base_url('public/js/abas/abas.js');?>"></script>

<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="x_title">
			<h2>Gerenciar Ordem de Serviço</h2>

			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<div class="" role="tabpanel" data-example-id="togglable-tabs">
				<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">

					<li role="presentation">
						<a href="#editar_usuario" id="home-tab" role="tab"  data-url="<?=base_url('usuario/editar/' . $id_cliente);?>" data-toggle="tab" aria-expanded="true">Editar Usuário</a>
					</li>

					<?if (in_array($this->session->userdata()[id_perfil], array(2, 3, 6)) == true): ?>

						<li role="presentation">
							<a href="#" id="home-tab" role="tab"  data-url="<?=base_url('os/editar/' . $id_os);?>" data-toggle="tab" aria-expanded="true">Editar Ordem de Serviço</a>
						</li>

					<?endif;?>

					<?if (in_array($this->session->userdata()[id_perfil], array(2, 3, 6)) == true and $os_detalhes->status_os != 10): ?>
						<li role="presentation">
							<a href="#" id="home-tab" role="tab"  data-url="<?=base_url('os/orcamento/' . $id_os);?>" data-toggle="tab" aria-expanded="true">Enviar Orçamento</a>
						</li>
					<?endif;?>

					<li role="presentation">
						<a href="#" id="home-tab" role="tab"  data-url="<?=base_url('os/historico/' . $id_cliente);?>" data-toggle="tab" aria-expanded="true">Histórico da Os</a>
					</li>


					<li role="presentation">
						<a href="#" id="comment" role="tab"  data-url="<?=base_url('os/comment/' . $id_os);?>" data-toggle="tab" aria-expanded="true">Observações Internas</a>
					</li>



					</ul>
				<div id="myTabContent" class="tab-content">
				</div>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	$("li[role='presentation'] a")[1].click();
</script>