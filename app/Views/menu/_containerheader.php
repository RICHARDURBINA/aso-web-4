<?php
$arreglousuario = isset($Model_usuario) && is_array($Model_usuario) ? $Model_usuario : [];

// Definir valores seguros por defecto si el arreglo está vacío
$avatar = !empty($arreglousuario[0]["avatar"]) ? $arreglousuario[0]["avatar"] : "default.png"; 
$nombreUsuario = !empty($arreglousuario[0]["usuario"]) ? $arreglousuario[0]["usuario"] : "Invitado";
?>

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
              <img src="<?php echo base_url();?>/content/template/assets/img/avatars/<?=$avatar;?>" alt="avatar" class="rounded-circle">
            </div>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li>
              <a class="dropdown-item waves-effect" href="#">
                <div class="d-flex">
                  <div class="flex-shrink-0 me-3">
                    <div class="avatar avatar-online">
                      <img src="<?php echo base_url();?>/content/template/assets/img/avatars/<?=$avatar;?>" alt="avatar" class="w-px-40 h-auto rounded-circle">
                    </div>
                  </div>
                  <div class="flex-grow-1">
                    <h6 class="mb-0"><?=$nombreUsuario;?></h6>
                    <small class="text-body-secondary"><?=$nombreUsuario;?></small>
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