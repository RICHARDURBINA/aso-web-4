<?php

namespace App\Controllers;

use App\Models\SesionModel;
use App\Models\ErrorModel;
use App\Models\TransportistaModel;

class TransportistaController extends BaseController
{
    //=============================================================================================================
    //
    //=============================================================================================================
    public function consultar_transportista()
    {
        try {
            $sesionModel        = new SesionModel();
            $errorModel         = new ErrorModel();
            $transportistaModel = new TransportistaModel();        

            $session = session();
            $session->remove('error');          

            $sesionusuario = $session->get('datossesionusuario');   
            if (!isset($sesionusuario["Model_usuario"])) {
                return $this->response->setJSON(["resultado" => "ERROR", "msn" => "Sesión expirada"]);
            }

            $co_transportista = $this->request->getPost("txtcodigo"); 
            $nb_transportista = $this->request->getPost("txtnombre"); 
            $co_estatus       = $this->request->getPost("txtestatus"); 

            $arreglo = $transportistaModel->consultar_transportista($co_transportista, $nb_transportista, $co_estatus);
            $errorSesion = $session->get('error');

            if (!empty($errorSesion))
            {
                $modeloerror = $errorModel->consultar_error('0', $errorSesion);
                return view('error/index', $modeloerror);
            }
            else if (is_array($arreglo) && count($arreglo) > 0)
            {
                $data = array("resultado" => "1", "arreglo" => $arreglo);
                return $this->response->setJSON($data);
            }
            else
            {
                $data = [ 'resultado' => '0' ];
                return $this->response->setJSON($data);  
            }      
        } catch (\Throwable $e) {
            $data = array("resultado" => "ERROR", "msn" => $e->getMessage());
            return $this->response->setJSON($data);
        }
    }
}