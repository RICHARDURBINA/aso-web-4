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

class ProductoModel extends Model
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

    public function consultar_producto_cliente($par_co_producto, $par_nb_producto, $par_co_cliente, $par_co_empresa)
    {
        $class_control = $this->get_control();
        
        if (!class_exists($class_control)) 
        {
            session()->set('error', 'No se encontró la clase de control: ' . $class_control);
            return [];
        }

        $ejecutar = new $class_control();

        $query_1 = "SELECT a.id_registro,
					       a.co_producto,
       					   a.nb_producto,
					       to_number(a.pr_producto) as pr_producto,
					       to_number(a.pr_producto_mayor) as pr_producto_mayor,
					       a.co_empresa,
					       a.total_kg,
					       a.nb_corto
					FROM web_productos_aso a
					WHERE a.co_empresa IN ( SELECT DECODE(b.adesa,'1','ADESA',NULL)
					                        FROM web_clientes_aso b
					                        WHERE b.adesa IS NOT NULL
					                          AND TRIM(NVL(b.co_organizacion,'')) LIKE '$par_co_cliente'
					                        UNION ALL
					                        SELECT DECODE(b.aai,'1','AA1',NULL)
					                        FROM web_clientes_aso b
					                        WHERE b.adesa IS NOT NULL
					                          AND TRIM(NVL(b.co_organizacion,'')) LIKE '$par_co_cliente' )
					  AND TRIM(NVL(a.co_producto,'')) LIKE '$par_co_producto'
					  AND TRIM(NVL(a.nb_producto,'')) LIKE '$par_nb_producto'
					  AND TRIM(NVL(a.co_empresa,'')) LIKE '$par_co_empresa'
					ORDER BY a.co_empresa, a.co_producto ASC";

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
                    $lista[$contador]["id_registro"]       = $row[$ejecutar->col_db("id_registro")];
                    $lista[$contador]["co_producto"]       = $row[$ejecutar->col_db("co_producto")];
                    $lista[$contador]["nb_producto"]       = $row[$ejecutar->col_db("nb_producto")];
                    $lista[$contador]["pr_producto"]       = $row[$ejecutar->col_db("pr_producto")];
                    $lista[$contador]["pr_producto_mayor"] = $row[$ejecutar->col_db("pr_producto_mayor")];
                    $lista[$contador]["co_empresa"]        = $row[$ejecutar->col_db("co_empresa")];
                    $lista[$contador]["total_kg"]          = $row[$ejecutar->col_db("total_kg")];
                    $lista[$contador]["nb_corto"]          = $row[$ejecutar->col_db("nb_corto")];
                    $lista[$contador]["nb_descripcion"]    = "(" . $row[$ejecutar->col_db("co_producto")] . ") -- " . $row[$ejecutar->col_db("nb_producto")];
                    
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