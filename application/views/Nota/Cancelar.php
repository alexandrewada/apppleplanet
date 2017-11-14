<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Cancelar nota fiscal</h2>
      
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <br>
      <h3 class="text-center">Aonde fica os dados necessários para cancelar uma NF-e?</h3>
      <DIV class='text-center'>
      <img width="70%"  src="<?=base_url('public/images/nfe-modelo.png');?>"/>
      </DIV>
      <hr>
      <form  id="ajaxForm" action='<?=base_url('nota/cancelarnota');?>' method='POST' class="form-horizontal form-label-left" >
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Chave de acesso<span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <input type="text" name='chave' placeholder='Ex: 35161224909865000133550000432166751432166751' class="form-control col-md-7 col-xs-12">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Número procotolo de autorização de uso<span class="required">*</span>
      </label>
      <div class="col-md-4 col-sm-6 col-xs-12">
        <input type="text" name='nprot' placeholder='Ex: 135160798662786 ' class="form-control col-md-7 col-xs-12">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">Motivo do cancelamento<span class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <textarea name='motivo' placeholder='Ex: A nota foi emitida com valor errado, por isso preciso cancelar.' class="form-control col-md-7 col-xs-12"></textarea>
    </div>
  </div>
  
  <div class="x_title">
    <div class="clearfix"></div>
  </div>
  <div class='alert' id='retorno'>
  </div>
  <div class="form-group">
    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">
      <button type="submit" class="btn btn-primary">Cancelar nota</button>
    </div>
  </div>
</form>
</div>
</div>
</div>