<?php   
    $arreglousuario = $Model_usuario ?? [];
    $id_vis_web     = $id_vis_web ?? "";
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

    <style type="text/css">
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
       th {
        color: #FFFFFF;
      }
      .h-px-80 {
        height: 80px !important;
      }
      input[type="checkbox"]:focus {
        border-color: #666cff;
      }
    </style>
</head>
<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        
        <!-- Menu -->
        <?= view('menu/_containerleftservicio'); ?>
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
                      <img src="<?php echo base_url();?>/content/template/assets/img/avatars/<?=$arreglousuario[0]["avatar"] ?? '';?>" alt="avatar" class="rounded-circle">
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item waves-effect" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="<?php echo base_url();?>/content/template/assets/img/avatars/<?=$arreglousuario[0]["avatar"] ?? '';?>" alt="avatar" class="w-px-40 h-auto rounded-circle">
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <h6 class="mb-0"><?=$arreglousuario[0]["usuario"] ?? '';?></h6>
                            <small class="text-body-secondary"><?=$arreglousuario[0]["usuario"] ?? '';?></small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider my-1"></div>
                    </li>
                    <li>
                      <div class="d-grid px-4 pt-2 pb-1">
                        <a href="<?php echo base_url();?>index.php/loginController/cerrar_sesion" class="btn btn-danger d-flex waves-effect waves-light">Desconectar</a>
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
            <div class="container-xxl flex-grow-1 container-p-y">

                <form id="form1" name="form1" class="mb-5" method="POST" action="" onsubmit="return false">

                  <div class="col-md-12">
                    <div class="card">
                      <h5 class="card-header">Consulta de Visita N° <?=$id_vis_web;?></h5>
                      <div class="card-body">
                        <div class="row g-6">

                          <div class="col-md-3">
                            <div class="form-floating form-floating-outline mb-6">
                              <input name="id_vis_web" type="hidden" id="id_vis_web" value="<?=$id_vis_web;?>" />
                              <input name="var_cobranza" type="hidden" id="var_cobranza" value="0" />
                              <input name="var_inventario" type="hidden" id="var_inventario" value="0" />
                              <input name="idvendedor" type="hidden" id="idvendedor" value="" />
                              <input type="text" class="form-control" tabindex="100" id="nbvendedor" name="nbvendedor" value="" placeholder="" readonly>
                              <label for="nbvendedor">Vendedor</label>
                            </div>
                          </div>

                          <div class="col-md-2">
                            <div class="form-floating form-floating-outline mb-6">
                              <input type="text" class="form-control" tabindex="101" name="fecha" id="fecha" placeholder="" value="" readonly>
                              <label for="fecha">Fecha</label>
                            </div>
                          </div>

                          <div class="col-md-7">
                            <div class="form-floating form-floating-outline">
                              <input type="text" class="form-control" tabindex="104" id="cmbcliente" name="cmbcliente" value="" placeholder="" readonly>
                              <label for="cmbcliente">Clientes</label>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-floating form-floating-outline">
                              <input type="text" class="form-control" tabindex="105" id="cmbvisita" name="cmbvisita" value="" placeholder="" readonly>
                              <label for="cmbvisita">Tipo Visita</label>
                            </div>
                          </div>

                          <div class="col-md-9">
                            <div class="form-floating form-floating-outline mb-6">
                              <input type="text" class="form-control mayus" id="txtobs" name="txtobs" tabindex="106" placeholder="" autocomplete="off" readonly>
                              <label for="txtobs">Observaci&oacute;n</label>
                            </div>
                          </div>

                          <div class="col-12">
                            <div class="col-md-3">
                              <div class="form-check mt-4">
                                <input type="checkbox" class="form-check-input" name="accion[]" id="accion[1]" value="INVENTARIO" onclick="change_check(this)" />
                                <label class="form-check-label" for="accion[1]"><h6>Productos (SKU)</h6></label>
                              </div>
                            </div>

                            <div id="content_prd"></div>

                            <hr class="mt-0">
                          </div>

                          <div class="col-12 mt-0">

                            <div class="col-md-3">
                              <div class="form-check mt-4">
                                <input type="checkbox" class="form-check-input" name="accion[]" id="accion[2]" value="COMPETENCIAS" onclick="change_check(this)" />
                                <label class="form-check-label" for="accion[2]"><h6>Productos (Terceros)</h6></label>
                              </div>
                            </div>

                            <hr class="mt-0">

                            <div id="content_comp">
                              <div class="mt-4" id="content_comp_detalle"></div>
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
          </div>
          <!-- / Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
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

    <!-- Page JS -->
    <script src="<?php echo base_url();?>/content/template/assets/js/forms-selects.js"></script>
    <script src="<?php echo base_url();?>/scripts/variables_globales.js"></script>
    <script src="<?php echo base_url();?>/scripts/jquery.general.js"></script>

    <!-- scripts del sitio -->
    <script src="<?php echo base_url();?>/scripts/consultavisita.js"></script>
</body>
</html>