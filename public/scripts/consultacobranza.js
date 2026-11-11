var current, current_step, next_step, steps;
var length_i_tab1 = $('#table_responsive_tab_1 tr').length;
var length_i_tab2 = $('#table_responsive_tab_2 tr').length;

//===============================================================================================================================================
//
//===============================================================================================================================================
$( document ).ready(function(){

  iniciarformulario();

  if ($.fn.DataTable.isDataTable('#table_responsive_tab_1')) {
    $('#table_responsive_tab_1').DataTable().destroy();
  }

  if ($.fn.DataTable.isDataTable('#table_responsive_tab_2')) {
    $('#table_responsive_tab_2').DataTable().destroy();
  }

  //======================================================================================================
  // DATATABLE  TAB 1
  //======================================================================================================
  var table_1 = $('#table_responsive_tab_1').DataTable( {

    language: {
      processing: "<i class='fa fa-spinner fa-5x fa-spin fa-fw' aria-hidden='true'></i>",
      search: "<i class='fa fa-search' aria-hidden='true'></i>",
      lengthMenu: "Mostrar _MENU_ registros", // <--- CAMBIADO A ESTE FORMATO DE STRING
      info: "Mostrando del _START_ al _END_ de _TOTAL_ facturas",
      infoEmpty: false,
      infoFiltered: "(filtrado de un total de _MAX_ elementos)",
      infoPostFix: "",
      loadingRecords: "<i class='fa fa-spinner fa-5x fa-spin fa-fw' aria-hidden='true'></i>",
      zeroRecords: "No hay coincidencias",
      emptyTable: " ",
      paginate: {
        first: "<i class='fa fa-fast-backward fa-lg' aria-hidden='true'></i>",
        previous: "<i class='fa fa-backward fa-lg' aria-hidden='true'></i>",
        next: "<i class='fa fa-forward fa-lg' aria-hidden='true'></i>",
        last: "<i class='fa fa-fast-forward fa-lg' aria-hidden='true'></i>"
      }
    },
    columnDefs:[
      { orderable: false, targets: [0] },{ orderable: false, targets: [2] }
    ],
    order:[
      [ 1, 'asc' ]
    ],
    stateSave: true
  });

  //table_1.buttons().container()
  //.appendTo( $('.col-sm-6:eq(0)', table_1.table().container() ) );

  //======================================================================================================
  // DATATABLE  TAB 2
  //======================================================================================================
  var table_2 = $('#table_responsive_tab_2').DataTable( {

    language: {
      processing: "<i class='fa fa-spinner fa-5x fa-spin fa-fw' aria-hidden='true'></i>",
      search: "<i class='fa fa-search' aria-hidden='true'></i>",
      lengthMenu: "Mostrar _MENU_ registros", // <--- CAMBIADO A ESTE FORMATO DE STRING
      info: "Mostrando del _START_ al _END_ de _TOTAL_ cobranzas",
      infoEmpty: false,
      infoFiltered: "(filtrado de un total de _MAX_ elementos)",
      infoPostFix: "",
      loadingRecords: "<i class='fa fa-spinner fa-5x fa-spin fa-fw' aria-hidden='true'></i>",
      zeroRecords: "No hay coincidencias",
      emptyTable: " ",
      paginate: {
        first: "<i class='fa fa-fast-backward fa-lg' aria-hidden='true'></i>",
        previous: "<i class='fa fa-backward fa-lg' aria-hidden='true'></i>",
        next: "<i class='fa fa-forward fa-lg' aria-hidden='true'></i>",
        last: "<i class='fa fa-fast-forward fa-lg' aria-hidden='true'></i>"
      }
    },
    columnDefs:[
      { orderable: false, targets: [0] },{ orderable: false, targets: [2] }
    ],
    order:[
      [ 1, 'asc' ]
    ],
    stateSave: true
  });

  //table_2.buttons().container()
  //.appendTo( $('.col-sm-6:eq(0)', table_2.table().container() ) );
  //======================================================================================================
});

//*****************************************************************************
//
//*****************************************************************************
function iniciarformulario() {

  document.forms["form1"].elements["fila_tot_fact"].value = "0";
  document.forms["form1"].elements["fila_tot_cobr"].value = "0";
  document.forms["form1"].elements["operacion"].value = "2";

  //======================================================================================================
  //  DATATABLE TAB 1
  //======================================================================================================
  $('#table_responsive_tab_1 tbody tr').slice(0).remove();

  //======================================================================================================
  //  DATATABLE TAB 2
  //======================================================================================================
  $('#table_responsive_tab_2 tbody tr').slice(0).remove();

  consultar_cobranza();
}


//*****************************************************************************
//
//*****************************************************************************
function consultar_cobranza() {
  var id_cobr_web = document.forms["form1"].elements["id_cobr_web"].value;

  $.ajax({
    type: "POST",
    url: baseurl + "CobranzaController/consultar_cobranza",
    data: {id_cobr_web : id_cobr_web},
    success: function (respuesta) {
      if (typeof respuesta === "string" && respuesta.includes("A PHP Error was encountered")) {
          alert(respuesta);
      }
      else {
        var res = (typeof respuesta === "string") ? JSON.parse(respuesta) : respuesta;
        console.log(res);

        if (res.resultado == "1") {

          $('#form1')[0].reset();
          document.forms["form1"].elements["operacion"].value = "2";

          document.forms["form1"].elements["idvendedor"].value = res.Model_consultar_cobranza[0]["id_vendedor"];
          document.forms["form1"].elements["nbvendedor"].value = res.Model_consultar_cobranza[0]["nb_vendedor"];
          document.forms["form1"].elements["fecha"].value = res.Model_consultar_cobranza[0]["fe_emision"];
          document.forms["form1"].elements["txtobs"].value = res.Model_consultar_cobranza[0]["tx_observacion"];
          document.forms["form1"].elements["cmbempresa"].value = res.Model_consultar_cobranza[0]["co_empresa"];
          document.forms["form1"].elements["cmbcliente"].value = res.Model_consultar_cobranza[0]["nb_organizacion"];

          const titulo = document.querySelector('.card-header');
          titulo.textContent = titulo.textContent + " (" + res.Model_consultar_cobranza[0]["ctv_de_estado_documento"] + ")";

          for(i = 0; i < res.Model_consultar_cobranza_fact.length; i++)
          {
            var txtfactura   = res.Model_consultar_cobranza_fact[i]["nu_factura"];
            var txtmontofact = res.Model_consultar_cobranza_fact[i]["saldo_factura"];

            add_item_fact(i, txtfactura, txtmontofact);
          }

          for(j = 0; j < res.Model_consultar_cobranza_pago.length; j++)
          {
            var txtfecha      = res.Model_consultar_cobranza_pago[j]["fecha"];
            var cmbbanco      = res.Model_consultar_cobranza_pago[j]["co_banco"];
            var txtreferencia = res.Model_consultar_cobranza_pago[j]["referencia"];
            var cmbmoneda     = res.Model_consultar_cobranza_pago[j]["co_moneda"];
            var txtcobro      = res.Model_consultar_cobranza_pago[j]["monto"];
            var txttasa       = res.Model_consultar_cobranza_pago[j]["tasa"];
            var txttotal      = res.Model_consultar_cobranza_pago[j]["total"];

            add_item_cobr(j, txtfecha, cmbbanco, txtreferencia, cmbmoneda, txtcobro, txttasa, txttotal.replace(',', '.'));
          }

          for(i = 0; i < res.Model_consultar_cobranza_comprobante.length; i++)
          {
            var tx_archivo   = res.Model_consultar_cobranza_comprobante[i]["tx_archivo"];

            add_item_comprobante(i, tx_archivo);
          }

          document.forms["form1"].elements["txtdesc_esp_porc"].value     = parseFloat(res.Model_consultar_cobranza[0]["porc_desc_especial"].replace(',', '.'));
          document.forms["form1"].elements["txtdesc_flet_nc"].value      = parseFloat(res.Model_consultar_cobranza[0]["mont_desc_flete"].replace(',', '.'));
          document.forms["form1"].elements["txtdesc_divisa_porc"].value  = parseFloat(res.Model_consultar_cobranza[0]["porc_desc_pago_divisa"].replace(',', '.'));

          document.forms["form1"].elements["txttot_fact"].value          = parseFloat(res.Model_consultar_cobranza[0]["total_facturado"].replace(',', '.'));
          document.forms["form1"].elements["txtdesc_esp_mont"].value     = parseFloat(res.Model_consultar_cobranza[0]["mont_desc_especial"].replace(',', '.'));
          document.forms["form1"].elements["txtdesc_flet_nc_mont"].value = parseFloat(res.Model_consultar_cobranza[0]["mont_desc_flete"].replace(',', '.'));
          document.forms["form1"].elements["txtdesc_divisa_mont"].value  = parseFloat(res.Model_consultar_cobranza[0]["mont_desc_pago_divisa"].replace(',', '.'));

          document.forms["form1"].elements["txtcobrado"].value           = parseFloat(res.Model_consultar_cobranza[0]["mont_cobrado"].replace(',', '.'));
          document.forms["form1"].elements["txtsubtotal"].value          = parseFloat(res.Model_consultar_cobranza[0]["mont_subtotal"].replace(',', '.'));
          document.forms["form1"].elements["txttotal"].value             = parseFloat(res.Model_consultar_cobranza[0]["mont_total"].replace(',', '.'));
          document.forms["form1"].elements["txtpendiente"].value         = parseFloat(res.Model_consultar_cobranza[0]["mont_pendiente"].replace(',', '.'));

          document.forms["form1"].elements["txtdesc_pronto_pago_porc"].value = parseFloat(res.Model_consultar_cobranza[0]["porc_desc_pronto_pago"].replace(',', '.'));
          document.forms["form1"].elements["txtdesc_pronto_pago_mont"].value = parseFloat(res.Model_consultar_cobranza[0]["mont_desc_pronto_pago"].replace(',', '.'));

        }
        else if (res.resultado == "0") {
          alert("No retornaron datos esperados");
          window.location.href = baseurl + "CobranzaController/listacobranza/";
        }
        else if (res.resultado == "ERROR") {
          alert(res.msn);
          window.location.href = baseurl + "CobranzaController/listacobranza/";
        }
        else {
          alert("No retornaron datos esperados");
          window.location.href = baseurl + "CobranzaController/listacobranza/";
        }
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
function add_item_fact(fila_i, txtfactura, txtmontofact) {
  html = '<tr id="tr_fa_' + fila_i + '"> ';

  html += '<td class="text-left celda_fac"><p>' + txtfactura.toUpperCase() + '</p>';
  html += '<input type="hidden" name="_txtfactura[]" value="'+ txtfactura.toUpperCase() +'" />';
  html += '</td>';

  html += '<td class="text-left celda_mon"><p>' + parseFloat(txtmontofact.replace(',', '.')).toLocaleString('en-US', { maximumFractionDigits: 2 }) + '</p>';
  html += '<input type="hidden" name="_txtmontofact[]" value="'+ txtmontofact +'" />';
  html += '</td>';

  html += '<td class="text-center celda_boton">';
  html += '</td>';
  html += '</tr>';

  $('#cont_table_body_1').append(html);
}

//========================================================================================================
// AGREGAR ITEM DINAMICOS DATATABLE TAB 2
//========================================================================================================
function add_item_cobr(fila_i, txtfecha, cmbbanco, txtreferencia, cmbmoneda, txtcobro, txttasa, txttotal) {
  html =  '<tr id="tr_cr_' + fila_i + '"> ';

  html += '<td class="text-left celda_fec"><p>' + txtfecha + '</p>';
  html += '<input type="hidden" name="_txtfecha[]" value="'+ txtfecha +'" />';
  html += '</td>';

  html += '<td class="text-left celda_ban"><p>' + cmbbanco + '</p>';
  html += '<input type="hidden" name="_cmbbanco[]" value="'+ cmbbanco +'" />';
  html += '</td>';

  html += '<td class="text-left celda_ref"><p>' + txtreferencia.toUpperCase() + '</p>';
  html += '<input type="hidden" name="_txtreferencia[]" value="'+ txtreferencia.toUpperCase() +'" />';
  html += '</td>';

  html += '<td class="text-left celda_moned"><p>' + cmbmoneda + '</p>';
  html += '<input type="hidden" name="_cmbmoneda[]" value="'+ cmbmoneda +'" />';
  html += '</td>';

  html += '<td class="text-left celda_cob"><p>' + parseFloat(txtcobro.replace(',', '.')).toLocaleString('en-US', { maximumFractionDigits: 2 }) + '</p>';
  html += '<input type="hidden" name="_txtcobro[]" value="'+ txtcobro +'" />';
  html += '</td>';

  html += '<td class="text-left celda_tas"><p>' + txttasa.replace(',', '.') + '</p>';
  html += '<input type="hidden" name="_txttasa[]" value="'+ txttasa +'" />';
  html += '</td>';

  html += '<td class="text-left celda_tot"><p>' + parseFloat(txttotal).toLocaleString('en-US', { maximumFractionDigits: 2 }) + '</p>';
  html += '<input type="hidden" name="_txttotal[]" value="'+ parseFloat(txttotal).toFixed(2) +'" />';
  html += '</td>';

  html += '<td class="text-center celda_boton">';
  html += '</td>';
  html += '</tr>';

  $('#cont_table_body_2').append(html);
}

//========================================================================================================
// AGREGAR ITEM DINAMICOS DATATABLE TAB 3
//========================================================================================================
function add_item_comprobante(fila_i, tx_archivo) {
  html = '<div class="col-md-2">';
  html += '<div class="card mb-6 border border-2 border-primary">';
  html += '<div class="card-body">';
  html += '<div class="d-flex align-items-center flex-column">';
  html += '<div class="user-info text-center">';
  html += '<h5>' + tx_archivo.toUpperCase() + '</h5>';
  html += '</div>';
  html += '</div>';
  html += '<div class="d-grid w-100 mt-6">';
  html += '<a href="' + linksitioweb + './images/comprobantes/' + tx_archivo + '" target="_blank" class="btn btn-primary waves-effect waves-light">Descargar</a>';
  html += '</div>';
  html += '</div>';
  html += '</div>';
  html += '</div>';

  $('#cont_table_body_3').append(html);
}

//*****************************************************************************
//  BOTON (CERRAR FORMULARIO)
//*****************************************************************************
$("#btnclose_").click(function () {
    window.location.href = baseurl + "CobranzaController/listacobranza/";
});