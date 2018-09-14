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
      margin-top: 100px;
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

    </style>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


  </head>
 
<?

	if(!empty($produto->nome_comprador)) {
		$_GET['cliente'] = $produto->nome_comprador;
	}

	if(!empty($produto->cpf_comprador)) {
		$_GET['cpf'] = $produto->cpf_comprador;
	}

	if(!empty($produto->garantia_comprador)) {
		$_GET['meses'] = $produto->garantia_comprador;
	}

?>



  <body>
  
  <div class='os-layout'>
      <div class='logo text-center'  style="
    padding: 10px;" "><img src='<?=base_url('public/images/loog-apple-planet.png');?>'/></div>
      <div class='text-left'><b>N° da Venda:</b> <?=$produto->id_saida;?></div>
    
      <h2 class="text-center">Garantia Apple Planet</h2>
      <div style="font-size: 10px; text-align: center;">
      <?=getInfoLoja();?>
      
    </div>
      <hr></hr>
       <h4>Termo de Garantia</h4>
      <div style="font-size: 12px; text-align: left;">
        <p>
        	Foi realizada a venda do produto <b><?=$produto->nome_produto;?></b> em nome do cliente <b><?=$_GET['cliente'];?></b> do CPF <b><?=$_GET['cpf'];?></b> na data <b><?=date('d/m/Y H:i:s',strtotime($produto->data_saida));?></b> no qual o produto <b><?=$produto->nome;?></b> foi entregue em mãos, testado e funcionando pelo cliente, mediante a assinatura de ambas as partes no final deste documento, seguindo então com <b><?=$_GET['meses'];?>  meses de garantia</b>, qualquer problema que ocorrer, é obrigatório a apresentação deste termo para validar a garantia, junto ao documento do cliente, a garantia será válida somente até o dia <b><?=date('d/m/Y',strtotime($produto->data_saida." +$_GET[meses] month"));?></b>. 
        </p>
        <p>
          A garantia não cobre mal uso por parte do cliente, como sinais de queda no aparelho, envolvendo:
        <ul>
          <li style="list-style: none;"><div style="width: 15px; height: 15px;border: 1px solid #ccc; float: left;margin-right: 5px;"></div>Tela quebrada</li>
          <li style="list-style: none;"><div style="width: 15px; height: 15px;border: 1px solid #ccc; float: left;margin-right: 5px;"></div>Pelicula de vidro quebrada</li>
          <li style="list-style: none;"><div style="width: 15px; height: 15px;border: 1px solid #ccc; float: left;margin-right: 5px;"></div>Carcaça muito amassada</li>
          <li style="list-style: none;"><div style="width: 15px; height: 15px;border: 1px solid #ccc; float: left;margin-right: 5px;"></div>Aparelho em contato com líquido</li>
          <li style="list-style: none;"><div style="width: 15px; height: 15px;border: 1px solid #ccc; float: left;margin-right: 5px;"></div>Tela descolando da carcaça</li>
      
        </ul>
        <br>
        Todos esses fatores automaticamente serão considerados mal uso do aparelho e cancelará a garantia do serviço prestado ou do aparelho comprado.
        </p>
      </div>


     
       <hr></hr>
       <h4>Dados do Produto</h4>
      <table id='dados_do_cliente'>
         
          
          <tbody>
          <tr>
            <td class='campo'>Nome:</td>
            <td class='valor'><?=$produto->nome_produto;?></td>
           
            <td class='campo'>IMEI:</td>
            <td class='valor'><?=$produto->imei;?></td>

            <td class='campo'></td>
            <td class='valor'></td>
          </tr>

          <tr>
          
            <td class='campo'>Modelo:</td>
            <td class='valor'><?=$produto->modelo;?></td>
           
            <td class='campo'>Cor:</td>
            <td class='valor'><?=$produto->cor;?></td>

            <td class='campo'></td>
            <td class='valor'></td>
          
          </tr>

          <tr>
          
            <td class='campo'>ID Produto:</td>
            <td class='valor'><?=$produto->id_produto;?></td>
           
            <td class='campo'>Marca:</td>
            <td class='valor'><?=$produto->marca;?></td>

            <td class='campo'></td>
            <td class='valor'></td>
          
          </tr>

          <tr>
          
            <td class='campo'>Marca:</td>
            <td class='valor'><?=$produto->marca;?></td>
           
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