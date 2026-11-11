<?php   
  $arreglousuario  = $Model_usuario;
  $var_desde = empty($par_desde) ? "" : $par_desde;
  $var_hasta = empty($par_hasta) ? "" : $par_hasta;
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
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="robots" content="noindex, nofollow" />
    <title>Demo: Dashboard - Analytics | Materialize - Bootstrap Dashboard PRO</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo base_url();?>/content/template/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap" /> 
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/assets/vendor/fonts/iconify-icons.css" />

    <!-- Core CSS del Template -->
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/assets/vendor/libs/pickr/pickr-themes.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/assets/vendor/css/core.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/assets/css/demo.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS Vendors -->
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/assets/vendor/css/pages/page-icons.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/assets/vendor/libs/apex-charts/apex-charts.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/assets/vendor/libs/swiper/swiper.css" />

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/assets/vendor/libs/select2/select2.css" />

    <!-- DataTables y Personalizados CSS -->
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/librerias/datatables/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/librerias/datatables/responsive/2.5.0/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/librerias/datatables/buttons/2.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/librerias/cloudflare/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/librerias/css/datatable-custom.css" />

    <!-- Estilos Propios / Personalizados (SIEMPRE AL FINAL) -->
    <link rel="stylesheet" href="<?php echo base_url();?>/content/template/bootstrap/css/bootstrap_style.css" />  
    <link rel="stylesheet" href="<?php echo base_url();?>/content/css/listaromana.css" />      

    <!-- Helpers -->
    <script src="<?php echo base_url();?>/content/template/assets/vendor/js/helpers.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/vendor/js/template-customizer.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/js/config.js"></script>

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
                      <img src="<?php echo base_url();?>/content/template/assets/img/avatars/<?=$arreglousuario[0]["avatar"];?>" alt="avatar" class="rounded-circle">
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item waves-effect" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="<?php echo base_url();?>/content/template/assets/img/avatars/<?=$arreglousuario[0]["avatar"];?>" alt="avatar" class="w-px-40 h-auto rounded-circle">
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <h6 class="mb-0"><?=$arreglousuario[0]["usuario"];?></h6>
                            <small class="text-body-secondary"><?=$arreglousuario[0]["usuario"];?></small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider my-1"></div>
                    </li>
                    <li>
                      <div class="d-grid px-4 pt-2 pb-1">
                        <a href="<?php echo base_url('LoginController/cerrar_sesion');?>" class="btn btn-danger d-flex waves-effect waves-light">Desconectar</a>
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

              <!-- ****************************************************************************** -->
              <!-- Filtro -->
              <!-- ****************************************************************************** -->
              <form id="form1" name="form1" class="mb-5" method="POST" action="" onsubmit="return false">
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
                      <label for="txtdesde">Hasta</label>
                    </div>
                  </div>

                  <div class="col-md-2">
                    <div class="form-floating form-floating-outline">
                      <select name="cmbcondicion" id="cmbcondicion" class="select2 form-select" tabindex="104" data-allow-clear="true" required>
                        <option value="" disabled selected></option>
                      </select>
                      <label for="cmbcondicion" class="form-label">Condición</label>
                    </div>
                  </div>

                  <div class="col-md-1">
                    <div class="form-floating form-floating-outline mb-6">
                      <button class="btn btn-success anim-btn" id="btnfilter" name="btnfilter" tabindex="103" type="button" title="Filtrar" onclick="fn_filter()">    
                          <span class="glyphicon glyphicon-search"></span>
                          <span id="txt-btnfilter"></span>
                      </button>
                    </div>
                  </div>  

                </div>
              </form>

              <!-- ****************************************************************************** -->
              <!-- Card Border Shadow -->
              <!-- ****************************************************************************** -->
              <div class="row g-6">                

                <div class="col-sm-6 col-lg-3">
                  <div class="card card-border-shadow-primary h-100">
                    <div class="card-body">
                      <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                          <span class="avatar-initial rounded-3 bg-label-primary">
                            <i class="icon-base ri ri-home-line icon-24px"></i>
                          </span>
                        </div>
                        <h4 id="kpi1_total_kg_p" class="mb-0"></h4>
                      </div>
                      <h6 class="mb-0 fw-normal">Total Recepción (Propio) </h6>
                      <p class="mb-0">
                        <span id="kpi1_porc_kg_p" class="me-1 fw-medium"></span>
                        <small class="text-body-secondary">Acondicionado...</small>
                      </p>
                    </div>
                  </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                  <div class="card card-border-shadow-warning h-100">
                    <div class="card-body">
                      <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                          <span class="avatar-initial rounded-3 bg-label-warning">
                            <i class="icon-base ri ri-alert-line icon-24px"></i>
                          </span>
                        </div>
                        <h4 id="kpi1_total_kg_c" class="mb-0"></h4>
                      </div>
                      <h6 class="mb-0 fw-normal">Total Recepción (Consignación) </h6>
                      <p class="mb-0">
                        <span id="kpi1_porc_kg_c" class="me-1 fw-medium"></span>
                        <small class="text-body-secondary">Acondicionado...</small>
                      </p>
                    </div>
                  </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                  <div class="card card-border-shadow-danger h-100">
                    <div class="card-body">
                      <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                          <span class="avatar-initial rounded-3 bg-label-danger">
                            <i class="icon-base ri ri-truck-line icon-24px"></i>
                          </span>
                        </div>
                        <h4 id="kpi3_total_vehiculo_p" class="mb-0"></h4>
                      </div>
                      <h6 class="mb-0 fw-normal">Total Entrada (Veh&iacute;culos) </h6>
                      <p class="mb-0">
                        <span id="kpi3_porc_vehiculo_p" class="me-1 fw-medium"></span>
                        <small class="text-body-secondary">Sin salida...</small>
                      </p>
                    </div>
                  </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                  <div class="card card-border-shadow-info h-100">
                    <div class="card-body">
                      <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                          <span class="avatar-initial rounded-3 bg-label-info">
                            <i class="icon-base ri ri-time-line icon-24px"></i>
                          </span>
                        </div>
                        <h4 class="mb-0" id="promedioTiempo">00:00:00</h4>
                      </div>
                      <h6 class="mb-0 fw-normal">Tiempo Promedio Proceso</h6>
                      <p class="mb-0">
                        <span class="me-1 fw-medium">Control</span>
                        <small class="text-body-secondary">de Tiempos</small>
                      </p>
                    </div>
                  </div>
                </div>

                <!-- -------------------------------------------------------------------------------- -->
                <!-- INICIO LISTADO Resumen de Entradas por Almacén -->
                <!-- -------------------------------------------------------------------------------- -->
                <div class="col-xxl-6 order-0 order-xxl-0">
                  <div class="card h-100">
                    <div class="card-header d-flex flex-column align-items-stretch pb-0">
                      
                      <!-- Fila superior: Título a la izquierda y Dropdown (3 punticos) a la derecha -->
                      <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="card-title mb-0">
                          <h5 class="m-0 me-2">Entradas por Almac&eacute;n (Resumén)</h5>
                        </div>
                        <div class="dropdown">
                          <button
                            class="btn btn-text-secondary rounded-pill text-body-secondary border-0 p-1"
                            type="button"
                            id="deliveryExceptionsAlmacen"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                            <i class="icon-base ri ri-more-2-line"></i>
                          </button>
                          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="deliveryExceptionsAlmacen">
                            <a class="dropdown-item" href="javascript:void(0);">Mostrar detalle...</a>
                            <a class="dropdown-item" href="javascript:void(0);">Refrescar...</a>
                          </div>
                        </div>
                      </div>

                      <!-- Pestañas (Tabs) de Filtrado integradas -->
                      <ul class="nav nav-tabs nav-fill w-100 border-bottom-0 mt-2" id="almacenesTabs" role="tablist">
                          <li class="nav-item" role="presentation">
                              <button class="nav-link active fw-semibold" id="tab-almacen-propio" data-tab="propio" type="button" onclick="cambiarTabAlmacenes('propio')">
                                  Propio
                              </button>
                          </li>
                          <li class="nav-item" role="presentation">
                              <button class="nav-link fw-semibold" id="tab-almacen-consignacion" data-tab="consignacion" type="button" onclick="cambiarTabAlmacenes('consignacion')">
                                  Consignaci&oacute;n
                              </button>
                          </li>
                      </ul>

                    </div>

                    <div class="card-body pb-2 pt-3">                      
                      <table id="example" class="display responsive nowrap" style="width:90%">
                          <thead>
                              <tr>
                                  <th class="all">Almacén</th>
                                  <th class="all">Descripción</th>
                                  <th class="desktop">Vehículos</th>
                                  <th class="desktop">Kilos</th>
                              </tr>
                          </thead>
                          <tbody></tbody>
                          <tfoot>
                              <tr>
                                  <th></th>
                                  <th></th>
                                  <th id="total1_cont_general"></th>
                                  <th id="total1_kg_general"></th>
                              </tr>
                          </tfoot>     
                      </table>

                      <div class="card-footer bg-light py-3 border-top d-flex d-md-none justify-content-between align-items-center">
                          <span class="fw-bold text-dark"></span>
                          <div class="d-flex gap-4">
                              <span class="fw-bold text-dark">Vehículos: 
                                <span id="total2_cont_general" class="text-primary"></span>
                              </span>
                              <span class="fw-bold text-dark">Kilos: 
                                <span id="total2_kg_general" class="text-success"></span>
                              </span>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- -------------------------------------------------------------------------------- -->
                <!-- INICIO LISTADO Promedio de Análisis de Calidad -->
                <!-- -------------------------------------------------------------------------------- -->
                <div class="col-lg-6 col-xxl-6 order-1 order-xxl-1">
                  <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <div class="card-title mb-0">
                        <h5 class="m-0 me-2 mb-1">Promedio de Análisis de Calidad</h5>
                        <p class="card-subtitle mb-0">Cálculo basado en el rango de fecha...</p>
                      </div>
                      <div class="dropdown">
                        <button
                          class="btn btn-text-secondary rounded-pill text-body-secondary border-0 p-1"
                          type="button"
                          id="deliveryExceptions"
                          data-bs-toggle="dropdown"
                          aria-haspopup="true"
                          aria-expanded="false">
                          <i class="icon-base ri ri-more-2-line"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="deliveryExceptions">
                          <a class="dropdown-item" href="javascript:void(0);">Mostrar detalle...</a>
                          <a class="dropdown-item" href="javascript:void(0);">Refrescar...</a>
                        </div>
                      </div>
                    </div>
                    <div class="card-body">
                      <div id="shipmentStatisticsChart"></div>
                    </div>
                  </div>
                </div>

                <!-- -------------------------------------------------------------------------------- -->
                <!-- INICIO LISTADO Control de Vehiculos -->
                <!-- -------------------------------------------------------------------------------- -->
                <div class="col-xxl-8 order-2 order-xxl-2">
                  <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <div class="card-title mb-0">
                        <h5 class="m-0 me-2">Control de Vehículos (Actual)</h5>
                      </div>
                      <div class="dropdown">
                        <button
                          class="btn btn-text-secondary rounded-pill text-body-secondary border-0 p-1"
                          type="button"
                          id="deliveryExceptions"
                          data-bs-toggle="dropdown"
                          aria-haspopup="true"
                          aria-expanded="false">
                          <i class="icon-base ri ri-more-2-line"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="deliveryExceptions">
                          <a class="dropdown-item" href="javascript:void(0);">Mostrar detalle...</a>
                          <a class="dropdown-item" href="javascript:void(0);">Refrescar...</a>
                        </div>
                      </div>
                    </div>

                    <div class="card-body pb-2">                      
                      <div class="cv-container">
                        <!-- Columna 1: Control de Recepción -->
                        <div class="cv-column">
                            <div class="cv-column-header cv-header-recepcion">
                                <span>Control de Recepción</span>
                                <span class="badge bg-secondary badge-sm" id="cv-count-recepcion">0</span>
                            </div>
                            <div class="cv-cards-container" id="cv-cards-recepcion"></div>
                            <div class="cv-column-footer">
                                <button class="cv-pagination-btn" id="cv-btn-prev-recepcion" onclick="cvCambiarPagina('recepcion', -1)">Anterior</button>
                                <span id="cv-page-info-recepcion">Pág 1 de 1</span>
                                <button class="cv-pagination-btn" id="cv-btn-next-recepcion" onclick="cvCambiarPagina('recepcion', 1)">Siguiente</button>
                            </div>
                        </div>

                        <!-- Columna 2: Roto de Muestreo -->
                        <div class="cv-column">
                            <div class="cv-column-header cv-header-muestreo">
                                <span>Roto de Muestreo</span>
                                <span class="badge bg-secondary badge-sm" id="cv-count-muestreo">0</span>
                            </div>
                            <div class="cv-cards-container" id="cv-cards-muestreo"></div>
                            <div class="cv-column-footer">
                                <button class="cv-pagination-btn" id="cv-btn-prev-muestreo" onclick="cvCambiarPagina('muestreo', -1)">Anterior</button>
                                <span id="cv-page-info-muestreo">Pág 1 de 1</span>
                                <button class="cv-pagination-btn" id="cv-btn-next-muestreo" onclick="cvCambiarPagina('muestreo', 1)">Siguiente</button>
                            </div>
                        </div>

                        <!-- Columna 3: Pesaje de Entrada -->
                        <div class="cv-column">
                            <div class="cv-column-header cv-header-pesaje">
                                <span>Pesaje de Entrada</span>
                                <span class="badge bg-secondary badge-sm" id="cv-count-pesaje">0</span>
                            </div>
                            <div class="cv-cards-container" id="cv-cards-pesaje"></div>
                            <div class="cv-column-footer">
                                <button class="cv-pagination-btn" id="cv-btn-prev-pesaje" onclick="cvCambiarPagina('pesaje', -1)">Anterior</button>
                                <span id="cv-page-info-pesaje">Pág 1 de 1</span>
                                <button class="cv-pagination-btn" id="cv-btn-next-pesaje" onclick="cvCambiarPagina('pesaje', 1)">Siguiente</button>
                            </div>
                        </div>

                        <!-- Columna 4: Descargado -->
                        <div class="cv-column">
                            <div class="cv-column-header cv-header-descargado">
                                <span>Descargado</span>
                                <span class="badge bg-secondary badge-sm" id="cv-count-descargado">0</span>
                            </div>
                            <div class="cv-cards-container" id="cv-cards-descargado"></div>
                            <div class="cv-column-footer">
                                <button class="cv-pagination-btn" id="cv-btn-prev-descargado" onclick="cvCambiarPagina('descargado', -1)">Anterior</button>
                                <span id="cv-page-info-descargado">Pág 1 de 1</span>
                                <button class="cv-pagination-btn" id="cv-btn-next-descargado" onclick="cvCambiarPagina('descargado', 1)">Siguiente</button>
                            </div>
                        </div>
                    </div>
                    </div>
                  </div>
                </div>

                <!-- -------------------------------------------------------------------------------- -->
                <!-- INICIO TARJETA: TOP 5 PROVEEDORES (LISTA MODERNA) -->
                <!-- -------------------------------------------------------------------------------- -->
                <div class="col-xxl-4 order-2 order-xxl-2">
                  <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <div class="card-title mb-0">
                        <h5 class="m-0 me-2">Top 5 Proveedores (Recepción)</h5>
                      </div>
                      <div class="dropdown">
                        <button
                          class="btn btn-text-secondary rounded-pill text-body-secondary border-0 p-1"
                          type="button"
                          id="topProveedoresDropdown"
                          data-bs-toggle="dropdown"
                          aria-haspopup="true"
                          aria-expanded="false">
                          <i class="icon-base ri ri-more-2-line"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="topProveedoresDropdown">
                          <a class="dropdown-item" href="javascript:void(0);">Mostrar detalle...</a>
                          <a class="dropdown-item" href="javascript:void(0);">Refrescar...</a>
                        </div>
                      </div>
                    </div>

                    <div class="card-body pb-3">
                      <div id="topProveedoresList" class="d-flex flex-column gap-3"></div>
                    </div>
                  </div>
                </div>

                <!-- -------------------------------------------------------------------------------- -->
                <!-- INICIO LISTADO Vehículos (LADO IZQUIERDO - 8 COLS) -->
                <!-- -------------------------------------------------------------------------------- -->
                <div class="col-lg-8 col-xxl-8 order-5 order-xxl-5">
                  <div class="card h-100">
                    <div class="card-header d-flex flex-column align-items-stretch pb-0">
                        
                        <!-- Fila superior: Título a la izquierda y Botones de Excel/Imprimir a la derecha (en PC) -->
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="card-title mb-0">
                                <h5 class="m-0">Listado de Recepción</h5>
                            </div>
                            <!-- Contenedor para los botones con ocultamiento automático en móviles -->
                            <div id="export-buttons-container" class="d-none d-md-block"></div>
                        </div>
                        
                        <!-- Pestañas (Tabs) de Filtrado integradas abajo -->
                        <ul class="nav nav-tabs nav-fill w-100 border-bottom-0 mt-2" id="vehiculosTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active fw-semibold" id="tab-descargado" data-tab="descargado" type="button" onclick="cambiarTabVehiculos('descargado')">
                                    Completado
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-semibold" id="tab-recepcion" data-tab="recepcion" type="button" onclick="cambiarTabVehiculos('recepcion')">
                                    Control Recepción
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-semibold" id="tab-pesaje" data-tab="pesaje" type="button" onclick="cambiarTabVehiculos('pesaje')">
                                    Pesaje de Entrada
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body pt-3">     
                      <table id="datatable_vehiculo" class="display responsive nowrap" style="width:100%">
                          <thead>
                              <tr>         
                                  <th class="all">Ticket</th>
                                  <th class="all">Boleto</th>
                                  <th class="all">Entrada</th>
                                  <th class="desktop">Salida</th>
                                  <th class="none">Tiempo</th>
                                  <th class="none">Organización</th>
                                  <th class="none">Almacén</th>
                                  <th class="none">Neto</th>
                                  <th class="all">Acond.</th>
                                  <th class="none">Transportista</th>
                                  <th class="none">Chofer</th>
                                  <th class="none">Vehículo</th>
                                  <th class="none">HMD</th>
                                  <th class="none">IMP</th>
                              </tr>
                          </thead>
                          <tbody></tbody>
                          <tfoot>
                              <tr>
                                  <th></th>
                                  <th></th>
                                  <th id="total3_cont_general"></th>                        
                                  <th id="total3_kg_general"></th>
                                  <th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>
                              </tr>
                          </tfoot>     
                      </table>

                      <div class="card-footer bg-light py-3 border-top d-flex d-md-none justify-content-between align-items-center mt-3">
                          <span class="fw-bold text-dark"></span>
                          <div class="d-flex gap-4">
                              <span class="fw-bold text-dark">Vehículos: 
                                <span id="total4_cont_general" class="text-primary"></span>
                              </span>
                              <span class="fw-bold text-dark">Kilos: 
                                <span id="total4_kg_general" class="text-success"></span>
                              </span>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- -------------------------------------------------------------------------------- -->
                <!-- INICIO RESUMEN (LADO DERECHO - 4 COLS) -->
                <!-- -------------------------------------------------------------------------------- -->
                <div class="col-lg-4 col-xxl-4 order-5 order-xxl-5">
                  <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                      <div class="card-title mb-0">
                        <h5 class="m-0 me-2">Resumén</h5>
                        <span class="text-body mb-0">62 deliveries in progress</span>
                      </div>
                      <div class="dropdown">
                        <button
                          class="btn btn-text-secondary rounded-pill text-body-secondary border-0 p-1"
                          type="button"
                          id="ordersCountries"
                          data-bs-toggle="dropdown"
                          aria-haspopup="true"
                          aria-expanded="false">
                          <i class="icon-base ri ri-more-2-line"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="ordersCountries">
                          <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                          <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                          <a class="dropdown-item" href="javascript:void(0);">Share</a>
                        </div>
                      </div>
                    </div>
                    <div class="card-body p-0">
                      <div class="nav-align-top">
                        <ul class="nav nav-tabs nav-fill" role="tablist">
                          <li class="nav-item">
                            <button
                              type="button"
                              class="nav-link active"
                              role="tab"
                              data-bs-toggle="tab"
                              data-bs-target="#navs-justified-new"
                              aria-controls="navs-justified-new"
                              aria-selected="true">
                              Organización
                            </button>
                          </li>
                          <li class="nav-item">
                            <button
                              type="button"
                              class="nav-link"
                              role="tab"
                              data-bs-toggle="tab"
                              data-bs-target="#navs-justified-link-preparing"
                              aria-controls="navs-justified-link-preparing"
                              aria-selected="false">
                              Transportista
                            </button>
                          </li>
                          <li class="nav-item">
                            <button
                              type="button"
                              class="nav-link"
                              role="tab"
                              data-bs-toggle="tab"
                              data-bs-target="#navs-justified-link-shipping"
                              aria-controls="navs-justified-link-shipping"
                              aria-selected="false">
                              Otros
                            </button>
                          </li>
                        </ul>
                        <div class="tab-content border-0 pb-0 px-6 mx-1">
                          <div class="tab-pane fade show active" id="navs-justified-new" role="tabpanel">
                            <ul class="timeline mb-0">
                              <li class="timeline-item ps-6 border-dashed">
                                <span class="timeline-indicator-advanced border-0 shadow-none">
                                  <i class="icon-base ri ri-checkbox-circle-line text-success"></i>
                                </span>
                                <div class="timeline-event ps-1">
                                  <div class="timeline-header">
                                    <small class="text-success text-uppercase">sender</small>
                                  </div>
                                  <h6 class="my-50">Myrtle Ullrich</h6>
                                  <p class="mb-0 small">101 Boulder, California(CA), 95959</p>
                                </div>
                              </li>
                              <li class="timeline-item ps-6 border-transparent">
                                <span class="timeline-indicator-advanced text-primary border-0 shadow-none">
                                  <i class="icon-base ri ri-map-pin-line"></i>
                                </span>
                                <div class="timeline-event ps-1">
                                  <div class="timeline-header">
                                    <small class="text-primary text-uppercase">Receiver</small>
                                  </div>
                                  <h6 class="my-50">Barry Schowalter</h6>
                                  <p class="mb-0 small">939 Orange, California(CA), 92118</p>
                                </div>
                              </li>
                            </ul>
                            <div class="border-1 border-light border-dashed mb-2"></div>
                            <ul class="timeline mb-0">
                              <li class="timeline-item ps-6 border-dashed">
                                <span class="timeline-indicator-advanced border-0 shadow-none">
                                  <i class="icon-base ri ri-checkbox-circle-line text-success"></i>
                                </span>
                                <div class="timeline-event ps-1">
                                  <div class="timeline-header">
                                    <small class="text-success text-uppercase">sender</small>
                                  </div>
                                  <h6 class="my-50">Veronica Herman</h6>
                                  <p class="mb-0 small">162 Windsor, California(CA), 95492</p>
                                </div>
                              </li>
                              <li class="timeline-item ps-6 border-transparent">
                                <span class="timeline-indicator-advanced text-primary border-0 shadow-none">
                                  <i class="icon-base ri ri-map-pin-line"></i>
                                </span>
                                <div class="timeline-event ps-1">
                                  <div class="timeline-header">
                                    <small class="text-primary text-uppercase">Receiver</small>
                                  </div>
                                  <h6 class="my-50">Helen Jacobs</h6>
                                  <p class="mb-0 small">487 Sunset, California(CA), 94043</p>
                                </div>
                              </li>
                            </ul>
                          </div>
                          <div class="tab-pane fade" id="navs-justified-link-preparing" role="tabpanel">
                            <ul class="timeline mb-0">
                              <li class="timeline-item ps-6 border-dashed">
                                <span class="timeline-indicator-advanced border-0 shadow-none">
                                  <i class="icon-base ri ri-checkbox-circle-line text-success"></i>
                                </span>
                                <div class="timeline-event ps-1">
                                  <div class="timeline-header">
                                    <small class="text-success text-uppercase">sender</small>
                                  </div>
                                  <h6 class="my-50">Barry Schowalter</h6>
                                  <p class="mb-0 small">939 Orange, California(CA), 92118</p>
                                </div>
                              </li>
                              <li class="timeline-item ps-6 border-transparent border-dashed">
                                <span class="timeline-indicator-advanced text-primary border-0 shadow-none">
                                  <i class="icon-base ri ri-map-pin-line"></i>
                                </span>
                                <div class="timeline-event ps-1">
                                  <div class="timeline-header">
                                    <small class="text-primary text-uppercase">Receiver</small>
                                  </div>
                                  <h6 class="my-50">Myrtle Ullrich</h6>
                                  <p class="mb-0 small">101 Boulder, California(CA), 95959</p>
                                </div>
                              </li>
                            </ul>
                            <div class="border-1 border-light border-dashed mb-2"></div>
                            <ul class="timeline mb-0">
                              <li class="timeline-item ps-6 border-dashed">
                                <span class="timeline-indicator-advanced border-0 shadow-none">
                                  <i class="icon-base ri ri-checkbox-circle-line text-success"></i>
                                </span>
                                <div class="timeline-event ps-1">
                                  <div class="timeline-header">
                                    <small class="text-success text-uppercase">sender</small>
                                  </div>
                                  <h6 class="my-50">Veronica Herman</h6>
                                  <p class="mb-0 small">162 Windsor, California(CA), 95492</p>
                                </div>
                              </li>
                              <li class="timeline-item ps-6 border-transparent">
                                <span class="timeline-indicator-advanced text-primary border-0 shadow-none">
                                  <i class="icon-base ri ri-map-pin-line"></i>
                                </span>
                                <div class="timeline-event ps-1">
                                  <div class="timeline-header">
                                    <small class="text-primary text-uppercase">Receiver</small>
                                  </div>
                                  <h6 class="my-50">Helen Jacobs</h6>
                                  <p class="mb-0 small">487 Sunset, California(CA), 94043</p>
                                </div>
                              </li>
                            </ul>
                          </div>
                          <div class="tab-pane fade" id="navs-justified-link-shipping" role="tabpanel">
                            <ul class="timeline mb-0">
                              <li class="timeline-item ps-6 border-dashed">
                                <span class="timeline-indicator-advanced border-0 shadow-none">
                                  <i class="icon-base ri ri-checkbox-circle-line text-success"></i>
                                </span>
                                <div class="timeline-event ps-1">
                                  <div class="timeline-header">
                                    <small class="text-success text-uppercase">sender</small>
                                  </div>
                                  <h6 class="my-50">Veronica Herman</h6>
                                  <p class="mb-0 small">101 Boulder, California(CA), 95959</p>
                                </div>
                              </li>
                              <li class="timeline-item ps-6 border-transparent">
                                <span class="timeline-indicator-advanced text-primary border-0 shadow-none">
                                  <i class="icon-base ri ri-map-pin-line"></i>
                                </span>
                                <div class="timeline-event ps-1">
                                  <div class="timeline-header">
                                    <small class="text-primary text-uppercase">Receiver</small>
                                  </div>
                                  <h6 class="my-50">Barry Schowalter</h6>
                                  <p class="mb-0 small">939 Orange, California(CA), 92118</p>
                                </div>
                              </li>
                            </ul>
                            <div class="border-1 border-light border-dashed mb-2"></div>
                            <ul class="timeline mb-0">
                              <li class="timeline-item ps-6 border-dashed">
                                <span class="timeline-indicator-advanced border-0 shadow-none">
                                  <i class="icon-base ri ri-checkbox-circle-line text-success"></i>
                                </span>
                                <div class="timeline-event ps-1">
                                  <div class="timeline-header">
                                    <small class="text-success text-uppercase">sender</small>
                                  </div>
                                  <h6 class="my-50">Myrtle Ullrich</h6>
                                  <p class="mb-0 small">162 Windsor, California(CA), 95492</p>
                                </div>
                              </li>
                              <li class="timeline-item ps-6 border-transparent">
                                <span class="timeline-indicator-advanced text-primary border-0 shadow-none">
                                  <i class="icon-base ri ri-map-pin-line"></i>
                                </span>
                                <div class="timeline-event ps-1">
                                  <div class="timeline-header">
                                    <small class="text-primary text-uppercase">Receiver</small>
                                  </div>
                                  <h6 class="my-50">Helen Jacobs</h6>
                                  <p class="mb-0 small">487 Sunset, California(CA), 94043</p>
                                </div>
                              </li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
              </div>

            </div>
            <!-- / Content -->

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl">
                <div
                  class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                  <div class="mb-2 mb-md-0">
                    &#169;
                    <script>
                      document.write(new Date().getFullYear());
                    </script>
                    , made with ❤️ by
                    <a href="https://pixinvent.com" target="_blank" class="footer-link fw-medium">AlimentosDoñaEmilia</a>
                  </div>
                  <div class="d-none d-lg-inline-block">
                    <a href="https://themeforest.net/licenses/standard" class="footer-link me-4" target="_blank">License</a>
                    <a href="https://themeforest.net/user/pixinvent/portfolio" target="_blank" class="footer-link me-4">More Themes</a>
                    <a href="https://demos.pixinvent.com/materialize-html-admin-template/documentation/" target="_blank" class="footer-link me-4">Documentation</a>
                    <a href="https://pixinvent.ticksy.com/" target="_blank" class="footer-link d-none d-sm-inline-block">Support</a>
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

      <!-- Drag Target Area To SlideIn Menu On Small Screens -->
      <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- SCRIPTS ORDENADOS Y ÚNICOS -->
    <script src="<?php echo base_url();?>/content/template/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/vendor/libs/popper/popper.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/vendor/js/bootstrap.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/vendor/libs/@algolia/autocomplete-js.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/vendor/libs/pickr/pickr.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/vendor/libs/hammer/hammer.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/vendor/js/menu.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/vendor/libs/select2/select2.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/vendor/libs/apex-charts/apexcharts.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/vendor/libs/swiper/swiper.js"></script>
    <script src="<?php echo base_url();?>/content/template/librerias/datatables/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url();?>/content/template/librerias/datatables/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url();?>/content/template/librerias/datatables/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url();?>/content/template/librerias/cloudflare/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="<?php echo base_url();?>/content/template/librerias/cloudflare/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="<?php echo base_url();?>/content/template/librerias/cloudflare/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="<?php echo base_url();?>/content/template/librerias/datatables/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="<?php echo base_url();?>/content/template/librerias/datatables/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url();?>/content/template/librerias/datatables/buttons/2.4.1/js/buttons.colVis.min.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/js/main.js"></script>
    <script src="<?php echo base_url();?>/content/template/assets/js/dashboards-analytics.js"></script>
    <script src="<?php echo base_url();?>/scripts/variables_globales.js"></script>
    <script src="<?php echo base_url();?>/scripts/jquery.general.js"></script>
    <script src="<?php echo base_url();?>/scripts/listaromana.js"></script>

  </body>
</html>