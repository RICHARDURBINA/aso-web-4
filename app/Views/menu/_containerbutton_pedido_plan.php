<?php
$arreglousuario = $Model_usuario;

// BOTÓN APROBAR PLAN
if(($model_btn == "1") && ($arreglousuario[0]["plan_registro"] == 1) && ($estatus_registro == "APROBADO"))        
{
?>
<button class='btnaccion btn btn-success btn-xs' id='btnapprove' name='btnapprove' type='button' title='Planificar Pedido' onclick="fn_approve(<?php echo $id_registro; ?>)">            
        <span class='glyphicon glyphicon-ok'></span>
        <span id='txt-btnapprove'></span>
</button> 
<?php
}
?>
