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

class ChoferModel extends Model
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
	public function consultar_chofer($par_id_chofer,
                                     $par_co_chofer,
                                     $par_nb_chofer,
                                     $par_co_estatus)
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();

		$query_1 = "SELECT a.id_registro as id_chofer,
		                   a.co_chofer,
       					   a.nb_chofer,
       					   a.ctv_co_estado_documento AS co_estatus
					FROM web_chofer_aso a
					WHERE TRIM(CAST(a.id_registro AS CHAR(9))) LIKE '$par_id_chofer'
					  AND TRIM(NVL(a.co_chofer,'')) LIKE '$par_co_chofer'
					  AND TRIM(NVL(a.nb_chofer,'')) LIKE '$par_nb_chofer'
					  AND TRIM(NVL(a.ctv_co_estado_documento,'')) LIKE '$par_co_estatus'
					ORDER BY a.co_chofer ASC";	

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
					$lista [$contador]["id_chofer"]  = $row[$ejecutar->col_db("id_chofer")];
					$lista [$contador]["co_chofer"]  = $row[$ejecutar->col_db("co_chofer")];
					$lista [$contador]["nb_chofer"]  = $row[$ejecutar->col_db("nb_chofer")];
					$lista [$contador]["co_estatus"] = $row[$ejecutar->col_db("co_estatus")];
					$lista [$contador]["de_chofer"]  = "(" . $row[$ejecutar->col_db("co_chofer")] . ") " . $row[$ejecutar->col_db("nb_chofer")];
					
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
	public function activar_chofer( $id_chofer_web )
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();

		$conexion = $ejecutar->conectar();
        if (!$conexion) { return; }
		$ejecutar->autocommit($conexion, false);

		try 
		{			
			$query_1 = "UPDATE web_chofer_aso 
						SET    ctv_co_estado_documento = 'AC'
						WHERE  id_registro = '$id_chofer_web'";

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
			session()->set('error', "CODE: 9001<br />MESSAGE: Error Fatal -> 9001 activar_chofer: " . $e->getMessage());
		}
	}

	//=============================================================================================================
    //
    //=============================================================================================================
	public function inactivar_chofer( $id_chofer_web )
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();

		$conexion = $ejecutar->conectar();
        if (!$conexion) { return; }
		$ejecutar->autocommit($conexion, false);

		try 
		{			
			$query_1 = "UPDATE web_chofer_aso 
						SET    ctv_co_estado_documento = 'IN'
						WHERE  id_registro = '$id_chofer_web'";

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
			session()->set('error', "CODE: 9001<br />MESSAGE: Error Fatal -> 9001 inactivar_chofer: " . $e->getMessage());
		}
	}

	//=============================================================================================================
    //
    //=============================================================================================================
    public function guardar_chofer( $txtid, $txtcodigo, $txtnombre, $operacion )
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
				$idchofer = "";
				$query_2 = "SELECT F00_ID_REGISTRO AS idchofer FROM DUAL";	
				$respuesta = $ejecutar->ejecutar($query_2, $conexion, false);	

				if(isset($respuesta["error"]) && $respuesta["error"] == "")
				{
					$result = $respuesta["resultado"];	
					if ($row = $ejecutar->proximo($result))
					{
						do { $idchofer = $row[$ejecutar->col_db("idchofer")]; } while ($row = $ejecutar->proximo($result));
					}
				}
				else
				{
					$ejecutar->rollback($conexion);
				    $ejecutar->desconectar($conexion);
				    session()->set('error', "CODE: 1.2<br />MESSAGE: guardar_chofer -> 1.2 ERROR NO SE PUDO OBTENER EL ID");
				    return;
				}

				$query_3 = "INSERT INTO web_chofer_aso (id_registro, co_chofer, nb_chofer, ctv_co_estado_documento) 
						    VALUES ($idchofer, '$txtcodigo', '$txtnombre', 'AC')";
				
				$respuesta = $ejecutar->ejecutar($query_3, $conexion, false);	

				if(!empty($respuesta["error"]))
				{
					$ejecutar->rollback($conexion);
				    $ejecutar->desconectar($conexion);
				    session()->set('error', "CODE: 1.3<br />MESSAGE: guardar_chofer -> 1.3 ERROR AL INSERTAR");
				    return;
				} 

				$ejecutar->commit($conexion);
				$ejecutar->desconectar($conexion);
				return;
			}

			if($operacion == '3')
			{		
				$co_chofer = "";
				$query_2 = "SELECT co_chofer FROM web_chofer_aso WHERE id_registro = $txtid";	
				$respuesta = $ejecutar->ejecutar($query_2, $conexion, false);	

				if(isset($respuesta["error"]) && $respuesta["error"] == "")
				{
					$result = $respuesta["resultado"];	
					if ($row = $ejecutar->proximo($result))
					{
						do { $co_chofer = $row[$ejecutar->col_db("co_chofer")]; } while ($row = $ejecutar->proximo($result));
					}
				}
				else
				{
					$ejecutar->rollback($conexion);
				    $ejecutar->desconectar($conexion);
				    session()->set('error', "CODE: 3.2<br />MESSAGE: guardar_chofer -> 3.2 ERROR");
				    return;
				}

				if($co_chofer != $txtcodigo)	
				{
					$query_3 = "UPDATE web_chofer_aso SET co_chofer = '$txtcodigo', nb_chofer = '$txtnombre' WHERE id_registro = $txtid";
				}  
				else
				{
					$query_3 = "UPDATE web_chofer_aso SET nb_chofer = '$txtnombre' WHERE id_registro = $txtid";
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
			session()->set('error', "CODE: 9001<br />MESSAGE: Error Fatal -> 9001 guardar_chofer: " . $e->getMessage());
		}
	}
}