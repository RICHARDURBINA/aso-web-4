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

class VehiculoModel extends Model
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
	public function consultar_vehiculo($par_id_vehiculo, $par_co_vehiculo, $par_ti_vehiculo, $par_co_tipocola, $par_co_estatus)
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();

		$query_1 = "SELECT a.id_registro as id_vehiculo,
		                   a.co_vehiculo,
       					   a.ti_vehiculo,
       					   a.capacidad,
       					   a.ti_cola,
       					   a.ctv_co_estado_documento AS co_estatus
					FROM web_vehiculo_aso a
					WHERE TRIM(CAST(a.id_registro AS CHAR(9))) LIKE '$par_id_vehiculo'
					  AND TRIM(NVL(a.co_vehiculo,'')) LIKE '$par_co_vehiculo'
					  AND TRIM(NVL(a.ti_vehiculo,'')) LIKE '$par_ti_vehiculo'
					  AND TRIM(NVL(a.ti_cola,'')) LIKE '$par_co_tipocola'
					  AND TRIM(NVL(a.ctv_co_estado_documento,'')) LIKE '$par_co_estatus'
					ORDER BY a.co_vehiculo ASC";	

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
					$lista [$contador]["id_vehiculo"]    = $row[$ejecutar->col_db("id_vehiculo")];
					$lista [$contador]["co_vehiculo"]    = $row[$ejecutar->col_db("co_vehiculo")];
					$lista [$contador]["ti_vehiculo"]    = $row[$ejecutar->col_db("ti_vehiculo")];
					$lista [$contador]["capacidad"]      = $row[$ejecutar->col_db("capacidad")];					
					$lista [$contador]["ti_cola"]        = $row[$ejecutar->col_db("ti_cola")];
					$lista [$contador]["co_estatus"]     = $row[$ejecutar->col_db("co_estatus")];
					$lista [$contador]["de_vehiculo"]    = $row[$ejecutar->col_db("co_vehiculo")] . " - " . $row[$ejecutar->col_db("ti_vehiculo")];
					
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

	//=============================================================================================================
    //
    //=============================================================================================================
	public function activar_vehiculo( $id_vehiculo_web )
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();

		$conexion = $ejecutar->conectar();
        if (!$conexion) { return; }
		$ejecutar->autocommit($conexion, false);

		try 
		{			
			$query_1 = "UPDATE web_vehiculo_aso SET ctv_co_estado_documento = 'AC' WHERE id_registro = '$id_vehiculo_web'";
			$respuesta = $ejecutar->ejecutar($query_1, $conexion, false);

			if(!empty($respuesta["error"]))
			{
				$ejecutar->rollback($conexion);
				$ejecutar->desconectar($conexion);
				session()->set('error', $respuesta["error"]);
				return;
			}
			else
			{
				$ejecutar->commit($conexion);
				$ejecutar->desconectar($conexion);
				return;								
			}			
		}
		catch (\Exception $e) 
		{
		    $ejecutar->rollback($conexion);
			$ejecutar->desconectar($conexion);
			session()->set('error', "CODE: 9001<br />MESSAGE: Error Fatal -> 9001 activar_vehiculo: " . $e->getMessage());
		}
	}

	//=============================================================================================================
    //
    //=============================================================================================================
	public function inactivar_vehiculo( $id_vehiculo_web )
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();

		$conexion = $ejecutar->conectar();
        if (!$conexion) { return; }
		$ejecutar->autocommit($conexion, false);

		try 
		{			
			$query_1 = "UPDATE web_vehiculo_aso SET ctv_co_estado_documento = 'IN' WHERE id_registro = '$id_vehiculo_web'";
			$respuesta = $ejecutar->ejecutar($query_1, $conexion, false);

			if(!empty($respuesta["error"]))
			{
				$ejecutar->rollback($conexion);
				$ejecutar->desconectar($conexion);
				session()->set('error', $respuesta["error"]);
				return;
			}
			else
			{
				$ejecutar->commit($conexion);
				$ejecutar->desconectar($conexion);
				return;								
			}			
		}
		catch (\Exception $e) 
		{
		    $ejecutar->rollback($conexion);
			$ejecutar->desconectar($conexion);
			session()->set('error', "CODE: 9001<br />MESSAGE: Error Fatal -> 9001 inactivar_vehiculo: " . $e->getMessage());
		}
	}

	//=============================================================================================================
    //
    //=============================================================================================================
    public function guardar_vehiculo( $txtid, $txtcodigo, $cmbtipovehiculo, $txtcapacidad, $cmbtipocarga, $operacion )
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();
		
		$conexion = $ejecutar->conectar();
        if (!$conexion) { return; }
		$ejecutar->autocommit($conexion, false);	

		try 
		{		
			if($operacion == '1')
			{
				$idvehiculo = "";
				$query_2 = "SELECT F00_ID_REGISTRO AS idvehiculo FROM DUAL";	
				$respuesta = $ejecutar->ejecutar($query_2, $conexion, false);	

				if(isset($respuesta["error"]) && $respuesta["error"] == "")
				{
					$result = $respuesta["resultado"];	
					if ($row = $ejecutar->proximo($result))
					{
						do { $idvehiculo = $row[$ejecutar->col_db("idvehiculo")]; } while ($row = $ejecutar->proximo($result));
					}
				}
				else
				{
					$ejecutar->rollback($conexion);
				    $ejecutar->desconectar($conexion);
				    session()->set('error', "CODE: 1.2<br />MESSAGE: guardar_vehiculo -> 1.2 ERROR");
				    return;
				}

				$query_3 = "INSERT INTO web_vehiculo_aso (id_registro, co_vehiculo, ti_vehiculo, capacidad, ti_cola, ctv_co_estado_documento) 
						    VALUES ($idvehiculo, '$txtcodigo', '$cmbtipovehiculo', $txtcapacidad, '$cmbtipocarga', 'AC')";
				
				$respuesta = $ejecutar->ejecutar($query_3, $conexion, false);	

				if(!empty($respuesta["error"]))
				{
					$ejecutar->rollback($conexion);
				    $ejecutar->desconectar($conexion);
				    session()->set('error', "CODE: 1.3<br />MESSAGE: guardar_vehiculo -> 1.3 ERROR");
				    return;
				} 

				$ejecutar->commit($conexion);
				$ejecutar->desconectar($conexion);
				return;
			}

			if($operacion == '3')
			{		
				$co_placa = "";
				$query_2 = "SELECT co_vehiculo FROM web_vehiculo_aso WHERE id_registro = $txtid";	
				$respuesta = $ejecutar->ejecutar($query_2, $conexion, false);	

				if(isset($respuesta["error"]) && $respuesta["error"] == "")
				{
					$result = $respuesta["resultado"];	
					if ($row = $ejecutar->proximo($result))
					{
						do { $co_placa = $row[$ejecutar->col_db("co_vehiculo")]; } while ($row = $ejecutar->proximo($result));
					}
				}
				else
				{
					$ejecutar->rollback($conexion);
				    $ejecutar->desconectar($conexion);
				    session()->set('error', "CODE: 3.2<br />MESSAGE: guardar_vehiculo -> 3.2 ERROR");
				    return;
				}

				if($co_placa != $txtcodigo)	
				{
					$query_3 = "UPDATE web_vehiculo_aso SET co_vehiculo = '$txtcodigo', ti_vehiculo = '$cmbtipovehiculo', capacidad = $txtcapacidad, ti_cola = '$cmbtipocarga' WHERE id_registro = $txtid";
				}  
				else
				{
					$query_3 = "UPDATE web_vehiculo_aso SET ti_vehiculo = '$cmbtipovehiculo', capacidad = $txtcapacidad, ti_cola = '$cmbtipocarga' WHERE id_registro = $txtid";
				}  

				$respuesta = $ejecutar->ejecutar($query_3, $conexion, false);

				if(!empty($respuesta["error"]))
				{
					$ejecutar->rollback($conexion);
				    $ejecutar->desconectar($conexion);
					session()->set('error', $respuesta["error"]);
				    return;
				}
				else
				{
					$ejecutar->commit($conexion);
					$ejecutar->desconectar($conexion);
					return;
				}
			}
		} 
		catch (\Exception $e) 
		{
		    $ejecutar->rollback($conexion);
			$ejecutar->desconectar($conexion);
			session()->set('error', "CODE: 9001<br />MESSAGE: Error Fatal -> 9001 guardar_vehiculo: " . $e->getMessage());
		}
	}
}