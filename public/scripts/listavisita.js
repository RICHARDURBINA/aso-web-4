// var host = window.location.host;
// var baseurl = "http://" + host + "/venta/index.php/";
// var linksitioweb = "http://" + host + "/venta/";
var current, current_step, next_step, steps;

//*****************************************************************************
//
//*****************************************************************************
$( document ).ready(function(){

  if ($.fn.DataTable.isDataTable('#table_responsive')) {
    $('#table_responsive').DataTable().destroy();
  }

  iniciarformulario(); 
    
  // DATATABLE  
  var table = $('#table_responsive').DataTable( {

    language: {
      processing: "<i class='fa fa-spinner fa-5x fa-spin fa-fw' aria-hidden='true'></i>",
      search: "<i class='fa fa-search' aria-hidden='true'></i>",
      lengthMenu:     "Mostrando _MENU_ visitas",
      info:           "Mostrando del _START_ al _END_ de _TOTAL_ visitas",
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
      [ 5,10, 25, 50, -1 ],
      [ '5','10', '25', '50', 'Todo' ]
    ],
    buttons: [
      /*{ extend: 'colvis', text: '<i class="fa fa-eye" aria-hidden="true"></i>' },
      { extend: 'copy', text: '<i class="fa fa-clipboard" aria-hidden="true"></i>' }, 
      { extend: 'excel', text: '<i class="fa fa-file-excel-o text-success" aria-hidden="true"></i>',title: 'Visitas' },  
      { extend: 'pdf', text: '<i class="fa fa-file-pdf-o text-danger" aria-hidden="true"></i>',title: 'Visitas' },
      { extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i>' }*/
    ],
    columnDefs:[
      { orderable: false, targets: [0] }
    ],
    pageLength: 25,
    order:[
      [ 2, 'desc' ]
    ],
    stateSave: false
  });

  table.buttons().container()
  .appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );
  // ----------------------------
  // Fin DataTable
  // ----------------------------

  var table = $('#table_responsive').DataTable();
  
  if(document.forms["form1"].elements["cobro_adesa"].value != "1")
  {    
    table.column(11).visible(false);
  }
  else
  {
    table.column(11).visible(true);
  }

  if(document.forms["form1"].elements["cobro_aai"].value != "1")
  {
    table.column(12).visible(false);
  }
  else
  {
    table.column(12).visible(true);
  }

  tipo_boton_accion(window.innerWidth);

});

//******************************************************************************
// OCULTARBOTONES COLVIS EN RESOLUCION PEQUEÑA
//******************************************************************************
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
  // Crea una expresión regular para agrupar caracteres
  const regex = new RegExp("(.{1," + cantidad + "})", "g");
  // Reemplaza cada grupo con el mismo grupo ($1) seguido de un salto de línea
  return str.replace(regex, "$1<br>").trim(); // .trim() quita el último salto de línea innecesario
}

//*****************************************************************************
//
//*****************************************************************************
function tipo_boton_accion($ancho_ventana) {  

  if ($ancho_ventana <= 768) {

    //--------------------------------------------------------------------------
    // CAMBIAR TAMAÑO DE BOTONES
    //--------------------------------------------------------------------------
    let elementos_btnaccion = document.querySelectorAll('.btnaccion');

    elementos_btnaccion.forEach(elemento => {
      if (elemento.classList.contains('btn-xs')) {
        elemento.classList.remove('btn-xs'); // Elimina clase anterior
      }
      elemento.classList.add('btn-sm'); // Agrega nueva clase
    });
    //--------------------------------------------------------------------------
    // SALTO DE LINEA PARA CLASS .max_ancho
    //--------------------------------------------------------------------------
    let elementos_max_ancho = document.querySelectorAll('.max_ancho');    

    elementos_max_ancho.forEach(elemento => {
      let textoOriginal = insertarSaltoDeLinea(elemento.innerText.trim(),31);
      elemento.innerHTML = textoOriginal;      
    });
    //--------------------------------------------------------------------------
  }
  else {
    
    //--------------------------------------------------------------------------
    // CAMBIAR TAMAÑO DE BOTONES
    //--------------------------------------------------------------------------
    let elementos = document.querySelectorAll('.btnaccion');

    elementos.forEach(elemento => {
      if (elemento.classList.contains('btn-sm')) {
        elemento.classList.remove('btn-sm'); // Elimina clase anterior
      }
      elemento.classList.add('btn-xs'); // Agrega nueva clase
    });    
    //--------------------------------------------------------------------------
    // SALTO DE LINEA PARA CLASS .max_ancho
    //--------------------------------------------------------------------------
    let elementos_max_ancho = document.querySelectorAll('.max_ancho');    

    elementos_max_ancho.forEach(elemento => {
      let textoOriginal = elemento.innerText.trim().replace(/[\r\n]+/gm, "");
      elemento.innerHTML = textoOriginal;      
    });
    //--------------------------------------------------------------------------
  }
}

//*****************************************************************************
//
//*****************************************************************************
function iniciarformulario() {

  // INICIAR COMBOS
  $('#cmbvendedor').empty();
  $('#cmbvendedor').append(new Option('', '', true, true));
  llenarcombovendedor(); 

  // INICIAR COMBOS
  $('#cmbcliente').empty();
  $('#cmbcliente').append(new Option('', '', true, true));
  llenarcombocliente();
  
}

//*****************************************************************************
//
//*****************************************************************************
function llenarcombovendedor() { 

  $.ajax({
    type: "POST",
    url: baseurl + "VendedorController/consultar_vendedor_zona_usuario",
    data: {  },

    success: function( respuesta ){  
      //alert(respuesta);

      // Validación segura por si la respuesta es texto plano o un objeto JSON
      if (typeof respuesta === "string" && respuesta.includes("A PHP Error was encountered")) {
          alert(respuesta);
      }
      else {
        var res = (typeof respuesta === "string") ? JSON.parse(respuesta) : respuesta;

        if (res.resultado == "1") {
          $.each(res.arreglo, function (i, item) { 

            if( (document.forms["form1"].elements["vendedor"].value != "%") &&
                (document.forms["form1"].elements["vendedor"].value == item.id_vendedor) ) {
              $('#cmbvendedor').append(new Option(item.nombre, item.id_vendedor, true, true));
            } 
            else {
              $('#cmbvendedor').append(new Option(item.nombre, item.id_vendedor));
            }    

          });
        }
        else if (res.resultado == "ERROR") {
          alert(res.msn);
        }    
      }
                
    },
    error: function(xhr, status, error) 
    {
        alert("Error crítico de comunicación con el servidor: " + error);
    }
  });
}

//*****************************************************************************
//
//*****************************************************************************
function llenarcombocliente() { 

  $.ajax({
    type: "POST",
    url: baseurl + "ClienteController/consultar_cliente_zona_usuario",
    data: {  },

    success: function( respuesta ){  
      //alert(respuesta);

      // Validación segura por si la respuesta es texto plano o un objeto JSON
      if (typeof respuesta === "string" && respuesta.includes("A PHP Error was encountered")) {
          alert(respuesta);
      }
      else {
        var res = (typeof respuesta === "string") ? JSON.parse(respuesta) : respuesta;

        if (res.resultado == "1") {
          $.each(res.arreglo, function (i, item) {
            
            if( (document.forms["form1"].elements["cliente"].value != "%") &&
                (document.forms["form1"].elements["cliente"].value == item.co_organizacion) ) {
              $('#cmbcliente').append(new Option(item.nb_organizacion, item.co_organizacion, true, true));
            } 
            else {
              $('#cmbcliente').append(new Option(item.nb_organizacion, item.co_organizacion));
            }   

          });
        }
        else if (res.resultado == "ERROR") {
          alert(res.msn);
        }    
      }
                
    },
    error: function(xhr, status, error) 
    {
        alert("Error crítico de comunicación con el servidor: " + error);
    }
  });
}

//*****************************************************************************
//
//*****************************************************************************
function fn_search(id_vis_web) {

  window.location.href = baseurl + "VisitaController/form_consultar_visita/" + id_vis_web;

}

//*****************************************************************************
//
//*****************************************************************************
function fn_annular(id_vis_web) {
  
  if (confirm('\u00BFEsta seguro de anular esta visita?')) {

    $.ajax({
      type: "POST",
      url: baseurl + "VisitaController/anular_visita",
      data: {id_vis_web : id_vis_web}, 
      success: function (respuesta) {

        //alert(respuesta);

        // Validación segura por si la respuesta es texto plano o un objeto JSON
        if (typeof respuesta === "string" && respuesta.includes("A PHP Error was encountered")) {
            alert(respuesta);
        }
        else {
          var res = (typeof respuesta === "string") ? JSON.parse(respuesta) : respuesta;

          if (res.resultado == "1") {            
            alert("Proceso satisfactorio");
            window.location.href = baseurl + "VisitaController/listavisita";
          }
          else if (res.resultado == "ERROR") {
            alert("Error: " + res.msn);            
          }
        }  
        
      },
      error: function(xhr, status, error) 
      {
          alert("Error crítico de comunicación con el servidor: " + error);
      }
    });  
  }
}

//*****************************************************************************
//
//*****************************************************************************
function fn_filter() {

  if(validar_form() == true) {

    var txtdesde = document.forms["form1"].elements["txtdesde"].value;
    var txthasta = document.forms["form1"].elements["txthasta"].value;

    var cmbvendedor = document.forms["form1"].elements["cmbvendedor"].value;
    var cmbcliente = document.forms["form1"].elements["cmbcliente"].value;

    if(cmbvendedor == "") { cmbvendedor = "0"; }
    if(cmbcliente == "") { cmbcliente = "0"; }

    window.location.href = baseurl + "VisitaController/consultar_visita_fecha/" + txtdesde + "/" + txthasta + "/" + cmbvendedor + "/" + cmbcliente;

  }

}

//*****************************************************************************
//
//*****************************************************************************
function validar_form() { 

  // VALIDACION DE FECHA DESDE
  if (document.forms["form1"].elements["txtdesde"].value.length < 1) {
    alert('Indique la fecha de desde');
    document.forms["form1"].elements["txtdesde"].focus();
    return (false);
  }

  // VALIDACION DE FECHA DESDE
  if (document.forms["form1"].elements["txthasta"].value.length < 1) {
    alert('Indique la fecha de hasta');
    document.forms["form1"].elements["txthasta"].focus();
    return (false);
  }

  else {
      return (true);
  }

}