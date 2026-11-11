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

class BancoModel extends Model 
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
		//----------------------------------------------------------
	}

	//=============================================================================================================
    //
    //=============================================================================================================
	public function consultar_banco($par_co_banco,
                                    $par_nb_banco)
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();

		$query_1 = "SELECT a.co_banco,
       					   a.nb_banco
					FROM web_entidad_bancaria a
					WHERE TRIM(NVL(a.co_banco,'')) LIKE '$par_co_banco'
					  AND TRIM(NVL(a.nb_banco,'')) LIKE '$par_nb_banco'
					ORDER BY a.co_banco ASC";	

		$conexion = $ejecutar->conectar();
        if (!$conexion) 
        {
            return [];
        }	

		$respuesta = $ejecutar->ejecutar($query_1, $conexion);
		$contador = 0;
		$lista = array();	

		if(isset($respuesta["error"]) && $respuesta["error"] == "")
		{
			$result = $respuesta["resultado"];	

			if ($row = $ejecutar->proximo($result))
			{
				DO
				{
					$lista [$contador]["co_banco"]       = $row[$ejecutar->col_db("co_banco")];
					$lista [$contador]["nb_banco"]       = $row[$ejecutar->col_db("nb_banco")];
					
					$contador++;
				}
				WHILE ($row = $ejecutar->proximo($result));
			}
            $ejecutar->desconectar($conexion);
			return $lista;
		}
		else
		{
			// ERROR DE CONEXIÓN
			session()->set('error', $respuesta["error"] ?? '');
		}	

		$ejecutar->desconectar($conexion);
        return [];
	}
}