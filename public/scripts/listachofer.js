var current, current_step, next_step, steps;

$( document ).ready(function(){
  if ($.fn.DataTable.isDataTable('#table_responsive')) {
    $('#table_responsive').DataTable().destroy();
  }

  iniciarformulario(); 
    
  var table = $('#table_responsive').DataTable( {
    language: {
      processing: "<i class='fa fa-spinner fa-5x fa-spin fa-fw' aria-hidden='true'></i>",
      search: "<i class='fa fa-search' aria-hidden='true'></i>",
      lengthMenu:     "Mostrando _MENU_ pedidos",
      info:           "Mostrando del _START_ al _END_ de _TOTAL_ choferes",
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
    buttons: [
      { extend: 'colvis', text: '<i class="fa fa-eye" aria-hidden="true"></i>' },
      { extend: 'copy', text: '<i class="fa fa-clipboard" aria-hidden="true"></i>' }, 
      { extend: 'excel', text: '<i class="fa fa-file-excel-o text-success" aria-hidden="true"></i>', title: 'Choferes' }, 
      { extend: 'pdf', text: '<i class="fa fa-file-pdf-o text-danger" aria-hidden="true"></i>', title: 'Choferes' },
      { extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i>' }
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

  table.buttons().container().appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );
  table.search('').draw();

  function syncToggleButtons() {
      $('#table_responsive tbody tr').each(function() {
          var $tr = $(this);
          if ($tr.hasClass('shown')) {
              $tr.find('.btn-toggle-row').text('-');
          } else {
              $tr.find('.btn-toggle-row').text('+');
          }
      });
  }

  syncToggleButtons();
  table.on('draw', function() {
      syncToggleButtons();
  });

  $('#table_responsive tbody').on('click', '.btn-toggle-row', function (e) {
      e.preventDefault();
      var $btnActual = $(this);
      var $trActual = $btnActual.closest('tr');

      if ($trActual.hasClass('shown')) {
          $trActual.removeClass('shown');
          $btnActual.text('+');
      } else {
          $('#table_responsive tbody tr.shown').each(function() {
              $(this).removeClass('shown');
              $(this).find('.btn-toggle-row').text('+');
          });
          $trActual.addClass('shown');
          $btnActual.text('-');
      }
  });
});

$(window).resize(function() {
  var table = $('#table_responsive').DataTable();
  if ($(window).width() <= 768) {
    table.buttons().container().hide(); 
  }
  else {
    table.buttons().container().show();
  }
});

function iniciarformulario() {}

function fn_active(id_chofer_web) {
  if (confirm('\u00BFEsta seguro de activar este chofer?')) {    
    $.ajax({
      type: "POST",
      url: baseurl + "ChoferController/activar_chofer",
      data: {id_chofer_web : id_chofer_web}, 
      success: function (respuesta) {
        if (typeof respuesta === "string" && respuesta.includes("A PHP Error was encountered")) {
            alert(respuesta);
        }
        else {
          var respuesta = (typeof respuesta === "string") ? JSON.parse(respuesta) : respuesta;
          if (respuesta.resultado == "1") {            
            alert("Proceso satisfactorio");
            window.location.href = baseurl + "ChoferController/listachofer";
          }
          else if (respuesta.resultado == "ERROR") {
            alert("Error: " + respuesta.msn);            
          }
        }
      },
      error: function(xhr, status, error) {
        alert("Error de comunicación con el servidor:\n" + error);
      }
    });  
  }
}

function fn_annular(id_chofer_web) {
  if (confirm('\u00BFEsta seguro de inactivar este chofer?')) {
    $.ajax({
      type: "POST",
      url: baseurl + "ChoferController/inactivar_chofer",
      data: {id_chofer_web : id_chofer_web}, 
      success: function (respuesta) {
        if (typeof respuesta === "string" && respuesta.includes("A PHP Error was encountered")) {
            alert(respuesta);
        }
        else {
          var respuesta = (typeof respuesta === "string") ? JSON.parse(respuesta) : respuesta;
          if (respuesta.resultado == "1") {            
            alert("Proceso satisfactorio");
            window.location.href = baseurl + "ChoferController/listachofer";
          }
          else if (respuesta.resultado == "ERROR") {
            alert("Error: " + respuesta.msn);            
          }
        }
      },
      error: function(xhr, status, error) {
        alert("Error de comunicación con el servidor:\n" + error);
      }
    });  
  }
}

$("#btnadd").click(function () {
  $('#form1')[0].reset();
  $('#modal_form_1').modal('show');
  document.forms["form1"].elements["operacion"].value = "1";

  setTimeout(function(){
      $('#txtcodigo').focus();
  }, 500);
});

$("#btnsave").click(function () {
  if(validar_form() == true) {
    document.forms["form1"].elements["btnsave"].disabled = true;
    $("#btnclose_").focus();

    if (confirm('\u00BFEsta seguro de guardar el chofer?')) {
      var str = $("#form1").serialize();

      $.ajax({
        type: "POST",
        url: baseurl + "ChoferController/guardar_chofer",
        data: str,
        success: function (respuesta) {
          if (typeof respuesta === "string" && respuesta.includes("A PHP Error was encountered")) {
              alert(respuesta);
              document.forms["form1"].elements["btnsave"].disabled = false;
          }
          else {
            var respuesta = (typeof respuesta === "string") ? JSON.parse(respuesta) : respuesta;
            if (respuesta.resultado == "1") {
              alert("Registro satisfactorio");
              window.location.href = baseurl + "ChoferController/listachofer/";
            }
            else if (respuesta.resultado == "ERROR") {
              alert(respuesta.msn);
              document.forms["form1"].elements["btnsave"].disabled = false;
              $('#modal_form_1').modal('hide');
            }
          }
        },
        error: function(xhr, status, error) {
          alert("Error de comunicación con el servidor:\n" + error);
          document.forms["form1"].elements["btnsave"].disabled = false;
        }
      });
    }
    else {
       document.forms["form1"].elements["btnsave"].disabled = false;
    }
  }
});

function validar_form() {
  if (document.forms["form1"].elements["txtcodigo"].value.length < 1) {
    alert('Indique el código del chofer');
    document.forms["form1"].elements["txtcodigo"].focus();
    return (false);
  }
  if (document.forms["form1"].elements["txtnombre"].value.length < 1) {
    alert('Indique el nombre del chofer');
    document.forms["form1"].elements["txtnombre"].focus();
    return (false);
  } 
  else {
      return (true);
  }
}

function fn_update(id_registro) {
  $.ajax({
    type: "POST",
    url: baseurl + "ChoferController/consultar_chofer",
    data: {txtid : id_registro, txtcodigo : "%", txtnombre : "%", txtestatus : "%"},
    success: function (respuesta) {
      if (typeof respuesta === "string" && respuesta.includes("A PHP Error was encountered")) {
          alert(respuesta);
      }
      else {
        var respuesta = (typeof respuesta === "string") ? JSON.parse(respuesta) : respuesta;
        if (respuesta.resultado == "1") {
          $('#form1')[0].reset();  
          $('#modal_form_1').modal('show'); 

          document.forms["form1"].elements["operacion"].value = "3";

          setTimeout(function(){
              $('#txtcodigo').focus();
          }, 500);

          document.forms["form1"].elements["txtid"].value = respuesta.arreglo[0]["id_chofer"];
          document.forms["form1"].elements["txtcodigo"].value = respuesta.arreglo[0]["co_chofer"]; 
          document.forms["form1"].elements["txtnombre"].value = respuesta.arreglo[0]["nb_chofer"]; 
          
          document.forms["form1"].elements["txtcodigo"].disabled = false;
          document.forms["form1"].elements["txtnombre"].disabled = false;
        }
        else if (respuesta.resultado == "0") {
          alert("No retornaron datos esperados");
          $('#modal_form_1').modal('hide');
        }
        else if (respuesta.resultado == "ERROR") {
          alert(respuesta.msn);
          $('#modal_form_1').modal('hide');
        }
      }
    },
    error: function(xhr, status, error) {
      alert("Error de comunicación con el servidor:\n" + error);
    }
  });
}