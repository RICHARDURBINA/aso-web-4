<?php
$arreglousuario = $Model_usuario;

// BOTÓN CONSULTAR VISITA
if(($model_btn == "1") && ($arreglousuario[0]["visita_consulta"] == 1))
{        
?>
<button class='btnaccion btn btn-primary btn-xs' id='btnsearch' name='btnsearch' type='button' title='Consultar' onclick="fn_search(<?php echo $id_registro; ?>)">    
        <span class='glyphicon glyphicon-search'></span>
        <span id='txt-btnsearch'></span>
</button>
<?php
}

// BOTÓN ANULAR VISITA
if(($model_btn == "1") && ($arreglousuario[0]["visita_anular"] == 1) && ($estatus_registro == "EMITIDO"))
{
?>
<button class='btnaccion btn btn-danger btn-xs' id='btnannular' name='btnannular' type='button' title='Anular' onclick="fn_annular(<?php echo $id_registro; ?>)">            
        <span class='glyphicon img-btnclose'></span>
        <span id='txt-btnannular'></span>
</button> 
<?php
}
?>

