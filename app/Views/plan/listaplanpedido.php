<?php
    $arreglousuario = $Model_usuario;
    $arreglopedido = $Model_consultar_plan;
    $arregloinventario = $Model_consultar_inv;

    $var_desde = empty($par_desde) ? "" : $par_desde;
    $var_hasta = empty($par_hasta) ? "" : $par_hasta;
    $var_producto = empty($par_producto) ? "" : $par_producto;
    $var_vendedor = empty($par_vendedor) ? "" : $par_vendedor;
    $var_cliente = empty($par_cliente) ? "" : $par_cliente;
    $var_empresa = empty($par_empresa) ? "" : $par_empresa;
    $var_estatus = empty($par_estatus) ? "" : $par_estatus;
    $var_url = empty($par_url) ? "" : $par_url;
    $var_fecha_inv = empty($par_fecha_inv) ? "" : $par_fecha_inv;
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

    <link rel="stylesheet" href="<?= base_url();?>/content/template/bootstrap/css/bootstrap.css" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url();?>/content/template/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="stylesheet" href="<?= base_url();?>/content/template/assets/vendor/fonts/iconify-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?= base_url();?>/content/template/assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="<?= base_url();?>/content/template/assets/vendor/css/core.css" />
    <link rel="stylesheet" href="<?= base_url();?>/content/template/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?= base_url();?>/content/template/assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="<?= base_url();?>/content/template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="<?= base_url();?>/content/template/assets/vendor/css/pages/page-icons.css" />
    <link rel="stylesheet" href="<?= base_url();?>/content/template/assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="<?= base_url();?>/content/css/formulario_modal.css" />
    <link rel="stylesheet" href="<?= base_url();?>/content/css/generales.css" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url();?>/content/template/font-awesome/css/font-awesome.min.css" />
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?= base_url();?>/content/template/ionicons/css/ionicons.min.css" />

    <link rel="stylesheet" href="<?= base_url();?>/content/template/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="<?= base_url();?>/content/css/interfaz.css" />

    <!-- datatables -->
    <link rel="stylesheet" href="<?= base_url();?>/content/template/plugins/datatables/datatables.min.css" />
    <link rel="stylesheet" href="<?= base_url();?>/content/template/plugins/datatables/Buttons-1.2.2/css/buttons.bootstrap.min.css" />

    <!-- DataTable Personal -->
    <link rel="stylesheet" href="<?= base_url();?>/content/css/table.Datatable.css" />
    
    <link rel="stylesheet" href="<?= base_url();?>/content/css/table.responsive.listaplanpedido.css" />
    <link rel="stylesheet" href="<?= base_url();?>/content/css/table.responsive.coladisponible.css" />

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

      /* Fila de Totales / Footer (tfoot) */
      [data-bs-theme="dark"] table.dataTable tfoot,
      [data-bs-theme="dark"] table.dataTable tfoot th,
      [data-bs-theme="dark"] table.dataTable tfoot td {
        background-color: #2b2c40 !important;
        color: #f1f1f6 !important;
        border-top: 1px solid #3b3c54 !important;
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

      /* Forzar el fondo y color en los componentes internos del selector de fecha */
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

      /* Asegurar el icono de calendario visible y claro */
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

      /* Línea divisoria en filas hijo */
      [data-bs-theme="dark"] table.dataTable > tbody > tr.child ul.dtr-details > li {
        border-bottom: 1px solid #3b3c54 !important;
      }

      /* ==========================================================
         FORZAR COLOR EN INPUTS DE FECHA READONLY EN MODO OSCURO
         ========================================================== */
      [data-bs-theme="dark"] input[type="date"][readonly],
      [data-bs-theme="dark"] .form-control[readonly] {
        background-color: #2b2c40 !important;
        background: #2b2c40 !important;
        opacity: 1 !important;
        color: #f1f1f6 !important;
        border-color: #3b3c54 !important;
      }

      /* ==========================================================
         ELIMINAR EL FONDO INTERNO DE LOS INPUTS DE FECHA
         ========================================================== */
      [data-bs-theme="dark"] #txtdesde,
      [data-bs-theme="dark"] #txthasta,
      [data-bs-theme="dark"] input[type="date"] {
        background-color: transparent !important;
        background: transparent !important;
      }

      [data-bs-theme="dark"] input[type="date"]::-webkit-datetime-edit,
      [data-bs-theme="dark"] input[type="date"]::-webkit-datetime-edit-fields-wrapper,
      [data-bs-theme="dark"] input[type="date"]::-webkit-datetime-edit-text,
      [data-bs-theme="dark"] input[type="date"]::-webkit-datetime-edit-month-field,
      [data-bs-theme="dark"] input[type="date"]::-webkit-datetime-edit-day-field,
      [data-bs-theme="dark"] input[type="date"]::-webkit-datetime-edit-year-field {
        background-color: transparent !important;
        background: transparent !important;
      }
      
      body { background-color: #f7f7f9; }
      .content_table table { width: 100%; max-width: 100%; border-collapse: collapse; }
      td, th { border: 1px solid black; padding: 4px; text-align: center; }
      .table_inter tr, td { border: 0px; }
      th { color: #FFFFFF; }
      h5 { font-size: 1.125rem; font-weight: bold; }
      select.input-sm { height: 40px; }
      @media (min-width: 768px) { .modal-dialog { width: 67%; max-width: 67%; } }
      @media (max-width: 767px) { .modal-dialog { width: 100%; max-width: 100%; } }
    </style>
</head>
<body>

    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        
        <!-- Menu Left -->
        <?= view('menu/_containerleftservicio'); ?>

        <div class="layout-page">

          <!-- Menu Header -->
          <?= view('menu/_containerheader'); ?>

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
                                      <h5 class="card-header">Listado de Planificaci&oacute;n</h5>
                                      <input name="url" type="hidden" id="url" value="<?= $var_url;?>" />
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
                                            <div class="form-floating form-floating-outline mb-6"> <!-- Agregado mb-6 -->
                                              <select name="cmbempresa" id="cmbempresa" class="select2 form-select" tabindex="104" data-allow-clear="true" required>
                                                <option value="" disabled selected></option>
                                              </select>
                                              <label for="cmbempresa" class="form-label">Empresa</label>
                                            </div>
                                          </div>

                                          <div class="col-md-2">
                                            <div class="form-floating form-floating-outline mb-6"> <!-- Agregado mb-6 -->
                                              <select name="cmbestatus" id="cmbestatus" class="select2 form-select" tabindex="104" data-allow-clear="true" required>
                                                <option value="" disabled selected></option>
                                              </select>
                                              <label for="cmbestatus" class="form-label">Estatus</label>
                                            </div>
                                          </div>

                                          <div class="col-md-3">
                                            <div class="form-floating form-floating-outline mb-6"> <!-- Agregado mb-6 -->
                                              <select name="cmbvendedor" id="cmbvendedor" class="select2 form-select" tabindex="105" data-allow-clear="true" required>
                                                <option value="" disabled selected></option>
                                              </select>
                                              <label for="cmbvendedor" class="form-label">Vendedor</label>
                                            </div>
                                          </div>

                                          <div class="col-md-6"> <!-- Removido mt-0 y agregado espaciado -->
                                            <div class="form-floating form-floating-outline mb-6"> <!-- Agregado mb-6 -->
                                              <select name="cmbcliente" id="cmbcliente" class="select2 form-select" tabindex="106" data-allow-clear="true" required>
                                                <option value="" disabled selected></option>
                                              </select>
                                              <label for="cmbcliente" class="form-label">Clientes</label>
                                            </div>
                                          </div>

                                          <div class="col-md-5"> <!-- Removido mt-0 -->
                                            <div class="form-floating form-floating-outline mb-6"> <!-- Agregado mb-6 -->
                                              <select name="cmbproducto" id="cmbproducto" class="select2 form-select" tabindex="107" data-allow-clear="true" required>
                                                <option value="" disabled selected></option>
                                              </select>
                                              <label for="cmbproducto" class="form-label">Producto</label>
                                            </div>
                                          </div>

                                          <!-- Botones de acción -->
                                          <div class="col-md-1">
                                            <div class="form-floating form-floating-outline mb-6">
                                              <input name="vendedor" type="hidden" id="vendedor" value="<?=$var_vendedor?>" />
                                              <input name="cliente" type="hidden" id="cliente" value="<?=$var_cliente?>" />
                                              <input name="empresa" type="hidden" id="empresa" value="<?=$var_empresa?>" />
                                              <input name="estatus" type="hidden" id="estatus" value="<?=$var_estatus?>" />
                                              <input name="producto" type="hidden" id="producto" value="<?=$var_producto?>" />
                                              <input name="cobro_adesa" type="hidden" id="cobro_adesa" value="<?=$arreglousuario[0]["cobro_adesa"];?>" />
                                              <input name="cobro_aai" type="hidden" id="cobro_aai" value="<?=$arreglousuario[0]["cobro_aai"];?>" />

                                              <button class="btn btn-success" id="btnfilter" name="btnfilter" tabindex="107" type="button" title="Filtrar" onclick="fn_filter()">
                                                  <span class="glyphicon glyphicon-search"></span>
                                                  <span id="txt-btnfilter"></span>
                                              </button>
                                            </div>
                                          </div>

                                          <div class="col-md-2 mt-2">
                                            <div class="form-floating form-floating-outline mb-6">
                                              <button class="btn btn-success" id="btnexcel" name="btnexcel" tabindex="108" type="button" title="Generar Excel" onclick="fn_excel()">
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
                                                          <table id="table_responsive" class="table table-striped table-bordered dt-responsive nowrap table-hover table-condensed" cellspacing="0" width="100%" style="background: white!important">
                                                              <thead>
                                                                  <tr>
                                                                      <th class="bg-primary max-width-100"><span></span></th>
                                                                      <th class="bg-primary"><span>Est.</span></th>
                                                                      <th class="bg-primary"><span>Fec/Plan.</span></th>
                                                                      <th class="bg-primary"><span>Web</span></th>
                                                                      <th class="bg-primary"><span>Empresa</span></th>
                                                                      <th class="bg-primary"><span>Pedido</span></th>
                                                                      <th class="bg-primary"><span>Tipo</span></th>
                                                                      <th class="bg-primary"><span>Fec/Ped.</span></th>
                                                                      <th class="bg-primary"><span>Vendedor</span></th>
                                                                      <th class="bg-primary"><span>Chofer</span></th>
                                                                      <th class="bg-primary"><span>Veh&iacute;culo</span></th>
                                                                      <th class="bg-primary"><span>Cliente</span></th>
                                                                      <th class="bg-primary"><span>Zona</span></th>
                                                                      <th class="bg-primary"><span>Producto</span></th>
                                                                      <th class="bg-primary"><span>Cantidad</span></th>
                                                                      <th class="bg-primary"><span>Direcci&Oacute;n</span></th>
                                                                  </tr>
                                                              </thead>
                                                              <tbody>
                                                                <?php
                                                                $var_pedido_doc = "";
                                                                $tot_ped = 0;
                                                                $var_tipo_pedido = "";

                                                                foreach($arreglopedido as $pedido)
                                                                {
                                                                  if( ($var_pedido_doc != $pedido["pedidos_documentos_aso"]) ||
                                                                      ($var_tipo_pedido != $pedido["tipo_pedido"]) )
                                                                  {
                                                                    $var_pedido_doc = $pedido["pedidos_documentos_aso"];
                                                                    $var_tipo_pedido = $pedido["tipo_pedido"];
                                                                ?>
                                                                    <tr data-id="<?= $pedido["pec_id_pedido_aso"]."_".$pedido["pedidos_documentos_aso"];?>">
                                                                      <td class="text-center">•</td>
                                                                      <td class="text-left">
                                                                        <?php
                                                                        if ( ($pedido["total_nos"] > 0) && ($pedido["total_fac"] == 0) ) { echo "DESPACHADO"; }
                                                                        elseif ( ($pedido["total_nos"] > 0) && ($pedido["total_fac"] > 0) ) { echo "DESPACHADO"; }
                                                                        elseif ( ($pedido["total_nos"] == 0) && ($pedido["total_fac"] > 0) ) { echo "FACTURADO"; }
                                                                        else { echo $pedido["ctv_de_estado_documento"]; }
                                                                        ?>
                                                                      </td>
                                                                      <td class="text-left"><?= $pedido["fe_plan"];?></td>
                                                                      <td class="text-left"><?= $pedido["pec_id_pedido_aso"];?></td>
                                                                      <td class="text-left"><?= $pedido["co_empresa"];?></td>
                                                                      <td class="text-left"><?= $pedido["nu_pedido"];?></td>
                                                                      <td class="text-left"><?= $pedido["tipo_pedido"];?></td>
                                                                      <td class="text-left"><?= $pedido["fe_emision"];?></td>
                                                                      <td class="text-left"><?= $pedido["nb_vendedor"];?></td>
                                                                      <td class="text-left">
                                                                        <?= $pedido["co_chofer"] != "" ? "(" . $pedido["co_chofer"] . ") " . $pedido["nb_chofer"] : "• ";?>
                                                                      </td>
                                                                      <td class="text-left">
                                                                        <?= $pedido["co_vehiculo"] != "" ? $pedido["co_vehiculo"] : "• ";?>
                                                                      </td>
                                                                      <td class="text-left">
                                                                        <div class="max_ancho"><?= $pedido["nb_organizacion"];?></div>
                                                                      </td>
                                                                      <td class="text-left"><?= $pedido["co_zona"];?></td>
                                                                      <td class="text-left">
                                                                        <table class="table_inter">
                                                                          <?php foreach($arreglopedido as $ped_prd) {
                                                                            if( ($ped_prd["pedidos_documentos_aso"] == $pedido["pedidos_documentos_aso"]) && ($ped_prd["tipo_pedido"] == $pedido["tipo_pedido"]) ) { ?>
                                                                              <tr>
                                                                                <td class="text-left td_inter">
                                                                                  <div class="max_ancho"><?= "• " . $ped_prd["nb_producto"];?></div>
                                                                                </td>
                                                                              </tr>
                                                                          <?php } } ?>
                                                                        </table>
                                                                      </td>
                                                                      <td class="text-left">
                                                                        <table class="table_inter">
                                                                          <?php foreach($arreglopedido as $ped_prd) {
                                                                            if( ($ped_prd["pedidos_documentos_aso"] == $pedido["pedidos_documentos_aso"]) && ($ped_prd["tipo_pedido"] == $pedido["tipo_pedido"]) ) {
                                                                              $tot_ped += $ped_prd["ca_producto"]; ?>
                                                                              <tr>
                                                                                <td class="text-left td_inter celda_venta">
                                                                                  <div><?= trim($ped_prd["ca_producto"]);?></div>
                                                                                </td>
                                                                              </tr>
                                                                          <?php } } ?>
                                                                        </table>
                                                                      </td>
                                                                      <td class="text-left">
                                                                          <div class="max_ancho"><?= $pedido["tx_direccion_entrega"];?></div>
                                                                      </td>
                                                                    </tr>
                                                                <?php } } ?>
                                                              </tbody>
                                                              <tfoot>
                                                                <tr>
                                                                  <th class="bg-primary" colspan="14"></th>
                                                                  <th class="bg-primary text-left"><?= $tot_ped; ?></th>
                                                                  <th class="bg-primary"></th>
                                                                </tr>
                                                              </tfoot>
                                                          </table>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                        </div>

                                        <hr>

                                        <div class="col-md">
                                          <div class="card card-action mb-6" data-card-id="card-2">
                                            <div class="card-header">
                                              <h5 class="card-action-title mb-0">Inventario de Productos <?= "(" . date("d/m/Y", strtotime($var_fecha_inv)) .")"; ?></h5>
                                              <div class="card-action-element">
                                                <ul class="list-inline mb-0">
                                                  <li class="list-inline-item">
                                                    <a href="javascript:void(0);" class="card-collapsible"><i class="icon-base ri ri-arrow-up-s-line icon-sm"></i></a>
                                                  </li>
                                                </ul>
                                              </div>
                                            </div>
                                            <div class="collapse">
                                              <div class="card-body">
                                                <div id="cont_table_body_3" class="row">
                                                  <?php foreach($arregloinventario as $inv_prd) { ?>
                                                    <div class="col-6 col-md-2">
                                                      <div class="card mb-6 border border-2 border-primary">
                                                        <div class="card-body">
                                                          <div class="d-flex align-items-center flex-column">
                                                            <div class="user-info text-center">
                                                              <h5> <?= $inv_prd["nb_corto"];?> </h5>
                                                              <p class="text-left">Inventario = <?= $inv_prd["ca_existencia"];?></p>
                                                              <p class="text-left">Programado = <?= $inv_prd["ca_planificada"];?></p>
                                                              <p class="text-left">Saldo = <?= $inv_prd["ca_saldo"];?></p>
                                                            </div>
                                                          </div>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  <?php } ?>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>

                                      </div>
                                    </div>
                                  </div>

                                  <!-- Modal Control Cola -->
                                  <div class="modal" id="modalControlCola" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 id="modalControlColaTitle">&nbsp;Control de Cola&nbsp;</h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                          <div class="col-md-12">
                                            <div class="card-body">
                                                <div class="row">
                                                  <div class="col mb-6 mt-2">
                                                    <div class="form-floating form-floating-outline">
                                                      <div class="content_table">
                                                        <table id="table_responsive_cola" cellspacing="0">
                                                          <thead>
                                                              <tr>
                                                                  <th class="bg-primary"><span></span></th>
                                                                  <th class="bg-primary"><span>Tipo Cola</span></th>
                                                                  <th class="bg-primary"><span>Posici&oacute;n</span></th>
                                                                  <th class="bg-primary"><span>Fecha</span></th>
                                                                  <th class="bg-primary"><span>Transportista</span></th>
                                                                  <th class="bg-primary"><span>Chofer</span></th>
                                                                  <th class="bg-primary"><span>Veh&iacute;culo</span></th>
                                                                  <th class="bg-primary"><span>Tipo</span></th>
                                                                  <th class="bg-primary"><span>Capacidad (kg)</span></th>
                                                                  <th class="bg-primary"><span>Total Carga (kg)</span></th>
                                                              </tr>
                                                          </thead>
                                                          <tbody id="cont_table_body"></tbody>
                                                        </table>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              <hr>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" tabindex="203" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                  </form>
                              </div>
                          </section>
                      </section>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Scripts -->
    <script src="<?= base_url();?>/content/template/assets/vendor/js/helpers.js"></script>
    <script src="<?= base_url();?>/content/template/assets/js/config.js"></script>
    <script src="<?= base_url();?>/content/template/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="<?= base_url();?>/content/template/assets/vendor/libs/popper/popper.js"></script>
    <script src="<?= base_url();?>/content/template/assets/vendor/js/bootstrap.js"></script>
    <script src="<?= base_url();?>/content/template/assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="<?= base_url();?>/content/template/assets/vendor/libs/@algolia/autocomplete-js.js"></script>
    <script src="<?= base_url();?>/content/template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="<?= base_url();?>/content/template/assets/vendor/libs/hammer/hammer.js"></script>
    <script src="<?= base_url();?>/content/template/assets/vendor/js/menu.js"></script>
    <script src="<?= base_url();?>/content/template/assets/vendor/libs/select2/select2.js"></script>
    <script src="<?= base_url();?>/content/template/assets/js/main.js"></script>
    <script src="<?= base_url();?>/content/template/assets/js/forms-selects.js"></script>
    <script src="<?= base_url();?>/scripts/variables_globales.js"></script>
    <script src="<?= base_url();?>/scripts/jquery.general.js"></script>
    <script src="<?= base_url();?>/content/template/plugins/datatables/datatables.min.js"></script>
    <script src="<?= base_url();?>/content/template/plugins/datatables/Buttons-1.2.2/js/buttons.bootstrap.min.js"></script>
    <script src="<?= base_url();?>/content/template/plugins/datatables/Buttons-1.2.2/js/buttons.colVis.min.js"></script>
    <script src="<?= base_url();?>/content/template/stuk-jszip/dist/jszip.min.js"></script>
    <script src="<?= base_url();?>/scripts/listaplanpedido.js"></script>
    <script src="<?= base_url();?>/scripts/acordeon.js"></script>
</body>
</html>