<?php

namespace App\Controllers;

use App\Models\SesionModel;
use App\Models\ErrorModel;
use App\Models\ChoferModel;

class ChoferController extends BaseController
{
    public function listachofer()
    {     
        try {
            $sesionModel = new SesionModel();
            $errorModel  = new ErrorModel();
            $choferModel = new ChoferModel();        

            $session = session();
            $session->remove('error');          
            $sesionusuario = $session->get('datossesionusuario');   

            if (!isset($sesionusuario["Model_usuario"])) {
                return redirect()->to(base_url('LoginController/login'));
            }

            $arreglochofer = $choferModel->consultar_chofer("%","%","%","%");
            $errorSesion = $session->get('error');

            if (!empty($errorSesion))
            {
                $sesionModel->actualizar_session(0);
                return view('error/index', $errorModel->consultar_error('0', $errorSesion));
            }
            else if (is_array($arreglochofer) && count($arreglochofer) >= 0)
            {
                $arreglo = array('Model_usuario' => $sesionusuario["Model_usuario"], 'Model_consultar_chofer' => $arreglochofer);
                return view('chofer/listachofer', $arreglo); 
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

    public function consultar_chofer()
    {
        try {
            $session = session();
            $session->remove('error');          

            $choferModel = new ChoferModel();        
            $arreglo = $choferModel->consultar_chofer(
                $this->request->getPost("txtid"), 
                $this->request->getPost("txtcodigo"), 
                $this->request->getPost("txtnombre"), 
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

    public function activar_chofer()
    {     
        try {
            $session = session();
            $session->remove('error');          
            $choferModel = new ChoferModel();        
            $choferModel->activar_chofer($this->request->getPost("id_chofer_web"));

            if (empty($session->get('error'))) {
                return $this->response->setJSON(['resultado' => '1']);
            }
            return $this->response->setJSON(["resultado" => "ERROR", "msn" => $session->get('error')]);
        } catch (\Throwable $e) {
            return $this->response->setJSON(["resultado" => "ERROR", "msn" => $e->getMessage()]);
        }
    }  

    public function inactivar_chofer()
    {     
        try {
            $session = session();
            $session->remove('error');          
            $choferModel = new ChoferModel();        
            $choferModel->inactivar_chofer($this->request->getPost("id_chofer_web"));

            if (empty($session->get('error'))) {
                return $this->response->setJSON(['resultado' => '1']);
            }
            return $this->response->setJSON(["resultado" => "ERROR", "msn" => $session->get('error')]);
        } catch (\Throwable $e) {
            return $this->response->setJSON(["resultado" => "ERROR", "msn" => $e->getMessage()]);
        }
    }  

    public function guardar_chofer()
    {
        try {
            $session = session();
            $session->remove('error');
            $choferModel = new ChoferModel();

            $choferModel->guardar_chofer(
                $this->request->getPost("txtid"),
                strtoupper($this->request->getPost("txtcodigo")),
                strtoupper($this->request->getPost("txtnombre")),
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