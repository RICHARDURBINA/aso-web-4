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
      lengthMenu:     "Mostrando _MENU_ pedidos",
      info:           "Mostrando del _START_ al _END_ de _TOTAL_ pedidos",
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
      { extend: 'excel', text: '<i class="fa fa-file-excel-o text-success" aria-hidden="true"></i>',title: 'Pedidos' },
      { extend: 'pdf', text: '<i class="fa fa-file-pdf-o text-danger" aria-hidden="true"></i>',title: 'Pedidos' },
      { extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i>' }*/
    ],
    columnDefs:[
      { orderable: false, targets: [0] }
    ],
    pageLength: 25,
    order:[
      [ 2, 'asc' ]
    ],
    stateSave: true
  });

  table.buttons().container()
  .appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );
  // ----------------------------
  // Fin DataTable
  // ----------------------------

  // Limpiar búsqueda y redibujar
  table.search('').draw();

  tipo_boton_accion(window.innerWidth);

  $('.dataTables_filter input').on('blur', function() {
      // Obtener el valor actual del input de búsqueda
      let valorBuscado = table.search();

      // Ejecutar tu función personalizada
      calcular_totales(valorBuscado);
    });

});

function calcular_totales(valorBuscado) {

  if(valorBuscado != "") {

    var tot_venta = 0;
    var table = $('#table_responsive').DataTable();

    // Selecciona todas las filas (tr) dentro del tbody de la tabla con ID "miTabla"
    var filas = document.querySelectorAll('.table_inter tbody tr');

    // Recorre cada fila
    filas.forEach((fila, index) => {
      // Obtiene todas las celdas (td) de la fila actual
      var celdas = fila.cells; // 'cells' es más eficiente que getElementsByTagName

      // Recorre las celdas de la fila
      for (let i = 0; i < celdas.length; i++) {
        if(celdas[i].className == "text-left td_inter celda_venta") {
          tot_venta = parseFloat(tot_venta) + parseFloat(celdas[i].innerText);
        }
      }

    });

    $(table.column(14).footer()).html(tot_venta);

  }

}

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
      let textoOriginal = insertarSaltoDeLinea(elemento.innerText.trim(),32);
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

  // INICIAR COMBOS
  $('#cmbempresa').empty();
  $('#cmbempresa').append(new Option('', '', true, true));
  llenarcomboempresa();

  // INICIAR COMBOS
  $('#cmbestatus').empty();
  $('#cmbestatus').append(new Option('', '', true, true));
  llenarcomboestatus();

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
    error: function(xhr, status, error) {
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
    error: function(xhr, status, error) {
        alert("Error crítico de comunicación con el servidor: " + error);
    }
  });
}

//*****************************************************************************
//
//*****************************************************************************
function llenarcomboestatus() {

  const datos = [
    { id: '', texto: '' },
    { id: 'APROBADO', texto: 'APROBADO' }
  ];

  const $miSelect = $('#cmbestatus');
  $miSelect.empty();

  datos.forEach(item => {
    let nuevaOpcion;
    if( (document.forms["form1"].elements["estatus"].value != "%") &&
        (document.forms["form1"].elements["estatus"].value == item.id) ) {
      nuevaOpcion = new Option(item.texto, item.id, true, true);
    }
    else {
      nuevaOpcion = new Option(item.texto, item.id, false, false);
    }

    $miSelect.append(nuevaOpcion).trigger('change');
  });

}

//*****************************************************************************
//
//*****************************************************************************
function llenarcomboempresa() {

  const datos = [
    { id: '', texto: '' },
    { id: 'ADESA', texto: 'ADESA' },
    { id: 'AA1', texto: 'AA1' }
  ];

  const $miSelect = $('#cmbempresa');
  $miSelect.empty();

  datos.forEach(item => {
    let nuevaOpcion;
    if( (document.forms["form1"].elements["empresa"].value != "%") &&
        (document.forms["form1"].elements["empresa"].value == item.id) ) {
      nuevaOpcion = new Option(item.texto, item.id, true, true);
    }
    else {
      nuevaOpcion = new Option(item.texto, item.id, false, false);
    }

    $miSelect.append(nuevaOpcion).trigger('change');
  });

}

//*****************************************************************************
//
//*****************************************************************************
function fn_annular(id_ped_web, id_doc_emp, nu_pedido, ti_doc) {

  if (confirm('\u00BFEsta seguro de anular la planificación de este pedido?')) {

    $.ajax({
      type: "POST",
      url: baseurl + "PlanController/anular_plan",
      data: {id_ped_web : id_ped_web, id_doc_emp : id_doc_emp, nu_pedido : nu_pedido, ti_doc : ti_doc},
      success: function (respuesta) {

        if (typeof respuesta === "string" && respuesta.includes("A PHP Error was encountered")) {
            alert(respuesta);
        }
        else {
          var res = (typeof respuesta === "string") ? JSON.parse(respuesta) : respuesta;

          if (res.resultado == "1") {
            alert("Proceso satisfactorio");
            link = document.forms["form1"].elements["url"].value;
            window.location.href = baseurl + "PlanController/" + link;
          }
          else if (res.resultado == "ERROR") {
            alert("Error: " + res.msn);
          }
        }

      },
      error: function(xhr, status, error) {
          alert("Error crítico de comunicación con el servidor: " + error);
      }
    });
  }
}

//*****************************************************************************
//
//*****************************************************************************
function fn_update(id_ped_web, id_doc_emp, nu_pedido, ti_doc) {

  if (confirm('\u00BFEsta seguro de desasociar este transporte?')) {

    $.ajax({
      type: "POST",
      url: baseurl + "PlanController/anular_transporte",
      data: {id_ped_web : id_ped_web, id_doc_emp : id_doc_emp, nu_pedido : nu_pedido, ti_doc : ti_doc },
      success: function (respuesta) {

        if (typeof respuesta === "string" && respuesta.includes("A PHP Error was encountered")) {
            alert(respuesta);
        }
        else {
          var res = (typeof respuesta === "string") ? JSON.parse(respuesta) : respuesta;

          if (res.resultado == "1") {
            alert("Proceso satisfactorio");
            link = document.forms["form1"].elements["url"].value;
            window.location.href = baseurl + "PlanController/" + link;
          }
          else if (res.resultado == "ERROR") {
            alert("Error: " + res.msn);
          }
        }

      },
      error: function(xhr, status, error) {
          alert("Error crítico de comunicación con el servidor: " + error);
      }
    });
  }
}

//*****************************************************************************
//
//*****************************************************************************
function fn_approve(id_ped_web, id_doc_emp, nu_pedido, ti_doc) {

  $.ajax({
      type: "POST",
      url: baseurl + "PlanController/consultar_control_cola_disponible",
      data: { },
      success: function (respuesta) {

        if (typeof respuesta === "string" && respuesta.includes("A PHP Error was encountered")) {
            alert(respuesta);
        }
        else {
          var res = (typeof respuesta === "string") ? JSON.parse(respuesta) : respuesta;

          if (res.resultado == "1") {

              document.querySelectorAll('.content_table tbody tr').forEach(tr => tr.remove());

              for(i=0; i<res.Model_consultar_cola.length; i++)
              {
                var idcola   = res.Model_consultar_cola[i]["id_cola_aso"];
                var tipocola = "";

                if(res.Model_consultar_cola[i]["ti_cola"] == "L") {
                  tipocola = "LIGERA";
                }

                if(res.Model_consultar_cola[i]["ti_cola"] == "P") {
                  tipocola = "PESADA";
                }
                var posicion  = res.Model_consultar_cola[i]["posicion"];
                var fecha     = res.Model_consultar_cola[i]["fe_reporte"];
                var transp    = res.Model_consultar_cola[i]["co_transportista"];
                var chofer    = "(" + res.Model_consultar_cola[i]["co_chofer"] + ") " + res.Model_consultar_cola[i]["nb_chofer"];
                var vehiculo  = res.Model_consultar_cola[i]["co_vehiculo"];
                var tipo      = res.Model_consultar_cola[i]["ti_vehiculo"];
                var capacidad = res.Model_consultar_cola[i]["capacidad"];
                var total     = res.Model_consultar_cola[i]["ca_prd_aprobado_kg"];

                if(parseFloat(total) <= parseFloat(capacidad)) {

                  html =  '<tr data-id="row_cola_' + idcola + '">';
                  html += '<td class="text-center">';
                  html += '<button type="button" class="btn btn-icon me-2 btn-primary p-0" name="btnadd_cola" title="Asignar" onclick="fn_asignar_cola(' + id_ped_web + ',' + id_doc_emp + ',' + '\'' + nu_pedido + '\'' + ',' + idcola + ',\'' + ti_doc + '\')">';
                  html += '<span class="icon-base ri ri-truck-fill icon-20px"></span>';
                  html += '</button>';
                  html += '</td>';
                  html += '<td class="text-left"><p>'+ tipocola +'</p></td>';
                  html += '<td class="text-left"><p>'+ posicion +'</p></td>';
                  html += '<td class="text-left"><p>'+ fecha +'</p></td>';
                  html += '<td class="text-left"><p>'+ transp +'</p></td>';
                  html += '<td class="text-left"><p>'+ chofer +'</p></td>';
                  html += '<td class="text-left"><p>'+ vehiculo +'</p></td>';
                  html += '<td class="text-left"><p>'+ tipo +'</p></td>';
                  html += '<td class="text-left"><p>'+ capacidad +'</p></td>';
                  html += '<td class="text-left"><p>'+ total +'</p></td>';
                  html += '</tr>';

                  $('#cont_table_body').append(html);
                }

              }

              $('#modalControlCola').modal('show');
          }
          else if (res.resultado == "0") {
            alert("No retornaron datos de asociados al control de cola");
          }
          else if (res.resultado == "ERROR") {
            alert(res.msn);
          }
          else {
            alert("No retornaron datos esperados");
          }
        }

      },
      error: function(xhr, status, error) {
          alert("Error crítico de comunicación con el servidor: " + error);
      }
    });
}

function fn_asignar_cola(id_ped_web, id_doc_emp, nu_pedido, id_cola, ti_doc) {

  if (confirm('\u00BFEsta seguro de asociar este transporte?')) {

    $.ajax({
      type: "POST",
      url: baseurl + "PlanController/asignar_transporte",
      data: {id_ped_web : id_ped_web, id_doc_emp : id_doc_emp, nu_pedido : nu_pedido, id_cola : id_cola, ti_doc : ti_doc},
      success: function (respuesta) {

        if (typeof respuesta === "string" && respuesta.includes("A PHP Error was encountered")) {
            alert(respuesta);
        }
        else {
          var res = (typeof respuesta === "string") ? JSON.parse(respuesta) : respuesta;

          if (res.resultado == "1") {
            alert("Proceso satisfactorio");
            link = document.forms["form1"].elements["url"].value;
            window.location.href = baseurl + "PlanController/" + link;
          }
          else if (res.resultado == "ERROR") {
            alert("Error: " + res.msn);
          }
        }

      },
      error: function(xhr, status, error) {
          alert("Error crítico de comunicación con el servidor: " + error);
      }
    });
  }
}

//*****************************************************************************
//
//*****************************************************************************
function fn_filter() {

  var fe_emision = document.forms["form1"].elements["fe_emision"].value;
  var cmbvendedor = document.forms["form1"].elements["cmbvendedor"].value;
  var cmbcliente = document.forms["form1"].elements["cmbcliente"].value;
  var cmbempresa = document.forms["form1"].elements["cmbempresa"].value;
  var cmbestatus = document.forms["form1"].elements["cmbestatus"].value;

  var estatus_anulado = "N";

  if(cmbvendedor == "") { cmbvendedor = "0"; }
  if(cmbcliente == "") { cmbcliente = "0"; }

  if(cmbempresa == "") { cmbempresa = "0"; }
  if(cmbestatus == "") { cmbestatus = "0"; }

  window.location.href = baseurl + "PlanController/consultar_pedido_vta_prom_fecha/" + fe_emision + "/" + cmbvendedor + "/" + cmbcliente + "/" + cmbempresa + "/" + cmbestatus;

}

//*****************************************************************************
//
//*****************************************************************************
function fn_move(id_ped_web, id_doc_emp, nu_pedido, ti_doc) {

  if (confirm('\u00BFEsta seguro de trasladar este transporte?')) {

    $.ajax({
      type: "POST",
      url: baseurl + "PlanController/sincronizar_transporte",
      data: {id_ped_web : id_ped_web, id_doc_emp : id_doc_emp, nu_pedido : nu_pedido, ti_doc : ti_doc},
      success: function (respuesta) {

        if (typeof respuesta === "string" && respuesta.includes("A PHP Error was encountered")) {
            alert(respuesta);
        }
        else {
          var res = (typeof respuesta === "string") ? JSON.parse(respuesta) : respuesta;

          if (res.resultado == "1") {
            alert("Proceso satisfactorio");
            link = document.forms["form1"].elements["url"].value;
            window.location.href = baseurl + "PlanController/" + link;
          }
          else if (res.resultado == "ERROR") {
            alert("Error: " + res.msn);
          }
        }

      },
      error: function(xhr, status, error) {
          alert("Error crítico de comunicación con el servidor: " + error);
      }
    });
  }
}

//*****************************************************************************
//
//*****************************************************************************
function fn_nc_total(id_ped_web, id_doc_emp, nu_pedido, ti_doc) {

  if (confirm('\u00BFEsta seguro de aplicar NC, esta acción no permitirá usar el mismo pedido web?')) {

    $.ajax({
      type: "POST",
      url: baseurl + "PlanController/aplicar_nc_total",
      data: {id_ped_web : id_ped_web, id_doc_emp : id_doc_emp, nu_pedido : nu_pedido, ti_doc : ti_doc},
      success: function (respuesta) {

        if (typeof respuesta === "string" && respuesta.includes("A PHP Error was encountered")) {
            alert(respuesta);
        }
        else {
          var res = (typeof respuesta === "string") ? JSON.parse(respuesta) : respuesta;

          if (res.resultado == "1") {
            alert("Proceso satisfactorio");
            link = document.forms["form1"].elements["url"].value;
            window.location.href = baseurl + "PlanController/" + link;
          }
          else if (res.resultado == "ERROR") {
            alert("Error: " + res.msn);
          }
        }

      },
      error: function(xhr, status, error) {
          alert("Error crítico de comunicación con el servidor: " + error);
      }
    });
  }
}