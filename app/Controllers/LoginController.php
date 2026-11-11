<?php

namespace App\Controllers;

use App\Models\LoginModel;
use App\Models\SesionModel;

class LoginController extends BaseController
{
    public function login()
    {
        // En CI4 las vistas se cargan directamente con la función helper view()
        return view('login/index');
    }

    public function home()
    {
        return view('login/home');
    }

    public function iniciar_sesion()
    {
        // Validamos que sea una petición por AJAX
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['resultado' => 'ERROR', 'msn' => 'Petición no válida']);
        }
        
        $txtusuario       = strtoupper($this->request->getPost('txtusuario'));
        $txtclaveusuario  = $this->request->getPost('txtclave');
        $cmbempresa       = $this->request->getPost('cmbempresa');         

        return  $this->validar_sesion($txtusuario, $txtclaveusuario, $cmbempresa);         
    }

    protected function validar_sesion($txtusuario, $txtclaveusuario, $cmbempresa)
    {
        try {
            // Instanciamos los modelos en CI4
            $loginModel  = new LoginModel();
            $sesionModel = new SesionModel();
            
            // Instanciamos la sesión de CI4
            $session = session();

            // Destruyo/limpio la variable de sesión para manejo de errores
            $session->remove('error');

            $ipmaquina = $this->request->getIPAddress(); 

            $arreglousuario = $loginModel->consultar_datos_usuario($txtusuario, $txtclaveusuario, $cmbempresa);

            // Verificamos si hay error en la sesión
            $errorSesion = $session->get('error');

            if (!empty($errorSesion)) {
                // ERROR DE BASE DE DATOS               
                $data = ["resultado" => "ERROR", "msn" => $errorSesion];
                //return $this->response->setJSON($data);
                return json_encode( $data );
            }
            else if (empty($arreglousuario)) {
                // No existe usuario o clave
                $sesionModel->actualizar_session(0);
                $data = ['resultado' => '0002'];
                //return $this->response->setJSON($data);
                return json_encode( $data );
            }
            else {
                // Cargo la sesion del usuario
                $sesionData = ['Model_usuario' => $arreglousuario];
                $session->set('datossesionusuario', $sesionData);

                $data = ['resultado' => '1'];
                //return $this->response->setJSON($data);
                return json_encode( $data );
            }

        } catch (\Throwable $e) {
            // Captura cualquier error crítico o de base de datos y lo envía ordenado al AJAX
            $data = ["resultado" => "ERROR", 
                     "msn" => $e->getMessage()];
            //return $this->response->setJSON($data);
            return json_encode( $data );
        }
    }

    public function cerrar_sesion()
    {        
        $sesionModel = new SesionModel();
        $sesionModel->actualizar_session(0);

        // Redirigir o retornar la vista de login
        return view('login/index');    
    }
}