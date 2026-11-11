<?php

namespace App\Controllers;

use App\Models\SesionModel;
use App\Models\ErrorModel;
use App\Models\VehiculoModel;

class VehiculoController extends BaseController
{
    public function listavehiculo()
    {     
        try {
            $sesionModel = new SesionModel();
            $errorModel  = new ErrorModel();
            $vehiculoModel = new VehiculoModel();        

            $session = session();
            $session->remove('error');          
            $sesionusuario = $session->get('datossesionusuario');   

            if (!isset($sesionusuario["Model_usuario"])) {
                return redirect()->to(base_url('LoginController/login'));
            }

            $arreglovehiculo = $vehiculoModel->consultar_vehiculo("%","%","%","%","%");
            $errorSesion = $session->get('error');

            if (!empty($errorSesion))
            {
                $sesionModel->actualizar_session(0);
                return view('error/index', $errorModel->consultar_error('0', $errorSesion));
            }
            else if (is_array($arreglovehiculo) && count($arreglovehiculo) >= 0)
            {
                $arreglo = array('Model_usuario' => $sesionusuario["Model_usuario"], 'Model_consultar_vehiculo' => $arreglovehiculo);
                return view('vehiculo/listavehiculo', $arreglo); 
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

    public function consultar_vehiculo()
    {
        try {
            $session = session();
            $session->remove('error');          
            $vehiculoModel = new VehiculoModel();        

            $arreglo = $vehiculoModel->consultar_vehiculo(
                $this->request->getPost("txtid"), 
                $this->request->getPost("txtcodigo"), 
                $this->request->getPost("cmbtipovehiculo"), 
                $this->request->getPost("cmbtipocola"), 
                $this->request->getPost("txtestatus")
            );

            if (!empty($session->get('error')))
            {
                return view('error/index', (new ErrorModel())->consultar_error('0', $session->get('error')));
            }
            else if (is_array($arreglo) && count($arreglo) > 0)
            {
                return $this->response->setJSON(["resultado" => "1", "arreglo" => $arreglo]);
            }
            else
            {
                return $this->response->setJSON(['resultado' => '0']);  
            }      
        } catch (\Throwable $e) {
            return $this->response->setJSON(["resultado" => "ERROR", "msn" => $e->getMessage()]);
        }
    }

    public function activar_vehiculo()
    {     
        try {
            $session = session();
            $session->remove('error');          
            $vehiculoModel = new VehiculoModel();        
            $vehiculoModel->activar_vehiculo($this->request->getPost("id_vehiculo_web"));

            if (empty($session->get('error'))) {
                return $this->response->setJSON(['resultado' => '1']);
            }
            return $this->response->setJSON(["resultado" => "ERROR", "msn" => $session->get('error')]);
        } catch (\Throwable $e) {
            return $this->response->setJSON(["resultado" => "ERROR", "msn" => $e->getMessage()]);
        }
    }  

    public function inactivar_vehiculo()
    {     
        try {
            $session = session();
            $session->remove('error');          
            $vehiculoModel = new VehiculoModel();        
            $vehiculoModel->inactivar_vehiculo($this->request->getPost("id_vehiculo_web"));

            if (empty($session->get('error'))) {
                return $this->response->setJSON(['resultado' => '1']);
            }
            return $this->response->setJSON(["resultado" => "ERROR", "msn" => $session->get('error')]);
        } catch (\Throwable $e) {
            return $this->response->setJSON(["resultado" => "ERROR", "msn" => $e->getMessage()]);
        }
    }  

    public function guardar_vehiculo()
    {
        try {
            $session = session();
            $session->remove('error');
            $vehiculoModel = new VehiculoModel();

            $vehiculoModel->guardar_vehiculo(
                $this->request->getPost("txtid"),
                strtoupper($this->request->getPost("txtcodigo")),
                $this->request->getPost("cmbtipovehiculo"),
                $this->request->getPost("txtcapacidad"),
                $this->request->getPost("cmbtipocarga"),
                $this->request->getPost("operacion") ?? ""
            );

            if (empty($session->get('error'))) {
                return $this->response->setJSON(['resultado' => '1']);
            }
            return $this->response->setJSON(["resultado" => "ERROR", "msn" => $session->get('error')]);
        } catch (\Throwable $e) {
            return $this->response->setJSON(["resultado" => "ERROR", "msn" => $e->getMessage()]);
        }
    }
}