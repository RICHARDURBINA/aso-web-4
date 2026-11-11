<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
//$routes->get('/', 'Home::index');

// ==========================================
// RUTAS DE LOGIN Y SESIÓN
// ==========================================
$routes->get('/', 'LoginController::login');
$routes->match(['get', 'post'], 'LoginController/login', 'LoginController::login');
$routes->match(['get', 'post'], 'LoginController/iniciar_sesion', 'LoginController::iniciar_sesion');
$routes->match(['get', 'post'], 'LoginController/cerrar_sesion', 'LoginController::cerrar_sesion');

// ==========================================
// RUTA DE MENÚ
// ==========================================
$routes->match(['get', 'post'], 'MenuController/menu', 'MenuController::menu');

// ==========================================
// RUTAS DE PEDIDOS (PedidoController)
// ==========================================
$routes->match(['get', 'post'], 'PedidoController/pedido', 'PedidoController::pedido');
$routes->match(['get', 'post'], 'PedidoController/listapedido', 'PedidoController::listapedido');
$routes->match(['get', 'post'], 'PedidoController/guardar_pedido', 'PedidoController::guardar_pedido');
$routes->match(['get', 'post'], 'PedidoController/aprobar_pedido', 'PedidoController::aprobar_pedido');
$routes->match(['get', 'post'], 'PedidoController/trasladar_pedido', 'PedidoController::trasladar_pedido');
$routes->match(['get', 'post'], 'PedidoController/trasladar_ordenes', 'PedidoController::trasladar_ordenes');
$routes->match(['get', 'post'], 'PedidoController/anular_pedido', 'PedidoController::anular_pedido');
$routes->match(['get', 'post'], 'PedidoController/consultar_pedido', 'PedidoController::consultar_pedido');
$routes->match(['get', 'post'], 'PedidoController/consultar_pedido_documentos_asociados', 'PedidoController::consultar_pedido_documentos_asociados');
$routes->match(['get', 'post'], 'PedidoController/form_consultar_pedido/(:segment)/(:segment)', 'PedidoController::form_consultar_pedido/$1/$2');
$routes->match(['get', 'post'], 'PedidoController/consultar_pedido_fecha/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', 'PedidoController::consultar_pedido_fecha/$1/$2/$3/$4/$5/$6/$7');
$routes->match(['get', 'post'], 'PedidoController/excelpedido/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', 'PedidoController::excelpedido/$1/$2/$3/$4/$5/$6/$7');

// ==========================================
// RUTAS DE CLIENTES (ClienteController)
// ==========================================
$routes->match(['get', 'post'], 'ClienteController/consultar_cliente_zona_usuario', 'ClienteController::consultar_cliente_zona_usuario');
$routes->match(['get', 'post'], 'ClienteController/consultar_sucursal_cliente', 'ClienteController::consultar_sucursal_cliente');

// ==========================================
// RUTAS DE PRODUCTOS (ProductoController)
// ==========================================
$routes->match(['get', 'post'], 'ProductoController/consultar_producto_cliente', 'ProductoController::consultar_producto_cliente');
$routes->match(['get', 'post'], 'productoController/consultar_producto_cliente', 'ProductoController::consultar_producto_cliente'); // Alias minúscula por compatibilidad

// ==========================================
// RUTAS DE VENDEDORES (VendedorController)
// ==========================================
$routes->match(['get', 'post'], 'VendedorController/consultar_vendedor_zona_usuario', 'VendedorController::consultar_vendedor_zona_usuario');
$routes->match(['get', 'post'], 'vendedorController/consultar_vendedor_zona_usuario', 'VendedorController::consultar_vendedor_zona_usuario'); // Alias minúscula por compatibilidad

// ==========================================
// RUTAS DE PLANIFICACIÓN Y TRANSPORTE (PlanController)[cite: 5]
// ==========================================
$routes->match(['get', 'post'], 'PlanController/planpedido', 'PlanController::planpedido');
$routes->match(['get', 'post'], 'PlanController/listaplanpedido', 'PlanController::listaplanpedido');
$routes->match(['get', 'post'], 'PlanController/asociartransporte', 'PlanController::asociartransporte');
$routes->match(['get', 'post'], 'PlanController/planificar_pedido', 'PlanController::planificar_pedido');
$routes->match(['get', 'post'], 'PlanController/anular_plan', 'PlanController::anular_plan');
$routes->match(['get', 'post'], 'PlanController/aplicar_nc_total', 'PlanController::aplicar_nc_total');
$routes->match(['get', 'post'], 'PlanController/anular_transporte', 'PlanController::anular_transporte');
$routes->match(['get', 'post'], 'PlanController/consultar_control_cola_disponible', 'PlanController::consultar_control_cola_disponible');
$routes->match(['get', 'post'], 'PlanController/asignar_transporte', 'PlanController::asignar_transporte');
$routes->match(['get', 'post'], 'PlanController/sincronizar_transporte', 'PlanController::sincronizar_transporte');
$routes->match(['get', 'post'], 'PlanController/consultar_pedido_vta_prom_fecha/(:any)/(:any)/(:any)/(:any)/(:any)', 'PlanController::consultar_pedido_vta_prom_fecha/$1/$2/$3/$4/$5');
$routes->match(['get', 'post'], 'PlanController/consultar_pedido_vta_prom/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', 'PlanController::consultar_pedido_vta_prom/$1/$2/$3/$4/$5/$6');
$routes->match(['get', 'post'], 'PlanController/consultar_pedido_plan_fecha/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', 'PlanController::consultar_pedido_plan_fecha/$1/$2/$3/$4/$5/$6/$7');
$routes->match(['get', 'post'], 'PlanController/excelgestiontransporte/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', 'PlanController::excelgestiontransporte/$1/$2/$3/$4/$5/$6/$7');

// Alias en minúscula para PlanController por compatibilidad
$routes->match(['get', 'post'], 'planController/planpedido', 'PlanController::planpedido');
$routes->match(['get', 'post'], 'planController/listaplanpedido', 'PlanController::listaplanpedido');
$routes->match(['get', 'post'], 'planController/planificar_pedido', 'PlanController::planificar_pedido');
$routes->match(['get', 'post'], 'planController/consultar_pedido_vta_prom/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', 'PlanController::consultar_pedido_vta_prom/$1/$2/$3/$4/$5/$6');

// ==========================================
// RUTAS DE COBRANZA (CobranzaController)
// ==========================================
$routes->match(['get', 'post'], 'CobranzaController/cobranza', 'CobranzaController::cobranza');
$routes->match(['get', 'post'], 'CobranzaController/listacobranza', 'CobranzaController::listacobranza');
$routes->match(['get', 'post'], 'CobranzaController/guardar_cobranza', 'CobranzaController::guardar_cobranza');
$routes->match(['get', 'post'], 'CobranzaController/form_consultar_cobranza/(:num)', 'CobranzaController::form_consultar_cobranza/$1');
$routes->match(['get', 'post'], 'CobranzaController/form_modificar_cobranza/(:num)', 'CobranzaController::form_modificar_cobranza/$1');
$routes->match(['get', 'post'], 'CobranzaController/consultar_cobranza', 'CobranzaController::consultar_cobranza');
$routes->match(['get', 'post'], 'CobranzaController/anular_cobranza', 'CobranzaController::anular_cobranza');
$routes->match(['get', 'post'], 'CobranzaController/consultar_cobranza_fecha/(:any)/(:any)/(:any)/(:any)', 'CobranzaController::consultar_cobranza_fecha/$1/$2/$3/$4');
$routes->match(['get', 'post'], 'CobranzaController/excelcobranza/(:any)/(:any)/(:any)/(:any)', 'CobranzaController::excelcobranza/$1/$2/$3/$4');
$routes->match(['get', 'post'], 'CobranzaController/consultar_cobranza_factura', 'CobranzaController::consultar_cobranza_factura');
$routes->match(['get', 'post'], 'CobranzaController/consultar_cobranza_factura/(:num)', 'CobranzaController::consultar_cobranza_factura/$1');
$routes->match(['get', 'post'], 'CobranzaController/consultar_cobranza_pago', 'CobranzaController::consultar_cobranza_pago');
$routes->match(['get', 'post'], 'CobranzaController/consultar_cobranza_pago/(:num)', 'CobranzaController::consultar_cobranza_pago/$1');
$routes->match(['get', 'post'], 'CobranzaController/consultar_comprobantes_cobranza/(:num)', 'CobranzaController::consultar_comprobantes_cobranza/$1');

// ==========================================
// RUTAS DE VISITA (VisitaController)
// ==========================================
$routes->match(['get', 'post'], 'VisitaController/visita', 'VisitaController::visita');
$routes->match(['get', 'post'], 'VisitaController/listavisita', 'VisitaController::listavisita');
$routes->match(['get', 'post'], 'VisitaController/ultimavisita', 'VisitaController::ultimavisita');
$routes->match(['get', 'post'], 'VisitaController/guardar_visita', 'VisitaController::guardar_visita');
$routes->match(['get', 'post'], 'VisitaController/form_consultar_visita/(:num)', 'VisitaController::form_consultar_visita/$1');
$routes->match(['get', 'post'], 'VisitaController/consultar_visita', 'VisitaController::consultar_visita');
$routes->match(['get', 'post'], 'VisitaController/anular_visita', 'VisitaController::anular_visita');
$routes->match(['get', 'post'], 'VisitaController/consultar_visita_fecha/(:any)/(:any)/(:any)/(:any)', 'VisitaController::consultar_visita_fecha/$1/$2/$3/$4');
$routes->match(['get', 'post'], 'VisitaController/consultar_ultimavisita_fecha/(:any)/(:any)/(:any)/(:any)', 'VisitaController::consultar_ultimavisita_fecha/$1/$2/$3/$4');
$routes->match(['get', 'post'], 'VisitaController/visita_productos_terceros', 'VisitaController::visita_productos_terceros');
$routes->match(['get', 'post'], 'VisitaController/consultar_visita_productos_terceros/(:any)/(:any)/(:any)/(:any)', 'VisitaController::consultar_visita_productos_terceros/$1/$2/$3/$4');

// ==========================================
// RUTAS DE BANCO (BancoController)
// ==========================================
$routes->match(['get', 'post'], 'BancoController/consultar_banco', 'BancoController::consultar_banco');

// ==========================================
// RUTAS DE CHOFER (ChoferController)
// ==========================================
$routes->match(['get', 'post'], 'ChoferController/listachofer', 'ChoferController::listachofer');
$routes->match(['get', 'post'], 'ChoferController/consultar_chofer', 'ChoferController::consultar_chofer');
$routes->match(['get', 'post'], 'ChoferController/activar_chofer', 'ChoferController::activar_chofer');
$routes->match(['get', 'post'], 'ChoferController/inactivar_chofer', 'ChoferController::inactivar_chofer');
$routes->match(['get', 'post'], 'ChoferController/guardar_chofer', 'ChoferController::guardar_chofer');

// ==========================================
// RUTAS DE VEHÍCULO (VehiculoController)
// ==========================================
$routes->match(['get', 'post'], 'VehiculoController/listavehiculo', 'VehiculoController::listavehiculo');
$routes->match(['get', 'post'], 'VehiculoController/consultar_vehiculo', 'VehiculoController::consultar_vehiculo');
$routes->match(['get', 'post'], 'VehiculoController/activar_vehiculo', 'VehiculoController::activar_vehiculo');
$routes->match(['get', 'post'], 'VehiculoController/inactivar_vehiculo', 'VehiculoController::inactivar_vehiculo');
$routes->match(['get', 'post'], 'VehiculoController/guardar_vehiculo', 'VehiculoController::guardar_vehiculo');

// ==========================================
// RUTAS DE COLA (ColaController)
// ==========================================
$routes->match(['get', 'post'], 'ColaController/cola', 'ColaController::cola');
$routes->match(['get', 'post'], 'ColaController/listacola', 'ColaController::listacola');
$routes->match(['get', 'post'], 'ColaController/guardar_cola', 'ColaController::guardar_cola');
$routes->match(['get', 'post'], 'ColaController/form_consultar_cola/(:num)', 'ColaController::form_consultar_cola/$1');
$routes->match(['get', 'post'], 'ColaController/consultar_cola', 'ColaController::consultar_cola');
$routes->match(['get', 'post'], 'ColaController/anular_cola', 'ColaController::anular_cola');
$routes->match(['get', 'post'], 'ColaController/finalizar_cola', 'ColaController::finalizar_cola');
$routes->match(['get', 'post'], 'ColaController/consultar_cola_fecha/(:any)/(:any)/(:any)/(:any)/(:any)', 'ColaController::consultar_cola_fecha/$1/$2/$3/$4/$5');

// ==========================================
// RUTAS DE TRANSPORTISTA (TransportistaController)
// ==========================================
$routes->match(['get', 'post'], 'TransportistaController/consultar_transportista', 'TransportistaController::consultar_transportista');

// ==========================================
// RUTAS DE GRÁFICAS (GraficaController)
// ==========================================
$routes->match(['get', 'post'], 'GraficaController/grafica', 'GraficaController::grafica');
$routes->match(['get', 'post'], 'GraficaController/resumen', 'GraficaController::resumen');
$routes->match(['get', 'post'], 'GraficaController/datos_grafica_fecha', 'GraficaController::datos_grafica_fecha');
$routes->match(['get', 'post'], 'GraficaController/datos_resumen_fecha', 'GraficaController::datos_resumen_fecha');


// ==========================================
// RUTAS DE ROMANA (RomanaController)
// ==========================================
$routes->match(['get', 'post'], 'RomanaController/listaromana', 'RomanaController::listaromana');
$routes->match(['get', 'post'], 'RomanaController/consultar_romana', 'RomanaController::consultar_romana');