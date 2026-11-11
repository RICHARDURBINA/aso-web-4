var current, current_step, next_step, steps;

$( document ).ready(function(){
  if ($.fn.DataTable.isDataTable('#table_responsive')) {
    $('#table_responsive').DataTable().destroy();
  }

  iniciarformulario(); 
    
  var table = $('#table_responsive').DataTable( {
    language: {
      processing: "<i class='fa fa-spinner fa-5x fa-spin fa-fw' aria-hidden='true'></i>",
      search: "<i class='fa fa-search' aria-hidden='true'></i>",
      lengthMenu:     "Mostrando _MENU_ colas",
      info:           "Mostrando del _START_ al _END_ de _TOTAL_ colas",
      infoEmpty:      "Mostrando 0 al 0 de 0 coincidencias",
      infoFiltered: "(filtrado de un total de _MAX_ elementos)",
      infoPostFix: "",
      loadingRecords: "<i class='fa fa-spinner fa-5x fa-spin fa-fw' aria-hidden='true'></i>",
      zeroRecords: "No hay coincidencias",
      emptyTable: "No hay datos para mostrar",
      paginate: {
        first: "<i class='fa fa-fast-backward fa-lg' aria-hidden='true'></i>",
        previous: "<i class='fa fa-backward fa-lg' aria-hidden='true'></i>",
        next: "<i class='fa fa-forward fa-lg' aria-hidden='true'></i>",
        last: "<i class='fa fa-fast-forward fa-lg' aria-hidden='true'></i>"
      }
    },
    lengthMenu: [
      [ 5, 10, 25, 50, -1 ],
      [ '5', '10', '25', '50', 'Todo' ]
    ],
    buttons: [
      { extend: 'copy', text: '<i class="fa fa-clipboard" aria-hidden="true"></i>' }, 
      { extend: 'excel', text: '<i class="fa fa-file-excel-o text-success" aria-hidden="true"></i>', title: 'Colas' },  
      { extend: 'pdf', text: '<i class="fa fa-file-pdf-o text-danger" aria-hidden="true"></i>', title: 'Colas' },
      { extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i>' }
    ],
    columnDefs:[
      { orderable: false, targets: [0] }
    ],
    pageLength: 25,
    order:[
      [ 1, 'asc' ]
    ],
    stateSave: true
  });

  table.buttons().container().appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );
  tipo_boton_accion(window.innerWidth);
});

$(window).resize(function() {
  var table = $('#table_responsive').DataTable();
  if ($(window).width() <= 768) {
    table.buttons().container().hide(); 
  }
  else {
    table.buttons().container().show();
  }
  tipo_boton_accion($(window).width());
});

function insertarSaltoDeLinea(str, cantidad) {
  const regex = new RegExp("(.{1," + cantidad + "})", "g");
  return str.replace(regex, "$1<br>").trim();
}

function tipo_boton_accion($ancho_ventana) {  
  if ($ancho_ventana <= 768) {
    let elementos_btnaccion = document.querySelectorAll('.btnaccion');
    elementos_btnaccion.forEach(elemento => {
      if (elemento.classList.contains('btn-xs')) {
        elemento.classList.remove('btn-xs');
      }
      elemento.classList.add('btn-sm');
    });
    let elementos_max_ancho = document.querySelectorAll('.max_ancho');    
    elementos_max_ancho.forEach(elemento => {
      let textoOriginal = insertarSaltoDeLinea(elemento.innerText.trim(),31);
      elemento.innerHTML = textoOriginal;      
    });
  }
  else {
    let elementos = document.querySelectorAll('.btnaccion');
    elementos.forEach(elemento => {
      if (elemento.classList.contains('btn-sm')) {
        elemento.classList.remove('btn-sm');
      }
      elemento.classList.add('btn-xs');
    });    
    let elementos_max_ancho = document.querySelectorAll('.max_ancho');    
    elementos_max_ancho.forEach(elemento => {
      let textoOriginal = elemento.innerText.trim().replace(/[\r\n]+/gm, "");
      elemento.innerHTML = textoOriginal;      
    });
  }
}

function iniciarformulario() {
  $('#cmbtipocola').empty();
  $('#cmbtipocola').append(new Option('', '', true, true));
  llenarcombotipocola();

  $('#cmbtransportista').empty();
  $('#cmbtransportista').append(new Option('', '', true, true));
  llenarcombotransportista();

  if(document.forms["form1"].elements["par_historico"].value == 'S') {
    document.forms["form1"].elements["check_historico"].checked = true;
    document.getElementById("titulo").textContent = "Listado Control de Cola (Histórico)";
  }
  else {
    document.getElementById("titulo").textContent = "Listado Control de Cola (Ultimo Reportado)";
  }
}

function llenarcombotipocola() {
  const datos = [
    { id: '', texto: '' },
    { id: 'P', texto: 'PESADA' },
    { id: 'L', texto: 'LIVIANA' }
  ];

  const $miSelect = $('#cmbtipocola');
  $miSelect.empty();

  datos.forEach(item => {
    var nuevaOpcion;
    if( (document.forms["form1"].elements["tipocola"].value != "%") &&
        (document.forms["form1"].elements["tipocola"].value == item.id) ) {
      nuevaOpcion = new Option(item.texto, item.id, true, true);  
    } 
    else {
      nuevaOpcion = new Option(item.texto, item.id, false, false);
    }
    $miSelect.append(nuevaOpcion).trigger('change');
  });
}

function llenarcombotransportista() {
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
            if( (document.forms["form1"].elements["transportista"].value != "%") &&
                (document.forms["form1"].elements["transportista"].value == item.co_transportista) ) {
              $('#cmbtransportista').append(new Option(item.de_transportista, item.co_transportista, true, true));
            } 
            else {
              $('#cmbtransportista').append(new Option(item.de_transportista, item.co_transportista));
            }   
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

function fn_search(id_cola_web) {
  window.location.href = baseurl + "ColaController/form_consultar_cola/" + id_cola_web;
}

function fn_finish(id_cola_web) {
  if (confirm('\u00BFEsta seguro de finalizar la cola de este vehículo?')) {
    $.ajax({
      type: "POST",
      url: baseurl + "ColaController/finalizar_cola",
      data: {id_cola_web : id_cola_web}, 
      success: function (respuesta) {
        if (typeof respuesta === "string" && respuesta.includes("A PHP Error was encountered")) {
            alert(respuesta);
        }
        else {
          var respuesta = (typeof respuesta === "string") ? JSON.parse(respuesta) : respuesta;
          if (respuesta.resultado == "1") {            
            alert("Proceso satisfactorio");
            window.location.href = baseurl + "ColaController/listacola";
          }
          else if (respuesta.resultado == "ERROR") {
            alert("Error: " + respuesta.msn);            
          }
        }  
      },
      error: function(xhr, status, error) { 
        alert("Error de comunicación: " + error); 
      }
    });  
  }
}

function fn_annular(id_cola_web) {
  if (confirm('\u00BFEsta seguro de anular este vehiculo de la cola?')) {
    $.ajax({
      type: "POST",
      url: baseurl + "ColaController/anular_cola",
      data: {id_cola_web : id_cola_web}, 
      success: function (respuesta) {
        if (typeof respuesta === "string" && respuesta.includes("A PHP Error was encountered")) {
            alert(respuesta);
        }
        else {
          var respuesta = (typeof respuesta === "string") ? JSON.parse(respuesta) : respuesta;
          if (respuesta.resultado == "1") {            
            alert("Proceso satisfactorio");
            window.location.href = baseurl + "ColaController/listacola";
          }
          else if (respuesta.resultado == "ERROR") {
            alert("Error: " + respuesta.msn);            
          }
        }  
      },
      error: function(xhr, status, error) { 
        alert("Error de comunicación: " + error); 
      }
    });  
  }
}

function fn_filter() {
  if(validar_form() == true) {
    var txtdesde = document.forms["form1"].elements["txtdesde"].value;
    var txthasta = document.forms["form1"].elements["txthasta"].value;
    var cmbtipocola = document.forms["form1"].elements["cmbtipocola"].value;
    var cmbtransportista = document.forms["form1"].elements["cmbtransportista"].value;

    if(cmbtipocola == "") { cmbtipocola = "0"; }
    if(cmbtransportista == "") { cmbtransportista = "0"; }

    var estatus_historico = "N";
    const checkbox = document.getElementById('check_historico');
    if (checkbox.checked) {
      estatus_historico = "S"; 
    } 

    window.location.href = baseurl + "ColaController/consultar_cola_fecha/" + txtdesde + "/" + txthasta + "/" + cmbtipocola + "/" + cmbtransportista + "/" + estatus_historico;
  }
}

function validar_form() { 
  if (document.forms["form1"].elements["txtdesde"].value.length < 1) {
    alert('Indique la fecha de desde');
    document.forms["form1"].elements["txtdesde"].focus();
    return (false);
  }
  if (document.forms["form1"].elements["txthasta"].value.length < 1) {
    alert('Indique la fecha de hasta');
    document.forms["form1"].elements["txthasta"].focus();
    return (false);
  }
  return (true);
}

document.getElementById('check_historico').addEventListener('change', (evento) => {
    if (evento.target.checked) {
        document.getElementById("titulo").textContent = "Listado Control de Cola (Histórico)";
    } else {
        document.getElementById("titulo").textContent = "Listado Control de Cola (Ultimo Reportado)";
    }
});