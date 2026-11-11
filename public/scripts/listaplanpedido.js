// var host = window.location.host;
// var baseurl = "http://" + host + "/venta/index.php/";
// var linksitioweb = "http://" + host + "/venta/";
var current, current_step, next_step, steps;

//*****************************************************************************
//
//*****************************************************************************
$( document ).ready(function() 
{
  if ($.fn.DataTable.isDataTable('#table_responsive')) 
  {
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
      [ 5, 10, 25, 50, -1 ],
      [ '5', '10', '25', '50', 'Todo' ]
    ],
    buttons: [],
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

  // Limpiar búsqueda y redibujar
  table.search('').draw();

  tipo_boton_accion(window.innerWidth);

  $('.dataTables_filter input').on('blur', function() 
  {
      let valorBuscado = table.search();
      calcular_totales(valorBuscado);
  });

});

function calcular_totales(valorBuscado) 
{
  if(valorBuscado != "") 
  {
    var tot_venta = 0;
    var tot_promo = 0;
    var table = $('#table_responsive').DataTable();

    var filas = document.querySelectorAll('.table_inter tbody tr');

    filas.forEach((fila, index) => 
    {
      var celdas = fila.cells;

      for (let i = 0; i < celdas.length; i++) 
      {
        if(celdas[i].className == "text-left td_inter celda_venta") 
        {
          tot_venta = parseFloat(tot_venta) + parseFloat(celdas[i].innerText);
        }

        if(celdas[i].className == "text-left td_inter celda_promo") 
        {
          tot_promo = parseFloat(tot_promo) + parseFloat(celdas[i].innerText);
        }
      }
    });

    $(table.column(11).footer()).html(tot_venta);
    $(table.column(12).footer()).html(tot_promo);
  }
}

//******************************************************************************
// OCULTARBOTONES COLVIS EN RESOLUCION PEQUEÑA
//******************************************************************************
$(window).resize(function() 
{
  var table = $('#table_responsive').DataTable();

  if ($(window).width() <= 768) 
  {
    table.buttons().container().hide();
  }
  else 
  {
    table.buttons().container().show();
  }

  tipo_boton_accion($(window).width());
});

function insertarSaltoDeLinea(str, cantidad) 
{
  const regex = new RegExp("(.{1," + cantidad + "})", "g");
  return str.replace(regex, "$1<br>").trim();
}

//*****************************************************************************
//
//*****************************************************************************
function tipo_boton_accion($ancho_ventana) 
{
  if ($ancho_ventana <= 768) 
  {
    let elementos_btnaccion = document.querySelectorAll('.btnaccion');

    elementos_btnaccion.forEach(elemento => 
    {
      if (elemento.classList.contains('btn-xs')) 
      {
        elemento.classList.remove('btn-xs');
      }
      elemento.classList.add('btn-sm');
    });

    let elementos_max_ancho = document.querySelectorAll('.max_ancho');

    elementos_max_ancho.forEach(elemento => 
    {
      let textoOriginal = insertarSaltoDeLinea(elemento.innerText.trim(), 32);
      elemento.innerHTML = textoOriginal;
    });
  }
  else 
  {
    let elementos = document.querySelectorAll('.btnaccion');

    elementos.forEach(elemento => 
    {
      if (elemento.classList.contains('btn-sm')) 
      {
        elemento.classList.remove('btn-sm');
      }
      elemento.classList.add('btn-xs');
    });

    let elementos_max_ancho = document.querySelectorAll('.max_ancho');

    elementos_max_ancho.forEach(elemento => 
    {
      let textoOriginal = elemento.innerText.trim().replace(/[\r\n]+/gm, "");
      elemento.innerHTML = textoOriginal;
    });
  }
}

//*****************************************************************************
//
//*****************************************************************************
function iniciarformulario() 
{
  $('#cmbvendedor').empty();
  $('#cmbvendedor').append(new Option('', '', true, true));
  llenarcombovendedor();

  $('#cmbcliente').empty();
  $('#cmbcliente').append(new Option('', '', true, true));
  llenarcombocliente();

  $('#cmbempresa').empty();
  $('#cmbempresa').append(new Option('', '', true, true));
  llenarcomboempresa();

  $('#cmbestatus').empty();
  $('#cmbestatus').append(new Option('', '', true, true));
  llenarcomboestatus();  

  $('#cmbproducto').empty();
  $('#cmbproducto').append(new Option('', '', true, true));
  llenarcomboproducto();
}

//*****************************************************************************
//
//*****************************************************************************
function llenarcombovendedor() 
{
  $.ajax(
  {
    type: "POST",
    url: baseurl + "VendedorController/consultar_vendedor_zona_usuario",
    data: {},

    success: function( respuesta )
    {
      if (typeof respuesta === "string" && respuesta.includes("A PHP Error was encountered")) 
      {
          alert(respuesta);
      }
      else 
      {
        var res = (typeof respuesta === 'object') ? respuesta : JSON.parse(respuesta);

        if (res.resultado == "1") 
        {
          $.each(res.arreglo, function (i, item) 
          {
            if( (document.forms["form1"].elements["vendedor"].value != "%") &&
                (document.forms["form1"].elements["vendedor"].value == item.id_vendedor) ) 
            {
              $('#cmbvendedor').append(new Option(item.nombre, item.id_vendedor, true, true));
            }
            else 
            {
              $('#cmbvendedor').append(new Option(item.nombre, item.id_vendedor));
            }
          });
        }
        else if (res.resultado == "ERROR") 
        {
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
function llenarcombocliente() 
{
  $.ajax(
  {
    type: "POST",
    url: baseurl + "ClienteController/consultar_cliente_zona_usuario",
    data: {},

    success: function( respuesta )
    {
      if (typeof respuesta === "string" && respuesta.includes("A PHP Error was encountered")) 
      {
          alert(respuesta);
      }
      else 
      {
        var res = (typeof respuesta === 'object') ? respuesta : JSON.parse(respuesta);

        if (res.resultado == "1") 
        {
          $.each(res.arreglo, function (i, item) 
          {
            if( (document.forms["form1"].elements["cliente"].value != "%") &&
                (document.forms["form1"].elements["cliente"].value == item.co_organizacion) ) 
            {
              $('#cmbcliente').append(new Option(item.nb_organizacion, item.co_organizacion, true, true));
            }
            else 
            {
              $('#cmbcliente').append(new Option(item.nb_organizacion, item.co_organizacion));
            }
          });
        }
        else if (res.resultado == "ERROR") 
        {
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
function llenarcomboestatus() 
{
  const datos = [
    { id: '', texto: '' },
    { id: 'PROGRAMADO', texto: 'PROGRAMADO' },
    { id: 'EMITIDO', texto: 'EMITIDO' },
    { id: 'APROBADO', texto: 'APROBADO' },
    { id: 'FACTURADO', texto: 'FACTURADO' },
    { id: 'DESPACHADO', texto: 'DESPACHADO' }
  ];

  const $miSelect = $('#cmbestatus');
  $miSelect.empty();

  datos.forEach(item => 
  {
    let nuevaOpcion;
    if( (document.forms["form1"].elements["estatus"].value != "%") &&
        (document.forms["form1"].elements["estatus"].value == item.id) ) 
    {
      nuevaOpcion = new Option(item.texto, item.id, true, true);
    }
    else 
    {
      nuevaOpcion = new Option(item.texto, item.id, false, false);
    }

    $miSelect.append(nuevaOpcion).trigger('change');
  });
}

//*****************************************************************************
//
//*****************************************************************************
function llenarcomboempresa() 
{
  const datos = [
    { id: '', texto: '' },
    { id: 'ADESA', texto: 'ADESA' },
    { id: 'AA1', texto: 'AA1' }
  ];

  const $miSelect = $('#cmbempresa');
  $miSelect.empty();

  datos.forEach(item => 
  {
    let nuevaOpcion;
    if( (document.forms["form1"].elements["empresa"].value != "%") &&
        (document.forms["form1"].elements["empresa"].value == item.id) ) 
    {
      nuevaOpcion = new Option(item.texto, item.id, true, true);
    }
    else 
    {
      nuevaOpcion = new Option(item.texto, item.id, false, false);
    }

    $miSelect.append(nuevaOpcion).trigger('change');
  });
}

//*****************************************************************************
//
//*****************************************************************************
function llenarcomboproducto() {

  $.ajax({
    type: "POST",
    url: baseurl + "ProductoController/consultar_producto_cliente",
    data: { txtcodigo : "%", txtnombre : "%", cocliente : "%", coempresa : "%" },

    success: function( respuesta ) {
      //alert(respuesta);

      if (typeof respuesta === "string" && respuesta.includes("A PHP Error was encountered")) {
          alert(respuesta);
      }
      else {
        var res = (typeof respuesta === "string") ? JSON.parse(respuesta) : respuesta;

        if (res.resultado == "1") {
          $.each(res.arregloproducto, function (i, item) {

            if( ((document.forms["form1"].elements["cobro_adesa"].value == "1" && item.co_empresa == "ADESA")) || ((document.forms["form1"].elements["cobro_aai"].value == "1" && item.co_empresa == "AA1")) ) {

              if( (document.forms["form1"].elements["producto"].value != "%") &&
                  (document.forms["form1"].elements["producto"].value == item.id_registro) ) {
                $('#cmbproducto').append(new Option(item.nb_descripcion, item.id_registro, true, true));
              }
              else {
                $('#cmbproducto').append(new Option(item.nb_descripcion, item.id_registro));
              }

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
function fn_search(id_ped_web, id_doc_emp) 
{
  window.location.href = baseurl + "PedidoController/form_consultar_pedido/" + id_ped_web + "/" + id_doc_emp;
}

//*****************************************************************************
//
//*****************************************************************************
function fn_approve(id_ped_web, id_doc_emp) 
{
  if (confirm('\u00BFEsta seguro de aprobar este pedido?')) 
  {
    $.ajax(
    {
      type: "POST",
      url: baseurl + "PedidoController/aprobar_pedido",
      data: {id_ped_web : id_ped_web, id_doc_emp : id_doc_emp},
      success: function (respuesta) 
      {
        if (typeof respuesta === "string" && respuesta.includes("A PHP Error was encountered")) 
        {
            alert(respuesta);
        }
        else 
        {
          var res = (typeof respuesta === 'object') ? respuesta : JSON.parse(respuesta);

          if (res.resultado == "1") 
          {
            alert("Proceso satisfactorio");
            window.location.href = baseurl + "PedidoController/listapedido";
          }
          else if (res.resultado == "ERROR") 
          {
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
function fn_annular(id_ped_web, id_doc_emp) 
{
  if (confirm('\u00BFEsta seguro de anular este pedido?')) 
  {
    $.ajax(
    {
      type: "POST",
      url: baseurl + "PedidoController/anular_pedido",
      data: {id_ped_web : id_ped_web, id_doc_emp : id_doc_emp},
      success: function (respuesta) 
      {
        if (typeof respuesta === "string" && respuesta.includes("A PHP Error was encountered")) 
        {
            alert(respuesta);
        }
        else 
        {
          var res = (typeof respuesta === 'object') ? respuesta : JSON.parse(respuesta);

          if (res.resultado == "1") 
          {
            alert("Proceso satisfactorio");
            window.location.href = baseurl + "PedidoController/listapedido";
          }
          else if (res.resultado == "ERROR") 
          {
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
function fn_move(id_ped_web, id_doc_emp) 
{
  if (confirm('\u00BFEsta seguro de trasladar este pedido?')) 
  {
    $.ajax(
    {
      type: "POST",
      url: baseurl + "PedidoController/trasladar_pedido",
      data: {id_ped_web : id_ped_web, id_doc_emp : id_doc_emp},
      success: function (respuesta) 
      {
        if (typeof respuesta === "string" && respuesta.includes("A PHP Error was encountered")) 
        {
            alert(respuesta);
        }
        else 
        {
          var res = (typeof respuesta === 'object') ? respuesta : JSON.parse(respuesta);

          if (res.resultado == "1") 
          {
            alert("Proceso satisfactorio");
            window.location.href = baseurl + "PedidoController/listapedido";
          }
          else if (res.resultado == "ERROR") 
          {
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
function fn_info(id_ped_web, id_doc_emp, id_ped_aso) 
{
  $.ajax(
  {
      type: "POST",
      url: baseurl + "PedidoController/consultar_pedido_documentos_asociados",
      data: {id_ped_web : id_ped_web, id_doc_emp : id_doc_emp, id_ped_aso : id_ped_aso},
      success: function (respuesta) 
      {
        if (typeof respuesta === "string" && respuesta.includes("A PHP Error was encountered")) 
        {
            alert(respuesta);
        }
        else 
        {
          var res = (typeof respuesta === 'object') ? respuesta : JSON.parse(respuesta);

          if (res.resultado == "1") 
          {
              document.querySelectorAll('.content_table tbody tr').forEach(tr => tr.remove());

              for(i=0; i<res.Model_consultar_pedido_documentos_asociados.length; i++)
              {
                var ti_documento  = res.Model_consultar_pedido_documentos_asociados[i]["tipo_documento"];
                var nu_documento  = res.Model_consultar_pedido_documentos_asociados[i]["nu_documento"];
                var fe_documento  = res.Model_consultar_pedido_documentos_asociados[i]["fe_documento"];

                let html =  '<tr data-id="row_asoc_' + i + '">';
                html += '<td class="text-left"><p>'+ ti_documento +'</p></td>';
                html += '<td class="text-left"><p>'+ nu_documento +'</p></td>';
                html += '<td class="text-left"><p>'+ fe_documento +'</p></td>';
                html += '</tr>';

                $('#cont_table_body').append(html);
              }

              $('#modalPedido').modal('show');
          }
          else if (res.resultado == "0") 
          {
            alert("No retornaron datos de asociados al pedido web");
          }
          else if (res.resultado == "ERROR") 
          {
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
function fn_filter() 
{
  if(validar_form() == true) 
  {
    var txtdesde = document.forms["form1"].elements["txtdesde"].value;
    var txthasta = document.forms["form1"].elements["txthasta"].value;
    var cmbvendedor = document.forms["form1"].elements["cmbvendedor"].value || "0";
    var cmbcliente = document.forms["form1"].elements["cmbcliente"].value || "0";
    var cmbempresa = document.forms["form1"].elements["cmbempresa"].value || "0";
    var cmbestatus = document.forms["form1"].elements["cmbestatus"].value || "0";
    var cmbproducto = document.forms["form1"].elements["cmbproducto"].value || "0";
    var estatus_anulado = "N";

    window.location.href = baseurl + "PlanController/consultar_pedido_plan_fecha/" + txtdesde + "/" + txthasta + "/" + cmbvendedor + "/" + cmbcliente + "/" + cmbempresa + "/" + cmbestatus + "/" + cmbproducto;


  }
}

//*****************************************************************************
//
//*****************************************************************************
function fn_excel() 
{
  if(validar_form() == true) 
  {
    var txtdesde = document.forms["form1"].elements["txtdesde"].value;
    var txthasta = document.forms["form1"].elements["txthasta"].value;
    var cmbvendedor = document.forms["form1"].elements["cmbvendedor"].value || "0";
    var cmbcliente = document.forms["form1"].elements["cmbcliente"].value || "0";
    var cmbempresa = document.forms["form1"].elements["cmbempresa"].value || "0";
    var cmbestatus = document.forms["form1"].elements["cmbestatus"].value || "0";
    var cmbproducto = document.forms["form1"].elements["cmbproducto"].value || "0";
    var estatus_anulado = "N";

    window.location.href = baseurl + "PlanController/excelgestiontransporte/" + txtdesde + "/" + txthasta + "/" + cmbvendedor + "/" + cmbcliente + "/" + cmbempresa + "/" + cmbestatus + "/" + cmbproducto;
  }
}

//*****************************************************************************
//
//*****************************************************************************
function validar_form() 
{
  if (document.forms["form1"].elements["txtdesde"].value.length < 1) 
  {
    alert('Indique la fecha desde');
    document.forms["form1"].elements["txtdesde"].focus();
    return (false);
  }

  if (document.forms["form1"].elements["txthasta"].value.length < 1) 
  {
    alert('Indique la fecha hasta');
    document.forms["form1"].elements["txthasta"].focus();
    return (false);
  }

  return (true);
}