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

class VisitaModel extends Model
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
	public function consultar_visita_pedido( $par_idvisita,
			                                 $par_cozona,
			                                 $par_coorganizacion,
			                                 $par_nborganizacion,
			                                 $par_estadodocumento,
			                                 $par_coproducto,
			                                 $par_nbproducto )
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();

		$query_1 = "SELECT  a.pec_id_visitas_aso,
							a.tipo,
							a.fe_emision,
							a.co_zona,
							a.co_organizacion,
							a.nb_organizacion,
							a.tx_observacion,
							a.id_vendedor,
						    a.ctv_id_estado_documento,
						    a.ctv_de_estado_documento,
							a.usuario,
							a.nb_vendedor,
							a.visita,
						    a.cobranza,
						    a.inventario,
					        a.pedido,
							a.prd_id_producto_aso,
					        a.nu_lote,
					        a.fe_vencimiento_lote,
							a.ca_buena_condicion,
							a.ca_mala_condicion_propio,
							a.ca_mala_condicion_tercero,
							a.ca_solicitada,
							a.co_producto,
							a.nb_producto,
							a.monto_cobrado_adesa,
							a.monto_cobrado_aai
					FROM web_visita_pedido_aso a
					WHERE TRIM(CAST(a.pec_id_visitas_aso AS CHAR(9))) LIKE '$par_idvisita'
					  AND a.co_zona LIKE '$par_cozona'
					  AND a.co_organizacion LIKE '$par_coorganizacion'
					  AND a.nb_organizacion LIKE '$par_nborganizacion'
					  AND a.ctv_de_estado_documento LIKE '$par_estadodocumento'
					  AND nvl(a.co_producto,' ') LIKE '$par_coproducto'
					  AND nvl(a.nb_producto,' ') LIKE '$par_nbproducto'
					ORDER BY a.pec_id_visitas_aso ASC";

		$conexion = $ejecutar->conectar();
        if (!$conexion) 
        {
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
					$lista [$contador]["pec_id_visitas_aso"]        = $row[$ejecutar->col_db("pec_id_visitas_aso")];
					$lista [$contador]["tipo"]                      = $row[$ejecutar->col_db("tipo")];
					$lista [$contador]["fe_emision"]                = $row[$ejecutar->col_db("fe_emision")];
					$lista [$contador]["co_zona"]                   = $row[$ejecutar->col_db("co_zona")];
					$lista [$contador]["co_organizacion"]           = $row[$ejecutar->col_db("co_organizacion")];
					$lista [$contador]["nb_organizacion"]           = $row[$ejecutar->col_db("nb_organizacion")];
					$lista [$contador]["tx_observacion"]            = $row[$ejecutar->col_db("tx_observacion")];

					$lista [$contador]["id_vendedor"]               = $row[$ejecutar->col_db("id_vendedor")];
					$lista [$contador]["usuario"]                   = $row[$ejecutar->col_db("usuario")];
					$lista [$contador]["nb_vendedor"]               = strtoupper($row[$ejecutar->col_db("nb_vendedor")]);

					$lista [$contador]["ctv_id_estado_documento"]   = $row[$ejecutar->col_db("ctv_id_estado_documento")];
					$lista [$contador]["ctv_de_estado_documento"]   = $row[$ejecutar->col_db("ctv_de_estado_documento")];

					$lista [$contador]["visita"]                    = $row[$ejecutar->col_db("visita")];
					$lista [$contador]["cobranza"]                  = $row[$ejecutar->col_db("cobranza")];
					$lista [$contador]["inventario"]                = $row[$ejecutar->col_db("inventario")];
					$lista [$contador]["pedido"]                    = $row[$ejecutar->col_db("pedido")];

					$lista [$contador]["prd_id_producto_aso"]       = $row[$ejecutar->col_db("prd_id_producto_aso")];
					$lista [$contador]["ca_buena_condicion"]        = $row[$ejecutar->col_db("ca_buena_condicion")];
					$lista [$contador]["ca_mala_condicion_propio"]  = $row[$ejecutar->col_db("ca_mala_condicion_propio")];
					$lista [$contador]["ca_mala_condicion_tercero"] = $row[$ejecutar->col_db("ca_mala_condicion_tercero")];
					$lista [$contador]["ca_solicitada"]             = $row[$ejecutar->col_db("ca_solicitada")];
					$lista [$contador]["nu_lote"]                   = $row[$ejecutar->col_db("nu_lote")];
					$lista [$contador]["fe_vencimiento_lote"]       = $row[$ejecutar->col_db("fe_vencimiento_lote")];
					$lista [$contador]["co_producto"]               = $row[$ejecutar->col_db("co_producto")];
					$lista [$contador]["nb_producto"]               = $row[$ejecutar->col_db("nb_producto")];

					$lista [$contador]["monto_cobrado_adesa"]       = $row[$ejecutar->col_db("monto_cobrado_adesa")];
					$lista [$contador]["monto_cobrado_aai"]         = $row[$ejecutar->col_db("monto_cobrado_aai")];

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
	public function consultar_visita($par_idvisita,
	                                 $par_cozona,
	                                 $par_coorganizacion,
	                                 $par_nborganizacion,
	                                 $par_estadodocumento,
	                                 $par_coproducto,
	                                 $par_nbproducto)
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();

		$query_1 = "SELECT   a.id_registro as pec_id_visitas_aso,
		                     a.tipo,
							 a.fe_emision,
				       		 a.co_zona,
							 a.co_organizacion,
							 a.nb_organizacion,
							 a.tx_observacion,
							 a.id_vendedor,
							 a.ctv_id_estado_documento,
				       		 g.de_ocurrencia as ctv_de_estado_documento,
							 f.usuario,
							 f.nombre as nb_vendedor,
							 d.prd_id_producto_aso,
							 d.nu_lote,
							 d.fe_vencimiento_lote,
							 d.ca_buena_condicion,
							 d.ca_mala_condicion_propio,
							 d.ca_mala_condicion_tercero,
							 d.ca_solicitada,
							 e.co_producto,
							 e.nb_producto
					FROM web_visitas_aso a
					INNER JOIN web_clientes_aso c ON c.co_organizacion = a.co_organizacion
					LEFT JOIN web_visitas_productos_aso d ON d.id_visita_vendedor = a.id_registro
					LEFT JOIN web_productos_aso e ON e.id_registro = d.prd_id_producto_aso
					INNER JOIN web_usuarios_aso f ON f.id_registro = a.id_vendedor
					INNER JOIN t00_contenido_tabla_virtual g ON g.id_registro = a.ctv_id_estado_documento
					WHERE TRIM(CAST(a.id_registro AS CHAR(9))) LIKE '$par_idvisita'
					  AND a.co_zona LIKE '$par_cozona'
					  AND a.co_organizacion LIKE '$par_coorganizacion'
					  AND a.nb_organizacion LIKE '$par_nborganizacion'
					  AND g.de_ocurrencia LIKE '$par_estadodocumento'
					  AND nvl(e.co_producto,' ') LIKE '$par_coproducto'
					  AND nvl(e.nb_producto,' ') LIKE '$par_nbproducto'
					ORDER BY a.id_registro ASC";

		$conexion = $ejecutar->conectar();
        if (!$conexion) 
        {
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
					$lista [$contador]["pec_id_visitas_aso"]        = $row[$ejecutar->col_db("pec_id_visitas_aso")];
					$lista [$contador]["tipo"]                      = $row[$ejecutar->col_db("tipo")];
					$lista [$contador]["fe_emision"]                = $row[$ejecutar->col_db("fe_emision")];
					$lista [$contador]["co_zona"]                   = $row[$ejecutar->col_db("co_zona")];
					$lista [$contador]["co_organizacion"]           = $row[$ejecutar->col_db("co_organizacion")];
					$lista [$contador]["nb_organizacion"]           = $row[$ejecutar->col_db("nb_organizacion")];
					$lista [$contador]["tx_observacion"]            = $row[$ejecutar->col_db("tx_observacion")];

					$lista [$contador]["id_vendedor"]               = $row[$ejecutar->col_db("id_vendedor")];
					$lista [$contador]["usuario"]                   = $row[$ejecutar->col_db("usuario")];
					$lista [$contador]["nb_vendedor"]               = strtoupper($row[$ejecutar->col_db("nb_vendedor")]);

					$lista [$contador]["ctv_id_estado_documento"]   = $row[$ejecutar->col_db("ctv_id_estado_documento")];
					$lista [$contador]["ctv_de_estado_documento"]   = $row[$ejecutar->col_db("ctv_de_estado_documento")];

					$lista [$contador]["prd_id_producto_aso"]       = $row[$ejecutar->col_db("prd_id_producto_aso")];
					$lista [$contador]["ca_buena_condicion"]        = $row[$ejecutar->col_db("ca_buena_condicion")];
					$lista [$contador]["ca_mala_condicion_propio"]  = $row[$ejecutar->col_db("ca_mala_condicion_propio")];
					$lista [$contador]["ca_mala_condicion_tercero"] = $row[$ejecutar->col_db("ca_mala_condicion_tercero")];
					$lista [$contador]["ca_solicitada"]             = $row[$ejecutar->col_db("ca_solicitada")];
					$lista [$contador]["nu_lote"]                   = $row[$ejecutar->col_db("nu_lote")];
					$lista [$contador]["fe_vencimiento_lote"]       = $row[$ejecutar->col_db("fe_vencimiento_lote")];
					$lista [$contador]["co_producto"]               = $row[$ejecutar->col_db("co_producto")];
					$lista [$contador]["nb_producto"]               = $row[$ejecutar->col_db("nb_producto")];

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
    public function guardar_visita( $fecha,
                                    $cmbcliente,
                                    $cmbvisita,
                                    $txtobs,
                                    $idvendedor,
                                    $var_inventario,
                                    $coemp,
                                    $idprd,
                                    $coprd,
                                    $lote_nu_prd,
                                    $lote_fe_prd,
                                    $ca_prd_b_e,
                                    $ca_prd_m_e,
                                    $ca_prd_m_e_t,
                                    $totalprd,
                                    $operacion,
                                    $var_competencias,
                                    $comp_prd_marca,
                                    $comp_prd_pres,
                                    $comp_prd_precio,
                                    $comp_prd_precio_v )
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
			if ($operacion == '1')
			{
				$cozona = "";
				$nbcliente = "";

				$query_1 = "SELECT  a.co_organizacion,
									a.nb_organizacion,
									a.co_zona,
									a.adesa,
									a.aai
							FROM web_clientes_aso a
							WHERE TRIM(NVL(a.co_organizacion,'')) LIKE '$cmbcliente'
							ORDER BY a.nb_organizacion ASC";

				$respuesta = $ejecutar->ejecutar($query_1, $conexion, false);

				if (isset($respuesta["error"]) && $respuesta["error"] == "")
				{
					$result = $respuesta["resultado"];

					if ($row = $ejecutar->proximo($result))
					{
						do
						{
							$cozona    = $row[$ejecutar->col_db("co_zona")];
							$nbcliente = $row[$ejecutar->col_db("nb_organizacion")];
						}
						while ($row = $ejecutar->proximo($result));
					}
				}
				else
				{
					$ejecutar->rollback($conexion);
				    $ejecutar->desconectar($conexion);

				    $msn = "CODE: 1.1<br />";
					$msn = $msn . "MESSAGE: guardar_visita -> 1.1 ERROR NO SE PUDO UBICAR LOS DATOS DEL CLIENTE <br />";

				    session()->set('error', $msn);
				    return;
				}

				$idvisitaweb = "";

				$query_2 = "SELECT F00_ID_REGISTRO AS idvisitaweb
				            FROM DUAL";

				$respuesta = $ejecutar->ejecutar($query_2, $conexion, false);

				if (isset($respuesta["error"]) && $respuesta["error"] == "")
				{
					$result = $respuesta["resultado"];

					if ($row = $ejecutar->proximo($result))
					{
						do
						{
							$idvisitaweb = $row[$ejecutar->col_db("idvisitaweb")];
						}
						while ($row = $ejecutar->proximo($result));
					}
				}
				else
				{
					$ejecutar->rollback($conexion);
				    $ejecutar->desconectar($conexion);

				    $msn = "CODE: 1.2<br />";
					$msn = $msn . "MESSAGE: guardar_visita -> 1.2 ERROR NO SE PUDO OBTENER EL ID PARA LA VISITA F00_ID_REGISTRO <br />";

				    session()->set('error', $msn);
				    return;
				}

				$query_3 = "INSERT INTO web_visitas_aso ( id_registro,
				                                          fe_emision,
														  co_organizacion,
														  nb_organizacion,
														  id_vendedor,
														  co_zona,
														  ctv_id_estado_documento,
														  tx_observacion,
														  tipo )
						    VALUES ($idvisitaweb,
						            TO_DATE('$fecha','YYYY-MM-DD HH24:MI:SS'),
						    	    '$cmbcliente',
						    	    '$nbcliente',
						    	     $idvendedor,
						    	    '$cozona',
						    	     6322658,
						    	    '$txtobs',
						    	    '$cmbvisita')";

				$respuesta = $ejecutar->ejecutar($query_3, $conexion, false);

				if (!empty($respuesta["error"]))
				{
					$ejecutar->rollback($conexion);
				    $ejecutar->desconectar($conexion);

				    $msn = "CODE: 1.3<br />";
					$msn = $msn . "MESSAGE: guardar_visita -> 1.3 ERROR AL INSERTAR DATOS EN TABLA web_visitas_aso <br />";

				    session()->set('error', $msn);
				    return;
				}

				$query_4 = "INSERT INTO web_visitas_acciones_aso ( id_registro,
				                                                   id_visita_vendedor,
														  		   co_accion )
						    SELECT F00_ID_REGISTRO,
						           $idvisitaweb,
						           'VISITA'
				            FROM   DUAL";

				$respuesta = $ejecutar->ejecutar($query_4, $conexion, false);

				if (!empty($respuesta["error"]))
				{
					$ejecutar->rollback($conexion);
				    $ejecutar->desconectar($conexion);

				    $msn = "CODE: 1.4<br />";
					$msn = $msn . "MESSAGE: guardar_visita -> 1.4 ERROR AL INSERTAR DATOS EN TABLA web_visitas_acciones_aso accion VISITA <br />";

				    session()->set('error', $msn);
				    return;
				}

				for ($x = 0; $x < $totalprd; $x++) 
				{
					if (!empty($ca_prd_b_e) || !empty($ca_prd_m_e) || !empty($ca_prd_m_e_t)) 
					{
						if (($ca_prd_b_e[$x] > 0) || ($ca_prd_m_e[$x] > 0) || ($ca_prd_m_e_t[$x] > 0))
						{
							$idvisitaproductoweb = "";
		            		
							$query_6 = "SELECT F00_ID_REGISTRO AS idvisitaproductoweb
							            FROM DUAL";

							$respuesta = $ejecutar->ejecutar($query_6, $conexion, false);

							if (isset($respuesta["error"]) && $respuesta["error"] == "")
							{
								$result = $respuesta["resultado"];

								if ($row = $ejecutar->proximo($result))
								{
									do
									{
										$idvisitaproductoweb = $row[$ejecutar->col_db("idvisitaproductoweb")];
									}
									while ($row = $ejecutar->proximo($result));
								}
							}
							else
							{
								$ejecutar->rollback($conexion);
							    $ejecutar->desconectar($conexion);

							    $msn = "CODE: 1.6<br />";
							    $msn = $msn . "MESSAGE: guardar_visita -> 1.6 ERROR NO SE PUDO OBTENER EL ID PARA EL DETALLE DE LA VISITA F00_ID_REGISTRO <br />";

							    session()->set('error', $msn);
							    return;
							}

							$fecha_lote = "''";
							if (!empty($lote_fe_prd[$x]))
							{
								$fecha_lote = "TO_DATE('" . $lote_fe_prd[$x] . "','YYYY-MM-DD')";
							}

							$lote_val = "''";
							if (!empty($lote_nu_prd[$x]))
							{
								$lote_val = "'" . $lote_nu_prd[$x] . "'";
							}

							$query_7 = "INSERT INTO web_visitas_productos_aso ( id_registro,
																		   	    id_visita_vendedor,
																			    prd_id_producto_aso,
																			    ca_buena_condicion,
																			    ca_mala_condicion_propio,
																			    ca_mala_condicion_tercero,
																			    fe_vencimiento_lote,
																			    nu_lote )
									    VALUES ($idvisitaproductoweb,
									            $idvisitaweb,
									    	    {$idprd[$x]},
									    	    {$ca_prd_b_e[$x]},
									    	    {$ca_prd_m_e[$x]},
									    	    {$ca_prd_m_e_t[$x]},
									    	    $fecha_lote,
									    	    UPPER($lote_val))";

							$respuesta = $ejecutar->ejecutar($query_7, $conexion, false);

							if (!empty($respuesta["error"]))
							{
								$ejecutar->rollback($conexion);
							    $ejecutar->desconectar($conexion);

							    $msn = "CODE: 1.7<br />";
								$msn = $msn . "MESSAGE: guardar_visita -> 1.7 ERROR AL INSERTAR DATOS DETALLE EN TABLA web_visitas_productos_aso <br />";

							    session()->set('error', $msn);
							    return;
							}
						}
					}
		        }

				if (is_array($comp_prd_marca))
				{
					for ($x = 0; $x < count($comp_prd_marca); $x++)
					{
          			if (!empty($comp_prd_marca) || !empty($comp_prd_precio))
          			{
            			if (($comp_prd_marca[$x] != '') || ($comp_prd_precio[$x] > 0))
            			{
							$idvisitaproductoweb = "";
		            		
							$query_6 = "SELECT F00_ID_REGISTRO AS idvisitaproductoweb
							            FROM DUAL";

							$respuesta = $ejecutar->ejecutar($query_6, $conexion, false);

              				if (isset($respuesta["error"]) && $respuesta["error"] == "")
							{
								$result = $respuesta["resultado"];

								if ($row = $ejecutar->proximo($result))
								{
									do
									{
										$idvisitaproductoweb = $row[$ejecutar->col_db("idvisitaproductoweb")];
									}
									while ($row = $ejecutar->proximo($result));
								}
							}
							else
							{
								$ejecutar->rollback($conexion);
							    $ejecutar->desconectar($conexion);

							    $msn = "CODE: 1.9<br />";
							    $msn = $msn . "MESSAGE: guardar_visita -> 1.9 ERROR NO SE PUDO OBTENER EL ID PARA EL DETALLE DE LA VISITA F00_ID_REGISTRO <br />";

							    session()->set('error', $msn);
							    return;
							}

							$query_7 = "INSERT INTO web_visitas_competencias_aso ( id_registro,
																		   	  	   id_visita_vendedor,
																			       comp_prd_marca,
										                                           comp_prd_pres,
										                                           comp_prd_precio,
										                                           comp_prd_precio_v )
									    VALUES ($idvisitaproductoweb,
									            $idvisitaweb,
									    	   '{$comp_prd_marca[$x]}',
					                           '{$comp_prd_pres[$x]}',
					                            {$comp_prd_precio[$x]},
					                            {$comp_prd_precio_v[$x]})";

							$respuesta = $ejecutar->ejecutar($query_7, $conexion, false);

							if (!empty($respuesta["error"]))
							{
								$ejecutar->rollback($conexion);
							    $ejecutar->desconectar($conexion);

							    $msn = "CODE: 1.10<br />";
								$msn = $msn . "MESSAGE: guardar_visita -> 1.10 ERROR AL INSERTAR DATOS DETALLE EN TABLA web_visitas_competencias_aso <br />";

							    session()->set('error', $msn);
							    return;
							}
			            }
			        }
			    }
				}

				if ($var_inventario == 1)
				{
					$query_8 = "INSERT INTO web_visitas_acciones_aso ( id_registro,
					                                                   id_visita_vendedor,
															  		   co_accion )
							    SELECT F00_ID_REGISTRO,
							           $idvisitaweb,
							           'INVENTARIO'
					            FROM   DUAL";

					$respuesta = $ejecutar->ejecutar($query_8, $conexion, false);

					if (!empty($respuesta["error"]))
					{
						$ejecutar->rollback($conexion);
					    $ejecutar->desconectar($conexion);

					    $msn = "CODE: 1.8<br />";
						$msn = $msn . "MESSAGE: guardar_visita -> 1.8 ERROR AL INSERTAR DATOS EN TABLA web_visitas_acciones_aso accion INVENTARIO <br />";

					    session()->set('error', $msn);
					    return;
					}
				}

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
			$msn = $msn . "MESSAGE: Error Fatal -> 9001 guardar_pedido: " . $e->getMessage() . " <br />";

			session()->set('error', $msn);
		}
	}

	//=============================================================================================================
    //
    //=============================================================================================================
	public function anular_visita( $id_vis_web )
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
			$query_1 = "UPDATE web_visitas_aso
						SET    ctv_id_estado_documento = 6322662
						WHERE  id_registro = $id_vis_web";

			$respuesta = $ejecutar->ejecutar($query_1, $conexion, false);

			if (!empty($respuesta["error"]))
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
			$msn = $msn . "MESSAGE: Error Fatal -> 9001 anular_visita: " . $e->getMessage() . " <br />";

			session()->set('error', $msn);
		}
	}

	//=============================================================================================================
    //
    //=============================================================================================================
	public function consultar_visita_pedido_fecha( $par_fecha_desde,
	                                 			   $par_fecha_hasta,
	                                 			   $par_idusuario,
			                                 	   $par_vendedor,
			                                 	   $par_coorganizacion )
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();

		$query_1 = "SELECT  a.pec_id_visitas_aso,
		                    a.tipo,
							a.fe_emision,
							a.co_zona,
							a.co_organizacion,
							a.nb_organizacion,
							a.tx_observacion,
							a.id_vendedor,
						    a.ctv_id_estado_documento,
						    a.ctv_de_estado_documento,
							a.usuario,
							a.nb_vendedor,
							a.visita,
						    a.cobranza,
						    a.inventario,
					        a.pedido,
							a.prd_id_producto_aso,
					        a.nu_lote,
					        a.fe_vencimiento_lote,
							a.ca_buena_condicion,
							a.ca_mala_condicion_propio,
							a.ca_mala_condicion_tercero,
							a.ca_solicitada,
							a.co_producto,
							a.nb_producto,
							a.monto_cobrado_adesa,
							a.monto_cobrado_aai
					FROM web_visita_pedido_aso a
					WHERE a.fe_emision >= to_date('$par_fecha_desde','yyyy-mm-dd')
					  AND a.fe_emision <= to_date('$par_fecha_hasta','yyyy-mm-dd')
					  AND a.co_zona IN (SELECT aa.co_zona
					                    FROM web_usuarios_zonas_aso aa
					                    WHERE aa.id_usuario = '$par_idusuario')
					  AND TRIM(CAST(a.id_vendedor AS CHAR(15))) LIKE '$par_vendedor'
					  AND a.co_organizacion LIKE '$par_coorganizacion'
					ORDER BY a.pec_id_visitas_aso DESC";

		$conexion = $ejecutar->conectar();
        if (!$conexion) 
        {
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
					$lista [$contador]["pec_id_visitas_aso"]        = $row[$ejecutar->col_db("pec_id_visitas_aso")];
					$lista [$contador]["tipo"]                      = $row[$ejecutar->col_db("tipo")];
					$lista [$contador]["fe_emision"]                = $row[$ejecutar->col_db("fe_emision")];
					$lista [$contador]["co_zona"]                   = $row[$ejecutar->col_db("co_zona")];
					$lista [$contador]["co_organizacion"]           = $row[$ejecutar->col_db("co_organizacion")];
					$lista [$contador]["nb_organizacion"]           = $row[$ejecutar->col_db("nb_organizacion")];
					$lista [$contador]["tx_observacion"]            = $row[$ejecutar->col_db("tx_observacion")];

					$lista [$contador]["id_vendedor"]               = $row[$ejecutar->col_db("id_vendedor")];
					$lista [$contador]["usuario"]                   = $row[$ejecutar->col_db("usuario")];
					$lista [$contador]["nb_vendedor"]               = strtoupper($row[$ejecutar->col_db("nb_vendedor")]);

					$lista [$contador]["ctv_id_estado_documento"]   = $row[$ejecutar->col_db("ctv_id_estado_documento")];
					$lista [$contador]["ctv_de_estado_documento"]   = $row[$ejecutar->col_db("ctv_de_estado_documento")];

					$lista [$contador]["visita"]                    = $row[$ejecutar->col_db("visita")];
					$lista [$contador]["cobranza"]                  = $row[$ejecutar->col_db("cobranza")];
					$lista [$contador]["inventario"]                = $row[$ejecutar->col_db("inventario")];
					$lista [$contador]["pedido"]                    = $row[$ejecutar->col_db("pedido")];

					$lista [$contador]["prd_id_producto_aso"]       = $row[$ejecutar->col_db("prd_id_producto_aso")];
					$lista [$contador]["ca_buena_condicion"]        = $row[$ejecutar->col_db("ca_buena_condicion")];
					$lista [$contador]["ca_mala_condicion_propio"]  = $row[$ejecutar->col_db("ca_mala_condicion_propio")];
					$lista [$contador]["ca_mala_condicion_tercero"] = $row[$ejecutar->col_db("ca_mala_condicion_tercero")];
					$lista [$contador]["ca_solicitada"]             = $row[$ejecutar->col_db("ca_solicitada")];
					$lista [$contador]["nu_lote"]                   = $row[$ejecutar->col_db("nu_lote")];
					$lista [$contador]["fe_vencimiento_lote"]       = $row[$ejecutar->col_db("fe_vencimiento_lote")];
					$lista [$contador]["co_producto"]               = $row[$ejecutar->col_db("co_producto")];
					$lista [$contador]["nb_producto"]               = $row[$ejecutar->col_db("nb_producto")];

					$lista [$contador]["monto_cobrado_adesa"]       = $row[$ejecutar->col_db("monto_cobrado_adesa")];
					$lista [$contador]["monto_cobrado_aai"]         = $row[$ejecutar->col_db("monto_cobrado_aai")];

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
	public function consultar_ultima_visita_fecha( $par_fecha_desde,
	                                 			   $par_fecha_hasta,
	                                 			   $par_idusuario,
			                                 	   $par_vendedor,
			                                 	   $par_coorganizacion )
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();

		$query_1 = "SELECT xb.pec_id_visitas_aso,
						   xb.tipo,
				           xb.fe_emision,
				           xb.co_zona,
				           xb.co_organizacion,
				           xb.nb_organizacion,
				           xb.tx_observacion,

				           xb.id_vendedor,
				           xc.usuario,
				           xc.nombre as nb_vendedor,

				           xb.ctv_id_estado_documento,
				           xb.ctv_de_estado_documento,

				           xb.co_producto,
				           xb.nb_producto,
				           xb.ca_buena_condicion

				    FROM (SELECT max(a.id_registro) as id_visitas_aso,
				                 a.co_organizacion,
				                 b.co_accion as inventario
				          FROM web_visitas_aso a
				          INNER JOIN t00_contenido_tabla_virtual c ON c.id_registro = a.ctv_id_estado_documento
				          LEFT JOIN web_visitas_acciones_aso b ON b.id_visita_vendedor = a.id_registro AND b.co_accion = 'INVENTARIO'
				          WHERE b.co_accion is not null
				            AND a.fe_emision >= to_date('$par_fecha_desde','yyyy-mm-dd')
					        AND a.fe_emision <= to_date('$par_fecha_hasta','yyyy-mm-dd')
				            AND c.de_ocurrencia NOT IN ('ANULADO')
				          GROUP BY a.co_organizacion, b.co_accion) xa
				    INNER JOIN web_visita_pedido_aso xb ON xb.pec_id_visitas_aso = xa.id_visitas_aso
				    INNER JOIN web_usuarios_aso xc ON xc.id_registro = xb.id_vendedor
					WHERE xb.fe_emision >= to_date('$par_fecha_desde','yyyy-mm-dd')
					  AND xb.fe_emision <= to_date('$par_fecha_hasta','yyyy-mm-dd')
					  AND xb.co_zona IN (SELECT aa.co_zona
					                     FROM web_usuarios_zonas_aso aa
					                     WHERE aa.id_usuario = '$par_idusuario')
					  AND TRIM(CAST(xb.id_vendedor AS CHAR(15))) LIKE '$par_vendedor'
					  AND xb.co_organizacion LIKE '$par_coorganizacion'
					ORDER BY xb.pec_id_visitas_aso DESC";

		$conexion = $ejecutar->conectar();
        if (!$conexion) 
        {
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
					$lista [$contador]["pec_id_visitas_aso"]        = $row[$ejecutar->col_db("pec_id_visitas_aso")];
					$lista [$contador]["tipo"]                      = $row[$ejecutar->col_db("tipo")];
					$lista [$contador]["fe_emision"]                = $row[$ejecutar->col_db("fe_emision")];
					$lista [$contador]["co_zona"]                   = $row[$ejecutar->col_db("co_zona")];
					$lista [$contador]["co_organizacion"]           = $row[$ejecutar->col_db("co_organizacion")];
					$lista [$contador]["nb_organizacion"]           = $row[$ejecutar->col_db("nb_organizacion")];
					$lista [$contador]["tx_observacion"]            = $row[$ejecutar->col_db("tx_observacion")];

					$lista [$contador]["id_vendedor"]               = $row[$ejecutar->col_db("id_vendedor")];
					$lista [$contador]["usuario"]                   = $row[$ejecutar->col_db("usuario")];
					$lista [$contador]["nb_vendedor"]               = strtoupper($row[$ejecutar->col_db("nb_vendedor")]);

					$lista [$contador]["ctv_id_estado_documento"]   = $row[$ejecutar->col_db("ctv_id_estado_documento")];
					$lista [$contador]["ctv_de_estado_documento"]   = $row[$ejecutar->col_db("ctv_de_estado_documento")];

					$lista [$contador]["co_producto"]               = $row[$ejecutar->col_db("co_producto")];
					$lista [$contador]["nb_producto"]               = $row[$ejecutar->col_db("nb_producto")];

					$lista [$contador]["ca_buena_condicion"]        = $row[$ejecutar->col_db("ca_buena_condicion")];

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
	public function consultar_visita_competencias($par_idvisita)
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();

		$query_1 = "SELECT a.id_registro as id_visita_competencia,
                      a.id_visita_vendedor,
                      UPPER(a.comp_prd_marca) AS comp_prd_marca,
                      UPPER(a.comp_prd_pres) AS comp_prd_pres,
                      a.comp_prd_precio,
                      a.comp_prd_precio_v
                 FROM web_visitas_competencias_aso a
								WHERE TRIM(CAST(a.id_visita_vendedor AS CHAR(9))) LIKE '$par_idvisita'";

		$conexion = $ejecutar->conectar();
        if (!$conexion) 
        {
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
					$lista [$contador]["id_visita_competencia"] = $row[$ejecutar->col_db("id_visita_competencia")];
					$lista [$contador]["id_visita_vendedor"] = $row[$ejecutar->col_db("id_visita_vendedor")];
					$lista [$contador]["comp_prd_marca"] = $row[$ejecutar->col_db("comp_prd_marca")];
                    $lista [$contador]["comp_prd_pres"] = $row[$ejecutar->col_db("comp_prd_pres")];
                    $lista [$contador]["comp_prd_precio"] = $row[$ejecutar->col_db("comp_prd_precio")];
                    $lista [$contador]["comp_prd_precio_v"] = $row[$ejecutar->col_db("comp_prd_precio_v")];

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
	public function consultar_visita_producto_terceros_fecha(  $par_fecha_desde,
				                                 			   $par_fecha_hasta,
				                                 			   $par_idusuario,
						                                 	   $par_vendedor,
						                                 	   $par_coorganizacion )
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();

		$query_1 = "SELECT a.id_registro,
						   a.fe_emision,
						   a.id_vendedor,
						   fff.nombre as nb_vendedor,
						   a.co_organizacion,
						   a.nb_organizacion,
						   a.co_zona,
						   UPPER(b.comp_prd_marca) AS comp_prd_marca,
						   UPPER(b.comp_prd_pres) AS comp_prd_pres,
						   b.comp_prd_precio,
						   b.comp_prd_precio_v,
						   ggg.de_ocurrencia AS ctv_de_estado_documento
				    FROM web_visitas_aso a
				    JOIN web_visitas_competencias_aso b ON a.id_registro = b.id_visita_vendedor
				    JOIN t00_contenido_tabla_virtual ggg ON ggg.id_registro = a.ctv_id_estado_documento
				    INNER JOIN web_usuarios_aso fff ON fff.id_registro = a.id_vendedor
				    WHERE 1 = 1
				      AND a.fe_emision >= to_date('$par_fecha_desde','yyyy-mm-dd')
				      AND a.fe_emision <= to_date('$par_fecha_hasta','yyyy-mm-dd')
				      AND a.co_zona IN (SELECT aa.co_zona
				        				  FROM web_usuarios_zonas_aso aa
				        				  WHERE aa.id_usuario = '$par_idusuario')
				      AND TRIM(CAST(a.id_vendedor AS CHAR(15))) LIKE '$par_vendedor'
				      AND a.co_organizacion LIKE '$par_coorganizacion'
				    ORDER BY a.id_registro DESC";

		$conexion = $ejecutar->conectar();
        if (!$conexion) 
        {
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
					$lista [$contador]["pec_id_visitas_aso"]        = $row[$ejecutar->col_db("id_registro")];
					$lista [$contador]["fe_emision"]                = $row[$ejecutar->col_db("fe_emision")];
					$lista [$contador]["co_zona"]                   = $row[$ejecutar->col_db("co_zona")];
					$lista [$contador]["co_organizacion"]           = $row[$ejecutar->col_db("co_organizacion")];
					$lista [$contador]["nb_organizacion"]           = $row[$ejecutar->col_db("nb_organizacion")];

					$lista [$contador]["id_vendedor"]               = $row[$ejecutar->col_db("id_vendedor")];
					$lista [$contador]["nb_vendedor"]               = strtoupper($row[$ejecutar->col_db("nb_vendedor")]);

					$lista [$contador]["ctv_de_estado_documento"]   = $row[$ejecutar->col_db("ctv_de_estado_documento")];

					$lista [$contador]["comp_prd_marca"] = $row[$ejecutar->col_db("comp_prd_marca")];
					$lista [$contador]["comp_prd_pres"] = $row[$ejecutar->col_db("comp_prd_pres")];
					$lista [$contador]["comp_prd_precio"] = $row[$ejecutar->col_db("comp_prd_precio")];
					$lista [$contador]["comp_prd_precio_v"] = $row[$ejecutar->col_db("comp_prd_precio_v")];

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