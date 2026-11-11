<?php

$arreglousuario = $Model_usuario;

if( ($arreglousuario[0]["chofer_registro"] == 1) || ($arreglousuario[0]["vehiculo_registro"] == 1) )
{
?>
	<button id='btnadd' name='btnadd' type='button' class='btn btn-success me-4 waves-effect waves-light' title='Agregar'>
        <span class='glyphicon glyphicon-plus' id='img-btnaddtab_1'></span>
    </button>

<?php
}
?>