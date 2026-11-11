var current, current_step, next_step, steps;
var length_i_tab1 = $('#table_responsive_tab_1 tr').length;
var length_i_tab2 = $('#table_responsive_tab_2 tr').length;

//======================================================================================================
// DROPZONE
//======================================================================================================
Dropzone.autoDiscover = false;

var myDropzone = new Dropzone("#miDropzoneform", {
    url: "#",
    autoProcessQueue: false,
    uploadMultiple: true,
    maxFiles: 10,
    maxFilesize: 2, // Tamaño máximo en MB
    acceptedFiles: ".jpeg,.jpg,.png,.pdf", // Formatos permitidos
    addRemoveLinks: true,
    dictDefaultMessage: "Arrastra tus archivos aquí para subirlos",
    init: function() {
        this.on("success", function(file, response) {
            console.log("Archivo subido exitosamente");
        });
        this.on("removedfile", function(file) {
            console.log("Archivo eliminado");
        });
    }
});

//===============================================================================================================================================
// DOCUMENT READY
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
  // DATATABLE TAB 1
  //======================================================================================================
  var table_1 = $('#table_responsive_tab_1').DataTable( {
    language: {
      processing: "<i class='fa fa-spinner fa-5x fa-spin fa-fw' aria-hidden='true'></i>",
      search: "<i class='fa fa-search' aria-hidden='true'></i>",
      lengthMenu: false,
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

  table_1.buttons().container().appendTo( $('.col-sm-6:eq(0)', table_1.table().container() ) );

  //======================================================================================================
  // DATATABLE TAB 2
  //======================================================================================================
  var table_2 = $('#table_responsive_tab_2').DataTable( {
    language: {
      processing: "<i class='fa fa-spinner fa-5x fa-spin fa-fw' aria-hidden='true'></i>",
      search: "<i class='fa fa-search' aria-hidden='true'></i>",
      lengthMenu: false,
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
      { orderable: false, targets: [0] },{ orderable: false, targets: [7] }
    ],
    order:[
      [ 1, 'asc' ]
    ],
    stateSave: true
  });

  table_2.buttons().container().appendTo( $('.col-sm-6:eq(0)', table_2.table().container() ) );
});

//========================================================================================================
// INICIAR FORMULARIO
//========================================================================================================
function iniciarformulario() {
  $('#cmbcliente').empty();
  $('#cmbcliente').append(new Option('', '', true, true));
  llenarcombocliente();

  $('#cmbbanco').empty();
  $('#cmbbanco').append(new Option('', '', true, true));
  llenarcombobanco();

  document.forms["form1"].elements["fila_tot_fact"].value = "0";
  document.forms["form1"].elements["fila_tot_cobr"].value = "0";
  document.forms["form1"].elements["operacion"].value = "3";

  $('#table_responsive_tab_1 tbody tr').slice(0).remove();
  $('#table_responsive_tab_2 tbody tr').slice(0).remove();

  consultar_cobranza();
}

//*****************************************************************************
// CONSULTAR COBRANZA
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
      } else {
        var respuesta = (typeof respuesta === "string") ? JSON.parse(respuesta) : respuesta;

        if (respuesta.resultado == "1") {
          $('#form1')[0].reset();
          document.forms["form1"].elements["operacion"].value = "3";

          document.forms["form1"].elements["idvendedor"].value = respuesta.Model_consultar_cobranza[0]["id_vendedor"];
          document.forms["form1"].elements["nbvendedor"].value = respuesta.Model_consultar_cobranza[0]["nb_vendedor"];
          document.forms["form1"].elements["fecha"].value = respuesta.Model_consultar_cobranza[0]["fe_emision"];
          document.forms["form1"].elements["txtobs"].value = respuesta.Model_consultar_cobranza[0]["tx_observacion"];

          $('#cmbempresa').val(respuesta.Model_consultar_cobranza[0]["co_empresa"]).trigger('change');
          setTimeout(function(){
              $('#cmbcliente').val(respuesta.Model_consultar_cobranza[0]["co_organizacion"]).trigger('change');
          }, 500);

          document.forms["form1"].elements["txtobs"].value = respuesta.Model_consultar_cobranza[0]["tx_observacion"];

          const titulo = document.querySelector('.card-header');
          titulo.textContent = titulo.textContent + " (" + respuesta.Model_consultar_cobranza[0]["ctv_de_estado_documento"] + ")";

          for(let i = 0; i < respuesta.Model_consultar_cobranza_fact.length; i++) {
            var txtfactura   = respuesta.Model_consultar_cobranza_fact[i]["nu_factura"];
            var txtmontofact = respuesta.Model_consultar_cobranza_fact[i]["saldo_factura"];
            var txtfec_fact  = respuesta.Model_consultar_cobranza_fact[i]["fe_emision_fact"];
            
            let partes_3 = txtfec_fact.split('/');
            txtfec_fact = partes_3[2]+'-'+partes_3[1]+'-'+partes_3[0];

            add_item_fact(i, txtfactura, txtmontofact, 'N', txtfec_fact);
          }

          document.forms["form1"].elements["fila_tot_fact"].value = respuesta.Model_consultar_cobranza_fact.length;

          for(let j = 0; j < respuesta.Model_consultar_cobranza_pago.length; j++) {
            var txtfecha      = respuesta.Model_consultar_cobranza_pago[j]["fecha"];
            let partes = txtfecha.split('/');
            txtfecha = partes[2]+'-'+partes[1]+'-'+partes[0];

            var cmbbanco      = respuesta.Model_consultar_cobranza_pago[j]["co_banco"];
            var txtreferencia = respuesta.Model_consultar_cobranza_pago[j]["referencia"];
            var cmbmoneda     = respuesta.Model_consultar_cobranza_pago[j]["co_moneda"];
            var txtcobro      = respuesta.Model_consultar_cobranza_pago[j]["monto"];
            var txttasa       = respuesta.Model_consultar_cobranza_pago[j]["tasa"];
            var txttotal      = respuesta.Model_consultar_cobranza_pago[j]["total"];
            var txtfec_cob    = respuesta.Model_consultar_cobranza_pago[j]["fe_emision_cob"];
            
            let partes_2 = txtfec_cob.split('/');
            txtfec_cob = partes_2[2]+'-'+partes_2[1]+'-'+partes_2[0];

            add_item_cobr(j, txtfecha, cmbbanco, txtreferencia, cmbmoneda, txtcobro, txttasa, txttotal.replace(',', '.'), 'N', txtfec_cob);
          }

          for(let i = 0; i < respuesta.Model_consultar_cobranza_comprobante.length; i++) {
            var tx_archivo = respuesta.Model_consultar_cobranza_comprobante[i]["tx_archivo"];
            add_item_comprobante(i, tx_archivo);
          }

          document.forms["form1"].elements["fila_tot_cobr"].value = respuesta.Model_consultar_cobranza_pago.length;

          document.forms["form1"].elements["txtdesc_esp_porc"].value     = parseFloat(respuesta.Model_consultar_cobranza[0]["porc_desc_especial"].replace(',', '.'));
          document.forms["form1"].elements["txtdesc_flet_nc"].value      = parseFloat(respuesta.Model_consultar_cobranza[0]["mont_desc_flete"].replace(',', '.'));
          document.forms["form1"].elements["txtdesc_divisa_porc"].value  = parseFloat(respuesta.Model_consultar_cobranza[0]["porc_desc_pago_divisa"].replace(',', '.'));

          document.forms["form1"].elements["txttot_fact"].value          = parseFloat(respuesta.Model_consultar_cobranza[0]["total_facturado"].replace(',', '.'));
          document.forms["form1"].elements["txtdesc_esp_mont"].value     = parseFloat(respuesta.Model_consultar_cobranza[0]["mont_desc_especial"].replace(',', '.'));
          document.forms["form1"].elements["txtdesc_flet_nc_mont"].value = parseFloat(respuesta.Model_consultar_cobranza[0]["mont_desc_flete"].replace(',', '.'));
          document.forms["form1"].elements["txtdesc_divisa_mont"].value  = parseFloat(respuesta.Model_consultar_cobranza[0]["mont_desc_pago_divisa"].replace(',', '.'));

          document.forms["form1"].elements["txtcobrado"].value           = parseFloat(respuesta.Model_consultar_cobranza[0]["mont_cobrado"].replace(',', '.'));
          document.forms["form1"].elements["txtsubtotal"].value          = parseFloat(respuesta.Model_consultar_cobranza[0]["mont_subtotal"].replace(',', '.'));
          document.forms["form1"].elements["txttotal"].value             = parseFloat(respuesta.Model_consultar_cobranza[0]["mont_total"].replace(',', '.'));
          document.forms["form1"].elements["txtpendiente"].value         = parseFloat(respuesta.Model_consultar_cobranza[0]["mont_pendiente"].replace(',', '.'));

          document.forms["form1"].elements["txtdesc_pronto_pago_porc"].value = parseFloat(respuesta.Model_consultar_cobranza[0]["porc_desc_pronto_pago"].replace(',', '.'));
          document.forms["form1"].elements["txtdesc_pronto_pago_mont"].value = parseFloat(respuesta.Model_consultar_cobranza[0]["mont_desc_pronto_pago"].replace(',', '.'));

        }
        else if (respuesta.resultado == "0") {
          alert("No retornaron datos esperados");
          window.location.href = baseurl + "CobranzaController/listacobranza/";
        }
        else if (respuesta.resultado == "ERROR") {
          alert(respuesta.msn);
          window.location.href = baseurl + "CobranzaController/listacobranza/";
        }
        else {
          alert("No retornaron datos esperados");
          window.location.href = baseurl + "CobranzaController/listacobranza/";
        }
      }
    },
    error: function(xhr, status, error) {
      alert("Error crítico de comunicación con el servidor:\n" + error);
    }
  });
}

//*****************************************************************************
// LLENAR COMBO CLIENTE
//*****************************************************************************
function llenarcombocliente() {
  $.ajax({
    type: "POST",
    url: baseurl + "ClienteController/consultar_cliente_zona_usuario",
    data: {},
    success: function( respuesta ){
      if (typeof respuesta === "string" && respuesta.includes("A PHP Error was encountered")) {
        alert(respuesta);
      } else {
        var respuesta = (typeof respuesta === "string") ? JSON.parse(respuesta) : respuesta;

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
    error: function(xhr, status, error) {
      alert("Error crítico de comunicación con el servidor:\n" + error);
    }
  });
}

//*****************************************************************************
// LLENAR COMBO BANCO
//*****************************************************************************
function llenarcombobanco() {
  $.ajax({
    type: "POST",
    url: baseurl + "BancoController/consultar_banco",
    data: { txtcodigo : "%", txtnombre : "%" },
    success: function( respuesta ){
      if (typeof respuesta === "string" && respuesta.includes("A PHP Error was encountered")) {
        alert(respuesta);
      } else {
        var respuesta = (typeof respuesta === "string") ? JSON.parse(respuesta) : respuesta;

        if (respuesta.resultado == "1") {
          $.each(respuesta.arreglo, function (i, item) {
            $('#cmbbanco').append(new Option(item.nb_banco, item.co_banco));
          });
        }
        else if (respuesta.resultado == "ERROR") {
          alert(respuesta.msn);
        }
      }
    },
    error: function(xhr, status, error) {
      alert("Error crítico de comunicación con el servidor:\n" + error);
    }
  });
}

//*****************************************************************************
// MODAL 1
//*****************************************************************************
$("#btnaddtab_1").click(function () {
  document.forms["form1"].elements["txtfactura"].value = "";
  document.forms["form1"].elements["txtmontofact"].value = "";

  $('#modal_form_1').modal('show');

  setTimeout(function(){
      $('#txtfactura').focus();
  }, 500);
});

//*****************************************************************************
// MODAL 2
//*****************************************************************************
$("#btnaddtab_2").click(function () {
  document.forms["form1"].elements["txtfecha"].value = new Date().toISOString().split('T')[0];
  document.forms["form1"].elements["txtcobro"].value = "";
  document.forms["form1"].elements["txttasa"].value = "";
  document.forms["form1"].elements["txtreferencia"].value = "";

  $('#cmbbanco').val(null).trigger('change');
  $('#cmbmoneda').val(null).trigger('change');

  $('#modal_form_2').modal('show');

  setTimeout(function(){
      $('#cmbbanco').focus();
  }, 500);
});

//*****************************************************************************
// BOTON AGREGAR FACTURA
//*****************************************************************************
$("#btnadd_fact").click(function () {
  var validar = false;
  var txtfactura = document.forms["form1"].elements["txtfactura"].value;
  var txtmontofact = document.forms["form1"].elements["txtmontofact"].value;
  var fila_tot_fact = document.forms["form1"].elements["fila_tot_fact"].value;

  if(document.forms["form1"].elements["fila_tot_fact"].value.length < 1) {
    validar = false;
    alert('No se pudo obtener el número de fila de la factura');
    document.forms["form1"].elements["txtfactura"].focus();
  }
  else if((txtfactura.length < 1) || (txtfactura < 1)) {
    validar = false;
    alert('Indique el número de factura');
    document.forms["form1"].elements["txtfactura"].focus();
  }
  else if((txtmontofact.length < 1) || (txtmontofact < 1)) {
    validar = false;
    alert('Indique el monto de la factura');
    document.forms["form1"].elements["txtmontofact"].focus();
  }
  else {
    validar = true;
  }

  if(validar == true) {
      fila_tot_fact = parseInt(fila_tot_fact);
      let fe_emision_fac = new Date().toISOString().split('T')[0];
      add_item_fact(fila_tot_fact, txtfactura, txtmontofact, 'S', fe_emision_fac);

      fila_tot_fact = fila_tot_fact + 1;
      document.forms["form1"].elements["fila_tot_fact"].value = fila_tot_fact;

      calcular_totales();

      document.forms["form1"].elements["txtfactura"].value = "";
      document.forms["form1"].elements["txtmontofact"].value = "";
      $('#modal_form_1').modal('hide');

      setTimeout(function(){
          $('#btnaddtab_1').focus();
      }, 500);
  }
});

//========================================================================================================
// AGREGAR ITEM FACTURA
//========================================================================================================
function add_item_fact(fila_i, txtfactura, txtmontofact, dato_nuevo, fe_emision_fac) {
  let html = '<tr id="tr_fa_' + fila_i + '"> ';

  html += '<td class="text-left celda_fac"><p>' + txtfactura.toUpperCase() + '</p>';
  html += '<input type="hidden" name="_txtfactura[]" value="'+ txtfactura.toUpperCase() +'" />';
  html += '</td>';

  html += '<td class="text-left celda_mon"><p>' + parseFloat(txtmontofact.toString().replace(',', '.')).toLocaleString('en-US', { maximumFractionDigits: 2 }) + '</p>';
  html += '<input type="hidden" name="_txtmontofact[]" value="'+ txtmontofact +'" />';
  html += '</td>';

  html += '<td class="text-center celda_boton">';
  if(dato_nuevo == "S") {
    html += '<button type="button" class="btnaccion btn btn-danger btn-xs" title="Eliminar" onclick="fn_remove_fact(' + "'" + 'tr_fa_' + fila_i + "'" + ')">';
    html += '<span class="icon-base ri ri-delete-bin-2-fill icon-22px"></span>';
    html += '</button>';
  }
  html += '</td>';

  html += '<td class="text-left celda_fac_oculta"><p>' + fe_emision_fac + '</p>';
  html += '<input type="hidden" name="_fe_emision_fac[]" value="' + fe_emision_fac + '" />';
  html += '<input type="hidden" name="_factura_nuevo[]" value="' + dato_nuevo + '" />';
  html += '</td>';
  html += '</tr>';

  $('#cont_table_body_1').append(html);
}

//*****************************************************************************
// REMOVER FACTURA
//*****************************************************************************
function fn_remove_fact(fila_i) {
  const lista_txtfac = [];
  const lista_txtmon = [];
  const lista_txtbot = [];
  const lista_txtfec_fac = [];

  var fila_tot_fact = document.forms["form1"].elements["fila_tot_fact"].value;

  let cont_fac = 0, cont_mon = 0, cont_bot = 0, cont_fec_fac = 0;

  const input_hidden_tr = document.getElementById(fila_i);
  if (input_hidden_tr) {
    input_hidden_tr.remove();
  }

  const filas = document.querySelectorAll('#table_responsive_tab_1 tbody tr');

  filas.forEach((fila, index) => {
    const celdas = fila.cells;
    for (let i = 0; i < celdas.length; i++) {
      if(celdas[i].className == "text-left celda_fac") {
        lista_txtfac[cont_fac] = celdas[i].innerText;
        cont_fac++;
      }
      if(celdas[i].className == "text-left celda_mon") {
        lista_txtmon[cont_mon] = celdas[i].innerText.replace(/,/g, "");
        cont_mon++;
      }
      if(celdas[i].className == "text-center celda_boton") {
        lista_txtbot[cont_bot] = celdas[i].querySelector('button') ? "S" : "N";
        cont_bot++;
      }
      if(celdas[i].className == "text-left celda_fac_oculta") {
        lista_txtfec_fac[cont_fec_fac] = celdas[i].innerText;
        cont_fec_fac++;
      }
    }
  });

  $('#table_responsive_tab_1 tbody').empty();

  for (let i = 0; i < cont_fac; i++) {
    if(lista_txtfac[i] != "" || lista_txtmon[i] != "") {
      add_item_fact(i, lista_txtfac[i], lista_txtmon[i], lista_txtbot[i], lista_txtfec_fac[i]);
    }
  }

  fila_tot_fact = parseInt(fila_tot_fact) - 1;
  document.forms["form1"].elements["fila_tot_fact"].value = fila_tot_fact;

  calcular_totales();
}

//*****************************************************************************
// BOTON AGREGAR PAGO
//*****************************************************************************
$("#btnadd_cobr").click(function () {
  var validar = false;
  var txtfecha = document.forms["form1"].elements["txtfecha"].value;
  var cmbbanco = document.forms["form1"].elements["cmbbanco"].value;
  var txtreferencia = document.forms["form1"].elements["txtreferencia"].value;
  var cmbmoneda = document.forms["form1"].elements["cmbmoneda"].value;
  var txtcobro = document.forms["form1"].elements["txtcobro"].value;
  var txttasa = document.forms["form1"].elements["txttasa"].value;
  var fila_tot_cobr = document.forms["form1"].elements["fila_tot_cobr"].value;
  var fila_tot_fact = document.forms["form1"].elements["fila_tot_fact"].value;

  if(document.forms["form1"].elements["fila_tot_cobr"].value.length < 1) {
    validar = false;
    alert('No se pudo obtener el número de fila de la cobranza');
    document.forms["form1"].elements["cmbbanco"].focus();
  }
  else if(fila_tot_fact == "0") {
    validar = false;
    alert('Indique una factura');
    $('#modal_form_2').modal('hide');
    setTimeout(function(){
        $('#btnaddtab_1').focus();
    }, 500);
  }
  else if((txtfecha.length < 1) || (txtfecha < 1)) {
    validar = false;
    alert('Indique la fecha');
    document.forms["form1"].elements["txtfecha"].focus();
  }
  else if(cmbbanco == "") {
    validar = false;
    alert('Indique el banco');
    document.forms["form1"].elements["cmbbanco"].focus();
  }
  else if(txtreferencia.length < 1) {
    validar = false;
    alert('Indique el número de referencia');
    document.forms["form1"].elements["txtreferencia"].focus();
  }
  else if(cmbmoneda == "") {
    validar = false;
    alert('Indique la moneda');
    document.forms["form1"].elements["cmbmoneda"].focus();
  }
  else if((txtcobro.length < 1) || (txtcobro < 1)) {
    validar = false;
    alert('Indique el monto');
    document.forms["form1"].elements["txtcobro"].focus();
  }
  else if( ((txttasa.length < 1) || (txttasa < 1) || (txttasa == 0) ) && (cmbmoneda == "BS") ) {
    validar = false;
    alert('Indique la tasa');
    document.forms["form1"].elements["txttasa"].focus();
  }
  else {
    validar = true;
  }

  if(validar == true) {
      let txttotal = 0.00;
      if(cmbmoneda == "$") {
        txttotal = parseFloat(txtcobro);
      }
      else {
        txttotal = parseFloat(txtcobro) / parseFloat(txttasa);
      }

      fila_tot_cobr = parseInt(fila_tot_cobr);
      let fe_emision_cob = new Date().toISOString().split('T')[0];
      add_item_cobr(fila_tot_cobr, txtfecha, cmbbanco, txtreferencia, cmbmoneda, txtcobro, txttasa, txttotal, 'S', fe_emision_cob);

      fila_tot_cobr = fila_tot_cobr + 1;
      document.forms["form1"].elements["fila_tot_cobr"].value = fila_tot_cobr;

      calcular_totales();

      document.forms["form1"].elements["txtfecha"].value = new Date().toISOString().split('T')[0];
      document.forms["form1"].elements["txtcobro"].value = "";
      document.forms["form1"].elements["txttasa"].value = "";
      document.forms["form1"].elements["txtreferencia"].value = "";

      $('#cmbbanco').val(null).trigger('change');
      $('#cmbmoneda').val(null).trigger('change');

      $('#modal_form_2').modal('hide');

      setTimeout(function(){
          $('#btnaddtab_2').focus();
      }, 500);
  }
});

//========================================================================================================
// AGREGAR ITEM PAGO
//========================================================================================================
function add_item_cobr(fila_i, txtfecha, cmbbanco, txtreferencia, cmbmoneda, txtcobro, txttasa, txttotal, dato_nuevo, fe_emision_cob) {
  let html =  '<tr id="tr_cr_' + fila_i + '"> ';

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

  html += '<td class="text-left celda_cob"><p>' + parseFloat(txtcobro.toString().replace(',', '.')).toLocaleString('en-US', { maximumFractionDigits: 2 }) + '</p>';
  html += '<input type="hidden" name="_txtcobro[]" value="'+ txtcobro +'" />';
  html += '</td>';

  html += '<td class="text-left celda_tas"><p>' + txttasa.toString().replace(',', '.') + '</p>';
  html += '<input type="hidden" name="_txttasa[]" value="'+ txttasa +'" />';
  html += '</td>';

  html += '<td class="text-left celda_tot"><p>' + parseFloat(txttotal).toLocaleString('en-US', { maximumFractionDigits: 2 }) + '</p>';
  html += '<input type="hidden" name="_txttotal[]" value="'+ parseFloat(txttotal).toFixed(2) +'" />';
  html += '</td>';

  html += '<td class="text-center celda_boton">';
  if(dato_nuevo == "S") {
    html += '<button type="button" class="btnaccion btn btn-danger btn-xs" title="Eliminar" onclick="fn_remove_cob(' + "'" + 'tr_cr_' + fila_i + "'" + ')">';
    html += '<span class="icon-base ri ri-delete-bin-2-fill icon-22px"></span>';
    html += '</button>';
  }
  html += '</td>';

  html += '<td class="text-left celda_cob_oculta"><p>' + fe_emision_cob + '</p>';
  html += '<input type="hidden" name="_fe_emision_cob[]" value="' + fe_emision_cob + '" />';
  html += '<input type="hidden" name="_pago_nuevo[]" value="' + dato_nuevo + '" />';
  html += '</td>';

  html += '</tr>';

  $('#cont_table_body_2').append(html);
}

//========================================================================================================
// AGREGAR ITEM COMPROBANTE
//========================================================================================================
function add_item_comprobante(fila_i, tx_archivo) {
  let html = '<div class="col-md-2">';
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
// REMOVER PAGO
//*****************************************************************************
function fn_remove_cob(fila_i) {
  const lista_txtfec = [], lista_txtban = [], lista_txtref = [], lista_txtmoned = [];
  const lista_txtcob = [], lista_txttas = [], lista_txttot = [], lista_txtbot = [], lista_txtfec_cob = [];

  var fila_tot_cobr = document.forms["form1"].elements["fila_tot_cobr"].value;

  let cont_fec = 0, cont_ban = 0, cont_ref = 0, cont_moned = 0, cont_cob = 0, cont_tas = 0, cont_tot = 0, cont_bot = 0, cont_fec_cob = 0;

  const input_hidden_tr = document.getElementById(fila_i);
  if (input_hidden_tr) {
    input_hidden_tr.remove();
  }

  const filas = document.querySelectorAll('#table_responsive_tab_2 tbody tr');

  filas.forEach((fila, index) => {
    const celdas = fila.cells;
    for (let i = 0; i < celdas.length; i++) {
      if(celdas[i].className == "text-left celda_fec") { lista_txtfec[cont_fec] = celdas[i].innerText; cont_fec++; }
      if(celdas[i].className == "text-left celda_ban") { lista_txtban[cont_ban] = celdas[i].innerText; cont_ban++; }
      if(celdas[i].className == "text-left celda_ref") { lista_txtref[cont_ref] = celdas[i].innerText; cont_ref++; }
      if(celdas[i].className == "text-left celda_moned") { lista_txtmoned[cont_moned] = celdas[i].innerText; cont_moned++; }
      if(celdas[i].className == "text-left celda_cob") { lista_txtcob[cont_cob] = celdas[i].innerText.replace(/,/g, ""); cont_cob++; }
      if(celdas[i].className == "text-left celda_tas") { lista_txttas[cont_tas] = celdas[i].innerText.replace(/,/g, ""); cont_tas++; }
      if(celdas[i].className == "text-left celda_tot") { lista_txttot[cont_tot] = celdas[i].innerText.replace(/,/g, ""); cont_tot++; }
      if(celdas[i].className == "text-center celda_boton") {
        lista_txtbot[cont_bot] = celdas[i].querySelector('button') ? "S" : "N";
        cont_bot++;
      }
      if(celdas[i].className == "text-left celda_cob_oculta") { lista_txtfec_cob[cont_fec_cob] = celdas[i].innerText; cont_fec_cob++; }
    }
  });

  $('#table_responsive_tab_2 tbody').empty();

  for (let i = 0; i < cont_ban; i++) {
    if(lista_txtban[i] != "" || lista_txtref[i] != "" || lista_txtcob[i] != "") {
      add_item_cobr(i, lista_txtfec[i], lista_txtban[i], lista_txtref[i], lista_txtmoned[i], lista_txtcob[i], lista_txttas[i], lista_txttot[i], lista_txtbot[i], lista_txtfec_cob[i]);
    }
  }

  fila_tot_cobr = parseInt(fila_tot_cobr) - 1;
  document.forms["form1"].elements["fila_tot_cobr"].value = fila_tot_cobr;

  calcular_totales();
}

//*****************************************************************************
// CALCULAR TOTALES
//*****************************************************************************
function calcular_totales() {
  var tot_fact = 0, tot_cobrado = 0, tot_cobrado_divisa = 0;
  var desc_esp_mont = 0, desc_divisa_mont = 0, desc_pronto_pago_mont = 0;
  var subtotal = 0, total = 0, pendiente = 0;

  var filas = document.querySelectorAll('#table_responsive_tab_1 tbody tr');
  filas.forEach((fila, index) => {
    var celdas = fila.cells;
    for (let i = 0; i < celdas.length; i++) {
      if(celdas[i].className == "text-left celda_mon") {
        tot_fact = parseFloat(tot_fact) + parseFloat(celdas[i].innerText.replace(/,/g, ""));
      }
    }
  });

  document.forms["form1"].elements["txttot_fact"].value = tot_fact.toFixed(2);

  let desc_esp_porc = document.forms["form1"].elements["txtdesc_esp_porc"].value;
  if( (desc_esp_porc > 0) && (desc_esp_porc <= 100) ) {
    desc_esp_mont = tot_fact * (parseFloat(desc_esp_porc) / 100);
    document.forms["form1"].elements["txtdesc_esp_mont"].value = desc_esp_mont.toFixed(2);
  } else {
    document.forms["form1"].elements["txtdesc_esp_mont"].value = 0;
  }

  let desc_flet_nc = document.forms["form1"].elements["txtdesc_flet_nc"].value;
  if(desc_flet_nc > 0) {
    desc_flet_nc = parseFloat(desc_flet_nc);
    document.forms["form1"].elements["txtdesc_flet_nc_mont"].value = desc_flet_nc.toFixed(2);
  } else {
    document.forms["form1"].elements["txtdesc_flet_nc_mont"].value = 0;
  }

  var filas2 = document.querySelectorAll('#table_responsive_tab_2 tbody tr');
  filas2.forEach((fila, index) => {
    var celdas = fila.cells;
    for (let i = 0; i < celdas.length; i++) {
      if(celdas[i].className == "text-left celda_tot") {
        tot_cobrado = parseFloat(tot_cobrado) + parseFloat(celdas[i].innerText.replace(/,/g, ""));
      }
    }
  });

  document.forms["form1"].elements["txtcobrado"].value = tot_cobrado.toFixed(2);

  subtotal = (tot_fact - desc_esp_mont - desc_flet_nc);
  document.forms["form1"].elements["txtsubtotal"].value = subtotal.toFixed(2);

  let desc_pronto_pago_porc = document.forms["form1"].elements["txtdesc_pronto_pago_porc"].value;
  if( (desc_pronto_pago_porc > 0) && (desc_pronto_pago_porc <= 100) ) {
    desc_pronto_pago_mont = subtotal * (parseFloat(desc_pronto_pago_porc) / 100);
    document.forms["form1"].elements["txtdesc_pronto_pago_mont"].value = desc_pronto_pago_mont.toFixed(2);
  } else {
    document.forms["form1"].elements["txtdesc_pronto_pago_mont"].value = 0;
  }

  let desc_divisa_porc = document.forms["form1"].elements["txtdesc_divisa_porc"].value;
  if( (desc_divisa_porc > 0) && (desc_divisa_porc <= 100) ) {
    filas2.forEach((fila, index) => {
      const celdas = fila.cells;
      for (let i = 0; i < celdas.length; i++) {
        if(celdas[i].className == "text-left celda_moned") {
          if(celdas[i].innerText == "$") {
            tot_cobrado_divisa = parseFloat(tot_cobrado_divisa) + parseFloat(celdas[i + 1].innerText.replace(/,/g, ""));
          }
        }
      }
    });

    desc_divisa_mont = tot_cobrado_divisa * (parseFloat(desc_divisa_porc) / 100);
    document.forms["form1"].elements["txtdesc_divisa_mont"].value = desc_divisa_mont.toFixed(2);
  } else {
    document.forms["form1"].elements["txtdesc_divisa_mont"].value = 0;
  }

  total = parseFloat(subtotal) - parseFloat(desc_divisa_mont) - parseFloat(desc_pronto_pago_mont);
  document.forms["form1"].elements["txttotal"].value = total.toFixed(2);

  pendiente = (parseFloat(total) - parseFloat(tot_cobrado));
  document.forms["form1"].elements["txtpendiente"].value = pendiente.toFixed(2);
}

$("#txtdesc_esp_porc").on("blur", function() { calcular_totales(); });
$("#txtdesc_flet_nc").on("blur", function() { calcular_totales(); });
$("#txtdesc_divisa_porc").on("blur", function() { calcular_totales(); });
$("#txtdesc_pronto_pago_porc").on("blur", function() { calcular_totales(); });

$("#txtdesc_esp_porc").on("click", function() { this.select(); });
$("#txtdesc_flet_nc").on("click", function() { this.select(); });
$("#txtdesc_divisa_porc").on("click", function() { this.select(); });
$("#txtdesc_pronto_pago_porc").on("click", function() { this.select(); });

// BOTON CERRAR
$("#btnclose_").click(function () {
    window.location.href = baseurl + "CobranzaController/cobranza/";
});

//*****************************************************************************
// GUARDAR COBRANZA
//*****************************************************************************
$("#btnsave").click(function () {
  if(validar_form() == true) {
    $("#btnclose_").focus();

    if (confirm('\u00BFEsta seguro de guardar la cobranza?')) {
      document.forms["form1"].elements["cmbempresa"].disabled = false;
      document.forms["form1"].elements["cmbcliente"].disabled = false;

      var operacion = document.forms["form1"].elements["operacion"].value;
      var formData = new FormData($("#form1")[0]);

      if (typeof myDropzone !== 'undefined') {
        var archivosEnCola = myDropzone.getQueuedFiles();
        archivosEnCola.forEach(function(archivo) {
            formData.append("imagenes[]", archivo);
        });
      }

      if (operacion == '3') {
        $.ajax({
          type: "POST",
          url: baseurl + "CobranzaController/guardar_cobranza",
          data: formData,
          contentType: false,
          processData: false,
          success: function (respuesta) {
            if (typeof respuesta === "string" && respuesta.includes("A PHP Error was encountered")) {
              alert(respuesta);
            } else {
              var respuesta = (typeof respuesta === "string") ? JSON.parse(respuesta) : respuesta;

              if (respuesta.resultado == "1") {
                alert("Registro satisfactorio");
                window.location.href = baseurl + "CobranzaController/listacobranza/";
              }
              else if (respuesta.resultado == "ERROR") {
                alert(respuesta.msn);
              }
            }
          },
          error: function(xhr, status, error) {
            alert("Error crítico de comunicación con el servidor:\n" + error);
          }
        });
      }
    }
  }
});

//*****************************************************************************
// VALIDAR FORMULARIO
//*****************************************************************************
function validar_form() {
  if (document.forms["form1"].elements["idvendedor"].value.length < 1) {
    alert('Indique el vendedor');
    document.forms["form1"].elements["nbvendedor"].focus();
    return (false);
  }
  if (document.forms["form1"].elements["nbvendedor"].value.length < 1) {
    alert('Indique el vendedor');
    document.forms["form1"].elements["nbvendedor"].focus();
    return (false);
  }
  if (document.forms["form1"].elements["fecha"].value.length < 1) {
    alert('Indique la fecha de registro');
    document.forms["form1"].elements["fecha"].focus();
    return (false);
  }
  if(document.forms["form1"].elements["cmbempresa"].value == "") {
    alert('Ingrese la empresa');
    document.forms["form1"].elements["cmbempresa"].focus();
    return (false);
  }
  if(document.forms["form1"].elements["cmbcliente"].value == "") {
    alert('Ingrese el cliente');
    document.forms["form1"].elements["cmbcliente"].focus();
    return (false);
  }
  if( (document.forms["form1"].elements["txttot_fact"].value.length < 1) || (document.forms["form1"].elements["txttot_fact"].value <= 0) ) {
    alert('No se posee un total facturado');
    document.forms["form1"].elements["btnaddtab_1"].focus();
    return (false);
  }
  if( (document.forms["form1"].elements["txtcobrado"].value.length < 1) || (document.forms["form1"].elements["txtcobrado"].value <= 0) ) {
    alert('No se posee un total cobrado');
    document.forms["form1"].elements["btnaddtab_2"].focus();
    return (false);
  }
  if( (document.forms["form1"].elements["txtsubtotal"].value.length < 1) || (document.forms["form1"].elements["txtsubtotal"].value <= 0) ||
      (document.forms["form1"].elements["txttotal"].value.length < 1) || (document.forms["form1"].elements["txttotal"].value <= 0) ) {
    alert('Existe algun error en los calculos de subtotal o total');
    document.forms["form1"].elements["btnsave"].focus();
    return (false);
  }
  if( (document.forms["form1"].elements["txtpendiente"].value.length < 1) ) {
    alert('Existe algun error en los calculos de saldo pendiente');
    document.forms["form1"].elements["btnsave"].focus();
    return (false);
  }
  if( (document.forms["form1"].elements["txtdesc_esp_porc"].value.length < 1) ) {
    alert('Existe algun error el porcentaje de descuento no puede estar vacio');
    document.forms["form1"].elements["txtdesc_esp_porc"].focus();
    return (false);
  }
  if( (document.forms["form1"].elements["txtdesc_flet_nc"].value.length < 1) ) {
    alert('Existe algun error en el descuento en flete no puede estar vacio');
    document.forms["form1"].elements["txtdesc_flet_nc"].focus();
    return (false);
  }
  if( (document.forms["form1"].elements["txtdesc_divisa_porc"].value.length < 1) ) {
    alert('Existe algun error en el porcentaje de descuento por pago en divisa no puede estar vacio');
    document.forms["form1"].elements["txtdesc_divisa_porc"].focus();
    return (false);
  }
  else {
      return (true);
  }
}