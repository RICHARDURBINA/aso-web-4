<?php

namespace App\Controllers;

use App\Models\SesionModel;
use App\Models\ErrorModel;
use App\Models\PedidoModel;

class PedidoController extends BaseController
{
    //=============================================================================================================
    //
    //=============================================================================================================
    public function pedido()
    {
        try {
            $session = session();
            $sesionusuario = $session->get('datossesionusuario');

            //-----------------------------------------------------------------------
            // Si no existe una sesión activa
            //-----------------------------------------------------------------------
            if (!isset($sesionusuario["Model_usuario"])) {
                return redirect()->to(base_url('LoginController/login'));
            }
            //-----------------------------------------------------------------------

            $par_co_cliente = $this->request->getGet('co_cliente');
            $co_cliente = isset($par_co_cliente) ? $par_co_cliente : "";

            $arreglo = array(
                'Model_usuario' => $sesionusuario["Model_usuario"],
                'par_co_cliente' => $co_cliente
            );

            return view('pedido/index', $arreglo);

        } catch (\Throwable $e) {
            return $this->response->setJSON(["resultado" => "ERROR", "msn" => $e->getMessage()]);
        }
    }

    //=============================================================================================================
    //
    //=============================================================================================================
    public function listapedido()
    {
        try {
            $sesionModel  = new SesionModel();
            $errorModel   = new ErrorModel();
            $pedidoModel  = new PedidoModel();
            
            $session = session();
            // DESTRUYO SESIÓN PARA MANEJO DE ERRORES
            $session->remove('error');

            $sesionusuario = $session->get('datossesionusuario');

            //-----------------------------------------------------------------------
            // Si no existe una sesión activa
            //-----------------------------------------------------------------------
            if (!isset($sesionusuario["Model_usuario"])) {
                return redirect()->to(base_url('LoginController/login'));
            }
            //-----------------------------------------------------------------------

            $idusuario = $sesionusuario["Model_usuario"][0]["idusuario"];

            // Primer día del mes
            $txtdesde = date('Y-m-01');
            // Último día del mes
            $txthasta = date('Y-m-t');

            $arreglopedido = $pedidoModel->consultar_pedido_fecha($txtdesde, $txthasta, $idusuario, "%", "%", "N", "%", "%");

            $errorSesion = $session->get('error');

            if (!empty($errorSesion)) {
                // MANEJADOR DE ERRORES (ERROR DE BASE DE DATOS)
                $sesionModel->actualizar_session(0);
                $modeloerror = $errorModel->consultar_error('0', $errorSesion);
                return view('error/index', $modeloerror);
            }
            else if (is_array($arreglopedido) && count($arreglopedido) >= 0)
            {
                $arreglopedidodesc = $pedidoModel->consultar_pedido_descuento("%", "%", "%", "%", "%");
                $errorSesionDesc = $session->get('error');

                if (!empty($errorSesionDesc)) {
                    // MANEJADOR DE ERRORES (ERROR DE BASE DE DATOS)
                    $sesionModel->actualizar_session(0);
                    $modeloerror = $errorModel->consultar_error('0', $errorSesionDesc);
                    return view('error/index', $modeloerror);
                }
                else if (is_array($arreglopedidodesc) && count($arreglopedidodesc) >= 0)
                {
                    $arreglo = array(
                        'Model_usuario' => $sesionusuario["Model_usuario"],
                        'Model_consultar_pedido' => $arreglopedido,
                        'Model_consultar_pedido_desc' => $arreglopedidodesc,
                        'par_desde' => $txtdesde,
                        'par_hasta' => $txthasta,
                        'par_vendedor' => "%",
                        'par_cliente' => "%",
                        'par_est_anulado' => "N"
                    );
                    return view('pedido/listapedido', $arreglo);
                }
                else
                {
                    $sesionModel->actualizar_session(0);
                    $modeloerror = $errorModel->consultar_error('4', '');
                    return view('error/index', $modeloerror);
                }
            }
            else
            {
                $sesionModel->actualizar_session(0);
                $modeloerror = $errorModel->consultar_error('4', '');
                return view('error/index', $modeloerror);
            }

        } catch (\Throwable $e) {
            $sesionModel = new SesionModel();
            $sesionModel->actualizar_session(0);
            $errorModel = new ErrorModel();
            $modeloerror = $errorModel->consultar_error('0', $e->getMessage());
            return view('error/index', $modeloerror);
        }
    }

    //=============================================================================================================
    //
    //=============================================================================================================
    public function guardar_pedido()
    {
        try {
            if (!$this->request->isAJAX()) {
                return $this->response->setJSON(['resultado' => 'ERROR', 'msn' => 'Petición no válida']);
            }

            $session = session();
            $session->remove('error');
            $pedidoModel = new PedidoModel();

            $idvendedor = $this->request->getPost("idvendedor");
            $nbvendedor = $this->request->getPost("nbvendedor");
            $fecha      = $this->request->getPost("fecha");

            $dateArray = explode('/', $this->request->getPost('fecha'));
            if(count($dateArray) >= 3) {
                $fecha = $dateArray[2].'-'.$dateArray[1].'-'.$dateArray[0];
            }

            $cmbconpag        = $this->request->getPost("cmbconpag");
            $cmbcliente       = $this->request->getPost("cmbcliente");
            $cmbsucursaladesa = $this->request->getPost("cmbsucursaladesa");
            $cmbsucursalaai   = $this->request->getPost("cmbsucursalaai");
            $txtobs           = strtoupper($this->request->getPost("txtobs"));

            $coemp   = $this->request->getPost("coemp");
            $idprd   = $this->request->getPost("idprd");
            $coprd   = $this->request->getPost("coprd");

            $nbprd   = $this->request->getPost("nbprd");
            $prprd   = $this->request->getPost("prprd");
            $caprd   = $this->request->getPost("caprd");
            $promprd = $this->request->getPost("promprd");
            $descprd = $this->request->getPost("descprd");
            $tipodesc = $this->request->getPost("tipodesc");

            $totalprd              = $this->request->getPost("totalprd");
            $total_desc_prd_actual = $this->request->getPost("total_desc_prd_actual");

            $array_dia_desc = [];
            $array_porc_desc = [];

            $postDia = $this->request->getPost("dia");
            $postPorc = $this->request->getPost("porc");

            for ($x = 0; $x < $totalprd; $x++) {
                if (isset($postDia[$x])) {
                    $array_dia_desc[$x] = $postDia[$x];
                }
                if (isset($postPorc[$x])) {
                    $array_porc_desc[$x] = $postPorc[$x];
                }
            }

            $operacion = "";
            $postOperacion = $this->request->getPost("operacion");
            if ($postOperacion != null && $postOperacion != "") {
                $operacion = $postOperacion;
            }

            $pedidoModel->guardar_pedido(
                $fecha, $cmbcliente, $cmbsucursaladesa, $cmbsucursalaai,
                $cmbconpag, $txtobs, $idvendedor, $coemp, $idprd, $coprd,
                $prprd, $caprd, $promprd, $descprd, $tipodesc, $totalprd,
                $total_desc_prd_actual, $array_dia_desc, $array_porc_desc, $operacion
            );

            $errorSesion = $session->get('error');

            if(empty($errorSesion)) {
                $data = [ 'resultado' => '1' ];
                return $this->response->setJSON($data);
            } else {
                $data = array("resultado" => "ERROR", "msn" => $errorSesion);
                return $this->response->setJSON($data);
            }

        } catch (\Throwable $e) {
            $data = array("resultado" => "ERROR", "msn" => $e->getMessage());
            return $this->response->setJSON($data);
        }
    }

    //=============================================================================================================
    //
    //=============================================================================================================
    public function aprobar_pedido()
    {
        try {
            if (!$this->request->isAJAX()) {
                return $this->response->setJSON(['resultado' => 'ERROR', 'msn' => 'Petición no válida']);
            }

            $session = session();
            $session->remove('error');
            $pedidoModel = new PedidoModel();

            $id_ped_web = $this->request->getPost("id_ped_web");
            $id_doc_emp = $this->request->getPost("id_doc_emp");

            $pedidoModel->aprobar_pedido($id_ped_web, $id_doc_emp);

            $errorSesion = $session->get('error');

            if(empty($errorSesion)) {
                $data = [ 'resultado' => '1' ];
                return $this->response->setJSON($data);
            } else {
                $data = array("resultado" => "ERROR", "msn" => $errorSesion);
                return $this->response->setJSON($data);
            }

        } catch (\Throwable $e) {
            $data = array("resultado" => "ERROR", "msn" => $e->getMessage());
            return $this->response->setJSON($data);
        }
    }

    //=============================================================================================================
    //
    //=============================================================================================================
    public function trasladar_pedido()
    {
        try {
            if (!$this->request->isAJAX()) {
                return $this->response->setJSON(['resultado' => 'ERROR', 'msn' => 'Petición no válida']);
            }

            $session = session();
            $session->remove('error');
            $pedidoModel = new PedidoModel();

            $id_ped_web = $this->request->getPost("id_ped_web");
            $id_doc_emp = $this->request->getPost("id_doc_emp");

            $pedidoModel->trasladar_pedido($id_ped_web, $id_doc_emp);

            $errorSesion = $session->get('error');

            if(empty($errorSesion)) {
                $data = [ 'resultado' => '1' ];
                return $this->response->setJSON($data);
            } else {
                $data = array("resultado" => "ERROR", "msn" => $errorSesion);
                return $this->response->setJSON($data);
            }

        } catch (\Throwable $e) {
            $data = array("resultado" => "ERROR", "msn" => $e->getMessage());
            return $this->response->setJSON($data);
        }
    }

    //=============================================================================================================
    //
    //=============================================================================================================
    public function trasladar_ordenes()
    {
        try {
            if (!$this->request->isAJAX()) {
                return $this->response->setJSON(['resultado' => 'ERROR', 'msn' => 'Petición no válida']);
            }

            $session = session();
            $session->remove('error');
            $pedidoModel = new PedidoModel();

            $pedidoModel->trasladar_ordenes();

            $errorSesion = $session->get('error');

            if(empty($errorSesion)) {
                $data = [ 'resultado' => '1' ];
                return $this->response->setJSON($data);
            } else {
                $data = array("resultado" => "ERROR", "msn" => $errorSesion);
                return $this->response->setJSON($data);
            }

        } catch (\Throwable $e) {
            $data = array("resultado" => "ERROR", "msn" => $e->getMessage());
            return $this->response->setJSON($data);
        }
    }

    //=============================================================================================================
    //
    //=============================================================================================================
    public function anular_pedido()
    {
        try {
            if (!$this->request->isAJAX()) {
                return $this->response->setJSON(['resultado' => 'ERROR', 'msn' => 'Petición no válida']);
            }

            $session = session();
            $session->remove('error');
            $pedidoModel = new PedidoModel();

            $id_ped_web = $this->request->getPost("id_ped_web");
            $id_doc_emp = $this->request->getPost("id_doc_emp");

            $pedidoModel->anular_pedido($id_ped_web, $id_doc_emp);

            $errorSesion = $session->get('error');

            if(empty($errorSesion)) {
                $data = [ 'resultado' => '1' ];
                return $this->response->setJSON($data);
            } else {
                $data = array("resultado" => "ERROR", "msn" => $errorSesion);
                return $this->response->setJSON($data);
            }

        } catch (\Throwable $e) {
            $data = array("resultado" => "ERROR", "msn" => $e->getMessage());
            return $this->response->setJSON($data);
        }
    }

    //=============================================================================================================
    //
    //=============================================================================================================
    public function form_consultar_pedido($id_ped_web, $id_doc_emp)
    {
        try {
            $session = session();
            $session->remove('error');

            $sesionusuario = $session->get('datossesionusuario');

            if (!isset($sesionusuario["Model_usuario"])) {
                return redirect()->to(base_url('LoginController/login'));
            }

            $arreglo = array(
                'Model_usuario' => $sesionusuario["Model_usuario"],
                'id_ped_web' => $id_ped_web,
                'id_doc_emp' => $id_doc_emp
            );

            return view('pedido/consultapedido', $arreglo);

        } catch (\Throwable $e) {
            $sesionModel = new SesionModel();
            $sesionModel->actualizar_session(0);
            $errorModel = new ErrorModel();
            $modeloerror = $errorModel->consultar_error('0', $e->getMessage());
            return view('error/index', $modeloerror);
        }
    }

    //=============================================================================================================
    //
    //=============================================================================================================
    public function consultar_pedido()
    {
        try {
            $session = session();
            $session->remove('error');
            $sesionModel  = new SesionModel();
            $errorModel   = new ErrorModel();
            $pedidoModel  = new PedidoModel();

            $sesionusuario = $session->get('datossesionusuario');

            $id_ped_web = $this->request->getPost("id_ped_web");
            $id_doc_emp = $this->request->getPost("id_doc_emp");

            $arreglopedido = $pedidoModel->consultar_pedido($id_ped_web, "%", "%", "%", "%", "%", "%", "%", "%");
            $errorSesion = $session->get('error');

            if(!empty($errorSesion))
            {
                $sesionModel->actualizar_session(0);
                $modeloerror = $errorModel->consultar_error('0', $errorSesion);
                return view('error/index', $modeloerror);
            }
            else if (is_array($arreglopedido) && count($arreglopedido) == 0 && empty($errorSesion))
            {
                $data = array('resultado' => "0");
                return $this->response->setJSON($data);
            }
            else if (is_array($arreglopedido) && count($arreglopedido) > 0 && empty($errorSesion))
            {
                $arreglopedidodesc = $pedidoModel->consultar_pedido_descuento("%", "%", "%", "%", "%");
                $errorSesionDesc = $session->get('error');

                if(!empty($errorSesionDesc))
                {
                    $sesionModel->actualizar_session(0);
                    $modeloerror = $errorModel->consultar_error('0', $errorSesionDesc);
                    return view('error/index', $modeloerror);
                }
                else if (is_array($arreglopedidodesc) && count($arreglopedidodesc) >= 0 && empty($errorSesionDesc))
                {
                    $data = array(
                        'resultado' => "1",
                        'Model_consultar_pedido' => $arreglopedido,
                        'Model_consultar_pedido_desc' => $arreglopedidodesc
                    );
                    return $this->response->setJSON($data);
                }
                else
                {
                    $sesionModel->actualizar_session(0);
                    $modeloerror = $errorModel->consultar_error('4', '');
                    return view('error/index', $modeloerror);
                }
            }
            else
            {
                $sesionModel->actualizar_session(0);
                $modeloerror = $errorModel->consultar_error('4', '');
                return view('error/index', $modeloerror);
            }

        } catch (\Throwable $e) {
            $data = array("resultado" => "ERROR", "msn" => $e->getMessage());
            return $this->response->setJSON($data);
        }
    }

    //=============================================================================================================
    //
    //=============================================================================================================
    public function consultar_pedido_fecha($txtdesde, $txthasta, $cmbvendedor, $cmbcliente, $est_anulado, $cmbempresa, $cmbestatus)
    {
        try {
            $session = session();
            $session->remove('error');
            $sesionModel  = new SesionModel();
            $errorModel   = new ErrorModel();
            $pedidoModel  = new PedidoModel();

            $sesionusuario = $session->get('datossesionusuario');
            $idusuario     = $sesionusuario["Model_usuario"][0]["idusuario"];

            if($cmbvendedor == "" || $cmbvendedor == "0") { $cmbvendedor = "%"; }
            if($cmbcliente == "" || $cmbcliente == "0") { $cmbcliente = "%"; }
            if($cmbempresa == "" || $cmbempresa == "0") { $cmbempresa = "%"; }

            if($cmbestatus == "" || $cmbestatus == "0") {
                $cmbestatus_aux = "%";
            }
            elseif($cmbestatus == "FACTURADO" || $cmbestatus == "DESPACHADO") {
                $cmbestatus_aux = "APROBADO";
            }
            else {
                $cmbestatus_aux = $cmbestatus;
            }

            $arreglopedido = $pedidoModel->consultar_pedido_fecha($txtdesde, $txthasta, $idusuario, $cmbvendedor, $cmbcliente, $est_anulado, $cmbempresa, $cmbestatus_aux);
            $errorSesion = $session->get('error');

            if(!empty($errorSesion))
            {
                $sesionModel->actualizar_session(0);
                $modeloerror = $errorModel->consultar_error('0', $errorSesion);
                return view('error/index', $modeloerror);
            }
            else if (is_array($arreglopedido) && count($arreglopedido) >= 0 && empty($errorSesion))
            {
                $arreglopedidodesc = $pedidoModel->consultar_pedido_descuento("%", "%", "%", "%", "%");
                $errorSesionDesc = $session->get('error');

                if(!empty($errorSesionDesc))
                {
                    $sesionModel->actualizar_session(0);
                    $modeloerror = $errorModel->consultar_error('0', $errorSesionDesc);
                    return view('error/index', $modeloerror);
                }
                else if (is_array($arreglopedidodesc) && count($arreglopedidodesc) >= 0 && empty($errorSesionDesc))
                {
                    $arreglo = array(
                        'Model_usuario' => $sesionusuario["Model_usuario"],
                        'Model_consultar_pedido' => $arreglopedido,
                        'Model_consultar_pedido_desc' => $arreglopedidodesc,
                        'par_desde' => $txtdesde,
                        'par_hasta' => $txthasta,
                        'par_vendedor' => $cmbvendedor,
                        'par_cliente' => $cmbcliente,
                        'par_est_anulado' => $est_anulado,
                        'par_empresa' => $cmbempresa,
                        'par_estatus' => $cmbestatus
                    );
                    return view('pedido/listapedido', $arreglo);
                }
                else
                {
                    $sesionModel->actualizar_session(0);
                    $modeloerror = $errorModel->consultar_error('4', '');
                    return view('error/index', $modeloerror);
                }
            }
            else
            {
                $sesionModel->actualizar_session(0);
                $modeloerror = $errorModel->consultar_error('4', '');
                return view('error/index', $modeloerror);
            }

        } catch (\Throwable $e) {
            $sesionModel = new SesionModel();
            $sesionModel->actualizar_session(0);
            $errorModel = new ErrorModel();
            $modeloerror = $errorModel->consultar_error('0', $e->getMessage());
            return view('error/index', $modeloerror);
        }
    }

    //=============================================================================================================
    //
    //=============================================================================================================
    public function consultar_pedido_documentos_asociados()
    {
        try {
            $session = session();
            $session->remove('error');
            $sesionModel  = new SesionModel();
            $errorModel   = new ErrorModel();
            $pedidoModel  = new PedidoModel();

            $id_ped_web = $this->request->getPost("id_ped_web");
            $id_doc_emp = $this->request->getPost("id_doc_emp");
            $id_ped_aso = $this->request->getPost("id_ped_aso");

            $arreglo = $pedidoModel->consultar_pedido_documentos_asociados($id_ped_web, $id_doc_emp, $id_ped_aso);
            $errorSesion = $session->get('error');

            if(!empty($errorSesion))
            {
                $sesionModel->actualizar_session(0);
                $modeloerror = $errorModel->consultar_error('0', $errorSesion);
                return view('error/index', $modeloerror);
            }
            else if (is_array($arreglo) && count($arreglo) == 0 && empty($errorSesion))
            {
                $data = array('resultado' => "0");
                return $this->response->setJSON($data);
            }
            else if (is_array($arreglo) && count($arreglo) > 0 && empty($errorSesion))
            {
                $data = array(
                    'resultado' => "1",
                    'Model_consultar_pedido_documentos_asociados' => $arreglo
                );
                return $this->response->setJSON($data);
            }
            else
            {
                $sesionModel->actualizar_session(0);
                $modeloerror = $errorModel->consultar_error('4', '');
                return view('error/index', $modeloerror);
            }

        } catch (\Throwable $e) {
            $data = array("resultado" => "ERROR", "msn" => $e->getMessage());
            return $this->response->setJSON($data);
        }
    }

    //=============================================================================================================
    //
    //=============================================================================================================
    public function excelpedido($txtdesde, $txthasta, $cmbvendedor, $cmbcliente, $est_anulado, $cmbempresa, $cmbestatus)
    {
        try {
            // Elevar límite de memoria y tiempo de ejecución para el renderizado
            ini_set('memory_limit', '512M');
            set_time_limit(300);

            $session = session();
            $session->remove('error');
            $sesionModel  = new SesionModel();
            $errorModel   = new ErrorModel();
            $pedidoModel  = new PedidoModel();

            $sesionusuario = $session->get('datossesionusuario');
            $idusuario     = $sesionusuario["Model_usuario"][0]["idusuario"];

            //-----------------------------------------------------------------------
            // Si no existe una sesión activa
            //-----------------------------------------------------------------------
            if (!isset($sesionusuario["Model_usuario"])) {
                return redirect()->to(base_url('LoginController/login'));
            }
            //-----------------------------------------------------------------------

            if($cmbvendedor == "" || $cmbvendedor == "0") { $cmbvendedor = "%"; }
            if($cmbcliente == "" || $cmbcliente == "0") { $cmbcliente = "%"; }
            if($cmbempresa == "" || $cmbempresa == "0") { $cmbempresa = "%"; }

            if($cmbestatus == "" || $cmbestatus == "0") {
                $cmbestatus_aux = "%";
            }
            elseif($cmbestatus == "FACTURADO" || $cmbestatus == "DESPACHADO") {
                $cmbestatus_aux = "APROBADO";
            }
            else {
                $cmbestatus_aux = $cmbestatus;
            }
            $var_estatus = $cmbestatus;

            $arreglopedido = $pedidoModel->consultar_pedido_fecha($txtdesde, $txthasta, $idusuario, $cmbvendedor, $cmbcliente, $est_anulado, $cmbempresa, $cmbestatus_aux);
            $errorSesion = $session->get('error');

            if(!empty($errorSesion))
            {
                $sesionModel->actualizar_session(0);
                $modeloerror = $errorModel->consultar_error('0', $errorSesion);
                return view('error/index', $modeloerror);
            }
            else if (is_array($arreglopedido) && count($arreglopedido) >= 0 && empty($errorSesion))
            {
                $arreglopedidodesc = $pedidoModel->consultar_pedido_descuento("%", "%", "%", "%", "%");
                $errorSesionDesc = $session->get('error');

                if(!empty($errorSesionDesc))
                {
                    $sesionModel->actualizar_session(0);
                    $modeloerror = $errorModel->consultar_error('0', $errorSesionDesc);
                    return view('error/index', $modeloerror);
                }
                else if (is_array($arreglopedidodesc) && count($arreglopedidodesc) >= 0 && empty($errorSesionDesc))
                {
                    // 1. Cargar la librería usando la ruta exacta compatible
                    require_once(APPPATH . 'ThirdParty/PHPExcel/Classes/PHPExcel.php');
                    $objPHPExcel = new \PHPExcel();

                    $sheet = $objPHPExcel->getActiveSheet();
                    $sheet->setTitle('Pedidos');

                    // 3. Encabezados
                    $headers = [
                        'Est.', 'Empresa', 'Pedido/Venta', 'Pedido/Promo', 'Fecha Pedido', 'Vendedor',
                        'Cliente', 'Zona', 'Producto', 'Cant/Venta', 'Cant/Promo', 'Exist/Buena',
                        'Direccion', 'Fecha Facturado', 'Fecha Despachado'
                    ];

                    $col = 'A';
                    foreach ($headers as $header) {
                        $sheet->setCellValue($col . '1', $header);
                        $col++;
                    }

                    // Estilo del Encabezado
                    $headerStyle = array(
                        'font' => array('bold' => true, 'color' => array('rgb' => 'FFFFFF')),
                        'fill' => array(
                            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => '337AB7')
                        ),
                        'alignment' => array(
                            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical'   => \PHPExcel_Style_Alignment::VERTICAL_CENTER
                        )
                    );
                    $sheet->getStyle('A1:O1')->applyFromArray($headerStyle);

                    // 4. Llenado de Datos
                    $row = 2;
                    $var_pedido_doc = "";

                    foreach ($arreglopedido as $pedido) {

                        if($var_pedido_doc != $pedido["pedidos_documentos_aso"])
                        {
                            $var_pedido_doc = $pedido["pedidos_documentos_aso"];

                            if( (($var_estatus == 'APROBADO') &&
                                 ($pedido["ctv_de_estado_documento"] == 'APROBADO') &&
                                 ($pedido["fec_nos"] != "") &&
                                 ($pedido["fec_fac"] == "")) ||

                                (($var_estatus == 'APROBADO') &&
                                 ($pedido["ctv_de_estado_documento"] == 'APROBADO') &&
                                 ($pedido["fec_nos"] != "") &&
                                 ($pedido["fec_fac"] != "")) ||

                                (($var_estatus == 'APROBADO') &&
                                 ($pedido["ctv_de_estado_documento"] == 'APROBADO') &&
                                 ($pedido["fec_nos"] == "") &&
                                 ($pedido["fec_fac"] != "")) ||

                                (($var_estatus == 'APROBADO') &&
                                 ($pedido["ctv_de_estado_documento"] != 'APROBADO')) ||

                                (($var_estatus == 'FACTURADO') &&
                                 ($pedido["ctv_de_estado_documento"] != 'APROBADO')) ||

                                (($var_estatus == 'FACTURADO') &&
                                 ($pedido["ctv_de_estado_documento"] == 'APROBADO') &&
                                 ($pedido["fec_nos"] != "") &&
                                 ($pedido["fec_fac"] == "")) ||

                                (($var_estatus == 'FACTURADO') &&
                                 ($pedido["ctv_de_estado_documento"] == 'APROBADO') &&
                                 ($pedido["fec_nos"] != "") &&
                                 ($pedido["fec_fac"] != "")) ||

                                (($var_estatus == 'FACTURADO') &&
                                 ($pedido["ctv_de_estado_documento"] == 'APROBADO') &&
                                 ($pedido["fec_nos"] == "") &&
                                 ($pedido["fec_fac"] == ""))  ) {
                            }
                            else {

                                $estatus_pedido_ = '';
                                if ( ($pedido["fec_nos"] != "") && ($pedido["fec_fac"] == "") ) {
                                    $estatus_pedido_ =  "DESPACHADO";
                                }
                                elseif ( ($pedido["fec_nos"] != "") && ($pedido["fec_fac"] != "") ) {
                                    $estatus_pedido_ =  "DESPACHADO";
                                }
                                elseif ( ($pedido["fec_nos"] == "") && ($pedido["fec_fac"] != "") ) {
                                    $estatus_pedido_ =  "FACTURADO";
                                }
                                else {
                                    $estatus_pedido_ =  $pedido["ctv_de_estado_documento"];
                                }

                                $fecha_factura_ = '';
                                if (is_null($pedido["fec_fac"])) {
                                    $fecha_factura_ = "S/F";
                                }
                                else {
                                    $fecha_factura_ = $pedido["fec_fac"];
                                }

                                $fecha_despacho_ = '';
                                if (is_null($pedido["fec_nos"])) {
                                    $fecha_despacho_ = "S/D";
                                }
                                else {
                                    $fecha_despacho_ = $pedido["fec_nos"];
                                }

                                // Filtrar productos asociados
                                $productosAsociadas = array_filter($arreglopedido, function($item) use ($var_pedido_doc) {
                                    return $item["pedidos_documentos_aso"] == $var_pedido_doc;
                                });

                                $cantProductos = count($productosAsociadas);
                                $totalFilas    = max(1, $cantProductos);

                                $startRow = $row;
                                $endRow   = $startRow + $totalFilas - 1;

                                // Escribir fila principal
                                $sheet->setCellValue("A{$startRow}", $estatus_pedido_);
                                $sheet->setCellValue("B{$startRow}", $pedido['co_empresa']);
                                $sheet->setCellValue("C{$startRow}", $pedido['nu_pedido']);
                                $sheet->setCellValue("D{$startRow}", $pedido['nu_pedido_promo']);
                                $sheet->setCellValue("E{$startRow}", $pedido['fe_emision']);
                                $sheet->setCellValue("F{$startRow}", $pedido['nb_vendedor']);
                                $sheet->setCellValue("G{$startRow}", $pedido['nb_organizacion']);
                                $sheet->setCellValue("H{$startRow}", $pedido['co_zona']);

                                // Sub-tabla Facturas
                                $prodRow = $startRow;
                                foreach ($productosAsociadas as $productos) {
                                    $sheet->setCellValue("I{$prodRow}", $productos["nb_producto"]);
                                    $sheet->setCellValue("J{$prodRow}", $productos["ca_producto"]);
                                    $sheet->setCellValue("K{$prodRow}", $productos["ca_producto_promo"]);
                                    $sheet->setCellValue("L{$prodRow}", $productos["ca_buena_condicion"]);
                                    $prodRow++;
                                }

                                $sheet->setCellValue("M{$startRow}", $pedido['tx_direccion_entrega']);
                                $sheet->setCellValue("N{$startRow}", $fecha_factura_);
                                $sheet->setCellValue("O{$startRow}", $fecha_despacho_);

                                // Combinar celdas (merge) si hay múltiples registros anidados
                                if ($totalFilas > 1) {
                                    foreach (range('A', 'H') as $colLetter) {
                                        $sheet->mergeCells("{$colLetter}{$startRow}:{$colLetter}{$endRow}");
                                        $sheet->getStyle("{$colLetter}{$startRow}")->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                    }
                                }

                                if ($totalFilas > 1) {
                                    foreach (range('M', 'O') as $colLetter) {
                                        $sheet->mergeCells("{$colLetter}{$startRow}:{$colLetter}{$endRow}");
                                        $sheet->getStyle("{$colLetter}{$startRow}")->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                    }
                                }

                                $row = $endRow + 1;
                            }
                        }
                    }

                    // Autoajustar ancho de columnas
                    foreach (range('A', 'O') as $colLetter) {
                        $sheet->getColumnDimension($colLetter)->setAutoSize(true);
                    }

                    // Limpieza estricta de todos los niveles del búfer de salida
                    while (ob_get_level() > 0) {
                        ob_end_clean();
                    }

                    $filename = 'Reporte_Pedidos_' . date('Ymd_His') . '.xls';

                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment;filename="' . $filename . '"');
                    header('Cache-Control: max-age=0');

                    $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                    $objWriter->save('php://output');
                    exit;
                }
                else
                {
                    $sesionModel->actualizar_session(0);
                    $modeloerror = $errorModel->consultar_error('4', '');
                    return view('error/index', $modeloerror);
                }
            }
            else
            {
                $sesionModel->actualizar_session(0);
                $modeloerror = $errorModel->consultar_error('4', '');
                return view('error/index', $modeloerror);
            }

        } catch (\Throwable $e) {
            $sesionModel = new SesionModel();
            $sesionModel->actualizar_session(0);
            $errorModel = new ErrorModel();
            $modeloerror = $errorModel->consultar_error('0', $e->getMessage());
            return view('error/index', $modeloerror);
        }
    }
}