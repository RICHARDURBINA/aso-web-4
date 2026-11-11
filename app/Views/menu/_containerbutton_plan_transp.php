<?php
$arreglousuario = $Model_usuario;

// BOTÓN ASOCIAR TRANSPORTE
if(($model_btn == "1") && ($arreglousuario[0]["plan_asociar"] == 1) && ($estatus_registro == "APROBADO") && ($id_control_cola == 0) && ($fe_plan >= date('d/m/Y')) )
//if(($model_btn == "1") && ($arreglousuario[0]["plan_asociar"] == 1) && ($estatus_registro == "APROBADO") && ($estatus_pedido == "APROBADO") && ($id_control_cola == 0) && ($fe_plan >= date('d/m/Y')) )
{
?>
<button class='btnaccion btn btn-success btn-xs' id='btnapprove' name='btnapprove' type='button' title='Asignar transporte' onclick="fn_approve(<?php echo $id_registro; ?>)">            
        <span class='glyphicon glyphicon-plus'></span>
        <span id='txt-btnapprove'></span>
</button> 
<?php
}

// BOTÓN DESASOCIAR TRANSPORTE 
if( ($model_btn == "1") && ($arreglousuario[0]["plan_desasociar"] == 1) && ($estatus_registro == "APROBADO") && ($estatus_pedido == "APROBADO" || $estatus_pedido == "FACTURADO") && ($id_control_cola != 0))
//if( ($model_btn == "1") && ($arreglousuario[0]["plan_desasociar"] == 1) && ($estatus_registro == "APROBADO") && ($id_control_cola != 0))        
{
?>
<button class='btnaccion btn btn-warning btn-xs' id='btnupdate' name='btnupdate' type='button' title='Quitar transporte' onclick="fn_update(<?php echo $id_registro; ?>)">    
        <span class='glyphicon glyphicon-minus'></span>
        <span id='txt-btnupdate'></span>
</button>
<?php
}

if( (($co_empresa == "ADESA" AND $arreglousuario[0]["cobro_adesa"] == "1")) || (($co_empresa == "AA1" AND $arreglousuario[0]["cobro_aai"] == "1")) )
{ 
        // BOTÓN ANULAR PLAN
        if(($model_btn == "1") && ($arreglousuario[0]["plan_anular"] == 1) && ($estatus_registro == "APROBADO")  && ($estatus_pedido == "APROBADO") && ($id_control_cola == 0)) 
        {
        ?>
        <button class='btnaccion btn btn-danger btn-xs' id='btnannular' name='btnannular' type='button' title='Anular Planificaci&oacute;n' onclick="fn_annular(<?php echo $id_registro; ?>)">            
                <span class='glyphicon img-btnclose'></span>
                <span id='txt-btnannular'></span>
        </button> 
        <?php
        }
}

// BOTÓN SINCRONIZAR TRASLADO MANUAL DE CHOFER Y VEHICULO
if( ($model_btn == "1") && 
    (($arreglousuario[0]["plan_asociar"] == 1) || ($arreglousuario[0]["plan_desasociar"] == 1)) && 
    ($estatus_registro == "APROBADO") && 
    ($estatus_pedido == "APROBADO") && 
    ($id_control_cola != 0) && 
    ($fe_plan >= date('d/m/Y')) &&
    ($sincronizado != "S") )
{
?>
<button class='btnaccion btn btn-info btn-xs' id='btnmove' name='btnmove' type='button' title='Sincronizar' onclick="fn_move(<?php echo $id_registro; ?>)">            
        <span class='glyphicon glyphicon-refresh'></span>
        <span id='txt-btnmove'></span>
</button> 
<?php
}
// BOTÓN APLICAR NOTA DE CREDITO
if( ($model_btn == "1") && 
    ($arreglousuario[0]["plan_aplicar_nc"] == 1) && 
    ($estatus_registro == "APROBADO") && 
    ($fe_plan >= date('d/m/Y')) &&
    ($total_fac > 0) )
{
        
?>
<button class='btnaccion btn btn-secondary btn-xs' id='btnnc' name='btnnc' type='button' title='Aplicar NC Total' onclick="fn_nc_total(<?php echo $id_registro; ?>)">            
        <span class='glyphicon glyphicon-file'></span>
        <span id='txt-btnnc'></span>
</button> 
<?php
}
?>



