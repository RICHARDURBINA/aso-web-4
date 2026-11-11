<?php
    $arreglousuario = $Model_usuario;
?>

<!DOCTYPE html>

<html
  lang="es"
  class="layout-navbar-fixed layout-menu-fixed layout-compact"
  dir="ltr"
  data-skin="default"
  data-bs-theme="light"
  data-assets-path="<?= base_url();?>/content/template/assets/"
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

    <link rel="stylesheet" href="<?= base_url();?>/content/css/dropzone.css" />
    <link rel="stylesheet" href="<?= base_url();?>/content/css/uploadcobranza.css" />


    <style type="text/css">

      body {
        background-color: #f7f7f9;
      }

      .content_table table {
        width: 100%; /* Ocupa el 50% del contenedor */
        max-width: 100%; /* No excederá el 100% del contenedor */
        border-collapse: collapse; /* Opcional: para bordes */
      }
      /* Para que las celdas se ajusten a ese 50% */
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

      select.input-sm {
        /*height: 40px;*/
      }

      .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
          /*background-color: #FFFFFF;
          opacity: 1;
          border: 2px solid #722F37;*/
      }

      /*label[for="nbvendedor"] { color: #722F37; }
      label[for="fecha"] { color: #722F37; }
      label[for="txttot_fact"] { color: #722F37; }
      label[for="txtdesc_esp_mont"] { color: #722F37; }
      label[for="txtdesc_flet_nc_mont"] { color: #722F37; }
      label[for="txtdesc_divisa_mont"] { color: #722F37; }
      label[for="txtcobrado"] { color: #722F37; }
      label[for="txtsubtotal"] { color: #722F37; }
      label[for="txttotal"] { color: #722F37; }*/

      /* Align all number inputs to the right */
      input[type="number"] {
        text-align: right;
      }

      /* Or use a specific class */
      .number-input-right {
        text-align: right;
      }


      .modal-ancho-especial {
            max-width: 700px; /* O el ancho que necesites */
            width: 100%;
        }

      .modal-header .close {
          margin-top: -2px;
      }

      hr {
        border: 3px solid;
        opacity: 1;
      }

      button.close {
          -webkit-appearance: none;
          padding: 0;
          cursor: pointer;
          background: transparent;
          border: 0;
      }
      .close {
          float: right;
          font-size: 21px;
          font-weight: bold;
          line-height: 1;
          color: #000;
          text-shadow: 0 1px 0 #fff;
          filter: alpha(opacity=20);
          opacity: .2;
      }

      .celda_fac_oculta {
        display: none !important;
      }

      .celda_cob_oculta {
        display: none !important;
      }

    </style>


</head>
<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        
        <!-- Menu -->
        <?= $this->include('menu/_containerleftservicio'); ?>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->
          <nav class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                <i class="icon-base ri ri-menu-line icon-22px"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">
              <div class="navbar-nav align-items-center">
                <div class="nav-item dropdown me-2 me-xl-0">
                  <a class="nav-link dropdown-toggle hide-arrow" id="nav-theme" href="javascript:void(0);" data-bs-toggle="dropdown" aria-label="Toggle theme (light)">
                    <i class="ri-sun-line icon-base ri icon-22px theme-icon-active"></i>
                    <span class="d-none ms-2" id="nav-theme-text">Toggle theme</span>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-start" aria-labelledby="nav-theme-text">
                    <li>
                      <button type="button" class="dropdown-item align-items-center waves-effect active" data-bs-theme-value="light" aria-pressed="true">
                        <span><i class="icon-base ri ri-sun-line icon-22px me-3" data-icon="sun-line"></i>Light</span>
                      </button>
                    </li>
                    <li>
                      <button type="button" class="dropdown-item align-items-center waves-effect" data-bs-theme-value="dark" aria-pressed="false">
                        <span><i class="icon-base ri ri-moon-clear-line icon-22px me-3" data-icon="moon-clear-line"></i>Dark</span>
                      </button>
                    </li>
                    <li>
                      <button type="button" class="dropdown-item align-items-center waves-effect" data-bs-theme-value="system" aria-pressed="false">
                        <span><i class="icon-base ri ri-computer-line icon-22px me-3" data-icon="computer-line"></i>System</span>
                      </button>
                    </li>
                  </ul>
                </div>
              </div>

              <ul class="navbar-nav flex-row align-items-center ms-md-auto">
                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="<?= base_url();?>/content/template/assets/img/avatars/<?= $arreglousuario[0]["avatar"];?>" alt="avatar" class="rounded-circle">
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item waves-effect" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="<?= base_url();?>/content/template/assets/img/avatars/<?= $arreglousuario[0]["avatar"];?>" alt="avatar" class="w-px-40 h-auto rounded-circle">
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <h6 class="mb-0"><?= $arreglousuario[0]["usuario"];?></h6>
                            <small class="text-body-secondary"><?= $arreglousuario[0]["usuario"];?></small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider my-1"></div>
                    </li>
                    <li>
                      <div class="d-grid px-4 pt-2 pb-1">
                        <a href="<?= base_url();?>/loginController/cerrar_sesion" class="btn btn-danger d-flex waves-effect waves-light">Desconectar</a>
                      </div>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>
          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">

                <!-- Main content -->
                <section class="content">
                <form id="form1" name="form1" class="mb-5" method="POST" action="" onsubmit="return false">

                  <div class="col-md-12">
                    <div class="card">
                      <h5 class="card-header">Postear Cobranza</h5>
                      <div class="card-body">
                        <div class="row g-6">

                          <div class="col-md-3">
                            <div class="form-floating form-floating-outline mb-6">
                              <input name="cobro_adesa" type="hidden" id="cobro_adesa" value="<?= $arreglousuario[0]["cobro_adesa"];?>" />
                              <input name="cobro_aai" type="hidden" id="cobro_aai" value="<?= $arreglousuario[0]["cobro_aai"];?>" />
                              <input name="idvendedor" type="hidden" id="idvendedor" value="<?= $arreglousuario[0]["idusuario"];?>" />
                              <input type="text" class="form-control" tabindex="100" id="nbvendedor" name="nbvendedor" value="<?= $arreglousuario[0]["usuario"];?>" placeholder="" readonly>
                              <label for="nbvendedor">Vendedor</label>
                            </div>
                          </div>

                          <div class="col-md-2">
                            <div class="form-floating form-floating-outline mb-6">
                              <input type="text" class="form-control" tabindex="101" name="fecha" id="fecha" placeholder="" value="<?= date('d/m/Y');?>" readonly>
                              <label for="fecha">Fecha</label>
                            </div>
                          </div>

                          <div class="col-md-2">
                            <div class="form-floating form-floating-outline">

                              <select name="cmbempresa" id="cmbempresa" class="select2 form-select" tabindex="102" data-allow-clear="true" required>
                                <option value="" disabled selected></option>
                                <?php
                                if($arreglousuario[0]["cobro_adesa"] == "1")
                                {
                                ?>
                                  <option value="ADESA">ADESA</option>
                                <?php
                                }

                                if($arreglousuario[0]["cobro_aai"] == "1")
                                {
                                ?>
                                  <option value="AA1">AAI</option>
                                <?php
                                }
                                ?>
                              </select>
                              <label for="cmbempresa" class="form-label">Empresa (*)</label>
                            </div>
                          </div>

                          <div class="col-md-5">
                            <div class="form-floating form-floating-outline">
                              <input name="par_co_cliente" type="hidden" id="par_co_cliente" value="<?= isset($par_co_cliente) ? $par_co_cliente : ''; ?>" />
                              <select name="cmbcliente" id="cmbcliente" class="select2 form-select" tabindex="104" data-allow-clear="true" required>
                                <option value="" disabled selected></option>
                              </select>
                              <label for="cmbcliente" class="form-label">Clientes</label>
                            </div>
                          </div>

                          <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6">
                              <input type="text" class="form-control mayus" id="txtobs" name="txtobs" tabindex="105" placeholder="" autocomplete="off">
                              <label for="txtobs">Observaci&oacute;n</label>
                            </div>
                          </div>

                          <div class="col-md-12">
                            <hr class="mt-0">
                          </div>

                          <!-- =============================================================================================== -->
                          <!-- inicio datatable factura                                                                        -->
                          <!-- =============================================================================================== -->
                          <div class="row">
                            <div class="box box-primary">

                              <div class="d-flex justify-content-between align-items-center mb-3">
                                  <h5 class="card-header  pt-0">Facturas</h5>
                                  <div class="pull-right box-tools">
                                    <button id='btnaddtab_1' name='btnaddtab_1' type='button' class='btn btn-success me-4 waves-effect waves-light' title='Agregar Factura'>
                                        <span class='glyphicon glyphicon-plus' id='img-btnaddtab_1'></span>
                                    </button>
                                  </div>
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

                                          <tbody id="cont_table_body_1">
                                            <!-- <tr data-id="f1">
                                                <td class="text-left"><p>A0001234</p></td>
                                                <td class="text-left">500</td>
                                                <td class="text-center" style="font-weight: bold; color: #ff5733;">&#10008;</td>
                                            </tr>
                                            <tr data-id="f2">
                                                <td class="text-left"><p>A0002566</p></td>
                                                <td class="text-left">300</td>
                                                <td class="text-center" style="font-weight: bold; color: #ff5733;">&#10008;</td>
                                            </tr>-->
                                        </tbody>
                                      </table>
                                    </div>

                                  </div>
                              </div>

                            </div>
                          </div>
                          <!-- =============================================================================================== -->
                          <!-- fin datatable factura                                                                           -->
                          <!-- =============================================================================================== -->

                          <div class="col-md-12">
                            <hr class="mt-0">
                          </div>

                          <!-- =============================================================================================== -->
                          <!-- inicio datatable cobranza                                                                       -->
                          <!-- =============================================================================================== -->
                          <div class="row">
                            <div class="box box-primary">

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="card-header  pt-0">Pagos</h5>
                                    <div class="pull-right box-tools">
                                      <button id='btnaddtab_2' name='btnaddtab_2' type='button' class='btn btn-success me-4 waves-effect waves-light' title='Agregar Pago'>
                                          <span class='glyphicon glyphicon-plus' id='img-btnaddtab_2'></span>
                                      </button>
                                    </div>
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
                                          <tbody id="cont_table_body_2">
                                          </tbody>
                                        </table>
                                      </div>

                                    </div>
                                </div>

                            </div>
                          </div>
                          <!-- =============================================================================================== -->
                          <!-- fin datatable cobranza                                                                          -->
                          <!-- =============================================================================================== -->

                          <div class="col-md-12">
                            <hr class="mt-0">
                          </div>


                          <div class="d-flex justify-content-between align-items-center mt-0">
                              <h5 class="card-header  pt-0">Descuentos</h5>
                          </div>

                          <div class="col-md-3">
                            <div class="form-floating form-floating-outline">
                              <input type="number" id="txtdesc_esp_porc" name="txtdesc_esp_porc" class="form-control" tabindex="106" min="0" max="100" value="0">
                              <label for="txtdesc_esp_porc">Dcto. Especial (%)</label>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-floating form-floating-outline">
                              <input type="number" id="txtdesc_flet_nc" name="txtdesc_flet_nc" class="form-control" tabindex="107" min="0" value="0">
                              <label for="txtdesc_flet_nc">Dcto. por Flete/NC ($)</label>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-floating form-floating-outline">
                              <input type="number" id="txtdesc_divisa_porc" name="txtdesc_divisa_porc" class="form-control" tabindex="108" min="0" max="100" value="0">
                              <label for="txtdesc_divisa_porc">Dcto. por Pago Divisa (%)</label>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-floating form-floating-outline">
                              <input type="number" id="txtdesc_pronto_pago_porc" name="txtdesc_pronto_pago_porc" class="form-control" tabindex="109" min="0" max="100" value="0">
                              <label for="txtdesc_pronto_pago_porc">Dcto. por Pronto Pago (%)</label>
                            </div>
                          </div>

                          <div class="col-md-12">
                            <hr class="mt-0">
                          </div>

                          <div class="d-flex justify-content-between align-items-center mt-0">
                              <h5 class="card-header  pt-0">Totales</h5>
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
                              <label for="txtdesc_flet_nc_mont">Monto Dcto. Flete/NC ($)</label>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-floating form-floating-outline">
                              <input type="number" style="text-align: right;" id="txtdesc_divisa_mont" name="txtdesc_divisa_mont" class="form-control" tabindex="503" value="0" min="0" readonly>
                              <label for="txtdesc_divisa_mont">Monto Dcto. Pago Divisa ($)</label>
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
                              <input type="number" style="text-align: right;" id="txttotal" name="txttotal" class="form-control" tabindex="507" value="0" min="0" readonly>
                              <label for="txttotal">Saldo Total ($)</label>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-floating form-floating-outline">
                              <input type="number" style="text-align: right;" id="txtpendiente" name="txtpendiente" class="form-control" tabindex="508" value="0" readonly>
                              <label for="txtpendiente">Saldo Pendiente ($)</label>
                            </div>
                          </div>

                          <div class="col-md-12">
                            <hr class="mt-0">
                          </div>

                          <div class="d-flex justify-content-between align-items-center mt-0">
                              <h5 class="card-header  pt-0">Comprobantes de Pago</h5>
                          </div>

                          <div class="col-md-12">
                            <div id="miDropzoneform" class="dropzone" style="border: 3px dashed #676b7c;">
                              <div class="dz-message needsclick">
                                <strong>Arrastra archivos a cualquier lugar para subirlos.</strong><br><br>
                                <span class="note needsclick">
                                  <span class="glyphicon glyphicon-open" aria-hidden="true" style="font-size:20px;"></span>
                                </span>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-12">
                            <hr class="mt-0">
                          </div>

                        </div>

                        <div class="pt-6">
                          <button type="button" id="btnsave" name="btnsave" tabindex="109" class="btn btn-primary me-4 waves-effect waves-light">Guardar</button>
                          <button type="button" id="btnclose_" name="btnclose_" tabindex="110" class="btn btn-outline-secondary waves-effect">Cancelar</button>
                          <input name="operacion" type="hidden" id="operacion" value="1" />
                          <input name="id_cobr_web" type="hidden" id="id_cobr_web" value="" />
                        </div>

                      </div>

                    </div>

                  </div>

                  <!-- Bootstrap modal_form 1 -->
                  <div class="modal fade" id="modal_form_1" role="dialog">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">

                        <div class="modal-header">
                          <h5 class="modal-title" id="modal_form_1_Title">&nbsp;Facturas&nbsp;</h5>
                          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                          <div class="col-md-12">
                            <div class="card-body">
                              <div class="row g-6">
                                <div class="col-md-8">
                                  <div class="form-floating form-floating-outline mb-6">
                                    <input type="text" id="txtfactura" name="txtfactura" class="form-control mayus" tabindex="201">
                                    <label for="txtfactura">Factura (*)</label>
                                  </div>
                                </div>

                                <div class="col-md-4">
                                  <div class="form-floating form-floating-outline mb-6">
                                    <input type="number" id="txtmontofact" name="txtmontofact" class="form-control" tabindex="202" min="0">
                                    <label for="txtmonto">Monto ($)</label>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="modal-footer">
                          <input name="fila_tot_fact" type="hidden" id="fila_tot_fact" value="0" />
                          <button type="button" tabindex="204" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                          <button type="button" tabindex="203" name='btnadd_fact' id='btnadd_fact' class="btn btn-primary">Agregar</button>
                        </div>

                      </div>
                    </div>
                  </div>

                  <!-- Bootstrap modal_form 2 -->
                  <div class="modal fade" id="modal_form_2" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-ancho-especial" role="document">
                      <div class="modal-content">

                        <div class="modal-header">
                          <h5 class="modal-title" id="modal_form_2_Title">&nbsp;Pagos&nbsp;</h5>
                          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                          <div class="col-md-12">
                            <div class="card-body">
                              <div class="row g-6">
                                <div class="col-md-3">
                                  <div class="form-floating form-floating-outline mb-6">
                                    <input type="date" class="form-control" tabindex="299" name="txtfecha" id="txtfecha" placeholder="" value="<?= date('Y-m-d');?>">
                                    <label for="txtfecha">Fecha (*)</label>
                                  </div>
                                </div>

                                <div class="col-md-9">
                                  <div class="form-floating form-floating-outline">
                                    <select name="cmbbanco" id="cmbbanco" class="select2 form-select" tabindex="300" data-allow-clear="true" required>
                                      <option value="" disabled selected></option>
                                    </select>
                                    <label for="cmbbanco" class="form-label">Banco (*)</label>
                                  </div>
                                </div>

                                <div class="col-md-3">
                                  <div class="form-floating form-floating-outline mb-6">
                                    <input type="text" id="txtreferencia" name="txtreferencia" class="form-control mayus" tabindex="301" min="0">
                                    <label for="txtreferencia">Referencia (*)</label>
                                  </div>
                                </div>

                                <div class="col-md-3">
                                  <div class="form-floating form-floating-outline">
                                    <select name="cmbmoneda" id="cmbmoneda" class="select2 form-select" tabindex="302" data-allow-clear="true" required>
                                      <option value="" disabled selected></option>
                                      <option value="$">$</option>
                                      <option value="BS">BsD</option>
                                    </select>
                                    <label for="cmbmoneda" class="form-label">Moneda (*)</label>
                                  </div>
                                </div>

                                <div class="col-md-3">
                                  <div class="form-floating form-floating-outline mb-6">
                                    <input type="number" id="txtcobro" name="txtcobro" class="form-control" tabindex="303" min="0">
                                    <label for="txtcobro">Monto (*)</label>
                                  </div>
                                </div>

                                <div class="col-md-3">
                                  <div class="form-floating form-floating-outline mb-6">
                                    <input type="number" id="txttasa" name="txttasa" class="form-control" tabindex="304" min="0">
                                    <label for="txttasa">Tasa</label>
                                  </div>
                                </div>

                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="modal-footer">
                          <input name="fila_tot_cobr" type="hidden" id="fila_tot_cobr" value="0" />
                          <button type="button" tabindex="306" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                          <button type="button" tabindex="305" name='btnadd_cobr' id='btnadd_cobr' class="btn btn-primary">Agregar</button>
                        </div>

                      </div>
                    </div>
                  </div>

                </form>
              </section>

            </div>
            <!-- / Content -->

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl">
                <div class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                  <div class="mb-2 mb-md-0">
                    &#169;
                    <script>
                      document.write(new Date().getFullYear());
                    </script>
                  </div>
                </div>
              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
      <div class="drag-target"></div>

    </div>
    <!-- / Layout wrapper -->

    <br><br>

    <script src="<?= base_url();?>/scripts/jquery.js"></script>
    <script src="<?= base_url();?>/content/template/assets/js/vendor/jquery.min.js"></script>
    <script src="<?= base_url();?>/content/template/bootstrap/js/bootstrap.min.js"></script>

    <!-- The JavaScript -->
    <script src="<?= base_url();?>/scripts/jquery.js"></script>
    <script src="<?= base_url();?>/scripts/jquery.min.js"></script>

    <!-- AdminLTE App -->
    <script src="<?= base_url();?>/scripts/variables_globales.js"></script>
    <script src="<?= base_url();?>/scripts/jquery.general.js"></script>

    <!-- JS SECTION-->
    <script src="<?= base_url();?>/scripts/jquery-2.1.3.min.js"></script>
    <script src="<?= base_url();?>/content/template/bootstrap/js/bootstrap.min.js"></script>

    <script src="<?= base_url();?>/content/template/bootstrap/js/bootstrap-datepicker.js"></script>

    <!-- DataTable -->
    <script src="<?= base_url();?>/content/template/plugins/datatables/datatables.min.js"></script>
    <script src="<?= base_url();?>/content/template/plugins/datatables/Buttons-1.2.2/js/buttons.bootstrap.min.js"></script>
    <script src="<?= base_url();?>/content/template/plugins/datatables/Buttons-1.2.2/js/buttons.colVis.min.js"></script>

    <!-- Vendors JS -->
    <script src="<?= base_url();?>/content/template/assets/vendor/libs/select2/select2.js"></script>
    <script src="<?= base_url();?>/content/template/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
    <script src="<?= base_url();?>/scripts/dropzone.js"></script>

    <!-- Page JS -->
    <script src="<?= base_url();?>/content/template/assets/js/forms-selects.js"></script>

    <!-- scrips del sitio -->
    <script src="<?= base_url();?>/scripts/cobranza.js"></script>
    <script src="<?= base_url();?>/scripts/uploadcobranza.js"></script>

</body>
</html>