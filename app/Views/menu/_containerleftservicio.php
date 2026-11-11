<?php
$arreglousuario = $Model_usuario ?? [];

$uri_actual = $_SERVER['REQUEST_URI'];
$accion_actual = '';

if (preg_match('/Controller\/([^\/\?]+)/i', $uri_actual, $matches)) {
    $accion_actual = trim($matches[1]); 
}
?>

<aside id="layout-menu" class="layout-menu menu-vertical menu">
    <div class="app-brand demo">
        <a href="<?= base_url('MenuController/menu') ?>" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="<?= base_url('images/logo/logo.png') ?>" alt="X" width="30in">
            </span>
            <span class="app-brand-text demo menu-text fw-semibold ms-2">Pedidos Web</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path d="M8.47365 11.7183C8.11707 12.0749 8.11707 12.6531 8.47365 13.0097L12.071 16.607C12.4615 16.9975 12.4615 17.6305 12.071 18.021C11.6805 18.4115 11.0475 18.4115 10.657 18.021L5.83009 13.1941C5.37164 12.7356 5.37164 11.9924 5.83009 11.5339L10.657 6.707C11.0475 6.31653 11.6805 6.31653 12.071 6.707C12.4615 7.09747 12.4615 7.73053 12.071 8.121L8.47365 11.7183Z" fill-opacity="0.9" />
                <path d="M14.3584 11.8336C14.0654 12.1266 14.0654 12.6014 14.3584 12.8944L18.071 16.607C18.4615 16.9975 18.4615 17.6305 18.071 18.021C17.6805 18.4115 17.0475 18.4115 16.657 18.021L11.6819 13.0459C11.3053 12.6693 11.3053 12.0587 11.6819 11.6821L16.657 6.707C17.0475 6.31653 17.6805 6.31653 18.071 6.707C18.4615 7.09747 18.4615 7.73053 18.071 8.121L14.3584 11.8336Z" fill-opacity="0.4" />
            </svg>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Inicio -->
        <li class="menu-item <?= ($accion_actual == 'menu') ? 'active' : '' ?>">
            <a href="<?= base_url('MenuController/menu') ?>" class="menu-link">
                <i class="menu-icon icon-base ri ri-home-smile-line"></i>
                <div data-i18n="Page 1">Inicio</div>
            </a>
        </li>

        <!-- MÓDULO PEDIDOS -->
        <?php if(!empty($arreglousuario) && (($arreglousuario[0]["pedido_registro"] == 1) || ($arreglousuario[0]["orden_registro"] == 1) || ($arreglousuario[0]["pedido_listar"] == 1))) { ?>
        <li class="menu-item <?= (in_array($accion_actual, ['pedido', 'listapedido'])) ? 'active open' : '' ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ri ri-layout-2-line"></i>
                <div data-i18n="Layouts">Pedidos</div>
            </a>
            <ul class="menu-sub">
                <?php if($arreglousuario[0]["pedido_registro"] == 1) { ?>
                <li class="menu-item <?= ($accion_actual == 'pedido') ? 'active' : '' ?>">
                    <a href="<?= base_url('PedidoController/pedido') ?>" class="menu-link">
                        <i class="menu-icon icon-base ri ri-smartphone-fill"></i>
                        <div data-i18n="Page 2">Registrar Pedido</div>
                    </a>
                </li>
                <?php } ?>

                <?php if($arreglousuario[0]["orden_registro"] == 1) { ?>
                <li class="menu-item">
                    <a href="javascript:fn_trasladar_ordenes()" class="menu-link">
                        <i class="menu-icon icon-base ri ri-settings-4-line"></i>
                        <div data-i18n="Page 2">Trasladar Ordenes</div>
                    </a>
                </li>
                <?php } ?>

                <?php if($arreglousuario[0]["pedido_listar"] == 1) { ?>
                <li class="menu-item <?= ($accion_actual == 'listapedido') ? 'active' : '' ?>">
                    <a href="<?= base_url('PedidoController/listapedido') ?>" class="menu-link">
                        <i class="menu-icon icon-base ri ri-file-list-fill"></i>
                        <div data-i18n="Page 2">Gesti&oacute;n de Pedidos</div>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </li>
        <?php } ?>

        <!-- MÓDULO VISITA -->
        <?php if(!empty($arreglousuario) && (($arreglousuario[0]["visita_registro"] == 1) || ($arreglousuario[0]["visita_listar"] == 1))) { ?>
        <li class="menu-item <?= (in_array($accion_actual, ['visita', 'listavisita', 'ultimavisita', 'visita_productos_terceros'])) ? 'active open' : '' ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ri ri-layout-2-line"></i>
                <div data-i18n="Layouts">Visita</div>
            </a>
            <ul class="menu-sub">
                <?php if($arreglousuario[0]["visita_registro"] == 1) { ?>
                <li class="menu-item <?= ($accion_actual == 'visita') ? 'active' : '' ?>">
                    <a href="<?= base_url('VisitaController/visita') ?>" class="menu-link">
                        <i class="menu-icon icon-base ri ri-community-fill"></i>
                        <div data-i18n="Page 2">Registrar Visita</div>
                    </a>
                </li>
                <?php } ?>

                <?php if($arreglousuario[0]["visita_listar"] == 1) { ?>
                <li class="menu-item <?= ($accion_actual == 'listavisita') ? 'active' : '' ?>">
                    <a href="<?= base_url('VisitaController/listavisita') ?>" class="menu-link">
                        <i class="menu-icon icon-base ri ri-file-list-fill"></i>
                        <div data-i18n="Page 2">Gesti&oacute;n de Visitas</div>
                    </a>
                </li>
                <li class="menu-item <?= ($accion_actual == 'ultimavisita') ? 'active' : '' ?>">
                    <a href="<?= base_url('VisitaController/ultimavisita') ?>" class="menu-link">
                        <i class="menu-icon icon-base ri ri-file-list-fill"></i>
                        <div data-i18n="Page 2">Ultima Visita</div>
                    </a>
                </li>
                <li class="menu-item <?= ($accion_actual == 'visita_productos_terceros') ? 'active' : '' ?>">
                    <a href="<?= base_url('VisitaController/visita_productos_terceros') ?>" class="menu-link">
                        <i class="menu-icon icon-base ri ri-file-list-fill"></i>
                        <div data-i18n="Page 2">Visita Productos Terc.</div>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </li>
        <?php } ?>

        <!-- MÓDULO COBRANZA -->
        <?php if(!empty($arreglousuario) && (($arreglousuario[0]["cobranza_registro"] == 1) || ($arreglousuario[0]["cobranza_listar"] == 1))) { ?>
        <li class="menu-item <?= (in_array($accion_actual, ['cobranza', 'listacobranza'])) ? 'active open' : '' ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ri ri-layout-2-line"></i>
                <div data-i18n="Layouts">Cobranza</div>
            </a>
            <ul class="menu-sub">
                <?php if($arreglousuario[0]["cobranza_registro"] == 1) { ?>
                <li class="menu-item <?= ($accion_actual == 'cobranza') ? 'active' : '' ?>">
                    <a href="<?= base_url('CobranzaController/cobranza') ?>" class="menu-link">
                        <i class="menu-icon icon-base ri ri-money-dollar-box-fill"></i>
                        <div data-i18n="Page 2">Registrar Cobranza</div>
                    </a>
                </li>
                <?php } ?>

                <?php if($arreglousuario[0]["cobranza_listar"] == 1) { ?>
                <li class="menu-item <?= ($accion_actual == 'listacobranza') ? 'active' : '' ?>">
                    <a href="<?= base_url('CobranzaController/listacobranza') ?>" class="menu-link">
                        <i class="menu-icon icon-base ri ri-file-list-fill"></i>
                        <div data-i18n="Page 2">Gesti&oacute;n de Cobranzas</div>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </li>
        <?php } ?>

        <!-- MÓDULO TRANSPORTE -->
        <?php if(!empty($arreglousuario) && (
            ($arreglousuario[0]["chofer_registro"] == 1) || ($arreglousuario[0]["chofer_anular"] == 1) || ($arreglousuario[0]["chofer_listar"] == 1) ||
            ($arreglousuario[0]["vehiculo_registro"] == 1) || ($arreglousuario[0]["vehiculo_anular"] == 1) || ($arreglousuario[0]["vehiculo_listar"] == 1) ||
            ($arreglousuario[0]["cola_registro"] == 1) || ($arreglousuario[0]["cola_listar"] == 1) ||
            ($arreglousuario[0]["plan_registro"] == 1) || ($arreglousuario[0]["plan_consulta"] == 1) ||
            ($arreglousuario[0]["plan_asociar"] == 1) || ($arreglousuario[0]["plan_anular"] == 1)
        )) { ?>
        <li class="menu-item <?= (in_array($accion_actual, ['listachofer', 'listavehiculo', 'cola', 'listacola', 'planpedido', 'listaplanpedido', 'asociartransporte'])) ? 'active open' : '' ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ri ri-layout-2-line"></i>
                <div data-i18n="Layouts">Transporte</div>
            </a>
            <ul class="menu-sub">
                <?php if($arreglousuario[0]["chofer_listar"] == 1) { ?>
                <li class="menu-item <?= ($accion_actual == 'listachofer') ? 'active' : '' ?>">
                    <a href="<?= base_url('ChoferController/listachofer') ?>" class="menu-link">
                        <i class="menu-icon icon-base ri ri-user-3-line"></i>
                        <div data-i18n="Page 2">Gesti&oacute;n de Chofer</div>
                    </a>
                </li>
                <?php } ?>

                <?php if($arreglousuario[0]["vehiculo_listar"] == 1) { ?>
                <li class="menu-item <?= ($accion_actual == 'listavehiculo') ? 'active' : '' ?>">
                    <a href="<?= base_url('VehiculoController/listavehiculo') ?>" class="menu-link">
                        <i class="menu-icon icon-base ri ri-truck-line"></i>
                        <div data-i18n="Page 2">Gesti&oacute;n de Veh&iacute;culo</div>
                    </a>
                </li>
                <?php } ?>

                <?php if($arreglousuario[0]["cola_registro"] == 1) { ?>
                <li class="menu-item <?= ($accion_actual == 'cola') ? 'active' : '' ?>">
                    <a href="<?= base_url('ColaController/cola') ?>" class="menu-link">
                        <i class="menu-icon icon-base ri ri-clockwise-line"></i>
                        <div data-i18n="Page 2">Registrar Cola</div>
                    </a>
                </li>
                <?php } ?>

                <?php if($arreglousuario[0]["cola_listar"] == 1) { ?>
                <li class="menu-item <?= ($accion_actual == 'listacola') ? 'active' : '' ?>">
                    <a href="<?= base_url('ColaController/listacola') ?>" class="menu-link">
                        <i class="menu-icon icon-base ri ri-file-list-fill"></i>
                        <div data-i18n="Page 2">Gesti&oacute;n de Cola</div>
                    </a>
                </li>
                <?php } ?>

                <?php if(($arreglousuario[0]["plan_registro"] == 1) || ($arreglousuario[0]["plan_consulta"] == 1)) { ?>
                <li class="menu-item <?= ($accion_actual == 'planpedido') ? 'active' : '' ?>">
                    <a href="<?= base_url('PlanController/planpedido') ?>" class="menu-link">
                        <i class="menu-icon icon-base ri ri-settings-4-line"></i>
                        <div data-i18n="Page 2">Plan de Despacho</div>
                    </a>
                </li>
                <?php } ?>

                <?php if($arreglousuario[0]["plan_listar"] == 1) { ?>
                <li class="menu-item <?= ($accion_actual == 'listaplanpedido') ? 'active' : '' ?>">
                    <a href="<?= base_url('PlanController/listaplanpedido') ?>" class="menu-link">
                        <i class="menu-icon icon-base ri ri-file-list-fill"></i>
                        <div data-i18n="Page 2">Listar Planificaci&oacute;n</div>
                    </a>
                </li>
                <?php } ?>

                <?php if(($arreglousuario[0]["plan_asociar"] == 1) || ($arreglousuario[0]["plan_anular"] == 1)) { ?>
                <li class="menu-item <?= ($accion_actual == 'asociartransporte') ? 'active' : '' ?>">
                    <a href="<?= base_url('PlanController/asociartransporte') ?>" class="menu-link">
                        <i class="menu-icon icon-base ri ri-file-list-fill"></i>
                        <div data-i18n="Page 2">Gesti&oacute;n de Transporte</div>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </li>
        <?php } ?>

        <!-- MÓDULO ROMANA -->
        <?php if(!empty($arreglousuario) && ($arreglousuario[0]["romana_listar"] == 1)) { ?>
        <li class="menu-item <?= (in_array($accion_actual, ['listaromana'])) ? 'active open' : '' ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ri ri-layout-2-line"></i>
                <div data-i18n="Layouts">Romana</div>
            </a>
            <ul class="menu-sub">
                <?php if($arreglousuario[0]["romana_listar"] == 1) { ?>
                <li class="menu-item <?= ($accion_actual == 'listaromana') ? 'active' : '' ?>">
                    <a href="<?= base_url('RomanaController/listaromana') ?>" class="menu-link">
                        <i class="menu-icon icon-base ri ri-file-list-fill"></i>
                        <div data-i18n="Page 2">Gesti&oacute;n de Romana</div>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </li>
        <?php } ?>

        <!-- OTROS MÓDULOS -->
        <?php if(!empty($arreglousuario) && $arreglousuario[0]["grafica"] == 1) { ?>
        <li class="menu-item <?= ($accion_actual == 'grafica') ? 'active' : '' ?>">
            <a href="<?= base_url('GraficaController/grafica') ?>" class="menu-link">
                <i class="menu-icon icon-base ri ri-airplay-fill"></i>
                <div data-i18n="Page 2">Estad&iacute;sticas Web</div>
            </a>
        </li>
        <?php } ?>

        <?php if(!empty($arreglousuario) && ($arreglousuario[0]["resumen_producto"] == 1 || $arreglousuario[0]["resumen_transporte"] == 1)) { ?>
        <li class="menu-item <?= ($accion_actual == 'resumen') ? 'active' : '' ?>">
            <a href="<?= base_url('GraficaController/resumen') ?>" class="menu-link">
                <i class="menu-icon icon-base ri ri-pie-chart-2-line"></i>
                <div data-i18n="Page 2">Resumen</div>
            </a>
        </li>
        <?php } ?>

        <!-- Cerrar Sesión -->
        <li class="menu-item">
            <a href="<?= base_url('LoginController/cerrar_sesion') ?>" class="menu-link">
                <i class="menu-icon icon-base ri ri-logout-box-fill"></i>
                <div data-i18n="Page 2">Cerrar Sesi&oacute;n</div>
            </a>
        </li>

    </ul>
</aside>

<div class="menu-mobile-toggler d-xl-none rounded-1">
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large text-bg-secondary p-2 rounded-1">
        <i class="ri ri-menu-line icon-base"></i>
        <i class="ri ri-arrow-right-s-line icon-base"></i>
    </a>
</div>