<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Histórico de Ordem de Serviço</h2>
      
      <div class="clearfix"></div>
    </div>
    <div class="x_content">


      <?if($historico == false):?>
        Você não tem nenhum acompanhamento de ordem de serviço.
      <?endif;?>


      <ul class="list-unstyled timeline widget">
        <?foreach ($historico as $key => $v):?>

        
        <li>
          <div class="block">
            <div class="block_content">
                       <h5>N° Ordem de Serviço: <b><?=$v->id_os;?></b></h5>
              <h2 class="title">
              <a>Status do OS foi alterado para <b><?=$v->status;?></b></a>
              </h2>
              <div class="byline">
                Alterado por <b><?=$v->alterado_por;?> <span style="color: gray;">[<?=$v->perfil;?>]</span></b> ás <span><?=date('d/m/Y H:i:s',strtotime($v->data));?></span> 
              </div>
              <p class="excerpt">
              <?= (empty($v->observacao) == true) ? 'Nenhuma observação foi escrita para este status.' : $v->observacao;?>
              </p>

          </div>
        </div>
      </li>



      <?endforeach;?>
    </ul>
  </div>
</div>
</div>