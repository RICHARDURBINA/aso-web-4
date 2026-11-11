<?php

namespace App\Models;

use CodeIgniter\Model;

//----------------------------------------------------------
// BUSCAR CLASS (Igual que en LoginModel)
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

class PedidoModel extends Model
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

    public function consultar_pedido($par_idpedido, $par_cozona, $par_coorganizacion, $par_nborganizacion, $par_condicionpago, $par_coempresa, $par_estadodocumento, $par_coproducto, $par_nbproducto)
    {
        $class_control = $this->get_control();
        
        if (!class_exists($class_control)) 
        {
            session()->set('error', 'No se encontró la clase de control: ' . $class_control);
            return [];
        }

        $ejecutar = new $class_control();

        $query_1 = "SELECT a.id_registro as pec_id_pedido_aso,
                           a.fe_emision,
                           a.co_zona,
                           a.co_organizacion,
                           a.nb_organizacion,
                           a.in_condicion_pago,
                           a.tx_observacion,
                           a.id_vendedor,
                           f.usuario,
                           f.nombre as nb_vendedor,
                           b.id_registro as pedidos_documentos_aso,
                           NVL(b.nu_pedido,'S/P') AS nu_pedido,
                           NVL(b.nu_pedido_promo,'S/P') AS nu_pedido_promo,
                           b.fe_procesado,
                           b.co_empresa,
                           b.id_referencia_aso,
                           b.id_referencia_promo,
                           b.ctv_de_estado_documento,
                           d.id_registro as pedido_producto_aso,
                           d.prd_id_producto_aso,
                           d.ca_producto,
                           d.ca_producto_promo,
                           d.pr_producto,
                           d.pc_descuento,
                           d.tipo_descuento,
                           e.co_producto,
                           e.nb_producto,
                           b.tx_direccion_entrega,
                           (SELECT COUNT(bb.ctv_de_estado_documento) 
                            FROM web_pedidos_documentos_aso bb
                            WHERE bb.pec_id_pedido_aso = a.id_registro
                              AND bb.ctv_de_estado_documento NOT IN ('PROGRAMADO')) AS estado_original_pedido,
                           (SELECT MAX(bb.fe_documento)  
                             FROM web_pedidos_doc_asociados_aso bb
                             WHERE bb.id_pec_pedido_doc_aso = b.id_registro
                               AND bb.ctv_de_estado_documento IN ('EMITIDO')
                               AND bb.tipo_documento IN ('FAC')) AS  fec_fac,
                            (SELECT MAX(bb.fe_documento) 
                             FROM web_pedidos_doc_asociados_aso bb
                             WHERE bb.id_pec_pedido_doc_aso = b.id_registro
                               AND bb.ctv_de_estado_documento IN ('EMITIDO')
                               AND bb.tipo_documento IN ('NOS')) AS  fec_nos
                    FROM web_pedidos_aso a
                    INNER JOIN web_pedidos_documentos_aso b ON b.pec_id_pedido_aso = a.id_registro
                    INNER JOIN web_clientes_aso c ON c.co_organizacion = a.co_organizacion
                    INNER JOIN web_pedidos_productos_aso d ON d.pec_id_pedido_aso = a.id_registro 
                    INNER JOIN web_productos_aso e ON e.id_registro = d.prd_id_producto_aso AND e.co_empresa = b.co_empresa
                    INNER JOIN web_usuarios_aso f ON f.id_registro = a.id_vendedor
                    WHERE TRIM(CAST(a.id_registro AS CHAR(9))) LIKE '$par_idpedido'  
                      AND a.co_zona LIKE '$par_cozona'
                      AND a.co_organizacion LIKE '$par_coorganizacion'
                      AND a.nb_organizacion LIKE '$par_nborganizacion'
                      AND a.in_condicion_pago LIKE '$par_condicionpago'
                      AND b.co_empresa LIKE '$par_coempresa'
                      AND b.ctv_de_estado_documento LIKE '$par_estadodocumento'
                      AND e.co_producto LIKE '$par_coproducto'
                      AND e.nb_producto LIKE '$par_nbproducto'
                    ORDER BY a.id_registro, b.id_registro DESC";

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
                    $lista[$contador]["pec_id_pedido_aso"]       = $row[$ejecutar->col_db("pec_id_pedido_aso")];
                    $lista[$contador]["fe_emision"]              = $row[$ejecutar->col_db("fe_emision")];
                    $lista[$contador]["co_zona"]                 = $row[$ejecutar->col_db("co_zona")];
                    $lista[$contador]["co_organizacion"]         = $row[$ejecutar->col_db("co_organizacion")];
                    $lista[$contador]["nb_organizacion"]         = $row[$ejecutar->col_db("nb_organizacion")];
                    $lista[$contador]["in_condicion_pago"]       = $row[$ejecutar->col_db("in_condicion_pago")];
                    $lista[$contador]["tx_observacion"]          = $row[$ejecutar->col_db("tx_observacion")];
                    $lista[$contador]["id_vendedor"]             = $row[$ejecutar->col_db("id_vendedor")];
                    $lista[$contador]["usuario"]                 = $row[$ejecutar->col_db("usuario")];
                    $lista[$contador]["nb_vendedor"]             = strtoupper($row[$ejecutar->col_db("nb_vendedor")]);
                    $lista[$contador]["pedidos_documentos_aso"]  = $row[$ejecutar->col_db("pedidos_documentos_aso")];
                    $lista[$contador]["nu_pedido"]               = $row[$ejecutar->col_db("nu_pedido")];
                    $lista[$contador]["nu_pedido_promo"]         = $row[$ejecutar->col_db("nu_pedido_promo")];
                    $lista[$contador]["fe_procesado"]            = $row[$ejecutar->col_db("fe_procesado")];
                    $lista[$contador]["co_empresa"]              = $row[$ejecutar->col_db("co_empresa")];
                    $lista[$contador]["id_referencia_aso"]       = $row[$ejecutar->col_db("id_referencia_aso")];
                    $lista[$contador]["id_referencia_promo"]     = $row[$ejecutar->col_db("id_referencia_promo")];
                    $lista[$contador]["ctv_de_estado_documento"] = $row[$ejecutar->col_db("ctv_de_estado_documento")];
                    $lista[$contador]["pedido_producto_aso"]     = $row[$ejecutar->col_db("pedido_producto_aso")];
                    $lista[$contador]["prd_id_producto_aso"]     = $row[$ejecutar->col_db("prd_id_producto_aso")];
                    $lista[$contador]["ca_producto"]             = $row[$ejecutar->col_db("ca_producto")];
                    $lista[$contador]["ca_producto_promo"]       = $row[$ejecutar->col_db("ca_producto_promo")];
                    $lista[$contador]["pr_producto"]             = $row[$ejecutar->col_db("pr_producto")];
                    $lista[$contador]["pc_descuento"]            = $row[$ejecutar->col_db("pc_descuento")];
                    $lista[$contador]["tipo_descuento"]          = $row[$ejecutar->col_db("tipo_descuento")];
                    $lista[$contador]["co_producto"]             = $row[$ejecutar->col_db("co_producto")];
                    $lista[$contador]["nb_producto"]             = $row[$ejecutar->col_db("nb_producto")];
                    $lista[$contador]["tx_direccion_entrega"]    = $row[$ejecutar->col_db("tx_direccion_entrega")];
                    $lista[$contador]["estado_original_pedido"]  = $row[$ejecutar->col_db("estado_original_pedido")];
                    $lista[$contador]["fec_fac"]                 = $row[$ejecutar->col_db("fec_fac")];
                    $lista[$contador]["fec_nos"]                 = $row[$ejecutar->col_db("fec_nos")];
                    $contador++;
                } 
                while ($row = $ejecutar->proximo($result));
            }
            $ejecutar->desconectar($conexion);
            return $lista;
        } 
        else 
        {
            session()->set('error', $respuesta["error"] ?? 'Error desconocido en la consulta');
        }
        $ejecutar->desconectar($conexion);
        return [];
    }

    public function consultar_pedido_descuento($par_idpedido, $par_idpedidoprd, $par_iddescuento, $par_idprd, $par_coprd)
    {
        $class_control = $this->get_control();
        $ejecutar = new $class_control();

        $query_1 = "SELECT b.pec_id_pedido_aso,       
                           a.pcp_id_pedido_producto_aso,
                           b.prd_id_producto_aso,
                           d.co_producto,
                           d.nb_producto,
                           a.id_registro as id_descuento,
                           a.ca_dias_descuento,
                           a.pc_descuento
                    FROM web_pedidos_pro_desc_aso a
                    INNER JOIN web_pedidos_productos_aso b on b.id_registro = a.pcp_id_pedido_producto_aso
                    INNER JOIN web_pedidos_aso c on c.id_registro = b.pec_id_pedido_aso
                    INNER JOIN web_productos_aso d ON d.id_registro = b.prd_id_producto_aso 
                    WHERE TRIM(CAST(c.id_registro AS CHAR(9))) LIKE '$par_idpedido'  
                      AND TRIM(CAST(a.pcp_id_pedido_producto_aso AS CHAR(9))) LIKE '$par_idpedidoprd' 
                      AND TRIM(CAST(a.id_registro AS CHAR(9))) LIKE '$par_iddescuento'
                      AND TRIM(CAST(b.prd_id_producto_aso AS CHAR(9))) LIKE '$par_idprd'                      
                      AND d.co_producto LIKE '$par_coprd'";

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
                    $lista[$contador]["pec_id_pedido_aso"]       = $row[$ejecutar->col_db("pec_id_pedido_aso")];
                    $lista[$contador]["pcp_id_pedido_producto_aso"] = $row[$ejecutar->col_db("pcp_id_pedido_producto_aso")];
                    $lista[$contador]["prd_id_producto_aso"] = $row[$ejecutar->col_db("prd_id_producto_aso")];
                    $lista[$contador]["co_producto"]         = $row[$ejecutar->col_db("co_producto")];
                    $lista[$contador]["nb_producto"]         = $row[$ejecutar->col_db("nb_producto")];
                    $lista[$contador]["id_descuento"]        = $row[$ejecutar->col_db("id_descuento")];
                    $lista[$contador]["ca_dias_descuento"]   = $row[$ejecutar->col_db("ca_dias_descuento")];
                    $lista[$contador]["pc_descuento"]        = $row[$ejecutar->col_db("pc_descuento")];
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

    public function guardar_pedido($fecha, $cmbcliente, $cmbsucursaladesa, $cmbsucursalaai, $cmbconpag, $txtobs, $idvendedor, $coemp, $idprd, $coprd, $prprd, $caprd, $promprd, $descprd, $tipodesc, $totalprd, $total_desc_prd_actual, $array_dia_desc, $array_porc_desc, $operacion)
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
                $idpedidoweb = "";

                $query_1 = "SELECT a.co_organizacion, a.nb_organizacion, a.co_zona, a.adesa, a.aai
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
                    session()->set('error', "CODE: 1.1<br />MESSAGE: guardar_pedido -> 1.1 ERROR NO SE PUDO UBICAR LOS DATOS DEL CLIENTE<br />");
                    return;
                }

                $query_2 = "SELECT F00_ID_REGISTRO AS idpedidoweb FROM DUAL";
                $respuesta = $ejecutar->ejecutar($query_2, $conexion, false);

                if (isset($respuesta["error"]) && $respuesta["error"] == "") 
                {
                    $result = $respuesta["resultado"];
                    if ($row = $ejecutar->proximo($result)) 
                    {
                        do 
                        {
                            $idpedidoweb = $row[$ejecutar->col_db("idpedidoweb")];
                        } 
                        while ($row = $ejecutar->proximo($result));
                    }
                } 
                else 
                {
                    $ejecutar->rollback($conexion);
                    $ejecutar->desconectar($conexion);
                    session()->set('error', "CODE: 1.2<br />MESSAGE: guardar_pedido -> 1.2 ERROR NO SE PUDO OBTENER EL ID F00_ID_REGISTRO<br />");
                    return;
                }

                $query_3 = "INSERT INTO web_pedidos_aso ( id_registro, fe_emision, co_zona, co_organizacion, nb_organizacion, in_condicion_pago, tx_observacion, id_vendedor ) 
                    VALUES ($idpedidoweb, TO_DATE('$fecha','YYYY-MM-DD HH24:MI:SS'), '$cozona', '$cmbcliente', '$nbcliente', '$cmbconpag', '$txtobs', '$idvendedor')";
                
                $respuesta = $ejecutar->ejecutar($query_3, $conexion, false);

                if (!empty($respuesta["error"])) 
                {
                    $ejecutar->rollback($conexion);
                    $ejecutar->desconectar($conexion);
                    session()->set('error', "CODE: 1.3<br />MESSAGE: guardar_pedido -> 1.3 ERROR AL INSERTAR EN web_pedidos_aso<br />");
                    return;
                }

                $prd_adesa = 0;
                $prd_aai = 0;

                for ($x = 0; $x < $totalprd; $x++) 
                {
                    if (!(empty($caprd) || empty($promprd))) 
                    {
                        if (($caprd[$x] > 0) || ($promprd[$x] > 0)) 
                        {
                            if ($coemp[$x] == "ADESA") 
                            {
                                $prd_adesa = $prd_adesa + 1;
                            }
                            if ($coemp[$x] == "AA1") 
                            {
                                $prd_aai = $prd_aai + 1;
                            }

                            if ($prd_adesa == 1) 
                            {
                                $prd_adesa = $prd_adesa + 1;
                                $query_4_1 = "INSERT INTO web_pedidos_documentos_aso ( id_registro, pec_id_pedido_aso, co_empresa, id_referencia_aso, ctv_de_estado_documento, tx_direccion_entrega ) 
                                            VALUES (F00_ID_REGISTRO, $idpedidoweb, 'ADESA', NULL, 'PROGRAMADO', '$cmbsucursaladesa')";
                                $respuesta = $ejecutar->ejecutar($query_4_1, $conexion, false);

                                if (!empty($respuesta["error"])) 
                                {
                                    $ejecutar->rollback($conexion);
                                    $ejecutar->desconectar($conexion);
                                    session()->set('error', "CODE: 1.4.1<br />MESSAGE: guardar_pedido -> 1.4.1 ERROR web_pedidos_documentos_aso<br />");
                                    return;
                                }
                            }

                            if ($prd_aai == 1) 
                            {
                                $prd_aai = $prd_aai + 1;
                                $query_4_2 = "INSERT INTO web_pedidos_documentos_aso ( id_registro, pec_id_pedido_aso, co_empresa, id_referencia_aso, ctv_de_estado_documento, tx_direccion_entrega ) 
                                            VALUES (F00_ID_REGISTRO, $idpedidoweb, 'AA1', NULL, 'PROGRAMADO', '$cmbsucursalaai')";
                                $respuesta = $ejecutar->ejecutar($query_4_2, $conexion, false);

                                if (!empty($respuesta["error"])) 
                                {
                                    $ejecutar->rollback($conexion);
                                    $ejecutar->desconectar($conexion);
                                    session()->set('error', "CODE: 1.4.2<br />MESSAGE: guardar_pedido -> 1.4.2 ERROR web_pedidos_documentos_aso<br />");
                                    return;
                                }
                            }

                            $idpedidoproductoweb = "";
                            $query_5 = "SELECT F00_ID_REGISTRO AS idpedidoproductoweb FROM DUAL";
                            $respuesta = $ejecutar->ejecutar($query_5, $conexion, false);

                            if (isset($respuesta["error"]) && $respuesta["error"] == "") 
                            {
                                $result = $respuesta["resultado"];
                                if ($row = $ejecutar->proximo($result)) 
                                {
                                    do 
                                    {
                                        $idpedidoproductoweb = $row[$ejecutar->col_db("idpedidoproductoweb")];
                                    } 
                                    while ($row = $ejecutar->proximo($result));
                                }
                            } 
                            else 
                            {
                                $ejecutar->rollback($conexion);
                                $ejecutar->desconectar($conexion);
                                session()->set('error', "CODE: 1.5<br />MESSAGE: guardar_pedido -> 1.5 ERROR ID DETALLE PEDIDO<br />");
                                return;
                            }

                            $query_6 = "INSERT INTO web_pedidos_productos_aso ( id_registro, pec_id_pedido_aso, prd_id_producto_aso, pr_producto, ca_producto, ca_producto_promo, pc_descuento, tipo_descuento ) 
                                VALUES ($idpedidoproductoweb, $idpedidoweb, {$idprd[$x]}, {$prprd[$x]}, {$caprd[$x]}, {$promprd[$x]}, {$descprd[$x]}, REPLACE('{$tipodesc[$x]}', '', NULL))";
                            
                            $respuesta = $ejecutar->ejecutar($query_6, $conexion, false);

                            if (!empty($respuesta["error"])) 
                            {
                                $ejecutar->rollback($conexion);
                                $ejecutar->desconectar($conexion);
                                session()->set('error', "CODE: 1.6<br />MESSAGE: guardar_pedido -> 1.6 ERROR web_pedidos_productos_aso<br />");
                                return;
                            }

                            $total_desc_act = isset($total_desc_prd_actual[$x]) ? $total_desc_prd_actual[$x] : 0;
                            for ($i = 0; $i < $total_desc_act; $i++) 
                            {
                                if (!(empty($array_dia_desc))) 
                                {
                                    if (isset($array_dia_desc[$x][$i]) && $array_dia_desc[$x][$i] > 0) 
                                    {
                                        $val_1 = $array_dia_desc[$x][$i];
                                        $val_2 = $array_porc_desc[$x][$i];

                                        $query_7 = "INSERT INTO web_pedidos_pro_desc_aso ( id_registro, pcp_id_pedido_producto_aso, ca_dias_descuento, pc_descuento ) 
                                            VALUES (F00_ID_REGISTRO, $idpedidoproductoweb, $val_1, $val_2)";
                                        
                                        $respuesta = $ejecutar->ejecutar($query_7, $conexion, false);

                                        if (!empty($respuesta["error"])) 
                                        {
                                            $ejecutar->rollback($conexion);
                                            $ejecutar->desconectar($conexion);
                                            session()->set('error', "CODE: 1.7<br />MESSAGE: guardar_pedido -> 1.7 ERROR web_pedidos_pro_desc_aso<br />");
                                            return;
                                        }
                                    }
                                }
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
            session()->set('error', "CODE: 9001<br />MESSAGE: Error Fatal -> 9001 guardar_pedido: " . $e->getMessage() . "<br />");
        }
    }

    public function aprobar_pedido($id_ped_web, $id_doc_emp)
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
            $query_1 = 'BEGIN P_WEB_APROBAR_PEDIDOS(:id_doc_emp, :id_ped_web); END;';
            $stmt = oci_parse($conexion, $query_1);
            oci_bind_by_name($stmt, ':id_doc_emp', $id_doc_emp);
            oci_bind_by_name($stmt, ':id_ped_web', $id_ped_web);
            $respuesta = oci_execute($stmt);

            if (!$respuesta) 
            {
                $ejecutar->rollback($conexion);
                $ejecutar->desconectar($conexion);
                session()->set('error', "Error al aprobar pedido");
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
            session()->set('error', "Error Fatal -> 9001 aprobar_pedido: " . $e->getMessage());
        }
    }

    public function trasladar_pedido($id_ped_web, $id_doc_emp)
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
            $query_1 = 'BEGIN P_WEB_TRASLADAR_PEDIDOS(:id_doc_emp, :id_ped_web); END;';
            $stmt = oci_parse($conexion, $query_1);
            oci_bind_by_name($stmt, ':id_doc_emp', $id_doc_emp);
            oci_bind_by_name($stmt, ':id_ped_web', $id_ped_web);
            $respuesta = oci_execute($stmt);

            if (!$respuesta) 
            {
                $ejecutar->rollback($conexion);
                $ejecutar->desconectar($conexion);
                session()->set('error', "Error al trasladar pedido");
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
            session()->set('error', "Error Fatal -> 9001 trasladar_pedido: " . $e->getMessage());
        }
    }

    public function trasladar_ordenes()
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
            $query_1 = 'BEGIN P_WEB_TRASLADAR_ORDENES(); END;';
            $stmt = oci_parse($conexion, $query_1);
            $respuesta = oci_execute($stmt);

            if (!$respuesta) 
            {
                $ejecutar->rollback($conexion);
                $ejecutar->desconectar($conexion);
                session()->set('error', "Error al trasladar órdenes");
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
            session()->set('error', "Error Fatal -> 9001 trasladar_ordenes: " . $e->getMessage());
        }
    }

    public function anular_pedido($id_ped_web, $id_doc_emp)
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
            $query_1 = "UPDATE web_pedidos_documentos_aso 
                        SET    ctv_de_estado_documento = 'ANULADO'
                        WHERE  pec_id_pedido_aso = $id_ped_web";

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
            session()->set('error', "Error Fatal -> 9001 anular_pedido: " . $e->getMessage());
        }
    }

    public function consultar_pedido_fecha($par_fecha_desde, $par_fecha_hasta, $par_idusuario, $par_vendedor, $par_coorganizacion, $par_est_anulado, $par_coempresa, $par_coestatus)
    {
        $class_control = $this->get_control();
        $ejecutar = new $class_control();

        if ($par_est_anulado == "N") 
        {
            $query_1 = "SELECT a.id_registro as pec_id_pedido_aso,
                               a.fe_emision,
                               a.co_zona,
                               a.co_organizacion,
                               a.nb_organizacion,
                               a.in_condicion_pago,
                               a.tx_observacion,
                               a.id_vendedor,
                               f.usuario as nb_vendedor,
                               b.id_registro as pedidos_documentos_aso,
                               NVL(b.nu_pedido,'S/P') AS nu_pedido,
                               NVL(b.nu_pedido_promo,'S/P') AS nu_pedido_promo,
                               b.fe_procesado,
                               b.co_empresa,
                               b.id_referencia_aso,
                               b.id_referencia_promo,
                               b.ctv_de_estado_documento,
                               d.prd_id_producto_aso,
                               d.ca_producto,
                               d.ca_producto_promo,
                               d.pr_producto,
                               d.pc_descuento,
                               d.tipo_descuento,
                               e.co_producto,
                               e.nb_producto,
                               b.tx_direccion_entrega,
                               (SELECT COUNT(bb.ctv_de_estado_documento) 
                                FROM web_pedidos_documentos_aso bb
                                WHERE bb.pec_id_pedido_aso = a.id_registro
                                  AND bb.ctv_de_estado_documento NOT IN ('PROGRAMADO','ANULADO')) AS estado_original_pedido,
                                (SELECT MAX(bb.fe_documento)  
                                 FROM web_pedidos_doc_asociados_aso bb
                                 WHERE bb.id_pec_pedido_doc_aso = b.id_registro
                                   AND bb.ctv_de_estado_documento IN ('EMITIDO')
                                   AND bb.tipo_documento IN ('FAC')) AS  fec_fac,
                                (SELECT MAX(bb.fe_documento) 
                                 FROM web_pedidos_doc_asociados_aso bb
                                 WHERE bb.id_pec_pedido_doc_aso = b.id_registro
                                   AND bb.ctv_de_estado_documento IN ('EMITIDO')
                                   AND bb.tipo_documento IN ('NOS')) AS  fec_nos,
                                NVL(F_WEB_CA_BUENA_PRD ( a.fe_emision, a.co_organizacion, a.id_vendedor, a.co_zona, d.prd_id_producto_aso ), 0) AS ca_buena_condicion
                        FROM web_pedidos_aso a
                        INNER JOIN web_pedidos_documentos_aso b ON b.pec_id_pedido_aso = a.id_registro
                        INNER JOIN web_clientes_aso c ON c.co_organizacion = a.co_organizacion
                        INNER JOIN web_pedidos_productos_aso d ON d.pec_id_pedido_aso = a.id_registro 
                        INNER JOIN web_productos_aso e ON e.id_registro = d.prd_id_producto_aso AND e.co_empresa = b.co_empresa
                        INNER JOIN web_usuarios_aso f ON f.id_registro = a.id_vendedor                      
                        WHERE a.fe_emision >= to_date('$par_fecha_desde','yyyy-mm-dd')
                          AND a.fe_emision <= to_date('$par_fecha_hasta','yyyy-mm-dd')
                          AND a.co_zona IN (SELECT aa.co_zona 
                                            FROM web_usuarios_zonas_aso aa 
                                            WHERE aa.id_usuario = '$par_idusuario')
                          AND TRIM(CAST(a.id_vendedor AS CHAR(15))) LIKE '$par_vendedor' 
                          AND a.co_organizacion LIKE '$par_coorganizacion'                        
                          AND b.co_empresa LIKE '$par_coempresa'
                          AND ( b.ctv_de_estado_documento LIKE '$par_coestatus' AND b.ctv_de_estado_documento NOT IN ('ANULADO') )
                        ORDER BY a.id_registro, b.id_registro DESC";
        } 
        else 
        {
            $query_1 = "SELECT a.id_registro as pec_id_pedido_aso,
                               a.fe_emision,
                               a.co_zona,
                               a.co_organizacion,
                               a.nb_organizacion,
                               a.in_condicion_pago,
                               a.tx_observacion,
                               a.id_vendedor,
                               f.usuario as nb_vendedor,
                               b.id_registro as pedidos_documentos_aso,
                               NVL(b.nu_pedido,'S/P') AS nu_pedido,
                               NVL(b.nu_pedido_promo,'S/P') AS nu_pedido_promo,
                               b.fe_procesado,
                               b.co_empresa,
                               b.id_referencia_aso,
                               b.id_referencia_promo,
                               b.ctv_de_estado_documento,
                               d.prd_id_producto_aso,
                               d.ca_producto,
                               d.ca_producto_promo,
                               d.pr_producto,
                               d.pc_descuento,
                               d.tipo_descuento,
                               e.co_producto,
                               e.nb_producto,
                               b.tx_direccion_entrega,
                               (SELECT COUNT(bb.ctv_de_estado_documento) 
                                FROM web_pedidos_documentos_aso bb
                                WHERE bb.pec_id_pedido_aso = a.id_registro
                                  AND bb.ctv_de_estado_documento NOT IN ('PROGRAMADO')) AS estado_original_pedido,
                                (SELECT MAX(bb.fe_documento)  
                                 FROM web_pedidos_doc_asociados_aso bb
                                 WHERE bb.id_pec_pedido_doc_aso = b.id_registro
                                   AND bb.ctv_de_estado_documento IN ('EMITIDO')
                                   AND bb.tipo_documento IN ('FAC')) AS  fec_fac,
                                (SELECT MAX(bb.fe_documento) 
                                 FROM web_pedidos_doc_asociados_aso bb
                                 WHERE bb.id_pec_pedido_doc_aso = b.id_registro
                                   AND bb.ctv_de_estado_documento IN ('EMITIDO')
                                   AND bb.tipo_documento IN ('NOS')) AS  fec_nos,                               
                                0 AS ca_buena_condicion
                        FROM web_pedidos_aso a
                        INNER JOIN web_pedidos_documentos_aso b ON b.pec_id_pedido_aso = a.id_registro
                        INNER JOIN web_clientes_aso c ON c.co_organizacion = a.co_organizacion
                        INNER JOIN web_pedidos_productos_aso d ON d.pec_id_pedido_aso = a.id_registro 
                        INNER JOIN web_productos_aso e ON e.id_registro = d.prd_id_producto_aso AND e.co_empresa = b.co_empresa
                        INNER JOIN web_usuarios_aso f ON f.id_registro = a.id_vendedor  
                        WHERE a.fe_emision >= to_date('$par_fecha_desde','yyyy-mm-dd')
                          AND a.fe_emision <= to_date('$par_fecha_hasta','yyyy-mm-dd')
                          AND a.co_zona IN (SELECT aa.co_zona 
                                            FROM web_usuarios_zonas_aso aa 
                                            WHERE aa.id_usuario = '$par_idusuario')
                          AND TRIM(CAST(a.id_vendedor AS CHAR(15))) LIKE '$par_vendedor' 
                          AND a.co_organizacion LIKE '$par_coorganizacion'
                          AND b.co_empresa LIKE '$par_coempresa'
                          AND ( b.ctv_de_estado_documento LIKE '$par_coestatus' OR b.ctv_de_estado_documento IN ('ANULADO') )
                        ORDER BY a.id_registro, b.id_registro DESC";
        }

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
                    $lista[$contador]["pec_id_pedido_aso"]       = $row[$ejecutar->col_db("pec_id_pedido_aso")];
                    $lista[$contador]["fe_emision"]              = $row[$ejecutar->col_db("fe_emision")];
                    $lista[$contador]["co_zona"]                 = $row[$ejecutar->col_db("co_zona")];
                    $lista[$contador]["co_organizacion"]         = $row[$ejecutar->col_db("co_organizacion")];
                    $lista[$contador]["nb_organizacion"]         = $row[$ejecutar->col_db("nb_organizacion")];
                    $lista[$contador]["in_condicion_pago"]       = $row[$ejecutar->col_db("in_condicion_pago")];
                    $lista[$contador]["tx_observacion"]          = $row[$ejecutar->col_db("tx_observacion")];
                    $lista[$contador]["id_vendedor"]             = $row[$ejecutar->col_db("id_vendedor")];
                    $lista[$contador]["nb_vendedor"]             = $row[$ejecutar->col_db("nb_vendedor")];
                    $lista[$contador]["pedidos_documentos_aso"]  = $row[$ejecutar->col_db("pedidos_documentos_aso")];
                    $lista[$contador]["nu_pedido"]               = $row[$ejecutar->col_db("nu_pedido")];
                    $lista[$contador]["nu_pedido_promo"]         = $row[$ejecutar->col_db("nu_pedido_promo")];
                    $lista[$contador]["fe_procesado"]            = $row[$ejecutar->col_db("fe_procesado")];
                    $lista[$contador]["co_empresa"]              = $row[$ejecutar->col_db("co_empresa")];
                    $lista[$contador]["id_referencia_aso"]       = $row[$ejecutar->col_db("id_referencia_aso")];
                    $lista[$contador]["id_referencia_promo"]     = $row[$ejecutar->col_db("id_referencia_promo")];
                    $lista[$contador]["ctv_de_estado_documento"] = $row[$ejecutar->col_db("ctv_de_estado_documento")];
                    $lista[$contador]["prd_id_producto_aso"]     = $row[$ejecutar->col_db("prd_id_producto_aso")];
                    $lista[$contador]["ca_producto"]             = $row[$ejecutar->col_db("ca_producto")];
                    $lista[$contador]["ca_producto_promo"]       = $row[$ejecutar->col_db("ca_producto_promo")];
                    $lista[$contador]["pr_producto"]             = $row[$ejecutar->col_db("pr_producto")];
                    $lista[$contador]["pc_descuento"]            = $row[$ejecutar->col_db("pc_descuento")];
                    $lista[$contador]["tipo_descuento"]          = $row[$ejecutar->col_db("tipo_descuento")];
                    $lista[$contador]["co_producto"]             = $row[$ejecutar->col_db("co_producto")];
                    $lista[$contador]["nb_producto"]             = $row[$ejecutar->col_db("nb_producto")];
                    $lista[$contador]["tx_direccion_entrega"]    = $row[$ejecutar->col_db("tx_direccion_entrega")];
                    $lista[$contador]["estado_original_pedido"]  = $row[$ejecutar->col_db("estado_original_pedido")];
                    $lista[$contador]["fec_fac"]                 = $row[$ejecutar->col_db("fec_fac")];
                    $lista[$contador]["fec_nos"]                 = $row[$ejecutar->col_db("fec_nos")];
                    $lista[$contador]["ca_buena_condicion"]      = $row[$ejecutar->col_db("ca_buena_condicion")];
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

    public function consultar_pedido_documentos_asociados($par_id_ped_web, $par_id_doc_emp, $par_id_ped_aso)
    {
        $class_control = $this->get_control();
        $ejecutar = new $class_control();

        $query_1 = "SELECT a.id_registro AS id_ped_doc_asoc,
                           a.id_pec_pedido_doc_aso,
                           a.id_referencia,
                           a.nu_documento,
                           a.tipo_documento,
                           a.fe_documento,
                           a.ctv_de_estado_documento
                    FROM web_pedidos_doc_asociados_aso a
                    INNER JOIN web_pedidos_documentos_aso b ON b.id_registro = a.id_pec_pedido_doc_aso
                    INNER JOIN web_pedidos_aso c ON c.id_registro = b.pec_id_pedido_aso
                    WHERE TRIM(CAST(a.id_pec_pedido_doc_aso AS CHAR(9))) LIKE '$par_id_doc_emp'  
                      AND TRIM(CAST(b.pec_id_pedido_aso AS CHAR(9))) LIKE '$par_id_ped_web'
                      AND TRIM(CAST(b.id_referencia_aso AS CHAR(9))) LIKE '$par_id_ped_aso'
                    ORDER BY a.tipo_documento ASC";

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
                    $lista[$contador]["id_ped_doc_asoc"]         = $row[$ejecutar->col_db("id_ped_doc_asoc")];
                    $lista[$contador]["id_pec_pedido_doc_aso"]   = $row[$ejecutar->col_db("id_pec_pedido_doc_aso")];
                    $lista[$contador]["id_referencia"]           = $row[$ejecutar->col_db("id_referencia")];
                    $lista[$contador]["nu_documento"]            = $row[$ejecutar->col_db("nu_documento")];
                    $lista[$contador]["tipo_documento"]          = $row[$ejecutar->col_db("tipo_documento")];
                    $lista[$contador]["fe_documento"]            = $row[$ejecutar->col_db("fe_documento")];
                    $lista[$contador]["ctv_de_estado_documento"] = $row[$ejecutar->col_db("ctv_de_estado_documento")];
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