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

class PlanModel extends Model 
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
    //  PLANIFICACION DE PEDIDOS
    //=============================================================================================================
	public function consultar_pedido_vta_prom(  $par_idusuario, 
				                             	$par_vendedor, 
				                                $par_coorganizacion,
				                                $par_coempresa,
				                                $par_coestatus,
				                                $par_idproducto )
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();

		$query_1 = "SELECT a.pec_id_pedido_aso,
					       a.fe_emision,
					       a.co_zona,
					       a.co_organizacion,
					       a.nb_organizacion,
					       a.in_condicion_pago,
					       a.tx_observacion,
					       a.id_vendedor,
					       a.nb_vendedor,
					       a.pedidos_documentos_aso,
					       a.tipo_pedido,
					       a.nu_pedido,
					       a.fe_procesado,
					       a.co_empresa,
					       a.id_referencia_aso,
					       a.ctv_de_estado_documento,
					       a.prd_id_producto_aso,
					       a.ca_producto,
					       a.pr_producto,
					       a.pc_descuento,
					       a.tipo_descuento,
					       a.co_producto,
					       a.nb_producto,
					       a.tx_direccion_entrega,
					       a.total_fac,
       					 a.total_nos,
       					 a.estatus_pedido,
       					 a.id_control_cola,
       					 a.tipo_documento
					FROM WEB_PROGRAMACION_PEDIDO_ASO a
					WHERE a.co_zona IN (SELECT aa.co_zona 
					                    FROM web_usuarios_zonas_aso aa 
					                    WHERE aa.id_usuario = '$par_idusuario')
					  AND TRIM(CAST(a.id_vendedor AS CHAR(15))) LIKE '$par_vendedor' 
					  AND a.co_organizacion LIKE '$par_coorganizacion'
					  AND a.co_empresa LIKE '$par_coempresa'
					  AND a.ctv_de_estado_documento LIKE '$par_coestatus'
					  AND a.estatus_pedido IN ('APROBADO')	
					  AND TRIM(CAST(a.prd_id_producto_aso AS CHAR(15))) LIKE '$par_idproducto'
					  AND NOT EXISTS (SELECT xb.*
					                  FROM web_plan_pedido_aso xb
					                  WHERE xb.pec_id_pedido_aso = a.pec_id_pedido_aso
					                    AND xb.co_empresa = a.co_empresa
					                    AND xb.nu_pedido = a.nu_pedido
					                    AND xb.ctv_co_estado_documento = 'EM')				  
					ORDER BY a.pec_id_pedido_aso, a.pedidos_documentos_aso, a.tipo_pedido DESC";

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
				do
				{
					$lista [$contador]["pec_id_pedido_aso"]       = $row[$ejecutar->col_db("pec_id_pedido_aso")];
					$lista [$contador]["fe_emision"]              = $row[$ejecutar->col_db("fe_emision")];
					$lista [$contador]["co_zona"]                 = $row[$ejecutar->col_db("co_zona")];
					$lista [$contador]["co_organizacion"]         = $row[$ejecutar->col_db("co_organizacion")];
					$lista [$contador]["nb_organizacion"]         = $row[$ejecutar->col_db("nb_organizacion")];
					$lista [$contador]["in_condicion_pago"]       = $row[$ejecutar->col_db("in_condicion_pago")];
					$lista [$contador]["tx_observacion"]          = $row[$ejecutar->col_db("tx_observacion")];
					$lista [$contador]["id_vendedor"]             = $row[$ejecutar->col_db("id_vendedor")];
					$lista [$contador]["nb_vendedor"]             = $row[$ejecutar->col_db("nb_vendedor")];
					$lista [$contador]["pedidos_documentos_aso"]  = $row[$ejecutar->col_db("pedidos_documentos_aso")];
					$lista [$contador]["tipo_pedido"]             = $row[$ejecutar->col_db("tipo_pedido")];
					$lista [$contador]["nu_pedido"]               = $row[$ejecutar->col_db("nu_pedido")];
					$lista [$contador]["fe_procesado"]            = $row[$ejecutar->col_db("fe_procesado")];
					$lista [$contador]["co_empresa"]              = $row[$ejecutar->col_db("co_empresa")];
					$lista [$contador]["id_referencia_aso"]       = $row[$ejecutar->col_db("id_referencia_aso")];
					$lista [$contador]["ctv_de_estado_documento"] = $row[$ejecutar->col_db("ctv_de_estado_documento")];
					$lista [$contador]["prd_id_producto_aso"]     = $row[$ejecutar->col_db("prd_id_producto_aso")];
					$lista [$contador]["ca_producto"]             = $row[$ejecutar->col_db("ca_producto")];
					$lista [$contador]["pr_producto"]             = $row[$ejecutar->col_db("pr_producto")];
					$lista [$contador]["pc_descuento"]            = $row[$ejecutar->col_db("pc_descuento")];
					$lista [$contador]["tipo_descuento"]          = $row[$ejecutar->col_db("tipo_descuento")];
					$lista [$contador]["co_producto"]             = $row[$ejecutar->col_db("co_producto")];
					$lista [$contador]["nb_producto"]             = $row[$ejecutar->col_db("nb_producto")];
					$lista [$contador]["tx_direccion_entrega"]    = $row[$ejecutar->col_db("tx_direccion_entrega")];
					$lista [$contador]["total_fac"]               = $row[$ejecutar->col_db("total_fac")];
					$lista [$contador]["total_nos"]               = $row[$ejecutar->col_db("total_nos")];
					$lista [$contador]["estatus_pedido"]          = $row[$ejecutar->col_db("estatus_pedido")];
					$lista [$contador]["id_control_cola"]         = $row[$ejecutar->col_db("id_control_cola")];	
					$lista [$contador]["tipo_documento"]          = $row[$ejecutar->col_db("tipo_documento")];										

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

	public function consultar_detalle_pedido( $id_ped_web, 
		                                      $id_doc_emp,
		                                      $tipo_pedido,
		                                      $tipo_documento )
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();

		if($tipo_documento == 'ORDEN') 
		{
			$query_1 = "SELECT a.co_empresa,
						       a.ref_num_pedido as nu_pedido,
						       d.prd_id_producto_aso,
						       d.ca_producto
						FROM web_orden_aso a
						INNER JOIN web_clientes_aso c ON c.co_organizacion = a.co_organizacion
						INNER JOIN web_orden_productos_aso d ON d.id_orden_aso = a.id_registro 
						INNER JOIN web_productos_aso e ON e.id_registro = d.prd_id_producto_aso AND e.co_empresa = a.co_empresa
						INNER JOIN web_usuarios_aso f ON f.id_registro = a.id_vendedor
						WHERE TRIM(CAST(a.id_registro AS CHAR(9))) LIKE '$id_ped_web' 
						ORDER BY a.id_registro ASC";	
        }
        else 
        {
           if($tipo_pedido == "VENTA") {
				$query_1 = "SELECT b.co_empresa,
							       b.nu_pedido,
							       d.prd_id_producto_aso,
							       d.ca_producto
							FROM web_pedidos_aso a
							INNER JOIN web_pedidos_documentos_aso b ON b.pec_id_pedido_aso = a.id_registro
							INNER JOIN web_clientes_aso c ON c.co_organizacion = a.co_organizacion
							INNER JOIN web_pedidos_productos_aso d ON d.pec_id_pedido_aso = a.id_registro 
							INNER JOIN web_productos_aso e ON e.id_registro = d.prd_id_producto_aso AND e.co_empresa = b.co_empresa
							INNER JOIN web_usuarios_aso f ON f.id_registro = a.id_vendedor
							WHERE TRIM(CAST(a.id_registro AS CHAR(9))) LIKE '$id_ped_web' 
							  AND TRIM(CAST(b.id_registro AS CHAR(9))) LIKE '$id_doc_emp' 
							ORDER BY a.id_registro, b.id_registro ASC";	
			}
			else
			{
				$query_1 = "SELECT b.co_empresa,
							       b.nu_pedido_promo as nu_pedido,
							       d.prd_id_producto_aso,
							       d.ca_producto_promo as ca_producto
							FROM web_pedidos_aso a
							INNER JOIN web_pedidos_documentos_aso b ON b.pec_id_pedido_aso = a.id_registro
							INNER JOIN web_clientes_aso c ON c.co_organizacion = a.co_organizacion
							INNER JOIN web_pedidos_productos_aso d ON d.pec_id_pedido_aso = a.id_registro 
							INNER JOIN web_productos_aso e ON e.id_registro = d.prd_id_producto_aso AND e.co_empresa = b.co_empresa
							INNER JOIN web_usuarios_aso f ON f.id_registro = a.id_vendedor
							WHERE TRIM(CAST(a.id_registro AS CHAR(9))) LIKE '$id_ped_web' 
							  AND TRIM(CAST(b.id_registro AS CHAR(9))) LIKE '$id_doc_emp' 
							ORDER BY a.id_registro, b.id_registro ASC";	
			}
        }   

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
				do
				{
					$lista [$contador]["id_ped_web"]          = $id_ped_web;
					$lista [$contador]["id_doc_emp"]          = $id_doc_emp;
					$lista [$contador]["tipo_pedido"]         = $tipo_pedido;
					$lista [$contador]["co_empresa"]          = $row[$ejecutar->col_db("co_empresa")];
					$lista [$contador]["nu_pedido"]           = $row[$ejecutar->col_db("nu_pedido")];
					$lista [$contador]["prd_id_producto_aso"] = $row[$ejecutar->col_db("prd_id_producto_aso")];
					$lista [$contador]["ca_producto"]         = $row[$ejecutar->col_db("ca_producto")];
										
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

    public function planificar_pedido( $fe_emision, $arr_pedido )
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();
		
		$conexion = $ejecutar->conectar();
        if (!$conexion) 
        {
            return;
        }
		$ejecutar->autocommit($conexion, false);

		try 
		{					
			for ($i = 0; $i < count($arr_pedido); $i++) {
				$idplan = "";
				$query_1 = "SELECT F00_ID_REGISTRO AS idplanweb FROM DUAL";	

				$respuesta = $ejecutar->ejecutar($query_1, $conexion, false);	

				if(isset($respuesta["error"]) && $respuesta["error"] == "")
				{
					$result = $respuesta["resultado"];	

					if ($row = $ejecutar->proximo($result))
					{
						do
						{
							$idplan = $row[$ejecutar->col_db("idplanweb")];
						}
						while ($row = $ejecutar->proximo($result));
					}
				}
				else
				{
					$ejecutar->rollback($conexion); 	
				    $ejecutar->desconectar($conexion);	

				    $msn = "CODE: 1.1<br />";
					$msn = $msn . "MESSAGE: planificar_pedido -> 1.1 ERROR NO SE PUDO OBTENER EL ID PARA EL PLAN F00_ID_REGISTRO <br />";

				    session()->set('error', $msn);
				    return;
				}

				$query_3 = "INSERT INTO web_plan_pedido_aso ( id_registro,
											   			      pec_id_pedido_aso,
													          co_empresa,
													          nu_pedido,
													          fe_emision,
													          prd_id_producto_aso,
													      	  ca_prd_solicitado,
													      	  ca_prd_aprobado,
													      	  ctv_co_estado_documento )
						    VALUES ($idplan,
						            ".$arr_pedido[$i]['id_ped_web'].",
						            '".$arr_pedido[$i]['co_empresa']."',
						            '".$arr_pedido[$i]['nu_pedido']."',
						            TO_DATE('$fe_emision','YYYY-MM-DD HH24:MI:SS'),
						            ".$arr_pedido[$i]['prd_id_producto_aso'].",
						            ".$arr_pedido[$i]['ca_producto'].",
						            ".$arr_pedido[$i]['ca_producto'].",
						            'EM')";
				
				$respuesta = $ejecutar->ejecutar($query_3, $conexion, false);	

				if(!empty($respuesta["error"]))
				{
					$ejecutar->rollback($conexion); 	
				    $ejecutar->desconectar($conexion);	

				    $msn = "CODE: 1.3<br />";
					$msn = $msn . "MESSAGE: planificar_pedido -> 1.3 ERROR AL INSERTAR DATOS EN TABLA web_plan_pedido_aso <br />";

				    session()->set('error', $msn);
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

			$msn = "CODE: 9001<br />";
			$msn = $msn . "MESSAGE: Error Fatal -> 9001 planificar_pedido: " . $e->getMessage() . " <br />";

			session()->set('error', $msn);
		}
	}

   public function consultar_planificacion(  $par_fecha,
	                                 		$par_idusuario, 
				                            $par_vendedor, 
				                            $par_coorganizacion,
				                            $par_coempresa,
				                            $par_coestatus  )
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();

		$par_fecha_hora = $par_fecha . " 23:59:00";

		$query_1 = "SELECT DISTINCT a.pec_id_pedido_aso,
					       a.fe_emision,
					       a.co_zona,
					       a.co_organizacion,
					       a.nb_organizacion,
					       a.in_condicion_pago,
					       a.tx_observacion,
					       a.id_vendedor,
					       a.nb_vendedor,
					       a.pedidos_documentos_aso,
					       a.tipo_pedido,
					       a.nu_pedido,
					       a.fe_procesado,
					       a.co_empresa,
					       a.id_referencia_aso,
					       a.ctv_de_estado_documento,
					       a.prd_id_producto_aso,
					       a.ca_producto,
					       a.pr_producto,
					       a.pc_descuento,
					       a.tipo_descuento,
					       a.co_producto,
					       a.nb_producto,
					       a.tx_direccion_entrega,
					       a.total_fac,
       					 a.total_nos,
       					 a.estatus_pedido,
       					 a.id_control_cola,
       					 b.co_transportista,
	       		 		 c.nb_transportista,
						 b.id_chofer,
						 d.co_chofer,
					 	 d.nb_chofer,
						 b.id_vehiculo,
						 e.co_vehiculo,
						 e.ti_vehiculo,
						 e.capacidad,
						 a.fe_plan,
						 a.tipo_documento,
						 a.sincronizado
					FROM WEB_PROGRAMACION_PEDIDO_ASO a
					LEFT JOIN web_control_cola_aso b ON b.id_registro = a.id_control_cola
          		    LEFT JOIN web_transportista_aso c ON c.co_transportista = b.co_transportista
					LEFT JOIN web_chofer_aso d ON d.id_registro = b.id_chofer
					LEFT JOIN web_vehiculo_aso e ON e.id_registro = b.id_vehiculo		
					WHERE a.fe_plan >= to_date('$par_fecha','yyyy-mm-dd')
					  AND a.fe_plan <= to_date('$par_fecha_hora','yyyy-mm-dd HH24:MI:SS')
					  AND a.co_zona IN (SELECT aa.co_zona 
					                    FROM web_usuarios_zonas_aso aa 
					                    WHERE aa.id_usuario = '$par_idusuario')
					  AND TRIM(CAST(a.id_vendedor AS CHAR(15))) LIKE '$par_vendedor' 
					  AND a.co_organizacion LIKE '$par_coorganizacion'
					  AND a.co_empresa LIKE '$par_coempresa'
					  AND a.ctv_de_estado_documento LIKE '$par_coestatus'
					  AND a.estatus_pedido IN ('APROBADO','FACTURADO','DESPACHADO')
					  AND a.ctv_de_estado_documento IN ('APROBADO')
					  AND EXISTS (SELECT xb.*
					              FROM web_plan_pedido_aso xb
					              WHERE xb.pec_id_pedido_aso = a.pec_id_pedido_aso
					                AND xb.co_empresa = a.co_empresa
					                AND xb.nu_pedido = a.nu_pedido
					                AND xb.ctv_co_estado_documento = 'EM')	
					ORDER BY a.pec_id_pedido_aso, a.pedidos_documentos_aso, a.tipo_pedido DESC";

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
				do
				{
					$lista [$contador]["pec_id_pedido_aso"]       = $row[$ejecutar->col_db("pec_id_pedido_aso")];
					$lista [$contador]["fe_emision"]              = $row[$ejecutar->col_db("fe_emision")];
					$lista [$contador]["co_zona"]                 = $row[$ejecutar->col_db("co_zona")];
					$lista [$contador]["co_organizacion"]         = $row[$ejecutar->col_db("co_organizacion")];
					$lista [$contador]["nb_organizacion"]         = $row[$ejecutar->col_db("nb_organizacion")];
					$lista [$contador]["in_condicion_pago"]       = $row[$ejecutar->col_db("in_condicion_pago")];
					$lista [$contador]["tx_observacion"]          = $row[$ejecutar->col_db("tx_observacion")];
					$lista [$contador]["id_vendedor"]             = $row[$ejecutar->col_db("id_vendedor")];
					$lista [$contador]["nb_vendedor"]             = $row[$ejecutar->col_db("nb_vendedor")];
					$lista [$contador]["pedidos_documentos_aso"]  = $row[$ejecutar->col_db("pedidos_documentos_aso")];
					$lista [$contador]["tipo_pedido"]             = $row[$ejecutar->col_db("tipo_pedido")];
					$lista [$contador]["nu_pedido"]               = $row[$ejecutar->col_db("nu_pedido")];
					$lista [$contador]["fe_procesado"]            = $row[$ejecutar->col_db("fe_procesado")];
					$lista [$contador]["co_empresa"]              = $row[$ejecutar->col_db("co_empresa")];
					$lista [$contador]["id_referencia_aso"]       = $row[$ejecutar->col_db("id_referencia_aso")];
					$lista [$contador]["ctv_de_estado_documento"] = $row[$ejecutar->col_db("ctv_de_estado_documento")];
					$lista [$contador]["prd_id_producto_aso"]     = $row[$ejecutar->col_db("prd_id_producto_aso")];
					$lista [$contador]["ca_producto"]             = $row[$ejecutar->col_db("ca_producto")];
					$lista [$contador]["pr_producto"]             = $row[$ejecutar->col_db("pr_producto")];
					$lista [$contador]["pc_descuento"]            = $row[$ejecutar->col_db("pc_descuento")];
					$lista [$contador]["tipo_descuento"]          = $row[$ejecutar->col_db("tipo_descuento")];
					$lista [$contador]["co_producto"]             = $row[$ejecutar->col_db("co_producto")];
					$lista [$contador]["nb_producto"]             = $row[$ejecutar->col_db("nb_producto")];
					$lista [$contador]["tx_direccion_entrega"]    = $row[$ejecutar->col_db("tx_direccion_entrega")];
					$lista [$contador]["total_fac"]               = $row[$ejecutar->col_db("total_fac")];
					$lista [$contador]["total_nos"]               = $row[$ejecutar->col_db("total_nos")];
					$lista [$contador]["estatus_pedido"]          = $row[$ejecutar->col_db("estatus_pedido")];
					$lista [$contador]["id_control_cola"]         = $row[$ejecutar->col_db("id_control_cola")];

					$lista [$contador]["co_transportista"]        = $row[$ejecutar->col_db("co_transportista")];
					$lista [$contador]["nb_transportista"]        = $row[$ejecutar->col_db("nb_transportista")];
					$lista [$contador]["id_chofer"]               = $row[$ejecutar->col_db("id_chofer")];
					$lista [$contador]["co_chofer"]               = $row[$ejecutar->col_db("co_chofer")];
					$lista [$contador]["nb_chofer"]               = $row[$ejecutar->col_db("nb_chofer")];
					$lista [$contador]["id_vehiculo"]             = $row[$ejecutar->col_db("id_vehiculo")];
					$lista [$contador]["co_vehiculo"]             = $row[$ejecutar->col_db("co_vehiculo")];
					$lista [$contador]["ti_vehiculo"]             = $row[$ejecutar->col_db("ti_vehiculo")];
					$lista [$contador]["capacidad"]               = $row[$ejecutar->col_db("capacidad")];

					$lista [$contador]["fe_plan"]                 = $row[$ejecutar->col_db("fe_plan")];	
					$lista [$contador]["tipo_documento"]          = $row[$ejecutar->col_db("tipo_documento")];
					$lista [$contador]["sincronizado"]            = $row[$ejecutar->col_db("sincronizado")];		
										
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

   public function consultar_planificacion_fecha( $par_fecha_desde,
	                                 			  $par_fecha_hasta,
	                                 		      $par_idusuario, 
				                                  $par_vendedor, 
				                                  $par_coorganizacion,
				                                  $par_coempresa,
				                                  $par_coestatus,
				                                  $par_idproducto )
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();

		$par_fecha_hora_hasta = $par_fecha_hasta . " 23:59:00";

		$query_1 = "SELECT DISTINCT a.pec_id_pedido_aso,
					       a.fe_emision,
					       a.co_zona,
					       a.co_organizacion,
					       a.nb_organizacion,
					       a.in_condicion_pago,
					       a.tx_observacion,
					       a.id_vendedor,
					       a.nb_vendedor,
					       a.pedidos_documentos_aso,
					       a.tipo_pedido,
					       a.nu_pedido,
					       a.fe_procesado,
					       a.co_empresa,
					       a.id_referencia_aso,
					       a.ctv_de_estado_documento,
					       a.prd_id_producto_aso,
					       a.ca_producto,
					       a.pr_producto,
					       a.pc_descuento,
					       a.tipo_descuento,
					       a.co_producto,
					       a.nb_producto,
					       a.tx_direccion_entrega,
					       a.total_fac,
       					 a.total_nos,
       					 a.estatus_pedido,
       					 a.id_control_cola,
       					 b.co_transportista,
	       		 		 c.nb_transportista,
						 b.id_chofer,
						 d.co_chofer,
						 d.nb_chofer,
						 b.id_vehiculo,
						 e.co_vehiculo,
						 e.ti_vehiculo,
						 e.capacidad,
						 a.fe_plan,
						 a.tipo_documento,
						 a.sincronizado
					FROM WEB_PROGRAMACION_PEDIDO_ASO a
					LEFT JOIN web_control_cola_aso b ON b.id_registro = a.id_control_cola
          		    LEFT JOIN web_transportista_aso c ON c.co_transportista = b.co_transportista
					LEFT JOIN web_chofer_aso d ON d.id_registro = b.id_chofer
					LEFT JOIN web_vehiculo_aso e ON e.id_registro = b.id_vehiculo		
					WHERE a.fe_plan >= to_date('$par_fecha_desde','yyyy-mm-dd')
					  AND a.fe_plan <= to_date('$par_fecha_hora_hasta','yyyy-mm-dd HH24:MI:SS')
					  AND a.co_zona IN (SELECT aa.co_zona 
					                    FROM web_usuarios_zonas_aso aa 
					                    WHERE aa.id_usuario = '$par_idusuario')
					  AND TRIM(CAST(a.id_vendedor AS CHAR(15))) LIKE '$par_vendedor' 
					  AND a.co_organizacion LIKE '$par_coorganizacion'
					  AND a.co_empresa LIKE '$par_coempresa'
					  AND a.ctv_de_estado_documento LIKE '$par_coestatus'
					  AND a.estatus_pedido IN ('APROBADO','FACTURADO','DESPACHADO')
					  AND a.ctv_de_estado_documento IN ('APROBADO')
					  AND TRIM(CAST(a.prd_id_producto_aso AS CHAR(15))) LIKE '$par_idproducto'					  
					  AND EXISTS (SELECT xb.*
					              FROM web_plan_pedido_aso xb
					              WHERE xb.pec_id_pedido_aso = a.pec_id_pedido_aso
					                AND xb.co_empresa = a.co_empresa
					                AND xb.nu_pedido = a.nu_pedido
					                AND xb.ctv_co_estado_documento = 'EM')	
					ORDER BY a.pec_id_pedido_aso, a.pedidos_documentos_aso, a.tipo_pedido DESC";

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
				do
				{
					$lista [$contador]["pec_id_pedido_aso"]       = $row[$ejecutar->col_db("pec_id_pedido_aso")];
					$lista [$contador]["fe_emision"]              = $row[$ejecutar->col_db("fe_emision")];
					$lista [$contador]["co_zona"]                 = $row[$ejecutar->col_db("co_zona")];
					$lista [$contador]["co_organizacion"]         = $row[$ejecutar->col_db("co_organizacion")];
					$lista [$contador]["nb_organizacion"]         = $row[$ejecutar->col_db("nb_organizacion")];
					$lista [$contador]["in_condicion_pago"]       = $row[$ejecutar->col_db("in_condicion_pago")];
					$lista [$contador]["tx_observacion"]          = $row[$ejecutar->col_db("tx_observacion")];
					$lista [$contador]["id_vendedor"]             = $row[$ejecutar->col_db("id_vendedor")];
					$lista [$contador]["nb_vendedor"]             = $row[$ejecutar->col_db("nb_vendedor")];
					$lista [$contador]["pedidos_documentos_aso"]  = $row[$ejecutar->col_db("pedidos_documentos_aso")];
					$lista [$contador]["tipo_pedido"]             = $row[$ejecutar->col_db("tipo_pedido")];
					$lista [$contador]["nu_pedido"]               = $row[$ejecutar->col_db("nu_pedido")];
					$lista [$contador]["fe_procesado"]            = $row[$ejecutar->col_db("fe_procesado")];
					$lista [$contador]["co_empresa"]              = $row[$ejecutar->col_db("co_empresa")];
					$lista [$contador]["id_referencia_aso"]       = $row[$ejecutar->col_db("id_referencia_aso")];
					$lista [$contador]["ctv_de_estado_documento"] = $row[$ejecutar->col_db("ctv_de_estado_documento")];
					$lista [$contador]["prd_id_producto_aso"]     = $row[$ejecutar->col_db("prd_id_producto_aso")];
					$lista [$contador]["ca_producto"]             = $row[$ejecutar->col_db("ca_producto")];
					$lista [$contador]["pr_producto"]             = $row[$ejecutar->col_db("pr_producto")];
					$lista [$contador]["pc_descuento"]            = $row[$ejecutar->col_db("pc_descuento")];
					$lista [$contador]["tipo_descuento"]          = $row[$ejecutar->col_db("tipo_descuento")];
					$lista [$contador]["co_producto"]             = $row[$ejecutar->col_db("co_producto")];
					$lista [$contador]["nb_producto"]             = $row[$ejecutar->col_db("nb_producto")];
					$lista [$contador]["tx_direccion_entrega"]    = $row[$ejecutar->col_db("tx_direccion_entrega")];
					$lista [$contador]["total_fac"]               = $row[$ejecutar->col_db("total_fac")];
					$lista [$contador]["total_nos"]               = $row[$ejecutar->col_db("total_nos")];
					$lista [$contador]["estatus_pedido"]          = $row[$ejecutar->col_db("estatus_pedido")];
					$lista [$contador]["id_control_cola"]         = $row[$ejecutar->col_db("id_control_cola")];

					$lista [$contador]["co_transportista"]        = $row[$ejecutar->col_db("co_transportista")];
					$lista [$contador]["nb_transportista"]        = $row[$ejecutar->col_db("nb_transportista")];
					$lista [$contador]["id_chofer"]               = $row[$ejecutar->col_db("id_chofer")];
					$lista [$contador]["co_chofer"]               = $row[$ejecutar->col_db("co_chofer")];
					$lista [$contador]["nb_chofer"]               = $row[$ejecutar->col_db("nb_chofer")];
					$lista [$contador]["id_vehiculo"]             = $row[$ejecutar->col_db("id_vehiculo")];
					$lista [$contador]["co_vehiculo"]             = $row[$ejecutar->col_db("co_vehiculo")];
					$lista [$contador]["ti_vehiculo"]             = $row[$ejecutar->col_db("ti_vehiculo")];
					$lista [$contador]["capacidad"]               = $row[$ejecutar->col_db("capacidad")];

					$lista [$contador]["fe_plan"]                 = $row[$ejecutar->col_db("fe_plan")];	
					$lista [$contador]["tipo_documento"]          = $row[$ejecutar->col_db("tipo_documento")];
					$lista [$contador]["sincronizado"]            = $row[$ejecutar->col_db("sincronizado")];		
										
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
  
	public function anular_plan( $id_ped_web, $id_doc_emp, $nu_pedido, $ti_doc )
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();

		$conexion = $ejecutar->conectar();
        if (!$conexion) 
        {
            return;
        }
		$ejecutar->autocommit($conexion, false);

		try 
		{			
			$query_1 = "UPDATE web_plan_pedido_aso 
						SET    ctv_co_estado_documento = 'AN'
						WHERE  pec_id_pedido_aso = $id_ped_web
						  AND  nu_pedido = '$nu_pedido'
						  AND  id_control_cola IS NULL";

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

			$msn = "CODE: 9001<br />";
			$msn = $msn . "MESSAGE: Error Fatal -> 9001 anular_plan: " . $e->getMessage() . " <br />";

			session()->set('error', $msn);
		}
	}

	public function aplicar_nc_total( $id_ped_web, $id_doc_emp, $nu_pedido, $ti_doc )
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();

		$conexion = $ejecutar->conectar();
        if (!$conexion) 
        {
            return;
        }
		$ejecutar->autocommit($conexion, false);

		try 
		{			
			$query_1 = "UPDATE web_plan_pedido_aso 
						SET    ctv_co_estado_documento = 'NCT'
						WHERE  pec_id_pedido_aso = $id_ped_web
						  AND  nu_pedido = '$nu_pedido'";

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

			$msn = "CODE: 9001<br />";
			$msn = $msn . "MESSAGE: Error Fatal -> 9001 aplicar_nc_total: " . $e->getMessage() . " <br />";

			session()->set('error', $msn);
		}
	}

	public function anular_transporte( $id_ped_web, $id_doc_emp, $nu_pedido, $ti_doc )
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();

		$conexion = $ejecutar->conectar();
        if (!$conexion) 
        {
            return;
        }
		$ejecutar->autocommit($conexion, false);

		try 
		{			
			$query_1 = "UPDATE web_plan_pedido_aso 
						SET id_control_cola = NULL 
						WHERE  pec_id_pedido_aso = $id_ped_web
						  AND  nu_pedido = '$nu_pedido'
						  AND ctv_co_estado_documento = 'EM'";

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

			$msn = "CODE: 9001<br />";
			$msn = $msn . "MESSAGE: Error Fatal -> 9001 anular_transporte: " . $e->getMessage() . " <br />";

			session()->set('error', $msn);
		}
	}

	public function consultar_control_cola_disponible( $par_idusuario, $par_tipocola, $par_transportista )
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();

		$query_1 = "SELECT xxxa.posicion,
						   xxxa.id_cola_aso,		                     
						   xxxa.fe_emision,
						   xxxa.fe_reporte,
						   xxxa.fe_emision_form,
						   xxxa.fe_reporte_form,
						   xxxa.ti_cola,
						   xxxa.co_transportista,
						   xxxa.nb_transportista,
						   xxxa.id_chofer,
						   xxxa.co_chofer,
						   xxxa.nb_chofer,
						   xxxa.id_vehiculo,
						   xxxa.co_vehiculo,
						   xxxa.ti_vehiculo,
						   xxxa.capacidad,
						   xxxa.kilometraje,					       
						   xxxa.tx_observacion,
						   xxxa.ctv_co_estado_documento,
		       			   SUM(NVL(xxd.ca_prd_solicitado_kg, 0)) AS ca_prd_solicitado_kg,
		      			   SUM(NVL(xxd.ca_prd_aprobado_kg, 0)) AS ca_prd_aprobado_kg
					FROM (SELECT ROWNUM AS posicion,
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
						              WHERE a.ctv_co_estado_documento NOT IN ('AN','FN')
						          	  GROUP BY a.id_chofer, a.ti_cola) xa                  
							    INNER JOIN web_control_cola_aso xb ON (xb.fe_reporte = xa.fe_reporte AND
					                                                 xb.id_chofer = xa.id_chofer AND
					                                                 xb.ti_cola = xb.ti_cola)
							    INNER JOIN web_transportista_aso xc ON xc.co_transportista = xb.co_transportista
							    INNER JOIN web_chofer_aso xd ON xd.id_registro = xb.id_chofer
							    INNER JOIN web_vehiculo_aso xe ON xe.id_registro = xb.id_vehiculo	
							    WHERE xb.ti_cola LIKE '%'
							      AND xb.co_transportista LIKE '%'
							      AND xb.ctv_co_estado_documento NOT IN ('AN','FN')
							      AND xb.ti_cola IN ('L')
							      AND xd.ctv_co_estado_documento IN ('AC')
						    	  AND xe.ctv_co_estado_documento IN ('AC')
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
								  		(SELECT COUNT(xf.estatus_pedido) 
		                                 FROM web_programacion_pedido_aso xf 
		                                 WHERE xf.estatus_pedido IN ('FACTURADO','DESPACHADO')
		                                   AND xf.id_control_cola = xb.id_registro) as est_fac_des ,
		                                (SELECT NVL(SUM(xf.ca_prd_aprobado * xg.total_kg),0)
		                                 FROM web_plan_pedido_aso xf 
		                                 INNER JOIN web_productos_aso xg ON xg.id_registro = xf.prd_id_producto_aso
		                                 WHERE xf.ctv_co_estado_documento IN ('EM')
		                                   AND xf.id_control_cola = xb.id_registro) as total_carga 
								  FROM (SELECT max(a.fe_reporte) as fe_reporte, 
								               a.id_chofer,
								               a.ti_cola
							            FROM web_control_cola_aso a
							            WHERE a.ctv_co_estado_documento NOT IN ('AN','FN')
							          	GROUP BY a.id_chofer, a.ti_cola) xa                  
								  INNER JOIN web_control_cola_aso xb ON (xb.fe_reporte = xa.fe_reporte AND
						                                               xb.id_chofer = xa.id_chofer AND
						                                               xb.ti_cola = xb.ti_cola)
								  INNER JOIN web_transportista_aso xc ON xc.co_transportista = xb.co_transportista
								  INNER JOIN web_chofer_aso xd ON xd.id_registro = xb.id_chofer
								  INNER JOIN web_vehiculo_aso xe ON xe.id_registro = xb.id_vehiculo	
								  WHERE xb.ti_cola LIKE '%'
								    AND xb.co_transportista LIKE '%'
								    AND xb.ctv_co_estado_documento NOT IN ('AN','FN')
								    AND xb.ti_cola IN ('P')
								    AND xd.ctv_co_estado_documento IN ('AC')
								    AND xe.ctv_co_estado_documento IN ('AC')
								  ORDER BY xb.fe_reporte ASC) xxb  
							WHERE xxb.total_carga <= xxb.capacidad                   
							ORDER BY ti_cola, posicion ASC ) xxxa
					LEFT JOIN (SELECT xf.co_empresa,
		                              xf.prd_id_producto_aso,
		                              SUM(xf.ca_prd_solicitado * xg.total_kg) AS ca_prd_solicitado_kg,
		                              SUM(xf.ca_prd_aprobado * xg.total_kg) AS ca_prd_aprobado_kg,
		                              xf.id_control_cola,
		                              xf.ctv_co_estado_documento
		                       FROM web_plan_pedido_aso xf
		                       INNER JOIN web_productos_aso xg ON xg.id_registro = xf.prd_id_producto_aso
		                       WHERE  xf.ctv_co_estado_documento IN ('EM')
		                       GROUP BY xf.co_empresa,
		                                xf.prd_id_producto_aso,
		                                xf.id_control_cola,
		                                xf.ctv_co_estado_documento) xxd ON xxd.id_control_cola = xxxa.id_cola_aso 
					GROUP BY xxxa.posicion,
						     xxxa.id_cola_aso,		                     
						     xxxa.fe_emision,
						     xxxa.fe_reporte,
						     xxxa.fe_emision_form,
						     xxxa.fe_reporte_form,
						     xxxa.ti_cola,
						     xxxa.co_transportista,
						     xxxa.nb_transportista,
						     xxxa.id_chofer,
						     xxxa.co_chofer,
						     xxxa.nb_chofer,
						     xxxa.id_vehiculo,
						     xxxa.co_vehiculo,
						     xxxa.ti_vehiculo,
						     xxxa.capacidad,
						     xxxa.kilometraje,					       
						     xxxa.tx_observacion,
						     xxxa.ctv_co_estado_documento
				    ORDER BY ti_cola, posicion";

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
					$lista [$contador]["ca_prd_solicitado_kg"]    = $row[$ejecutar->col_db("ca_prd_solicitado_kg")];
					$lista [$contador]["ca_prd_aprobado_kg"]      = $row[$ejecutar->col_db("ca_prd_aprobado_kg")];
										
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

	public function asignar_transporte( $id_ped_web, $id_doc_emp, $nu_pedido, $id_cola, $ti_doc )
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();

		$conexion = $ejecutar->conectar();
        if (!$conexion) 
        {
            return;
        }
		$ejecutar->autocommit($conexion, false);

		try 
		{			
			$query_1 = "UPDATE web_plan_pedido_aso 
						SET    id_control_cola = $id_cola						
						WHERE  pec_id_pedido_aso = $id_ped_web
						  AND  nu_pedido = '$nu_pedido'
						  AND  ctv_co_estado_documento = 'EM'
						  AND  id_control_cola IS NULL";

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

			$msn = "CODE: 9001<br />";
			$msn = $msn . "MESSAGE: Error Fatal -> 9001 asignar_transporte: " . $e->getMessage() . " <br />";

			session()->set('error', $msn);
		}
	}

	public function consultar_inventario( $par_fecha, $par_idusuario )
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();

		$query_1 = "SELECT a.id_registro as id_producto_aso,
					       a.co_empresa,
					       a.co_producto,
					       a.nb_producto,
					       a.nb_corto,
					       a.total_kg,
					       '$par_fecha' as fe_inventario,
					       NVL(b.ca_producto,0) as ca_existencia,
					       NVL(c.ca_prd_aprobado,0) ca_planificada,   
					       NVL(b.ca_producto,0) - NVL(c.ca_prd_aprobado,0) as ca_saldo     
					FROM web_productos_aso a
					LEFT JOIN web_productos_inventario_aso b ON b.id_producto_aso = a.id_registro AND b.fe_registro = to_date('$par_fecha','yyyy-mm-dd')
					LEFT JOIN (SELECT xc.fe_emision,
					                  xc.prd_id_producto_aso,
					                  SUM(xc.ca_prd_solicitado) AS ca_prd_solicitado,
					                  SUM(xc.ca_prd_aprobado) AS ca_prd_aprobado
					           FROM web_plan_pedido_aso xc
					           WHERE xc.ctv_co_estado_documento IN ('EM')
					           GROUP BY xc.fe_emision,
					                    xc.prd_id_producto_aso) c ON c.prd_id_producto_aso = a.id_registro AND c.fe_emision = to_date('$par_fecha','yyyy-mm-dd')";

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
				do
				{
					$lista [$contador]["id_producto_aso"] = $row[$ejecutar->col_db("id_producto_aso")];
					$lista [$contador]["co_empresa"]      = $row[$ejecutar->col_db("co_empresa")];
					$lista [$contador]["co_producto"]     = $row[$ejecutar->col_db("co_producto")];
					$lista [$contador]["nb_producto"]     = $row[$ejecutar->col_db("nb_producto")];
					$lista [$contador]["nb_corto"]        = $row[$ejecutar->col_db("nb_corto")];
					$lista [$contador]["total_kg"]        = $row[$ejecutar->col_db("total_kg")];
					$lista [$contador]["fe_inventario"]   = $row[$ejecutar->col_db("fe_inventario")];
					$lista [$contador]["ca_existencia"]   = $row[$ejecutar->col_db("ca_existencia")];
					$lista [$contador]["ca_planificada"]  = $row[$ejecutar->col_db("ca_planificada")];
					$lista [$contador]["ca_saldo"]        = $row[$ejecutar->col_db("ca_saldo")];
										
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

	public function sincronizar_transporte( $id_ped_web, $id_doc_emp, $nu_pedido, $sincronizar, $ti_doc )
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();

		$conexion = $ejecutar->conectar();
        if (!$conexion) 
        {
            return;
        }

		$ejecutar->autocommit($conexion, false); 

		try 
		{			
			$query_1 = 'BEGIN P_WEB_ACTUALIZAR_TRANSPORTE(:P_ID_DOC_EMP, :P_ID_PED_WEB, :P_NU_PED_ASO, :P_SINCRONIZAR, :P_TI_DOC_EMP); END;';
			$stmt = oci_parse($conexion, $query_1);

			oci_bind_by_name($stmt, ':P_ID_DOC_EMP', $id_doc_emp);
			oci_bind_by_name($stmt, ':P_ID_PED_WEB', $id_ped_web);
			oci_bind_by_name($stmt, ':P_NU_PED_ASO', $nu_pedido);
			oci_bind_by_name($stmt, ':P_SINCRONIZAR', $sincronizar);
			oci_bind_by_name($stmt, ':P_TI_DOC_EMP', $ti_doc);

			$resExec = oci_execute($stmt);

			if(!$resExec)
			{
				$e = oci_error($stmt);
				$ejecutar->rollback($conexion); 		
				$ejecutar->desconectar($conexion);	

				session()->set('error', $e['message'] ?? 'Error desconocido en PL/SQL');
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

			$msn = "CODE: 9001<br />";
			$msn = $msn . "MESSAGE: Error Fatal -> 9001 sincronizar_transporte: " . $e->getMessage() . " <br />";

			session()->set('error', $msn);
		}
	}
}