<?php

namespace App\Controllers;

use App\Models\ClienteModel;
use App\Models\SesionModel;
use App\Models\ErrorModel;

class ClienteController extends BaseController
{
    protected $session;
    protected $clienteModel;
    protected $sesionModel;
    protected $errorModel;

    public function __construct()
    {
        $this->session = service('session');
        $this->clienteModel = new ClienteModel();
        $this->sesionModel = new SesionModel();
        $this->errorModel = new ErrorModel();
    }

    public function consultar_cliente_zona_usuario()
    {
        try 
        {
            $this->session->remove('error');

            $sesionusuario = $this->session->get('datossesionusuario');

            if (!isset($sesionusuario["Model_usuario"])) 
            {
                return $this->response->setJSON(["resultado" => "ERROR", "msn" => "Sesión no válida"]);
            }

            $idusuario = $sesionusuario["Model_usuario"][0]["idusuario"];
            $usuario = $sesionusuario["Model_usuario"][0]["usuario"];

            $arreglo = $this->clienteModel->consultar_cliente_zona_usuario($idusuario);

            if ($this->session->get('error') != "") 
            {
                $modeloerror = $this->errorModel->consultar_error('0', $this->session->get('error'));
                return view('error/index', $modeloerror);
            } 
            else if (count($arreglo) >= 0) 
            {
                if (count($arreglo) > 0) 
                {
                    $data = [ 'resultado' => "1", 'arreglo' => $arreglo ];
                    echo json_encode($data);
                } 
                else 
                {
                    $data = [ 'resultado' => '0' ];
                    echo json_encode($data);
                }
            } 
            else 
            {
                $modeloerror = $this->errorModel->consultar_error('-1', '');
                return view('error/index', $modeloerror);
            }
        } 
        catch (\Throwable $e) 
        {
            return json_encode(["resultado" => "ERROR", "msn" => $e->getMessage()]);
        }
    }

    public function consultar_sucursal_cliente()
    {
        try 
        {
            $this->session->remove('error');

            $sesionusuario = $this->session->get('datossesionusuario');

            if (!isset($sesionusuario["Model_usuario"])) 
            {
                return $this->response->setJSON(["resultado" => "ERROR", "msn" => "Sesión no válida"]);
            }

            $idusuario = $sesionusuario["Model_usuario"][0]["idusuario"];
            $usuario = $sesionusuario["Model_usuario"][0]["usuario"];
            $cmbcliente = $this->request->getPost("cmbcliente");

            $arreglo = $this->clienteModel->consultar_sucursal_cliente($cmbcliente);

            if ($this->session->get('error') != "") 
            {
                $modeloerror = $this->errorModel->consultar_error('0', $this->session->get('error'));
                return view('error/index', $modeloerror);
            } 
            else if (count($arreglo) >= 0) 
            {
                if (count($arreglo) > 0) 
                {
                    $data = [ 'resultado' => "1", 'arreglo' => $arreglo ];
                    echo json_encode($data);
                } 
                else 
                {
                    $data = [ 'resultado' => '0' ];
                    echo json_encode($data);
                }
            } 
            else 
            {
                $modeloerror = $this->errorModel->consultar_error('-1', '');
                return view('error/index', $modeloerror);
            }
        } 
        catch (\Throwable $e) 
        {
            return json_encode(["resultado" => "ERROR", "msn" => $e->getMessage()]);
        }
    }
}