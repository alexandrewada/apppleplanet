<script type="text/javascript" src="<?=base_url('public/js/template/ajaxPost.js');?>"></script>
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Observações Internas</h2>

      <div class="clearfix"></div>
    </div>
    <div class="x_content">

      <?if ($comments == false): ?>
        Você não tem nenhuma observação interna.
      <?endif;?>


      <ul class="list-unstyled timeline widget" style='
    overflow-y: auto;
    height: 230px;
'>
        <?foreach ($comments as $key => $v): ?>


        <li>
          <div class="block">
            <div class="block_content">

              <p class="excerpt">
              <?=(empty($v->mensagem) == true) ? 'Nenhuma observação.' : $v->mensagem;?>
              </p>
              <div class="byline">
                Escrito por <b><?=$v->author;?> </b> ás <span><?=date('d/m/Y H:i:s', strtotime($v->data));?></span>
              </div>
          </div>
        </div>
      </li>



      <?endforeach;?>
    </ul>

  </div>
</div>
<form id="ajaxForm" action='<?=base_url('comment/cadastrar');?>' method='POST'>
<input type='hidden' name='id_os' value='<?=$id_os;?>'>
<input type='hidden' name='origem' value='os'>
<div class='alert' id='retorno'>
</div>
<textarea name="comentario" rows="3" class="form-control" placeholder="Escreva uma observação interna."></textarea>
    <br>
    <div class='text-center'>
    <button type="submit" class='btn btn-primary'>Enviar</button>
    </div>
</div>
</form>