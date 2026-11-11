<?php

namespace App\Models;

use CodeIgniter\Model;

//----------------------------------------------------------
// BUSCAR CLASS 
//----------------------------------------------------------
$nombre_fichero = APPPATH . 'Models/class_first.txt';
$class_conexion = "conexion_mysql.php";

if (file_exists($nombre_fichero)) 
{
    $contenido = file_get_contents($nombre_fichero);
    $arreglo = explode("\n", str_replace("\r", "", $contenido));
    if (isset($arreglo[0]) && trim($arreglo[0]) !== '') 
    {
        $class_conexion = trim($arreglo[0]);
    }
}

$ruta_conexion = APPPATH . 'Models/' . $class_conexion;
if (file_exists($ruta_conexion)) 
{
    include_once($ruta_conexion);
}
//----------------------------------------------------------

class ClienteModel extends Model
{
    function get_control()
    {
        //----------------------------------------------------------
        // BUSCAR CLASS 
        //----------------------------------------------------------
        $nombre_fichero = APPPATH . 'Models/class_first.txt';
        $class_control = "control_mysql";

        if (file_exists($nombre_fichero)) 
        {
            $contenido = file_get_contents($nombre_fichero);
            $arreglo = explode("\n", str_replace("\r", "", $contenido));
            if (isset($arreglo[1]) && trim($arreglo[1]) !== '') 
            {
                $class_control = trim($arreglo[1]);
            }
        }

        return $class_control;
        //----------------------------------------------------------
    }

    public function consultar_cliente_zona_usuario($par_idusuario)
    {
        $class_control = $this->get_control();
        
        if (!class_exists($class_control)) 
        {
            session()->set('error', 'No se encontró la clase de control: ' . $class_control);
            return [];
        }

        $ejecutar = new $class_control();

        $query_1 = "SELECT  a.co_organizacion,
							a.nb_organizacion,
							a.co_zona,
							a.adesa,
							a.aai
					FROM web_clientes_aso a
					WHERE a.co_zona IN (SELECT b.co_zona
					                    FROM web_usuarios_zonas_aso b
					                    WHERE b.id_usuario = $par_idusuario)
					ORDER BY a.nb_organizacion ASC";

        $conexion = $ejecutar->conectar();
        if (!$conexion) 
        {
            session()->set('error', 'No se pudo establecer la conexión a la base de datos.');
            return [];
        }

        $respuesta = $ejecutar->ejecutar($query_1, $conexion);
        $contador = 0;
        $lista = array();

        if (isset($respuesta["error"]) && $respuesta["error"] == "") 
        {
            $result = $respuesta["resultado"];

            if ($row = $ejecutar->proximo($result)) 
            {
                do 
                {
                    $lista[$contador]["co_organizacion"] = $row[$ejecutar->col_db("co_organizacion")];
                    $lista[$contador]["nb_organizacion"] = $row[$ejecutar->col_db("nb_organizacion")];
                    $lista[$contador]["co_zona"]         = $row[$ejecutar->col_db("co_zona")];
                    $lista[$contador]["adesa"]           = $row[$ejecutar->col_db("adesa")];
                    $lista[$contador]["aai"]             = $row[$ejecutar->col_db("aai")];
                    
                    $contador++;
                } 
                while ($row = $ejecutar->proximo($result));
            }
            $ejecutar->desconectar($conexion);
            return $lista;
        } 
        else 
        {
            // ERROR DE CONEXIÓN
            session()->set('error', $respuesta["error"] ?? 'Error de conexión desconocido');
        }

        $ejecutar->desconectar($conexion);
        return [];
    }

    public function consultar_sucursal_cliente($par_co_cliente)
    {
        $class_control = $this->get_control();
        
        if (!class_exists($class_control)) 
        {
            session()->set('error', 'No se encontró la clase de control: ' . $class_control);
            return [];
        }

        $ejecutar = new $class_control();

        $query_1 = "SELECT  a.co_organizacion,
							a.direccion,
							a.adesa,
							a.aai
					FROM web_clientes_sucursales_aso a
					WHERE a.co_organizacion = '$par_co_cliente'";

        $conexion = $ejecutar->conectar();
        if (!$conexion) 
        {
            session()->set('error', 'No se pudo establecer la conexión a la base de datos.');
            return [];
        }

        $respuesta = $ejecutar->ejecutar($query_1, $conexion);
        $contador = 0;
        $lista = array();

        if (isset($respuesta["error"]) && $respuesta["error"] == "") 
        {
            $result = $respuesta["resultado"];

            if ($row = $ejecutar->proximo($result)) 
            {
                do 
                {
                    $lista[$contador]["co_organizacion"] = $row[$ejecutar->col_db("co_organizacion")];
                    $lista[$contador]["direccion"]       = $row[$ejecutar->col_db("direccion")];
                    $lista[$contador]["adesa"]           = $row[$ejecutar->col_db("adesa")];
                    $lista[$contador]["aai"]             = $row[$ejecutar->col_db("aai")];
                    
                    $contador++;
                } 
                while ($row = $ejecutar->proximo($result));
            }
            $ejecutar->desconectar($conexion);
            return $lista;
        } 
        else 
        {
            // ERROR DE CONEXIÓN
            session()->set('error', $respuesta["error"] ?? 'Error de conexión desconocido');
        }

        $ejecutar->desconectar($conexion);
        return [];
    }
}