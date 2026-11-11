<?php

namespace App\Models;

use CodeIgniter\Model;

//----------------------------------------------------------
// BUSCAR CLASS (Ejecución previa a la clase igual que en tu código original)
//----------------------------------------------------------
$nombre_fichero = APPPATH . 'Models/class_first.txt';
$class_conexion = "conexion_mysql.php"; // O el que tengas por defecto

if (file_exists($nombre_fichero)) {
    $contenido = file_get_contents($nombre_fichero);
    $arreglo = explode("\n", str_replace("\r", "", $contenido));
    if (isset($arreglo[0]) && trim($arreglo[0]) !== '') {
        $class_conexion = trim($arreglo[0]);
    }
}

// Incluimos el archivo físico de conexión de forma idéntica a tu código original
$ruta_conexion = APPPATH . 'Models/' . $class_conexion;
if (file_exists($ruta_conexion)) {
    include_once($ruta_conexion);
}
//----------------------------------------------------------
//----------------------------------------------------------

class LoginModel extends Model
{
    function get_control()
    {
        //----------------------------------------------------------
        // BUSCAR CLASS PARA EL CONTROL
        //----------------------------------------------------------
        $nombre_fichero = APPPATH . 'Models/class_first.txt';
        $class_control = "control_mysql";

        if (file_exists($nombre_fichero)) {
            $contenido = file_get_contents($nombre_fichero);
            $arreglo = explode("\n", str_replace("\r", "", $contenido));
            if (isset($arreglo[1]) && trim($arreglo[1]) !== '') {
                $class_control = trim($arreglo[1]);
            }
        }

        return $class_control;
        //----------------------------------------------------------
        //----------------------------------------------------------
    }

    public function consultar_datos_usuario($par_usuario, $par_claveusuario, $par_empresa)
    {
        $class_control = $this->get_control();
        
        if (!class_exists($class_control)) {
            session()->set('error', 'No se encontró la clase de control: ' . $class_control);
            return [];
        }

        $ejecutar = new $class_control();

        $query_1 = "SELECT  a.id_registro,
                            a.usuario,
                            a.clave,
                            a.id_persona,
                            a.nombre,
                            a.cedula,
                            a.estatus,
                            a.id_registro AS id_usuario,
                            NVL(a.avatar,'1.png') AS avatar,
                            MAX(CASE WHEN a.co_servicio = 'COLA_LISTAR' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS cola_listar,
                            MAX(CASE WHEN a.co_servicio = 'VEHICULO_REGISTRO' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS vehiculo_registro,
                            MAX(CASE WHEN a.co_servicio = 'VEHICULO_LISTAR' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS vehiculo_listar,
                            MAX(CASE WHEN a.co_servicio = 'COLA_ANULAR' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS cola_anular,
                            MAX(CASE WHEN a.co_servicio = 'CHOFER_LISTAR' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS chofer_listar,
                            MAX(CASE WHEN a.co_servicio = 'CHOFER_REGISTRO' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS chofer_registro,
                            MAX(CASE WHEN a.co_servicio = 'CHOFER_ANULAR' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS chofer_anular,
                            MAX(CASE WHEN a.co_servicio = 'PLAN_DESASOCIAR' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS plan_desasociar,
                            MAX(CASE WHEN a.co_servicio = 'COLA_REGISTRO' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS cola_registro,
                            MAX(CASE WHEN a.co_servicio = 'RESUMEN_TRANSPORTE' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS resumen_transporte,
                            MAX(CASE WHEN a.co_servicio = 'VEHICULO_ANULAR' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS vehiculo_anular,
                            MAX(CASE WHEN a.co_servicio = 'PLAN_ASOCIAR' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS plan_asociar,
                            MAX(CASE WHEN a.co_servicio = 'COLA_CONSULTA' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS cola_consulta,
                            MAX(CASE WHEN a.co_servicio = 'ROMANA_LISTAR' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS romana_listar,
                            MAX(CASE WHEN a.co_servicio = 'ORDEN_REGISTRO' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS orden_registro,
                            MAX(CASE WHEN a.co_servicio = 'PLAN_CONSULTA' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS plan_consulta,
                            MAX(CASE WHEN a.co_servicio = 'VEHICULO_MODIFICAR' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS vehiculo_modificar,
                            MAX(CASE WHEN a.co_servicio = 'VISITA_CONSULTA' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS visita_consulta,
                            MAX(CASE WHEN a.co_servicio = 'PEDIDO_LISTAR' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS pedido_listar,
                            MAX(CASE WHEN a.co_servicio = 'PEDIDO_REGISTRO' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS pedido_registro,
                            MAX(CASE WHEN a.co_servicio = 'VISITA_REGISTRO' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS visita_registro,
                            MAX(CASE WHEN a.co_servicio = 'PLAN_ANULAR' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS plan_anular,
                            MAX(CASE WHEN a.co_servicio = 'PEDIDO_CONSULTA' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS pedido_consulta,
                            MAX(CASE WHEN a.co_servicio = 'COBRO_ADESA' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS cobro_adesa,
                            MAX(CASE WHEN a.co_servicio = 'PLAN_LISTAR' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS plan_listar,
                            MAX(CASE WHEN a.co_servicio = 'COBRANZA_CONSULTA' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS cobranza_consulta,
                            MAX(CASE WHEN a.co_servicio = 'PEDIDO_APROBAR' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS pedido_aprobar,
                            MAX(CASE WHEN a.co_servicio = 'VISITA_ANULAR' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS visita_anular,
                            MAX(CASE WHEN a.co_servicio = 'RESUMEN_PRODUCTO' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS resumen_producto,
                            MAX(CASE WHEN a.co_servicio = 'COBRANZA_MODIFICAR' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS cobranza_modificar,
                            MAX(CASE WHEN a.co_servicio = 'PLAN_APLICAR_NC' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS plan_aplicar_nc,
                            MAX(CASE WHEN a.co_servicio = 'PEDIDO_TRASLADO' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS pedido_traslado,
                            MAX(CASE WHEN a.co_servicio = 'COBRO_AAI' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS cobro_aai,
                            MAX(CASE WHEN a.co_servicio = 'PEDIDO_ANULAR' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS pedido_anular,
                            MAX(CASE WHEN a.co_servicio = 'COBRANZA_ANULAR' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS cobranza_anular,
                            MAX(CASE WHEN a.co_servicio = 'ID_USUARIO' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS id_usuario,
                            MAX(CASE WHEN a.co_servicio = 'COBRANZA_REGISTRO' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS cobranza_registro,
                            MAX(CASE WHEN a.co_servicio = 'COBRANZA_LISTAR' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS cobranza_listar,
                            MAX(CASE WHEN a.co_servicio = 'PLAN_REGISTRO' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS plan_registro,
                            MAX(CASE WHEN a.co_servicio = 'CHOFER_MODIFICAR' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS chofer_modificar,
                            MAX(CASE WHEN a.co_servicio = 'VISITA_LISTAR' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS visita_listar,
                            MAX(CASE WHEN a.co_servicio = 'GRAFICA' AND b.co_servicio IS NOT NULL THEN 1 ELSE 0 END) AS grafica        
                    FROM ( SELECT DISTINCT aa.id_registro,
                                           aa.usuario,
                                           aa.clave,
                                           aa.id_persona,
                                           aa.nombre,
                                           aa.cedula,
                                           aa.estatus,
                                           aa.avatar,
                                           bb.co_servicio
                           FROM web_usuarios_aso aa,
                                web_servicio_aso bb ) a  
                    LEFT JOIN web_privilegio_aso b ON b.id_usuario = a.id_registro  AND b.co_servicio = a.co_servicio
                    WHERE TRIM(UPPER(a.usuario)) LIKE '$par_usuario'
                      AND TRIM(a.clave) LIKE '$par_claveusuario' 
                      AND a.estatus = 'A'
                    GROUP BY a.id_registro,
                             a.usuario,
                             a.clave,
                             a.id_persona,
                             a.nombre,
                             a.cedula,
                             a.estatus,
                             a.avatar";

        $conexion = $ejecutar->conectar();

        if (!$conexion) {
            session()->set('error', 'No se pudo establecer la conexión a la base de datos.');
            return [];
        }

        $respuesta = $ejecutar->ejecutar($query_1, $conexion);
        $contador = 0;
        $lista = array();

        if (isset($respuesta["error"]) && $respuesta["error"] == "") {
            $result = $respuesta["resultado"];

            if ($row = $ejecutar->proximo($result)) {
                do {
                    $lista[$contador]["idusuario"]   = $row[$ejecutar->col_db("id_registro")];
                    $lista[$contador]["usuario"]     = $row[$ejecutar->col_db("usuario")];
                    $lista[$contador]["clave"]       = $row[$ejecutar->col_db("clave")];
                    $lista[$contador]["id_persona"]  = $row[$ejecutar->col_db("id_persona")];
                    $lista[$contador]["nombre"]      = $row[$ejecutar->col_db("nombre")];
                    $lista[$contador]["cedula"]      = $row[$ejecutar->col_db("cedula")];

                    $lista[$contador]["pedido_registro"] = $row[$ejecutar->col_db("pedido_registro")];
                    $lista[$contador]["pedido_consulta"] = $row[$ejecutar->col_db("pedido_consulta")];
                    $lista[$contador]["pedido_aprobar"]  = $row[$ejecutar->col_db("pedido_aprobar")];
                    $lista[$contador]["pedido_anular"]   = $row[$ejecutar->col_db("pedido_anular")];
                    $lista[$contador]["pedido_listar"]   = $row[$ejecutar->col_db("pedido_listar")];
                    $lista[$contador]["pedido_traslado"] = $row[$ejecutar->col_db("pedido_traslado")];

                    $lista[$contador]["visita_registro"] = $row[$ejecutar->col_db("visita_registro")];
                    $lista[$contador]["visita_consulta"] = $row[$ejecutar->col_db("visita_consulta")];
                    $lista[$contador]["visita_anular"]   = $row[$ejecutar->col_db("visita_anular")];
                    $lista[$contador]["visita_listar"]   = $row[$ejecutar->col_db("visita_listar")];

                    $lista[$contador]["cobranza_registro"]  = $row[$ejecutar->col_db("cobranza_registro")];
                    $lista[$contador]["cobranza_consulta"]  = $row[$ejecutar->col_db("cobranza_consulta")];
                    $lista[$contador]["cobranza_anular"]    = $row[$ejecutar->col_db("cobranza_anular")];
                    $lista[$contador]["cobranza_listar"]    = $row[$ejecutar->col_db("cobranza_listar")];
                    $lista[$contador]["cobranza_modificar"] = $row[$ejecutar->col_db("cobranza_modificar")];

                    $lista[$contador]["grafica"]             = $row[$ejecutar->col_db("grafica")];
                    $lista[$contador]["cobro_adesa"]         = $row[$ejecutar->col_db("cobro_adesa")];
                    $lista[$contador]["cobro_aai"]           = $row[$ejecutar->col_db("cobro_aai")];

                    $lista[$contador]["cola_registro"]   = $row[$ejecutar->col_db("cola_registro")];
                    $lista[$contador]["cola_consulta"]   = $row[$ejecutar->col_db("cola_consulta")];
                    $lista[$contador]["cola_anular"]     = $row[$ejecutar->col_db("cola_anular")];
                    $lista[$contador]["cola_listar"]     = $row[$ejecutar->col_db("cola_listar")];

                    $lista[$contador]["plan_registro"]   = $row[$ejecutar->col_db("plan_registro")];
                    $lista[$contador]["plan_consulta"]   = $row[$ejecutar->col_db("plan_consulta")];
                    $lista[$contador]["plan_anular"]     = $row[$ejecutar->col_db("plan_anular")];
                    $lista[$contador]["plan_asociar"]    = $row[$ejecutar->col_db("plan_asociar")];
                    $lista[$contador]["plan_desasociar"] = $row[$ejecutar->col_db("plan_desasociar")];

                    $lista[$contador]["resumen_producto"]   = $row[$ejecutar->col_db("resumen_producto")];
                    $lista[$contador]["resumen_transporte"] = $row[$ejecutar->col_db("resumen_transporte")];

                    $lista[$contador]["chofer_registro"]   = $row[$ejecutar->col_db("chofer_registro")];
                    $lista[$contador]["chofer_anular"]     = $row[$ejecutar->col_db("chofer_anular")];
                    $lista[$contador]["chofer_listar"]     = $row[$ejecutar->col_db("chofer_listar")];
                    $lista[$contador]["chofer_modificar"]  = $row[$ejecutar->col_db("chofer_modificar")];

                    $lista[$contador]["vehiculo_registro"]  = $row[$ejecutar->col_db("vehiculo_registro")];
                    $lista[$contador]["vehiculo_anular"]    = $row[$ejecutar->col_db("vehiculo_anular")];
                    $lista[$contador]["vehiculo_listar"]    = $row[$ejecutar->col_db("vehiculo_listar")];
                    $lista[$contador]["vehiculo_modificar"] = $row[$ejecutar->col_db("vehiculo_modificar")];

                    $lista[$contador]["plan_aplicar_nc"]   = $row[$ejecutar->col_db("plan_aplicar_nc")];
                    $lista[$contador]["orden_registro"]    = $row[$ejecutar->col_db("orden_registro")];
                    $lista[$contador]["plan_listar"]       = $row[$ejecutar->col_db("plan_listar")];
                    $lista[$contador]["romana_listar"]     = $row[$ejecutar->col_db("romana_listar")];
                    $lista[$contador]["avatar"]            = $row[$ejecutar->col_db("avatar")];

                    $contador++;
                } while ($row = $ejecutar->proximo($result));
            }

            $ejecutar->desconectar($conexion);
            return $lista;
        } else {
            // ERROR DE CONEXIÓN
            session()->set('error', $respuesta["error"] ?? 'Error de conexión desconocido');
        }

        $ejecutar->desconectar($conexion);
        return [];
    }
}