var current, current_step, next_step, steps;
let myChart_1, myChart_2, myChart_3, myChart_4, myChart_5, myChart_6, myChart_7, myChart_8;


$(document).on('click', '.card-collapsible', function (event) {
  event.preventDefault();

  const $this = $(this);
  const card = $this.closest('.card')[0];
  const collapseEl = card.querySelector('.collapse');

  // Inicializa o commuta la instancia de Bootstrap Collapse
  const bsCollapse = bootstrap.Collapse.getInstance(collapseEl) || new bootstrap.Collapse(collapseEl);
  bsCollapse.toggle();

  // Alterna clases de estilo
  $this.closest('.card-header').toggleClass('collapsed');

  // Toggle de íconos usando vanilla JS o jQuery
  const icon = $this.find('.icon-base')[0] || this.firstElementChild;
  if (icon && typeof Helpers !== 'undefined' && Helpers._toggleClass) {
    Helpers._toggleClass(icon, 'ri-arrow-down-s-line', 'ri-arrow-up-s-line');
  }
});

//*****************************************************************************
//
//*****************************************************************************
$( document ).ready(function(){

  let permisos = {
    'producto': $('#resumen_producto').val(),
    'transporte': $('#resumen_transporte').val(),
  };

  if(permisos.producto == '0'){ $('#reporte_resumen_producto').hide(); }
  if(permisos.transporte == '0'){ $('#reporte_resumen_transporte').hide(); }

  $('#cmbtransportista').empty();
  $('#cmbtransportista').append(new Option('', '', true, true));
  llenarcombotransportista();

  document.getElementById("btnfilter").click();

});

//*****************************************************************************
//
//*****************************************************************************
function llenarcombotransportista() {

  $.ajax({
    type: "POST",
    url: baseurl + "TransportistaController/consultar_transportista",
    data: { txtcodigo : "%",
            txtnombre : "%",
            txtestatus : "%" },

    success: function( respuesta ){
      
      var res = (typeof respuesta === 'object') ? respuesta : JSON.parse(respuesta);

      if (typeof respuesta === 'string' && respuesta.includes("A PHP Error was encountered")) {
          alert(respuesta);
      }
      else {
        if (res.resultado == "1") {
          $.each(res.arreglo, function (i, item) {

            if( (document.forms["form1"].elements["transportista"].value != "%") &&
                (document.forms["form1"].elements["transportista"].value == item.co_transportista) ) {
              $('#cmbtransportista').append(new Option(item.de_transportista, item.co_transportista, true, true));
            }
            else {
              $('#cmbtransportista').append(new Option(item.de_transportista, item.co_transportista));
            }

          });
        }
        else if (res.resultado == "ERROR") {
          alert(res.msn);
        }
      }

    }
  });
}

//*****************************************************************************
//
//*****************************************************************************
function fn_filter() {

  if(validar_form() == true) {

    $('#cont_resumen').html('');
    $('#cont_resumen_2').html('');
    var txtfecha = document.forms["form1"].elements["txtfecha"].value;
    var cmbtransportista = document.forms["form1"].elements["cmbtransportista"].value;

    $.ajax({
      type: "POST",
      url: baseurl + "GraficaController/datos_resumen_fecha",
      data: {
        txtfecha : txtfecha,
        cmbtransportista: cmbtransportista,
      },
      success: function (respuesta) {
        
        var res = (typeof respuesta === 'object') ? respuesta : JSON.parse(respuesta);

        if (res.resultado == "1") {

          let resumen = res.Model_arr_resumen_1;

          let html = '';
          let u = 1;

          for (let i in resumen) {

            // PRINCIPIO DEL RECUADRO
            if(u == 1){
              html += '<div class="col-md-6">';
              html += '<div class="accordion accordion-custom-button mt-3" id="accordionCustom">';
            }

            html += '<div class="accordion-item">';

            html += '<h2 class="accordion-header m-0" id="headingCustom' + i + '">';
            html += '<button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionCustom' + i + '" aria-expanded="false" aria-controls="accordionCustom' + i + '">';
            html += resumen[i].co_chofer + ' ' + resumen[i].nb_chofer;
            html += '</button>';
            html += '</h2>';

            html += '<div id="accordionCustom' + i + '" class="accordion-collapse collapse" aria-labelledby="headingCustom' + i + '" data-bs-parent="#accordionCustom">';
            html += '<div class="accordion-body" style="padding: 0 0 0 20px;">';
            html += '<div class="table-responsive text-nowrap">';
            html += '<table class="table">';
            html += '<thead>';
            html += '<tr>';
            html += '<th>Organizacion</th>';
            html += '<th>Producto</th>';
            html += '<th>Cantidad</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody class="table-border-bottom-0">';

            for (let ii in resumen[i].detalle_clientes) {

              let cliente = resumen[i].detalle_clientes[ii].nb_organizacion;
              let productos = resumen[i].detalle_clientes[ii].detalle_productos;
              let numero_producto = 1;

              html += '<tr>';
              html += '<td rowspan="' + productos.length + '" class="col_name">' + cliente + '</td>';

              for (let iii in productos) {

                let co_producto = productos[iii].co_producto;
                let nb_producto = productos[iii].nb_producto;
                let ca_producto = productos[iii].ca_prd_aprobado;

                if(numero_producto == 1){

                  html += '<td class="col_product">' + nb_producto + '</td>';
                  html += '<td class="col_cantidad"><span class="badge rounded-pill bg-label-primary me-1">' + ca_producto + '</span></td>';
                  html += '</tr>';

                }else{

                  html += '<tr>';
                  html += '<td class="col_product">' + nb_producto + '</td>';
                  html += '<td class="col_cantidad"><span class="badge rounded-pill bg-label-primary me-1">' + ca_producto + '</span></td>';
                  html += '</tr>';

                }

                numero_producto++;

              }

            }

            html += '</tbody>';
            html += '</table>';
            html += '</div>';
            html += '</div>';

            html += '</div>';

            html += '</div>';

            // FINAL DEL RECUADRO
            if(u == 1){
              html += '</div>';
              html += '</div>';
              u = 1;
            }else{
              u++;
            }

          }

          $('#cont_resumen').append(html);

          let resumen2 = res.Model_arr_resumen_2;
          let total_inventario = 0;
          let total_programada = 0;
          let total_saldo = 0;

          html = '';

          for (let i in resumen2) {

            let nombreCompleto = resumen2[i].co_producto + ' ' + resumen2[i].nb_producto;
            let nombreMostrar = nombreCompleto.length > 75 ? nombreCompleto.substring(0, 75) + '...' : nombreCompleto;

            total_inventario += parseInt(resumen2[i].ca_inventario);
            total_programada += parseInt(resumen2[i].ca_programada);
            total_saldo += (parseInt(resumen2[i].ca_inventario - resumen2[i].ca_programada));

            html += '<div class="card col-md-12 mb-8">';

              html += '<div class="card-body">';

                html += '<div class="card-title header-elements">';

                  html += '<h5 class="m-0 me-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="' + nombreCompleto + '">' + nombreMostrar + '</h5>';

                  html += '<div class="card-title-elements ms-auto">';
                  html += '<span class="badge badge-outline-primary rounded-pill color-primary">Inventario: ' + resumen2[i].ca_inventario + '</span>';
                  html += '<span class="badge badge-outline-primary rounded-pill color-primary">Programado: ' + resumen2[i].ca_programada + '</span>';
                  html += '<span class="badge badge-outline-primary rounded-pill color-primary">Saldo: ' + parseInt(resumen2[i].ca_inventario - resumen2[i].ca_programada) + '</span>';
                  html += '</div>';

                  html += '<div class="card-action-element ms-2">';
                  html += '<ul class="list-inline mb-0">';
                  html += '<li class="list-inline-item">';
                  html += '<a href="javascript:void(0);" class="card-collapsible"><i class="icon-base ri ri-arrow-down-s-line icon-sm"></i></a>';
                  html += '</li>';
                  html += '</ul>';
                  html += '</div>';

                html += '</div>';

                html += '<div class="collapse">';

                  html += '<div class="table-responsive text-nowrap">';

                    html += '<table class="table">';
                    html += '<thead>';
                    html += '<tr>';
                    html += '<th>Organizacion</th>';
                    html += '<th>Chofer</th>';
                    html += '<th>Vehiculo</th>';
                    html += '<th>Cantidad</th>';
                    html += '</tr>';
                    html += '</thead>';
                    html += '<tbody class="table-border-bottom-0">';

                    for (let ii in resumen2[i].detalle) {

                      let detalle = resumen2[i].detalle[ii];

                      html += '<tr>';
                      html += '<td class="col_name">' + detalle.nb_organizacion + '</td>';
                      html += '<td class="col_chofer">' + detalle.co_chofer + ' ' + detalle.nb_chofer + '</td>';
                      html += '<td class="">' + detalle.co_vehiculo + '</td>';
                      html += '<td class="">' + detalle.ca_programada + '</td>';
                      html += '</tr>';

                    }

                    html += '</tbody>';

                    html += '<tfooter>';
                    html += '<tr>';
                    html += '<td class=""></td>';
                    html += '<td class=""></td>';
                    html += '<td class=""></td>';
                    html += '<td class="fw-bold">' + resumen2[i].ca_programada + '</td>';
                    html += '</tr>';
                    html += '</tfooter>';

                    html += '</table>';

                  html += '</div>';

                html += '</div>';

              html += '</div>';

            html += '</div>';

          }

          html += '<div class="card col-md-12 mb-8">';
          html += '<div class="card-body">';
          html += '<div class="card-title header-elements m-0">';
          html += '<h5 class="m-0 me-2">TOTALIZADO:</h5>';
          html += '<div class="card-title-elements ms-auto me-8">';
          html += '<span class="badge rounded-pill">Inventario: ' + total_inventario + '</span>';
          html += '<span class="badge rounded-pill">Programado: ' + total_programada + '</span>';
          html += '<span class="badge rounded-pill">Saldo: ' + total_saldo + '</span>';
          html += '</div>';
          html += '</div>';
          html += '</div>';
          html += '</div>';

          $('#cont_resumen_2').append(html);

          const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
          tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            if (!bootstrap.Tooltip.getInstance(tooltipTriggerEl)) {
              new bootstrap.Tooltip(tooltipTriggerEl);
            }
          });

        }
        else if (res.resultado == "0") {
          alert("No retornaron datos para el resumen");
        }
        else if (res.resultado == "ERROR") {
          alert(res.msn);
          window.location.href = baseurl + "GraficaController/resumen/";
        }
        else {
          alert("No retornaron datos esperados");
          window.location.href = baseurl + "GraficaController/resumen/";
        }
      }
    });

  }

}

//*****************************************************************************
//
//*****************************************************************************
function validar_form() {

  // VALIDACION DE FECHA
  if (document.forms["form1"].elements["txtfecha"].value.length < 1) {
    alert('Indique la fecha a filtrar');
    document.forms["form1"].elements["txtfecha"].focus();
    return (false);
  }

  else {
      return (true);
  }

}