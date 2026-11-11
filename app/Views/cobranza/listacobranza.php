<?php 
    $arreglousuario      = $Model_usuario ?? [];
    $arreglocobranza     = $Model_consultar_cobranza ?? [];
    $arreglocobranzafact = $Model_consultar_cobranza_fact ?? [];
    $arreglocobranzapago = $Model_consultar_cobranza_pago ?? [];

    $var_desde    = empty($par_desde) ? "" : $par_desde;
    $var_hasta    = empty($par_hasta) ? "" : $par_hasta;
    $var_vendedor = empty($par_vendedor) ? "" : $par_vendedor;
    $var_cliente  = empty($par_cliente) ? "" : $par_cliente;
?>

<!DOCTYPE html>
<html
  lang="es"
  class="layout-navbar-fixed layout-menu-fixed layout-compact"
  dir="ltr"
  data-skin="default"
  data-bs-theme="light"
  data-assets-path="assets/"
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

    <!-- table_responsive -->
    <link rel="stylesheet" href="<?php echo base_url();?>/content/css/table.responsive.listacobranza.css" />

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

      /* Anular el fondo blanco forzado en línea de la tabla principal */
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
      .btn:disabled, .btn.disabled, fieldset:disabled .btn {
        background-color: grey;
        border-color: black;
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
                                      <h5 class="card-header">Listado de Cobranzas</h5>
                                      <div class="card-body">
                                        
                                        <div class="row g-6">
                                          <div class="col-md-2">
                                            <div class="form-floating form-floating-outline mb-6">
                                              <input type="date" class="form-control" tabindex="101" name="txtdesde" id="txtdesde" placeholder="" value="<?=$var_desde?>">
                                              <label for="txtdesde">Desde Registro</label>
                                            </div>
                                          </div>

                                          <div class="col-md-2">
                                            <div class="form-floating form-floating-outline mb-6">
                                              <input type="date" class="form-control" tabindex="102" name="txthasta" id="txthasta" placeholder="" value="<?=$var_hasta?>">
                                              <label for="txthasta">Hasta Registro</label>
                                            </div>
                                          </div>  

                                          <div class="col-md-2">
                                            <div class="form-floating form-floating-outline">                              
                                              <select name="cmbvendedor" id="cmbvendedor" class="select2 form-select" tabindex="103" data-allow-clear="true" required>
                                                <option value="" disabled selected></option>
                                              </select>
                                              <label for="cmbvendedor" class="form-label">Vendedor</label>
                                            </div>
                                          </div>

                                          <div class="col-md-5">
                                            <div class="form-floating form-floating-outline">                              
                                              <select name="cmbcliente" id="cmbcliente" class="select2 form-select" tabindex="104" data-allow-clear="true" required>
                                                <option value="" disabled selected></option>
                                              </select>
                                              <label for="cmbcliente" class="form-label">Clientes</label>
                                            </div>
                                          </div>

                                          <div class="col-md-1">
                                            <div class="form-floating form-floating-outline mb-6">
                                              <input name="vendedor" type="hidden" id="vendedor" value="<?=$var_vendedor?>" />
                                              <input name="cliente" type="hidden" id="cliente" value="<?=$var_cliente?>" />
                                              <button class="btn btn-success" id="btnfilter" name="btnfilter" tabindex="105" type="button" title="Filtrar" onclick="fn_filter()">    
                                                  <span class="glyphicon glyphicon-search"></span>
                                                  <span id="txt-btnfilter"></span>
                                              </button>
                                            </div>
                                          </div>  

                                          <div class="col-md-2 mt-0">
                                            <div class="form-floating form-floating-outline mb-6">
                                              <button class="btn btn-success" id="btnexcel" name="btnexcel" tabindex="106" type="button" title="Generar Excel" onclick="fn_excel()">
                                                  <i class="ri ri-file-excel-fill"></i>
                                                  <span id="txt-btnexcel">Generar Excel</span>
                                              </button>
                                            </div>
                                          </div>
                                        </div>
                                        <hr>

                                        <div class="row">
                                          <div class="box box-primary">
                                              <div class="box-body">
                                                  <div class="col-lg-12 col-xs-12">
                                                      <div class="table-responsive">
                                                          <input name="cobro_adesa" type="hidden" id="cobro_adesa" value="<?=$arreglousuario[0]["cobro_adesa"] ?? 0;?>" />
                                                          <input name="cobro_aai" type="hidden" id="cobro_aai" value="<?=$arreglousuario[0]["cobro_aai"] ?? 0;?>" />

                                                          <table id="table_responsive" class="table table-striped table-bordered dt-responsive nowrap table-hover table-condensed" cellspacing="0" width="100%" style="background: white!important">
                                                              <thead>
                                                                  <tr>
                                                                      <th class="bg-primary max-width-100"><span></span></th>
                                                                      <th class="bg-primary"><span>Est.</span></th>
                                                                      <th class="bg-primary"><span>Empresa</span></th>
                                                                      <th class="bg-primary"><span>Cobranza</span></th>
                                                                      <th class="bg-primary"><span>Fecha</span></th>
                                                                      <th class="bg-primary"><span>Vendedor</span></th>
                                                                      <th class="bg-primary"><span>Cliente</span></th>
                                                                      <th class="bg-primary"><span>Zona</span></th>
                                                                      <th class="bg-primary"><span>Facturado ($)</span></th>
                                                                      <th class="bg-primary"><span>Desc.Especial ($)</span></th>
                                                                      <th class="bg-primary"><span>Desc.Flete/NC ($)</span></th>
                                                                      <th class="bg-primary"><span>Cobrado ($)</span></th>
                                                                      <th class="bg-primary"><span>Pendiente ($)</span></th>
                                                                      <th class="bg-primary"><span>Facturas</span></th>
                                                                      <th class="bg-primary"><span>Saldo</span></th>
                                                                      <th class="bg-primary"><span>Banco</span></th>
                                                                      <th class="bg-primary"><span>Fecha</span></th>
                                                                      <th class="bg-primary"><span>Referencia</span></th>
                                                                      <th class="bg-primary"><span>Moneda</span></th>
                                                                      <th class="bg-primary"><span>Monto</span></th>
                                                                      <th class="bg-primary"><span>Tasa</span></th>
                                                                      <th class="bg-primary"><span>Total ($)</span></th>
                                                                      <th class="bg-primary"><span>Actualización</span></th>
                                                                  </tr>
                                                              </thead>
                                                              <tbody>                                                                     
                                                                <?php 
                                                                $tot_cobrad = 0;
                                                                foreach($arreglocobranza as $cobranza)
                                                                {
                                                                  $cobroAdesaPermitito = $arreglousuario[0]["cobro_adesa"] ?? 0;
                                                                  $cobroAaiPermitido   = $arreglousuario[0]["cobro_aai"] ?? 0;

                                                                  if( (($cobranza["co_empresa"] == "ADESA") && ($cobroAdesaPermitito == "1")) ||
                                                                      (($cobranza["co_empresa"] == "AA1") && ($cobroAaiPermitido == "1")) )
                                                                  {
                                                                ?>   
                                                                    <tr data-id="<?php echo $cobranza["cob_id_cobranza"];?>"> 
                                                                      <td class="text-center">
                                                                      <?php 
                                                                        $arreglo_btn["model_btn"]          = "1";
                                                                        $arreglo_btn["id_registro"]        = $cobranza["cob_id_cobranza"];
                                                                        $arreglo_btn["estatus_registro"]   = $cobranza["ctv_de_estado_documento"];
                                                                        $arreglo_btn["mont_pendiente"]     = $cobranza["mont_pendiente"];

                                                                        echo view('menu/_containerbutton_cobranza', $arreglo_btn); 
                                                                      ?> 
                                                                      </td>
                                                                      <td class="text-left"><?php echo $cobranza["ctv_de_estado_documento"];?></td>
                                                                      <td class="text-left"><?php echo $cobranza["co_empresa"];?></td>
                                                                      <td class="text-left"><?php echo $cobranza["cob_id_cobranza"];?></td>
                                                                      <td class="text-left"><?php echo $cobranza["fe_emision"];?></td>
                                                                      <td class="text-left"><?php echo $cobranza["nb_vendedor"];?></td>
                                                                      <td class="text-left"><div class="max_ancho"><?php echo $cobranza["nb_organizacion"];?></div></td>
                                                                      <td class="text-left"><?php echo $cobranza["co_zona"];?></td>
                                                                      <td class="text-left"><?php echo number_format(str_replace(',', '.', $cobranza["total_facturado"]), 2, '.', ','); ?></td>
                                                                      <td class="text-left"><?php echo number_format(str_replace(',', '.', $cobranza["mont_desc_especial"]), 2, '.', ','); ?></td>
                                                                      <td class="text-left"><?php echo number_format(str_replace(',', '.', $cobranza["mont_desc_flete"]), 2, '.', ','); ?></td>
                                                                      <td class="text-left"><?php echo number_format(str_replace(',', '.', $cobranza["mont_cobrado"]), 2, '.', ','); ?></td>
                                                                      <td class="text-left"><?php echo number_format(str_replace(',', '.', $cobranza["mont_pendiente"]), 2, '.', ','); ?></td>

                                                                      <td class="text-left">
                                                                        <table class="table_inter">
                                                                          <?php foreach($arreglocobranzafact as $cob_fact) {
                                                                            if($cob_fact["id_cobranza_web"] == $cobranza["cob_id_cobranza"]) { ?>
                                                                              <tr><td class="text-left td_inter"><div class="max_ancho"><?php echo $cob_fact["nu_factura"];?></div></td></tr>
                                                                          <?php } } ?>
                                                                        </table>
                                                                      </td> 

                                                                      <td class="text-left">
                                                                        <table class="table_inter">
                                                                          <?php foreach($arreglocobranzafact as $cob_fact) {
                                                                            if($cob_fact["id_cobranza_web"] == $cobranza["cob_id_cobranza"]) { ?>
                                                                              <tr><td class="text-left td_inter"><div class="max_ancho"><?php echo number_format(str_replace(',', '.', $cob_fact["saldo_factura"]), 2, '.', ',');;?></div></td></tr>
                                                                          <?php } } ?>
                                                                        </table>
                                                                      </td> 

                                                                      <td class="text-left">
                                                                        <table class="table_inter">
                                                                          <?php foreach($arreglocobranzapago as $cob_pago) {
                                                                            if($cob_pago["id_cobranza_web"] == $cobranza["cob_id_cobranza"]) { ?>
                                                                              <tr><td class="text-left td_inter"><div class="max_ancho"><?php echo $cob_pago["co_banco"];?></div></td></tr>
                                                                          <?php } } ?>
                                                                        </table>
                                                                      </td> 

                                                                      <td class="text-left">
                                                                        <table class="table_inter">
                                                                          <?php foreach($arreglocobranzapago as $cob_pago) {
                                                                            if($cob_pago["id_cobranza_web"] == $cobranza["cob_id_cobranza"]) { ?>
                                                                              <tr><td class="text-left td_inter"><div class="max_ancho"><?php echo $cob_pago["fecha"];?></div></td></tr>
                                                                          <?php } } ?>
                                                                        </table>
                                                                      </td> 

                                                                      <td class="text-left">
                                                                        <table class="table_inter">
                                                                          <?php foreach($arreglocobranzapago as $cob_pago) {
                                                                            if($cob_pago["id_cobranza_web"] == $cobranza["cob_id_cobranza"]) { ?>
                                                                              <tr><td class="text-left td_inter"><div class="max_ancho"><?php echo $cob_pago["referencia"];?></div></td></tr>
                                                                          <?php } } ?>
                                                                        </table>
                                                                      </td> 

                                                                      <td class="text-left">
                                                                        <table class="table_inter">
                                                                          <?php foreach($arreglocobranzapago as $cob_pago) {
                                                                            if($cob_pago["id_cobranza_web"] == $cobranza["cob_id_cobranza"]) { ?>
                                                                              <tr><td class="text-left td_inter"><div class="max_ancho"><?php echo $cob_pago["co_moneda"];?></div></td></tr>
                                                                          <?php } } ?>
                                                                        </table>
                                                                      </td> 

                                                                      <td class="text-left">
                                                                        <table class="table_inter">
                                                                          <?php foreach($arreglocobranzapago as $cob_pago) {
                                                                            if($cob_pago["id_cobranza_web"] == $cobranza["cob_id_cobranza"]) { ?>
                                                                              <tr><td class="text-left td_inter"><div class="max_ancho"><?php echo number_format(str_replace(',', '.', $cob_pago["monto"]), 2, '.', ',');;?></div></td></tr>
                                                                          <?php } } ?>
                                                                        </table>
                                                                      </td> 

                                                                      <td class="text-left">
                                                                        <table class="table_inter">
                                                                          <?php foreach($arreglocobranzapago as $cob_pago) {
                                                                            if($cob_pago["id_cobranza_web"] == $cobranza["cob_id_cobranza"]) { ?>
                                                                              <tr><td class="text-left td_inter"><div class="max_ancho"><?php echo number_format(str_replace(',', '.', $cob_pago["tasa"]), 4, '.', ',');;?></div></td></tr>
                                                                          <?php } } ?>
                                                                        </table>
                                                                      </td> 

                                                                      <td class="text-left">
                                                                        <table class="table_inter">
                                                                          <?php foreach($arreglocobranzapago as $cob_pago) {
                                                                            if($cob_pago["id_cobranza_web"] == $cobranza["cob_id_cobranza"]) {
                                                                              $tot_cobrad += $cob_pago["total"]; 
                                                                          ?>
                                                                              <tr><td class="text-left td_inter celda_cobrado"><div class="max_ancho"><?php echo number_format(str_replace(',', '.', $cob_pago["total"]), 2, '.', ',');;?></div></td></tr>
                                                                          <?php } } ?>
                                                                        </table>
                                                                      </td> 

                                                                      <td class="text-left">
                                                                        <table class="table_inter">
                                                                          <?php 
                                                                          $max_fec = "";
                                                                          foreach($arreglocobranzapago as $cob_pago) {
                                                                            if($cob_pago["id_cobranza_web"] == $cobranza["cob_id_cobranza"]) {
                                                                              if($max_fec == "" || $max_fec < $cob_pago["fe_emision_cob"]) {
                                                                                $max_fec = $cob_pago["fe_emision_cob"];
                                                                              }
                                                                            }
                                                                          }
                                                                          ?>
                                                                          <tr><td class="text-left td_inter"><div class="max_ancho"><?php echo $max_fec;?></div></td></tr>
                                                                        </table>
                                                                      </td> 
                                                                    </tr> 
                                                                <?php } } ?> 
                                                              </tbody>
                                                              <tfoot>
                                                                <tr>
                                                                  <th class="bg-primary"></th>
                                                                  <th class="bg-primary"></th>
                                                                  <th class="bg-primary"></th>
                                                                  <th class="bg-primary"></th>
                                                                  <th class="bg-primary"></th>
                                                                  <th class="bg-primary"></th>
                                                                  <th class="bg-primary"></th>
                                                                  <th class="bg-primary"></th>
                                                                  <th class="bg-primary"></th>
                                                                  <th class="bg-primary"></th>
                                                                  <th class="bg-primary"></th>
                                                                  <th class="bg-primary"></th>
                                                                  <th class="bg-primary"></th>
                                                                  <th class="bg-primary"></th>
                                                                  <th class="bg-primary"></th>
                                                                  <th class="bg-primary"></th>
                                                                  <th class="bg-primary"></th>
                                                                  <th class="bg-primary"></th>
                                                                  <th class="bg-primary"></th>
                                                                  <th class="bg-primary"></th>
                                                                  <th class="bg-primary"></th>
                                                                  <th class="bg-primary text-left"><?php echo $tot_cobrad.'($)'; ?></th>
                                                                  <th class="bg-primary"></th>
                                                                </tr>
                                                              </tfoot>
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

    <!-- ============================================================================================================ -->
    <!-- ================================           LINKEO DESCRIPT             ===================================== -->
    <!-- ============================================================================================================ -->
    <!-- Helpers -->
    <script src="<?php echo base_url();?>/content/template/assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Config: Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file. -->

    <script src="<?php echo base_url();?>/content/template/assets/js/config.js"></script>

    <script src="<?php echo base_url();?>/content/template/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/vendor/libs/popper/popper.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/vendor/js/bootstrap.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/vendor/libs/@algolia/autocomplete-js.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/vendor/libs/hammer/hammer.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="<?php echo base_url();?>/content/template/assets/vendor/libs/select2/select2.js"></script>

    <!-- Main JS -->
    <script src="<?php echo base_url();?>/content/template/assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="<?php echo base_url();?>/content/template/assets/js/forms-selects.js"></script>

    <!-- <script src="<?php //echo base_url();?>/content/template/assets/js/docs.min.js"></script>  -->

    <!-- <script src="<?php //echo base_url();?>/content/template/assets/js/ui-modals.js"></script>  -->

    <script src="<?php echo base_url();?>/scripts/variables_globales.js"></script>

    <script src="<?php echo base_url();?>/scripts/jquery.general.js"></script>

    <!-- DataTable -->
    <script src="<?php echo base_url();?>/content/template/plugins/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url();?>/content/template/plugins/datatables/Buttons-1.2.2/js/buttons.bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>/content/template/plugins/datatables/Buttons-1.2.2/js/buttons.colVis.min.js"></script>
    <!-- DataTable Excel -->
    <script src="<?php echo base_url();?>/content/template/stuk-jszip/dist/jszip.min.js"></script>

    <!-- scrips del sitio -->
    <script src="<?php echo base_url();?>/scripts/listacobranza.js"></script>
</body>
</html>