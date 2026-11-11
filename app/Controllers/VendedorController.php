<?php

namespace App\Controllers;

use App\Models\SesionModel;
use App\Models\ErrorModel;
use App\Models\VendedorModel;

class VendedorController extends BaseController
{
    //=============================================================================================================
    //
    //=============================================================================================================
    public function consultar_vendedor_zona_usuario()
    {
        try {
            if (!$this->request->isAJAX()) {
                return $this->response->setJSON(['resultado' => 'ERROR', 'msn' => 'Petición no válida']);
            }

            $sesionModel  = new SesionModel();
            $errorModel   = new ErrorModel();
            $vendedorModel = new VendedorModel();
            
            $session = session();
            // DESTRUYO SESIÓN PARA MANEJO DE ERRORES
            $session->remove('error');

            $sesionusuario = $session->get('datossesionusuario');

            if (!isset($sesionusuario["Model_usuario"])) {
                return $this->response->setJSON(['resultado' => 'ERROR', 'msn' => 'Sesión no válida']);
            }

            $idusuario = $sesionusuario["Model_usuario"][0]["idusuario"];

            $arreglo = $vendedorModel->consultar_vendedor_zona_usuario($idusuario);

            $errorSesion = $session->get('error');

            if (!empty($errorSesion)) {
                // MANEJADOR DE ERRORES (ERROR DE BASE DE DATOS)
                $sesionModel->actualizar_session(0);
                $modeloerror = $errorModel->consultar_error('0', $errorSesion);
                return view('error/index', $modeloerror);
            }
            else if (is_array($arreglo) && count($arreglo) >= 0)
            {
                if (count($arreglo) > 0)
                {
                    $data = array("resultado" => "1", "arreglo" => $arreglo);
                    return $this->response->setJSON($data);
                }
                else
                {
                    $data = [ 'resultado' => '0' ];
                    return $this->response->setJSON($data);  
                }      
            }
            else
            {
                $modeloerror = $errorModel->consultar_error('-1', '');
                return view('error/index', $modeloerror);
            }

        } catch (\Throwable $e) {
            $data = array("resultado" => "ERROR", "msn" => $e->getMessage());
            return $this->response->setJSON($data);
        }
    }
}