<?php

namespace App\Controllers;

use App\Models\SesionModel;
use App\Models\ErrorModel;
use App\Models\VisitaModel;

class VisitaController extends BaseController
{
    //=============================================================================================================
    //
    //=============================================================================================================
    public function visita()
    {
        try {
            $session = session();
            $sesionusuario = $session->get('datossesionusuario');

            if (!isset($sesionusuario["Model_usuario"])) {
                return redirect()->to(base_url('LoginController/login'));
            }

            $arreglo = array( 'Model_usuario' => $sesionusuario["Model_usuario"] );
            return view('visita/index', $arreglo);

        } catch (\Throwable $e) {
            return $this->response->setJSON(["resultado" => "ERROR", "msn" => $e->getMessage()]);
        }
    }

    //=============================================================================================================
    //
    //=============================================================================================================
    public function listavisita()
    {
        try {
            $sesionModel = new SesionModel();
            $errorModel  = new ErrorModel();
            $visitaModel = new VisitaModel();

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

            $arreglovisita = $visitaModel->consultar_visita_pedido_fecha($txtdesde, $txthasta, $idusuario, "%", "%");
            $errorSesion = $session->get('error');

            if (!empty($errorSesion))
            {
                $sesionModel->actualizar_session(0);
                $modeloerror = $errorModel->consultar_error('0', $errorSesion);
                return view('error/index', $modeloerror);
            }
            else if (is_array($arreglovisita) && count($arreglovisita) >= 0)
            {
                $arreglo = array( 
                    'Model_usuario' => $sesionusuario["Model_usuario"],
                    'Model_consultar_visita_pedido' => $arreglovisita,
                    'par_desde' => $txtdesde,
                    'par_hasta' => $txthasta,
                    'par_vendedor' => "%",
                    'par_cliente' => "%" 
                );

                return view('visita/listavisita', $arreglo);
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
    public function ultimavisita()
    {
        try {
            $sesionModel = new SesionModel();
            $errorModel  = new ErrorModel();
            $visitaModel = new VisitaModel();

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

            $arregloultimavisita = $visitaModel->consultar_ultima_visita_fecha($txtdesde, $txthasta, $idusuario, "%", "%");
            $errorSesion = $session->get('error');

            if (!empty($errorSesion))
            {
                $sesionModel->actualizar_session(0);
                $modeloerror = $errorModel->consultar_error('0', $errorSesion);
                return view('error/index', $modeloerror);
            }
            else if (is_array($arregloultimavisita) && count($arregloultimavisita) >= 0)
            {
                $arreglo = array( 
                    'Model_usuario' => $sesionusuario["Model_usuario"],
                    'Model_consultar_ultima_visita' => $arregloultimavisita,
                    'par_desde' => $txtdesde,
                    'par_hasta' => $txthasta,
                    'par_vendedor' => "%",
                    'par_cliente' => "%" 
                );

                return view('visita/ultimavisita', $arreglo);
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
    public function guardar_visita()
    {
        try {
            $sesionModel = new SesionModel();
            $errorModel  = new ErrorModel();
            $visitaModel = new VisitaModel();

            $session = session();
            $session->remove('error');

            $sesionusuario = $session->get('datossesionusuario');
            $idusuario     = $sesionusuario["Model_usuario"][0]["idusuario"];

            $idvendedor = $this->request->getPost("idvendedor");
            $nbvendedor = $this->request->getPost("nbvendedor");
            $fecha      = $this->request->getPost("fecha");

            $dateArray = explode('/', $this->request->getPost('fecha'));
            if (count($dateArray) >= 3) {
                $fecha     = $dateArray[2].'-'.$dateArray[1].'-'.$dateArray[0];
            }

            $cmbcliente  = $this->request->getPost("cmbcliente");
            $cmbvisita   = $this->request->getPost("cmbvisita");

            $txtobs           = strtoupper($this->request->getPost("txtobs"));

            $var_inventario   = $this->request->getPost("var_inventario");
            $var_competencias = $this->request->getPost("var_competencias");

            $coemp   = $this->request->getPost("coemp");
            $idprd   = $this->request->getPost("idprd");
            $coprd   = $this->request->getPost("coprd");
            $nbprd   = $this->request->getPost("nbprd");

            $lote_nu_prd   = $this->request->getPost("lote_nu_prd");
            $lote_fe_prd   = $this->request->getPost("lote_fe_prd");
            $ca_prd_b_e    = $this->request->getPost("ca_prd_b_e");
            $ca_prd_m_e    = $this->request->getPost("ca_prd_m_e");
            $ca_prd_m_e_t  = $this->request->getPost("ca_prd_m_e_t");

            $totalprd      = $this->request->getPost("totalprd");

            $comp_prd_marca = $this->request->getPost("comp_prd_marca") ?? "";
            $comp_prd_pres = $this->request->getPost("comp_prd_pres") ?? "";
            $comp_prd_precio = $this->request->getPost("comp_prd_precio") ?? "";
            $comp_prd_precio_v = $this->request->getPost("comp_prd_precio_v") ?? "";

            $operacion = $this->request->getPost("operacion") ?? "";

            $visitaModel->guardar_visita( 
                $fecha, $cmbcliente, $cmbvisita, $txtobs, $idvendedor,
                $var_inventario, $coemp, $idprd, $coprd, $lote_nu_prd,
                $lote_fe_prd, $ca_prd_b_e, $ca_prd_m_e, $ca_prd_m_e_t, $totalprd,
                $operacion, $var_competencias, $comp_prd_marca, $comp_prd_pres,
                $comp_prd_precio, $comp_prd_precio_v
            );

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

    //=============================================================================================================
    //
    //=============================================================================================================
    public function form_consultar_visita($id_vis_web)
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
                'id_vis_web' => $id_vis_web
            );

            return view('visita/consultavisita', $arreglo);

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
    public function consultar_visita()
    {
        try {
            $sesionModel = new SesionModel();
            $errorModel  = new ErrorModel();
            $visitaModel = new VisitaModel();

            $session = session();
            $session->remove('error');

            $sesionusuario = $session->get('datossesionusuario');
            $id_vis_web = $this->request->getPost("id_vis_web");

            $arreglovisita = $visitaModel->consultar_visita($id_vis_web,"%","%","%","%","%","%");
            $errorSesion = $session->get('error');

            if (!empty($errorSesion))
            {
                $sesionModel->actualizar_session(0);
                $modeloerror = $errorModel->consultar_error('0', $errorSesion);
                return view('error/index', $modeloerror);
            }
            else if (is_array($arreglovisita) && count($arreglovisita) == 0 && empty($errorSesion))
            {
                $data = array( 'resultado' => "0");
                return $this->response->setJSON($data);
            }
            else if (is_array($arreglovisita) && count($arreglovisita) > 0 && empty($errorSesion))
            {
                $arreglocompetencias = $visitaModel->consultar_visita_competencias($id_vis_web);
                $errorSesionComp = $session->get('error');

                if (!empty($errorSesionComp))
                {
                    $sesionModel->actualizar_session(0);
                    $modeloerror = $errorModel->consultar_error('0', $errorSesionComp);
                    return view('error/index', $modeloerror);
                }
                else if (is_array($arreglocompetencias) && count($arreglocompetencias) >= 0 && empty($errorSesionComp))
                {
                    $data = array( 
                        'resultado' => "1",
                        'Model_consultar_visita' => $arreglovisita,
                        'Model_consultar_competencias' => $arreglocompetencias
                    );
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

    //=============================================================================================================
    //
    //=============================================================================================================
    public function anular_visita()
    {
        try {
            $sesionModel = new SesionModel();
            $errorModel  = new ErrorModel();
            $visitaModel = new VisitaModel();

            $session = session();
            $session->remove('error');

            $sesionusuario = $session->get('datossesionusuario');
            $id_vis_web = $this->request->getPost("id_vis_web");

            $visitaModel->anular_visita( $id_vis_web );
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

    //=============================================================================================================
    //
    //=============================================================================================================
    public function consultar_visita_fecha($txtdesde, $txthasta, $cmbvendedor, $cmbcliente)
    {
        try {
            $sesionModel = new SesionModel();
            $errorModel  = new ErrorModel();
            $visitaModel = new VisitaModel();

            $session = session();
            $session->remove('error');

            $sesionusuario = $session->get('datossesionusuario');
            $idusuario     = $sesionusuario["Model_usuario"][0]["idusuario"];

            if ($cmbvendedor == "" || $cmbvendedor == "0") { $cmbvendedor = "%"; }
            if ($cmbcliente == "" || $cmbcliente == "0") { $cmbcliente = "%"; }

            $arreglovisita = $visitaModel->consultar_visita_pedido_fecha($txtdesde, $txthasta, $idusuario, $cmbvendedor, $cmbcliente);
            $errorSesion = $session->get('error');

            if (!empty($errorSesion))
            {
                $sesionModel->actualizar_session(0);
                $modeloerror = $errorModel->consultar_error('0', $errorSesion);
                return view('error/index', $modeloerror);
            }
            else if (is_array($arreglovisita) && count($arreglovisita) >= 0)
            {
                $arreglo = array( 
                    'Model_usuario' => $sesionusuario["Model_usuario"],
                    'Model_consultar_visita_pedido' => $arreglovisita,
                    'par_desde' => $txtdesde,
                    'par_hasta' => $txthasta,
                    'par_vendedor' => $cmbvendedor,
                    'par_cliente' => $cmbcliente 
                );
                return view('visita/listavisita', $arreglo);
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
    public function consultar_ultimavisita_fecha($txtdesde, $txthasta, $cmbvendedor, $cmbcliente)
    {
        try {
            $sesionModel = new SesionModel();
            $errorModel  = new ErrorModel();
            $visitaModel = new VisitaModel();

            $session = session();
            $session->remove('error');

            $sesionusuario = $session->get('datossesionusuario');
            $idusuario     = $sesionusuario["Model_usuario"][0]["idusuario"];

            if ($cmbvendedor == "" || $cmbvendedor == "0") { $cmbvendedor = "%"; }
            if ($cmbcliente == "" || $cmbcliente == "0") { $cmbcliente = "%"; }

            $arregloultimavisita = $visitaModel->consultar_ultima_visita_fecha($txtdesde, $txthasta, $idusuario, $cmbvendedor, $cmbcliente);
            $errorSesion = $session->get('error');

            if (!empty($errorSesion))
            {
                $sesionModel->actualizar_session(0);
                $modeloerror = $errorModel->consultar_error('0', $errorSesion);
                return view('error/index', $modeloerror);
            }
            else if (is_array($arregloultimavisita) && count($arregloultimavisita) >= 0)
            {
                $arreglo = array( 
                    'Model_usuario' => $sesionusuario["Model_usuario"],
                    'Model_consultar_ultima_visita' => $arregloultimavisita,
                    'par_desde' => $txtdesde,
                    'par_hasta' => $txthasta,
                    'par_vendedor' => $cmbvendedor,
                    'par_cliente' => $cmbcliente 
                );
                return view('visita/ultimavisita', $arreglo);
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
    public function visita_productos_terceros()
    {
        try {
            $sesionModel = new SesionModel();
            $errorModel  = new ErrorModel();
            $visitaModel = new VisitaModel();

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

            $arreglovisita = $visitaModel->consultar_visita_producto_terceros_fecha($txtdesde, $txthasta, $idusuario, "%", "%");
            $errorSesion = $session->get('error');

            if (!empty($errorSesion))
            {
                $sesionModel->actualizar_session(0);
                $modeloerror = $errorModel->consultar_error('0', $errorSesion);
                return view('error/index', $modeloerror);
            }
            else if (is_array($arreglovisita) && count($arreglovisita) >= 0)
            {
                $arreglo = array( 
                    'Model_usuario' => $sesionusuario["Model_usuario"],
                    'Model_consultar_visita_pedido' => $arreglovisita,
                    'par_desde' => $txtdesde,
                    'par_hasta' => $txthasta,
                    'par_vendedor' => "%",
                    'par_cliente' => "%" 
                );

                return view('visita/visita_productos_terceros', $arreglo);
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
    public function consultar_visita_productos_terceros($txtdesde, $txthasta, $cmbvendedor, $cmbcliente)
    {
        try {
            $sesionModel = new SesionModel();
            $errorModel  = new ErrorModel();
            $visitaModel = new VisitaModel();

            $session = session();
            $session->remove('error');

            $sesionusuario = $session->get('datossesionusuario');
            $idusuario     = $sesionusuario["Model_usuario"][0]["idusuario"];

            if ($cmbvendedor == "" || $cmbvendedor == "0") { $cmbvendedor = "%"; }
            if ($cmbcliente == "" || $cmbcliente == "0") { $cmbcliente = "%"; }

            $arreglovisita = $visitaModel->consultar_visita_producto_terceros_fecha($txtdesde, $txthasta, $idusuario, $cmbvendedor, $cmbcliente);
            $errorSesion = $session->get('error');

            if (!empty($errorSesion))
            {
                $sesionModel->actualizar_session(0);
                $modeloerror = $errorModel->consultar_error('0', $errorSesion);
                return view('error/index', $modeloerror);
            }
            else if (is_array($arreglovisita) && count($arreglovisita) >= 0)
            {
                $arreglo = array( 
                    'Model_usuario' => $sesionusuario["Model_usuario"],
                    'Model_consultar_visita_pedido' => $arreglovisita,
                    'par_desde' => $txtdesde,
                    'par_hasta' => $txthasta,
                    'par_vendedor' => $cmbvendedor,
                    'par_cliente' => $cmbcliente 
                );
                return view('visita/visita_productos_terceros', $arreglo);
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