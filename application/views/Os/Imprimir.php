<!DOCTYPE >
<html>
  <head>

    <style>



    .os-layout  {
      width: 700px;
      margin-left:  auto;
      margin-right:  auto;
      height: 90%;
      padding: 10px;
      /*border: 1px solid #ccc;*/
      margin-top: 0px;
    }

    #dados_do_cliente {
      font-size: 13px;
      text-align: right;
      width: 100%;
      /*background-color: #e9e9e9;*/


    }

    #assinatura {
      margin-top: 50px;
    }

    #assinatura span {
      font-weight: 900;
    }

    #assinatura .atendente {
      float: right;
    }

    #assinatura .cliente {
      float: left;
    }

    h4 {
    	text-decoration: underline;
    	margin-bottom: 5px !important;
    }

    #dados_do_cliente td {
      padding: 1px;
      padding-left: 5px;
    }


    .campo {

      text-align: right;
      font-weight: 600;
      font-size: 12px;
      width: 100px;
      padding-right: 10px;
    }

    .valor {
      text-align: left;
      width: 200px;
      padding-left: 10px;
    }


    hr {
    	margin: 0px !important;
    }

    </style>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


  </head>



  <body>

  <div class='os-layout'>
      <div class='logo text-center'  style="
    padding: 10px;" "><img src="<?=base_url('public/images/loog-apple-planet.png');?>"/></div>
      <h5 class='text-left'>N°OS <b>#<?=$os->id_os;?></b></h5>
      <h2 class="text-center">Ordem de Serviço Apple Planet</h2>
    
        <div style="font-size: 10px; text-align: center;">
        <?=getInfoLoja();?>
        </div>
      


      <hr></hr>
       <h4>Acompanhe o seu aparelho via web.</h4>
      <div style="font-size: 12px; text-align: left;">
        <p>
        <br>Apple Planet oferece para você, um sistema via web com status em tempo real do que está acontecendo com o seu aparelho, e também podendo aprovar o orçamento via web.
        <br>
        <br>
        <b>Acesse:</b> http://sistema.appleplanet.com.br/<br>
        <b>Login:</b> <?=$os->email;?><br>
        <b>Senha:</b> <?=$os->senha;?><br>
        <b>Previsão Orçamento:</b> <?=(new DateTime($os->data_previsao_orcamento))->format('d/m/Y');?><br>
        </p>
      </div>

      <hr></hr>

      De acordo com o Código de Defesa do Consumidor n° 39.597-SP. O produto não sendo retirado em 90 dias, será retido para cobrir as despesas do serviço.<br>
      Em caso de reprovação do orçamento , será cobrado a taxa de diagnóstico de R$99,90.

      <hr></hr>
      <h4>Dados do Cliente</h4>
      <table id='dados_do_cliente'>


          <tbody>
          <tr>
            <td class='campo'>Nome:</td>
            <td class='valor'><?=$os->nome_cliente;?></td>

            <td class='campo'>Sexo:</td>
            <td class='valor'><?=$os->sexo;?></td>

            <td class='campo'>Telefone:</td>
            <td class='valor'><?=$os->telefone;?></td>
          </tr>

          <tr>

            <td class='campo'>Email:</td>
            <td class='valor'><?=$os->email;?></td>

            <td class='campo'>CEP:</td>
            <td class='valor'><?=$os->cep;?></td>

            <td class='campo'>Celular:</td>
            <td class='valor'><?=$os->celular;?></td>

          </tr>

          <tr>

            <td class='campo'>Senha:</td>
            <td class='valor'><?=$os->senha;?></td>

            <td class='campo'>Bairro:</td>
            <td class='valor'><?=$os->bairro;?></td>

            <td class='campo'>Rua:</td>
            <td class='valor'><?=$os->rua;?></td>

          </tr>

          <tr>

            <td class='campo'>CPF:</td>
            <td class='valor'><?=$os->cpf;?></td>

            <td class='campo'>Cidade:</td>
            <td class='valor'><?=$os->cidade;?></td>

            <td class='campo'>N°:</td>
            <td class='valor'><?=$os->rua_numero;?></td>

          </tr>
          </tbody>
      </table>
      <hr></hr>
       <h4>Dados do Aparelho</h4>
      <table id='dados_do_cliente'>


          <tbody>
          <tr>
            <td class='campo'>Nome:</td>
            <td class='valor'><?=$os->nome;?></td>

            <td class='campo'>IMEI:</td>
            <td class='valor'><?=$os->imei;?></td>

            <td class='campo'>Garantia Apple:</td>
            <td class='valor'><?=($os->garantia_apple > 0) ? 'Sim' : 'Não';?></td>
          </tr>

          <tr>

            <td class='campo'>Modelo:</td>
            <td class='valor'><?=$os->modelo;?></td>

            <td class='campo'>Senha:</td>
            <td class='valor'><?=$os->senha_aparelho;?></td>

            <td class='campo'></td>
            <td class='valor'></td>

          </tr>

          <tr>

            <td class='campo'>Série:</td>
            <td class='valor'><?=$os->serie;?></td>

            <td class='campo'>Categoria:</td>
            <td class='valor'><?=$os->categoria;?></td>

            <td class='campo'></td>
            <td class='valor'></td>

          </tr>

          <tr>

            <td class='campo'>Marca:</td>
            <td class='valor'><?=$os->marca;?></td>

            <td class='campo'>Cor:</td>
            <td class='valor'><?=$os->cor;?></td>

            <td class='campo'></td>
            <td class='valor'></td>

          </tr>
          </tbody>


      </table>

        <hr></hr>
       <h4>Defeito declarado</h4>
       <div>
       	<p style="margin-left: 20px; max-width: 650px;"><?=$os->defeito_declarado;?></p>


       <hr></hr>
       <h4>Observações</h4>
       <div>
       	<p style="margin-left: 20px; max-width: 650px;"><?=$os->observacoes;?></p>


        <div id='assinatura'>
          <span class='cliente'>Ass. Cliente: _________________________</span>

          <span class='atendente'>Ass. Atendente: _____________________</span>
        </div>

      </div>

  </div>

  </body>

</html>

<script type="text/javascript">
	window.print();
</script>
