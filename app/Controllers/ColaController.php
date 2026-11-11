<?php

namespace App\Controllers;

use App\Models\SesionModel;
use App\Models\ErrorModel;
use App\Models\ColaModel;

class ColaController extends BaseController
{
    public function cola()
    {     
        $session = session();
        $sesionusuario = $session->get('datossesionusuario');   

        if (!isset($sesionusuario["Model_usuario"])) {
            return redirect()->to(base_url('LoginController/login'));
        }

        $arreglo = array('Model_usuario' => $sesionusuario["Model_usuario"]);
        return view('cola/index', $arreglo); 
    } 

    public function listacola()
    {     
        try {
            $sesionModel = new SesionModel();
            $errorModel  = new ErrorModel();
            $colaModel   = new ColaModel();        

            $session = session();
            $session->remove('error');          

            $sesionusuario = $session->get('datossesionusuario');   
            $idusuario     = $sesionusuario["Model_usuario"][0]["idusuario"] ?? 0;

            if (!isset($sesionusuario["Model_usuario"])) {
                return redirect()->to(base_url('LoginController/login'));
            }

            $txtdesde = date('Y-m-01', strtotime("-1 month"));
            $txthasta = date('Y-m-t');  
            $txthasta_hora = $txthasta . " 23:59:00";

            $arreglocola = $colaModel->consultar_cola_fecha($txtdesde, $txthasta_hora, $idusuario, "%", "%", "N");
            $errorSesion = $session->get('error');

            if (!empty($errorSesion))
            {
                $sesionModel->actualizar_session(0);
                return view('error/index', $errorModel->consultar_error('0', $errorSesion));
            }
            else if (is_array($arreglocola) && count($arreglocola) >= 0)
            {
                $arreglo = array( 
                    'Model_usuario'        => $sesionusuario["Model_usuario"],
                    'Model_consultar_cola' => $arreglocola,
                    'par_desde'            => $txtdesde,
                    'par_hasta'            => $txthasta,
                    'par_tipocola'         => "%",
                    'par_transportista'    => "%",
                    'par_historico'        => "N" 
                );
                return view('cola/listacola', $arreglo);            
            }
            else
            {
                $sesionModel->actualizar_session(0);
                return view('error/index', $errorModel->consultar_error('4', ''));
            }
        } catch (\Throwable $e) {
            $sesionModel = new SesionModel();
            $sesionModel->actualizar_session(0);
            return view('error/index', (new ErrorModel())->consultar_error('0', $e->getMessage()));
        }
    }

    public function guardar_cola()
    {     
        try {
            $session = session();
            $session->remove('error');          
            $colaModel = new ColaModel();        

            $fecha     = $this->request->getPost('txtfecha'); 
            $hora      = $this->request->getPost("txthora"); 
            $cmbtipocola      = $this->request->getPost("cmbtipocola");
            $cmbtransportista = $this->request->getPost("cmbtransportista");
            $cmbchofer        = $this->request->getPost("cmbchofer"); 
            $cmbvehiculo      = $this->request->getPost("cmbvehiculo"); 
            $kilometraje      = $this->request->getPost("txtkilometraje"); 

            if (empty($kilometraje)) { $kilometraje = 0; }
            
            $txtobs = strtoupper($this->request->getPost("txtobs") ?? ""); 
            $operacion = $this->request->getPost("operacion") ?? "";

            $colaModel->guardar_cola($fecha, $hora, $cmbtipocola, $cmbtransportista, $cmbchofer, $cmbvehiculo, $kilometraje, $txtobs, $operacion);
            
            $errorSesion = $session->get('error');
            if (empty($errorSesion))
            {
                return $this->response->setJSON([ 'resultado' => '1' ]);
            }
            else
            {
                return $this->response->setJSON(["resultado" => "ERROR", "msn" => $errorSesion]);
            }
        } catch (\Throwable $e) {
            return $this->response->setJSON(["resultado" => "ERROR", "msn" => $e->getMessage()]);
        }
    } 

    public function form_consultar_cola($id_cola_web)
    {
        $session = session();
        $sesionusuario = $session->get('datossesionusuario'); 

        $arreglo = array( 
            'Model_usuario' => $sesionusuario["Model_usuario"],
            'id_cola_web'   => $id_cola_web
        );

        return view('cola/consultacola', $arreglo); 
    }

    public function consultar_cola()
    {
        try {
            $session = session();
            $session->remove('error');          
            $colaModel = new ColaModel();        

            $id_cola_web = $this->request->getPost("id_cola_web");
            $arreglocola = $colaModel->consultar_cola($id_cola_web,"%","%","%","%","%");        

            $errorSesion = $session->get('error');
            if (!empty($errorSesion))
            {
                return view('error/index', (new ErrorModel())->consultar_error('0', $errorSesion));
            }
            else if (is_array($arreglocola) && count($arreglocola) == 0)
            {
                return $this->response->setJSON([ 'resultado' => "0"]);
            }
            else if (is_array($arreglocola) && count($arreglocola) > 0)
            {
                return $this->response->setJSON([ 'resultado' => "1", 'Model_consultar_cola' => $arreglocola]);
            }
            else
            {
                return view('error/index', (new ErrorModel())->consultar_error('4', ''));
            }        
        } catch (\Throwable $e) {
            return $this->response->setJSON(["resultado" => "ERROR", "msn" => $e->getMessage()]);
        }
    }

    public function anular_cola()
    {     
        try {
            $session = session();
            $session->remove('error');          
            $colaModel = new ColaModel();        

            $id_cola_web = $this->request->getPost("id_cola_web"); 
            $colaModel->anular_cola($id_cola_web);

            if (empty($session->get('error')))
            {
                return $this->response->setJSON([ 'resultado' => '1' ]);
            }
            else
            {
                return $this->response->setJSON(["resultado" => "ERROR", "msn" => $session->get('error')]);
            }
        } catch (\Throwable $e) {
            return $this->response->setJSON(["resultado" => "ERROR", "msn" => $e->getMessage()]);
        }
    }   

    public function finalizar_cola()
    {     
        try {
            $session = session();
            $session->remove('error');          
            $colaModel = new ColaModel();        

            $id_cola_web = $this->request->getPost("id_cola_web"); 
            $colaModel->finalizar_cola($id_cola_web);

            if (empty($session->get('error')))
            {
                return $this->response->setJSON([ 'resultado' => '1' ]);
            }
            else
            {
                return $this->response->setJSON(["resultado" => "ERROR", "msn" => $session->get('error')]);
            }
        } catch (\Throwable $e) {
            return $this->response->setJSON(["resultado" => "ERROR", "msn" => $e->getMessage()]);
        }
    }   

    public function consultar_cola_fecha($txtdesde, $txthasta, $cmbtipocola, $cmbtransportista, $est_historico)
    {
        try {
            $sesionModel = new SesionModel();
            $errorModel  = new ErrorModel();
            $colaModel   = new ColaModel();        

            $session = session();
            $session->remove('error');          

            $sesionusuario = $session->get('datossesionusuario');   
            $idusuario     = $sesionusuario["Model_usuario"][0]["idusuario"] ?? 0; 

            $txthasta_hora = $txthasta . " 23:59:00";

            if($cmbtipocola == "" || $cmbtipocola == "0") { $cmbtipocola = "%"; }
            if($cmbtransportista == "" || $cmbtransportista == "0") { $cmbtransportista = "%"; }

            $arreglocola = $colaModel->consultar_cola_fecha($txtdesde, $txthasta_hora, $idusuario, $cmbtipocola, $cmbtransportista, $est_historico);
            $errorSesion = $session->get('error');

            if (!empty($errorSesion))
            {
                $sesionModel->actualizar_session(0);
                return view('error/index', $errorModel->consultar_error('0', $errorSesion));
            }
            else if (is_array($arreglocola) && count($arreglocola) >= 0)
            {
                $arreglo = array( 
                    'Model_usuario'        => $sesionusuario["Model_usuario"],
                    'Model_consultar_cola' => $arreglocola,
                    'par_desde'            => $txtdesde,
                    'par_hasta'            => $txthasta,
                    'par_tipocola'         => $cmbtipocola,
                    'par_transportista'    => $cmbtransportista,
                    'par_historico'        => $est_historico 
                );
                return view('cola/listacola', $arreglo); 
            }
            else
            {
                $sesionModel->actualizar_session(0);
                return view('error/index', $errorModel->consultar_error('4', ''));
            }        
        } catch (\Throwable $e) {
            $sesionModel = new SesionModel();
            $sesionModel->actualizar_session(0);
            return view('error/index', (new ErrorModel())->consultar_error('0', $e->getMessage()));
        }
    }
}