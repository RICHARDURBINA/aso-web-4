//===============================================================================================================================================
//
//===============================================================================================================================================
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
      var res = (typeof respuesta === 'object') ? respuesta : JSON.parse(respuesta);

      if (res.resultado == "1") {
        $.each(res.arreglo, function (i, item) {
          $('#cmbcliente').append(new Option(item.nb_organizacion, item.co_organizacion));
        });
      }
      else if (res.resultado == "ERROR") {
        alert(res.msn);
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
function iniciarformulario() {

  // INICIAR COMBOS
  $('#cmbcliente').empty();
  $('#cmbcliente').append(new Option('', '', true, true));
  llenarcombocliente();

  document.forms["form1"].elements["fila_prd_actual"].value = "";
  document.forms["form1"].elements["totalprd"].value = "0";
  document.forms["form1"].elements["operacion"].value = "1"; 

  consultar_pedido();
  
}


//*****************************************************************************
//
//*****************************************************************************
function consultar_pedido() {

  var id_ped_web = document.forms["form1"].elements["id_ped_web"].value;
  var id_doc_emp = document.forms["form1"].elements["id_doc_emp"].value;
 
  $.ajax({
    type: "POST",
    url: baseurl + "PedidoController/consultar_pedido",
    data: {id_ped_web : id_ped_web, id_doc_emp : id_doc_emp},
    success: function (respuesta) {
      var res = (typeof respuesta === 'object') ? respuesta : JSON.parse(respuesta);

      if (res.resultado == "1") {

        $('#form1')[0].reset(); // reset form on modals
        document.forms["form1"].elements["operacion"].value = "2";

        document.forms["form1"].elements["idvendedor"].value = res.Model_consultar_pedido[0]["id_vendedor"];
        document.forms["form1"].elements["nbvendedor"].value = res.Model_consultar_pedido[0]["nb_vendedor"];
        document.forms["form1"].elements["fecha"].value = res.Model_consultar_pedido[0]["fe_emision"];

        if(res.Model_consultar_pedido[0]["in_condicion_pago"] == "CO")
        {
          document.forms["form1"].elements["cmbconpag"].value = "CONTADO";
        }

        if(res.Model_consultar_pedido[0]["in_condicion_pago"] == "CR")
        {
          document.forms["form1"].elements["cmbconpag"].value = "CREDITO";
        }

        document.forms["form1"].elements["cmbcliente"].value = res.Model_consultar_pedido[0]["nb_organizacion"];

        //--------------------------------------------------------------------------------------------------
        //--------------------------------------------------------------------------------------------------
        var est_doc = "";
        var cad_est_doc = "";
        var estatus = "";

        for (j = 0; j < res.Model_consultar_pedido.length; j++)
        {          
          
          if ( (res.Model_consultar_pedido[j]["fec_nos"] == null) && (res.Model_consultar_pedido[j]["fec_fac"] == null) ) {
            estatus = res.Model_consultar_pedido[j]["ctv_de_estado_documento"];
          }

          if ( (res.Model_consultar_pedido[j]["fec_nos"] != null) && (res.Model_consultar_pedido[j]["fec_fac"] != null) ) {
            estatus = "DESPACHADO";
          }

          if ( (res.Model_consultar_pedido[j]["fec_nos"] != null) && (res.Model_consultar_pedido[j]["fec_fac"] == null) ) {
            estatus = "DESPACHADO";
          }

          if ( (res.Model_consultar_pedido[j]["fec_nos"] == null) && (res.Model_consultar_pedido[j]["fec_fac"] != null) ) {
            estatus = "FACTURADO";
          }            

          if(est_doc == "") 
          {
            est_doc     = res.Model_consultar_pedido[j]["co_empresa"] + " - " + estatus;
            cad_est_doc = res.Model_consultar_pedido[j]["co_empresa"] + " - " + estatus;
          }
          else 
          {
            if(est_doc != res.Model_consultar_pedido[j]["co_empresa"] + " - " + estatus) 
            {
              cad_est_doc = cad_est_doc + " // " + res.Model_consultar_pedido[j]["co_empresa"] + " - " + estatus;
            }
          }
        }

        // Selecciona el h5 con la clase 'card-header'
        const titulo = document.querySelector('.card-header');

        // Cambia el texto
        titulo.textContent = titulo.textContent + " (" + cad_est_doc + ")";

        //--------------------------------------------------------------------------------------------------
        //--------------------------------------------------------------------------------------------------
        for (x = 0; x < res.Model_consultar_pedido.length; x++)
        {
          if(res.Model_consultar_pedido[x]["co_empresa"] == "ADESA")
          {
            document.forms["form1"].elements["cmbsucursaladesa"].value = res.Model_consultar_pedido[x]["tx_direccion_entrega"];
          }

          if(res.Model_consultar_pedido[x]["co_empresa"] == "AA1")
          {
            document.forms["form1"].elements["cmbsucursalaai"].value = res.Model_consultar_pedido[x]["tx_direccion_entrega"];
          } 
        }

        //--------------------------------------------------------------------------------------------------
        //--------------------------------------------------------------------------------------------------
        document.forms["form1"].elements["txtobs"].value = res.Model_consultar_pedido[0]["tx_observacion"];  

        for(i = 0; i < res.Model_consultar_pedido.length; i++)
        {
          var co_emp = res.Model_consultar_pedido[i]["co_empresa"];
          var id_prd = res.Model_consultar_pedido[i]["prd_id_producto_aso"];
          var co_prd = res.Model_consultar_pedido[i]["co_producto"];
          var nb_prd = res.Model_consultar_pedido[i]["nb_producto"];

          var pr_prd = res.Model_consultar_pedido[i]["pr_producto"]; 
          var ca_prd = res.Model_consultar_pedido[i]["ca_producto"];
          var ca_prom_prd = res.Model_consultar_pedido[i]["ca_producto_promo"]; 
          var ca_desc_prd = res.Model_consultar_pedido[i]["pc_descuento"];  
          var tipo_desc = res.Model_consultar_pedido[i]["tipo_descuento"];   

          var ped_prd = res.Model_consultar_pedido[i]["pedido_producto_aso"];    

          if(tipo_desc === null){tipo_desc = "";}   

          pr_prd = parseFloat(pr_prd.replace(',', '.'));
          ca_prd = parseFloat(ca_prd.replace(',', '.')); 
          ca_prom_prd = parseFloat(ca_prom_prd.replace(',', '.')); 
          ca_desc_prd = parseFloat(ca_desc_prd.replace(',', '.'));     
          
          add_item_prd(i, co_emp, id_prd, co_prd, nb_prd, pr_prd, ca_prd, ca_prom_prd, ca_desc_prd, tipo_desc, ped_prd, res.Model_consultar_pedido_desc);
        } 
        //--------------------------------------------------------------------------------------------------
        //--------------------------------------------------------------------------------------------------

      }
      else if (res.resultado == "0") {
        alert("No retornaron datos esperados");        
        window.location.href = baseurl + "PedidoController/listapedido/";
      }
      else if (res.resultado == "ERROR") {
        alert(res.msn);
        window.location.href = baseurl + "PedidoController/listapedido/";
      }      
      else {
        alert("No retornaron datos esperados");       
        window.location.href = baseurl + "PedidoController/listapedido/";
      }   
    },
    error: function(xhr, status, error) {
        alert("Error crítico de comunicación con el servidor: " + error);
    }      
  });
}

//========================================================================================================
// AGREGAR ITEM DINAMICOS DATATABLE TAB 1
//========================================================================================================
function add_item_prd(fila_i, co_emp, id_prd, co_prd, nb_prd, pr_prd, ca_prd, ca_prom_prd, ca_desc_prd, tipo_desc, ped_prd, arr_desc)
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
  html += '<input type="number" class="form-control" name="caprd[' + fila_i + ']" id="caprd[' + fila_i + ']" value="'+ ca_prd +'" min="0" maxlength="4" placeholder="0" onkeypress="ValidaSoloNumeros(event)" readonly/>';
  html += '<label for="caprd[' + fila_i + ']">Cantidad</label>';
  html += '</div>';
  html += '</div>';

  html += '<div class="col-md-1">';
  html += '<div class="form-floating form-floating-outline mb-6">';
  html += '<input type="number" class="form-control" name="promprd[' + fila_i + ']" id="promprd[' + fila_i + ']" value="'+ ca_prom_prd +'" min="0" maxlength="4" placeholder="0" onkeypress="ValidaSoloNumeros(event)" readonly/>';
  html += '<label for="promprd[' + fila_i + ']">Promoción</label>';
  html += '</div>';
  html += '</div>';

  html += '<div class="col-md-1">';
  html += '<div class="form-floating form-floating-outline mb-6">';
  html += '<input type="number" class="form-control" name="descprd[' + fila_i + ']" id="descprd[' + fila_i + ']" value="'+ ca_desc_prd +'" min="0" maxlength="4" placeholder="0" onkeypress="ValidaSoloNumeros(event)" readonly/>';
  html += '<label for="descprd[' + fila_i + ']">Descuento</label>';
  html += '</div>';
  html += '</div>';

  html += '<input type="hidden" name="tipodesc[' + fila_i + ']" id="tipodesc[' + fila_i + ']" value="" readonly/>';
  
  html += '<div class="col-md-1">';
  html += '<div class="form-floating form-floating-outline mb-6">';
  html += '<button type="button" class="btn btn-icon me-2 btn-primary " id="btnadd_desc" name="btnadd_desc"  title="Agregar" onclick="fn_open_modal_desc(' + fila_i + ')">';
  html += '<span class="icon-base ri ri-list-view icon-22px"></span>';
  html += '</button>';
  html += '</div>';
  html += '</div>';  
  html += '<hr class="mt-0">';

  html += '<div id="cont_porc_desc_' + fila_i + '">';

  for(y = 0; y < arr_desc.length; y++)
  {
    if(arr_desc[y]["pcp_id_pedido_producto_aso"] == ped_prd)
    {
      html += '<input type="hidden" name="dia[' + fila_i + '][]" id="dia[' + fila_i + '][' + y + ']" value="' + arr_desc[y]["ca_dias_descuento"] + '">';
      html += '<input type="hidden" name="porc[' + fila_i + '][]" id="porc[' + fila_i + '][' + y + ']" value="' + arr_desc[y]["pc_descuento"] + '">';
    }    
  } 

  html += '</div>';
  html += '<input type="hidden" name="total_desc_prd_actual[' + fila_i + ']" id="total_desc_prd_actual[' + fila_i + ']" value="0" />';

  html += '</div>';  

  $('#content_prd').append(html);
}

//*****************************************************************************
//  BOTON (CERRAR FORMULARIO)
//*****************************************************************************
$("#btnclose_").click(function () {
    window.location.href = baseurl + "PedidoController/listapedido/";
});

//*****************************************************************************
//
//*****************************************************************************
function fn_open_modal_desc(fila_prd_actual) {
  
  if(document.forms["form1"].elements["caprd["+ fila_prd_actual +"]"].value > 0) {

    document.forms["form1"].elements["fila_prd_actual"].value = fila_prd_actual;
    $('#modalDescuento').modal('show'); // show bootstrap modal  

    $('#table_responsive_desc tbody').empty();

    //--------------------------------------------------------------------------
    //
    //--------------------------------------------------------------------------

    $('#table_responsive_desc tbody').empty();
    document.forms["form1"].elements["total_desc_prd_actual[" + fila_prd_actual + "]"].value = 0;  
    
    const elementos = document.getElementsByName('dia['+ fila_prd_actual +'][]');
    
    elementos.forEach((el, index) => {   
      txtdias = el.value;
      txtporc = document.forms["form1"].elements[el.id.replace("dia", "porc")].value;
      add_item_table_desc_prd(fila_prd_actual, index, txtdias, txtporc);
    });

    document.forms["form1"].elements["total_desc_prd_actual[" + fila_prd_actual + "]"].value = elementos.length;

  }  
}

//*****************************************************************************
// AGREGAR ITEM DINAMICOS TABLE
//*****************************************************************************
function add_item_table_desc_prd(fila_prd_actual, fila_desc_prd_actual, txtdias, txtporc)
{
  html = '<tr id="tr_' + fila_desc_prd_actual + '"> ';  
  html += '<td class="celda_dia"><p>' + txtdias + '</p></td>';
  html += '<td class="celda_porc"><p>' + txtporc + '</p></td>'; 
  html += '</tr>'; 
  $('#cont_table_body').append(html);
}
