<?php
$arreglousuario = $Model_usuario;

// BOTÓN CONSULTAR COBRANZA
if(($model_btn == "1") && ($arreglousuario[0]["cobranza_consulta"] == 1))
{        
?>
<button class='btnaccion btn btn-primary btn-xs' id='btnsearch' name='btnsearch' type='button' title='Consultar' onclick="fn_search(<?php echo $id_registro; ?>)">    
        <span class='glyphicon glyphicon-search'></span>
        <span id='txt-btnsearch'></span>
</button>
<?php
}

// BOTÓN MODIFICAR COBRANZA
//if(($model_btn == "1") && ($arreglousuario[0]["cobranza_modificar"] == 1) && ($mont_pendiente > 0) && ($estatus_registro == "EMITIDO"))
if(($model_btn == "1") && ($arreglousuario[0]["cobranza_modificar"] == 1)  && ($estatus_registro == "EMITIDO"))
{        
?>
<button class='btnaccion btn btn-warning btn-xs' id='btnupdate' name='btnupdate' type='button' title='Modificar' onclick="fn_update(<?php echo $id_registro; ?>)">    
        <span class='glyphicon glyphicon-edit'></span>
        <span id='txt-btnupdate'></span>
</button>
<?php
}

// BOTÓN ANULAR COBRANZA
if(($model_btn == "1") && ($arreglousuario[0]["cobranza_anular"] == 1) && ($estatus_registro == "EMITIDO"))
{
?>
<button class='btnaccion btn btn-danger btn-xs' id='btnannular' name='btnannular' type='button' title='Anular' onclick="fn_annular(<?php echo $id_registro; ?>)">            
        <span class='glyphicon img-btnclose'></span>
        <span id='txt-btnannular'></span>
</button> 
<?php
}
?>