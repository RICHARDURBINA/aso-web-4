//===============================================================================================================================================
//
//===============================================================================================================================================
$(function() {
	hideshow('form1');
});

//===============================================================================================================================================
//  MOSTRAR U OCULTAR CAMPO PASSWORD
//===============================================================================================================================================
function mostrarcampo(formulario, campo, icono)
{           
    var contenido = document.getElementById(campo); 
    
    //alert(contenido);
    var atributo = contenido.getAttribute("type");

    if(atributo=="password")
    {
        //alert("a1");
        contenido.setAttribute("type","text");   

		document.getElementById(icono).classList.remove('ri-eye-off-line'); 
		document.getElementById(icono).classList.add('ri-eye-line'); 

        document.getElementById(campo).focus();
    }
    else
    {
        //alert("a2");
        contenido.setAttribute("type","password");      
        
        document.getElementById(icono).classList.remove('ri-eye-line'); 
        document.getElementById(icono).classList.add('ri-eye-off-line'); 		

        document.getElementById(campo).focus();
    }
}

//===============================================================================================================================================
//
//===============================================================================================================================================
function mostrarmsn(formulario, opcion) {
    if (formulario == 'form1') {
        var operacion = document.form1.operacion.value;

        if (opcion == "0001") {
            alert("Error al tratar de establecer la conexión");
        }

        else if (opcion == "0002") {
        	alert("Usuario/Clave Incorrecta");
        }

        else if (opcion == "0003") {
        	alert("Error no controlado");
        }
    }
}

//===============================================================================================================================================
//
//===============================================================================================================================================
function enviar(formulario)
{        
    if(formulario == 'form1') 
	{	
        const form = document.getElementById('form1');	    
	    
		if (form.checkValidity()) {
		    var operacion = document.form1.operacion.value;
		    var str = $("#form1").serialize();
	        
	        //INICIAR SESION 
		    if (operacion == '3') { 
				//console.log(baseurl);
				document.getElementById("form1btnenviar").disabled = true;

				$.ajax({
				    type: "POST",
				    url: baseurl + "LoginController/iniciar_sesion",
				    data: str,
				    success: function (respuesta) {
				        
				        // Como el controlador envía json_encode (texto plano), 
				        // debemos convertirlo explícitamente a objeto con JSON.parse:
				        var res = JSON.parse(respuesta);

				        if (res.resultado == "1") {
				            // Inicio satisfactorio ENVIAR A PAGINA PRINCIPAL
				            window.location.href = baseurl + "MenuController/menu";
				        }   
				        else if (res.resultado == "ERROR") {
				            // Aquí capturamos y mostramos cualquier error (incluyendo class_first.txt malo)
				            alert("Error del Sistema: " + res.msn);
				            document.getElementById("form1btnenviar").disabled = false;
				        }
				        else if (res.resultado == "0001") {
				            mostrarmsn(formulario, "0001");
				            document.getElementById("form1btnenviar").disabled = false;
				        }
				        else if (res.resultado == "0002") {
				            mostrarmsn(formulario, "0002");
				            document.getElementById("form1btnenviar").disabled = false;
				        }
				        else if (res.resultado == "0003") {
				            mostrarmsn(formulario, "0003");
				            document.getElementById("form1btnenviar").disabled = false;
				        }
				    },
				    error: function(xhr, status, error) {
				        alert("Error crítico de comunicación con el servidor: " + error);
				        document.getElementById("form1btnenviar").disabled = false;
				    }
				});
		    }
		} 
	}
}


//===============================================================================================================================================
//
//===============================================================================================================================================
function onPress_enter(formulario) {
    var keyPressed = event.keyCode || event.which;

    if (keyPressed == 13) {

        /*if (formulario.name == "form1") {
            keyPressed = null;
            var obj = document.form1.form1btnenviar;
            obj.click();
        }*/
    }
    else {
        return false;
    }
}

//===============================================================================================================================================
//
//===============================================================================================================================================
function hideshow(formulario)
{			
	if(formulario == "form1")
	{
		$('#form1').fadeIn(500);
		//document.form1.style.display="block";		
		//document.form2.style.display="none";
		//document.form3.style.display="none";
		//document.form4.style.display="none";

		document.forms["form1"].reset();	
		document.forms["form1"].elements["cmbempresa"].style.display = 'none';
		document.forms["form1"].elements["cmbempresa"].value = "WEB";
		document.forms["form1"].elements["txtusuario"].focus();
	}
}

