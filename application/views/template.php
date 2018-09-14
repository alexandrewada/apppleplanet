<!DOCTYPE html>
<html lang="en">
  <head>

    <script type="text/javascript">
      var base_url = '<?=base_url();?>';
    </script>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  

    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

    <link rel="shortcut icon" href="http://www.appleplanet.com.br/img/favicon/favicon.ico" type="image/x-icon"> <link rel="icon" sizes="16x16 32x32 64x64" href="http://www.appleplanet.com.br/img/favicon/favicon.ico"> <link rel="icon" type="image/png" sizes="196x196" href="http://www.appleplanet.com.br/img/favicon/favicon-192.png"> <link rel="icon" type="image/png" sizes="160x160" href="http://www.appleplanet.com.br/img/favicon/favicon-160.png"> <link rel="icon" type="image/png" sizes="96x96" href="http://www.appleplanet.com.br/img/favicon/favicon-96.png"> <link rel="icon" type="image/png" sizes="64x64" href="http://www.appleplanet.com.br/img/favicon/favicon-64.png"> <link rel="icon" type="image/png" sizes="32x32" href="http://www.appleplanet.com.br/img/favicon/favicon-32.png"> <link rel="icon" type="image/png" sizes="16x16" href="http://www.appleplanet.com.br/img/favicon/favicon-16.png"> <link rel="apple-touch-icon" href="http://www.appleplanet.com.br/img/favicon/favicon-57.png"> <link rel="apple-touch-icon" sizes="114x114" href="http://www.appleplanet.com.br/img/favicon/favicon-114.png"> <link rel="apple-touch-icon" sizes="72x72" href="http://www.appleplanet.com.br/img/favicon/favicon-72.png"> <link rel="apple-touch-icon" sizes="144x144" href="http://www.appleplanet.com.br/img/favicon/favicon-144.png"> <link rel="apple-touch-icon" sizes="60x60" href="http://www.appleplanet.com.br/img/favicon/favicon-60.png"> <link rel="apple-touch-icon" sizes="120x120" href="http://www.appleplanet.com.br/img/favicon/favicon-120.png"> <link rel="apple-touch-icon" sizes="76x76" href="http://www.appleplanet.com.br/img/favicon/favicon-76.png">

    <title>Apple Planet</title>

    <!-- jQuery -->
    <script src="<?=base_url();?>public/vendors/jquery/dist/jquery.min.js"></script>

    <!-- Toast -->
    <script src="<?=base_url();?>public/js/template/toast.js"></script>


    <!-- Bootstrap -->
    <link href="<?=base_url();?>public/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?=base_url();?>public/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

	<!-- Toast Style     -->
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>public/css/template/toast.css">

    <!-- NProgress -->
    <link href="<?=base_url();?>public/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- jQuery custom content scroller -->
    <link href="<?=base_url();?>public/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet"/>

    <!-- Custom Theme Style -->
    <link href="<?=base_url();?>public/css/template/custom.css" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col menu_fixed">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0; margin-bottom: 30px;">
               <img class='center-block img-responsive' src='<?=base_url('public/images/logo.png');?>'/>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile">
              <div class="profile_pic">
                <img src="<?=FOTO_PERFIL;?>" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Bem vindo,</span>
                <h2><?=$nome?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <div style="margin-bottom: 10px;"></div>
            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>Menu</h3>
                <ul class="nav side-menu">



                  <li>
                    <a href='<?=base_url("");?>'><i class="fa fa-circle"></i> Principal</a>
                  </li>

                    <?if(in_array($perfil,array(1)) == true):?>
                      <li>
                        <a href='<?=base_url("os/acompanhamento");?>'><i class="fa fa-question-circle-o"></i> Acompanhar OS</a>
                      </li>                  
                    <?endif;?>


                    <?if(in_array($perfil,array(2)) == true):?>
                      <li><a><i class="fa fa-sticky-note-o"></i> NF-e <span class="fa fa-chevron-down"></span></a>
                       <ul class="nav child_menu">
                          <li><a href="<?=base_url('nota/gerenciar');?>">Gerenciar</a></li>
                          <li><a href="<?=base_url('nota/cancelar');?>">Cancelar NF-e</a></li>
                        </ul> 
                      </li>
                    <?endif;?>
               
                    <?if(in_array($perfil,array(2)) == true):?>
                      <li><a><i class="fa fa-area-chart"></i> Relatórios <span class="fa fa-chevron-down"></span></a>
                       <ul class="nav child_menu">
                          <li><a href="<?=base_url('relatorio/VendasProdutos');?>">Vendas Produtos</a></li>
                          <li><a href="<?=base_url('relatorio/AssistenciasFaturadas');?>">Asisstências Faturadas</a></li>
                        </ul> 
                      </li>
                    <?endif;?>

                    <?if(in_array($perfil,array(2,5,4,6,3)) == true):?>
                      <li><a><i class="fa fa-users"></i> Usuários <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                          <li><a href="<?=base_url('usuario/cadastrar');?>">Cadastrar</a></li>
                          <li><a href="<?=base_url('usuario/gerenciar');?>">Gerenciar</a></li>
                        </ul>
                      </li>
                    <?endif;?>

                    <?if(in_array($perfil,array(2,3,4,5,6)) == true):?>
                      <li><a><i class="fa fa-wrench"></i> Assistência <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                          <li><a href="<?=base_url('os/gerenciar');?>">Gerenciar O.S</a></li>
                          <li><a href="<?=base_url('os/monitoramento');?>">Monitoramento O.S</a></li>
                          <li><a href="<?=base_url('os/gerenciar?status=4');?>">Aguardando aprovação</a></li>
                          
                           <?if(in_array($perfil,array(2,4,5,6)) == true):?>
                             <li><a href="<?=base_url('os/saida');?>">Saída de O.S</a></li>                 
                           <?endif;?>
                        </ul>
                      </li>
                    <?endif;?>
                    
                    <?if(in_array($perfil,array(2,4,5,6)) == true):?>
                    
                      <li><a><i class="fa fa-shopping-cart"></i> Produtos Loja <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">

                          <?if(in_array($perfil,array(2,5,6)) == true):?>
                            <li><a href="<?=base_url('produto/cadastrar');?>">Entrada de Produtos</a></li>
                          <?endif;?>
                          
                          <li><a href="<?=base_url('produto/saida');?>">Saída de Produtos</a></li>
                          
                          
                          <?if(in_array($perfil,array(2,5,6)) == true):?>
                            <li><a href="<?=base_url('produto/retorno');?>">Retorno de Produtos</a></li>
                          <?endif;?>

                          <?if(in_array($perfil,array(2,5,6)) == true):?>
                            <li><a href="<?=base_url('produto/gerenciar');?>">Gerenciar</a></li>
                          <?endif;?>


                          <?if(in_array($perfil,array(2,5,6)) == true):?>
                            <li><a href="<?=base_url('produto/estoque');?>">Estoque Rápido</a></li>
                          <?endif;?>

                        </ul>
                      </li>

                    <?endif;?>

                     <?if(in_array($perfil,array(2,4,5,6,3)) == true):?>
                     
                      <li><a><i class="fa fa-link"></i> Peças Assistência<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                          <?if(in_array($perfil,array(2,5,6)) == true):?>
                            <li><a href="<?=base_url('peca/cadastrar');?>">Entrada de Peças</a></li>
                          <?endif;?>

     <?if(in_array($perfil,array(2)) == true):?>
                     
                          <li><a href="<?=base_url('peca/saida');?>">Saída de Peças</a></li>
<?endif;?>

                          <?if(in_array($perfil,array(2,5,6)) == true):?>
                            <li><a href="<?=base_url('peca/retorno');?>">Retorno de Peças</a></li>
                          <?endif;?>

                          <?if(in_array($perfil,array(2,5,6,3)) == true):?>
                            <li><a href="<?=base_url('peca/gerenciar');?>">Gerenciar</a></li>
                          <?endif;?>


                          <?if(in_array($perfil,array(2,5,6)) == true):?>
                            <li><a href="<?=base_url('peca/estoque');?>">Estoque Rápido</a></li>
                          <?endif;?>


                        </ul>
                      </li>

                    <?endif;?>


                    <?if(in_array($perfil,array(2)) == true):?>
                   
                    <li><a><i class="fa fa-home"></i> Lojas <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li><a href="<?=base_url('loja/cadastrar');?>">Cadastrar</a></li>
                        <li><a href="<?=base_url('loja/gerenciar');?>">Gerenciar</a></li>
                      </ul>
                    </li>

                    <?endif;?>

                   
                    <?if(in_array($perfil,array(2,5)) == true):?>
                      <li><a><i class="fa fa-book"></i> Categorias <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                          <li><a href="<?=base_url('categoria/cadastrar');?>">Cadastrar</a></li>
                          <li><a href="<?=base_url('categoria/gerenciar');?>">Gerenciar</a></li>
                        </ul>
                      </li>
                    <?endif;?>


                    <?if(in_array($perfil,array(2,5,6)) == true):?>
                      <li><a><i class="fa fa-truck"></i> Fornecedores <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                          <li><a href="<?=base_url('fornecedor/cadastrar');?>">Cadastrar</a></li>
                          <li><a href="<?=base_url('fornecedor/gerenciar');?>">Gerenciar</a></li>
                        </ul>
                      </li>
                    <?endif;?>

                    <?if(in_array($perfil,array(2,5,4,6,3)) == true):?>
                      <li><a><i class="fa fa-exchange"></i> Compra ou Troca <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                          <li><a href="<?=base_url('troca/cadastrar');?>">Troca</a></li>
                        </ul>
                      </li>
                    <?endif;?>



                </ul>
              </div>


            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
         <!--    <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div> -->
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="<?=FOTO_PERFIL;?>" alt=""><?=$nome;?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="<?=base_url('principal/sair');?>"><i class="fa fa-sign-out pull-right"></i> Sair</a></li>
                  </ul>
                </li>

               <!--  <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green">6</span>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    <li>
                      <a>
                        <span class="image"><img src="<?=$_SESSION['foto'];?>" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="<?=$_SESSION['foto'];?>" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="<?=$_SESSION['foto'];?>" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="<?=$_SESSION['foto'];?>" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <div class="text-center">
                        <a>
                          <strong>See All Alerts</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li> -->
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div>
            <div class="page-title">
              <!-- <div class="title_left">
                <h3><?=$titulo;?></h3>
              </div> -->
            </div>
            <div class="clearfix"></div>
            <div id='conteudo' class='row'>
              <?=$contents;?>
            </div>
          </div>


        </div>
        <!-- /page content -->

        <!-- footer content -->
       <!--  <footer>
          <div class="pull-right">
            Apple Planet
          </div>
          <div class="clearfix"></div>
        </footer> -->
        <!-- /footer content -->
      </div>
    </div>

    <!-- Bootstrap -->
    <script src="<?=base_url();?>public/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?=base_url();?>public/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?=base_url();?>public/vendors/nprogress/nprogress.js"></script>
    <!-- jQuery custom content scroller -->
    <script src="<?=base_url();?>public/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?=base_url();?>public/js/template/custom.min.js"></script>

    <script src="<?=base_url();?>public/js/template/cep.js"></script>



    <!-- funcoes template -->
    <script src="<?=base_url('public/js/template/funcoes.js');?>"></script>

    <script src="http://cdn.jsdelivr.net/momentjs/latest/moment.min.js" type="text/javascript"></script>

    <!-- datapicker -->
    <script src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>

     <!-- AjaxPost -->
    <script src="<?=base_url('public/js/template/ajaxPost.js');?>"></script>

    <!-- barcode -->
    <script type="text/javascript" src="<?=base_url('public/js/template/barcode.js');?>"></script>

    <!-- Mask -->
    <script src="<?=base_url();?>public/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>


    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.0/js/dataTables.buttons.min.js">
  </script>
  <script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.5.0/js/buttons.flash.min.js">
  </script>
  <script type="text/javascript" language="javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js">
  </script>
  <script type="text/javascript" language="javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js">
  </script>
  <script type="text/javascript" language="javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js">
  </script>
  <script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.5.0/js/buttons.html5.min.js">
  </script>
  <script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.5.0/js/buttons.print.min.js">
  </script>

    <script type="text/javascript">
      $(document).ready(function(){
         $(":input").inputmask({greedy: false,placeholder:""});
      });
    </script>

    <!--mask-->



<div id='modalAjax' class="modal bs-example-modal-lg" tabindex="-1" role="dialog" >
  <div class="modal-dialog modal-lg" role="document">
    <div id='modalAjax_html' class="modal-content">
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>

  </div>
</div>


  </body>
</html>