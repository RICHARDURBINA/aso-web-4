<?php

namespace App\Controllers;

use App\Models\SesionModel;
use App\Models\ErrorModel;
use App\Models\RomanaModel;

class RomanaController extends BaseController
{
    //=============================================================================================================
    //
    //=============================================================================================================
    public function listaromana()
    {
        try {
            $sesionModel = new SesionModel();
            $errorModel  = new ErrorModel();
            $romanaModel = new RomanaModel();

            $session = session();
            $session->remove('error');

            $sesionusuario = $session->get('datossesionusuario');

            if (!isset($sesionusuario["Model_usuario"])) 
            {
                return redirect()->to(base_url('LoginController/login'));
            }

            $idusuario = $sesionusuario["Model_usuario"][0]["idusuario"];
            $usuario   = $sesionusuario["Model_usuario"][0]["usuario"];

            // Primer día (ajustado con fecha específica según tu script o puedes usar date('Y-m-01'))
            $txtdesde = date('2026-09-01');

            // Último día
            $txthasta = date('Y-m-t');

            $arreglo = array( 
                'Model_usuario' => $sesionusuario["Model_usuario"],
                'par_desde' => $txtdesde,
                'par_hasta' => $txthasta,
                'par_condicion' => '%' 
            );

            return view('romana/listaromana', $arreglo);

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
    public function consultar_romana()
    {
        try {
            $sesionModel = new SesionModel();
            $errorModel  = new ErrorModel();
            $romanaModel = new RomanaModel();

            $session = session();
            $session->remove('error');

            $sesionusuario = $session->get('datossesionusuario');

            if (!isset($sesionusuario["Model_usuario"])) 
            {
                return redirect()->to(base_url('LoginController/login'));
            }

            $idusuario     = $sesionusuario["Model_usuario"][0]["idusuario"];
            $usuario       = $sesionusuario["Model_usuario"][0]["usuario"];   

            $txtdesde     = $this->request->getPost("txtdesde");
            $txthasta     = $this->request->getPost("txthasta");
            $cmbcondicion = $this->request->getPost("cmbcondicion");

            $arreglo_NOR = $romanaModel->consultar_NOR($txtdesde, $txthasta, $cmbcondicion, $idusuario);
            $errorSesion = $session->get('error');

            if (!empty($errorSesion))
            {
                $sesionModel->actualizar_session(0);
                $modeloerror = $errorModel->consultar_error('0', $errorSesion);
                return view('error/index', $modeloerror);
            }
            else if (is_array($arreglo_NOR) && count($arreglo_NOR) >= 0)
            {
                $arreglo_NOE_ALM = $romanaModel->consultar_NOE_ALM($txtdesde, $txthasta, $cmbcondicion, $idusuario);
                $errorSesion2 = $session->get('error');

                if (!empty($errorSesion2))
                {
                    $sesionModel->actualizar_session(0);
                    $modeloerror = $errorModel->consultar_error('0', $errorSesion2);
                    return view('error/index', $modeloerror);
                }
                else if (is_array($arreglo_NOE_ALM) && count($arreglo_NOE_ALM) >= 0)
                {
                    $arreglo_Control = $romanaModel->consultar_Control($txtdesde, $txthasta, $cmbcondicion, $idusuario);
                    $errorSesion3 = $session->get('error');

                    if (!empty($errorSesion3))
                    {
                        $sesionModel->actualizar_session(0);
                        $modeloerror = $errorModel->consultar_error('0', $errorSesion3);
                        return view('error/index', $modeloerror);
                    }
                    else if (is_array($arreglo_Control) && count($arreglo_Control) >= 0)
                    {
                        $total_segundos = 0;
                        $contador_validos = 0;

                        foreach ($arreglo_Control as $row) 
                        {
                            $segundos_descarga = $row["TIEMPO_DESCARGA_SEGUNDOS"];
                            
                            if ($segundos_descarga > 0) 
                            {
                                $total_segundos += (float)$segundos_descarga;
                                $contador_validos++;
                            }
                        }

                        if ($contador_validos > 0) 
                        {
                            $promedio_segundos = $total_segundos / $contador_validos;
                            
                            $dias     = floor($promedio_segundos / 86400);
                            $horas    = floor(($promedio_segundos % 86400) / 3600);
                            $minutos  = floor(($promedio_segundos / 60) % 60);
                            $segundos = floor($promedio_segundos % 60);
                            
                            if ($dias > 0) {
                                $promedio_descarga_hms = sprintf('%d día(s) %02d:%02d:%02d', $dias, $horas, $minutos, $segundos);
                            } else {
                                $promedio_descarga_hms = sprintf('%02d:%02d:%02d', $horas, $minutos, $segundos);
                            }
                        } 
                        else 
                        {
                            $promedio_descarga_hms = "00:00:00";
                            $promedio_segundos = 0;
                        }

                        $data = array( 
                            'resultado' => "1",
                            'Model_consultar_NOR' => $arreglo_NOR,
                            'Model_consultar_NOE_ALM' => $arreglo_NOE_ALM,
                            'Model_consultar_Control' => $arreglo_Control,
                            'promedio_descarga_hms' => $promedio_descarga_hms,
                            'promedio_descarga_seg' => $promedio_segundos,
                            'par_desde' => $txtdesde,
                            'par_hasta' => $txthasta,
                            'par_condicion' => $cmbcondicion 
                        );

                        return $this->response->setJSON($data);
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
}