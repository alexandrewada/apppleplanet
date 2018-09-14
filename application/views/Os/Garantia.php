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
    	margin-bottom: 3px !important;
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
    	margin-top: 10px !important;
    	margin-bottom: 10px !important;
    }

    </style>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


  </head>
 




  <body>
  
  <div class='os-layout'>
      <div class='logo text-center'  style="
    padding: 10px;" "><img src='<?=base_url('public/images/loog-apple-planet.png');?>'/></div>
      <h2 class="text-center">Garantia Apple Planet</h2>
      <div style="font-size: 10px; text-align: center;">
      <?=getInfoLoja();?>
      
    </div>
      <hr></hr>
       <h4>Termo de Garantia - OS #<?=$os->id_os;?></h4>
      <div style="font-size: 12px; text-align: left;">
        <p>
        	Foi realizada a assistência do aparelho <b><?=$os->nome;?></b> em nome do cliente <b><?=$os->nome_cliente;?></b> do CPF <b><?=$os->cpf;?></b> na data <b><?=date('d/m/Y H:i:s',strtotime($os->data_saida));?></b> no qual o aparelho <b><?=$os->nome;?></b> foi entregue em mãos, testado e funcionando pelo cliente, mediante a assinatura de ambas as partes no final deste documento, seguindo então com <b>3 meses de garantia nas peças usadas no conserto</b>, qualquer problema que ocorrer, é obrigatório a apresentação deste termo para validar a garantia, junto ao documento do cliente, a garantia será válida somente até o dia <b><?=date('d/m/Y',strtotime($os->data_saida.' +3 month'));?></b>. 
        </p>
    
        	A garantia não cobre mal uso por parte do cliente, como sinais de queda no aparelho, envolvendo:
     		<ul>
     			<li style="list-style: none;"><div style="width: 15px; height: 15px;border: 1px solid #ccc; float: left;margin-right: 5px;"></div>Tela quebrada</li>
     			<li style="list-style: none;"><div style="width: 15px; height: 15px;border: 1px solid #ccc; float: left;margin-right: 5px;"></div>Pelicula de vidro quebrada</li>
     			<li style="list-style: none;"><div style="width: 15px; height: 15px;border: 1px solid #ccc; float: left;margin-right: 5px;"></div>Carcaça muito amassada</li>
     			<li style="list-style: none;"><div style="width: 15px; height: 15px;border: 1px solid #ccc; float: left;margin-right: 5px;"></div>Aparelho em contato com líquido</li>
     			<li style="list-style: none;"><div style="width: 15px; height: 15px;border: 1px solid #ccc; float: left;margin-right: 5px;"></div>Tela descolando da carcaça</li>
    	
     		</ul>
     		Todos esses fatores automaticamente serão considerados mal uso do aparelho e cancelará a garantia do serviço prestado ou do aparelho comprado<br>
     		A garantia também não cobre serviços do motoboy.
        
      </div>


	  <? $pecasUsadas = json_decode($os->pecas_usados,true);?>  

      <?if(!empty($pecasGarantia[0]->id_saida_peca)):?>

      <h4>Peças usadas no conserto</h4>
      <ul>
      	<?foreach($pecasGarantia as $v):?>
      	<li><b>N° GARANTIA <?=$v->id_saida_peca;?></b> - <?=$v->nome_peca;?></li>
      	<?endforeach;?>
      </ul>
      <?endif;?>
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

            <td class='campo'></td>
            <td class='valor'></td>
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
           
            <td class='campo'></td>
            <td class='valor'></td>

            <td class='campo'></td>
            <td class='valor'></td>
          
          </tr>
          </tbody>


      </table>
      

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