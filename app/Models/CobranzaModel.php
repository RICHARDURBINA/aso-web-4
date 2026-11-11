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

class CobranzaModel extends Model
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
	public function consultar_cobranza($par_idcobranza,
		                                 $par_cozona,
		                                 $par_coorganizacion,
		                                 $par_nborganizacion,
		                                 $par_estadodocumento)
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();

		$query_1 = "SELECT  a.id_registro as cob_id_cobranza,
												a.fe_emision,
											  a.co_empresa,
				                a.co_zona,
											  a.co_organizacion,
											  a.nb_organizacion,
											  a.id_vendedor,
				                f.usuario as nb_vendedor,
											  a.co_zona,
											  a.ctv_id_estado_documento,
											  g.de_ocurrencia as ctv_de_estado_documento,
											  a.tx_observacion,
											  a.porc_desc_especial,
											  a.mont_desc_flete,
											  a.porc_desc_pago_divisa,
											  a.total_facturado,
											  a.mont_desc_especial,
											  a.mont_desc_pago_divisa,
											  a.mont_cobrado,
											  a.mont_subtotal,
											  a.mont_total,
											  a.mont_pendiente,
											  a.porc_desc_pronto_pago,
											  a.mont_desc_pronto_pago
								FROM web_cobranza_aso a
								INNER JOIN web_clientes_aso c ON c.co_organizacion = a.co_organizacion
								INNER JOIN web_usuarios_aso f ON f.id_registro = a.id_vendedor
								INNER JOIN t00_contenido_tabla_virtual g ON g.id_registro = a.ctv_id_estado_documento
								WHERE TRIM(CAST(a.id_registro AS CHAR(9))) LIKE '$par_idcobranza'
								  AND a.co_zona LIKE '$par_cozona'
								  AND a.co_organizacion LIKE '$par_coorganizacion'
								  AND a.nb_organizacion LIKE '$par_nborganizacion'
								  AND g.de_ocurrencia LIKE '$par_estadodocumento'
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
					$lista [$contador]["cob_id_cobranza"]           = $row[$ejecutar->col_db("cob_id_cobranza")];
					$lista [$contador]["fe_emision"]                = $row[$ejecutar->col_db("fe_emision")];
					$lista [$contador]["co_empresa"]                = $row[$ejecutar->col_db("co_empresa")];
					$lista [$contador]["co_zona"]                   = $row[$ejecutar->col_db("co_zona")];
					$lista [$contador]["co_organizacion"]           = $row[$ejecutar->col_db("co_organizacion")];
					$lista [$contador]["nb_organizacion"]           = $row[$ejecutar->col_db("nb_organizacion")];
					$lista [$contador]["tx_observacion"]            = $row[$ejecutar->col_db("tx_observacion")];

					$lista [$contador]["id_vendedor"]               = $row[$ejecutar->col_db("id_vendedor")];
					$lista [$contador]["nb_vendedor"]               = strtoupper($row[$ejecutar->col_db("nb_vendedor")]);
					$lista [$contador]["ctv_id_estado_documento"]   = $row[$ejecutar->col_db("ctv_id_estado_documento")];
					$lista [$contador]["ctv_de_estado_documento"]   = $row[$ejecutar->col_db("ctv_de_estado_documento")];

					$lista [$contador]["porc_desc_especial"]        = $row[$ejecutar->col_db("porc_desc_especial")];
					$lista [$contador]["mont_desc_flete"]           = $row[$ejecutar->col_db("mont_desc_flete")];
					$lista [$contador]["porc_desc_pago_divisa"]     = $row[$ejecutar->col_db("porc_desc_pago_divisa")];
					$lista [$contador]["total_facturado"]           = $row[$ejecutar->col_db("total_facturado")];

					$lista [$contador]["mont_desc_especial"]        = $row[$ejecutar->col_db("mont_desc_especial")];
					$lista [$contador]["mont_desc_pago_divisa"]     = $row[$ejecutar->col_db("mont_desc_pago_divisa")];
					$lista [$contador]["mont_cobrado"]              = $row[$ejecutar->col_db("mont_cobrado")];
					$lista [$contador]["mont_subtotal"]             = $row[$ejecutar->col_db("mont_subtotal")];
					$lista [$contador]["mont_total"]                = $row[$ejecutar->col_db("mont_total")];
					$lista [$contador]["mont_pendiente"]            = $row[$ejecutar->col_db("mont_pendiente")];

					$lista [$contador]["porc_desc_pronto_pago"]     = $row[$ejecutar->col_db("porc_desc_pronto_pago")];
					$lista [$contador]["mont_desc_pronto_pago"]     = $row[$ejecutar->col_db("mont_desc_pronto_pago")];

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
    public function guardar_cobranza( $fecha,
                                      $cmbempresa,
                                      $cmbcliente,
                                      $txtobs,
                                      $idvendedor,
                                      $arr_nu_fact,
                                      $arr_mo_fact,
                                      $arr_fe_cobr,
                                      $arr_co_banc,
                                      $arr_nu_refe,
                                      $arr_co_mone,
                                      $arr_mo_cobr,
                                      $arr_mo_tasa,
                                      $arr_mo_tota,
                                      $desc_esp_porc,
                                      $desc_flet_nc,
                                      $desc_divisa_porc,
                                      $tot_fact,
                                      $desc_esp_mont,
                                      $desc_flet_nc_mont,
                                      $desc_divisa_mont,
                                      $cobrado,
                                      $subtotal,
                                      $total,
                                      $pendiente,
                                      $operacion,
                                      $id_cobr_web,
                                      $desc_pronto_pago_proc,
                                      $desc_pronto_pago_mont,
                                      $arr_fe_emision_fact,
                                      $arr_fe_emision_cob,
                                      $arr_factura_nuevo,
                                      $arr_pago_nuevo,
                                      $arr_com_imagenes )
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
					$msn = $msn . "MESSAGE: guardar_cobranza -> 1.1 ERROR NO SE PUDO UBICAR LOS DATOS DEL CLIENTE <br />";

				  session()->set('error', $msn);
				  return;
				}

				$idcobranzaweb = "";

				$query_2 = "SELECT F00_ID_REGISTRO AS idcobranzaweb
				            FROM DUAL";

				$respuesta = $ejecutar->ejecutar($query_2, $conexion, false);

				if (isset($respuesta["error"]) && $respuesta["error"] == "")
				{
					$result = $respuesta["resultado"];

					if ($row = $ejecutar->proximo($result))
					{
						do
						{
							$idcobranzaweb = $row[$ejecutar->col_db("idcobranzaweb")];
						}
						while ($row = $ejecutar->proximo($result));
					}
				}
				else
				{
					$ejecutar->rollback($conexion);
				  $ejecutar->desconectar($conexion);

				  $msn = "CODE: 1.2<br />";
					$msn = $msn . "MESSAGE: guardar_cobranza -> 1.2 ERROR NO SE PUDO OBTENER EL ID PARA LA COBRANZA F00_ID_REGISTRO <br />";

				  session()->set('error', $msn);
				  return;
				}

				$query_3 = "INSERT INTO web_cobranza_aso (id_registro,
																								  fe_emision,
																								  co_empresa,
																								  co_organizacion,
																								  nb_organizacion,
																								  id_vendedor,
																								  co_zona,
																								  ctv_id_estado_documento,
																								  tx_observacion,
																								  porc_desc_especial,
																								  mont_desc_flete,
																								  porc_desc_pago_divisa,
																								  total_facturado,
																								  mont_desc_especial,
																								  mont_desc_pago_divisa,
																								  mont_cobrado,
																								  mont_subtotal,
																								  mont_total,
																								  mont_pendiente,
																								  porc_desc_pronto_pago,
																								  mont_desc_pronto_pago)
								    VALUES ($idcobranzaweb,
								            TO_DATE('$fecha','YYYY-MM-DD HH24:MI:SS'),
								            '$cmbempresa',
								    	      '$cmbcliente',
								      	    '$nbcliente',
								      	     $idvendedor,
								    	      '$cozona',
								    	       6322658,
								    	      '$txtobs',
								      	     $desc_esp_porc,
		                         $desc_flet_nc,
		                         $desc_divisa_porc,
		                         $tot_fact,
		                         $desc_esp_mont,
		                         $desc_divisa_mont,
		                         $cobrado,
		                         $subtotal,
		                         $total,
		                         $pendiente,
		                         $desc_pronto_pago_proc,
		                         $desc_pronto_pago_mont)";

				$respuesta = $ejecutar->ejecutar($query_3, $conexion, false);

				if (!empty($respuesta["error"]))
				{
					$ejecutar->rollback($conexion);
				  $ejecutar->desconectar($conexion);

				  $msn = "CODE: 1.3<br />";
					$msn = $msn . "MESSAGE: guardar_cobranza -> 1.3 ERROR AL INSERTAR DATOS EN TABLA web_cobranza_aso <br />";

				  session()->set('error', $msn);
				  return;
				}

				for ($x = 0; $x < count($arr_nu_fact); $x++) 
				{
					if (!empty($arr_nu_fact) && !empty($arr_mo_fact)) 
					{
						if ($arr_mo_fact[$x] > 0) 
						{
							$idcobranzafacturaweb = "";
		          
							$query_6 = "SELECT F00_ID_REGISTRO AS idcobranzafacturaweb
							            FROM DUAL";

							$respuesta = $ejecutar->ejecutar($query_6, $conexion, false);

							if (isset($respuesta["error"]) && $respuesta["error"] == "")
							{
								$result = $respuesta["resultado"];

								if ($row = $ejecutar->proximo($result))
								{
									do
									{
										$idcobranzafacturaweb = $row[$ejecutar->col_db("idcobranzafacturaweb")];
									}
									while ($row = $ejecutar->proximo($result));
								}
							}
							else
							{
								$ejecutar->rollback($conexion);
							  $ejecutar->desconectar($conexion);

							  $msn = "CODE: 1.6<br />";
							  $msn = $msn . "MESSAGE: guardar_cobranza -> 1.6 ERROR NO SE PUDO OBTENER EL ID PARA FACTURAS ASOCIADAS A LA COBRANZA F00_ID_REGISTRO <br />";

							  session()->set('error', $msn);
							  return;
							}

							$query_7 = "INSERT INTO web_cobranza_fac_aso ( id_registro,
																										   	     id_cobranza_web,
																											       nu_factura,
																											       saldo_factura,
																											       fe_emision )
											    VALUES ($idcobranzafacturaweb,
											            $idcobranzaweb,
												    	    '$arr_nu_fact[$x]',
												    	    $arr_mo_fact[$x],
												    	    TO_DATE('$arr_fe_emision_fact[$x]','YYYY-MM-DD'))";

							$respuesta = $ejecutar->ejecutar($query_7, $conexion, false);

							if (!empty($respuesta["error"]))
							{
								$ejecutar->rollback($conexion);
							  $ejecutar->desconectar($conexion);

							  $msn = "CODE: 1.7<br />";
								$msn = $msn . "MESSAGE: guardar_cobranza -> 1.7 ERROR AL INSERTAR DATOS FACTURAS EN TABLA web_cobranza_fac_aso <br />";

							  session()->set('error', $msn);
							  return;
							}
						}
					}
		    }

				for ($x = 0; $x < count($arr_co_banc); $x++) 
				{
					if (!empty($arr_fe_cobr) && !empty($arr_co_banc) &&
						    !empty($arr_nu_refe) && !empty($arr_co_mone) &&
						    !empty($arr_mo_cobr) && !empty($arr_mo_tasa) &&
						    !empty($arr_mo_tota)) 
					{
							$idcobranzapagoweb = "";
		          
							$query_8 = "SELECT F00_ID_REGISTRO AS idcobranzapagoweb
							            FROM DUAL";

							$respuesta = $ejecutar->ejecutar($query_8, $conexion, false);

							if (isset($respuesta["error"]) && $respuesta["error"] == "")
							{
								$result = $respuesta["resultado"];

								if ($row = $ejecutar->proximo($result))
								{
									do
									{
										$idcobranzapagoweb = $row[$ejecutar->col_db("idcobranzapagoweb")];
									}
									while ($row = $ejecutar->proximo($result));
								}
							}
							else
							{
								$ejecutar->rollback($conexion);
							  $ejecutar->desconectar($conexion);

							  $msn = "CODE: 1.8<br />";
							  $msn = $msn . "MESSAGE: guardar_cobranza -> 1.8 ERROR NO SE PUDO OBTENER EL ID PARA PAGO ASOCIADOS A LA COBRANZA F00_ID_REGISTRO <br />";

							  session()->set('error', $msn);
							  return;
							}

							if (!empty($arr_fe_cobr[$x]))
							{
								$arr_fe_cobr[$x] = "TO_DATE('" . $arr_fe_cobr[$x] . "','YYYY-MM-DD')";
							}

							if (empty($arr_mo_tasa[$x]))
							{
								$arr_mo_tasa[$x] = 0;
							}

							$query_9 = "INSERT INTO web_cobranza_pago_aso ( id_registro,
																														  id_cobranza_web,
																														  fecha,
																														  co_banco,
																														  referencia,
																														  co_moneda,
																														  monto,
																														  tasa,
																														  total,
																														  fe_emision )
											    VALUES ($idcobranzapagoweb,
											            $idcobranzaweb,
												    	    $arr_fe_cobr[$x],
												    	    '$arr_co_banc[$x]',
												    	    '$arr_nu_refe[$x]',
												    	    '$arr_co_mone[$x]',
												    	    $arr_mo_cobr[$x],
												    	    $arr_mo_tasa[$x],
												    	    $arr_mo_tota[$x],
												    	    TO_DATE('$arr_fe_emision_cob[$x]','YYYY-MM-DD'))";

							$respuesta = $ejecutar->ejecutar($query_9, $conexion, false);

							if (!empty($respuesta["error"]))
							{
								$ejecutar->rollback($conexion);
							  $ejecutar->desconectar($conexion);

							  $msn = "CODE: 1.9<br />";
								$msn = $msn . "MESSAGE: guardar_cobranza -> 1.9 ERROR AL INSERTAR DATOS FACTURAS EN TABLA web_cobranza_fac_aso <br />";

							  session()->set('error', $msn);
							  return;
							}
					}
		    }

        if (is_array($arr_com_imagenes) && isset($arr_com_imagenes['name']))
        {
          for ($x = 0; $x < count($arr_com_imagenes['name']); $x++)
          {
            $idcomprobanteweb = "";
            $query_10 = "SELECT F00_ID_REGISTRO AS idcomprobanteweb FROM DUAL";

            $respuesta = $ejecutar->ejecutar($query_10, $conexion, false);

            if (isset($respuesta["error"]) && $respuesta["error"] == "")
            {
              $result = $respuesta["resultado"];

              if ($row = $ejecutar->proximo($result))
              {
                do
                {
                  $idcomprobanteweb = $row[$ejecutar->col_db("idcomprobanteweb")];
                }
                while ($row = $ejecutar->proximo($result));
              }
            }
            else
            {
              $ejecutar->rollback($conexion);
              $ejecutar->desconectar($conexion);

              $msn = "CODE: 1.10<br />";
              $msn = $msn . "MESSAGE: guardar_cobranza -> 1.10 ERROR NO SE PUDO OBTENER EL ID PARA EL COMPROBANTE ASOCIADO A LA COBRANZA F00_ID_REGISTRO <br />";

              session()->set('error', $msn);
              return;
            }

            $_FILES['archivos']['name'] = $arr_com_imagenes['name'][$x];
            $_FILES['archivos']['type'] = $arr_com_imagenes['type'][$x];
            $_FILES['archivos']['tmp_name'] = $arr_com_imagenes['tmp_name'][$x];
            $_FILES['archivos']['error'] = $arr_com_imagenes['error'][$x];
            $_FILES['archivos']['size'] = $arr_com_imagenes['size'][$x];

            $config['upload_path'] = './images/comprobantes';
            $config['allowed_types'] = 'gif|jpg|png|pdf|jpeg|GIF|JPG|PNG|PDF|JPEG';
            $config['file_name'] = $idcomprobanteweb;

            $upload = \Config\Services::upload($config);
            $upload->initialize($config);

            if ($upload->do_upload('archivos'))
            {
                $fileData = $upload->data();
                $nombre_archivo = $fileData['file_name'];

								$query_11 = "INSERT INTO web_cobranza_com_aso ( id_registro,
																														  id_cobranza_web,
																														  tx_archivo )
											    VALUES ($idcomprobanteweb,
											            $idcobranzaweb,
												    	    '$nombre_archivo')";

								$respuesta = $ejecutar->ejecutar($query_11, $conexion, false);

    					if (!empty($respuesta["error"]))
    					{
    						$ejecutar->rollback($conexion);
    					  $ejecutar->desconectar($conexion);

    					  $msn = "CODE: 1.11<br />";
    						$msn = $msn . "MESSAGE: guardar_cobranza -> 1.11 ERROR AL INSERTAR DATOS COMPROBANTES EN TABLA web_cobranza_com_aso <br />";

    					  session()->set('error', $msn);
    					  return;
    					}
            }
            else 
            {
				    $error_subida = $upload->display_errors('', '');

				    $ejecutar->rollback($conexion);
				    $ejecutar->desconectar($conexion);

				    $msn = "CODE: 1.12<br />";
				    $msn .= "MESSAGE: Error al subir el archivo físico: " . $error_subida . "<br />";

				    session()->set('error', $msn);
    				return;
					}
          }
        }

				$ejecutar->commit($conexion);
				$ejecutar->desconectar($conexion);
				return;
			}

			if ($operacion == '3') 
			{
				$idcobranzaweb = $id_cobr_web;

				$query_3 = "UPDATE web_cobranza_aso
										SET    tx_observacion = '$txtobs',
					       					 porc_desc_especial = $desc_esp_porc,
					       					 mont_desc_flete = $desc_flet_nc,
					       					 porc_desc_pago_divisa = $desc_divisa_porc,
					       					 total_facturado = $tot_fact,
					       					 mont_desc_especial = $desc_esp_mont,
					       					 mont_desc_pago_divisa = $desc_divisa_mont,
					       					 mont_cobrado = $cobrado,
					       					 mont_subtotal = $subtotal,
					       					 mont_total = $total,
					       					 mont_pendiente = $pendiente,
					       					 porc_desc_pronto_pago = $desc_pronto_pago_proc,
					       					 mont_desc_pronto_pago = $desc_pronto_pago_mont
										WHERE  id_registro = $idcobranzaweb";

				$respuesta = $ejecutar->ejecutar($query_3, $conexion, false);

				if (!empty($respuesta["error"]))
				{
					$ejecutar->rollback($conexion);
				  $ejecutar->desconectar($conexion);

				  $msn = "CODE: 1.3<br />";
					$msn = $msn . "MESSAGE: guardar_cobranza -> 1.3 ERROR AL MODIFICAR DATOS EN TABLA web_cobranza_aso <br />";

				  session()->set('error', $msn);
				  return;
				}

				for ($x = 0; $x < count($arr_nu_fact); $x++) 
				{
					if (!empty($arr_nu_fact) && !empty($arr_mo_fact) && !empty($arr_factura_nuevo)) 
					{
						if (($arr_mo_fact[$x] > 0) && ($arr_factura_nuevo[$x] == "S")) 
						{
							$idcobranzafacturaweb = "";
		          
							$query_6 = "SELECT F00_ID_REGISTRO AS idcobranzafacturaweb
							            FROM DUAL";

							$respuesta = $ejecutar->ejecutar($query_6, $conexion, false);

							if (isset($respuesta["error"]) && $respuesta["error"] == "")
							{
								$result = $respuesta["resultado"];

								if ($row = $ejecutar->proximo($result))
								{
									do
									{
										$idcobranzafacturaweb = $row[$ejecutar->col_db("idcobranzafacturaweb")];
									}
									while ($row = $ejecutar->proximo($result));
								}
							}
							else
							{
								$ejecutar->rollback($conexion);
							  $ejecutar->desconectar($conexion);

							  $msn = "CODE: 1.6<br />";
							  $msn = $msn . "MESSAGE: guardar_cobranza -> 1.6 ERROR NO SE PUDO OBTENER EL ID PARA FACTURAS ASOCIADAS A LA COBRANZA F00_ID_REGISTRO <br />";

							  session()->set('error', $msn);
							  return;
							}

							$query_7 = "INSERT INTO web_cobranza_fac_aso ( id_registro,
																										   	     id_cobranza_web,
																											       nu_factura,
																											       saldo_factura,
																											       fe_emision )
											    VALUES ($idcobranzafacturaweb,
											            $idcobranzaweb,
												    	    '$arr_nu_fact[$x]',
												    	    $arr_mo_fact[$x],
												    	    TO_DATE('$arr_fe_emision_fact[$x]','YYYY-MM-DD'))";

							$respuesta = $ejecutar->ejecutar($query_7, $conexion, false);

							if (!empty($respuesta["error"]))
							{
								$ejecutar->rollback($conexion);
							  $ejecutar->desconectar($conexion);

							  $msn = "CODE: 1.7<br />";
								$msn = $msn . "MESSAGE: guardar_cobranza -> 1.7 ERROR AL INSERTAR DATOS FACTURAS EN TABLA web_cobranza_fac_aso <br />";

							  session()->set('error', $msn);
							  return;
							}
						}
					}
		    }

				for ($x = 0; $x < count($arr_co_banc); $x++) 
				{
					if ((!empty($arr_fe_cobr) && !empty($arr_co_banc) &&
						      !empty($arr_nu_refe) && !empty($arr_co_mone) &&
						      !empty($arr_mo_cobr) && !empty($arr_mo_tasa) &&
						      !empty($arr_mo_tota) && !empty($arr_pago_nuevo)) && ($arr_pago_nuevo[$x] == "S")) 
					{
							$idcobranzapagoweb = "";
		          
							$query_8 = "SELECT F00_ID_REGISTRO AS idcobranzapagoweb
							            FROM DUAL";

							$respuesta = $ejecutar->ejecutar($query_8, $conexion, false);

							if (isset($respuesta["error"]) && $respuesta["error"] == "")
							{
								$result = $respuesta["resultado"];

								if ($row = $ejecutar->proximo($result))
								{
									do
									{
										$idcobranzapagoweb = $row[$ejecutar->col_db("idcobranzapagoweb")];
									}
									while ($row = $ejecutar->proximo($result));
								}
							}
							else
							{
								$ejecutar->rollback($conexion);
							  $ejecutar->desconectar($conexion);

							  $msn = "CODE: 1.8<br />";
							  $msn = $msn . "MESSAGE: guardar_cobranza -> 1.8 ERROR NO SE PUDO OBTENER EL ID PARA PAGO ASOCIADOS A LA COBRANZA F00_ID_REGISTRO <br />";

							  session()->set('error', $msn);
							  return;
							}

							if (!empty($arr_fe_cobr[$x]))
							{
								$arr_fe_cobr[$x] = "TO_DATE('" . $arr_fe_cobr[$x] . "','YYYY-MM-DD')";
							}

							if (empty($arr_mo_tasa[$x]))
							{
								$arr_mo_tasa[$x] = 0;
							}

							$query_9 = "INSERT INTO web_cobranza_pago_aso ( id_registro,
																														  id_cobranza_web,
																														  fecha,
																														  co_banco,
																														  referencia,
																														  co_moneda,
																														  monto,
																														  tasa,
																														  total,
																														  fe_emision )
											    VALUES ($idcobranzapagoweb,
											            $idcobranzaweb,
												    	    $arr_fe_cobr[$x],
												    	    '$arr_co_banc[$x]',
												    	    '$arr_nu_refe[$x]',
												    	    '$arr_co_mone[$x]',
												    	    $arr_mo_cobr[$x],
												    	    $arr_mo_tasa[$x],
												    	    $arr_mo_tota[$x],
												    	    TO_DATE('$arr_fe_emision_cob[$x]','YYYY-MM-DD'))";

							$respuesta = $ejecutar->ejecutar($query_9, $conexion, false);

							if (!empty($respuesta["error"]))
							{
								$ejecutar->rollback($conexion);
							  $ejecutar->desconectar($conexion);

							  $msn = "CODE: 1.9<br />";
								$msn = $msn . "MESSAGE: guardar_cobranza -> 1.9 ERROR AL INSERTAR DATOS FACTURAS EN TABLA web_cobranza_fac_aso <br />";

							  session()->set('error', $msn);
							  return;
							}
					}
		    }

        if (is_array($arr_com_imagenes) && isset($arr_com_imagenes['name']))
        {
          for ($x = 0; $x < count($arr_com_imagenes['name']); $x++)
          {
            $idcomprobanteweb = "";
            $query_10 = "SELECT F00_ID_REGISTRO AS idcomprobanteweb FROM DUAL";

            $respuesta = $ejecutar->ejecutar($query_10, $conexion, false);

            if (isset($respuesta["error"]) && $respuesta["error"] == "")
            {
              $result = $respuesta["resultado"];

              if ($row = $ejecutar->proximo($result))
              {
                do
                {
                  $idcomprobanteweb = $row[$ejecutar->col_db("idcomprobanteweb")];
                }
                while ($row = $ejecutar->proximo($result));
              }
            }
            else
            {
              $ejecutar->rollback($conexion);
              $ejecutar->desconectar($conexion);

              $msn = "CODE: 1.10<br />";
              $msn = $msn . "MESSAGE: guardar_cobranza -> 1.10 ERROR NO SE PUDO OBTENER EL ID PARA EL COMPROBANTE ASOCIADO A LA COBRANZA F00_ID_REGISTRO <br />";

              session()->set('error', $msn);
              return;
            }

            $_FILES['archivos']['name'] = $arr_com_imagenes['name'][$x];
            $_FILES['archivos']['type'] = $arr_com_imagenes['type'][$x];
            $_FILES['archivos']['tmp_name'] = $arr_com_imagenes['tmp_name'][$x];
            $_FILES['archivos']['error'] = $arr_com_imagenes['error'][$x];
            $_FILES['archivos']['size'] = $arr_com_imagenes['size'][$x];

            $config['upload_path'] = './images/comprobantes';
            $config['allowed_types'] = 'gif|jpg|png|pdf';
            $config['file_name'] = $idcomprobanteweb;

            $upload = \Config\Services::upload($config);
            $upload->initialize($config);

            if ($upload->do_upload('archivos'))
            {
                $fileData = $upload->data();
                $nombre_archivo = $fileData['file_name'];

								$query_11 = "INSERT INTO web_cobranza_com_aso ( id_registro,
																														  id_cobranza_web,
																														  tx_archivo )
											    VALUES ($idcomprobanteweb,
											            $idcobranzaweb,
												    	    '$nombre_archivo')";

								$respuesta = $ejecutar->ejecutar($query_11, $conexion, false);

    					if (!empty($respuesta["error"]))
    					{
    						$ejecutar->rollback($conexion);
    					  $ejecutar->desconectar($conexion);

    					  $msn = "CODE: 1.11<br />";
    						$msn = $msn . "MESSAGE: guardar_cobranza -> 1.11 ERROR AL INSERTAR DATOS COMPROBANTES EN TABLA web_cobranza_com_aso <br />";

    					  session()->set('error', $msn);
    					  return;
    					}
            }
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
			$msn = $msn . "MESSAGE: Error Fatal -> 9001 guardar_cobranza: " . $e->getMessage() . " <br />";

			session()->set('error', $msn);
		}
	}

	//=============================================================================================================
    //
    //=============================================================================================================
	public function anular_cobranza( $id_cobr_web )
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
			$query_1 = "UPDATE web_cobranza_aso
									SET    ctv_id_estado_documento = 6322662
									WHERE  id_registro = $id_cobr_web";

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
			$msn = $msn . "MESSAGE: Error Fatal -> 9001 anular_cobranza: " . $e->getMessage() . " <br />";

			session()->set('error', $msn);
		}
	}

	//=============================================================================================================
    //
    //=============================================================================================================
	public function consultar_cobranza_fecha( $par_fecha_desde,
	                                 			    $par_fecha_hasta,
	                                 			    $par_idusuario,
	                                 			    $par_vendedor,
	                                 		      $par_coorganizacion )
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();

		$query_1 = "SELECT  a.id_registro as cob_id_cobranza,
												a.fe_emision,
											  a.co_empresa,
				                a.co_zona,
											  a.co_organizacion,
											  a.nb_organizacion,
											  a.id_vendedor,
				                f.usuario as nb_vendedor,
											  a.co_zona,
											  a.ctv_id_estado_documento,
											  g.de_ocurrencia as ctv_de_estado_documento,
											  a.tx_observacion,
											  a.porc_desc_especial,
											  a.mont_desc_flete,
											  a.porc_desc_pago_divisa,
											  a.total_facturado,
											  a.mont_desc_especial,
											  a.mont_desc_pago_divisa,
											  a.mont_cobrado,
											  a.mont_subtotal,
											  a.mont_total,
											  a.mont_pendiente,
											  a.porc_desc_pronto_pago,
											  a.mont_desc_pronto_pago
								FROM web_cobranza_aso a
								INNER JOIN web_clientes_aso c ON c.co_organizacion = a.co_organizacion
								INNER JOIN web_usuarios_aso f ON f.id_registro = a.id_vendedor
								INNER JOIN t00_contenido_tabla_virtual g ON g.id_registro = a.ctv_id_estado_documento
								WHERE a.id_registro IN (SELECT bb.id_cobranza_web
									                      FROM web_cobranza_pago_aso bb
									                      WHERE bb.fe_emision >= to_date('$par_fecha_desde','yyyy-mm-dd')
									                        AND bb.fe_emision <= to_date('$par_fecha_hasta','yyyy-mm-dd'))
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
					$lista [$contador]["cob_id_cobranza"]           = $row[$ejecutar->col_db("cob_id_cobranza")];
					$lista [$contador]["fe_emision"]                = $row[$ejecutar->col_db("fe_emision")];
					$lista [$contador]["co_empresa"]                = $row[$ejecutar->col_db("co_empresa")];
					$lista [$contador]["co_zona"]                   = $row[$ejecutar->col_db("co_zona")];
					$lista [$contador]["co_organizacion"]           = $row[$ejecutar->col_db("co_organizacion")];
					$lista [$contador]["nb_organizacion"]           = $row[$ejecutar->col_db("nb_organizacion")];
					$lista [$contador]["tx_observacion"]            = $row[$ejecutar->col_db("tx_observacion")];

					$lista [$contador]["id_vendedor"]               = $row[$ejecutar->col_db("id_vendedor")];
					$lista [$contador]["nb_vendedor"]               = strtoupper($row[$ejecutar->col_db("nb_vendedor")]);
					$lista [$contador]["ctv_id_estado_documento"]   = $row[$ejecutar->col_db("ctv_id_estado_documento")];
					$lista [$contador]["ctv_de_estado_documento"]   = $row[$ejecutar->col_db("ctv_de_estado_documento")];

					$lista [$contador]["porc_desc_especial"]        = $row[$ejecutar->col_db("porc_desc_especial")];
					$lista [$contador]["mont_desc_flete"]           = $row[$ejecutar->col_db("mont_desc_flete")];
					$lista [$contador]["porc_desc_pago_divisa"]     = $row[$ejecutar->col_db("porc_desc_pago_divisa")];
					$lista [$contador]["total_facturado"]           = $row[$ejecutar->col_db("total_facturado")];

					$lista [$contador]["mont_desc_especial"]        = $row[$ejecutar->col_db("mont_desc_especial")];
					$lista [$contador]["mont_desc_pago_divisa"]     = $row[$ejecutar->col_db("mont_desc_pago_divisa")];
					$lista [$contador]["mont_cobrado"]              = $row[$ejecutar->col_db("mont_cobrado")];
					$lista [$contador]["mont_subtotal"]             = $row[$ejecutar->col_db("mont_subtotal")];
					$lista [$contador]["mont_total"]                = $row[$ejecutar->col_db("mont_total")];
					$lista [$contador]["mont_pendiente"]            = $row[$ejecutar->col_db("mont_pendiente")];

					$lista [$contador]["porc_desc_pronto_pago"]     = $row[$ejecutar->col_db("porc_desc_pronto_pago")];
					$lista [$contador]["mont_desc_pronto_pago"]     = $row[$ejecutar->col_db("mont_desc_pronto_pago")];

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
	public function consultar_cobranza_factura($par_idcobranzafact,
		                                         $par_idcobranzaweb,
			                                       $par_factura)
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();

		$query_1 = "SELECT a.id_registro as id_cobranza_fact,
							       	 a.id_cobranza_web,
							       	 a.nu_factura,
							       	 a.saldo_factura,
							       	 a.fe_emision as fe_emision_fact
								FROM web_cobranza_fac_aso a
								INNER JOIN web_cobranza_aso b on b.id_registro = a.id_cobranza_web
								WHERE TRIM(CAST(a.id_registro AS CHAR(9))) LIKE '$par_idcobranzafact'
								  AND TRIM(CAST(a.id_cobranza_web AS CHAR(9))) LIKE '$par_idcobranzaweb'
								  AND TRIM(a.nu_factura) LIKE '$par_factura'";

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
					$lista [$contador]["id_cobranza_fact"] = $row[$ejecutar->col_db("id_cobranza_fact")];
					$lista [$contador]["id_cobranza_web"]  = $row[$ejecutar->col_db("id_cobranza_web")];
					$lista [$contador]["nu_factura"]       = $row[$ejecutar->col_db("nu_factura")];
					$lista [$contador]["saldo_factura"]    = $row[$ejecutar->col_db("saldo_factura")];
					$lista [$contador]["fe_emision_fact"]  = $row[$ejecutar->col_db("fe_emision_fact")];
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
	public function consultar_cobranza_pago($par_idcobranzapago,
		                                      $par_idcobranzaweb,
			                                    $par_banco,
			                                    $par_referencia,
			                                    $par_moneda)
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();

		$query_1 = "SELECT a.id_registro as id_cobranza_pago,
										   a.id_cobranza_web,
										   a.fecha,
										   a.co_banco,
										   a.referencia,
										   a.co_moneda,
										   a.monto,
										   a.tasa,
										   a.total,
										   a.fe_emision as fe_emision_cob
								FROM web_cobranza_pago_aso a
								INNER JOIN web_cobranza_aso b on b.id_registro = a.id_cobranza_web
								WHERE TRIM(CAST(a.id_registro AS CHAR(9))) LIKE '$par_idcobranzapago'
								  AND TRIM(CAST(a.id_cobranza_web AS CHAR(9))) LIKE '$par_idcobranzaweb'
								  AND TRIM(a.co_banco) LIKE '$par_banco'
								  AND TRIM(a.referencia) LIKE '$par_referencia'
								  AND TRIM(a.co_moneda) LIKE '$par_moneda'";

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
					$lista [$contador]["id_cobranza_pago"] = $row[$ejecutar->col_db("id_cobranza_pago")];
					$lista [$contador]["id_cobranza_web"]  = $row[$ejecutar->col_db("id_cobranza_web")];
					$lista [$contador]["fecha"]            = $row[$ejecutar->col_db("fecha")];
					$lista [$contador]["co_banco"]         = $row[$ejecutar->col_db("co_banco")];
					$lista [$contador]["referencia"]       = $row[$ejecutar->col_db("referencia")];
					$lista [$contador]["co_moneda"]        = $row[$ejecutar->col_db("co_moneda")];
					$lista [$contador]["monto"]            = $row[$ejecutar->col_db("monto")];
					$lista [$contador]["tasa"]             = $row[$ejecutar->col_db("tasa")];
					$lista [$contador]["total"]            = $row[$ejecutar->col_db("total")];
					$lista [$contador]["fe_emision_cob"]   = $row[$ejecutar->col_db("fe_emision_cob")];

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
	public function consultar_cobranza_comprobante($par_idcobranzacomprobante,
		                                      $par_idcobranzaweb,
			                                    $par_txcomprobante)
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();

		$query_1 = "SELECT a.id_registro as id_cobranza_comprobante,
                       a.id_cobranza_web,
                       a.tx_archivo
								FROM web_cobranza_com_aso a
								WHERE TRIM(CAST(a.id_registro AS CHAR(9))) LIKE '$par_idcobranzacomprobante'
								  AND TRIM(CAST(a.id_cobranza_web AS CHAR(9))) LIKE '$par_idcobranzaweb'
								  AND TRIM(a.tx_archivo) LIKE '$par_txcomprobante'";

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
					$lista [$contador]["id_cobranza_comprobante"] = $row[$ejecutar->col_db("id_cobranza_comprobante")];
					$lista [$contador]["id_cobranza_web"] = $row[$ejecutar->col_db("id_cobranza_web")];
					$lista [$contador]["tx_archivo"] = $row[$ejecutar->col_db("tx_archivo")];

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