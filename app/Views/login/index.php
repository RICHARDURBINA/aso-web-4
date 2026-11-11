<!DOCTYPE html>
<html lang="es">
<head>  
    <title>Pedidos Web | Asoportuguesa</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, minimum-scale=1">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('content/template/assets/img/favicon/favicon.ico') ?>" />

    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="<?= base_url('content/template/assets/vendor/fonts/iconify-icons.css') ?>" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?= base_url('content/template/assets/vendor/css/core.css') ?>" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="<?= base_url('content/template/assets/vendor/css/pages/page-auth.css') ?>" /> 

    <!-- General CSS -->
    <link rel="stylesheet" href="<?= base_url('content/css/generales.css') ?>" /> 
</head>

<body>  
    <!-- Content -->
    <div class="position-relative">
        <div class="authentication-wrapper authentication-basic container-p-y p-4 p-sm-0">
            <div class="authentication-inner py-6">
                <!-- Login -->
                <div class="card p-md-7 p-1">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center mt-5">
                      <a href="<?= base_url() ?>" class="app-brand-link gap-2">
                        <img src="<?= base_url('images/logo/logo.png') ?>" alt="Logo" width="70in">
                      </a>
                    </div>
                    <!-- /Logo -->

                    <div class="card-body mt-1">
                        <h4 class="mb-1">Bienvenidos al Portal de Pedidos Web! 👋</h4>
                        <br />

                        <form id="form1" name="form1" class="mb-5" method="POST" action="" onsubmit="return false">
                            
                            <!-- Token CSRF de seguridad de CI4 -->
                            <?= csrf_field() ?>

                            <div class="form-floating form-floating-outline mb-5 form-control-validation">
                                <input type="text" name="txtusuario" id="txtusuario" tabindex="1" class="form-control" autofocus required placeholder="Ingrese Usuario" autocomplete="off" maxlength="50" value="" />
                                <label for="txtusuario">Usuario</label>
                            </div>
                            <div class="mb-5">
                                <div class="form-password-toggle form-control-validation">
                                    <div class="input-group input-group-merge">
                                        <div class="form-floating form-floating-outline">
                                            <input type="password" name="txtclave" id="txtclave" tabindex="2" class="form-control" required placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" autocomplete="off" onkeypress="javascript:onPress_enter(this.form)" value="" />
                                            <label for="txtclave">Contraseña</label>
                                        </div>
                                        <span class="input-group-text cursor-pointer">
                                            <a href="javascript:mostrarcampo(this, 'txtclave', 'icono_eye')">
                                                <i id="icono_eye" class="icon-base ri ri-eye-off-line icon-20px"></i>
                                            </a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-5">
                                <div class="form-password-toggle form-control-validation">
                                    <div class="form-floating form-floating-outline mb-6">
                                        <select class="form-select" id="cmbempresa" name="cmbempresa" tabindex="3" required aria-label="Default select example">
                                            <option value="WEB">WEB</option>
                                            <option value="AAI">ALMACENADORA I</option>
                                            <option value="ADESA" selected>ALIMENTOS DOÑA EMILIA</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-5">
                                <button name="form1btnenviar" id="form1btnenviar" class="btn btn-primary d-grid w-100" onclick="javascript:enviar('form1')" tabindex="4">Ingresar</button>
                                <input name="operacion" type="hidden" id="operacion" value="3" />
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /Login -->

                <img alt="mask" src="<?= base_url('content/template/assets/img/illustrations/auth-basic-login-mask-light.png') ?>" class="authentication-image d-none d-lg-block" />
            </div>
        </div>
    </div>
    <!-- / Content -->

    <br />

    <!-- Scripts Esenciales -->
    <script src="<?= base_url('content/template/assets/vendor/libs/jquery/jquery.js') ?>"></script>
    <script src="<?= base_url('content/template/assets/vendor/js/bootstrap.js') ?>"></script>

    <!-- Scripts Propios del Proyecto -->
    <script src="<?= base_url('scripts/variables_globales.js') ?>"></script>        
    <script src="<?= base_url('scripts/login.js') ?>"></script>

</body>
</html>