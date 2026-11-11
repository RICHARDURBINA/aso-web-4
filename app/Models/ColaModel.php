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

class ColaModel extends Model
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
	public function consultar_cola($par_idcola,
	                               $par_tipocola,
	                               $par_cotransportista,
	                               $par_idchofer,
	                               $par_idvehiculo,
	                               $par_estatus)
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();

		$query_1 = "SELECT a.id_registro as id_cola_aso,		                     
					 a.fe_emision,
					 a.fe_reporte,
					 TO_CHAR(a.fe_emision, 'DD/MM/YYYY HH24:MI:SS') AS fe_emision_form,
					 TO_CHAR(a.fe_reporte, 'DD/MM/YYYY HH24:MI:SS') AS fe_reporte_form,
					 a.ti_cola,
		       		 a.co_transportista,
		       		 b.nb_transportista,
		       		 a.id_chofer,
					 c.co_chofer,
					 c.nb_chofer,
					 c.ctv_co_estado_documento as co_estatus_chofer,
					 a.id_vehiculo,
					 d.co_vehiculo,
					 d.ti_vehiculo,
					 d.capacidad,
					 d.ctv_co_estado_documento as co_estatus_vehiculo,
					 a.kilometraje,		       
					 a.tx_observacion,
					 a.ctv_co_estado_documento
				FROM web_control_cola_aso a
				INNER JOIN web_transportista_aso b ON b.co_transportista = a.co_transportista
				INNER JOIN web_chofer_aso c ON c.id_registro = a.id_chofer
				INNER JOIN web_vehiculo_aso d ON d.id_registro = a.id_vehiculo				
				WHERE TRIM(CAST(a.id_registro AS CHAR(9))) LIKE '$par_idcola'  
				  AND a.ti_cola LIKE '$par_tipocola'
				  AND a.co_transportista LIKE '$par_cotransportista'
				  AND TRIM(CAST(a.id_chofer AS CHAR(9))) LIKE '$par_idchofer'
				  AND TRIM(CAST(a.id_vehiculo AS CHAR(9))) LIKE '$par_idvehiculo'
				  AND a.ctv_co_estado_documento LIKE '$par_estatus'
				ORDER BY a.id_registro ASC";	

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
					$lista [$contador]["id_cola_aso"]      = $row[$ejecutar->col_db("id_cola_aso")];
					$lista [$contador]["fe_emision"]       = $row[$ejecutar->col_db("fe_emision")];
					$lista [$contador]["fe_reporte"]       = $row[$ejecutar->col_db("fe_reporte")];
					$lista [$contador]["fe_emision_form"]  = $row[$ejecutar->col_db("fe_emision_form")];
					$lista [$contador]["fe_reporte_form"]  = $row[$ejecutar->col_db("fe_reporte_form")];
					$lista [$contador]["ti_cola"]          = $row[$ejecutar->col_db("ti_cola")];
					$lista [$contador]["co_transportista"] = $row[$ejecutar->col_db("co_transportista")];
					$lista [$contador]["nb_transportista"] = $row[$ejecutar->col_db("nb_transportista")];
					$lista [$contador]["id_chofer"]        = $row[$ejecutar->col_db("id_chofer")];
					$lista [$contador]["co_chofer"]        = $row[$ejecutar->col_db("co_chofer")];
					$lista [$contador]["nb_chofer"]        = $row[$ejecutar->col_db("nb_chofer")];
					$lista [$contador]["co_estatus_chofer"] = $row[$ejecutar->col_db("co_estatus_chofer")];
					$lista [$contador]["id_vehiculo"]      = $row[$ejecutar->col_db("id_vehiculo")];
					$lista [$contador]["co_vehiculo"]      = $row[$ejecutar->col_db("co_vehiculo")];
					$lista [$contador]["ti_vehiculo"]      = $row[$ejecutar->col_db("ti_vehiculo")];
					$lista [$contador]["capacidad"]        = $row[$ejecutar->col_db("capacidad")];
					$lista [$contador]["kilometraje"]      = $row[$ejecutar->col_db("kilometraje")];
					$lista [$contador]["co_estatus_vehiculo"] = $row[$ejecutar->col_db("co_estatus_vehiculo")];
					$lista [$contador]["tx_observacion"]   = $row[$ejecutar->col_db("tx_observacion")];
					$lista [$contador]["ctv_co_estado_documento"] = $row[$ejecutar->col_db("ctv_co_estado_documento")];
										
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
    public function guardar_cola( $fecha, 
                                  $hora,
                                  $cmbtipocola, 
                                  $cmbtransportista, 
                                  $cmbchofer, 
                                  $cmbvehiculo, 
                                  $kilometraje,                                       
                                  $txtobs,
                                  $operacion )
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
				$idcolaweb = "";
				$fechareporte = $fecha . " " . $hora . ":00";

				$query_2 = "SELECT F00_ID_REGISTRO AS idcolaweb FROM DUAL";	
				$respuesta = $ejecutar->ejecutar($query_2, $conexion, false);	

				if(isset($respuesta["error"]) && $respuesta["error"] == "")
				{
					$result = $respuesta["resultado"];	
					if ($row = $ejecutar->proximo($result))
					{
						do { $idcolaweb = $row[$ejecutar->col_db("idcolaweb")]; } while ($row = $ejecutar->proximo($result));
					}
				}
				else
				{
					$ejecutar->rollback($conexion);
				    $ejecutar->desconectar($conexion);
				    session()->set('error', "CODE: 1.2<br />MESSAGE: guardar_cola -> 1.2 ERROR NO SE PUDO OBTENER EL ID PARA LA COLA F00_ID_REGISTRO");
				    return;
				}
  
				$query_3 = "INSERT INTO web_control_cola_aso ( id_registro,
				                                               fe_emision,
				                                               fe_reporte,
				                                               ti_cola,														  
															   co_transportista,
															   id_chofer,
															   id_vehiculo,
															   kilometraje,														  	
															   tx_observacion,
															   ctv_co_estado_documento ) 
						    VALUES ($idcolaweb,
						            SYSDATE,
						            TO_DATE('$fechareporte','YYYY-MM-DD HH24:MI:SS'),				    	    
						    	    '$cmbtipocola',
						    	    '$cmbtransportista',
						    	    '$cmbchofer',
						    	    '$cmbvehiculo',
						    	    $kilometraje,
						    	    '$txtobs',
						    	    'EM')";
				
				$respuesta = $ejecutar->ejecutar($query_3, $conexion, false);	

				if(!empty($respuesta["error"]))
				{
					$ejecutar->rollback($conexion);
				    $ejecutar->desconectar($conexion);
				    session()->set('error', "CODE: 1.3<br />MESSAGE: guardar_cola -> 1.3 ERROR AL INSERTAR DATOS EN TABLA web_control_cola_aso");
				    return;
				}
			}

			$ejecutar->commit($conexion);
			$ejecutar->desconectar($conexion);
			return;
			
		} 
		catch (\Exception $e) 
		{
		    $ejecutar->rollback($conexion);
			$ejecutar->desconectar($conexion);
			session()->set('error', "CODE: 9001<br />MESSAGE: Error Fatal -> 9001 guardar_cola: " . $e->getMessage());
		}
	}

	//=============================================================================================================
    //
    //=============================================================================================================    
	public function anular_cola( $id_cola_web )
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();

		$conexion = $ejecutar->conectar();
        if (!$conexion) { return; }
		$ejecutar->autocommit($conexion, false);

		try 
		{			
			$query_1 = "UPDATE web_control_cola_aso 
						SET    ctv_co_estado_documento = 'AN'
						WHERE  id_registro = $id_cola_web";

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
			session()->set('error', "CODE: 9001<br />MESSAGE: Error Fatal -> 9001 anular_cola: " . $e->getMessage());
		}
	}

	//=============================================================================================================
    //
    //=============================================================================================================    
	public function finalizar_cola( $id_cola_web )
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();

		$conexion = $ejecutar->conectar();
        if (!$conexion) { return; }
		$ejecutar->autocommit($conexion, false);

		try 
		{			
			$query_1 = "UPDATE web_control_cola_aso 
						SET    ctv_co_estado_documento = 'FN'
						WHERE  id_registro = $id_cola_web";

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
			session()->set('error', "CODE: 9001<br />MESSAGE: Error Fatal -> 9001 finalizar_cola: " . $e->getMessage());
		}
	}

	//=============================================================================================================
    //
    //=============================================================================================================
	public function consultar_cola_fecha( $par_fecha_desde,
	                                 	  $par_fecha_hasta,
	                                 	  $par_idusuario, 
			                              $par_tipocola, 
			                              $par_transportista,
			                              $par_historico )
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();

		if($par_historico == "S") 
		{
			$query_1 = "SELECT ROWNUM AS posicion,
							 xxa.id_cola_aso,		                     
							 xxa.fe_emision,
							 xxa.fe_reporte,
							 xxa.fe_emision_form,
							 xxa.fe_reporte_form,
							 xxa.ti_cola,
							 xxa.co_transportista,
							 xxa.nb_transportista,
							 xxa.id_chofer,
							 xxa.co_chofer,
							 xxa.nb_chofer,
							 xxa.id_vehiculo,
							 xxa.co_vehiculo,
							 xxa.ti_vehiculo,
							 xxa.capacidad,
							 xxa.kilometraje,					       
							 xxa.tx_observacion,
							 xxa.ctv_co_estado_documento,
							 xxa.co_estatus_chofer,
							 xxa.co_estatus_vehiculo,
							 xxa.est_fac_des,
                             xxa.total_carga
			            FROM (SELECT a.id_registro as id_cola_aso,		                     
								 a.fe_emision,
								 a.fe_reporte,
								 TO_CHAR(a.fe_emision, 'DD/MM/YYYY HH24:MI:SS') AS fe_emision_form,
								 TO_CHAR(a.fe_reporte, 'DD/MM/YYYY HH24:MI:SS') AS fe_reporte_form,
								 a.ti_cola,
					       		 a.co_transportista,
					       		 b.nb_transportista,
								 a.id_chofer,
								 c.co_chofer,
								 c.nb_chofer,
								 a.id_vehiculo,
								 d.co_vehiculo,
								 d.ti_vehiculo,
								 d.capacidad,
								 a.kilometraje,					       
								 a.tx_observacion,
								 a.ctv_co_estado_documento,
								 c.ctv_co_estado_documento as co_estatus_chofer,
								 d.ctv_co_estado_documento as co_estatus_vehiculo,
								(SELECT COUNT(xf.estatus_pedido) 
                                   FROM web_programacion_pedido_aso xf 
                                   WHERE xf.estatus_pedido IN ('FACTURADO','DESPACHADO')
                                     AND xf.id_control_cola = a.id_registro) as est_fac_des,
                                  (SELECT NVL(SUM(xf.ca_prd_aprobado * xg.total_kg),0)
                                   FROM web_plan_pedido_aso xf 
                                   INNER JOIN web_productos_aso xg ON xg.id_registro = xf.prd_id_producto_aso
                                   WHERE xf.ctv_co_estado_documento IN ('EM')
                                     AND xf.id_control_cola = a.id_registro) as total_carga 
							FROM web_control_cola_aso a
							INNER JOIN web_transportista_aso b ON b.co_transportista = a.co_transportista
							INNER JOIN web_chofer_aso c ON c.id_registro = a.id_chofer
							INNER JOIN web_vehiculo_aso d ON d.id_registro = a.id_vehiculo			
							WHERE a.fe_reporte >= to_date('$par_fecha_desde','yyyy-mm-dd')
							  AND a.fe_reporte <= to_date('$par_fecha_hasta','yyyy-mm-dd HH24:MI:SS')
							  AND a.ti_cola LIKE '$par_tipocola'
							  AND a.co_transportista LIKE '$par_transportista'
							  AND a.ctv_co_estado_documento NOT IN ('AN')
							  AND a.ti_cola IN ('L')
							ORDER BY a.fe_reporte ASC) xxa			            
			            UNION 
			            SELECT ROWNUM AS posicion,
							 xxb.id_cola_aso,		                     
							 xxb.fe_emision,
							 xxb.fe_reporte,
							 xxb.fe_emision_form,
							 xxb.fe_reporte_form,
							 xxb.ti_cola,
							 xxb.co_transportista,
							 xxb.nb_transportista,
							 xxb.id_chofer,
							 xxb.co_chofer,
							 xxb.nb_chofer,
							 xxb.id_vehiculo,
							 xxb.co_vehiculo,
							 xxb.ti_vehiculo,
							 xxb.capacidad,
							 xxb.kilometraje,					       
							 xxb.tx_observacion,
							 xxb.ctv_co_estado_documento,
							 xxb.co_estatus_chofer,
							 xxb.co_estatus_vehiculo,
							 xxb.est_fac_des,
                             xxb.total_carga
			            FROM (SELECT a.id_registro as id_cola_aso,		                     
								 a.fe_emision,
								 a.fe_reporte,
								 TO_CHAR(a.fe_emision, 'DD/MM/YYYY HH24:MI:SS') AS fe_emision_form,
								 TO_CHAR(a.fe_reporte, 'DD/MM/YYYY HH24:MI:SS') AS fe_reporte_form,
								 a.ti_cola,
					       		 a.co_transportista,
					       		 b.nb_transportista,
					       		 a.id_chofer,
								 c.co_chofer,
								 c.nb_chofer,
								 a.id_vehiculo,
								 d.co_vehiculo,
								 d.ti_vehiculo,
								 d.capacidad,
								 a.kilometraje,					       
								 a.tx_observacion,
								 a.ctv_co_estado_documento,
								 c.ctv_co_estado_documento as co_estatus_chofer,
								 d.ctv_co_estado_documento as co_estatus_vehiculo,
								(SELECT COUNT(xf.estatus_pedido) 
                                   FROM web_programacion_pedido_aso xf 
                                   WHERE xf.estatus_pedido IN ('FACTURADO','DESPACHADO')
                                     AND xf.id_control_cola = a.id_registro) as est_fac_des,
                                  (SELECT NVL(SUM(xf.ca_prd_aprobado * xg.total_kg),0)
                                   FROM web_plan_pedido_aso xf 
                                   INNER JOIN web_productos_aso xg ON xg.id_registro = xf.prd_id_producto_aso
                                   WHERE xf.ctv_co_estado_documento IN ('EM')
                                     AND xf.id_control_cola = a.id_registro) as total_carga 
							FROM web_control_cola_aso a
							INNER JOIN web_transportista_aso b ON b.co_transportista = a.co_transportista
							INNER JOIN web_chofer_aso c ON c.id_registro = a.id_chofer
							INNER JOIN web_vehiculo_aso d ON d.id_registro = a.id_vehiculo			
							WHERE a.fe_reporte >= to_date('$par_fecha_desde','yyyy-mm-dd')
							  AND a.fe_reporte <= to_date('$par_fecha_hasta','yyyy-mm-dd HH24:MI:SS')
							  AND a.ti_cola LIKE '$par_tipocola'
							  AND a.co_transportista LIKE '$par_transportista'
							  AND a.ctv_co_estado_documento NOT IN ('AN')
							  AND a.ti_cola IN ('P')
							ORDER BY a.fe_reporte ASC) xxb
						ORDER BY ti_cola, posicion ASC";		
		}
		else
		{
			$query_1 = "SELECT ROWNUM AS posicion,
							 xxa.id_cola_aso,		                     
							 xxa.fe_emision,
							 xxa.fe_reporte,
							 xxa.fe_emision_form,
							 xxa.fe_reporte_form,
							 xxa.ti_cola,
							 xxa.co_transportista,
							 xxa.nb_transportista,
							 xxa.id_chofer,
							 xxa.co_chofer,
							 xxa.nb_chofer,
							 xxa.id_vehiculo,
							 xxa.co_vehiculo,
							 xxa.ti_vehiculo,
							 xxa.capacidad,
							 xxa.kilometraje,					       
							 xxa.tx_observacion,
							 xxa.ctv_co_estado_documento,
							 xxa.co_estatus_chofer,
							 xxa.co_estatus_vehiculo,
							 xxa.est_fac_des,
                             xxa.total_carga
			            FROM (SELECT xb.id_registro as id_cola_aso,		                     
								   xb.fe_emision,
								   xb.fe_reporte,
								   TO_CHAR(xb.fe_emision, 'DD/MM/YYYY HH24:MI:SS') AS fe_emision_form,
								   TO_CHAR(xb.fe_reporte, 'DD/MM/YYYY HH24:MI:SS') AS fe_reporte_form,
								   xb.ti_cola,
						    	 xb.co_transportista,
						    	 xc.nb_transportista,
						  		 xb.id_chofer,
						  		 xd.co_chofer,
						  		 xd.nb_chofer,
						  		 xb.id_vehiculo,
						  		 xe.co_vehiculo,
						  		 xe.ti_vehiculo,
						  		 xe.capacidad,
						  		 xb.kilometraje,					       
						  		 xb.tx_observacion,
						  		 xb.ctv_co_estado_documento,
						  		 xd.ctv_co_estado_documento as co_estatus_chofer,
								 xe.ctv_co_estado_documento as co_estatus_vehiculo,
								(SELECT COUNT(xf.estatus_pedido) 
                                   FROM web_programacion_pedido_aso xf 
                                   WHERE xf.estatus_pedido IN ('FACTURADO','DESPACHADO')
                                     AND xf.id_control_cola = xb.id_registro) as est_fac_des,
                                  (SELECT NVL(SUM(xf.ca_prd_aprobado * xg.total_kg),0)
                                   FROM web_plan_pedido_aso xf 
                                   INNER JOIN web_productos_aso xg ON xg.id_registro = xf.prd_id_producto_aso
                                   WHERE xf.ctv_co_estado_documento IN ('EM')
                                     AND xf.id_control_cola = xb.id_registro) as total_carga  
							FROM (SELECT max(a.fe_reporte) as fe_reporte, 
							             a.id_chofer,
							             a.ti_cola
					          FROM web_control_cola_aso a
					          WHERE a.fe_reporte >= to_date('$par_fecha_desde','yyyy-mm-dd')
							  	AND a.fe_reporte <= to_date('$par_fecha_hasta','yyyy-mm-dd HH24:MI:SS')
							  	AND a.ctv_co_estado_documento NOT IN ('AN','FN')
					          GROUP BY a.id_chofer, a.ti_cola) xa                  
							INNER JOIN web_control_cola_aso xb ON (xb.fe_reporte = xa.fe_reporte AND
                                                                   xb.id_chofer = xa.id_chofer AND
                                                                   xb.ti_cola = xb.ti_cola)
							INNER JOIN web_transportista_aso xc ON xc.co_transportista = xb.co_transportista
							INNER JOIN web_chofer_aso xd ON xd.id_registro = xb.id_chofer
							INNER JOIN web_vehiculo_aso xe ON xe.id_registro = xb.id_vehiculo	
							WHERE xb.fe_reporte >= to_date('$par_fecha_desde','yyyy-mm-dd')
							  AND xb.fe_reporte <= to_date('$par_fecha_hasta','yyyy-mm-dd HH24:MI:SS')
							  AND xb.ti_cola LIKE '$par_tipocola'
							  AND xb.co_transportista LIKE '$par_transportista'
							  AND xb.ctv_co_estado_documento NOT IN ('AN','FN')
							  AND xb.ti_cola IN ('L')
							ORDER BY xb.fe_reporte ASC) xxa
						WHERE xxa.total_carga <= xxa.capacidad
						UNION
						SELECT ROWNUM AS posicion,
							 xxb.id_cola_aso,		                     
							 xxb.fe_emision,
							 xxb.fe_reporte,
							 xxb.fe_emision_form,
							 xxb.fe_reporte_form,
							 xxb.ti_cola,
							 xxb.co_transportista,
							 xxb.nb_transportista,
							 xxb.id_chofer,
							 xxb.co_chofer,
							 xxb.nb_chofer,
							 xxb.id_vehiculo,
							 xxb.co_vehiculo,
							 xxb.ti_vehiculo,
							 xxb.capacidad,
							 xxb.kilometraje,					       
							 xxb.tx_observacion,
							 xxb.ctv_co_estado_documento,
							 xxb.co_estatus_chofer,
							 xxb.co_estatus_vehiculo,
							 xxb.est_fac_des,
                             xxb.total_carga
			            FROM (SELECT xb.id_registro as id_cola_aso,		                     
								   xb.fe_emision,
								   xb.fe_reporte,
								   TO_CHAR(xb.fe_emision, 'DD/MM/YYYY HH24:MI:SS') AS fe_emision_form,
								   TO_CHAR(xb.fe_reporte, 'DD/MM/YYYY HH24:MI:SS') AS fe_reporte_form,
								   xb.ti_cola,
						    	 xb.co_transportista,
						    	 xc.nb_transportista,
						  		 xb.id_chofer,
						  		 xd.co_chofer,
						  		 xd.nb_chofer,
						  		 xb.id_vehiculo,
						  		 xe.co_vehiculo,
						  		 xe.ti_vehiculo,
						  		 xe.capacidad,
						  		 xb.kilometraje,					       
						  		 xb.tx_observacion,
						  		 xb.ctv_co_estado_documento,
						  		 xd.ctv_co_estado_documento as co_estatus_chofer,
								 xe.ctv_co_estado_documento as co_estatus_vehiculo,
								(SELECT COUNT(xf.estatus_pedido) 
                                   FROM web_programacion_pedido_aso xf 
                                   WHERE xf.estatus_pedido IN ('FACTURADO','DESPACHADO')
                                     AND xf.id_control_cola = xb.id_registro) as est_fac_des,
                                  (SELECT NVL(SUM(xf.ca_prd_aprobado * xg.total_kg),0)
                                   FROM web_plan_pedido_aso xf 
                                   INNER JOIN web_productos_aso xg ON xg.id_registro = xf.prd_id_producto_aso
                                   WHERE xf.ctv_co_estado_documento IN ('EM')
                                     AND xf.id_control_cola = xb.id_registro) as total_carga   
							FROM (SELECT max(a.fe_reporte) as fe_reporte, 
							             a.id_chofer,
							             a.ti_cola
					          FROM web_control_cola_aso a
					          WHERE a.fe_reporte >= to_date('$par_fecha_desde','yyyy-mm-dd')
							  	AND a.fe_reporte <= to_date('$par_fecha_hasta','yyyy-mm-dd HH24:MI:SS')
							  	AND a.ctv_co_estado_documento NOT IN ('AN','FN')
					          GROUP BY a.id_chofer, a.ti_cola) xa                  
							INNER JOIN web_control_cola_aso xb ON (xb.fe_reporte = xa.fe_reporte AND
                                                                   xb.id_chofer = xa.id_chofer AND
                                                                   xb.ti_cola = xb.ti_cola)
							INNER JOIN web_transportista_aso xc ON xc.co_transportista = xb.co_transportista
							INNER JOIN web_chofer_aso xd ON xd.id_registro = xb.id_chofer
							INNER JOIN web_vehiculo_aso xe ON xe.id_registro = xb.id_vehiculo	
							WHERE xb.fe_reporte >= to_date('$par_fecha_desde','yyyy-mm-dd')
							  AND xb.fe_reporte <= to_date('$par_fecha_hasta','yyyy-mm-dd HH24:MI:SS')
							  AND xb.ti_cola LIKE '$par_tipocola'
							  AND xb.co_transportista LIKE '$par_transportista'
							  AND xb.ctv_co_estado_documento NOT IN ('AN','FN')
							  AND xb.ti_cola IN ('P')
							ORDER BY xb.fe_reporte ASC) xxb
			            WHERE xxb.total_carga <= xxb.capacidad
						ORDER BY ti_cola, posicion ASC";		
		}

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
					$lista [$contador]["posicion"]          = $row[$ejecutar->col_db("posicion")];
					$lista [$contador]["id_cola_aso"]       = $row[$ejecutar->col_db("id_cola_aso")];
					$lista [$contador]["fe_emision"]        = $row[$ejecutar->col_db("fe_emision")];
					$lista [$contador]["fe_reporte"]        = $row[$ejecutar->col_db("fe_reporte")];
					$lista [$contador]["fe_emision_form"]   = $row[$ejecutar->col_db("fe_emision_form")];
					$lista [$contador]["fe_reporte_form"]   = $row[$ejecutar->col_db("fe_reporte_form")];
					$lista [$contador]["ti_cola"]           = $row[$ejecutar->col_db("ti_cola")];
					$lista [$contador]["co_transportista"]  = $row[$ejecutar->col_db("co_transportista")];
					$lista [$contador]["nb_transportista"]  = $row[$ejecutar->col_db("nb_transportista")];
					$lista [$contador]["id_chofer"]         = $row[$ejecutar->col_db("id_chofer")];
					$lista [$contador]["co_chofer"]         = $row[$ejecutar->col_db("co_chofer")];
					$lista [$contador]["nb_chofer"]         = $row[$ejecutar->col_db("nb_chofer")];
					$lista [$contador]["id_vehiculo"]       = $row[$ejecutar->col_db("id_vehiculo")];
					$lista [$contador]["co_vehiculo"]       = $row[$ejecutar->col_db("co_vehiculo")];
					$lista [$contador]["ti_vehiculo"]       = $row[$ejecutar->col_db("ti_vehiculo")];
					$lista [$contador]["capacidad"]         = $row[$ejecutar->col_db("capacidad")];
					$lista [$contador]["kilometraje"]       = $row[$ejecutar->col_db("kilometraje")];
					$lista [$contador]["tx_observacion"]    = $row[$ejecutar->col_db("tx_observacion")];
					$lista [$contador]["ctv_co_estado_documento"] = $row[$ejecutar->col_db("ctv_co_estado_documento")];
					$lista [$contador]["co_estatus_chofer"]       = $row[$ejecutar->col_db("co_estatus_chofer")];
					$lista [$contador]["co_estatus_vehiculo"]     = $row[$ejecutar->col_db("co_estatus_vehiculo")];
					$lista [$contador]["est_fac_des"]             = $row[$ejecutar->col_db("est_fac_des")];
					$lista [$contador]["total_carga"]             = $row[$ejecutar->col_db("total_carga")];
										
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