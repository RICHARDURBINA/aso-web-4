<?php

namespace App\Controllers;

use App\Models\SesionModel;
use App\Models\ErrorModel;
use App\Models\CobranzaModel;

class CobranzaController extends BaseController
{
    //=============================================================================================================
    //
    //=============================================================================================================
    public function cobranza()
    {
        try {
            $session = session();
            $sesionusuario = $session->get('datossesionusuario');

            //-----------------------------------------------------------------------
            // Si no existe una sesión activa
            //-----------------------------------------------------------------------
            if (!isset($sesionusuario["Model_usuario"])) {
                return redirect()->to(base_url('LoginController/login'));
            }
            //-----------------------------------------------------------------------

            $par_co_cliente = $this->request->getGet('co_cliente');
            $co_cliente = isset($par_co_cliente) ? $par_co_cliente : "";

            $arreglo = array(
                'Model_usuario' => $sesionusuario["Model_usuario"],
                'par_co_cliente' => $par_co_cliente
            );

            return view('cobranza/index', $arreglo);

        } catch (\Throwable $e) {
            return $this->response->setJSON(["resultado" => "ERROR", "msn" => $e->getMessage()]);
        }
    }

    //=============================================================================================================
    //
    //=============================================================================================================
    public function listacobranza()
    {
        try {
            $sesionModel = new SesionModel();
            $errorModel  = new ErrorModel();
            $cobranzaModel = new CobranzaModel();

            $session = session();
            // DESTRUYO SESIÓN PARA MANEJO DE ERRORES
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

            $arreglocobranza = $cobranzaModel->consultar_cobranza_fecha($txtdesde, $txthasta, $idusuario, "%", "%");
            $errorSesion = $session->get('error');

            if (!empty($errorSesion)) {
                $sesionModel->actualizar_session(0);
                $modeloerror = $errorModel->consultar_error('0', $errorSesion);
                return view('error/index', $modeloerror);
            }
            else if (is_array($arreglocobranza) && count($arreglocobranza) >= 0)
            {
                $arreglocobranzafact = $cobranzaModel->consultar_cobranza_factura("%","%","%");
                $errorSesionFact = $session->get('error');

                if (!empty($errorSesionFact)) {
                    $sesionModel->actualizar_session(0);
                    $modeloerror = $errorModel->consultar_error('0', $errorSesionFact);
                    return view('error/index', $modeloerror);
                }
                else if (is_array($arreglocobranzafact) && count($arreglocobranzafact) >= 0)
                {
                    $arreglocobranzapago = $cobranzaModel->consultar_cobranza_pago("%","%","%","%","%");
                    $errorSesionPago = $session->get('error');

                    if (!empty($errorSesionPago)) {
                        $sesionModel->actualizar_session(0);
                        $modeloerror = $errorModel->consultar_error('0', $errorSesionPago);
                        return view('error/index', $modeloerror);
                    }
                    else if (is_array($arreglocobranzapago) && count($arreglocobranzapago) >= 0)
                    {
                        $arreglo = array( 
                            'Model_usuario' => $sesionusuario["Model_usuario"],
                            'Model_consultar_cobranza' => $arreglocobranza,
                            'Model_consultar_cobranza_fact' => $arreglocobranzafact,
                            'Model_consultar_cobranza_pago' => $arreglocobranzapago,
                            'par_desde' => $txtdesde,
                            'par_hasta' => $txthasta,
                            'par_vendedor' => "%",
                            'par_cliente' => "%" 
                        );
                        return view('cobranza/listacobranza', $arreglo);
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
    public function guardar_cobranza()
    {
        try {
            $sesionModel = new SesionModel();
            $errorModel  = new ErrorModel();
            $cobranzaModel = new CobranzaModel();

            $session = session();
            $session->remove('error');

            $sesionusuario = $session->get('datossesionusuario');
            $idusuario     = $sesionusuario["Model_usuario"][0]["idusuario"];
            $usuario       = $sesionusuario["Model_usuario"][0]["usuario"];

            $idvendedor = $this->request->getPost("idvendedor");
            $nbvendedor = $this->request->getPost("nbvendedor");
            $fecha      = $this->request->getPost("fecha");

            $dateArray = explode('/', $this->request->getPost('fecha'));
            if (count($dateArray) >= 3) {
                $fecha     = $dateArray[2].'-'.$dateArray[1].'-'.$dateArray[0];
            }

            $cmbempresa  = $this->request->getPost("cmbempresa");
            $cmbcliente  = $this->request->getPost("cmbcliente");
            $txtobs      = strtoupper($this->request->getPost("txtobs"));

            $arr_nu_fact = $this->request->getPost("_txtfactura");
            $arr_mo_fact = $this->request->getPost("_txtmontofact");
            $arr_fe_emision_fact = $this->request->getPost("_fe_emision_fac");
            $arr_factura_nuevo = $this->request->getPost("_factura_nuevo");

            $arr_fe_cobr = $this->request->getPost("_txtfecha");
            $arr_co_banc = $this->request->getPost("_cmbbanco");
            $arr_nu_refe = $this->request->getPost("_txtreferencia");
            $arr_co_mone = $this->request->getPost("_cmbmoneda");
            $arr_mo_cobr = $this->request->getPost("_txtcobro");
            $arr_mo_tasa = $this->request->getPost("_txttasa");
            $arr_mo_tota = $this->request->getPost("_txttotal");
            $arr_fe_emision_cob = $this->request->getPost("_fe_emision_cob");
            $arr_pago_nuevo = $this->request->getPost("_pago_nuevo");

            $desc_esp_porc     = $this->request->getPost("txtdesc_esp_porc");
            $desc_flet_nc      = $this->request->getPost("txtdesc_flet_nc");
            $desc_divisa_porc  = $this->request->getPost("txtdesc_divisa_porc");

            $tot_fact          = $this->request->getPost("txttot_fact");
            $desc_esp_mont     = $this->request->getPost("txtdesc_esp_mont");
            $desc_flet_nc_mont = $this->request->getPost("txtdesc_flet_nc_mont");
            $desc_divisa_mont  = $this->request->getPost("txtdesc_divisa_mont");
            $cobrado           = $this->request->getPost("txtcobrado");
            $subtotal          = $this->request->getPost("txtsubtotal");
            $total             = $this->request->getPost("txttotal");
            $pendiente         = $this->request->getPost("txtpendiente");

            $desc_pronto_pago_proc = $this->request->getPost("txtdesc_pronto_pago_porc");
            $desc_pronto_pago_mont = $this->request->getPost("txtdesc_pronto_pago_mont");

            $operacion = "";
            $id_cobr_web = "";
            $arr_com_imagenes = null;

            if ($this->request->getPost("id_cobr_web") != null && $this->request->getPost("id_cobr_web") != "")
            {
                $id_cobr_web = $this->request->getPost("id_cobr_web");
            }

            if ($this->request->getPost("operacion") != null && $this->request->getPost("operacion") != "")
            {
                $operacion = $this->request->getPost("operacion");
            }

            $files = $this->request->getFiles();
            if (isset($_FILES['imagenes']))
            {
                $filesCount = count($_FILES['imagenes']['name']);
                if ($filesCount > 0)
                {
                    $arr_com_imagenes = $_FILES['imagenes'];
                }
            }

            $cobranzaModel->guardar_cobranza( 
                $fecha, $cmbempresa, $cmbcliente, $txtobs, $idvendedor,
                $arr_nu_fact, $arr_mo_fact, $arr_fe_cobr, $arr_co_banc, $arr_nu_refe,
                $arr_co_mone, $arr_mo_cobr, $arr_mo_tasa, $arr_mo_tota, $desc_esp_porc,
                $desc_flet_nc, $desc_divisa_porc, $tot_fact, $desc_esp_mont, $desc_flet_nc_mont,
                $desc_divisa_mont, $cobrado, $subtotal, $total, $pendiente, $operacion,
                $id_cobr_web, $desc_pronto_pago_proc, $desc_pronto_pago_mont, $arr_fe_emision_fact,
                $arr_fe_emision_cob, $arr_factura_nuevo, $arr_pago_nuevo, $arr_com_imagenes
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
    public function form_consultar_cobranza($id_cobr_web)
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
                'id_cobr_web' => $id_cobr_web
            );

            return view('cobranza/consultacobranza', $arreglo);

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
    public function form_modificar_cobranza($id_cobr_web)
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
                'id_cobr_web' => $id_cobr_web
            );

            return view('cobranza/modificarcobranza', $arreglo);

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
    public function consultar_cobranza()
    {
        try {
            $sesionModel = new SesionModel();
            $errorModel  = new ErrorModel();
            $cobranzaModel = new CobranzaModel();

            $session = session();
            $session->remove('error');

            $sesionusuario = $session->get('datossesionusuario');
            $id_cobr_web = $this->request->getPost("id_cobr_web");

            $arreglocobranza = $cobranzaModel->consultar_cobranza($id_cobr_web,"%","%","%","%");
            $errorSesion = $session->get('error');

            if (!empty($errorSesion))
            {
                $sesionModel->actualizar_session(0);
                $modeloerror = $errorModel->consultar_error('0', $errorSesion);
                return view('error/index', $modeloerror);
            }
            else if (is_array($arreglocobranza) && count($arreglocobranza) == 0 && empty($errorSesion))
            {
                $data = array( 'resultado' => "0");
                return $this->response->setJSON($data);
            }
            else if (is_array($arreglocobranza) && count($arreglocobranza) > 0 && empty($errorSesion))
            {
                $arreglocobranzafact = $cobranzaModel->consultar_cobranza_factura("%",$id_cobr_web,"%");
                $errorSesionFact = $session->get('error');

                if (!empty($errorSesionFact))
                {
                    $sesionModel->actualizar_session(0);
                    $modeloerror = $errorModel->consultar_error('0', $errorSesionFact);
                    return view('error/index', $modeloerror);
                }
                else if (is_array($arreglocobranzafact) && count($arreglocobranzafact) >= 0 && empty($errorSesionFact))
                {
                    $arreglocobranzapago = $cobranzaModel->consultar_cobranza_pago("%",$id_cobr_web,"%","%","%");
                    $errorSesionPago = $session->get('error');

                    if (!empty($errorSesionPago))
                    {
                        $sesionModel->actualizar_session(0);
                        $modeloerror = $errorModel->consultar_error('0', $errorSesionPago);
                        return view('error/index', $modeloerror);
                    }
                    else if (is_array($arreglocobranzapago) && count($arreglocobranzapago) >= 0 && empty($errorSesionPago))
                    {
                        $arreglocobranzacomprobante = $cobranzaModel->consultar_cobranza_comprobante("%",$id_cobr_web,"%");
                        $errorSesionComp = $session->get('error');

                        if (!empty($errorSesionComp))
                        {
                            $sesionModel->actualizar_session(0);
                            $modeloerror = $errorModel->consultar_error('0', $errorSesionComp);
                            return view('error/index', $modeloerror);
                        }
                        else if (is_array($arreglocobranzacomprobante) && count($arreglocobranzacomprobante) >= 0 && empty($errorSesionComp))
                        {
                            $data = array( 
                                'resultado' => "1",
                                'Model_consultar_cobranza' => $arreglocobranza,
                                'Model_consultar_cobranza_fact' => $arreglocobranzafact,
                                'Model_consultar_cobranza_pago' => $arreglocobranzapago,
                                'Model_consultar_cobranza_comprobante' => $arreglocobranzacomprobante
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
            $data = array("resultado" => "ERROR", "msn" => $e->getMessage());
            return $this->response->setJSON($data);
        }
    }

    //=============================================================================================================
    //
    //=============================================================================================================
    public function anular_cobranza()
    {
        try {
            $sesionModel = new SesionModel();
            $errorModel  = new ErrorModel();
            $cobranzaModel = new CobranzaModel();

            $session = session();
            $session->remove('error');

            $sesionusuario = $session->get('datossesionusuario');
            $id_cob_web = $this->request->getPost("id_cob_web");

            $cobranzaModel->anular_cobranza( $id_cob_web );
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
    public function consultar_cobranza_fecha($txtdesde, $txthasta, $cmbvendedor, $cmbcliente)
    {
        try {
            $sesionModel = new SesionModel();
            $errorModel  = new ErrorModel();
            $cobranzaModel = new CobranzaModel();

            $session = session();
            $session->remove('error');

            $sesionusuario = $session->get('datossesionusuario');
            $idusuario     = $sesionusuario["Model_usuario"][0]["idusuario"];

            if ($cmbvendedor == "" || $cmbvendedor == "0") { $cmbvendedor = "%"; }
            if ($cmbcliente == "" || $cmbcliente == "0") { $cmbcliente = "%"; }

            $arreglocobranza = $cobranzaModel->consultar_cobranza_fecha($txtdesde, $txthasta, $idusuario, $cmbvendedor, $cmbcliente);
            $errorSesion = $session->get('error');

            if (!empty($errorSesion))
            {
                $sesionModel->actualizar_session(0);
                $modeloerror = $errorModel->consultar_error('0', $errorSesion);
                return view('error/index', $modeloerror);
            }
            else if (is_array($arreglocobranza) && count($arreglocobranza) >= 0)
            {
                $arreglocobranzafact = $cobranzaModel->consultar_cobranza_factura("%","%","%");
                $errorSesionFact = $session->get('error');

                if (!empty($errorSesionFact))
                {
                    $sesionModel->actualizar_session(0);
                    $modeloerror = $errorModel->consultar_error('0', $errorSesionFact);
                    return view('error/index', $modeloerror);
                }
                else if (is_array($arreglocobranzafact) && count($arreglocobranzafact) >= 0)
                {
                    $arreglocobranzapago = $cobranzaModel->consultar_cobranza_pago("%","%","%","%","%");
                    $errorSesionPago = $session->get('error');

                    if (!empty($errorSesionPago))
                    {
                        $sesionModel->actualizar_session(0);
                        $modeloerror = $errorModel->consultar_error('0', $errorSesionPago);
                        return view('error/index', $modeloerror);
                    }
                    else if (is_array($arreglocobranzapago) && count($arreglocobranzapago) >= 0)
                    {
                        $arreglo = array( 
                            'Model_usuario' => $sesionusuario["Model_usuario"],
                            'Model_consultar_cobranza' => $arreglocobranza,
                            'Model_consultar_cobranza_fact' => $arreglocobranzafact,
                            'Model_consultar_cobranza_pago' => $arreglocobranzapago,
                            'par_desde' => $txtdesde,
                            'par_hasta' => $txthasta,
                            'par_vendedor' => $cmbvendedor,
                            'par_cliente' => $cmbcliente 
                        );
                        return view('cobranza/listacobranza', $arreglo);
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
    public function excelcobranza($txtdesde, $txthasta, $cmbvendedor, $cmbcliente)
    {
        try {
            ini_set('memory_limit', '512M');
            set_time_limit(300);

            $sesionModel = new SesionModel();
            $errorModel  = new ErrorModel();
            $cobranzaModel = new CobranzaModel();

            $session = session();
            $session->remove('error');

            $sesionusuario = $session->get('datossesionusuario');
            $idusuario     = $sesionusuario["Model_usuario"][0]["idusuario"];

            if (!isset($sesionusuario["Model_usuario"])) {
                return redirect()->to(base_url('LoginController/login'));
            }

            if ($cmbvendedor == "" || $cmbvendedor == "0") { $cmbvendedor = "%"; }
            if ($cmbcliente == "" || $cmbcliente == "0") { $cmbcliente = "%"; }

            $arreglocobranza = $cobranzaModel->consultar_cobranza_fecha($txtdesde, $txthasta, $idusuario, $cmbvendedor, $cmbcliente);
            $errorSesion = $session->get('error');

            if (!empty($errorSesion))
            {
                $sesionModel->actualizar_session(0);
                $modeloerror = $errorModel->consultar_error('0', $errorSesion);
                return view('error/index', $modeloerror);
            }
            else if (is_array($arreglocobranza) && count($arreglocobranza) >= 0)
            {
                $arreglocobranzafact = $cobranzaModel->consultar_cobranza_factura("%","%","%");
                $errorSesionFact = $session->get('error');

                if (!empty($errorSesionFact))
                {
                    $sesionModel->actualizar_session(0);
                    $modeloerror = $errorModel->consultar_error('0', $errorSesionFact);
                    return view('error/index', $modeloerror);
                }
                else if (is_array($arreglocobranzafact) && count($arreglocobranzafact) >= 0)
                {
                    $arreglocobranzapago = $cobranzaModel->consultar_cobranza_pago("%","%","%","%","%");
                    $errorSesionPago = $session->get('error');

                    if (!empty($errorSesionPago))
                    {
                        $sesionModel->actualizar_session(0);
                        $modeloerror = $errorModel->consultar_error('0', $errorSesionPago);
                        return view('error/index', $modeloerror);
                    }
                    else if (is_array($arreglocobranzapago) && count($arreglocobranzapago) >= 0)
                    {
                        $arreglousuario = $sesionusuario["Model_usuario"];
                        
                        require_once(APPPATH . 'ThirdParty/PHPExcel/Classes/PHPExcel.php');
                        $objPHPExcel = new \PHPExcel();

                        $sheet = $objPHPExcel->getActiveSheet();
                        $sheet->setTitle('Cobranzas');

                        $headers = [
                            'Est.', 'Empresa', 'Cobranza', 'Fecha', 'Vendedor', 'Cliente', 'Zona',
                            'Facturado ($)', 'Desc. Especial ($)', 'Desc. Flete/NC ($)', 'Cobrado ($)', 'Pendiente ($)',
                            'Facturas', 'Saldo Factura ($)', 'Banco Pago', 'Fecha Pago', 'Referencia', 'Moneda', 'Monto Pago',
                            'Tasa', 'Total Pago'
                        ];

                        $col = 'A';
                        foreach ($headers as $header) {
                            $sheet->setCellValue($col . '1', $header);
                            $col++;
                        }

                        $headerStyle = array(
                            'font' => array('bold' => true, 'color' => array('rgb' => 'FFFFFF')),
                            'fill' => array(
                                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => '337AB7')
                            ),
                            'alignment' => array(
                                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                'vertical'   => \PHPExcel_Style_Alignment::VERTICAL_CENTER
                            )
                        );
                        $sheet->getStyle('A1:U1')->applyFromArray($headerStyle);

                        $row = 2;

                        foreach ($arreglocobranza as $rows) {
                            $esAdesa = ($rows["co_empresa"] == "ADESA") && (isset($arreglousuario[0]["cobro_adesa"]) && $arreglousuario[0]["cobro_adesa"] == "1");
                            $esAA1   = ($rows["co_empresa"] == "AA1")   && (isset($arreglousuario[0]["cobro_aai"]) && $arreglousuario[0]["cobro_aai"] == "1");

                            if (!($esAdesa || $esAA1)) {
                                continue;
                            }

                            $idCobranza = $rows["cob_id_cobranza"];

                            $facturasAsociadas = array_filter($arreglocobranzafact, function($item) use ($idCobranza) {
                                return $item["id_cobranza_web"] == $idCobranza;
                            });

                            $pagosAsociados = array_filter($arreglocobranzapago, function($item) use ($idCobranza) {
                                return $item["id_cobranza_web"] == $idCobranza;
                            });

                            $cantFacturas = count($facturasAsociadas);
                            $cantPagos    = count($pagosAsociados);
                            $totalFilas   = max(1, $cantFacturas, $cantPagos);

                            $startRow = $row;
                            $endRow   = $startRow + $totalFilas - 1;

                            $facturado = (float) str_replace(',', '.', $rows["total_facturado"]);
                            $descEspec = (float) str_replace(',', '.', $rows["mont_desc_especial"]);
                            $descFlete = (float) str_replace(',', '.', $rows["mont_desc_flete"]);
                            $cobrado   = (float) str_replace(',', '.', $rows["mont_cobrado"]);
                            $pendiente = (float) str_replace(',', '.', $rows["mont_pendiente"]);

                            $sheet->setCellValue("A{$startRow}", $rows["ctv_de_estado_documento"]);
                            $sheet->setCellValue("B{$startRow}", $rows["co_empresa"]);
                            $sheet->setCellValue("C{$startRow}", $idCobranza);
                            $sheet->setCellValue("D{$startRow}", $rows["fe_emision"]);
                            $sheet->setCellValue("E{$startRow}", $rows["nb_vendedor"]);
                            $sheet->setCellValue("F{$startRow}", $rows["nb_organizacion"]);
                            $sheet->setCellValue("G{$startRow}", $rows["co_zona"]);

                            $sheet->setCellValue("H{$startRow}", $facturado);
                            $sheet->setCellValue("I{$startRow}", $descEspec);
                            $sheet->setCellValue("J{$startRow}", $descFlete);
                            $sheet->setCellValue("K{$startRow}", $cobrado);
                            $sheet->setCellValue("L{$startRow}", $pendiente);

                            $factRow = $startRow;
                            foreach ($facturasAsociadas as $cob_fact) {
                                $saldoFact = (float) str_replace(',', '.', $cob_fact["saldo_factura"]);
                                $sheet->setCellValue("M{$factRow}", $cob_fact["nu_factura"]);
                                $sheet->setCellValue("N{$factRow}", $saldoFact);
                                $sheet->getStyle("N{$factRow}")->getNumberFormat()->setFormatCode('#,##0.00');
                                $factRow++;
                            }

                            $pagoRow = $startRow;
                            foreach ($pagosAsociados as $cob_pago) {
                                $montoPago = (float) str_replace(',', '.', $cob_pago["monto"]);
                                $tasaPago  = (float) str_replace(',', '.', $cob_pago["tasa"]);
                                $totalPago = (float) str_replace(',', '.', $cob_pago["total"]);

                                $sheet->setCellValue("O{$pagoRow}", $cob_pago["co_banco"]);
                                $sheet->setCellValue("P{$pagoRow}", $cob_pago["fecha"]);
                                $sheet->setCellValue("Q{$pagoRow}", $cob_pago["referencia"]);
                                $sheet->setCellValue("R{$pagoRow}", $cob_pago["co_moneda"]);
                                $sheet->setCellValue("S{$pagoRow}", $montoPago);
                                $sheet->setCellValue("T{$pagoRow}", $tasaPago);
                                $sheet->setCellValue("U{$pagoRow}", $totalPago);

                                $sheet->getStyle("S{$pagoRow}")->getNumberFormat()->setFormatCode('#,##0.00');
                                $sheet->getStyle("T{$pagoRow}")->getNumberFormat()->setFormatCode('#,##0.00');
                                $sheet->getStyle("U{$pagoRow}")->getNumberFormat()->setFormatCode('#,##0.00');
                                $pagoRow++;
                            }

                            if ($totalFilas > 1) {
                                foreach (range('A', 'L') as $colLetter) {
                                    $sheet->mergeCells("{$colLetter}{$startRow}:{$colLetter}{$endRow}");
                                    $sheet->getStyle("{$colLetter}{$startRow}")->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                }
                            }

                            foreach (array('H', 'I', 'J', 'K', 'L') as $colLetter) {
                                $sheet->getStyle("{$colLetter}{$startRow}")->getNumberFormat()->setFormatCode('#,##0.00');
                            }

                            $row = $endRow + 1;
                        }

                        foreach (range('A', 'U') as $colLetter) {
                            $sheet->getColumnDimension($colLetter)->setAutoSize(true);
                        }

                        while (ob_get_level() > 0) {
                            ob_end_clean();
                        }

                        $filename = 'Reporte_Cobranza_' . date('Ymd_His') . '.xls';

                        header('Content-Type: application/vnd.ms-excel');
                        header('Content-Disposition: attachment;filename="' . $filename . '"');
                        header('Cache-Control: max-age=0');

                        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                        $objWriter->save('php://output');
                        exit;
                    }
                }
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