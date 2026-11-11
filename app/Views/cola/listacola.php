<?php   
    $arreglousuario = $Model_usuario ?? [];
    $arreglocola = $Model_consultar_cola ?? [];

    $var_desde = empty($par_desde) ? "" : $par_desde;
    $var_hasta = empty($par_hasta) ? "" : $par_hasta;
    $var_tipocola = empty($par_tipocola) ? "" : $par_tipocola;
    $var_transportista = empty($par_transportista) ? "" : $par_transportista;
    $var_historico = empty($par_historico) ? "" : $par_historico;
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

    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/bootstrap/css/bootstrap.css" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo base_url();?>/content/template/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/assets/vendor/fonts/iconify-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/assets/vendor/css/core.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/assets/vendor/css/pages/page-icons.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>/content/css/formulario_modal.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>/content/css/generales.css" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/font-awesome/css/font-awesome.min.css" />
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/ionicons/css/ionicons.min.css" />

    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>/content/css/interfaz.css" />

    <!-- datatables -->
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/plugins/datatables/datatables.min.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/plugins/datatables/Buttons-1.2.2/css/buttons.bootstrap.min.css" />

    <!-- DataTable Personal -->
    <link rel="stylesheet" href="<?php echo base_url();?>/content/css/table.Datatable.css" />


    <!-- table_responsive (Tomado del estilo limpio de listavisita) -->
    <link rel="stylesheet" href="<?php echo base_url();?>/content/css/table.responsive.listacola.css" />

    <style type="text/css">
      /* ==========================================================
         UNIFICACIÓN DE FONDO TANTO PARA MODO LIGHT COMO DARK
         ========================================================== */
      [data-bs-theme="light"] body,
      [data-bs-theme="light"] .layout-page,
      [data-bs-theme="light"] .content-wrapper {
        background-color: #f7f7f9 !important; 
      }

      [data-bs-theme="dark"] body,
      [data-bs-theme="dark"] .layout-page,
      [data-bs-theme="dark"] .content-wrapper {
        background-color: #2b2c40 !important;
      }

      /* 2. Anular el fondo blanco forzado en línea de la tabla principal */
      [data-bs-theme="dark"] #table_responsive {
        background-color: transparent !important;
      }

      [data-bs-theme="dark"] .table-header-custom {
        border-bottom-color: #3b3c54 !important;
      }

      [data-bs-theme="dark"] .table-title {
        color: #f1f1f6 !important;
      }

      /* Cabecera de la tabla */
      [data-bs-theme="dark"] table.dataTable thead th,
      [data-bs-theme="dark"] table.dataTable thead td {
        background-color: #2b2c40 !important;
        color: #f1f1f6 !important;
        border-bottom: 1px solid #3b3c54 !important;
      }

      /* Cuerpo de la tabla y filas */
      [data-bs-theme="dark"] table.dataTable tbody tr {
        background-color: #232333 !important;
        color: #cfd0df !important;
      }

      [data-bs-theme="dark"] table.dataTable tbody td {
        border-bottom: 1px solid #3b3c54 !important;
        color: #cfd0df !important;
      }

      [data-bs-theme="dark"] table.dataTable.stripe tbody tr.odd,
      [data-bs-theme="dark"] table.dataTable.display tbody tr.odd {
        background-color: #262738 !important;
      }

      [data-bs-theme="dark"] table.dataTable.stripe tbody tr.even,
      [data-bs-theme="dark"] table.dataTable.display tbody tr.even {
        background-color: #232333 !important;
      }

      [data-bs-theme="dark"] table.dataTable tbody tr:hover {
        background-color: #2f3046 !important;
      }

      [data-bs-theme="dark"] .dataTables_wrapper .dataTables_info,
      [data-bs-theme="dark"] .dataTables_wrapper .dataTables_length,
      [data-bs-theme="dark"] .dataTables_wrapper .dataTables_filter label {
        background-color: transparent !important;
        color: #a3a4b8 !important;
      }

      /* Paginación de DataTable */
      [data-bs-theme="dark"] .dataTables_wrapper .dataTables_paginate .paginate_button {
        background: #35364f !important;
        border-color: #484968 !important;
        color: #cfd0df !important;
      }

      [data-bs-theme="dark"] .dataTables_wrapper .dataTables_paginate .paginate_button.current,
      [data-bs-theme="dark"] .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: #3b82f6 !important;
        border-color: #3b82f6 !important;
        color: #ffffff !important;
      }

      [data-bs-theme="dark"] .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #484968 !important;
        color: #ffffff !important;
      }

      /* ==========================================================
         CORRECCIÓN DEFINITIVA PARA INPUTS DE FECHA Y SELECTS
         ========================================================== */
      [data-bs-theme="dark"] .form-control,
      [data-bs-theme="dark"] .form-select,
      [data-bs-theme="dark"] input[type="date"],
      [data-bs-theme="dark"] input[type="text"],
      [data-bs-theme="dark"] select {
        background-color: #2b2c40 !important;
        border-color: #3b3c54 !important;
        color: #f1f1f6 !important;
      }

      [data-bs-theme="dark"] input[type="date"]::-webkit-datetime-edit,
      [data-bs-theme="dark"] input[type="date"]::-webkit-datetime-edit-fields-wrapper,
      [data-bs-theme="dark"] input[type="date"]::-webkit-datetime-edit-text,
      [data-bs-theme="dark"] input[type="date"]::-webkit-datetime-edit-month-field,
      [data-bs-theme="dark"] input[type="date"]::-webkit-datetime-edit-day-field,
      [data-bs-theme="dark"] input[type="date"]::-webkit-datetime-edit-year-field {
        background-color: #2b2c40 !important;
        color: #f1f1f6 !important;
      }

      [data-bs-theme="dark"] input[type="date"] {
        color-scheme: dark !important;
      }

      [data-bs-theme="dark"] input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(1) brightness(0.9);
        cursor: pointer;
      }

      /* Flecha desplegable (dtr-control) */
      [data-bs-theme="dark"] table.dataTable.dtr-inline.collapsed > tbody > tr > td.dtr-control::before,
      [data-bs-theme="dark"] table.dataTable.dtr-inline.collapsed > tbody > tr > th.dtr-control::before {
        background: transparent !important;
        background-color: transparent !important;
        border: none !important;
        box-shadow: none !important;
        color: #60a5fa !important;
        font-size: 1rem !important;
      }

      [data-bs-theme="dark"] table.dataTable > tbody > tr.child ul.dtr-details > li {
        border-bottom: 1px solid #3b3c54 !important;
      }

      [data-bs-theme="dark"] input[type="date"][readonly],
      [data-bs-theme="dark"] .form-control[readonly] {
        background-color: #2b2c40 !important;
        background: #2b2c40 !important;
        opacity: 1 !important;
        color: #f1f1f6 !important;
        border-color: #3b3c54 !important;
      }

      [data-bs-theme="dark"] #txtdesde,
      [data-bs-theme="dark"] #txthasta,
      [data-bs-theme="dark"] input[type="date"] {
        background-color: transparent !important;
        background: transparent !important;
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
      .celda-destacada {
        background-color: #ffe0b2 !important;
        color: #e65100;
        font-weight: bold;
      }
      .table-striped > tbody > tr:nth-of-type(even) > * {
          --bs-table-bg-type: none;
      }
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
                                      <h5 id="titulo" class="card-header">Listado Control de Cola (Ultimo Reportado)</h5>
                                      <div class="card-body">
                                        
                                        <div class="row g-6">
                                          <div class="col-md-2">
                                            <div class="form-floating form-floating-outline mb-6">
                                              <input type="date" class="form-control" tabindex="101" name="txtdesde" id="txtdesde" placeholder="" value="<?=$var_desde?>">
                                              <label for="txtdesde">Desde</label>
                                            </div>
                                          </div>

                                          <div class="col-md-2">
                                            <div class="form-floating form-floating-outline mb-6">
                                              <input type="date" class="form-control" tabindex="102" name="txthasta" id="txthasta" placeholder="" value="<?=$var_hasta?>">
                                              <label for="txthasta">Hasta</label>
                                            </div>
                                          </div>  

                                          <div class="col-md-2">
                                            <div class="form-floating form-floating-outline">                              
                                              <select name="cmbtipocola" id="cmbtipocola" class="select2 form-select" tabindex="103" data-allow-clear="true" required>
                                                <option value="" disabled selected></option>
                                              </select>
                                              <label for="cmbtipocola" class="form-label">Tipo Carga</label>
                                            </div>
                                          </div>

                                          <div class="col-md-5">
                                            <div class="form-floating form-floating-outline">                              
                                              <select name="cmbtransportista" id="cmbtransportista" class="select2 form-select" tabindex="104" data-allow-clear="true" required>
                                                <option value="" disabled selected></option>
                                              </select>
                                              <label for="cmbtransportista" class="form-label">Transportista</label>
                                            </div>
                                          </div>

                                          <div class="col-md-1">
                                            <div class="form-floating form-floating-outline mb-6">
                                              <input name="tipocola" type="hidden" id="tipocola" value="<?=$var_tipocola?>" />
                                              <input name="transportista" type="hidden" id="transportista" value="<?=$var_transportista?>" />
                                              <button class="btn btn-success" id="btnfilter" name="btnfilter" tabindex="105" type="button" title="Filtrar" onclick="fn_filter()">    
                                                  <span class="glyphicon glyphicon-search"></span>
                                                  <span id="txt-btnfilter"></span>
                                              </button>
                                            </div>
                                          </div> 

                                          <div class="col-md-12">
                                            <div class="form-check mt-4">
                                              <input name="par_historico" type="hidden" id="par_historico" value="<?=$var_historico?>" />
                                              <input type="checkbox" class="form-check-input" name="check_historico" id="check_historico" value="S"/>
                                              <label class="form-check-label" for="check_historico"><h6>Traer Hist&oacute;rico</h6></label>
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
                                                                      <th class="bg-primary"><span>Carga</span></th>
                                                                      <th class="bg-primary"><span>Posici&oacute;n</span></th>
                                                                      <th class="bg-primary"><span>Nro.Cola</span></th>  
                                                                      <th class="bg-primary"><span>Fec/Reporte</span></th>                    
                                                                      <th class="bg-primary"><span>Transportista</span></th>
                                                                      <th class="bg-primary"><span>Chofer</span></th>
                                                                      <th class="bg-primary"><span>Veh&iacute;culo</span></th>
                                                                      <th class="bg-primary"><span>Tipo</span></th>
                                                                      <th class="bg-primary"><span>Capacidad</span></th>
                                                                      <th class="bg-primary"><span>Kilometraje</span></th>
                                                                      <th class="bg-primary"><span>Carga(kg)</span></th>
                                                                      <th class="bg-primary"><span>Fec/Registro</span></th>                
                                                                  </tr>
                                                              </thead>
                                                              <tbody>                                                                     
                                                                <?php 
                                                                $var_cola = "";
                                                                foreach($arreglocola as $cola)
                                                                {
                                                                  if($var_cola != $cola["id_cola_aso"])
                                                                  { 
                                                                    $var_cola = $cola["id_cola_aso"];                          
                                                                ?>   
                                                                    <tr data-id="<?php echo $cola["id_cola_aso"];?>"> 
                                                                      <td class="text-center">
                                                                      <?php 
                                                                        $arreglo_btn["model_btn"]            = "1";
                                                                        $arreglo_btn["id_registro"]          = $cola["id_cola_aso"];
                                                                        $arreglo_btn["estatus_registro"]     = $cola["ctv_co_estado_documento"];
                                                                        $arreglo_btn["est_fac_des"]          = $cola["est_fac_des"];
                                                                        $arreglo_btn["total_carga"]          = $cola["total_carga"];
                                                                        $arreglo_btn["capacidad"]            = $cola["capacidad"];  

                                                                        echo view('menu/_containerbutton_cola', $arreglo_btn); 
                                                                      ?> 
                                                                      </td>
                                                                      <td class="text-left"><?php if($cola["ti_cola"] == "L") { echo "LIVIANA"; } else { echo "PESADA"; } ;?></td>
                                                                      <td class="text-left"><?php echo $cola["posicion"];?></td>
                                                                      <td class="text-left"><?php echo $cola["id_cola_aso"];?></td>           
                                                                      <td class="text-left"><?php echo $cola["fe_reporte_form"];?></td>      
                                                                      <td class="text-left"><?php echo $cola["co_transportista"];?></td>
                                                                      <?php if($cola["co_estatus_chofer"] == "IN") { ?>  
                                                                        <td class="text-left celda-destacada"><?php echo $cola["nb_chofer"];?></td>
                                                                      <?php } else { ?>
                                                                        <td class="text-left"><?php echo $cola["nb_chofer"];?></td>
                                                                      <?php } 
                                                                            if($cola["co_estatus_vehiculo"] == "IN") { ?>  
                                                                        <td class="text-left celda-destacada"><?php echo $cola["co_vehiculo"];?></td>
                                                                      <?php } else { ?>
                                                                        <td class="text-left"><?php echo $cola["co_vehiculo"];?></td>
                                                                      <?php } ?>
                                                                      <td class="text-left"><?php echo $cola["ti_vehiculo"];?></td>
                                                                      <td class="text-left"><?php echo $cola["capacidad"];?></td>
                                                                      <td class="text-left"><?php echo $cola["kilometraje"];?></td>
                                                                      <td class="text-left"><?php echo $cola["total_carga"];?></td>
                                                                      <td class="text-left"><?php echo $cola["fe_emision_form"];?></td>            
                                                                    </tr> 
                                                                <?php
                                                                  }
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

    <!-- Scripts -->
    <!-- Scripts -->
    <script src="<?php echo base_url();?>/content/template/assets/vendor/js/helpers.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/js/config.js"></script>

    <script src="<?php echo base_url();?>/content/template/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/vendor/libs/popper/popper.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/vendor/js/bootstrap.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/vendor/libs/@algolia/autocomplete-js.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/vendor/libs/hammer/hammer.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/vendor/js/menu.js"></script>

    <!-- Vendors JS -->
    <script src="<?php echo base_url();?>/content/template/assets/vendor/libs/select2/select2.js"></script>

    <!-- Main JS -->
    <script src="<?php echo base_url();?>/content/template/assets/js/main.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/js/forms-selects.js"></script>

    <script src="<?php echo base_url();?>/scripts/variables_globales.js"></script>
    <script src="<?php echo base_url();?>/scripts/jquery.general.js"></script>

    <!-- DataTable -->
    <script src="<?php echo base_url();?>/content/template/plugins/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url();?>/content/template/plugins/datatables/Buttons-1.2.2/js/buttons.bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>/content/template/plugins/datatables/Buttons-1.2.2/js/buttons.colVis.min.js"></script>
    <!-- DataTable Excel -->
    <script src="<?php echo base_url();?>/content/template/stuk-jszip/dist/jszip.min.js"></script>

    <!-- scripts del sitio -->
    <script src="<?php echo base_url();?>/scripts/listacola.js"></script>
</body>
</html>