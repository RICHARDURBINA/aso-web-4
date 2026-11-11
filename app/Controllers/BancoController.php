<?php

namespace App\Controllers;

use App\Models\SesionModel;
use App\Models\ErrorModel;
use App\Models\BancoModel;

class BancoController extends BaseController
{
    //=============================================================================================================
    //
    //=============================================================================================================
    public function consultar_banco()
    {
        try {
            $sesionModel = new SesionModel();
            $errorModel  = new ErrorModel();
            $bancoModel  = new BancoModel();

            $session = session();
            // DESTRUYO SESION PARA MANEJO DE ERRORES
            $session->remove('error');

            $sesionusuario = $session->get('datossesionusuario');

            if (!isset($sesionusuario["Model_usuario"])) {
                return redirect()->to(base_url('LoginController/login'));
            }

            $idusuario = $sesionusuario["Model_usuario"][0]["idusuario"];
            $usuario   = $sesionusuario["Model_usuario"][0]["usuario"];

            $co_banco = $this->request->getPost("txtcodigo");
            $nb_banco = $this->request->getPost("txtnombre");

            $arreglo = $bancoModel->consultar_banco($co_banco, $nb_banco);
            $errorSesion = $session->get('error');

            if (!empty($errorSesion))
            {
                //----------------------------------------------------------------------------------------------
                // MANEJADOR DE ERRORES (ERROR DE BASE DE DATOS)
                //----------------------------------------------------------------------------------------------
                $modeloerror = $errorModel->consultar_error('0', $errorSesion);
                //$sesionModel->actualizar_session(0);
                return view('error/index', $modeloerror);
                //----------------------------------------------------------------------------------------------
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
            else if (isset($arreglo["resultado"]) && $arreglo["resultado"] == "ERROR")
            {
                $codigoerror = $arreglo["codigoerror"];
                //----------------------------------------------------------------------------------------------
                // MANEJADOR DE ERRORES
                //----------------------------------------------------------------------------------------------
                $modeloerror = $errorModel->consultar_error($codigoerror, '');
                //$sesionModel->actualizar_session(0);
                return view('error/index', $modeloerror);
                //----------------------------------------------------------------------------------------------
            }
            else
            {
                //----------------------------------------------------------------------------------------------
                // MANEJADOR DE ERRORES
                //----------------------------------------------------------------------------------------------
                $modeloerror = $errorModel->consultar_error('-1', '');
                //$sesionModel->actualizar_session(0);
                return view('error/index', $modeloerror);
                //----------------------------------------------------------------------------------------------
            }

        } catch (\Throwable $e) {
            $data = array("resultado" => "ERROR", "msn" => $e->getMessage());
            return $this->response->setJSON($data);
        }
    }
}