<script type="text/javascript" src="<?=base_url('public/js/template/ajaxPost.js');?>"></script>
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Observações Internas</h2>

      <div class="clearfix"></div>
    </div>
    <div class="x_content">

      <?if ($comments == false): ?>
        Você não tem nenhum acompanhamento de ordem de serviço.
      <?endif;?>


      <ul class="list-unstyled timeline widget">
        <?foreach ($comments as $key => $v): ?>


        <li>
          <div class="block">
            <div class="block_content">
              <div class="byline">
                Escrito por <b><?=$v->author;?> </b> ás <span><?=date('d/m/Y H:i:s', strtotime($v->data));?></span>
              </div>
              <p class="excerpt">
              <?=(empty($v->mensagem) == true) ? 'Nenhuma observação foi escrita para este status.' : $v->mensagem;?>
              </p>

          </div>
        </div>
      </li>



      <?endforeach;?>
    </ul>

  </div>
</div>
<form id="ajaxForm" action='<?=base_url('comment/cadastrar');?>' method='POST'>
<input type='hidden' name='id_os' value='<?=$id_os;?>'>
<textarea name="comentario" rows="3" class="form-control" placeholder="Escreva uma observação interna."></textarea>
    <br>
    <div class='text-center'>
    <button type="submit" class='btn btn-primary'>Enviar</button>
    </div>
</div>
</form>