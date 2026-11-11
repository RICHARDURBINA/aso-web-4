<?php

namespace App\Controllers;

use App\Models\SesionModel;
use App\Models\ErrorModel;
use App\Models\PlanModel;

class PlanController extends BaseController
{
    //=============================================================================================================
    //  PLANIFICACION DE PEDIDOS
    //=============================================================================================================
    public function planpedido()
    {
        try {
            $sesionModel = new SesionModel();
            $errorModel  = new ErrorModel();
            $planModel   = new PlanModel();

            $session = session();
            $session->remove('error');

            $sesionusuario = $session->get('datossesionusuario');

            if (!isset($sesionusuario["Model_usuario"])) {
                return redirect()->to(base_url('LoginController/login'));
            }

            $idusuario = $sesionusuario["Model_usuario"][0]["idusuario"];

            // Primer día
            $txtdesde = date('Y-m-01');
            // Último día
            $txthasta = date('Y-m-t');
            // Día actual
            $txtfecha = date('Y-m-d');

            // CONSERVAR LA URL
            $frase   = $_SERVER['REQUEST_URI'];
            $palabra = "PlanController";
            $posicion = strpos($frase, $palabra);
            $url = "";
            if ($posicion !== false) {
                $url = substr($frase, $posicion + strlen($palabra));
            } else {
                $palabra = "planController";
                $posicion = strpos($frase, $palabra);
                if ($posicion !== false) {
                    $url = substr($frase, $posicion + strlen($palabra));
                }
            }

            $arreglopedido = $planModel->consultar_pedido_vta_prom($idusuario, "%", "%", "%", "%", "%");
            $errorSesion = $session->get('error');

            if (!empty($errorSesion))
            {
                $sesionModel->actualizar_session(0);
                $modeloerror = $errorModel->consultar_error('0', $errorSesion);
                return view('error/index', $modeloerror);
            }
            else if (is_array($arreglopedido) && count($arreglopedido) >= 0)
            {
                $arreglo = array( 
                    'Model_usuario' => $sesionusuario["Model_usuario"],
                    'Model_consultar_pedido' => $arreglopedido,
                    'par_vendedor' => "%",
                    'par_cliente' => "%",
                    'par_empresa' => "%",
                    'par_estatus' => "%",
                    'par_fecha' => $txtfecha,
                    'par_url' => $url,
                    'par_producto' => "%" 
                );

                return view('plan/planpedido', $arreglo);
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

    public function consultar_pedido_vta_prom($cmbvendedor, $cmbcliente, $cmbempresa, $cmbestatus, $fe_emision, $cmbproducto)
    {
        try {
            $sesionModel = new SesionModel();
            $errorModel  = new ErrorModel();
            $planModel   = new PlanModel();

            $session = session();
            $session->remove('error');

            $sesionusuario = $session->get('datossesionusuario');

            if (!isset($sesionusuario["Model_usuario"])) {
                return redirect()->to(base_url('LoginController/login'));
            }

            $idusuario = $sesionusuario["Model_usuario"][0]["idusuario"];

            if($cmbvendedor == "" || $cmbvendedor == "0") { $cmbvendedor = "%"; }
            if($cmbcliente  == "" || $cmbcliente == "0") { $cmbcliente = "%"; }
            if($cmbempresa  == "" || $cmbempresa == "0") { $cmbempresa = "%"; }
            if($cmbestatus  == "" || $cmbestatus == "0") { $cmbestatus = "%"; }
            if($cmbproducto == "" || $cmbproducto == "0") { $cmbproducto = "%"; }

            $frase   = $_SERVER['REQUEST_URI'];
            $palabra = "PlanController";
            $posicion = strpos($frase, $palabra);
            $url = "";
            if ($posicion !== false) {
                $url = substr($frase, $posicion + strlen($palabra));
            } else {
                $palabra = "planController";
                $posicion = strpos($frase, $palabra);
                if ($posicion !== false) {
                    $url = substr($frase, $posicion + strlen($palabra));
                }
            }

            $arreglopedido = $planModel->consultar_pedido_vta_prom($idusuario, $cmbvendedor, $cmbcliente, $cmbempresa, $cmbestatus, $cmbproducto);
            $errorSesion = $session->get('error');

            if (!empty($errorSesion))
            {
                $sesionModel->actualizar_session(0);
                $modeloerror = $errorModel->consultar_error('0', $errorSesion);
                return view('error/index', $modeloerror);
            }
            else if (is_array($arreglopedido) && count($arreglopedido) >= 0)
            {
                $arreglo = array( 
                    'Model_usuario' => $sesionusuario["Model_usuario"],
                    'Model_consultar_pedido' => $arreglopedido,
                    'par_vendedor' => $cmbvendedor,
                    'par_cliente' => $cmbcliente,
                    'par_empresa' => $cmbempresa,
                    'par_estatus' => $cmbestatus,
                    'par_fecha' => $fe_emision,
                    'par_url' => $url,
                    'par_producto' => $cmbproducto 
                );

                return view('plan/planpedido', $arreglo);
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

    public function planificar_pedido()
    {
        try {
            $sesionModel = new SesionModel();
            $errorModel  = new ErrorModel();
            $planModel   = new PlanModel();

            $session = session();
            $session->remove('error');

            $sesionusuario = $session->get('datossesionusuario');
            if (!isset($sesionusuario["Model_usuario"])) {
                return redirect()->to(base_url('LoginController/login'));
            }

            $id_ped_web      = $this->request->getPost("id_ped_web");
            $id_doc_emp      = $this->request->getPost("id_doc_emp");
            $tipo_pedido     = $this->request->getPost("tipo_pedido");
            $tipo_documento  = $this->request->getPost("tipo_documento");
            $fe_emision      = $this->request->getPost("fe_emision");

            $arreglo = $planModel->consultar_detalle_pedido($id_ped_web, $id_doc_emp, $tipo_pedido, $tipo_documento);
            $errorSesion = $session->get('error');

            if (!empty($errorSesion))
            {
                $sesionModel->actualizar_session(0);
                $modeloerror = $errorModel->consultar_error('0', $errorSesion);
                return view('error/index', $modeloerror);
            }
            else if (is_array($arreglo) && count($arreglo) >= 0)
            {
                $planModel->planificar_pedido($fe_emision, $arreglo);
                $errorSesionPlan = $session->get('error');

                if (empty($errorSesionPlan))
                {
                    $data = [ 'resultado' => '1' ];
                    return $this->response->setJSON($data);
                }
                else
                {
                    $data = array("resultado" => "ERROR", "msn" => $errorSesionPlan);
                    return $this->response->setJSON($data);
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

    public function asociartransporte()
    {
        try {
            $sesionModel = new SesionModel();
            $errorModel  = new ErrorModel();
            $planModel   = new PlanModel();

            $session = session();
            $session->remove('error');

            $sesionusuario = $session->get('datossesionusuario');

            if (!isset($sesionusuario["Model_usuario"])) {
                return redirect()->to(base_url('LoginController/login'));
            }

            $idusuario = $sesionusuario["Model_usuario"][0]["idusuario"];
            $txtfecha = date('Y-m-d');

            $frase   = $_SERVER['REQUEST_URI'];
            $palabra = "PlanController";
            $posicion = strpos($frase, $palabra);
            $url = "";
            if ($posicion !== false) {
                $url = substr($frase, $posicion + strlen($palabra));
            } else {
                $palabra = "planController";
                $posicion = strpos($frase, $palabra);
                if ($posicion !== false) {
                    $url = substr($frase, $posicion + strlen($palabra));
                }
            }

            $arregloplan = $planModel->consultar_planificacion($txtfecha, $idusuario, "%", "%", "%", "%");
            $errorSesion = $session->get('error');

            if (!empty($errorSesion))
            {
                $sesionModel->actualizar_session(0);
                $modeloerror = $errorModel->consultar_error('0', $errorSesion);
                return view('error/index', $modeloerror);
            }
            else if (is_array($arregloplan) && count($arregloplan) >= 0)
            {
                $arregloinventario = $planModel->consultar_inventario($txtfecha, $idusuario);
                $errorSesionInv = $session->get('error');

                if (!empty($errorSesionInv))
                {
                    $sesionModel->actualizar_session(0);
                    $modeloerror = $errorModel->consultar_error('0', $errorSesionInv);
                    return view('error/index', $modeloerror);
                }
                else if (is_array($arregloinventario) && count($arregloinventario) >= 0)
                {
                    $arreglo = array( 
                        'Model_usuario' => $sesionusuario["Model_usuario"],
                        'Model_consultar_plan' => $arregloplan,
                        'Model_consultar_inv' => $arregloinventario,
                        'par_fecha' => $txtfecha,
                        'par_vendedor' => "%",
                        'par_cliente' => "%",
                        'par_empresa' => "%",
                        'par_estatus' => "%",
                        'par_url' => $url,
                        'par_fecha_inv' => $txtfecha 
                    );

                    return view('plan/asociartransporte', $arreglo);
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

    public function consultar_pedido_vta_prom_fecha($fe_emision, $cmbvendedor, $cmbcliente, $cmbempresa, $cmbestatus)
    {
        try {
            $sesionModel = new SesionModel();
            $errorModel  = new ErrorModel();
            $planModel   = new PlanModel();

            $session = session();
            $session->remove('error');

            $sesionusuario = $session->get('datossesionusuario');
            if (!isset($sesionusuario["Model_usuario"])) {
                return redirect()->to(base_url('LoginController/login'));
            }

            $idusuario = $sesionusuario["Model_usuario"][0]["idusuario"];

            if($cmbvendedor == "" || $cmbvendedor == "0") { $cmbvendedor = "%"; }
            if($cmbcliente  == "" || $cmbcliente == "0") { $cmbcliente = "%"; }
            if($cmbempresa  == "" || $cmbempresa == "0") { $cmbempresa = "%"; }
            if($cmbestatus  == "" || $cmbestatus == "0") { $cmbestatus = "%"; }

            $frase   = $_SERVER['REQUEST_URI'];
            $palabra = "PlanController";
            $posicion = strpos($frase, $palabra);
            $url = "";
            if ($posicion !== false) {
                $url = substr($frase, $posicion + strlen($palabra));
            } else {
                $palabra = "planController";
                $posicion = strpos($frase, $palabra);
                if ($posicion !== false) {
                    $url = substr($frase, $posicion + strlen($palabra));
                }
            }

            $arreglopedido = $planModel->consultar_planificacion($fe_emision, $idusuario, $cmbvendedor, $cmbcliente, $cmbempresa, $cmbestatus);
            $errorSesion = $session->get('error');

            if (!empty($errorSesion))
            {
                $sesionModel->actualizar_session(0);
                $modeloerror = $errorModel->consultar_error('0', $errorSesion);
                return view('error/index', $modeloerror);
            }
            else if (is_array($arreglopedido) && count($arreglopedido) >= 0)
            {
                $arregloinventario = $planModel->consultar_inventario($fe_emision, $idusuario);
                $errorSesionInv = $session->get('error');

                if (!empty($errorSesionInv))
                {
                    $sesionModel->actualizar_session(0);
                    $modeloerror = $errorModel->consultar_error('0', $errorSesionInv);
                    return view('error/index', $modeloerror);
                }
                else if (is_array($arregloinventario) && count($arregloinventario) >= 0)
                {
                    $arreglo = array( 
                        'Model_usuario' => $sesionusuario["Model_usuario"],
                        'Model_consultar_plan' => $arreglopedido,
                        'Model_consultar_inv' => $arregloinventario,
                        'par_fecha' => $fe_emision,
                        'par_vendedor' => $cmbvendedor,
                        'par_cliente' => $cmbcliente,
                        'par_empresa' => $cmbempresa,
                        'par_estatus' => $cmbestatus,
                        'par_url' => $url,
                        'par_fecha_inv' => $fe_emision 
                    );

                    return view('plan/asociartransporte', $arreglo);
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

    public function consultar_pedido_plan_fecha($txtdesde, $txthasta, $cmbvendedor, $cmbcliente, $cmbempresa, $cmbestatus, $cmbproducto)
    {
        try {
            $sesionModel = new SesionModel();
            $errorModel  = new ErrorModel();
            $planModel   = new PlanModel();

            $session = session();
            $session->remove('error');

            $sesionusuario = $session->get('datossesionusuario');
            if (!isset($sesionusuario["Model_usuario"])) {
                return redirect()->to(base_url('LoginController/login'));
            }

            $idusuario = $sesionusuario["Model_usuario"][0]["idusuario"];
            $fe_emision = date('Y-m-d');

            if($cmbvendedor == "" || $cmbvendedor == "0") { $cmbvendedor = "%"; }
            if($cmbcliente  == "" || $cmbcliente == "0") { $cmbcliente = "%"; }
            if($cmbempresa  == "" || $cmbempresa == "0") { $cmbempresa = "%"; }
            if($cmbestatus  == "" || $cmbestatus == "0") { $cmbestatus = "%"; }
            if($cmbproducto == "" || $cmbproducto == "0") { $cmbproducto = "%"; }

            $frase   = $_SERVER['REQUEST_URI'];
            $palabra = "PlanController";
            $posicion = strpos($frase, $palabra);
            $url = "";
            if ($posicion !== false) {
                $url = substr($frase, $posicion + strlen($palabra));
            } else {
                $palabra = "planController";
                $posicion = strpos($frase, $palabra);
                if ($posicion !== false) {
                    $url = substr($frase, $posicion + strlen($palabra));
                }
            }

            $arreglopedido = $planModel->consultar_planificacion_fecha($txtdesde, $txthasta, $idusuario, $cmbvendedor, $cmbcliente, $cmbempresa, $cmbestatus, $cmbproducto);
            $errorSesion = $session->get('error');

            if (!empty($errorSesion))
            {
                $sesionModel->actualizar_session(0);
                $modeloerror = $errorModel->consultar_error('0', $errorSesion);
                return view('error/index', $modeloerror);
            }
            else if (is_array($arreglopedido) && count($arreglopedido) >= 0)
            {
                $arregloinventario = $planModel->consultar_inventario($fe_emision, $idusuario);
                $errorSesionInv = $session->get('error');

                if (!empty($errorSesionInv))
                {
                    $sesionModel->actualizar_session(0);
                    $modeloerror = $errorModel->consultar_error('0', $errorSesionInv);
                    return view('error/index', $modeloerror);
                }
                else if (is_array($arregloinventario) && count($arregloinventario) >= 0)
                {
                    $arreglo = array( 
                        'Model_usuario' => $sesionusuario["Model_usuario"],
                        'Model_consultar_plan' => $arreglopedido,
                        'Model_consultar_inv' => $arregloinventario,
                        'par_desde' => $txtdesde,
                        'par_hasta' => $txthasta,
                        'par_vendedor' => $cmbvendedor,
                        'par_cliente' => $cmbcliente,
                        'par_empresa' => $cmbempresa,
                        'par_estatus' => $cmbestatus,
                        'par_url' => $url,
                        'par_producto' => $cmbproducto,
                        'par_fecha_inv' => $fe_emision 
                    );

                    return view('plan/listaplanpedido', $arreglo);
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

    public function anular_plan()
    {
        try {
            $session = session();
            $session->remove('error');
            $planModel = new PlanModel();

            $id_ped_web = $this->request->getPost("id_ped_web");
            $id_doc_emp = $this->request->getPost("id_doc_emp");
            $nu_pedido  = $this->request->getPost("nu_pedido");
            $ti_doc     = $this->request->getPost("ti_doc");

            $planModel->anular_plan($id_ped_web, $id_doc_emp, $nu_pedido, $ti_doc);
            $errorSesion = $session->get('error');

            if (empty($errorSesion))
            {
                $data = [ 'resultado' => '1' ];
                return $this->response->setJSON($data);
            }
            else
            {
                $data = array("resultado" => "ERROR", "msn" => $errorSesion);
                return $this->response->setJSON($data);
            }

        } catch (\Throwable $e) {
            $data = array("resultado" => "ERROR", "msn" => $e->getMessage());
            return $this->response->setJSON($data);
        }
    }

    public function aplicar_nc_total()
    {
        try {
            $session = session();
            $session->remove('error');
            $planModel = new PlanModel();

            $id_ped_web = $this->request->getPost("id_ped_web");
            $id_doc_emp = $this->request->getPost("id_doc_emp");
            $nu_pedido  = $this->request->getPost("nu_pedido");
            $ti_doc     = $this->request->getPost("ti_doc");

            $planModel->aplicar_nc_total($id_ped_web, $id_doc_emp, $nu_pedido, $ti_doc);
            $errorSesion = $session->get('error');

            if (empty($errorSesion))
            {
                $data = [ 'resultado' => '1' ];
                return $this->response->setJSON($data);
            }
            else
            {
                $data = array("resultado" => "ERROR", "msn" => $errorSesion);
                return $this->response->setJSON($data);
            }

        } catch (\Throwable $e) {
            $data = array("resultado" => "ERROR", "msn" => $e->getMessage());
            return $this->response->setJSON($data);
        }
    }

    public function anular_transporte()
    {
        try {
            $session = session();
            $session->remove('error');
            $planModel = new PlanModel();

            $id_ped_web = $this->request->getPost("id_ped_web");
            $id_doc_emp = $this->request->getPost("id_doc_emp");
            $nu_pedido  = $this->request->getPost("nu_pedido");
            $ti_doc     = $this->request->getPost("ti_doc");

            $planModel->anular_transporte($id_ped_web, $id_doc_emp, $nu_pedido, $ti_doc);
            $errorSesion = $session->get('error');

            if (empty($errorSesion))
            {
                $planModel->sincronizar_transporte($id_ped_web, $id_doc_emp, $nu_pedido, 'N', $ti_doc);
                $errorSesionSync = $session->get('error');

                if (empty($errorSesionSync))
                {
                    $data = [ 'resultado' => '1' ];
                    return $this->response->setJSON($data);
                }
                else
                {
                    $data = array("resultado" => "ERROR", "msn" => $errorSesionSync);
                    return $this->response->setJSON($data);
                }
            }
            else
            {
                $data = array("resultado" => "ERROR", "msn" => $errorSesion);
                return $this->response->setJSON($data);
            }

        } catch (\Throwable $e) {
            $data = array("resultado" => "ERROR", "msn" => $e->getMessage());
            return $this->response->setJSON($data);
        }
    }

    public function consultar_control_cola_disponible()
    {
        try {
            $sesionModel = new SesionModel();
            $errorModel  = new ErrorModel();
            $planModel   = new PlanModel();

            $session = session();
            $session->remove('error');

            $sesionusuario = $session->get('datossesionusuario');

            $cmbtipocola = $this->request->getPost("cmbtipocola") ?? "%";
            $cmbtransportista = $this->request->getPost("cmbtransportista") ?? "%";
            $idusuario = $sesionusuario["Model_usuario"][0]["idusuario"];

            $arreglocola = $planModel->consultar_control_cola_disponible($idusuario, $cmbtipocola, $cmbtransportista);
            $errorSesion = $session->get('error');

            if (!empty($errorSesion))
            {
                $sesionModel->actualizar_session(0);
                $modeloerror = $errorModel->consultar_error('0', $errorSesion);
                return view('error/index', $modeloerror);
            }
            else if (is_array($arreglocola) && count($arreglocola) == 0)
            {
                $data = array('resultado' => "0");
                return $this->response->setJSON($data);
            }
            else if (is_array($arreglocola) && count($arreglocola) > 0)
            {
                $arreglo = array( 
                    'resultado' => "1",
                    'Model_usuario' => $sesionusuario["Model_usuario"],
                    'Model_consultar_cola' => $arreglocola,
                    'par_tipocola' => $cmbtipocola,
                    'par_transportista' => $cmbtransportista 
                );

                return $this->response->setJSON($arreglo);
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

    public function asignar_transporte()
    {
        try {
            $session = session();
            $session->remove('error');
            $planModel = new PlanModel();

            $id_ped_web = $this->request->getPost("id_ped_web");
            $id_doc_emp = $this->request->getPost("id_doc_emp");
            $nu_pedido  = $this->request->getPost("nu_pedido");
            $id_cola    = $this->request->getPost("id_cola");
            $ti_doc     = $this->request->getPost("ti_doc");

            $planModel->asignar_transporte($id_ped_web, $id_doc_emp, $nu_pedido, $id_cola, $ti_doc);
            $errorSesion = $session->get('error');

            if (empty($errorSesion))
            {
                $planModel->sincronizar_transporte($id_ped_web, $id_doc_emp, $nu_pedido, 'S', $ti_doc);
                $errorSesionSync = $session->get('error');

                if (empty($errorSesionSync))
                {
                    $data = [ 'resultado' => '1' ];
                    return $this->response->setJSON($data);
                }
                else
                {
                    $data = array("resultado" => "ERROR", "msn" => $errorSesionSync);
                    return $this->response->setJSON($data);
                }
            }
            else
            {
                $data = array("resultado" => "ERROR", "msn" => $errorSesion);
                return $this->response->setJSON($data);
            }

        } catch (\Throwable $e) {
            $data = array("resultado" => "ERROR", "msn" => $e->getMessage());
            return $this->response->setJSON($data);
        }
    }

    public function sincronizar_transporte()
    {
        try {
            $session = session();
            $session->remove('error');
            $planModel = new PlanModel();

            $id_ped_web = $this->request->getPost("id_ped_web");
            $id_doc_emp = $this->request->getPost("id_doc_emp");
            $nu_pedido  = $this->request->getPost("nu_pedido");
            $ti_doc     = $this->request->getPost("ti_doc");

            $planModel->sincronizar_transporte($id_ped_web, $id_doc_emp, $nu_pedido, 'S', $ti_doc);
            $errorSesion = $session->get('error');

            if (empty($errorSesion))
            {
                $data = [ 'resultado' => '1' ];
                return $this->response->setJSON($data);
            }
            else
            {
                $data = array("resultado" => "ERROR", "msn" => $errorSesion);
                return $this->response->setJSON($data);
            }

        } catch (\Throwable $e) {
            $data = array("resultado" => "ERROR", "msn" => $e->getMessage());
            return $this->response->setJSON($data);
        }
    }

    public function excelgestiontransporte($txtdesde, $txthasta, $cmbvendedor, $cmbcliente, $cmbempresa, $cmbestatus, $cmbproducto)
    {
        try {
            $sesionModel = new SesionModel();
            $errorModel  = new ErrorModel();
            $planModel   = new PlanModel();

            $session = session();
            $session->remove('error');

            $sesionusuario = $session->get('datossesionusuario');
            if (!isset($sesionusuario["Model_usuario"])) {
                return redirect()->to(base_url('LoginController/login'));
            }

            $idusuario = $sesionusuario["Model_usuario"][0]["idusuario"];
            $fe_emision = date('Y-m-d');

            if($cmbvendedor == "" || $cmbvendedor == "0") { $cmbvendedor = "%"; }
            if($cmbcliente  == "" || $cmbcliente == "0") { $cmbcliente = "%"; }
            if($cmbempresa  == "" || $cmbempresa == "0") { $cmbempresa = "%"; }
            if($cmbestatus  == "" || $cmbestatus == "0") { $cmbestatus = "%"; }
            if($cmbproducto == "" || $cmbproducto == "0") { $cmbproducto = "%"; }

            $arreglopedido = $planModel->consultar_planificacion_fecha($txtdesde, $txthasta, $idusuario, $cmbvendedor, $cmbcliente, $cmbempresa, $cmbestatus, $cmbproducto);
            $errorSesion = $session->get('error');

            if (!empty($errorSesion))
            {
                $sesionModel->actualizar_session(0);
                $modeloerror = $errorModel->consultar_error('0', $errorSesion);
                return view('error/index', $modeloerror);
            }
            else if (is_array($arreglopedido) && count($arreglopedido) >= 0)
            {
                $arregloinventario = $planModel->consultar_inventario($fe_emision, $idusuario);
                $errorSesionInv = $session->get('error');

                if (!empty($errorSesionInv))
                {
                    $sesionModel->actualizar_session(0);
                    $modeloerror = $errorModel->consultar_error('0', $errorSesionInv);
                    return view('error/index', $modeloerror);
                }
                else if (is_array($arregloinventario) && count($arregloinventario) >= 0)
                {
                    require_once(APPPATH . 'ThirdParty/PHPExcel/Classes/PHPExcel.php');
                    $objPHPExcel = new \PHPExcel();

                    $sheet = $objPHPExcel->getActiveSheet();
                    $sheet->setTitle('Gestion');

                    $headers = [
                        'Est.', 'Empresa', 'Fecha Plan', 'Pedido', 'Tipo', 'Fecha Pedido', 'Vendedor',
                        'Chofer', 'Vehiculo', 'Cliente', 'Zona', 'Producto', 'Cantidad', 'Direccion'
                    ];

                    $col = 'A';
                    foreach ($headers as $header) {
                        $sheet->setCellValue($col . '1', $header);
                        $col++;
                    }

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
                    $sheet->getStyle('A1:N1')->applyFromArray($headerStyle);

                    $row = 2;
                    $var_pedido_doc = '';
                    $var_tipo_pedido = '';

                    foreach ($arreglopedido as $pedido) {
                        if(($var_pedido_doc != $pedido["pedidos_documentos_aso"]) || ($var_tipo_pedido != $pedido["tipo_pedido"]))
                        {
                            $estatus_pedido_ = '';
                            $nombre_chofer = '';
                            $vehiculo_chofer = '';

                            $var_pedido_doc = $pedido["pedidos_documentos_aso"];
                            $var_tipo_pedido = $pedido["tipo_pedido"];

                            if (($pedido["total_nos"] > 0) && ($pedido["total_fac"] == 0)) {
                                $estatus_pedido_ = "DESPACHADO";
                            }
                            elseif (($pedido["total_nos"] > 0) && ($pedido["total_fac"] > 0)) {
                                $estatus_pedido_ = "DESPACHADO";
                            }
                            elseif (($pedido["total_nos"] == 0) && ($pedido["total_fac"] > 0)) {
                                $estatus_pedido_ = "FACTURADO";
                            }
                            else {
                                $estatus_pedido_ = $pedido["ctv_de_estado_documento"];
                            }

                            if($pedido["co_chofer"] != "") {
                                $nombre_chofer = "(" . $pedido["co_chofer"] . ") " . $pedido["nb_chofer"];
                            }

                            if($pedido["co_vehiculo"] != "") {
                                $vehiculo_chofer = $pedido["co_vehiculo"];
                            }

                            $productosAsociadas = array_filter($arreglopedido, function($item) use ($var_pedido_doc, $var_tipo_pedido) {
                                return ($item["pedidos_documentos_aso"] == $var_pedido_doc) && ($item["tipo_pedido"] == $var_tipo_pedido);
                            });

                            $cantProductos = count($productosAsociadas);
                            $totalFilas    = max(1, $cantProductos);

                            $startRow = $row;
                            $endRow   = $startRow + $totalFilas - 1;

                            $sheet->setCellValue("A{$startRow}", $estatus_pedido_);
                            $sheet->setCellValue("B{$startRow}", $pedido['co_empresa']);
                            $sheet->setCellValue("C{$startRow}", $pedido['fe_plan']);
                            $sheet->setCellValue("D{$startRow}", $pedido['nu_pedido']);
                            $sheet->setCellValue("E{$startRow}", $pedido['tipo_pedido']);
                            $sheet->setCellValue("F{$startRow}", $pedido['fe_emision']);
                            $sheet->setCellValue("G{$startRow}", $pedido['nb_vendedor']);

                            $sheet->setCellValue("H{$startRow}", $nombre_chofer);
                            $sheet->setCellValue("I{$startRow}", $vehiculo_chofer);
                            $sheet->setCellValue("J{$startRow}", $pedido['nb_organizacion']);
                            $sheet->setCellValue("K{$startRow}", $pedido['co_zona']);

                            $prodRow = $startRow;
                            foreach ($productosAsociadas as $productos) {
                                $sheet->setCellValue("L{$prodRow}", $productos["nb_producto"]);
                                $sheet->setCellValue("M{$prodRow}", $productos["ca_producto"]);
                                $prodRow++;
                            }

                            $sheet->setCellValue("N{$startRow}", $pedido['tx_direccion_entrega']);

                            if ($totalFilas > 1) {
                                foreach (range('A', 'K') as $colLetter) {
                                    $sheet->mergeCells("{$colLetter}{$startRow}:{$colLetter}{$endRow}");
                                    $sheet->getStyle("{$colLetter}{$startRow}")->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                }
                            }

                            if ($totalFilas > 1) {
                                $sheet->mergeCells("N{$startRow}:N{$endRow}");
                                $sheet->getStyle("N{$startRow}")->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
                            }

                            $row = $endRow + 1;
                        }
                    }

                    foreach (range('A', 'N') as $colLetter) {
                        $sheet->getColumnDimension($colLetter)->setAutoSize(true);
                    }

                    while (ob_get_level() > 0) {
                        ob_end_clean();
                    }

                    $filename = 'Reporte_Gestion_' . date('Ymd_His') . '.xls';

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

    public function listaplanpedido()
    {
        try {
            $sesionModel = new SesionModel();
            $errorModel  = new ErrorModel();
            $planModel   = new PlanModel();

            $session = session();
            $session->remove('error');

            $sesionusuario = $session->get('datossesionusuario');

            if (!isset($sesionusuario["Model_usuario"])) {
                return redirect()->to(base_url('LoginController/login'));
            }

            $idusuario = $sesionusuario["Model_usuario"][0]["idusuario"];
            $txtfecha = date('Y-m-d');

            $frase   = $_SERVER['REQUEST_URI'];
            $palabra = "PlanController";
            $posicion = strpos($frase, $palabra);
            $url = "";
            if ($posicion !== false) {
                $url = substr($frase, $posicion + strlen($palabra));
            } else {
                $palabra = "planController";
                $posicion = strpos($frase, $palabra);
                if ($posicion !== false) {
                    $url = substr($frase, $posicion + strlen($palabra));
                }
            }

            $arregloplan = $planModel->consultar_planificacion_fecha($txtfecha, $txtfecha, $idusuario, "%", "%", "%", "%", "%");
            $errorSesion = $session->get('error');

            if (!empty($errorSesion))
            {
                $sesionModel->actualizar_session(0);
                $modeloerror = $errorModel->consultar_error('0', $errorSesion);
                return view('error/index', $modeloerror);
            }
            else if (is_array($arregloplan) && count($arregloplan) >= 0)
            {
                $arregloinventario = $planModel->consultar_inventario($txtfecha, $idusuario);
                $errorSesionInv = $session->get('error');

                if (!empty($errorSesionInv))
                {
                    $sesionModel->actualizar_session(0);
                    $modeloerror = $errorModel->consultar_error('0', $errorSesionInv);
                    return view('error/index', $modeloerror);
                }
                else if (is_array($arregloinventario) && count($arregloinventario) >= 0)
                {
                    $arreglo = array( 
                        'Model_usuario' => $sesionusuario["Model_usuario"],
                        'Model_consultar_plan' => $arregloplan,
                        'Model_consultar_inv' => $arregloinventario,
                        'par_desde' => $txtfecha,
                        'par_hasta' => $txtfecha,
                        'par_vendedor' => "%",
                        'par_cliente' => "%",
                        'par_empresa' => "%",
                        'par_estatus' => "%",
                        'par_url' => $url,
                        'par_producto' => "%",
                        'par_fecha_inv' => $txtfecha 
                    );

                    return view('plan/listaplanpedido', $arreglo);
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