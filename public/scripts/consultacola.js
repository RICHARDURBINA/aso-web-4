$( document ).ready(function(){
  iniciarformulario(); 
});

function iniciarformulario() {
  document.forms["form1"].elements["operacion"].value = "1"; 
  consultar_cola();
}

function consultar_cola() {
  var id_cola_web = document.forms["form1"].elements["id_cola_web"].value;
 
  $.ajax({
    type: "POST",
    url: baseurl + "ColaController/consultar_cola",
    data: {id_cola_web : id_cola_web},
    success: function (respuesta) {
      if (typeof respuesta === "string" && respuesta.includes("A PHP Error was encountered")) {
          alert(respuesta);
      }
      else {
        var respuesta = (typeof respuesta === "string") ? JSON.parse(respuesta) : respuesta;
        if (respuesta.resultado == "1") {
          $('#form1')[0].reset();
          document.forms["form1"].elements["operacion"].value = "2";

          if(respuesta.Model_consultar_cola[0]["ti_cola"] == "L") {
            document.forms["form1"].elements["cmbtipocola"].value = "LIVIANA";
          }
          if(respuesta.Model_consultar_cola[0]["ti_cola"] == "P") {
            document.forms["form1"].elements["cmbtipocola"].value = "PESADA";
          }

          var hora = respuesta.Model_consultar_cola[0]["fe_reporte_form"].substring(11);

          document.forms["form1"].elements["txtfecha"].value = respuesta.Model_consultar_cola[0]["fe_emision"];          
          document.forms["form1"].elements["txthora"].value = hora;
          document.forms["form1"].elements["cmbtransportista"].value = respuesta.Model_consultar_cola[0]["nb_transportista"];
          document.forms["form1"].elements["cmbchofer"].value = respuesta.Model_consultar_cola[0]["nb_chofer"];
          document.forms["form1"].elements["cmbvehiculo"].value = respuesta.Model_consultar_cola[0]["co_vehiculo"];
          document.forms["form1"].elements["txtkilometraje"].value = respuesta.Model_consultar_cola[0]["kilometraje"];
          document.forms["form1"].elements["txtobs"].value = respuesta.Model_consultar_cola[0]["tx_observacion"];
        }
        else if (respuesta.resultado == "0") {
          alert("No retornaron datos esperados");
          window.location.href = baseurl + "ColaController/listacola/";
        }
        else if (respuesta.resultado == "ERROR") {
          alert(respuesta.msn);
          window.location.href = baseurl + "ColaController/listacola/";
        }      
        else {
          alert("No retornaron datos esperados");
          window.location.href = baseurl + "ColaController/listacola/";
        }
      }
    },
    error: function(xhr, status, error) { 
      alert("Error de comunicación: " + error); 
    }
  });
}

$("#btnclose_").click(function () {
    window.location.href = baseurl + "ColaController/listacola/";
});