//*****************************************************************************
//
//*****************************************************************************
function fn_trasladar_ordenes() 
{
    if (confirm('\u00BFEsta seguro de trasladar las ordenes?')) 
    {
        $.ajax({
            type: "POST",
            url: baseurl + "PedidoController/trasladar_ordenes",
            data: { },
            success: function (respuesta) 
            {
                // Como respuesta ya es un objeto JSON, evaluamos directamente:
                if (respuesta.resultado == "1") 
                {
                    alert("Proceso satisfactorio");            
                }
                else if (respuesta.resultado == "ERROR") 
                {
                    alert("Error: " + respuesta.msn);
                }
                else 
                {
                    alert("Respuesta inesperada del servidor");
                }
            },
            error: function(xhr, status, error) 
            {
                alert("Error crítico de comunicación con el servidor: " + error);
            }
        });
    }
}