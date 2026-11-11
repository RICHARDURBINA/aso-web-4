<?php

namespace App\Controllers;

use App\Models\SesionModel;
use App\Models\ErrorModel;
use App\Models\GraficaModel;

class GraficaController extends BaseController
{
    //=============================================================================================================
    //
    //=============================================================================================================
    public function grafica()
    {
        try {
            $session = session();
            $sesionusuario = $session->get('datossesionusuario');

            if (!isset($sesionusuario["Model_usuario"])) 
            {
                return redirect()->to(base_url('LoginController/login'));
            }

            // Primer día
            $txtdesde = date('Y-m-01');

            // Último día
            $txthasta = date('Y-m-t');

            $arreglo = array( 
                'Model_usuario' => $sesionusuario["Model_usuario"],
                'par_desde' => $txtdesde,
                'par_hasta' => $txthasta 
            );

            return view('grafica/index', $arreglo);

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
    public function resumen()
    {
        try {
            $session = session();
            $sesionusuario = $session->get('datossesionusuario');

            if (!isset($sesionusuario["Model_usuario"])) 
            {
                return redirect()->to(base_url('LoginController/login'));
            }

            // Fecha predeterminada
            $txtfecha = date('Y-m-d');

            $arreglo = array( 
                'Model_usuario' => $sesionusuario["Model_usuario"],
                'par_fecha' => $txtfecha 
            );

            return view('grafica/resumen', $arreglo);

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
    public function datos_grafica_fecha()
    {
        try {
            $sesionModel = new SesionModel();
            $errorModel  = new ErrorModel();
            $graficaModel = new GraficaModel();

            $session = session();
            $session->remove('error');

            $sesionusuario = $session->get('datossesionusuario');

            if (!isset($sesionusuario["Model_usuario"])) 
            {
                return redirect()->to(base_url('LoginController/login'));
            }

            $idusuario     = $sesionusuario["Model_usuario"][0]["idusuario"];
            $usuario       = $sesionusuario["Model_usuario"][0]["usuario"];

            $txtdesde = $this->request->getPost('txtdesde');
            $txthasta = $this->request->getPost('txthasta');

            $arr_grafica_1 = $graficaModel->consultar_arr_grafica_1($txtdesde, $txthasta, $idusuario);
            $errorSesion = $session->get('error');

            if (!empty($errorSesion)) 
            {
                $sesionModel->actualizar_session(0);
                $modeloerror = $errorModel->consultar_error('0', $errorSesion);
                return view('error/index', $modeloerror);
            }
            else if (is_array($arr_grafica_1) && count($arr_grafica_1) >= 0) 
            {
                $arr_grafica_2 = $graficaModel->consultar_arr_grafica_2($txtdesde, $txthasta, $idusuario);
                $errorSesion2 = $session->get('error');

                if (!empty($errorSesion2)) 
                {
                    $sesionModel->actualizar_session(0);
                    $modeloerror = $errorModel->consultar_error('0', $errorSesion2);
                    return view('error/index', $modeloerror);
                }
                else if (is_array($arr_grafica_2) && count($arr_grafica_2) >= 0) 
                {
                    $arr_grafica_3 = $graficaModel->consultar_arr_grafica_3($txtdesde, $txthasta, $idusuario);
                    $errorSesion3 = $session->get('error');

                    if (!empty($errorSesion3)) 
                    {
                        $sesionModel->actualizar_session(0);
                        $modeloerror = $errorModel->consultar_error('0', $errorSesion3);
                        return view('error/index', $modeloerror);
                    }
                    else if (is_array($arr_grafica_3) && count($arr_grafica_3) >= 0) 
                    {
                        $arr_grafica_4 = $graficaModel->consultar_arr_grafica_4($txtdesde, $txthasta, $idusuario);
                        $errorSesion4 = $session->get('error');

                        if (!empty($errorSesion4)) 
                        {
                            $sesionModel->actualizar_session(0);
                            $modeloerror = $errorModel->consultar_error('0', $errorSesion4);
                            return view('error/index', $modeloerror);
                        }
                        else if (is_array($arr_grafica_4) && count($arr_grafica_4) >= 0) 
                        {
                            $arr_grafica_5 = $graficaModel->consultar_arr_grafica_5($txtdesde, $txthasta, $idusuario);
                            $errorSesion5 = $session->get('error');

                            if (!empty($errorSesion5)) 
                            {
                                $sesionModel->actualizar_session(0);
                                $modeloerror = $errorModel->consultar_error('0', $errorSesion5);
                                return view('error/index', $modeloerror);
                            }
                            else if (is_array($arr_grafica_5) && count($arr_grafica_5) >= 0) 
                            {
                                $arreglo = array( 
                                    'resultado' => "1",
                                    'Model_usuario' => $sesionusuario["Model_usuario"],
                                    'Model_arr_grafica_1' => $arr_grafica_1,
                                    'Model_arr_grafica_2' => $arr_grafica_2,
                                    'Model_arr_grafica_3' => $arr_grafica_3,
                                    'Model_arr_grafica_4' => $arr_grafica_4,
                                    'Model_arr_grafica_5' => $arr_grafica_5,
                                    'par_desde' => $txtdesde,
                                    'par_hasta' => $txthasta 
                                );

                                return $this->response->setJSON($arreglo);
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
            }
            else 
            {
                $sesionModel->actualizar_session(0);
                $modeloerror = $errorModel->consultar_error('4', '');
                return view('error/index', $modeloerror);
            }

        } catch (\Throwable $e) {
            return $this->response->setJSON(["resultado" => "ERROR", "msn" => $e->getMessage()]);
        }
    }

    //=============================================================================================================
    //
    //=============================================================================================================
    public function datos_resumen_fecha()
    {
        try {
            $sesionModel = new SesionModel();
            $errorModel  = new ErrorModel();
            $graficaModel = new GraficaModel();

            $session = session();
            $session->remove('error');

            $sesionusuario = $session->get('datossesionusuario');

            if (!isset($sesionusuario["Model_usuario"])) 
            {
                return redirect()->to(base_url('LoginController/login'));
            }

            $idusuario     = $sesionusuario["Model_usuario"][0]["idusuario"];
            $usuario       = $sesionusuario["Model_usuario"][0]["usuario"];

            $txtfecha = $this->request->getPost('txtfecha');
            $cmbtransportista = $this->request->getPost('cmbtransportista');

            $arr_resumen_1 = $graficaModel->consultar_arr_resumen_1($txtfecha, $cmbtransportista, $idusuario);
            $errorSesion = $session->get('error');

            if (!empty($errorSesion)) 
            {
                $sesionModel->actualizar_session(0);
                $modeloerror = $errorModel->consultar_error('0', $errorSesion);
                return view('error/index', $modeloerror);
            }
            else if (is_array($arr_resumen_1) && count($arr_resumen_1) >= 0) 
            {
                $arr_resumen_2 = $graficaModel->consultar_arr_resumen_producto_1($txtfecha, $cmbtransportista, $idusuario);
                $errorSesion2 = $session->get('error');

                if (!empty($errorSesion2)) 
                {
                    $sesionModel->actualizar_session(0);
                    $modeloerror = $errorModel->consultar_error('0', $errorSesion2);
                    return view('error/index', $modeloerror);
                }
                else if (is_array($arr_resumen_2) && count($arr_resumen_2) >= 0) 
                {
                    $arreglo = array( 
                        'resultado' => "1",
                        'Model_usuario' => $sesionusuario["Model_usuario"],
                        'Model_arr_resumen_1' => $arr_resumen_1,
                        'Model_arr_resumen_2' => $arr_resumen_2,
                        'par_desde' => $txtfecha
                    );

                    return $this->response->setJSON($arreglo);
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
            return $this->response->setJSON(["resultado" => "ERROR", "msn" => $e->getMessage()]);
        }
    }
}