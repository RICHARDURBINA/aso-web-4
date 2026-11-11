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
  data-assets-path="assets/"
  data-template="vertical-menu-template-no-customizer-starter">
<head>
    <title>Pedidos Web | Asoportuguesa</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, minimum-scale=1">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('content/template/assets/img/favicon/favicon.ico') ?>" />

    <link rel="stylesheet" href="<?= base_url('content/template/assets/vendor/fonts/iconify-icons.css') ?>" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?= base_url('content/template/assets/vendor/libs/node-waves/node-waves.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('content/template/assets/vendor/css/core.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('content/template/assets/css/demo.css') ?>" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?= base_url('content/template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') ?>" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="<?= base_url('content/template/assets/vendor/css/pages/page-icons.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('content/template/assets/vendor/libs/select2/select2.css') ?>" />

    <style>
      @media (max-width: 767.98px) {
          #icons-container .icon-card {
              inline-size: 100px;
          }
      }
    </style>

</head>
<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        
        <!-- Menu Lateral (Sustituido el $this->load->view por la función nativa view() de CI4) -->
        <?= view('menu/_containerleftservicio') ?>
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
                      <img src="<?= base_url('content/template/assets/img/avatars/' . $arreglousuario[0]["avatar"]) ?>" alt="avatar" class="rounded-circle">
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item waves-effect" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="<?= base_url('content/template/assets/img/avatars/' . $arreglousuario[0]["avatar"]) ?>" alt="avatar" class="w-px-40 h-auto rounded-circle">
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <h6 class="mb-0"><?= $arreglousuario[0]["usuario"] ?></h6>
                            <small class="text-body-secondary"><?= $arreglousuario[0]["usuario"] ?></small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider my-1"></div>
                    </li>
                    <li>
                      <div class="d-grid px-4 pt-2 pb-1">
                        <a href="<?= base_url('LoginController/cerrar_sesion') ?>" class="btn btn-danger d-flex waves-effect waves-light">Desconectar</a>
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
              <div class="d-flex flex-wrap" id="icons-container">
                <a href="<?= base_url('MenuController/menu') ?>">
                  <div class="card icon-card cursor-pointer text-center mb-6 mx-3">
                    <div class="card-body">
                      <i class="icon-base ri ri-home-4-fill icon-36px"></i>
                      <p class="icon-name text-capitalize text-truncate mb-0 mt-2">inicio</p>
                    </div>
                  </div>
                </a>

                <?php
                if($arreglousuario[0]["pedido_registro"] == 1)
                {
                ?>
                <a href="<?= base_url('PedidoController/pedido') ?>">
                  <div class="card icon-card cursor-pointer text-center mb-6 mx-3">
                    <div class="card-body">
                      <i class="icon-base ri ri-smartphone-fill icon-36px"></i>
                      <p class="icon-name text-capitalize text-truncate mb-0 mt-2">Pedido</p>
                    </div>
                  </div>
                </a>
                <?php
                }
                if($arreglousuario[0]["visita_registro"] == 1)
                {
                ?>
                <a href="<?= base_url('VisitaController/visita') ?>">
                  <div class="card icon-card cursor-pointer text-center mb-6 mx-3">
                    <div class="card-body">
                      <i class="icon-base ri ri-community-fill icon-36px"></i>
                      <p class="icon-name text-capitalize text-truncate mb-0 mt-2">Visita</p>
                    </div>
                  </div>
                </a>
                <?php
                }
                if($arreglousuario[0]["cobranza_registro"] == 1)
                {
                ?>
                <a href="<?= base_url('CobranzaController/cobranza') ?>">
                  <div class="card icon-card cursor-pointer text-center mb-6 mx-3">
                    <div class="card-body">
                      <i class="icon-base ri ri-money-dollar-box-fill icon-36px"></i>
                      <p class="icon-name text-capitalize text-truncate mb-0 mt-2">Cobranza</p>
                    </div>
                  </div>
                </a>
                <?php
                }

                if($arreglousuario[0]["cola_registro"] == 1)
                {
                ?>
                <a href="<?= base_url('ColaController/cola') ?>">
                  <div class="card icon-card cursor-pointer text-center mb-6 mx-3">
                    <div class="card-body">
                      <i class="icon-base ri ri-clockwise-line icon-36px"></i>
                      <p class="icon-name text-capitalize text-truncate mb-0 mt-2">Cola</p>
                    </div>
                  </div>
                </a>
                <?php
                }
                if($arreglousuario[0]["chofer_listar"] == 1)
                {
                ?>
                <a href="<?= base_url('ChoferController/listachofer') ?>">
                  <div class="card icon-card cursor-pointer text-center mb-6 mx-3">
                    <div class="card-body">
                      <i class="icon-base ri ri-user-3-line icon-36px"></i>
                      <p class="icon-name text-capitalize text-truncate mb-0 mt-2">Gesti&oacute;n Chofer</p>
                    </div>
                  </div>
                </a>
                <?php
                }
                if($arreglousuario[0]["vehiculo_listar"] == 1)
                {
                ?>
                <a href="<?= base_url('VehiculoController/listavehiculo') ?>">
                  <div class="card icon-card cursor-pointer text-center mb-6 mx-3">
                    <div class="card-body">
                      <i class="icon-base ri ri-truck-line icon-36px"></i>
                      <p class="icon-name text-capitalize text-truncate mb-0 mt-2">Gesti&oacute;n Veh&iacute;culo</p>
                    </div>
                  </div>
                </a>
                <?php
                }
                if(($arreglousuario[0]["plan_registro"] == 1) || ($arreglousuario[0]["plan_consulta"] == 1))
                {
                ?>
                <a href="<?= base_url('PlanController/planpedido') ?>">
                  <div class="card icon-card cursor-pointer text-center mb-6 mx-3">
                    <div class="card-body">
                      <i class="icon-base ri ri-settings-4-line icon-36px"></i>
                      <p class="icon-name text-capitalize text-truncate mb-0 mt-2">Plan de Despacho</p>
                    </div>
                  </div>
                </a>
                <?php
                }

                if($arreglousuario[0]["pedido_listar"] == 1)
                {
                ?>
                <a href="<?= base_url('PedidoController/listapedido') ?>">
                  <div class="card icon-card cursor-pointer text-center mb-6 mx-3">
                    <div class="card-body">
                      <i class="icon-base ri ri-file-list-fill icon-36px"></i>
                      <p class="icon-name text-capitalize text-truncate mb-0 mt-2">Gesti&oacute;n Pedidos</p>
                    </div>
                  </div>
                </a>
                <?php
                }
                if($arreglousuario[0]["visita_listar"] == 1)
                {
                ?>
                <a href="<?= base_url('VisitaController/listavisita') ?>">
                  <div class="card icon-card cursor-pointer text-center mb-6 mx-3">
                    <div class="card-body">
                      <i class="icon-base ri ri-file-list-fill icon-36px"></i>
                      <p class="icon-name text-capitalize text-truncate mb-0 mt-2">Gesti&oacute;n Visitas</p>
                    </div>
                  </div>
                </a>
                <a href="<?= base_url('VisitaController/ultimavisita') ?>">
                  <div class="card icon-card cursor-pointer text-center mb-6 mx-3">
                    <div class="card-body">
                      <i class="icon-base ri ri-file-list-fill icon-36px"></i>
                      <p class="icon-name text-capitalize text-truncate mb-0 mt-2">Ultima Visita</p>
                    </div>
                  </div>
                </a>
                <a href="<?= base_url('VisitaController/visita_productos_terceros') ?>">
                  <div class="card icon-card cursor-pointer text-center mb-6 mx-3">
                    <div class="card-body">
                      <i class="icon-base ri ri-file-list-fill icon-36px"></i>
                      <p class="icon-name text-capitalize text-truncate mb-0 mt-2">Visita Productos Terc.</p>
                    </div>
                  </div>
                </a>
                <?php
                }
                if($arreglousuario[0]["cobranza_listar"] == 1)
                {
                ?>
                <a href="<?= base_url('CobranzaController/listacobranza') ?>">
                  <div class="card icon-card cursor-pointer text-center mb-6 mx-3">
                    <div class="card-body">
                      <i class="icon-base ri ri-file-list-fill icon-36px"></i>
                      <p class="icon-name text-capitalize text-truncate mb-0 mt-2">Gesti&oacute;n Cobranzas</p>
                    </div>
                  </div>
                </a>
                <?php
                }
                if($arreglousuario[0]["cola_listar"] == 1)
                {
                ?>
                <a href="<?= base_url('ColaController/listacola') ?>">
                  <div class="card icon-card cursor-pointer text-center mb-6 mx-3">
                    <div class="card-body">
                      <i class="icon-base ri ri-file-list-fill icon-36px"></i>
                      <p class="icon-name text-capitalize text-truncate mb-0 mt-2">Gesti&oacute;n Cola</p>
                    </div>
                  </div>
                </a>
                <?php
                }
                if(($arreglousuario[0]["plan_asociar"] == 1) || ($arreglousuario[0]["plan_anular"] == 1))
                {
                ?>
                <a href="<?= base_url('PlanController/asociartransporte') ?>">
                  <div class="card icon-card cursor-pointer text-center mb-6 mx-3">
                    <div class="card-body">
                      <i class="icon-base ri ri-file-list-fill icon-36px"></i>
                      <p class="icon-name text-capitalize text-truncate mb-0 mt-2">Gesti&oacute;n de Transporte</p>
                    </div>
                  </div>
                </a>
                <?php
                }
                if($arreglousuario[0]["romana_listar"] == 1)
                {
                ?>
                <a href="<?= base_url('RomanaController/listaromana') ?>">
                  <div class="card icon-card cursor-pointer text-center mb-6 mx-3">
                    <div class="card-body">
                      <i class="icon-base ri ri-file-list-fill icon-36px"></i>
                      <p class="icon-name text-capitalize text-truncate mb-0 mt-2">Gesti&oacute;n de Romana</p>
                    </div>
                  </div>
                </a>
                <?php
                }
                if($arreglousuario[0]["plan_listar"] == 1)
                {
                ?>
                <a href="<?= base_url('PlanController/listaplanpedido') ?>">
                  <div class="card icon-card cursor-pointer text-center mb-6 mx-3">
                    <div class="card-body">
                      <i class="icon-base ri ri-file-list-fill icon-36px"></i>
                      <p class="icon-name text-capitalize text-truncate mb-0 mt-2">Listar Planificaci&oacute;n</p>
                    </div>
                  </div>
                </a>
                <?php
                }
                if($arreglousuario[0]["grafica"] == 1)
                {
                ?>
                <a href="<?= base_url('GraficaController/grafica') ?>">
                  <div class="card icon-card cursor-pointer text-center mb-6 mx-3">
                    <div class="card-body">
                      <i class="icon-base ri ri-airplay-fill icon-36px"></i>
                      <p class="icon-name text-capitalize text-truncate mb-0 mt-2">Estad&iacute;sticas Web</p>
                    </div>
                  </div>
                </a>
                <?php
                }
                if($arreglousuario[0]["resumen_producto"] == 1 || $arreglousuario[0]["resumen_transporte"] == 1)
                {
                ?>
                <a href="<?= base_url('GraficaController/resumen') ?>">
                  <div class="card icon-card cursor-pointer text-center mb-6 mx-3">
                    <div class="card-body">
                      <i class="icon-base ri ri-pie-chart-2-line icon-36px"></i>
                      <p class="icon-name text-capitalize text-truncate mb-0 mt-2">Resumen</p>
                    </div>
                  </div>
                </a>
                <?php
                }
                if($arreglousuario[0]["orden_registro"] == 1)
                {
                ?>
                <a href="javascript:fn_trasladar_ordenes()">
                  <div class="card icon-card cursor-pointer text-center mb-6 mx-3">
                    <div class="card-body">
                      <i class="icon-base ri ri-settings-4-line icon-36px"></i>
                      <p class="icon-name text-capitalize text-truncate mb-0 mt-2">Trasladar Ordenes</p>
                    </div>
                  </div>
                </a>
                <?php
                }
                ?>
                <a href="<?= base_url('LoginController/cerrar_sesion') ?>">
                  <div class="card icon-card cursor-pointer text-center mb-6 mx-3">
                    <div class="card-body">
                      <i class="icon-base ri ri-logout-box-fill icon-36px"></i>
                      <p class="icon-name text-capitalize text-truncate mb-0 mt-2">Cerrar</p>
                    </div>
                  </div>
                </a>

              </div>
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
        </div>
      </div>

      <div class="layout-overlay layout-menu-toggle"></div>
      <div class="drag-target"></div>
    </div>

    <!-- Scripts -->
    <script src="<?= base_url('content/template/assets/vendor/js/helpers.js') ?>"></script>
    <script src="<?= base_url('content/template/assets/js/config.js') ?>"></script>

    <script src="<?= base_url('content/template/assets/vendor/libs/jquery/jquery.js') ?>"></script>
    <script src="<?= base_url('content/template/assets/vendor/libs/popper/popper.js') ?>"></script>
    <script src="<?= base_url('content/template/assets/vendor/js/bootstrap.js') ?>"></script>
    <script src="<?= base_url('content/template/assets/vendor/libs/node-waves/node-waves.js') ?>"></script>
    <script src="<?= base_url('content/template/assets/vendor/libs/@algolia/autocomplete-js.js') ?>"></script>
    <script src="<?= base_url('content/template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') ?>"></script>
    <script src="<?= base_url('content/template/assets/vendor/libs/hammer/hammer.js') ?>"></script>
    <script src="<?= base_url('content/template/assets/vendor/js/menu.js') ?>"></script>

    <script src="<?= base_url('content/template/assets/vendor/libs/select2/select2.js') ?>"></script>
    <script src="<?= base_url('content/template/assets/js/main.js') ?>"></script>
    <script src="<?= base_url('content/template/assets/js/forms-selects.js') ?>"></script>
    
    <script src="<?= base_url('scripts/variables_globales.js') ?>"></script>
    <script src="<?= base_url('scripts/jquery.general.js') ?>"></script>
    <script src="<?= base_url('scripts/menu.js') ?>"></script>

</body>
</html>