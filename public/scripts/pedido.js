//===============================================================================================================================================
//
//===============================================================================================================================================
$( document ).ready(function() 
{
  iniciarformulario();
});

//*****************************************************************************
//
//*****************************************************************************
function iniciarformulario() 
{
  $('#cmbcliente').empty();
  $('#cmbcliente').append(new Option('', '', true, true));
  llenarcombocliente();

  document.forms["form1"].elements["fila_prd_actual"].value = "";
  document.forms["form1"].elements["totalprd"].value = "0";
  document.forms["form1"].elements["operacion"].value = "1";

  par_co_cliente = document.forms["form1"].elements["par_co_cliente"].value;

  if (par_co_cliente != "") 
  {
    setTimeout(function() 
    {
        $('#cmbcliente').val(par_co_cliente).trigger('change');
    }, 500);
  }

  document.forms["form1"].elements["cmbconpag"].focus();
}

//*****************************************************************************
//
//*****************************************************************************
function llenarcombocliente() 
{
  $.ajax({
    type: "POST",
    url: baseurl + "ClienteController/consultar_cliente_zona_usuario",
    data: {},
    success: function( respuesta ) 
    {
      if (respuesta.includes("A PHP Error was encountered")) 
      {
          alert(respuesta);
      }
      else 
      {
        var res = JSON.parse(respuesta);

        if (res.resultado == "1") 
        {
          $.each(res.arreglo, function (i, item) 
          {
            $('#cmbcliente').append(new Option(item.nb_organizacion, item.co_organizacion));
          });
        }
        else if (res.resultado == "ERROR") 
        {
          alert("Error del Sistema: " + res.msn);
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
function llenarcombosucursal(cocliente) 
{
  $.ajax({
    type: "POST",
    url: baseurl + "ClienteController/consultar_sucursal_cliente",
    data: { cmbcliente: cocliente },
    success: function( respuesta ) 
    {
      if (respuesta.includes("A PHP Error was encountered")) 
      {
          alert(respuesta);
      }
      else 
      {
        var res = JSON.parse(respuesta);

        if (res.resultado == "1") 
        {
          $.each(res.arreglo, function (i, item) 
          {
            if (item.adesa == "1") 
            {
              $('#cmbsucursaladesa').append(new Option(item.direccion, item.direccion));
            }
            if (item.aai == "1") 
            {
              $('#cmbsucursalaai').append(new Option(item.direccion, item.direccion));
            }
          });
        }
        else if (res.resultado == "ERROR") 
        {
          alert("Error del Sistema: " + res.msn);
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
$('#cmbcliente').on('change', function() 
{
  var operacion = document.forms["form1"].elements["operacion"].value;

  if (operacion == '1') 
  {
    if (!(document.forms["form1"].elements["cmbcliente"].value == "")) 
    {
      var cocliente = document.forms["form1"].elements["cmbcliente"].value;

      $('#cmbsucursaladesa').empty();
      $('#cmbsucursaladesa').append(new Option('', '', true, true));

      $('#cmbsucursalaai').empty();
      $('#cmbsucursalaai').append(new Option('', '', true, true));

      llenarcombosucursal(cocliente);

      $.ajax({
        type: "POST",
        url: baseurl + "ProductoController/consultar_producto_cliente",
        data: {
          txtcodigo : "%",
          txtnombre : "%",
          cocliente : cocliente,
          coempresa : "%"
        },
        success: function (respuesta) 
        {
          if (respuesta.includes("A PHP Error was encountered")) 
          {
              alert(respuesta);
          }
          else 
          {
            var res = JSON.parse(respuesta);

            if (res.resultado == "1") 
            {
              const miDiv = document.getElementById('content_prd');
              miDiv.textContent = '';

              document.forms["form1"].elements["totalprd"].value = res.arregloproducto.length;

              for (i = 0; i < res.arregloproducto.length; i++) 
              {
                var id_prd = res.arregloproducto[i]["id_registro"];
                var co_prd = res.arregloproducto[i]["co_producto"];
                var nb_prd = res.arregloproducto[i]["nb_producto"];
                var pr_prd = Number(res.arregloproducto[i]["pr_producto"].replace(',', '.'));
                var prm_prd = Number(res.arregloproducto[i]["pr_producto_mayor"].replace(',', '.'));
                var co_emp = res.arregloproducto[i]["co_empresa"];

                add_item_prd(i, id_prd, co_prd, nb_prd, pr_prd, prm_prd, co_emp);
              }
            }
            else if (res.resultado == "ERROR") 
            {
              alert("Error del Sistema: " + res.msn);
            }
            else if (res.resultado == "0") 
            {
              alert("No retornaron datos de productos esperados");
            }
            else 
            {
              alert("No retornaron datos esperados");
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
});

//========================================================================================================
// AGREGAR ITEM DINAMICOS DATATABLE TAB 1
//========================================================================================================
function add_item_prd(fila_i, id_prd, co_prd, nb_prd, pr_prd, prm_prd, co_emp)
{
  html = '<div class="row" id="row_' + fila_i + '">';

  html += '<div class="col-md-6">';
  html += '<div class="form-floating form-floating-outline mb-6">';
  html += '<input type="hidden" name="coemp[' + fila_i + ']" id="coemp[' + fila_i + ']" value="'+ co_emp +'" />';
  html += '<input type="hidden" name="idprd[' + fila_i + ']" id="idprd[' + fila_i + ']" value="'+ id_prd +'" />';
  html += '<input type="hidden" name="coprd[' + fila_i + ']" id="coprd[' + fila_i + ']" value="'+ co_prd +'" />';
  html += '<textarea class="form-control h-px-75" name="nbprd[' + fila_i + ']" id="nbprd[' + fila_i + ']" placeholder="" readonly>';
  html += nb_prd;
  html += '</textarea>';
  html += '<label for="nbprd[' + fila_i + ']">Producto</label>';
  html += '</div>';
  html += '</div>';

  html += '<div class="col-md-2">';
  html += '<div class="form-floating form-floating-outline mb-6">';
  html += '<input type="number" class="form-control" name="prprd[' + fila_i + ']" id="prprd[' + fila_i + ']" value="'+ pr_prd +'" min="0" maxlength="8" placeholder="0" onkeypress="ValidaSoloNumeros(event)" readonly/>';
  html += '<label for="prprd[' + fila_i + ']">Precio Ofertado</label>';
  html += '</div>';
  html += '</div>';

  html += '<div class="col-md-1">';
  html += '<div class="form-floating form-floating-outline mb-6">';
  html += '<input type="number" class="form-control" name="caprd[]" id="caprd[' + fila_i + ']" value="0" min="0" maxlength="4" placeholder="0" onkeypress="ValidaSoloNumeros(event)" onclick="this.select()" />';
  html += '<label for="caprd[' + fila_i + ']">Cantidad</label>';
  html += '</div>';
  html += '</div>';

  html += '<div class="col-md-1">';
  html += '<div class="form-floating form-floating-outline mb-6">';
  html += '<input type="number" class="form-control" name="promprd[' + fila_i + ']" id="promprd[' + fila_i + ']" value="0" min="0" maxlength="4" placeholder="0" onkeypress="ValidaSoloNumeros(event)" onclick="this.select()" />';
  html += '<label for="promprd[' + fila_i + ']">Promoción</label>';
  html += '</div>';
  html += '</div>';

  html += '<div class="col-md-1">';
  html += '<div class="form-floating form-floating-outline mb-6">';
  html += '<input type="number" class="form-control" name="descprd[' + fila_i + ']" id="descprd[' + fila_i + ']" value="0" min="0" maxlength="4" placeholder="0" onkeypress="ValidaSoloNumeros(event)" onclick="this.select()" />';
  html += '<label for="descprd[' + fila_i + ']">Descuento</label>';
  html += '</div>';
  html += '</div>';

  html += '<input type="hidden" name="tipodesc[' + fila_i + ']" id="tipodesc[' + fila_i + ']" value="" />';

  html += '<div class="col-md-1">';
  html += '<div class="form-floating form-floating-outline mb-6">';
  html += '<button type="button" class="btn btn-icon me-2 btn-primary " id="btnadd_desc" name="btnadd_desc" title="Agregar" onclick="fn_open_modal_desc(' + fila_i + ')">';
  html += '<span class="icon-base ri ri-list-view icon-22px"></span>';
  html += '</button>';
  html += '</div>';
  html += '</div>';
  html += '<hr class="mt-0">';

  html += '<div id="cont_porc_desc_' + fila_i + '">';
  html += '</div>';
  html += '<input type="hidden" name="total_desc_prd_actual[' + fila_i + ']" id="total_desc_prd_actual[' + fila_i + ']" value="0" />';

  html += '</div>';

  $('#content_prd').append(html);
}

//*****************************************************************************
//
//*****************************************************************************
function fn_open_modal_desc(fila_prd_actual) 
{
  if (document.forms["form1"].elements["caprd["+ fila_prd_actual +"]"].value > 0) 
  {
    document.forms["form1"].elements["fila_prd_actual"].value = fila_prd_actual;
    $('#modalDescuento').modal('show');

    document.forms["form1"].elements["txtdias"].value = "";
    document.forms["form1"].elements["txtporc"].value = "";

    $('#table_responsive_desc tbody').empty();
    document.forms["form1"].elements["total_desc_prd_actual[" + fila_prd_actual + "]"].value = 0;

    const elementos = document.getElementsByName('dia['+ fila_prd_actual +'][]');

    elementos.forEach((el, index) => 
    {
      txtdias = el.value;
      txtporc = document.forms["form1"].elements[el.id.replace("dia", "porc")].value;
      add_item_table_desc_prd(fila_prd_actual, index, txtdias, txtporc);
    });

    document.forms["form1"].elements["total_desc_prd_actual[" + fila_prd_actual + "]"].value = elementos.length;
  }
}

//*****************************************************************************
//
//*****************************************************************************
$('#modalDescuento').on('shown.bs.modal', function () 
{
  $('#txtdias').trigger('focus');
});

//*****************************************************************************
//
//*****************************************************************************
function fn_remove_desc_prd(fila_prd_actual, fila_desc_prd_actual) 
{
  const input_hidden_dia = document.getElementById('dia['+ fila_prd_actual +']['+ fila_desc_prd_actual +']');
  const input_hidden_porc = document.getElementById('porc['+ fila_prd_actual +']['+ fila_desc_prd_actual +']');

  if (input_hidden_dia) 
  {
      input_hidden_dia.remove();
  }

  if (input_hidden_porc) 
  {
      input_hidden_porc.remove();
  }

  $('#table_responsive_desc tbody').empty();
  document.forms["form1"].elements["total_desc_prd_actual[" + fila_prd_actual + "]"].value = 0;

  const elementos = document.getElementsByName('dia['+ fila_prd_actual +'][]');

  elementos.forEach((el, index) => 
  {
    txtdias = el.value;
    txtporc = document.forms["form1"].elements[el.id.replace("dia", "porc")].value;
    add_item_table_desc_prd(fila_prd_actual, index, txtdias, txtporc);
  });

  document.forms["form1"].elements["total_desc_prd_actual[" + fila_prd_actual + "]"].value = elementos.length;

  $('#cont_porc_desc_'+fila_prd_actual).empty();

  const lista_txtdias = [];
  const lista_txtporc = [];

  cont_dia = 0;
  cont_porc = 0;

  const filas = document.querySelectorAll('#table_responsive_desc tbody tr');

  filas.forEach((fila) => 
  {
    const celdas = fila.cells;
    for (let i = 0; i < celdas.length; i++) 
    {
      if (celdas[i].className == "celda_dia") 
      {
        lista_txtdias[cont_dia] = celdas[i].innerText;
        cont_dia = cont_dia + 1;
      }

      if (celdas[i].className == "celda_porc") 
      {
        lista_txtporc[cont_porc] = celdas[i].innerText;
        cont_porc = cont_porc + 1;
      }
    }
  });

  for (i = 0; i < cont_dia; i++) 
  {
    if (lista_txtdias[i] != "" && lista_txtporc[i] != "") 
    {
      add_item_array_desc_prd(fila_prd_actual, i, lista_txtdias[i], lista_txtporc[i]);
    }
  }

  document.forms["form1"].elements["txtdias"].focus();
}

//*****************************************************************************
//
//*****************************************************************************
$("#btnadd_desc_prd").click(function () 
{
  var validar = false;
  var fila_prd_actual = document.forms["form1"].elements["fila_prd_actual"].value;
  var txtdias = document.forms["form1"].elements["txtdias"].value;
  var txtporc = document.forms["form1"].elements["txtporc"].value;

  if (fila_prd_actual.length < 1) 
  {
    validar = false;
    alert('No se pudo obtener el número de fila de producto');
    document.forms["form1"].elements["txtdias"].focus();
  }
  else if ((txtdias.length < 1) || (txtdias < 1)) 
  {
    validar = false;
    alert('Indique el número de días para el porcentaje de descuento');
    document.forms["form1"].elements["txtdias"].focus();
  }
  else if ((txtporc.length < 1) || (txtporc < 1)) 
  {
    validar = false;
    alert('Indique el porcentaje de descuento');
    document.forms["form1"].elements["txtporc"].focus();
  }
  else 
  {
    validar = true;
  }

  if (validar == true) 
  {
      let fila_desc_prd_actual = parseInt(document.forms["form1"].elements["total_desc_prd_actual[" + fila_prd_actual + "]"].value);

      add_item_array_desc_prd(fila_prd_actual, fila_desc_prd_actual, txtdias, txtporc);
      add_item_table_desc_prd(fila_prd_actual, fila_desc_prd_actual, txtdias, txtporc);

      fila_desc_prd_actual = fila_desc_prd_actual + 1;
      document.forms["form1"].elements["total_desc_prd_actual[" + fila_prd_actual + "]"].value = fila_desc_prd_actual;

      document.forms["form1"].elements["txtdias"].value = "";
      document.forms["form1"].elements["txtporc"].value = "";
      document.forms["form1"].elements["txtdias"].focus();
  }
});

//*****************************************************************************
// AGREGAR ITEM DINAMICOS ARRAY
//*****************************************************************************
function add_item_array_desc_prd(fila_prd_actual, fila_desc_prd_actual, txtdias, txtporc)
{
  html_ =  '<input type="hidden" name="dia[' + fila_prd_actual + '][]" id="dia[' + fila_prd_actual + '][' + fila_desc_prd_actual + ']" value="'+ txtdias +'" />';
  html_ += '<input type="hidden" name="porc[' + fila_prd_actual + '][]" id="porc[' + fila_prd_actual + '][' + fila_desc_prd_actual + ']" value="'+ txtporc +'" />';
  $('#cont_porc_desc_'+ fila_prd_actual).append(html_);
}

//*****************************************************************************
// AGREGAR ITEM DINAMICOS TABLE
//*****************************************************************************
function add_item_table_desc_prd(fila_prd_actual, fila_desc_prd_actual, txtdias, txtporc)
{
  html = '<tr id="tr_' + fila_desc_prd_actual + '"> ';
  html += '<td class="celda_dia"><p>' + txtdias + '</p></td>';
  html += '<td class="celda_porc"><p>' + txtporc + '</p></td>';
  html += '<td class="celda_boton">';
  html += '<button type="button" class="btn btn-icon me-2 btn-danger " id="btnremove_prd" name="btnremove_prd" title="Eliminar" onclick="fn_remove_desc_prd(' + fila_prd_actual + ',' + fila_desc_prd_actual + ')">';
  html += '<span class="icon-base ri ri-delete-bin-2-fill icon-22px"></span>';
  html += '</button>';
  html += '</td>';
  html += '</tr>';
  $('#cont_table_body').append(html);
}

//*****************************************************************************
//
//*****************************************************************************
$("#btnsave").click(function () 
{
  if (validar_form() == true) 
  {
    document.forms["form1"].elements["btnsave"].disabled = true;
    $("#btnclose_").focus();

    if (confirm('\u00BFEsta seguro de guardar el pedido?')) 
    {
      var operacion = document.forms["form1"].elements["operacion"].value;
      var str = $("#form1").serialize();
      var co_cliente = $('#cmbcliente').val();

      if (operacion == '1') 
      {
        $.ajax({
          type: "POST",
          url: baseurl + "PedidoController/guardar_pedido",
          data: str,
          success: function (respuesta) 
          {
            if (respuesta.includes("A PHP Error was encountered")) 
            {
                alert(respuesta);
                document.forms["form1"].elements["btnsave"].disabled = false;
            }
            else 
            {
              var res = JSON.parse(respuesta);

              if (res.resultado == "1") 
              {
                Swal.fire({
                  title: "Registro Satisfactorio!",
                  text: "Desea continuar a la siguiente pantalla?",
                  icon: 'success',
                  showCancelButton: true,
                  allowOutsideClick: false,
                  confirmButtonText: "Cobranza",
                  confirmButtonColor: '#278321',
                  cancelButtonText: "Cancelar",
                  cancelButtonColor: '#ccc',
                }).then((result) => 
                {
                  if (result.isConfirmed) 
                  {
                    window.location.href = baseurl + "CobranzaController/cobranza/?co_cliente=" + co_cliente;
                  } 
                  else 
                  {
                    window.location.href = baseurl + "PedidoController/pedido/";
                  }
                });
              }
              else if (res.resultado == "ERROR") 
              {
                alert("Error del Sistema: " + res.msn);
                document.forms["form1"].elements["btnsave"].disabled = false;
              }
            }
          },
          error: function(xhr, status, error) 
          {
              alert("Error crítico de comunicación con el servidor: " + error);
              document.forms["form1"].elements["btnsave"].disabled = false;
          }
        });
      }
    }
    else 
    {
       document.forms["form1"].elements["btnsave"].disabled = false;
    }
  }
});

//*****************************************************************************
//
//*****************************************************************************
function validar_form() 
{
  if (document.forms["form1"].elements["idvendedor"].value.length < 1) 
  {
    alert('Indique el vendedor');
    document.forms["form1"].elements["nbvendedor"].focus();
    return (false);
  }

  if (document.forms["form1"].elements["nbvendedor"].value.length < 1) 
  {
    alert('Indique el vendedor');
    document.forms["form1"].elements["nbvendedor"].focus();
    return (false);
  }

  if (document.forms["form1"].elements["fecha"].value.length < 1) 
  {
    alert('Indique la fecha de registro');
    document.forms["form1"].elements["fecha"].focus();
    return (false);
  }

  if (document.forms["form1"].elements["cmbconpag"].value == "") 
  {
    alert('Ingrese la condición de pago');
    document.forms["form1"].elements["cmbconpag"].focus();
    return (false);
  }

  if (document.forms["form1"].elements["cmbcliente"].value == "") 
  {
    alert('Ingrese el cliente');
    document.forms["form1"].elements["cmbcliente"].focus();
    return (false);
  }

  var seleccion = false;
  for (i = 0; i < document.forms["form1"].elements.length; i++) 
  {
    if (document.forms["form1"].elements[i].name == "caprd[]") 
    {
        if (document.forms["form1"].elements[i].value != 0) 
        {
            seleccion = true;
        }
    }
  }

  if (seleccion == false) 
  {
      alert('Seleccione algun producto para el pedido');
      document.forms["form1"].elements["cmbcliente"].focus();
      return (false);
  }

  var adesa = 0;
  var aai = 0;

  for (i = 0; i < document.forms["form1"].elements.length; i++) 
  {
    if (document.forms["form1"].elements[i].name == "caprd[]") 
    {
      if (document.forms["form1"].elements[i].value != 0) 
      {
        prd_emp = document.forms["form1"].elements[i].id.replace("caprd","coemp");

        if (document.forms["form1"].elements[prd_emp].value == "ADESA") 
        {
          adesa = 1;
        }
        if (document.forms["form1"].elements[prd_emp].value == "AA1") 
        {
          aai = 1;
        }
      }
    }
  }

  if ( (document.forms["form1"].elements["cmbsucursaladesa"].value == "") && (adesa == "1") ) 
  {
    alert('Ingrese la direccion de entrega (ADESA)');
    document.forms["form1"].elements["cmbsucursaladesa"].focus();
    return (false);
  }

  if ( (document.forms["form1"].elements["cmbsucursalaai"].value == "") && (aai == "1") ) 
  {
    alert('Ingrese la direccion de entrega (AAI)');
    document.forms["form1"].elements["cmbsucursalaai"].focus();
    return (false);
  }

  return (true);
}

//  BOTON (CERRAR FORMULARIO)
$("#btnclose_").click(function () 
{
    window.location.href = baseurl + "PedidoController/pedido";
});