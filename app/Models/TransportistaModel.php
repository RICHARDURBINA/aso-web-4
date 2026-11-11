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

class TransportistaModel extends Model
{
    function get_control()
    {
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
    }

	//=============================================================================================================
    //
    //=============================================================================================================
	public function consultar_transportista($par_co_transportista,
                                            $par_nb_transportista,
                                            $par_co_estatus)
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();

		$query_1 = "SELECT a.co_transportista,
       					   a.nb_transportista,
       					   a.ctv_co_estado_documento AS co_estatus
					FROM web_transportista_aso a
					WHERE TRIM(NVL(a.co_transportista,'')) LIKE '$par_co_transportista'
					  AND TRIM(NVL(a.nb_transportista,'')) LIKE '$par_nb_transportista'
					  AND TRIM(NVL(a.ctv_co_estado_documento,'')) LIKE '$par_co_estatus'
					ORDER BY a.co_transportista ASC";	

		$conexion = $ejecutar->conectar();	
        if (!$conexion) { return []; }

		$respuesta = $ejecutar->ejecutar($query_1, $conexion);
		$contador = 0;
		$lista = array();	

		if(isset($respuesta["error"]) && $respuesta["error"] == "")
		{
			$result = $respuesta["resultado"];	

			if ($row = $ejecutar->proximo($result))
			{
				do
				{
					$lista [$contador]["co_transportista"] = $row[$ejecutar->col_db("co_transportista")];
					$lista [$contador]["nb_transportista"] = $row[$ejecutar->col_db("nb_transportista")];
					$lista [$contador]["co_estatus"]       = $row[$ejecutar->col_db("co_estatus")];
					$lista [$contador]["de_transportista"] = "(" . $row[$ejecutar->col_db("co_transportista")] . ") " . $row[$ejecutar->col_db("nb_transportista")];
					
					$contador++;
				}
				while ($row = $ejecutar->proximo($result));
			}
            $ejecutar->desconectar($conexion);
			return $lista;
		}
		else
		{
			session()->set('error', $respuesta["error"] ?? '');
		}	

		$ejecutar->desconectar($conexion);
        return [];
	}
}