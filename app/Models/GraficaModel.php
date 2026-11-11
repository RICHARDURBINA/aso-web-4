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

class GraficaModel extends Model
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
	public function consultar_arr_grafica_1( $par_fecha_desde,
	                                  		 $par_fecha_hasta,
	                                 		 $par_idusuario )
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();

		$query_1 = "SELECT e.co_empresa,
					       e.co_producto,
					       e.nb_producto,
					       e.nb_corto,
					       SUM(d.ca_producto) AS ca_producto
					FROM web_pedidos_aso a
					INNER JOIN web_pedidos_documentos_aso b ON b.pec_id_pedido_aso = a.id_registro
					INNER JOIN web_clientes_aso c ON c.co_organizacion = a.co_organizacion
					INNER JOIN web_pedidos_productos_aso d ON d.pec_id_pedido_aso = a.id_registro
					INNER JOIN web_productos_aso e ON e.id_registro = d.prd_id_producto_aso AND e.co_empresa = b.co_empresa
					WHERE b.ctv_de_estado_documento NOT IN ('ANULADO')
					  AND a.fe_emision >= to_date('$par_fecha_desde','yyyy-mm-dd')
					  AND a.fe_emision <= to_date('$par_fecha_hasta','yyyy-mm-dd')
					GROUP BY e.co_empresa, e.co_producto, e.nb_producto, e.nb_corto
					ORDER BY e.co_empresa";

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
					$lista [$contador]["co_empresa"]  = $row[$ejecutar->col_db("co_empresa")];
					$lista [$contador]["co_producto"] = $row[$ejecutar->col_db("co_producto")];
					$lista [$contador]["nb_producto"] = $row[$ejecutar->col_db("nb_producto")];
					$lista [$contador]["nb_corto"]    = $row[$ejecutar->col_db("nb_corto")];
					$lista [$contador]["ca_producto"] = $row[$ejecutar->col_db("ca_producto")];

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
	public function consultar_arr_grafica_2( $par_fecha_desde,
	                                  		 $par_fecha_hasta,
	                                 		 $par_idusuario )
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();

		$query_1 = "SELECT e.co_empresa,
					       a.id_vendedor,
					       f.nombre AS nb_vendedor,
					       TO_NUMBER(SUM(d.ca_producto)) AS ca_producto
					FROM web_pedidos_aso a
					INNER JOIN web_pedidos_documentos_aso b ON b.pec_id_pedido_aso = a.id_registro
					INNER JOIN web_clientes_aso c ON c.co_organizacion = a.co_organizacion
					INNER JOIN web_pedidos_productos_aso d ON d.pec_id_pedido_aso = a.id_registro
					INNER JOIN web_productos_aso e ON e.id_registro = d.prd_id_producto_aso AND e.co_empresa = b.co_empresa
					INNER JOIN web_usuarios_aso f ON f.id_registro = a.id_vendedor
					WHERE b.ctv_de_estado_documento NOT IN ('ANULADO')
					  AND a.fe_emision >= to_date('$par_fecha_desde','yyyy-mm-dd')
					  AND a.fe_emision <= to_date('$par_fecha_hasta','yyyy-mm-dd')
					GROUP BY e.co_empresa, a.id_vendedor, f.nombre
					ORDER BY e.co_empresa";

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
					$lista [$contador]["co_empresa"]  = $row[$ejecutar->col_db("co_empresa")];
					$lista [$contador]["id_vendedor"] = $row[$ejecutar->col_db("id_vendedor")];
					$lista [$contador]["nb_vendedor"] = $row[$ejecutar->col_db("nb_vendedor")];
					$lista [$contador]["ca_producto"] = $row[$ejecutar->col_db("ca_producto")];

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
	public function consultar_arr_grafica_3( $par_fecha_desde,
	                                  		 $par_fecha_hasta,
	                                 		 $par_idusuario )
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();

		$query_1 = "SELECT a.id_vendedor,
					       f.nombre AS nb_vendedor,
					       TO_NUMBER(SUM(DECODE(a.co_empresa,'ADESA', a.mont_cobrado, 0))) AS monto_cobrado_adesa,
                 		   TO_NUMBER(SUM(DECODE(a.co_empresa,'AA1', a.mont_cobrado, 0))) AS monto_cobrado_aai
					FROM web_cobranza_aso a
					INNER JOIN t00_contenido_tabla_virtual b ON b.id_registro = a.ctv_id_estado_documento
					INNER JOIN web_clientes_aso c ON c.co_organizacion = a.co_organizacion
					INNER JOIN web_usuarios_aso f ON f.id_registro = a.id_vendedor
					WHERE b.de_ocurrencia NOT IN ('ANULADO')
					  AND a.fe_emision >= to_date('$par_fecha_desde','yyyy-mm-dd')
					  AND a.fe_emision <= to_date('$par_fecha_hasta','yyyy-mm-dd')
					GROUP BY a.id_vendedor, f.nombre
					ORDER BY f.nombre";

		$conexion = $ejecutar->conectar();
        if (!$conexion) 
        {
            return [];
        }

		$ejecutar->formato_decimal('.,', $conexion);

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
					$lista [$contador]["id_vendedor"] = $row[$ejecutar->col_db("id_vendedor")];
					$lista [$contador]["nb_vendedor"] = $row[$ejecutar->col_db("nb_vendedor")];
					$lista [$contador]["monto_cobrado_adesa"] = $row[$ejecutar->col_db("monto_cobrado_adesa")];
					$lista [$contador]["monto_cobrado_aai"]   = $row[$ejecutar->col_db("monto_cobrado_aai")];

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
    // COBRANZAS ADESA (RANGO DE FECHA)
    //=============================================================================================================
	public function consultar_arr_grafica_4( $par_fecha_desde,
	                                  		 $par_fecha_hasta,
	                                 		 $par_idusuario )
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();

		$query_1 = "SELECT a.fe_emision,
					       TO_NUMBER(SUM(NVL(a.mont_cobrado,0))) AS monto_cobrado_adesa
					FROM web_cobranza_aso a
					INNER JOIN t00_contenido_tabla_virtual b ON b.id_registro = a.ctv_id_estado_documento
					INNER JOIN web_clientes_aso c ON c.co_organizacion = a.co_organizacion
					INNER JOIN web_usuarios_aso f ON f.id_registro = a.id_vendedor
					WHERE b.de_ocurrencia NOT IN ('ANULADO')
					  AND a.fe_emision >= to_date('$par_fecha_desde','yyyy-mm-dd')
					  AND a.fe_emision <= to_date('$par_fecha_hasta','yyyy-mm-dd')
					  AND a.co_empresa = 'ADESA'
					GROUP BY a.fe_emision
					ORDER BY a.fe_emision";

		$conexion = $ejecutar->conectar();
        if (!$conexion) 
        {
            return [];
        }

		$ejecutar->formato_decimal('.,', $conexion);

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
					$lista [$contador]["fe_emision"] = $row[$ejecutar->col_db("fe_emision")];
					$lista [$contador]["monto_cobrado_adesa"] = $row[$ejecutar->col_db("monto_cobrado_adesa")];

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
    // COBRANZAS AAI (RANGO DE FECHA)
    //=============================================================================================================
	public function consultar_arr_grafica_5( $par_fecha_desde,
	                                  		 $par_fecha_hasta,
	                                 		 $par_idusuario )
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();

		$query_1 = "SELECT a.fe_emision,
					       TO_NUMBER(SUM(NVL(a.mont_cobrado,0))) AS monto_cobrado_aai
					FROM web_cobranza_aso a
					INNER JOIN t00_contenido_tabla_virtual b ON b.id_registro = a.ctv_id_estado_documento
					INNER JOIN web_clientes_aso c ON c.co_organizacion = a.co_organizacion
					INNER JOIN web_usuarios_aso f ON f.id_registro = a.id_vendedor
					WHERE b.de_ocurrencia NOT IN ('ANULADO')
					  AND a.fe_emision >= to_date('$par_fecha_desde','yyyy-mm-dd')
					  AND a.fe_emision <= to_date('$par_fecha_hasta','yyyy-mm-dd')
					  AND a.co_empresa = 'AA1'
					GROUP BY a.fe_emision
					ORDER BY a.fe_emision";

		$conexion = $ejecutar->conectar();
        if (!$conexion) 
        {
            return [];
        }

		$ejecutar->formato_decimal('.,', $conexion);

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
					$lista [$contador]["fe_emision"] = $row[$ejecutar->col_db("fe_emision")];
					$lista [$contador]["monto_cobrado_aai"] = $row[$ejecutar->col_db("monto_cobrado_aai")];

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
  // RESUMEN TRANSPORTE CHOFERES
  //=============================================================================================================
	public function consultar_arr_resumen_1($par_fecha, $par_transportista, $par_idusuario)
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();
        $vars_temporales = array();

		$query_1 = "SELECT e.co_chofer,
									     e.nb_chofer,
                       b.co_transportista,
									     a.nb_organizacion,
									     c.co_producto,
									     c.nb_producto,
									     SUM(a.ca_producto) as ca_prd_aprobado
						    FROM web_programacion_pedido_aso a
						    JOIN web_control_cola_aso b ON a.id_control_cola = b.id_registro
						    JOIN web_productos_aso c ON a.prd_id_producto_aso = c.id_registro
						    JOIN web_chofer_aso e ON e.id_registro = b.id_chofer
						    WHERE 1 = 1
						      AND a.ctv_de_estado_documento IN ('APROBADO','FACTURADO','DESPACHADO')
						      AND b.ctv_co_estado_documento IN ('EM','FN')
                  AND a.fe_plan = to_date('$par_fecha','yyyy-mm-dd')
                  AND b.co_transportista = NVL('$par_transportista',b.co_transportista)
						    GROUP BY e.co_chofer,
										     e.nb_chofer,
										     a.nb_organizacion,
										     c.co_producto,
										     c.nb_producto,
                         b.co_transportista
						    ORDER BY e.nb_chofer,
						    				 a.nb_organizacion,
						    				 c.nb_producto ASC";

		$conexion = $ejecutar->conectar();
        if (!$conexion) 
        {
            return [];
        }

		$ejecutar->formato_decimal('.,', $conexion);

		$respuesta = $ejecutar->ejecutar($query_1, $conexion);

		if (isset($respuesta["error"]) && $respuesta["error"] == "") 
		{
            $contador = 0;
            $contador2 = 0;
            $lista = array();
            $result = $respuesta["resultado"];
            $vars_temporales['co_chofer'] = '';
            $vars_temporales['nb_organizacion'] = '';
            $vars_temporales['contador_clientes'] = 0;
            $vars_temporales['contador_chofer'] = 0;

            if ($row = $ejecutar->proximo($result))
            {
                do
                {
                    if($vars_temporales['co_chofer'] != $row[$ejecutar->col_db("co_chofer")]) 
                    {
                        $vars_temporales['contador_chofer'] = $contador;
                        $vars_temporales['contador_clientes'] = 0;
                        $vars_temporales['nb_organizacion'] = '';
                        $vars_temporales['co_chofer'] = $row[$ejecutar->col_db("co_chofer")];

                        $lista [$vars_temporales['contador_chofer']]["co_chofer"] = $row[$ejecutar->col_db("co_chofer")];
                        $lista [$vars_temporales['contador_chofer']]["nb_chofer"] = $row[$ejecutar->col_db("nb_chofer")];

                        $contador++;
                    }

                    if($vars_temporales['nb_organizacion'] != $row[$ejecutar->col_db("nb_organizacion")]) 
                    {
                        $vars_temporales['contador_clientes'] = $contador2;
                        $vars_temporales['nb_organizacion'] = $row[$ejecutar->col_db("nb_organizacion")];

                        $lista [$vars_temporales['contador_chofer']]["detalle_clientes"][$vars_temporales['contador_clientes']]['nb_organizacion'] = $row[$ejecutar->col_db("nb_organizacion")];

                        $contador2++;
                    }

                    $lista [$vars_temporales['contador_chofer']]["detalle_clientes"][$vars_temporales['contador_clientes']]['detalle_productos'][] = array(
                        'co_producto' => $row[$ejecutar->col_db("co_producto")],
                        'nb_producto' => $row[$ejecutar->col_db("nb_producto")],
                        'ca_prd_aprobado' => $row[$ejecutar->col_db("ca_prd_aprobado")],
                    );

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
  // RESUMEN TRANSPORTE PRODUCTOS
  //=============================================================================================================
	public function consultar_arr_resumen_producto_1($par_fecha, $par_transportista, $par_idusuario)
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();
        $vars_temporales = array();

		$query_1 = "SELECT c.co_producto,
									     c.nb_producto,
                       NVL((select inv.ca_producto
                          from web_productos_inventario_aso inv
                         where inv.id_producto_aso = c.id_registro
                           and inv.fe_registro = to_date('$par_fecha','yyyy-mm-dd')),0) as ca_inventario,
									     SUM(a.ca_producto) as ca_programada,
									     a.nb_organizacion,
									     e.co_chofer,
									     e.nb_chofer,
                       f.co_vehiculo,
                       b.co_transportista
						    FROM web_programacion_pedido_aso a
						    JOIN web_control_cola_aso b ON a.id_control_cola = b.id_registro
						    JOIN web_productos_aso c ON a.prd_id_producto_aso = c.id_registro
						    JOIN web_chofer_aso e ON e.id_registro = b.id_chofer
						    JOIN web_vehiculo_aso f ON f.id_registro = b.id_vehiculo
						    WHERE 1 = 1
						      AND a.ctv_de_estado_documento IN ('APROBADO','FACTURADO','DESPACHADO')
						      AND b.ctv_co_estado_documento IN ('EM','FN')
                  AND a.fe_plan = to_date('$par_fecha','yyyy-mm-dd')
                  AND b.co_transportista = NVL('$par_transportista',b.co_transportista)
						    GROUP BY e.co_chofer,
										     e.nb_chofer,
										     a.nb_organizacion,
										     c.co_producto,
										     c.nb_producto,
                         f.co_vehiculo,
                         c.id_registro,
                         b.co_transportista
						    ORDER BY c.nb_producto, a.nb_organizacion ASC";

		$conexion = $ejecutar->conectar();
        if (!$conexion) 
        {
            return [];
        }

		$ejecutar->formato_decimal('.,', $conexion);

		$respuesta = $ejecutar->ejecutar($query_1, $conexion);

		if (isset($respuesta["error"]) && $respuesta["error"] == "") 
		{
            $contador = 0;
            $lista = array();
            $result = $respuesta["resultado"];
            $vars_temporales['co_producto'] = '';
            $vars_temporales['contador_producto'] = 0;

            if ($row = $ejecutar->proximo($result))
            {
                do
                {
                    if($vars_temporales['co_producto'] != $row[$ejecutar->col_db("co_producto")]) 
                    {
                        $vars_temporales['contador_producto'] = $contador;
                        $vars_temporales['co_producto'] = $row[$ejecutar->col_db("co_producto")];

                        $lista [$vars_temporales['contador_producto']]["co_producto"] = $row[$ejecutar->col_db("co_producto")];
                        $lista [$vars_temporales['contador_producto']]["nb_producto"] = $row[$ejecutar->col_db("nb_producto")];
                        $lista [$vars_temporales['contador_producto']]["ca_inventario"] = $row[$ejecutar->col_db("ca_inventario")];
                        $lista [$vars_temporales['contador_producto']]["ca_programada"] = 0;

                        $contador++;
                    }

                    $lista [$vars_temporales['contador_producto']]["detalle"][] = array(
                        'nb_organizacion' => $row[$ejecutar->col_db("nb_organizacion")],
                        'co_chofer' => $row[$ejecutar->col_db("co_chofer")],
                        'nb_chofer' => $row[$ejecutar->col_db("nb_chofer")],
                        'co_vehiculo' => $row[$ejecutar->col_db("co_vehiculo")],
                        'ca_programada' => $row[$ejecutar->col_db("ca_programada")],
                    );

                    $lista [$vars_temporales['contador_producto']]["ca_programada"] += $row[$ejecutar->col_db("ca_programada")];

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