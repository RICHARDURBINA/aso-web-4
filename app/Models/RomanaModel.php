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

class RomanaModel extends Model {		

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
	public function consultar_NOR( $par_fecha_desde,
	                               $par_fecha_hasta,
	                               $par_condicion,
	                               $par_idusuario )
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();
		
		$query_1 = "SELECT A.NU_NOTA_ENTRADA,
					       A.FE_EMISION,
					       A.NU_TICKET,
					       A.CO_INSTALACION_EQUIPO,
					       A.NB_INSTALACION_EQUIPO,
					       A.CO_PRODUCTO,
					       A.NB_PRODUCTO,
					       A.CA_PRODUCTO,
					       A.CO_UNIDAD_MEDIDA,
					       A.NU_GUIA,
					       A.TI_GUIA,
					       A.CO_PROVEEDOR_GUIA,
					       A.NB_PROVEEDOR_GUIA,
					       A.CO_CLIENTE_GUIA,
					       A.NB_CLIENTE_GUIA,
					       A.CO_TRANSPORTISTA_GUIA,
					       A.NB_TRANSPORTISTA_GUIA,
					       A.CO_PROPIETARIO_GUIA,
					       A.NB_PROPIETARIO_GUIA,       
					       A.TOTAL_EN_PATIO					                 
					FROM WEB_ROMANA_NOR A
					WHERE A.FE_EMISION >= to_date('$par_fecha_desde','yyyy-mm-dd')
					  AND A.FE_EMISION <= to_date('$par_fecha_hasta','yyyy-mm-dd')";

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
					$lista [$contador]["NU_NOTA_ENTRADA"]       = $row[$ejecutar->col_db("NU_NOTA_ENTRADA")];
					$lista [$contador]["FE_EMISION"]            = $row[$ejecutar->col_db("FE_EMISION")];
					$lista [$contador]["NU_TICKET"]             = $row[$ejecutar->col_db("NU_TICKET")];
					$lista [$contador]["CO_INSTALACION_EQUIPO"] = $row[$ejecutar->col_db("CO_INSTALACION_EQUIPO")];
					$lista [$contador]["NB_INSTALACION_EQUIPO"] = $row[$ejecutar->col_db("NB_INSTALACION_EQUIPO")];
					$lista [$contador]["CO_PRODUCTO"]           = $row[$ejecutar->col_db("CO_PRODUCTO")];
					$lista [$contador]["NB_PRODUCTO"]           = $row[$ejecutar->col_db("NB_PRODUCTO")];
					$lista [$contador]["CA_PRODUCTO"]           = $row[$ejecutar->col_db("CA_PRODUCTO")];
					$lista [$contador]["CO_UNIDAD_MEDIDA"]      = $row[$ejecutar->col_db("CO_UNIDAD_MEDIDA")];

					$lista [$contador]["NU_GUIA"]               = $row[$ejecutar->col_db("NU_GUIA")];
					$lista [$contador]["TI_GUIA"]               = $row[$ejecutar->col_db("TI_GUIA")];
					$lista [$contador]["CO_PROVEEDOR_GUIA"]     = $row[$ejecutar->col_db("CO_PROVEEDOR_GUIA")];
					$lista [$contador]["NB_PROVEEDOR_GUIA"]     = $row[$ejecutar->col_db("NB_PROVEEDOR_GUIA")];
					$lista [$contador]["CO_CLIENTE_GUIA"]       = $row[$ejecutar->col_db("CO_CLIENTE_GUIA")];
					$lista [$contador]["NB_CLIENTE_GUIA"]       = $row[$ejecutar->col_db("NB_CLIENTE_GUIA")];
					$lista [$contador]["CO_TRANSPORTISTA_GUIA"] = $row[$ejecutar->col_db("CO_TRANSPORTISTA_GUIA")];
					$lista [$contador]["NB_TRANSPORTISTA_GUIA"] = $row[$ejecutar->col_db("NB_TRANSPORTISTA_GUIA")];
					$lista [$contador]["CO_PROPIETARIO_GUIA"]   = $row[$ejecutar->col_db("CO_PROPIETARIO_GUIA")];
					$lista [$contador]["NB_PROPIETARIO_GUIA"]   = $row[$ejecutar->col_db("NB_PROPIETARIO_GUIA")];
					$lista [$contador]["TOTAL_EN_PATIO"]        = $row[$ejecutar->col_db("TOTAL_EN_PATIO")];	
										
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
	public function consultar_NOE_ALM( $par_fecha_desde,
	                                   $par_fecha_hasta,
	                                   $par_condicion,
	                                   $par_idusuario )
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();
		
		$query_1 = "SELECT A.NU_BOLETO_PESAJE,
					       A.NU_NOTA_ENTRADA,
					       A.NU_LOTE_PRODUCTO,
					       A.CO_ALMACEN_NOE,
					       A.NB_ALMACEN_NOE,
					       A.CO_TIPO_ALMACEN,
					       A.CO_PRODUCTO_NOE,
					       A.NB_PRODUCTO_NOE,
					       A.CA_PRODUCTO_NOE,
					       A.CO_UNIDAD_MEDIDA_NOE,
					       A.HMD,
					       A.IMP,
					       A.GDT,
					       A.GPT,
					       A.GCS,
					       A.GAM,
					       A.PAF,
					       A.MZC, 
					       A.PC_CONDICION
					FROM WEB_ROMANA_NOE_ALM A
					WHERE A.FE_EMISION >= to_date('$par_fecha_desde','yyyy-mm-dd')
					  AND A.FE_EMISION <= to_date('$par_fecha_hasta','yyyy-mm-dd')
					  AND A.PC_CONDICION  LIKE '$par_condicion'";

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
					$lista [$contador]["NU_BOLETO_PESAJE"]     = $row[$ejecutar->col_db("NU_BOLETO_PESAJE")];
					$lista [$contador]["NU_NOTA_ENTRADA"]      = $row[$ejecutar->col_db("NU_NOTA_ENTRADA")];
					$lista [$contador]["NU_LOTE_PRODUCTO"]     = $row[$ejecutar->col_db("NU_LOTE_PRODUCTO")];

					$lista [$contador]["CO_ALMACEN_NOE"]       = $row[$ejecutar->col_db("CO_ALMACEN_NOE")];
					$lista [$contador]["NB_ALMACEN_NOE"]       = $row[$ejecutar->col_db("NB_ALMACEN_NOE")];
					$lista [$contador]["CO_TIPO_ALMACEN"]      = $row[$ejecutar->col_db("CO_TIPO_ALMACEN")];
					$lista [$contador]["CO_PRODUCTO_NOE"]      = $row[$ejecutar->col_db("CO_PRODUCTO_NOE")];
					$lista [$contador]["NB_PRODUCTO_NOE"]      = $row[$ejecutar->col_db("NB_PRODUCTO_NOE")];
					$lista [$contador]["CA_PRODUCTO_NOE"]      = $row[$ejecutar->col_db("CA_PRODUCTO_NOE")];
					$lista [$contador]["CO_UNIDAD_MEDIDA_NOE"] = $row[$ejecutar->col_db("CO_UNIDAD_MEDIDA_NOE")];
					$lista [$contador]["CO_NB_ALMACEN_NOE"]    = "(" . $row[$ejecutar->col_db("CO_ALMACEN_NOE")] . ") - " . $row[$ejecutar->col_db("NB_ALMACEN_NOE")];

					$lista [$contador]["HMD"] = $row[$ejecutar->col_db("HMD")];
					$lista [$contador]["IMP"] = $row[$ejecutar->col_db("IMP")];
					$lista [$contador]["GDT"] = $row[$ejecutar->col_db("GDT")];
					$lista [$contador]["GPT"] = $row[$ejecutar->col_db("GPT")];
					$lista [$contador]["GCS"] = $row[$ejecutar->col_db("GCS")];
					$lista [$contador]["GAM"] = $row[$ejecutar->col_db("GAM")];
					$lista [$contador]["PAF"] = $row[$ejecutar->col_db("PAF")];
					$lista [$contador]["MZC"] = $row[$ejecutar->col_db("MZC")];
					$lista [$contador]["PC_CONDICION"] = $row[$ejecutar->col_db("PC_CONDICION")];					
										
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
	public function consultar_Control( $par_fecha_desde,
		                               $par_fecha_hasta,
		                               $par_condicion,
		                               $par_idusuario )
	{
		$class_control = $this->get_control();
		$ejecutar = new $class_control();
		
		$query_1 = "SELECT A.ID_LOTE_PRODUCTO,
					       A.NU_LOTE_PRODUCTO,
					       A.NU_NOTA_RECEPCION,
					       A.FE_NOR,
					       A.NU_TICKET, 
					       A.CO_TRANSPORTISTA_NOR,
					       A.NB_TRANSPORTISTA_NOR,
					       A.CO_CHOFER_NOR,
					       A.NB_CHOFER_NOR,
					       A.CO_VEHICULO,
					       A.CO_PROPIETARIO_NOR,
					       A.NB_PROPIETARIO_NOR,  
					       A.CO_ORGANIZACION_NOR,
					       A.NB_ORGANIZACION_NOR,
					       A.CO_PRODUCTO,
					       A.NB_PRODUCTO,
					       A.ID_BOLETO_NOR,
					       A.NU_BOLETO_NOR,         
					       A.FH_INICIAL,
					       A.FH_FINAL,
					       A.CA_PESO_INICIAL,
					       A.CA_PESO_FINAL,  
					       A.NU_NOTA_ENTRADA,
					       A.CA_PRODUCTO_NOE,
					       A.CO_UNIDAD_MEDIDA,
					       A.CO_ALMACEN,
					       A.NB_ALMACEN,
					       A.HMD,
					       A.IMP,
					       A.TIEMPO_DESCARGA_SEGUNDOS,
					       A.TIEMPO_DESCARGA_HMS		              
					FROM WEB_ROMANA_CONTROL A
					WHERE A.FE_NOR >= to_date('$par_fecha_desde','yyyy-mm-dd')
					  AND A.FE_NOR <= to_date('$par_fecha_hasta','yyyy-mm-dd')";
		
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
					$lista [$contador]["ID_LOTE_PRODUCTO"]     = $row[$ejecutar->col_db("ID_LOTE_PRODUCTO")];
					$lista [$contador]["NU_LOTE_PRODUCTO"]     = $row[$ejecutar->col_db("NU_LOTE_PRODUCTO")];
					$lista [$contador]["NU_NOTA_RECEPCION"]    = $row[$ejecutar->col_db("NU_NOTA_RECEPCION")];
					$lista [$contador]["FE_NOR"]               = $row[$ejecutar->col_db("FE_NOR")];
					$lista [$contador]["NU_TICKET"]            = $row[$ejecutar->col_db("NU_TICKET")];
					$lista [$contador]["CO_TRANSPORTISTA_NOR"] = $row[$ejecutar->col_db("CO_TRANSPORTISTA_NOR")];
					$lista [$contador]["NB_TRANSPORTISTA_NOR"] = $row[$ejecutar->col_db("NB_TRANSPORTISTA_NOR")];
					$lista [$contador]["CO_CHOFER_NOR"]        = $row[$ejecutar->col_db("CO_CHOFER_NOR")];
					$lista [$contador]["NB_CHOFER_NOR"]        = $row[$ejecutar->col_db("NB_CHOFER_NOR")];
					$lista [$contador]["CO_VEHICULO"]          = $row[$ejecutar->col_db("CO_VEHICULO")];
					$lista [$contador]["CO_PROPIETARIO_NOR"]   = $row[$ejecutar->col_db("CO_PROPIETARIO_NOR")];
					$lista [$contador]["NB_PROPIETARIO_NOR"]   = $row[$ejecutar->col_db("NB_PROPIETARIO_NOR")];
					$lista [$contador]["CO_ORGANIZACION_NOR"]  = $row[$ejecutar->col_db("CO_ORGANIZACION_NOR")];
					$lista [$contador]["NB_ORGANIZACION_NOR"]  = $row[$ejecutar->col_db("NB_ORGANIZACION_NOR")];
					$lista [$contador]["CO_PRODUCTO"]          = $row[$ejecutar->col_db("CO_PRODUCTO")];
					$lista [$contador]["NB_PRODUCTO"]          = $row[$ejecutar->col_db("NB_PRODUCTO")];
					$lista [$contador]["ID_BOLETO_NOR"]        = $row[$ejecutar->col_db("ID_BOLETO_NOR")];
					$lista [$contador]["NU_BOLETO_NOR"]        = $row[$ejecutar->col_db("NU_BOLETO_NOR")];
					$lista [$contador]["FH_INICIAL"]           = $row[$ejecutar->col_db("FH_INICIAL")];
					$lista [$contador]["FH_FINAL"]             = $row[$ejecutar->col_db("FH_FINAL")];
					$lista [$contador]["CA_PESO_INICIAL"]      = $row[$ejecutar->col_db("CA_PESO_INICIAL")];
					$lista [$contador]["CA_PESO_FINAL"]        = $row[$ejecutar->col_db("CA_PESO_FINAL")];
					$lista [$contador]["NU_NOTA_ENTRADA"]      = $row[$ejecutar->col_db("NU_NOTA_ENTRADA")];
					$lista [$contador]["CA_PRODUCTO_NOE"]      = $row[$ejecutar->col_db("CA_PRODUCTO_NOE")];
					$lista [$contador]["CO_UNIDAD_MEDIDA"]     = $row[$ejecutar->col_db("CO_UNIDAD_MEDIDA")];
					$lista [$contador]["CO_ALMACEN"]           = $row[$ejecutar->col_db("CO_ALMACEN")];
					$lista [$contador]["NB_ALMACEN"]           = $row[$ejecutar->col_db("NB_ALMACEN")];
					$lista [$contador]["HMD"]                  = $row[$ejecutar->col_db("HMD")];
					$lista [$contador]["IMP"]                  = $row[$ejecutar->col_db("IMP")];

					$lista [$contador]["TIEMPO_DESCARGA_SEGUNDOS"] = $row[$ejecutar->col_db("TIEMPO_DESCARGA_SEGUNDOS")];
					$lista [$contador]["TIEMPO_DESCARGA_HMS"] = $row[$ejecutar->col_db("TIEMPO_DESCARGA_HMS")];
										
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