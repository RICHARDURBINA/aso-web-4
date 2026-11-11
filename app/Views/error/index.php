<?php 
    $arreglousuario = $Model_usuario ?? [];
    $mensaje_error  = $msn ?? "Ha ocurrido un error inesperado en el sistema.";
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
    <title>Error | Pedidos Web Asoportuguesa</title>
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

    <!-- Page CSS -->
    <link rel="stylesheet" href="<?php echo base_url();?>/content/css/generales.css" />

    <style type="text/css">
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

              <div class="col-md-12">
                <div class="card border-danger">
                  <h5 class="card-header bg-danger text-white">Error en la Aplicación</h5>
                  <div class="card-body mt-4">
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                      <i class="icon-base ri ri-error-warning-line me-2 icon-24px"></i>
                      <div>
                        <strong>Ha ocurrido un inconveniente:</strong><br>
                        <?php echo htmlspecialchars($mensaje_error); ?>
                      </div>
                    </div>

                    <div class="pt-4">
                      <button type="button" onclick="window.history.back();" class="btn btn-primary waves-effect waves-light">
                        <i class="icon-base ri ri-arrow-left-line me-1"></i> Volver Atrás
                      </button>
                      <a href="<?= base_url('MenuController/menu') ?>" class="btn btn-outline-secondary waves-effect me-2">
                        <i class="icon-base ri ri-home-smile-line me-1"></i> Ir al Inicio
                      </a>
                    </div>

                  </div>
                </div>
              </div>

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

    <!-- Main JS -->
    <script src="<?php echo base_url();?>/content/template/assets/js/main.js"></script>
</body>
</html>