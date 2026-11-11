$( document ).ready(function(){
  iniciarformulario();
});

function iniciarformulario() {
  $('#cmbtipocola').empty();
  $('#cmbtipocola').append(new Option('', '', true, true));
  llenarcombotipocola();

  $('#cmbtransportista').empty();
  $('#cmbtransportista').append(new Option('', '', true, true));
  llenarcombotransportista();

  $('#cmbchofer').empty();
  $('#cmbchofer').append(new Option('', '', true, true));
  llenarcombochofer();

  const fecha = new Date();  
  const hora = String(fecha.getHours()).padStart(2, '0') + ":" + String(fecha.getMinutes()).padStart(2, '0');
  
  document.forms["form1"].elements["txtfecha"].valueAsDate = fecha;
  document.forms["form1"].elements["txthora"].value = hora;

  const fechaActual = new Date();
  fechaActual.setDate(fechaActual.getDate() - 7);

  document.forms["form1"].elements["txtfecha"].min = fechaActual.toISOString().split('T')[0];
  document.forms["form1"].elements["operacion"].value = "1";
  document.forms["form1"].elements["cmbtipocola"].focus();
}

function llenarcombotipocola() {
  const datos = [
    { id: 'P', texto: 'PESADA' },
    { id: 'L', texto: 'LIVIANA' }
  ];

  const $miSelect = $('#cmbtipocola');
  $miSelect.empty();

  datos.forEach(item => {
    const nuevaOpcion = new Option(item.texto, item.id, false, false);
    $miSelect.append(nuevaOpcion).trigger('change');
  });

  $miSelect.val('');
  $miSelect.trigger('change');
}

function llenarcombotransportista() {
  var operacion = document.forms["form1"].elements["operacion"].value;

  $.ajax({
    type: "POST",
    url: baseurl + "TransportistaController/consultar_transportista",
    data: { txtcodigo : "%", txtnombre : "%", txtestatus : "%" },
    success: function( respuesta ){
      if (typeof respuesta === "string" && respuesta.includes("A PHP Error was encountered")) {
          alert(respuesta);
      }
      else {
        var respuesta = (typeof respuesta === "string") ? JSON.parse(respuesta) : respuesta;
        if (respuesta.resultado == "1") {
          $.each(respuesta.arreglo, function (i, item) {
            $('#cmbtransportista').append(new Option(item.de_transportista, item.co_transportista));
          });
        }
        else if (respuesta.resultado == "ERROR") {
          alert(respuesta.msn);
        }
      }
    },
    error: function(xhr, status, error) { 
      alert("Error de comunicación: " + error); 
    }
  });
}

function llenarcombochofer() {
  var operacion = document.forms["form1"].elements["operacion"].value;

  $.ajax({
    type: "POST",
    url: baseurl + "ChoferController/consultar_chofer",
    data: { txtid : "%", txtcodigo : "%", txtnombre : "%", txtestatus : "%" },
    success: function( respuesta ){
      if (typeof respuesta === "string" && respuesta.includes("A PHP Error was encountered")) {
          alert(respuesta);
      }
      else {
        var respuesta = (typeof respuesta === "string") ? JSON.parse(respuesta) : respuesta;
        if (respuesta.resultado == "1") {
          $.each(respuesta.arreglo, function (i, item) {
            $('#cmbchofer').append(new Option(item.de_chofer, item.id_chofer));
          });
        }
        else if (respuesta.resultado == "ERROR") {
          alert(respuesta.msn);
        }
      }
    },
    error: function(xhr, status, error) { 
      alert("Error de comunicación: " + error); 
    }
  });
}

function llenarcombovehiculo(cotipocola) {
  var operacion = document.forms["form1"].elements["operacion"].value;

  $.ajax({
    type: "POST",
    url: baseurl + "VehiculoController/consultar_vehiculo",
    data: { txtid : "%", txtcodigo : "%", cmbtipovehiculo : "%", cmbtipocola : cotipocola, txtestatus : "%" },
    success: function( respuesta ){
      if (typeof respuesta === "string" && respuesta.includes("A PHP Error was encountered")) {
          alert(respuesta);
      }
      else {
        var respuesta = (typeof respuesta === "string") ? JSON.parse(respuesta) : respuesta;
        if (respuesta.resultado == "1") {
          $.each(respuesta.arreglo, function (i, item) {
            $('#cmbvehiculo').append(new Option(item.de_vehiculo, item.id_vehiculo));
          });
        }
        else if (respuesta.resultado == "ERROR") {
          alert(respuesta.msn);
        }
      }
    },
    error: function(xhr, status, error) { 
      alert("Error de comunicación: " + error); 
    }
  });
}

$('#cmbtipocola').on('change', function() {  
  var operacion = document.forms["form1"].elements["operacion"].value;
  if(operacion == '1') {
    if(!(document.forms["form1"].elements["cmbtipocola"].value == "")) {
      var cotipocola = document.forms["form1"].elements["cmbtipocola"].value;
      $('#cmbvehiculo').empty();
      $('#cmbvehiculo').append(new Option('', '', true, true));
      llenarcombovehiculo(cotipocola);      
    }
  }
});

$("#btnsave").click(function () {
  if(validar_form() == true) {
    document.forms["form1"].elements["btnsave"].disabled = true;
    $("#btnclose_").focus();

    if (confirm('\u00BFEsta seguro de guardar el registro de control de cola?')) {
      var operacion = document.forms["form1"].elements["operacion"].value;
      var str = $("#form1").serialize();

      if (operacion == '1') {
        $.ajax({
          type: "POST",
          url: baseurl + "ColaController/guardar_cola",
          data: str,
          success: function (respuesta) {
            if (typeof respuesta === "string" && respuesta.includes("A PHP Error was encountered")) {
                alert(respuesta);
            }
            else {
              var respuesta = (typeof respuesta === "string") ? JSON.parse(respuesta) : respuesta;
              if (respuesta.resultado == "1") {
                alert("Registro satisfactorio");
                window.location.href = baseurl + "ColaController/cola/";
              }
              else if (respuesta.resultado == "ERROR") {
                alert(respuesta.msn);
                document.forms["form1"].elements["btnsave"].disabled = false;
              }
            }
          },
          error: function(xhr, status, error) { 
            alert("Error de comunicación: " + error);
            document.forms["form1"].elements["btnsave"].disabled = false;
          }
        });
      }
    }
    else {
       document.forms["form1"].elements["btnsave"].disabled = false;
    }
  }
});

function validar_form() {
  if(document.forms["form1"].elements["cmbtipocola"].value == "") {
    alert('Ingrese el tipo de cola');
    document.forms["form1"].elements["cmbtipocola"].focus();
    return (false);
  }
  if (document.forms["form1"].elements["txtfecha"].value.length < 1) {
    alert('Indique la fecha reportada');
    document.forms["form1"].elements["txtfecha"].focus();
    return (false);
  }
  if (document.forms["form1"].elements["txthora"].value.length < 1) {
    alert('Indique la hora reportada');
    document.forms["form1"].elements["txthora"].focus();
    return (false);
  }
  if(document.forms["form1"].elements["cmbtransportista"].value == "") {
    alert('Ingrese la empresa transportista');
    document.forms["form1"].elements["cmbtransportista"].focus();
    return (false);
  }
  if(document.forms["form1"].elements["cmbchofer"].value == "") {
    alert('Ingrese el chofer');
    document.forms["form1"].elements["cmbchofer"].focus();
    return (false);
  }
  if(document.forms["form1"].elements["cmbvehiculo"].value == "") {
    alert('Ingrese el vehiculo');
    document.forms["form1"].elements["cmbvehiculo"].focus();
    return (false);
  }
  return (true);
}

$("#btnclose_").click(function () {
    window.location.href = baseurl + "ColaController/cola/";
});