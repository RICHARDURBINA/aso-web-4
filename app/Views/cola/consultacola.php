<?php   
    $arreglousuario = $Model_usuario ?? [];
?>
<!DOCTYPE html>
<html lang="es" class="layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr" data-skin="default" data-bs-theme="light" data-assets-path="<?php echo base_url();?>/content/template/assets/" data-template="vertical-menu-template-no-customizer-starter">
<head>
    <title>Pedidos Web | Asoportuguesa</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, minimum-scale=1">
    <link rel="icon" type="image/x-icon" href="<?php echo base_url();?>/content/template/assets/img/favicon/favicon.ico" />
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/assets/vendor/fonts/iconify-icons.css" /> 
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/assets/vendor/css/core.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/assets/css/demo.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/assets/vendor/css/pages/page-icons.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>/content/css/formulario_modal.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>/content/css/generales.css" />
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

      
      .content_table table { width: 100%; max-width: 100%; border-collapse: collapse; }
      td, th { border: 1px solid black; padding: 4px; text-align: center; }
      th { color: #FFFFFF; }
      .h-px-80 { height: 80px !important; }
      input[type="checkbox"]:focus { border-color: #666cff; }
    </style>
</head>
<body>
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <?= view('menu/_containerleftservicio'); ?>
        <div class="layout-page">
          <?= view('menu/_containerheader'); ?>
          <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
                <form id="form1" name="form1" class="mb-5" method="POST" action="" onsubmit="return false">
                  <div class="col-md-12">
                    <div class="card">
                      <h5 class="card-header">Consulta de Control de Cola N° <?=$id_cola_web;?></h5>
                      <div class="card-body">
                        <div class="row g-6">
                          <div class="col-md-2">
                            <div class="form-floating form-floating-outline">
                              <input name="id_cola_web" type="hidden" id="id_cola_web" value="<?=$id_cola_web;?>" />
                              <input type="text" class="form-control" tabindex="100" id="cmbtipocola" name="cmbtipocola" value="" placeholder="" readonly>
                              <label for="cmbtipocola" class="form-label">Tipo Carga (*)</label>
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="form-floating form-floating-outline mb-6">
                              <input type="text" class="form-control" tabindex="101" name="txtfecha" id="txtfecha" placeholder="" value="" readonly>
                              <label for="txtfecha">Fecha (*)</label>
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="form-floating form-floating-outline mb-6">
                              <input type="text" class="form-control" tabindex="102" name="txthora" id="txthora" placeholder="" value="" readonly>
                              <label for="txthora">Hora (*)</label>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                              <input type="text" class="form-control" tabindex="103" id="cmbtransportista" name="cmbtransportista" value="" placeholder="" readonly>
                              <label for="cmbtransportista" class="form-label">Transportista (*)</label>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-floating form-floating-outline">
                              <input type="text" class="form-control" tabindex="104" id="cmbchofer" name="cmbchofer" value="" placeholder="" readonly>
                              <label for="cmbchofer" class="form-label">Chofer (*)</label>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-floating form-floating-outline">
                              <input type="text" class="form-control" tabindex="105" id="cmbvehiculo" name="cmbvehiculo" value="" placeholder="" readonly>
                              <label for="cmbvehiculo" class="form-label">Vehículo (*)</label>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-floating form-floating-outline">
                              <input type="number" class="form-control" id="txtkilometraje" name="txtkilometraje" tabindex="106" min="0" readonly>
                              <label for="txtkilometraje">Kilometraje</label>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6">
                              <input type="text" class="form-control mayus" id="txtobs" name="txtobs" tabindex="107" placeholder="" autocomplete="off" readonly>
                              <label for="txtobs">Observaci&oacute;n</label>
                            </div>
                          </div>                                                    
                        </div>                                               
                        <div class="pt-6">
                          <button type="button" id="btnclose_" name="btnclose_" tabindex="108" class="btn btn-outline-secondary waves-effect">Cancelar</button>
                          <input name="operacion" type="hidden" id="operacion" value="1" />
                          <input name="totalprd" type="hidden" id="totalprd" value="0" />
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
            </div>            
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl">
                <div class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                  <div class="mb-2 mb-md-0">&#169; <script>document.write(new Date().getFullYear());</script></div>
                </div>
              </div>
            </footer>
            <div class="content-backdrop fade"></div>
          </div>
        </div>
      </div>
      <div class="layout-overlay layout-menu-toggle"></div>
      <div class="drag-target"></div>
    </div>
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
    <script src="<?php echo base_url();?>/content/template/assets/vendor/libs/select2/select2.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/js/main.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/js/forms-selects.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/js/docs.min.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/js/ui-modals.js"></script>
    <script src="<?php echo base_url();?>/scripts/variables_globales.js"></script>
    <script src="<?php echo base_url();?>/scripts/jquery.general.js"></script>
    <script src="<?php echo base_url();?>/scripts/consultacola.js"></script>
</body>
</html>