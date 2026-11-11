<?php   
    $arreglousuario  = $Model_usuario ?? [];
    $arreglovehiculo = $Model_consultar_vehiculo ?? [];
?>

<!DOCTYPE html>
<html
  lang="es"
  class="layout-navbar-fixed layout-menu-fixed layout-compact"
  dir="ltr"
  data-skin="default"
  data-bs-theme="light"
  data-assets-path="<?php echo base_url();?>/content/template/assets/"
  data-template="vertical-menu-template-no-customizer-starter">
<head>
    <title>Pedidos Web | Asoportuguesa</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, minimum-scale=1">    

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo base_url();?>/content/template/assets/img/favicon/favicon.ico" />

    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/assets/vendor/fonts/iconify-icons.css" /> 
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/ionicons/css/ionicons.min.css" />

    <!-- Core CSS de la plantilla -->
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/assets/vendor/css/core.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/assets/vendor/libs/select2/select2.css" />

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/plugins/datatables/datatables.min.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/plugins/datatables/Buttons-1.2.2/css/buttons.bootstrap.min.css" />

    <!-- Estilos Propios / Personalizados -->
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/assets/vendor/css/pages/page-icons.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>/content/css/formulario_modal.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>/content/css/generales.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/bootstrap/css/bootstrap_style.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>/content/css/interfaz.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>/content/css/table.Datatable.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>/content/css/table.responsive.listavehiculo.css" />   

    <!-- Helpers -->
    <script src="<?php echo base_url();?>/content/template/assets/vendor/js/helpers.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/js/config.js"></script>  

    <style type="text/css">
      body {
        background-color: #f7f7f9; 
      }
      .content_table table {
        width: 100%;
        max-width: 100%;
        border-collapse: collapse;
      }
      td, th {
        border: 1px solid black;
        padding: 4px;
        text-align: center;
      }
      .table_inter tr, td {
        border: 0px;
      }
      th {
        color: #FFFFFF;
      }
      h5 {
        font-size: 1.125rem;
        font-weight: bold;
      }
      select.input-sm {
        height: 40px;
      }
      .text-left {  text-align: left !important;  }
    </style>
</head>
<body>

    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        
        <!-- Menu -->
        <?= view('menu/_containerleftservicio'); ?>
      
        <!-- Layout container -->
        <div class="layout-page">

          <!-- Header -->
          <?= view('menu/_containerheader'); ?>

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y"> 
              <div>
                  <div class="">                         
                      <section class="content">
                          <div id="msj"></div>
                          <section class="content">
                              <div id="skin" class="row">       
                                  <form id="form1" name="form1" class="mb-5" method="POST" action="" onsubmit="return false">

                                  <div class="col-md-12">
                                    <div class="card">
                                      <div class="card-body">
                                        <div class="row g-6">
                                          <div class="d-flex justify-content-between align-items-center mb-3">
                                              <h5 class="card-header pt-0">Listado de Veh&iacute;culo</h5>
                                              <div class="pull-right box-tools">
                                                <?= view('menu/_containerbutton_new'); ?>
                                              </div>
                                          </div>
                                        </div>
                                        <hr>                                           
                                        
                                        <div class="row">
                                          <div class="box box-primary">
                                              <div class="box-body">
                                                  <div class="col-lg-12 col-xs-12">
                                                      <div class="table-responsive">
                                                          <table id="table_responsive" class="table table-striped table-bordered dt-responsive nowrap table-hover table-condensed" cellspacing="0" width="100%" style="background: white!important">
                                                              <thead>
                                                                  <tr>
                                                                      <th class="bg-primary max-width-100"><span></span></th>
                                                                      <th class="bg-primary"><span>Est.</span></th>
                                                                      <th class="bg-primary"><span>Placa</span></th>
                                                                      <th class="bg-primary"><span>Tipo/Veh&iacute;culo</span></th>
                                                                      <th class="bg-primary"><span>Capacidad</span></th>
                                                                      <th class="bg-primary"><span>Tipo/Cola</span></th>
                                                                  </tr>
                                                              </thead>
                                                              <tbody>                                                                     
                                                                <?php 
                                                                foreach($arreglovehiculo as $vehiculo)
                                                                {                                                                      
                                                                ?>    
                                                                    <tr data-id="<?php echo $vehiculo["id_vehiculo"];?>"> 
                                                                      <td class="text-center shown">
                                                                        <?php 
                                                                        $arreglo_btn["model_btn"] = "1";
                                                                        $arreglo_btn["id_registro"] = "'" . $vehiculo["id_vehiculo"] . "'";
                                                                        $arreglo_btn["estatus_registro"] = $vehiculo["co_estatus"];

                                                                        echo view('menu/_containerbutton_vehiculo', $arreglo_btn); 
                                                                        ?>
                                                                        <button type="button" class="btn-toggle-row">+</button>
                                                                      </td>
                                                                      
                                                                      <td class="text-left shown">
                                                                        <?php 
                                                                        if ( $vehiculo["co_estatus"] == 'AC' ) {
                                                                          echo "ACTIVO";
                                                                        }
                                                                        else {
                                                                          echo "INACTIVO";
                                                                        }
                                                                        ?>                                                                              
                                                                      </td>

                                                                      <td class="text-left shown"><?php echo $vehiculo["co_vehiculo"];?></td>
                                                                      <td class="text-left "><?php echo $vehiculo["ti_vehiculo"];?></td> 
                                                                      <td class="text-left "><?php echo $vehiculo["capacidad"];?></td> 
                                                                      <td class="text-left ">
                                                                        <?php 
                                                                        if ( $vehiculo["ti_cola"] == 'L' ) {
                                                                          echo "LIVIANA";
                                                                        }
                                                                        else {
                                                                          echo "PESADA";
                                                                        }
                                                                        ?>
                                                                      </td>   
                                                                    </tr> 
                                                                <?php
                                                                }
                                                                ?> 
                                                              </tbody>
                                                          </table>                                                                                
                                                      </div>                                    
                                                  </div>
                                              </div>
                                          </div>
                                        </div>

                                      </div>
                                    </div>
                                  </div>

                                  <!-- Bootstrap modal_form 1-->
                                  <div class="modal fade" id="modal_form_1" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="modal_form_1_Title">&nbsp;Veh&iacute;culo&nbsp;</h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                          <div class="col-md-12">
                                            <div class="card-body">
                                              <div class="row g-6">
                                                <div class="col-md-12">
                                                  <div class="form-floating form-floating-outline mb-6">
                                                    <input type="text" id="txtcodigo" name="txtcodigo" class="form-control mayus" tabindex="201" autocomplete="off">
                                                    <label for="txtcodigo">Placa (*)</label>
                                                  </div>
                                                </div>

                                                <div class="col-md-12">
                                                  <div class="form-floating form-floating-outline mb-6">
                                                    <select name="cmbtipocarga" id="cmbtipocarga" class="select2 form-select" tabindex="202" data-allow-clear="true" required>
                                                      <option value="" disabled selected></option>
                                                    </select>
                                                    <label for="cmbtipocarga" class="form-label">Tipo Carga (*)</label>
                                                  </div>
                                                </div>

                                                <div class="col-md-12">
                                                  <div class="form-floating form-floating-outline mb-6">
                                                    <select name="cmbtipovehiculo" id="cmbtipovehiculo" class="select2 form-select" tabindex="203" data-allow-clear="true" required>
                                                      <option value="" disabled selected></option>
                                                    </select>
                                                    <label for="cmbtipovehiculo" class="form-label">Tipo Veh&iacute;culo (*)</label>
                                                  </div>
                                                </div>

                                                <div class="col-md-12">
                                                  <div class="form-floating form-floating-outline mb-6">
                                                    <input type="number" id="txtcapacidad" name="txtcapacidad" class="form-control" tabindex="204" placeholder="0.00">
                                                    <label for="txtcapacidad">Capacidad (*)</label>
                                                  </div>
                                                </div>                                                      
                                              </div>
                                            </div>
                                          </div>
                                        </div>

                                        <div class="modal-footer">
                                          <input name="txtid" type="hidden" id="txtid" value="" />
                                          <button type="button" tabindex="206" name='btnclose_' id='btnclose_' class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                                          <button type="button" tabindex="205" name='btnsave' id='btnsave' class="btn btn-primary">Guardar</button>
                                          <input name="operacion" type="hidden" id="operacion" value="" />
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <!-- End Bootstrap modal_form_1 -->
                                  
                                </form>
                              </div>
                          </section>
                          <br><br>                    
                      </section>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <br><br>

    <!-- Scripts -->
    <script src="<?php echo base_url();?>/content/template/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/vendor/libs/popper/popper.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/vendor/js/bootstrap.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/vendor/libs/hammer/hammer.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/vendor/libs/@algolia/autocomplete-js.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/vendor/libs/select2/select2.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/vendor/js/menu.js"></script>

    <script src="<?php echo base_url();?>/content/template/stuk-jszip/dist/jszip.min.js"></script>

    <script src="<?php echo base_url();?>/content/template/plugins/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url();?>/content/template/plugins/datatables/Buttons-1.2.2/js/buttons.bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>/content/template/plugins/datatables/Buttons-1.2.2/js/buttons.colVis.min.js"></script>

    <script src="<?php echo base_url();?>/content/template/assets/js/main.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/js/forms-selects.js"></script>

    <script src="<?php echo base_url();?>/scripts/variables_globales.js"></script>
    <script src="<?php echo base_url();?>/scripts/jquery.general.js"></script>
    <script src="<?php echo base_url();?>/scripts/listapedido.js"></script>
    <script src="<?php echo base_url();?>/scripts/listavehiculo.js"></script>
</body>
</html>