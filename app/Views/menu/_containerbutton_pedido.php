<?php
$arreglousuario = $Model_usuario;

// BOTÓN INFORMACION PEDIDO EMPRESA
if(($model_btn == "1") && ($arreglousuario[0]["pedido_consulta"] == 1) && (!empty($id_referencia_aso)) && ($estatus_registro != "PROGRAMADO") && ($estatus_registro != "EMITIDO") && ($estatus_registro != "ANULADO"))
{        
?>
<button class='btnaccion btn btn-warning btn-xs' id='btninfo' name='btninfo' type='button' title='Información' onclick="fn_info(<?php echo $id_registro.",".$id_referencia_aso; ?>)">    
        <span class='glyphicon glyphicon-list-alt'></span>
        <span id='txt-btninfo'></span>
</button>
<?php
}

// BOTÓN CONSULTAR PEDIDO
if(($model_btn == "1") && ($arreglousuario[0]["pedido_consulta"] == 1))
{        
?>
<button class='btnaccion btn btn-primary btn-xs' id='btnsearch' name='btnsearch' type='button' title='Consultar' onclick="fn_search(<?php echo $id_registro; ?>)">    
        <span class='glyphicon glyphicon-search'></span>
        <span id='txt-btnsearch'></span>
</button>
<?php
}

// BOTÓN APROBAR PEDIDO
if(($model_btn == "1") && ($arreglousuario[0]["pedido_aprobar"] == 1) && ($estatus_registro == "EMITIDO"))
{
?>
<button class='btnaccion btn btn-success btn-xs' id='btnapprove' name='btnapprove' type='button' title='Aprobar' onclick="fn_approve(<?php echo $id_registro; ?>)">            
        <span class='glyphicon glyphicon-ok'></span>
        <span id='txt-btnapprove'></span>
</button> 
<?php
}

// BOTÓN ANULAR PEDIDO
if(($model_btn == "1") && ($arreglousuario[0]["pedido_anular"] == 1) && ($estatus_registro == "PROGRAMADO") && ($estatus_aux_registro == 0))
{
?>
<button class='btnaccion btn btn-danger btn-xs' id='btnannular' name='btnannular' type='button' title='Anular' onclick="fn_annular(<?php echo $id_registro; ?>)">            
        <span class='glyphicon img-btnclose'></span>
        <span id='txt-btnannular'></span>
</button> 
<?php
}

// BOTÓN TRASLADO MANUAL PEDIDO
if(($model_btn == "1") && ($arreglousuario[0]["pedido_traslado"] == 1) && ($estatus_registro == "PROGRAMADO"))
{
?>
<button class='btnaccion btn btn-info btn-xs' id='btnmove' name='btnmove' type='button' title='Trasladar' onclick="fn_move(<?php echo $id_registro; ?>)">            
        <span class='glyphicon glyphicon-refresh'></span>
        <span id='txt-btnmove'></span>
</button> 
<?php
}
?>

