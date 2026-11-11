<?php
$arreglousuario = $Model_usuario;

// BOTÓN CONSULTAR COLA
if(($model_btn == "1") && ($arreglousuario[0]["cola_consulta"] == 1))
{        
?>
<button class='btnaccion btn btn-primary btn-xs' id='btnsearch' name='btnsearch' type='button' title='Consultar' onclick="fn_search(<?php echo $id_registro; ?>)">    
        <span class='glyphicon glyphicon-search'></span>
        <span id='txt-btnsearch'></span>
</button>
<?php
}

// BOTÓN ANULAR COLA
if(($model_btn == "1") && ($arreglousuario[0]["cola_anular"] == 1) && ($estatus_registro == "EM") && ($est_fac_des == 0) && ($total_carga == 0))        
{
?>
<button class='btnaccion btn btn-danger btn-xs' id='btnannular' name='btnannular' type='button' title='Anular' onclick="fn_annular(<?php echo $id_registro; ?>)">            
        <span class='glyphicon img-btnclose'></span>
        <span id='txt-btnannular'></span>
</button> 
<?php
}

// BOTÓN CERRAR COLA
if(($model_btn == "1") && ($arreglousuario[0]["cola_anular"] == 1) && ($estatus_registro == "EM") && ($est_fac_des > 0) && ($total_carga < $capacidad))
{
?>
<button class='btnaccion btn btn-warning btn-xs' id='btnfinish' name='btnfinish' type='button' title='Finalizar control de cola' onclick="fn_finish(<?php echo $id_registro; ?>)">    
        <span class='glyphicon glyphicon glyphicon-off'></span>
        <span id='txt-btninfo'></span>
</button>
<?php
}
?>

