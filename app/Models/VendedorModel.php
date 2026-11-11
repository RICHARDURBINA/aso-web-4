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

class VendedorModel extends Model
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

    //=============================================================================================================
    //
    //=============================================================================================================
    public function consultar_vendedor_zona_usuario($par_idusuario)
    {
        $class_control = $this->get_control();
        
        if (!class_exists($class_control)) {
            session()->set('error', 'No se encontró la clase de control: ' . $class_control);
            return [];
        }

        $ejecutar = new $class_control();

        $query_1 = "SELECT DISTINCT c.id_registro as id_vendedor, c.usuario, c.cedula, c.nombre
                    FROM (SELECT a.id_registro, a.usuario, a.cedula, a.nombre, b.co_zona
                          FROM web_usuarios_aso A 
                          INNER JOIN web_usuarios_zonas_aso b ON b.id_usuario = a.id_registro
                          WHERE a.Estatus = 'A'
                            AND a.rol IN ('S','V')
                            AND b.co_zona IN (SELECT aa.co_zona
                                              FROM web_usuarios_zonas_aso aa
                                              WHERE aa.id_usuario = $par_idusuario)) c
                    ORDER BY c.nombre ASC";  
        
        $conexion = $ejecutar->conectar();   

        if (!$conexion) {
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
                    $lista[$contador]["id_vendedor"] = $row[$ejecutar->col_db("id_vendedor")];
                    $lista[$contador]["usuario"]     = $row[$ejecutar->col_db("usuario")];
                    $lista[$contador]["cedula"]      = $row[$ejecutar->col_db("cedula")];
                    $lista[$contador]["nombre"]      = $row[$ejecutar->col_db("nombre")];
                    
                    $contador++;
                }
                while ($row = $ejecutar->proximo($result));
            }

            $ejecutar->desconectar($conexion);
            return $lista;
        }
        else
        {
            // ERROR DE CONEXIÓN
            session()->set('error', $respuesta["error"] ?? 'Error de conexión desconocido');
        }   

        $ejecutar->desconectar($conexion);
        return [];
    }
}