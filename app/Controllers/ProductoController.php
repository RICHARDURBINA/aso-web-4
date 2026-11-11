<?php

namespace App\Controllers;

use App\Models\ProductoModel;
use App\Models\SesionModel;
use App\Models\ErrorModel;

class ProductoController extends BaseController
{
    protected $session;
    protected $productoModel;
    protected $sesionModel;
    protected $errorModel;

    public function __construct()
    {
        $this->session = service('session');
        $this->productoModel = new ProductoModel();
        $this->sesionModel = new SesionModel();
        $this->errorModel = new ErrorModel();
    }

    public function consultar_producto_cliente()
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

            $co_producto = $this->request->getPost("txtcodigo");
            $nb_producto = $this->request->getPost("txtnombre");
            $co_cliente  = $this->request->getPost("cocliente");
            $co_empresa  = $this->request->getPost("coempresa");

            $arregloproducto = $this->productoModel->consultar_producto_cliente($co_producto, $nb_producto, $co_cliente, $co_empresa);

            if ($this->session->get('error') != "") 
            {
                $modeloerror = $this->errorModel->consultar_error('0', $this->session->get('error'));
                return view('error/index', $modeloerror);
            } 
            else if (count($arregloproducto) >= 0) 
            {
                if (count($arregloproducto) > 0) 
                {
                    $data = [ 'resultado' => "1", 'arregloproducto' => $arregloproducto ];
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