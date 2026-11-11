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
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/assets/vendor/libs/sweetalert2/sweetalert2.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/assets/vendor/libs/animate-css/animate.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>/content/css/formulario_modal.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>/content/css/generales.css" />
    <style type="text/css">
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
                      <h5 class="card-header">Postear Control de Cola</h5>
                      <div class="card-body">
                        <div class="row g-6">
                          <div class="col-md-2">
                            <div class="form-floating form-floating-outline">
                              <select name="cmbtipocola" id="cmbtipocola" class="select2 form-select" tabindex="100" data-allow-clear="true" required>
                                <option value="" disabled selected></option>
                              </select>
                              <label for="cmbtipocola" class="form-label">Tipo Carga (*)</label>
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="form-floating form-floating-outline mb-6">
                              <input type="date" class="form-control" tabindex="101" name="txtfecha" id="txtfecha" placeholder="" value="">
                              <label for="txtfecha">Fecha (*)</label>
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="form-floating form-floating-outline mb-6">
                              <input type="time" class="form-control" tabindex="102" name="txthora" id="txthora" placeholder="" value="">
                              <label for="txthora">Hora (*)</label>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                              <select name="cmbtransportista" id="cmbtransportista" class="select2 form-select" tabindex="103" data-allow-clear="true" required>
                                <option value="" disabled selected></option>
                              </select>
                              <label for="cmbtransportista" class="form-label">Transportista (*)</label>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-floating form-floating-outline">
                              <select name="cmbchofer" id="cmbchofer" class="select2 form-select" tabindex="104" data-allow-clear="true" required>
                                <option value="" disabled selected></option>
                              </select>
                              <label for="cmbchofer" class="form-label">Chofer (*)</label>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-floating form-floating-outline">
                              <select name="cmbvehiculo" id="cmbvehiculo" class="select2 form-select" tabindex="105" data-allow-clear="true" required>
                                <option value="" disabled selected></option>
                              </select>
                              <label for="cmbvehiculo" class="form-label">Vehículo (*)</label>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-floating form-floating-outline">
                              <input type="number" class="form-control" id="txtkilometraje" name="txtkilometraje" tabindex="106" min="0">
                              <label for="txtkilometraje">Kilometraje</label>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6">
                              <input type="text" class="form-control mayus" id="txtobs" name="txtobs" tabindex="107" placeholder="" autocomplete="off">
                              <label for="txtobs">Observaci&oacute;n</label>
                            </div>
                          </div>
                        </div>
                        <div class="pt-6">
                          <button type="button" id="btnsave" name="btnsave" tabindex="108" class="btn btn-primary me-4 waves-effect waves-light">Guardar</button>
                          <button type="button" id="btnclose_" name="btnclose_" tabindex="109" class="btn btn-outline-secondary waves-effect">Cancelar</button>
                          <input name="operacion" type="hidden" id="operacion" value="" />
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
    <script src="<?php echo base_url();?>/content/template/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/js/main.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/js/forms-selects.js"></script>
    <script src="<?php echo base_url();?>/scripts/variables_globales.js"></script>
    <script src="<?php echo base_url();?>/scripts/jquery.general.js"></script>
    <script src="<?php echo base_url();?>/scripts/cola.js"></script>
</body>
</html>