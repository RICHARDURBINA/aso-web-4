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

  consultar_visita();

}


//*****************************************************************************
//
//*****************************************************************************
function consultar_visita() {

  var id_vis_web = document.forms["form1"].elements["id_vis_web"].value;

  $.ajax({
    type: "POST",
    url: baseurl + "VisitaController/consultar_visita",
    data: {id_vis_web : id_vis_web},
    success: function (respuesta) {
      //alert(respuesta);

      // Validación segura por si la respuesta es texto plano o un objeto JSON
      if (typeof respuesta === "string" && respuesta.includes("A PHP Error was encountered")) {
          alert(respuesta);
      }
      else {
        var respuesta = (typeof respuesta === "string") ? JSON.parse(respuesta) : respuesta;

        console.log(respuesta)

        if (respuesta.resultado == "1") {

          $('#form1')[0].reset(); // reset form on modals
          document.forms["form1"].elements["operacion"].value = "2";

          document.forms["form1"].elements["idvendedor"].value = respuesta.Model_consultar_visita[0]["id_vendedor"];
          document.forms["form1"].elements["nbvendedor"].value = respuesta.Model_consultar_visita[0]["nb_vendedor"];
          document.forms["form1"].elements["fecha"].value = respuesta.Model_consultar_visita[0]["fe_emision"];
          document.forms["form1"].elements["txtobs"].value = respuesta.Model_consultar_visita[0]["tx_observacion"];
          document.forms["form1"].elements["cmbcliente"].value = respuesta.Model_consultar_visita[0]["nb_organizacion"];

          if(respuesta.Model_consultar_visita[0]["tipo"] == "F")
          {
            document.forms["form1"].elements["cmbvisita"].value = "FISICA";
          }

          if(respuesta.Model_consultar_visita[0]["tipo"] == "T")
          {
            document.forms["form1"].elements["cmbvisita"].value = "TELEFONICA";
          }

          // Selecciona el h5 con la clase 'card-header'
          const titulo = document.querySelector('.card-header');

          // Cambia el texto
          titulo.textContent = titulo.textContent + " (" + respuesta.Model_consultar_visita[0]["ctv_de_estado_documento"] + ")";

          for(i = 0; i < respuesta.Model_consultar_visita.length; i++)
          {
            var id_prd = respuesta.Model_consultar_visita[i]["prd_id_producto_aso"];
            var co_prd = respuesta.Model_consultar_visita[i]["co_producto"];
            var nb_prd = respuesta.Model_consultar_visita[i]["nb_producto"];
            var lo_prd     = respuesta.Model_consultar_visita[i]["nu_lote"];
            var fe_lo_prd  = respuesta.Model_consultar_visita[i]["fe_vencimiento_lote"];
            var ca_prd_b   = respuesta.Model_consultar_visita[i]["ca_buena_condicion"];
            var ca_prd_m_p = respuesta.Model_consultar_visita[i]["ca_mala_condicion_propio"];
            var ca_prd_m_t = respuesta.Model_consultar_visita[i]["ca_mala_condicion_tercero"];
            var ca_prd_sol = respuesta.Model_consultar_visita[i]["ca_solicitada"];

            if(lo_prd === null){lo_prd = "";}
            if(fe_lo_prd === null){fe_lo_prd = "";}

            if(id_prd != null)
            {
              ca_prd_b = parseFloat(ca_prd_b.replace(',', '.'));
              ca_prd_m_p = parseFloat(ca_prd_m_p.replace(',', '.'));
              ca_prd_m_t = parseFloat(ca_prd_m_t.replace(',', '.'));

              add_item_prd(i, id_prd, co_prd, nb_prd, lo_prd, fe_lo_prd, ca_prd_b, ca_prd_m_p, ca_prd_m_t, ca_prd_sol);
            }
          }

          for(i = 0; i < respuesta.Model_consultar_competencias.length; i++)
          {
            var comp_prd_marca = respuesta.Model_consultar_competencias[i]["comp_prd_marca"];
            var comp_prd_pres = respuesta.Model_consultar_competencias[i]["comp_prd_pres"];
            var comp_prd_precio = respuesta.Model_consultar_competencias[i]["comp_prd_precio"];
            var comp_prd_precio_v = respuesta.Model_consultar_competencias[i]["comp_prd_precio_v"];

            if(comp_prd_pres === null){comp_prd_pres = "";}

            comp_prd_precio = parseFloat(comp_prd_precio.replace(',', '.'));
            comp_prd_precio_v = parseFloat(comp_prd_precio_v.replace(',', '.'));

            add_item_comp(comp_prd_marca, comp_prd_pres, comp_prd_precio, comp_prd_precio_v);
          }

          if(respuesta.Model_consultar_visita[0]["prd_id_producto_aso"] != null){
            document.forms["form1"].elements["accion[1]"].checked = true;
            $("#content_prd").show();
          }

          if(respuesta.Model_consultar_competencias.length > 0) {
            document.forms["form1"].elements["accion[2]"].checked = true;
            $("#content_comp").show();
          }

        }
        else if (respuesta.resultado == "0") {
          alert("No retornaron datos esperados");
          window.location.href = baseurl + "VisitaController/listavisita/";
        }
        else if (respuesta.resultado == "ERROR") {
          alert(respuesta.msn);
          window.location.href = baseurl + "VisitaController/listavisita/";
        }
        else {
          alert("No retornaron datos esperados");
          window.location.href = baseurl + "VisitaController/listavisita/";
        }
      }

    },
    error: function(xhr, status, error) 
    {
        alert("Error crítico de comunicación con el servidor: " + error);
    }
  });
}

//========================================================================================================
// AGREGAR ITEM DINAMICOS DATATABLE TAB 1
//========================================================================================================
function add_item_prd(fila_i, id_prd, co_prd, nb_prd, lo_prd, fe_lo_prd, ca_prd_b, ca_prd_m_p, ca_prd_m_t, ca_prd_sol)
{
  html = '<div class="row" id="row_' + fila_i + '">';

  html += '<div class="col-md-3">';
  html += '<div class="form-floating form-floating-outline mb-6">';
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
  html += '<input type="text" class="form-control mayus" name="lote_nu_prd[]" id="lote_nu_prd[' + fila_i + ']" value="'+ lo_prd +'" maxlength="8" readonly/>';
  html += '<label for="lote_nu_prd[' + fila_i + ']">N° Lote</label>';
  html += '</div>';
  html += '</div>';

  //alert(fe_lo_prd);

  html += '<div class="col-md-2">';
  html += '<div class="form-floating form-floating-outline mb-6">';
  html += '<input type="text" class="form-control" name="lote_fe_prd[]" id="lote_fe_prd[' + fila_i + ']" value="'+ fe_lo_prd +'" readonly/>';
  html += '<label for="lote_fe_prd[' + fila_i + ']">Fecha VNC Lote</label>';
  html += '</div>';
  html += '</div>';

  html += '<div class="col-md-2">';
  html += '<div class="form-floating form-floating-outline mb-6">';
  html += '<input type="number" class="form-control" name="ca_prd_b_e[]" id="ca_prd_b_e[' + fila_i + ']" value="'+ ca_prd_b +'" min="0" maxlength="4" placeholder="0" onkeypress="ValidaSoloNumeros(event)" readonly/>';
  html += '<label for="ca_prd_b_e[' + fila_i + ']">Cant. Buen Edo.</label>';
  html += '</div>';
  html += '</div>';

  html += '<div class="col-md-2">';
  html += '<div class="form-floating form-floating-outline mb-6">';
  html += '<input type="number" class="form-control" name="ca_prd_m_e[]" id="ca_prd_m_e[' + fila_i + ']" value="'+ ca_prd_m_p +'" min="0" maxlength="4" placeholder="0" onkeypress="ValidaSoloNumeros(event)" readonly/>';
  html += '<label for="ca_prd_m_e[' + fila_i + ']">Cant. Mal Edo.</label>';
  html += '</div>';
  html += '</div>';

  html += '<div class="col-md-2">';
  html += '<div class="form-floating form-floating-outline mb-6">';
  html += '<input type="number" class="form-control" name="ca_prd_m_e_t[]" id="ca_prd_m_e_t[' + fila_i + ']" value="'+ ca_prd_m_t +'" min="0" maxlength="4" placeholder="0" onkeypress="ValidaSoloNumeros(event)" readonly/>';
  html += '<label for="ca_prd_m_e_t[' + fila_i + ']">Cant. Mal Edo. Tercero</label>';
  html += '</div>';
  html += '</div>';

  html += '<hr class="mt-0">';

  html += '</div>';

  $('#content_prd').append(html);
}

function add_item_comp(comp_prd_marca, comp_prd_pres, comp_prd_precio, comp_prd_precio_v)
{

  html = '<div class="row" id="row_' + i_numero + '">';

  html += '<div class="col-md-3">';
  html += '<div class="form-floating form-floating-outline mb-6">';
  html += '<input type="text" class="form-control" name="comp_prd_marca[]" id="comp_prd_marca[' + i_numero + ']" value="' + comp_prd_marca + '" maxlength="150" placeholder="">';
  html += '<label for="comp_prd_marca[' + i_numero + ']">Marca</label>';
  html += '</div>';
  html += '</div>';
  html += '<div class="col-md-3">';
  html += '<div class="form-floating form-floating-outline mb-6">';
  html += '<input type="text" class="form-control" name="comp_prd_pres[]" id="comp_prd_pres[' + i_numero + ']" value="' + comp_prd_pres + '" maxlength="150" placeholder="">';
  html += '<label for="comp_prd_pres[' + i_numero + ']">Presentacion</label>';
  html += '</div>';
  html += '</div>';
  html += '<div class="col-md-2">';
  html += '<div class="form-floating form-floating-outline mb-6">';
  html += '<input type="number" class="form-control" name="comp_prd_precio[]" id="comp_prd_precio[' + i_numero + ']" value="' + comp_prd_precio + '" maxlength="4" placeholder="0" onkeypress="ValidaSoloNumeros(event)">';
  html += '<label for="comp_prd_precio[' + i_numero + ']">Precio ($)</label>';
  html += '</div>';
  html += '</div>';
  html += '<div class="col-md-2">';
  html += '<div class="form-floating form-floating-outline mb-6">';
  html += '<input type="number" class="form-control" name="comp_prd_precio_v[]" id="comp_prd_precio_v[' + i_numero + ']" value="' + comp_prd_precio_v + '" maxlength="4" placeholder="0" onkeypress="ValidaSoloNumeros(event)">';
  html += '<label for="comp_prd_precio_v[' + i_numero + ']">Precio Segun Vendedor ($)</label>';
  html += '</div>';
  html += '</div>';
  html += '<hr class="mt-0">';

  html += '</div>';

  i_numero++;

  $('#content_comp_detalle').append(html);

}

//*****************************************************************************
//  BOTON (CERRAR FORMULARIO)
//*****************************************************************************
$("#btnclose_").click(function () {
    window.location.href = baseurl + "VisitaController/listavisita/";
});