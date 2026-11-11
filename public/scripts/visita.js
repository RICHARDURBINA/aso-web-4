//===============================================================================================================================================
//
//===============================================================================================================================================
let i_numero = 0;

$( document ).ready(function(){
  iniciarformulario();
});

//*****************************************************************************
//
//*****************************************************************************
function iniciarformulario() {

  // INICIAR COMBOS
  $('#cmbcliente').empty();
  $('#cmbcliente').append(new Option('', '', true, true));
  llenarcombocliente();

  //document.forms["form1"].elements["fila_prd_actual"].value = "";
  document.forms["form1"].elements["totalprd"].value = "0";
  document.forms["form1"].elements["operacion"].value = "1";

  document.forms["form1"].elements["accion[1]"].disabled = true;
  document.forms["form1"].elements["accion[2]"].disabled = true;

  document.forms["form1"].elements["var_inventario"].value = "0";
  document.forms["form1"].elements["var_competencias"].value = "0";  

  document.forms["form1"].elements["cmbcliente"].focus();

  $("#btnaddprd_").hide();
  $("#content_comp").hide();
  $("#content_prd").hide();

}

//*****************************************************************************
//
//*****************************************************************************
function llenarcombocliente() {

  var operacion = document.forms["form1"].elements["operacion"].value;

  $.ajax({
    type: "POST",
    url: baseurl + "ClienteController/consultar_cliente_zona_usuario",
    data: {  },

    success: function( respuesta ){
      //alert(respuesta);

      if (respuesta.includes("A PHP Error was encountered")) {
          //Inicio satisfactorio ENVIAR A PAGINA ERROR
          alert(respuesta);
          //window.location.href = baseurl + "errorController/mostrar_error/"+respuesta;
      }
      else {
        var respuesta = JSON.parse(respuesta);

        if (respuesta.resultado == "1") {
          $.each(respuesta.arreglo, function (i, item) {
            $('#cmbcliente').append(new Option(item.nb_organizacion, item.co_organizacion));
          });
        }
        else if (respuesta.resultado == "ERROR") {
          alert(respuesta.msn);
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
$('#cmbcliente').on('change', function() {

  var operacion = document.forms["form1"].elements["operacion"].value;

  if(operacion == '1') {

    if(!(document.forms["form1"].elements["cmbcliente"].value == "")) {

      var cocliente = document.forms["form1"].elements["cmbcliente"].value;

      $.ajax({
        type: "POST",
        url: baseurl + "ProductoController/consultar_producto_cliente",
        data: {txtcodigo : "%",
               txtnombre : "%",
               cocliente : cocliente,
               coempresa : "%"},
        success: function (respuesta) {
          //alert(respuesta);

          if (respuesta.includes("A PHP Error was encountered")) {
              //Inicio satisfactorio ENVIAR A PAGINA ERROR
              alert(respuesta);
              //window.location.href = baseurl + "errorController/mostrar_error/"+respuesta;
          }
          else {
            var respuesta = JSON.parse(respuesta);

            if (respuesta.resultado == "1") {
              //alert("idempresatipoempresa_" + respuesta.arregloproducto[0]["idempresatipoempresa"]);

              //--------------------------------------------------------------------------------------
              //--------------------------------------------------------------------------------------
              const miDiv = document.getElementById('content_prd');
              miDiv.textContent = '';
              //--------------------------------------------------------------------------------------
              //--------------------------------------------------------------------------------------

              //alert(respuesta.arregloproducto.length);

              document.forms["form1"].elements["totalprd"].value = respuesta.arregloproducto.length;

              for(i=0; i<respuesta.arregloproducto.length; i++)
              {
                var id_prd = respuesta.arregloproducto[i]["id_registro"];
                var co_prd = respuesta.arregloproducto[i]["co_producto"];
                var nb_prd  = respuesta.arregloproducto[i]["nb_producto"];
                var pr_prd  = respuesta.arregloproducto[i]["pr_producto"];
                var prm_prd  = respuesta.arregloproducto[i]["pr_producto_mayor"];
                var co_emp  = respuesta.arregloproducto[i]["co_empresa"];

                add_item_prd(i, id_prd, co_prd, nb_prd, pr_prd, prm_prd, co_emp);
              }

              document.forms["form1"].elements["accion[1]"].disabled = false;
              document.forms["form1"].elements["accion[2]"].disabled = false;

              $("#content_prd").hide();
              $("#content_comp").hide();
              //$("#content_prd").show();
            }
            else if (respuesta.resultado == "ERROR") {
              alert(respuesta.msn);
            }
            else if (respuesta.resultado == "0") {
              alert("No retornarón datos de productos esperados");
            }
            else {
              alert("No retornarón datos esperados");
            }
          }

        },
        error: function(xhr, status, error) 
        {
            alert("Error crítico de comunicación con el servidor: " + error);
        }
      });
    }
    else {
      const miDiv = document.getElementById('content_prd');
      miDiv.textContent = '';
      $("#content_prd").hide();
      $("#content_comp").hide();
      document.forms["form1"].elements["accion[1]"].checked = false;
      document.forms["form1"].elements["accion[1]"].disabled = true;
      document.forms["form1"].elements["accion[2]"].checked = false;
      document.forms["form1"].elements["accion[2]"].disabled = true;
    }
  }
});

//========================================================================================================
// AGREGAR ITEM DINAMICOS DATATABLE TAB 1
//========================================================================================================
function add_item_prd(fila_i, id_prd, co_prd, nb_prd, pr_prd, prm_prd, co_emp)
{
  html = '<div class="row" id="row_' + fila_i + '">';

  html += '<div class="col-md-3">';
  html += '<div class="form-floating form-floating-outline mb-6">';
  html += '<input type="hidden" name="coemp[' + fila_i + ']" id="coemp[' + fila_i + ']" value="'+ co_emp +'" />';
  html += '<input type="hidden" name="idprd[' + fila_i + ']" id="idprd[' + fila_i + ']" value="'+ id_prd +'" />';
  html += '<input type="hidden" name="coprd[' + fila_i + ']" id="coprd[' + fila_i + ']" value="'+ co_prd +'" />';
  html += '<textarea class="form-control h-px-80" name="nbprd[' + fila_i + ']" id="nbprd[' + fila_i + ']" placeholder="" readonly>';
  html += nb_prd;
  html += '</textarea>';
  html += '<label for="nbprd[' + fila_i + ']">Producto</label>';
  html += '</div>';
  html += '</div>';

  html += '<div class="col-md-1">';
  html += '<div class="form-floating form-floating-outline mb-6">';
  html += '<input type="text" class="form-control mayus" name="lote_nu_prd[]" id="lote_nu_prd[' + fila_i + ']" value="" maxlength="8" />';
  html += '<label for="lote_nu_prd[' + fila_i + ']">N° Lote</label>';
  html += '</div>';
  html += '</div>';

  html += '<div class="col-md-2">';
  html += '<div class="form-floating form-floating-outline mb-6">';
  html += '<input type="date" class="form-control" name="lote_fe_prd[]" id="lote_fe_prd[' + fila_i + ']" value="" />';
  html += '<label for="lote_fe_prd[' + fila_i + ']">Fecha VNC Lote</label>';
  html += '</div>';
  html += '</div>';

  html += '<div class="col-md-2">';
  html += '<div class="form-floating form-floating-outline mb-6">';
  html += '<input type="number" class="form-control" name="ca_prd_b_e[]" id="ca_prd_b_e[' + fila_i + ']" value="0" min="0" maxlength="4" placeholder="0" onkeypress="ValidaSoloNumeros(event)" />';
  html += '<label for="ca_prd_b_e[' + fila_i + ']">Cant. Buen Edo.</label>';
  html += '</div>';
  html += '</div>';

  html += '<div class="col-md-2">';
  html += '<div class="form-floating form-floating-outline mb-6">';
  html += '<input type="number" class="form-control" name="ca_prd_m_e[]" id="ca_prd_m_e[' + fila_i + ']" value="0" min="0" maxlength="4" placeholder="0" onkeypress="ValidaSoloNumeros(event)" />';
  html += '<label for="ca_prd_m_e[' + fila_i + ']">Cant. Mal Edo.</label>';
  html += '</div>';
  html += '</div>';

  html += '<div class="col-md-2">';
  html += '<div class="form-floating form-floating-outline mb-6">';
  html += '<input type="number" class="form-control" name="ca_prd_m_e_t[]" id="ca_prd_m_e_t[' + fila_i + ']" value="0" min="0" maxlength="4" placeholder="0" onkeypress="ValidaSoloNumeros(event)" />';
  html += '<label for="ca_prd_m_e_t[' + fila_i + ']">Cant. Mal Edo. Tercero</label>';
  html += '</div>';
  html += '</div>';

  html += '<hr class="mt-0">';

  html += '</div>';

  $('#content_prd').append(html);
}

//========================================================================================================
// AGREGAR ITEM DINAMICOS DATATABLE TAB 1
//========================================================================================================
function add_item_comp()
{

  html = '<div class="row" id="srow_' + i_numero + '">';

  html += '<div class="col-md-3">';
  html += '<div class="form-floating form-floating-outline mb-6">';
  html += '<input type="text" class="form-control" name="comp_prd_marca[]" id="comp_prd_marca[' + i_numero + ']" value="" maxlength="150" placeholder="">';
  html += '<label for="comp_prd_marca[' + i_numero + ']">Marca</label>';
  html += '</div>';
  html += '</div>';
  html += '<div class="col-md-3">';
  html += '<div class="form-floating form-floating-outline mb-6">';
  html += '<input type="text" class="form-control" name="comp_prd_pres[]" id="comp_prd_pres[' + i_numero + ']" value="" maxlength="150" placeholder="">';
  html += '<label for="comp_prd_pres[' + i_numero + ']">Presentacion</label>';
  html += '</div>';
  html += '</div>';
  html += '<div class="col-md-2">';
  html += '<div class="form-floating form-floating-outline mb-6">';
  html += '<input type="number" class="form-control" name="comp_prd_precio[]" id="comp_prd_precio[' + i_numero + ']" maxlength="4" placeholder="0" onkeypress="ValidaSoloNumeros(event)">';
  html += '<label for="comp_prd_precio[' + i_numero + ']">Precio ($)</label>';
  html += '</div>';
  html += '</div>';
  html += '<div class="col-md-2">';
  html += '<div class="form-floating form-floating-outline mb-6">';
  html += '<input type="number" class="form-control" name="comp_prd_precio_v[]" id="comp_prd_precio_v[' + i_numero + ']" maxlength="4" placeholder="0" onkeypress="ValidaSoloNumeros(event)">';
  html += '<label for="comp_prd_precio_v[' + i_numero + ']">Precio Segun Vendedor ($)</label>';
  html += '</div>';
  html += '</div>';
  html += '<div class="col-md-2">';
  html += '<button type="button" class="btn btn-icon me-2 btn-danger eliminiar_comp" id="btnremove_prd" title="Eliminar" var-id="' + i_numero + '">';
  html += '<span class="icon-base ri ri-delete-bin-2-fill icon-22px"></span>';
  html += '</button>';
  html += '</div>';
  html += '<hr class="mt-0">';

  html += '</div>';

  i_numero++;

  $('#content_comp_detalle').append(html);

  $('.eliminiar_comp').click(function(){

    let id = $(this).attr('var-id');
    console.log(id)
    $('#srow_' + id).remove();
  });

}

//*****************************************************************************
//
//*****************************************************************************
function change_check(e)
{

  if(e.checked == true && e.value == 'INVENTARIO')
  {
    document.forms["form1"].elements["var_inventario"].value = "1";
    $("#content_prd").show();
  }

  if(e.checked == true && e.value == 'COMPETENCIAS')
  {
    document.forms["form1"].elements["var_competencias"].value = "1";
    $("#content_comp").show();
    $("#btnaddprd_").show();
  }

  if(e.checked == false && e.value == 'INVENTARIO')
  {
    // Selecciona el div contenedor
    const divContenedor = document.getElementById("content_prd");

    // Selecciona todos los inputs (text, select, textarea, etc.) dentro del div
    const inputs = divContenedor.querySelectorAll("input, select, textarea");

    // Itera sobre los elementos y establece su valor a una cadena vacía
    inputs.forEach(inputElement => {

        if((inputElement.name == 'lote_nu_prd[]')||(inputElement.name == 'lote_fe_prd[]'))
        {
          inputElement.value = '';
        }

        if((inputElement.name == 'ca_prd_b_e[]')||(inputElement.name == 'ca_prd_m_e[]')||(inputElement.name == 'ca_prd_m_e_t[]'))
        {
          inputElement.value = 0;
        }
    });

    document.forms["form1"].elements["var_inventario"].value = "0";    
    $("#content_prd").hide();
    $("#btnaddprd_").hide();
  }

  if(e.checked == false && e.value == 'COMPETENCIAS')
  {
    // Selecciona el div contenedor
    const divContenedor = document.getElementById("content_comp_detalle");

    // Selecciona todos los inputs (text, select, textarea, etc.) dentro del div
    const inputs = divContenedor.querySelectorAll("input, select, textarea");

    // Itera sobre los elementos y establece su valor a una cadena vacía
    inputs.forEach(inputElement => {

        if((inputElement.name == 'comp_prd_marca[]')||(inputElement.name == 'comp_prd_pres[]'))
        {
          inputElement.value = '';
        }

        if((inputElement.name == 'comp_prd_precio[]')||(inputElement.name == 'comp_prd_precio_v[]'))
        {
          inputElement.value = 0;
        }
    });

    document.forms["form1"].elements["var_competencias"].value = "0";
    $("#content_comp").hide();
    $("#btnaddprd_").hide();
  }
}

//*****************************************************************************
//
//*****************************************************************************
$("#btnsave").click(function () {

  if(validar_form() == true) {

    document.forms["form1"].elements["btnsave"].disabled = true;

    $("#btnclose_").focus();

    if (confirm('\u00BFEsta seguro de guardar el registro de visita?')) {

      var operacion = document.forms["form1"].elements["operacion"].value;

      var str = $("#form1").serialize();
      var co_cliente = $('#cmbcliente').val();

      console.log(str);

      if (operacion == '1') {

        $.ajax({
          type: "POST",
          url: baseurl + "VisitaController/guardar_visita",
          data: str,
          success: function (respuesta) {

            console.log(respuesta)

            if (respuesta.includes("A PHP Error was encountered")) {
                //Inicio satisfactorio ENVIAR A PAGINA ERROR
                alert(respuesta);
                //window.location.href = baseurl + "errorController/mostrar_error/"+respuesta;
            }
            else {
              var respuesta = JSON.parse(respuesta);

              if (respuesta.resultado == "1") {

                Swal.fire({
                  title: "Registro Satisfactorio!",
                  text: "Desea continuar a las siguientes pantallas?",
                  icon: 'success',
                  showDenyButton: true,
                  showCancelButton: true,
                  allowOutsideClick: false,
                  confirmButtonText: "Cobranza",
                  confirmButtonColor: '#278321',
                  denyButtonText: "Pedido",
                  denyButtonColor: '#58ABD5',
                  cancelButtonText: "Cancelar",
                  cancelButtonColor: '#ccc',
                }).then((result) => {
                  if (result.isConfirmed){
                    window.location.href = baseurl + "CobranzaController/cobranza/?co_cliente=" + co_cliente;
                  } else if (result.isDenied) {
                    window.location.href = baseurl + "PedidoController/pedido/?co_cliente=" + co_cliente;
                  } else{
                    window.location.href = baseurl + "VisitaController/visita/";
                  }
                });
              }
              else if (respuesta.resultado == "ERROR") {
                alert(respuesta.msn);
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
    else {
       document.forms["form1"].elements["btnsave"].disabled = false;
    }
  }

});

//*****************************************************************************
//
//*****************************************************************************
function validar_form() {

  // VALIDACION DE IDVENDEDOR
  if (document.forms["form1"].elements["idvendedor"].value.length < 1) {
    alert('Indique el vendedor');
    document.forms["form1"].elements["nbvendedor"].focus();
    return (false);
  }

  // VALIDACION DE NBVENDEDOR
  if (document.forms["form1"].elements["nbvendedor"].value.length < 1) {
    alert('Indique el vendedor');
    document.forms["form1"].elements["nbvendedor"].focus();
    return (false);
  }

  // VALIDACION DE FECHA
  if (document.forms["form1"].elements["fecha"].value.length < 1) {
    alert('Indique la fecha de registro');
    document.forms["form1"].elements["fecha"].focus();
    return (false);
  }

  // VALIDACION DE CLIENTE
  if(document.forms["form1"].elements["cmbcliente"].value == "")
  {
    alert('Ingrese el cliente');
    document.forms["form1"].elements["cmbcliente"].focus();
    return (false);
  }

  // VALIDACION DE TIPO VISITA
  if(document.forms["form1"].elements["cmbvisita"].value == "")
  {
    alert('Ingrese el tipo de visita');
    document.forms["form1"].elements["cmbvisita"].focus();
    return (false);
  }

  var accion_inventario = false;
  var valida_inventario = false;

  const input_accion = document.getElementsByName('accion[]');

  // Iterar sobre la colección
  input_accion.forEach(function(input) {

    if(input.checked == true && input.value == 'INVENTARIO')
    {
      accion_inventario = true;

      for (i = 0; i < document.forms["form1"].elements.length; i++)
      {
        if ( (document.forms["form1"].elements[i].name == "ca_prd_b_e[]") ||
             (document.forms["form1"].elements[i].name == "ca_prd_m_e[]") ||
             (document.forms["form1"].elements["i"].name == "ca_prd_m_e_t[]") )
        {
          if (document.forms["form1"].elements[i].value > 0)
          {
              valida_inventario = true;
          }
        }
      }
    }

  });

  if(accion_inventario == true && valida_inventario == false)
  {
      alert('Seleccione algun producto para el registro de visita');
      document.forms["form1"].elements["cmbcliente"].focus();
      return (false);
  }

  else {
    return (true);
  }


}

//  BOTON (CERRAR FORMULARIO)
$("#btnclose_").click(function () {
    window.location.href = baseurl + "VisitaController/visita/";
});