<?php
    
class control_oracle
{
    private $protocol; 
    private $host; 
    private $port; 
    private $basedatos; 
    private $usuario; 
    private $clave; 
    private $conexion;   
    
    function __construct()
    {     
        /*
        // TIRA DE CONEXION WEB ASOPORTUGUESA
        $this->protocol  = 'TCP'; 
        $this->port      = '1521'; 
        $this->host      = '192.168.4.5'; 
        $this->basedatos = 'FIGO';
        $this->usuario   = 'sqlfigo'; 
        $this->clave     = 'oracleaaosa'; 
        $this->charset   = 'AL32UTF8'; 
        $this->conexion  = '';
        */

        // TIRA DE CONEXION WEB ADESA
        $this->protocol  = 'TCP'; 
        $this->port      = '1521'; 
        $this->host      = '192.168.2.2'; 
        $this->basedatos = 'SIMAALM';
        $this->usuario   = 'WEB'; 
        $this->clave     = 'WEB'; 
        $this->charset   = 'AL32UTF8'; 
        $this->conexion  = '';

        /*
        // TIRA DE CONEXION LOCAL
        $this->protocol  = 'TCP'; 
        $this->port      = '1521'; 
        $this->host      = '127.0.0.1'; 
        $this->basedatos = 'LOCAL';
        //$this->host      = '192.168.2.2'; 
        //$this->basedatos = 'SIMAALM';
        $this->usuario   = 'web'; 
        $this->clave     = 'web'; 
        $this->charset   = 'AL32UTF8'; 
        $this->conexion  = '';
        */
    }      

    // ================================================
    // Devuelve Nombre de Columna segun Base de datos
    // ================================================
    public function col_db($nom)
    {        
        return strtoupper($nom);
    } 

    // ================================================
    // Devuelve Tipo Base de datos
    // ================================================
    public function tipobasedatos()
    {        
        return "oracle";
    } 

    // ================================================
    // Devuelve Nombre Base de datos
    // ================================================
    public function database()
    {        
        return $this->basedatos;
    } 

    // ================================================
    // 
    // ================================================
    public function conectar(){

        $con_str = "(DESCRIPTION =
                        (ADDRESS = (PROTOCOL = ".$this->protocol.")(HOST = ".$this->host.")(PORT = ".$this->port."))
                        (CONNECT_DATA = (SERVER = DEDICATED)(SID = ".$this->basedatos."))
                    )";

        $this->conexion = oci_connect( $this->usuario, $this->clave, $con_str, $this->charset ); 

        return $this->conexion;
    } 

    // ================================================
    // 
    // ================================================
    public function conectar_modulo($array_conex){

        if(Count($array_conex) > 0)
        {    
            $con_str = "(DESCRIPTION =
                        (ADDRESS = (PROTOCOL = ".$array_conex[0]["protocolo"].")(HOST = ".$array_conex[0]["servidor"].")(PORT = ".$array_conex[0]["puerto"]."))
                        (CONNECT_DATA = (SERVER = DEDICATED)(SID = ".$array_conex[0]["basedatos"]."))
                    )";

            $this->conexion = oci_connect( $array_conex[0]["usuario"], $array_conex[0]["clave"], $con_str ); 
            return $this->conexion;     
        }
        else
        {
            return '';
        }       
    } 

    //funcion para cerrar conexion
    public function desconectar($con)
    {  
        return oci_close($con);
    }    

    // ==================================================
    //
    // ==================================================
    /*public function ejecutar_old($sql, $con)
    {
        $stid = oci_parse($con, $sql);

        // Preparar la sentencia
        if (!$stid) {
            
            //$msn_error = "CODE: ".mysqli_errno($con)."<br />";
            $msn_error = "CODE: "."Nº xxx"."<br />";
            $msn_error = $msn_error . "MESSAGE: ".oci_error($con)."<br />";

            $respuesta["error"] = $msn_error;
            $respuesta["resultado"] = "";

        }
        else
        {            
            // Realizar la lógica de la consulta
            $resultado = oci_execute($stid);        
            if (!$resultado) {

                //$msn_error = "CODE: ".mysqli_errno($con)."<br />";
                $msn_error = "CODE: "."Nº xxx"."<br />";
                $msn_error = $msn_error . "MESSAGE: ".oci_error($con)."<br />";

                $respuesta["error"] = $msn_error;
                $respuesta["resultado"] = "";
            
            }
            else
            {                
                $respuesta["error"] = "";
                $respuesta["resultado"] = $stid; // Este resultado se puede usar así:  while ($row = $resultado->fetch_assoc()){...}
            }
        }

        return $respuesta; 
    } */ 

    // ==================================================
    //  Funcion que ejecuta el SQL y retorna un CURSOR
    //      Esta funcion esta pensada para SQLs, 
    //      que retornen multiples lineas (1 o varias)
    // ==================================================
    //public function ejecutar($sql, $con)
    public function ejecutar($sql, $con, $auto_commit = true)
    {
        $stid = oci_parse($con, $sql);

        // Preparar la sentencia
        if (!$stid) {
            
            //$msn_error = "CODE: ".mysqli_errno($con)."<br />";
            $msn_error = "CODE: "."Nº xxx"."<br />";
            $msn_error = $msn_error . "MESSAGE: ".oci_error($con)."<br />";

            $respuesta["error"] = $msn_error;
            $respuesta["resultado"] = "";

        }
        else
        {            
            // Realizar la lógica de la consulta
            if($auto_commit == true)
            {
                $resultado = oci_execute($stid); 
            }
            else
            {
                $resultado = oci_execute($stid, OCI_NO_AUTO_COMMIT);                 
            }
                   
            if (!$resultado) {

                //$msn_error = "CODE: ".mysqli_errno($con)."<br />";
                $msn_error = "CODE: "."Nº xxx"."<br />";
                $msn_error = $msn_error . "MESSAGE: ".oci_error($con)."<br />";

                $respuesta["error"] = $msn_error;
                $respuesta["resultado"] = "";
            
            }
            else
            {                
                $respuesta["error"] = "";
                $respuesta["resultado"] = $stid; // Este resultado se puede usar así:  while ($row = $resultado->fetch_assoc()){...}
            }
        }

        return $respuesta; 
    }        

    public function rollback($con)
    {
        //$this->conexion->rollback();
        oci_rollback($con);
    }

    public function commit($con)
    {
        //$this->conexion->commit();
        oci_commit($con);
    }  

    public function autocommit($con, $status)
    { 
        
    } 

    public function liberar_recursos($result)
    {       
        oci_free_statement($result); 
    }

    public function proximo($result)//verifica existencia de registros
    {       
        $arreglo = oci_fetch_array($result, OCI_ASSOC+OCI_RETURN_NULLS);   
        return $arreglo;
    }    

    // ==================================================
    //  Funcion Valida Tabla
    // ==================================================
    public function escape_string($parametro, $con)
    {
        
    }

    // ==================================================
    //  Funcion Valida Tabla
    // ==================================================
    public function exist_table($database, $table, $con)
    {  
        $sql = "SELECT OWNER, TABLE_NAME FROM DBA_TABLES WHERE TABLE_NAME LIKE '%".strtoupper ($table)."%'";

        // Preparar la sentencia
        $stid = oci_parse($con, $sql); 

        // Manejar error en base de datos
        if (!$stid) {            
            return false;
        }
        else
        {
            // Realizar la lógica de la consulta
            $resultado = oci_execute($stid);        
            if (!$resultado) {

                return false;              
            }
            else
            {                
                $lista = array();
                $contador = 0;

                if ($row = $this->proximo($stid))
                {
                    DO
                    {
                        $lista [$contador]["OWNER"]      = $row[strtoupper ("OWNER")];
                        $lista [$contador]["TABLE_NAME"] = $row[strtoupper ("TABLE_NAME")];
                        
                        $contador++;
                    }
                    WHILE ($row = $this->proximo($stid));
                }

                if(Count($lista) > 0) 
                {
                    return true;
                }
                else
                {
                    return false;   
                }
            }
        }
    }    

    // ==================================================
    //  Funcion que ejecuta el SQL y retorna un ROW
    //      Esta funcion esta pensada para SQLs, 
    //      que retornen unicamente UNA sola línea
    // ==================================================
    public function get_Row($sql, $con)
    { 
        // Preparar la sentencia
        $stid = oci_parse($con, $sql); 

        // Manejar error en base de datos
        if (!$stid) {
            
            //$msn_error = "CODE: ".mysqli_errno($con)."<br />";
            $msn_error = "CODE: "."Nº xxx"."<br />";
            $msn_error = $msn_error . "MESSAGE: ".oci_error($con)."<br />";

            $respuesta["error"] = $msn_error;
            $respuesta["resultado"] = "";

        }
        else
        {
            // Realizar la lógica de la consulta
            $resultado = oci_execute($stid);        
            if (!$resultado) {

                //$msn_error = "CODE: ".mysqli_errno($con)."<br />";
                $msn_error = "CODE: "."Nº xxx"."<br />";
                $msn_error = $msn_error . "MESSAGE: ".oci_error($con)."<br />";

                $respuesta["error"] = $msn_error;
                $respuesta["resultado"] = "";
            
            }
            else
            {
                if($row = $resultado->fetch_assoc())
                {
                    $respuesta["resultado"] = $row;
                }
                else
                {            
                    $respuesta["resultado"] = array();
                }
            }          
        }
        return $respuesta;        
    }

    // ==================================================
    //  Funcion formato decimales
    // ==================================================
    public function formato_decimal($orden, $con)
    {  
        $sql = "ALTER SESSION SET NLS_NUMERIC_CHARACTERS = '$orden'";

        // Preparar la sentencia
        $stid = oci_parse($con, $sql); 

        // Manejar error en base de datos
        if (!$stid) {            
            return false;
        }
        else
        {
            // Realizar la lógica de la consulta
            $resultado = oci_execute($stid);        
            if (!$resultado) {
                return false;              
            }
            else
            { 
                return true;
            }
        }
    }    
    
}
?>
