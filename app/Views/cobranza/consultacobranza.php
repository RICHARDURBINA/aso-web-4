<?php
    $arreglousuario = $Model_usuario ?? [];
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

    <link rel="stylesheet" href="<?= base_url();?>/content/template/assets/vendor/css/core.css" />

    <link rel="stylesheet" href="<?= base_url();?>/content/template/assets/vendor/css/core.css" />

    <link rel="stylesheet" href="<?= base_url();?>/content/template/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="<?= base_url();?>/content/template/bootstrap/css/bootstrap-change.css" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url();?>/content/template/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="stylesheet" href="<?= base_url();?>/content/template/assets/vendor/fonts/iconify-icons.css" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url();?>/content/template/font-awesome/css/font-awesome.min.css" />

    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css -->

    <link rel="stylesheet" href="<?= base_url();?>/content/template/assets/vendor/libs/node-waves/node-waves.css" />

    <link rel="stylesheet" href="<?= base_url();?>/content/template/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?= base_url();?>/content/template/assets/vendor/libs/node-waves/node-waves.css" />

    <link rel="stylesheet" href="<?= base_url();?>/content/template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <!-- endbuild -->

    <!-- Page CSS -->
    <link rel="stylesheet" href="<?= base_url();?>/content/template/assets/vendor/css/pages/page-icons.css" />

    <link rel="stylesheet" href="<?= base_url();?>/content/template/assets/vendor/libs/select2/select2.css" />

    <link rel="stylesheet" href="<?= base_url();?>/content/template/assets/vendor/libs/sweetalert2/sweetalert2.css" />
    <link rel="stylesheet" href="<?= base_url();?>/content/template/assets/vendor/libs/animate-css/animate.css" />

    <link rel="stylesheet" href="<?= base_url();?>/content/css/generales.css" />

    <!-- Interfaz dinamica con php -->
    <link rel="stylesheet" href="<?= base_url();?>/content/css/interfaz.css" />
    <link rel="stylesheet" href="<?= base_url();?>/content/css/formulario_modal.css" />

    <!-- datatables -->
    <link rel="stylesheet" href="<?= base_url();?>/content/template/plugins/datatables/datatables.min.css" />
    <link rel="stylesheet" href="<?= base_url();?>/content/template/plugins/datatables/Buttons-1.2.2/css/buttons.bootstrap.min.css" />

    <!-- DataTable Personal -->
    <link rel="stylesheet" href="<?= base_url();?>/content/css/table.Datatable.css" />

    <link rel="stylesheet" href="<?= base_url();?>/content/template/assets/vendor/libs/select2/select2.css" />

    <!-- table_responsive -->
    <link rel="stylesheet" href="<?= base_url();?>/content/css/table.responsive.cobranza.css" />

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

      [data-bs-theme="dark"] table.dataTable thead th,
      [data-bs-theme="dark"] table.dataTable thead td {
        background-color: #2b2c40 !important;
        color: #f1f1f6 !important;
        border-bottom: 1px solid #3b3c54 !important;
      }

      [data-bs-theme="dark"] table.dataTable tbody tr {
        background-color: #232333 !important;
        color: #cfd0df !important;
      }

      [data-bs-theme="dark"] table.dataTable tbody td {
        border-bottom: 1px solid #3b3c54 !important;
        color: #cfd0df !important;
      }

      [data-bs-theme="dark"] .form-control,
      [data-bs-theme="dark"] .form-select,
      [data-bs-theme="dark"] input[type="date"],
      [data-bs-theme="dark"] input[type="text"],
      [data-bs-theme="dark"] select {
        background-color: #2b2c40 !important;
        border-color: #3b3c54 !important;
        color: #f1f1f6 !important;
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
      .table th {
        color: #FFFFFF;
        font-weight: bold;
      }
      h5 {
        font-size: 1.125rem;
        font-weight: bold;
      }
      .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
          background-color: #FFFFFF;
          opacity: 1;
      }
      input[type="number"] {
        text-align: right;
      }
      .modal-ancho-especial {
        max-width: 700px;
        width: 100%;
      }
      hr {
        border: 3px solid;
        opacity: 1;
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
          <!-- Navbar -->
          <?= view('menu/_containerheader'); ?>
          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">

                <!-- Main content -->
                <section class="content">
                <form id="form1" name="form1" class="mb-5" method="POST" action="" onsubmit="return false">

                  <div class="col-md-12">
                    <div class="card">
                      <h5 class="card-header">Consulta de Cobranza N° <?=$id_cobr_web ?? '';?></h5>
                      <div class="card-body">
                        <div class="row g-6">

                          <div class="col-md-3">
                            <div class="form-floating form-floating-outline mb-6">
                              <input name="id_cobr_web" type="hidden" id="id_cobr_web" value="<?=$id_cobr_web ?? '';?>" />
                              <input name="idvendedor" type="hidden" id="idvendedor" value="<?=$arreglousuario[0]["idusuario"] ?? '';?>" />
                              <input type="text" class="form-control" tabindex="100" id="nbvendedor" name="nbvendedor" value="<?=$arreglousuario[0]["usuario"] ?? '';?>" placeholder="" readonly>
                              <label for="nbvendedor">Vendedor</label>
                            </div>
                          </div>

                          <div class="col-md-2">
                            <div class="form-floating form-floating-outline mb-6">
                              <input type="text" class="form-control" tabindex="101" name="fecha" id="fecha" placeholder="" value="<?php echo date('d/m/Y');?>" readonly>
                              <label for="fecha">Fecha</label>
                            </div>
                          </div>

                          <div class="col-md-2">
                            <div class="form-floating form-floating-outline">
                              <input type="text" class="form-control" tabindex="102" id="cmbempresa" name="cmbempresa" value="" placeholder="" readonly>
                              <label for="cmbempresa">Empresa (*)</label>
                            </div>
                          </div>

                          <div class="col-md-5">
                            <div class="form-floating form-floating-outline">
                              <input type="text" class="form-control" tabindex="103" id="cmbcliente" name="cmbcliente" value="" placeholder="" readonly>
                              <label for="cmbcliente" class="form-label">Clientes</label>
                            </div>
                          </div>

                          <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6">
                              <textarea class="form-control mayus" id="txtobs" name="txtobs" tabindex="105" placeholder="" autocomplete="off" readonly style="min-height: 5rem;"></textarea>
                              <label for="txtobs">Observaci&oacute;n</label>
                            </div>
                          </div>

                          <div class="col-md-12">
                            <hr class="mt-0">
                          </div>

                          <!-- Facturas -->
                          <div class="row">
                            <div class="box box-primary">
                              <div class="d-flex justify-content-between align-items-center mb-3">
                                  <h5 class="card-header pt-0">Facturas</h5>
                                  <div class="pull-right box-tools"></div>
                              </div>
                              <div class="box-body">
                                  <div class="col-lg-12 col-xs-12">
                                    <div class="table-responsive">
                                      <table id="table_responsive_tab_1" class="table table-striped table-bordered dt-responsive nowrap table-hover table-condensed" cellspacing="0" width="100%" style="background: white!important">
                                          <thead>
                                              <tr>
                                                  <th class="bg-primary"><span>Factura</span></th>
                                                  <th class="bg-primary"><span>Monto ($)</span></th>
                                                  <th class="bg-primary max-width-100"><span>Acciones</span></th>
                                              </tr>
                                          </thead>
                                          <tbody id="cont_table_body_1"></tbody>
                                      </table>
                                    </div>
                                  </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-12">
                            <hr class="mt-0">
                          </div>

                          <!-- Pagos -->
                          <div class="row">
                            <div class="box box-primary">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="card-header pt-0">Pagos</h5>
                                    <div class="pull-right box-tools"></div>
                                </div>
                                <div class="box-body">
                                    <div class="col-lg-12 col-xs-12">
                                      <div class="table-responsive">
                                        <table id="table_responsive_tab_2" class="table table-striped table-bordered dt-responsive nowrap table-hover table-condensed" cellspacing="0" width="100%" style="background: white!important">
                                          <thead>
                                            <tr>
                                              <th class="bg-primary"><span>Fecha</span></th>
                                              <th class="bg-primary"><span>Banco</span></th>
                                              <th class="bg-primary"><span>Referencia</span></th>
                                              <th class="bg-primary"><span>Moneda</span></th>
                                              <th class="bg-primary"><span>Monto</span></th>
                                              <th class="bg-primary"><span>Tasa</span></th>
                                              <th class="bg-primary"><span>Total($)</span></th>
                                              <th class="bg-primary"><span>Acciones</span></th>
                                            </tr>
                                          </thead>
                                          <tbody id="cont_table_body_2"></tbody>
                                        </table>
                                      </div>
                                    </div>
                                </div>
                            </div>
                          </div>

                          <div class="col-md-12">
                            <hr class="mt-0">
                          </div>

                          <div class="d-flex justify-content-between align-items-center mt-0">
                              <h5 class="card-header pt-0">Descuentos</h5>
                          </div>

                          <div class="col-md-3">
                            <div class="form-floating form-floating-outline">
                              <input type="number" id="txtdesc_esp_porc" name="txtdesc_esp_porc" class="form-control" tabindex="106" min="0" max="100" value="0" readonly>
                              <label for="txtdesc_esp_porc">Dcto. Especial (%)</label>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-floating form-floating-outline">
                              <input type="number" id="txtdesc_flet_nc" name="txtdesc_flet_nc" class="form-control" tabindex="107" min="0" value="0" readonly>
                              <label for="txtdesc_flet_nc">Dcto. por Flete/NC ($)</label>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-floating form-floating-outline">
                              <input type="number" id="txtdesc_divisa_porc" name="txtdesc_divisa_porc" class="form-control" tabindex="108" min="0" max="100" value="0" readonly>
                              <label for="txtdesc_divisa_porc">Dcto. por Pago Divisa (%)</label>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-floating form-floating-outline">
                              <input type="number" id="txtdesc_pronto_pago_porc" name="txtdesc_pronto_pago_porc" class="form-control" tabindex="109" min="0" max="100" value="0" readonly>
                              <label for="txtdesc_pronto_pago_porc">Dcto. por Pronto Pago (%)</label>
                            </div>
                          </div>

                          <div class="col-md-12">
                            <hr class="mt-0">
                          </div>

                          <div class="d-flex justify-content-between align-items-center mt-0">
                              <h5 class="card-header pt-0">Totales</h5>
                          </div>

                          <div class="col-md-3">
                            <div class="form-floating form-floating-outline">
                              <input type="number" style="text-align: right;" id="txttot_fact" name="txttot_fact" class="form-control" tabindex="500" value="0" min="0" readonly>
                              <label for="txttot_fact">Total Facturado ($)</label>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-floating form-floating-outline">
                              <input type="number" style="text-align: right;" id="txtdesc_esp_mont" name="txtdesc_esp_mont" class="form-control" tabindex="501" value="0" min="0" readonly>
                              <label for="txtdesc_esp_mont">Monto Dcto. Especial ($)</label>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-floating form-floating-outline">
                              <input type="number" style="text-align: right;" id="txtdesc_flet_nc_mont" name="txtdesc_flet_nc_mont" class="form-control" tabindex="502" value="0" min="0" readonly>
                              <label for="txtdesc_flet_nc_mont">Monto Dcto. por Flete/NC ($)</label>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-floating form-floating-outline">
                              <input type="number" style="text-align: right;" id="txtdesc_divisa_mont" name="txtdesc_divisa_mont" class="form-control" tabindex="503" value="0" min="0" readonly>
                              <label for="txtdesc_divisa_mont">Monto Dcto. por Pago Divisa ($)</label>
                            </div>
                          </div>

                          <div class="col-md-2">
                            <div class="form-floating form-floating-outline">
                              <input type="number" style="text-align: right;" id="txtcobrado" name="txtcobrado" class="form-control" tabindex="504" value="0" min="0" readonly>
                              <label for="txtcobrado">Cobrado ($)</label>
                            </div>
                          </div>

                          <div class="col-md-2">
                            <div class="form-floating form-floating-outline">
                              <input type="number" style="text-align: right;" id="txtsubtotal" name="txtsubtotal" class="form-control" tabindex="505" value="0" min="0" readonly>
                              <label for="txtsubtotal">SubTotal ($)</label>
                            </div>
                          </div>

                          <div class="col-md-2">
                            <div class="form-floating form-floating-outline">
                              <input type="number" style="text-align: right;" id="txtdesc_pronto_pago_mont" name="txtdesc_pronto_pago_mont" class="form-control" tabindex="506" value="0" min="0" readonly>
                              <label for="txtdesc_pronto_pago_mont">Monto Dcto. Pronto Pago ($)</label>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-floating form-floating-outline">
                              <input type="number" style="text-align: right;" id="txttotal" name="txttotal" class="form-control" tabindex="506" value="0" min="0" readonly>
                              <label for="txttotal">Saldo Total ($)</label>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-floating form-floating-outline">
                              <input type="number" style="text-align: right;" id="txtpendiente" name="txtpendiente" class="form-control" tabindex="506" value="0" min="0" readonly>
                              <label for="txtpendiente">Saldo Pendiente ($)</label>
                            </div>
                          </div>

                          <div class="col-md-12">
                            <hr class="mt-0">
                          </div>

                          <div class="d-flex justify-content-between align-items-center mt-0">
                              <h5 class="card-header pt-0">Comprobantes de Pago</h5>
                          </div>

                          <div id="cont_table_body_3"></div>

                          <div class="col-md-12">
                            <hr class="mt-0">
                          </div>

                        </div>

                        <div class="pt-6">
                          <input name="fila_tot_fact" type="hidden" id="fila_tot_fact" value="0" />
                          <input name="fila_tot_cobr" type="hidden" id="fila_tot_cobr" value="0" />
                          <button type="button" id="btnclose_" name="btnclose_" tabindex="108" class="btn btn-outline-secondary waves-effect">Cancelar</button>
                          <input name="operacion" type="hidden" id="operacion" value="2" />
                        </div>

                      </div>
                    </div>
                  </div>
                </form>
              </section>

            </div>

            <!-- Footer -->
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



    <!-- Core JS de la plantilla (Orden idéntico a tu vista funcional) -->
    <script src="<?= base_url('content/template/assets/vendor/js/helpers.js') ?>"></script>
    <script src="<?= base_url('content/template/assets/js/config.js') ?>"></script>

    <!-- jQuery y Popper (Indispensable para los dropdowns y tooltips) -->
    <script src="<?= base_url('content/template/assets/vendor/libs/jquery/jquery.js') ?>"></script>
    <script src="<?= base_url('content/template/assets/vendor/libs/popper/popper.js') ?>"></script>
    <script src="<?= base_url('content/template/assets/vendor/js/bootstrap.js') ?>"></script>

    <!-- Plugins de estructura de la plantilla -->
    <script src="<?= base_url('content/template/assets/vendor/libs/node-waves/node-waves.js') ?>"></script>
    <script src="<?= base_url('content/template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') ?>"></script>
    <script src="<?= base_url('content/template/assets/vendor/libs/hammer/hammer.js') ?>"></script>
    <script src="<?= base_url('content/template/assets/vendor/js/menu.js') ?>"></script>

    <!-- Tus plugins y DataTable (con la DataTable core funcionando) -->
    <script src="<?= base_url('content/template/plugins/datatables/datatables.min.js') ?>"></script>
    <script src="<?= base_url('content/template/assets/vendor/libs/select2/select2.js') ?>"></script>
    <script src="<?= base_url('content/template/assets/vendor/libs/sweetalert2/sweetalert2.js') ?>"></script>
    <script src="<?= base_url('scripts/dropzone.js') ?>"></script>

    <!-- Main JS de la plantilla (Inicializa el menú lateral y navbar) -->
    <script src="<?= base_url('content/template/assets/js/main.js') ?>"></script>

    <!-- Page JS y tus scripts personalizados -->
    <script src="<?= base_url('content/template/assets/js/forms-selects.js') ?>"></script>
    <script src="<?= base_url('scripts/variables_globales.js') ?>"></script>
    <script src="<?= base_url('scripts/jquery.general.js') ?>"></script>
    <script src="<?= base_url('content/template/bootstrap/js/bootstrap-datepicker.js') ?>"></script>
    <script src="<?= base_url('scripts/consultacobranza.js') ?>"></script>

</body>
</html>