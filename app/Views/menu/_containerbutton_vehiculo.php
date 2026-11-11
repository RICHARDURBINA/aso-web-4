<?php
$arreglousuario = $Model_usuario;

// BOTÓN MODIFICAR VEHICULO
if(($model_btn == "1") && ($arreglousuario[0]["vehiculo_modificar"] == 1) && ($estatus_registro == "AC"))
{        
?>
<button class='btnaccion btn btn-warning btn-xs' id='btnupdate' name='btnupdate' type='button' title='Modificar' onclick="fn_update(<?php echo $id_registro; ?>)">    
        <span class='glyphicon glyphicon-edit'></span>
        <span id='txt-btnupdate'></span>
</button>
<?php
}

// BOTÓN ACTIVAR VEHICULO
if(($model_btn == "1") && ($arreglousuario[0]["vehiculo_registro"] == 1) && ($estatus_registro == "IN"))
{        
?>
<button class='btn btn-success btn-xs' id='btnactive' name='btnactive' type='button' title='Activar' onclick="fn_active(<?php echo $id_registro; ?>)">    
        <span class='glyphicon glyphicon-ok'></span>
        <span id='txt-btnactive'></span>
</button>
<?php
}

// BOTÓN INACTIVAR VEHICULO
if(($model_btn == "1") && ($arreglousuario[0]["vehiculo_anular"] == 1) && ($estatus_registro == "AC"))
{
?>
<button class='btnaccion btn btn-danger btn-xs' id='btnannular' name='btnannular' type='button' title='Inactivar' onclick="fn_annular(<?php echo $id_registro; ?>)">            
        <span class='glyphicon img-btnclose'></span>
        <span id='txt-btnannular'></span>
</button> 
<?php
}
?>

