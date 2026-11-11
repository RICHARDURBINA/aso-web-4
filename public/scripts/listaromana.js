// ============================================================================
// 1. VARIABLES GLOBALES Y CONFIGURACIÓN INICIAL
// ============================================================================
let shipmentChart = null;
window.topProveedoresDetalle = {};

// Estado de paginación global para las 4 columnas de control de vehículos
const cvState = {
    recepcion: { page: 1, perPage: 4 },
    muestreo: { page: 1, perPage: 4 },
    pesaje: { page: 1, perPage: 4 },
    descargado: { page: 1, perPage: 4 }
};

let vehiculosDataGlobal = {
    recepcion: [],
    muestreo: [],
    pesaje: [],
    descargado: []
};

// Variables globales para el filtrado por pestañas del Listado de Vehículos
let listaVehiculosGlobal = [];
let tabActivaActual = 'descargado';

// Variables globales para el filtrado por pestañas de Entradas por Almacén
let almacenesDataGlobal = [];
let tabAlmacenActual = 'propio';


// ============================================================================
// 2. EVENTO DOCUMENT READY (INICIALIZACIÓN DE DATATABLES Y EVENTOS)
// ============================================================================
$(document).ready(function () {
    console.log("romana.js cargado correctamente.");

    // Inicialización del DataTable principal (#example - Almacenes)
    if ($('#example').length > 0) {
        if (!$.fn.DataTable.isDataTable('#example')) {
            $('#example').DataTable({
                responsive: true,
                paging: true,
                searching: true,
                ordering: true,
                order: [[1, 'asc']],
                lengthMenu: [5, 10, 25, 50],
                pageLength: 5,
                dom: 'rtip',
                buttons: [],
                language: {
                    processing: "Procesando...",
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_ registros",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    infoEmpty: "Mostrando 0 a 0 de 0 registros",
                    infoFiltered: "(filtrado de _MAX_ registros totales)",
                    loadingRecords: "Cargando...",
                    zeroRecords: "No se encontraron resultados",
                    emptyTable: "Ningún dato disponible en esta tabla",
                    paginate: {
                        first: "Primero",
                        previous: "Anterior",
                        next: "Siguiente",
                        last: "Último"
                    }
                },
                columnDefs: [
                    { orderable: false, targets: 0 }
                ]
            });
        }
    }

    // Inicialización del DataTable para Listado de Vehículos con Pestañas (#datatable_vehiculo)
    if ($('#datatable_vehiculo').length > 0) {
        if ($.fn.DataTable.isDataTable('#datatable_vehiculo')) {
            $('#datatable_vehiculo').DataTable().destroy();
        }

        let tableVehiculos = $('#datatable_vehiculo').DataTable({
            responsive: true,
            paging: true,
            searching: true,
            ordering: true,
            order: [[0, 'asc']],
            lengthMenu: [5, 10, 25, 50],
            pageLength: 5,
            dom: '<"row mb-3"<"col-md-6"B><"col-md-6"f>>rtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="icon-base ri ri-file-excel-2-line icon-18px text-success"></i>',
                    titleAttr: 'Exportar a Excel',
                    className: 'btn btn-light btn-sm px-3 py-2 border me-2'
                },
                {
                    extend: 'print',
                    text: '<i class="icon-base ri ri-printer-line icon-18px text-primary"></i>',
                    titleAttr: 'Imprimir listado',
                    className: 'btn btn-light btn-sm px-3 py-2 border'
                }
            ],
            language: {
                processing: "Procesando...",
                search: "Buscar:",
                lengthMenu: "Mostrar _MENU_ registros",
                info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                infoEmpty: "Mostrando 0 a 0 de 0 registros",
                infoFiltered: "(filtrado de _MAX_ registros totales)",
                loadingRecords: "Cargando...",
                zeroRecords: "No se encontraron resultados",
                emptyTable: "Ningún dato disponible en esta tabla",
                paginate: {
                    first: "Primero",
                    previous: "Anterior",
                    next: "Siguiente",
                    last: "Último"
                }
            }
        });

        if ($('#export-buttons-container').length > 0) {
            tableVehiculos.buttons().container().appendTo('#export-buttons-container');
        }
    }

    establecer_fechas_por_defecto();
    iniciarformulario();
    fn_filter();

    // 3. Refrescar automático cada 5 minutos (300000 ms) sin mostrar el indicador de carga
    setInterval(function() {
        console.log("Refrescando datos de la romana automáticamente...");
        fn_filter(false); 
    }, 300000); 
});


// ============================================================================
// 3. FUNCIONES AUXILIARES DE FORMULARIO, FECHAS Y VALIDACIÓN
// ============================================================================
function establecer_fechas_por_defecto() {
    const inputDesde = document.forms["form1"]?.elements["txtdesde"];
    const inputHasta = document.forms["form1"]?.elements["txthasta"];

    if (inputDesde && inputHasta && !inputDesde.value) {
        let hoy = new Date().toISOString().split('T')[0];
        inputDesde.value = hoy;
        inputHasta.value = hoy;
    }
}

function iniciarformulario() {
  $('#cmbcondicion').empty();
  $('#cmbcondicion').append(new Option('', '', true, true));
  llenarcombocondicion();
  
  renderControlVehiculosColumn('recepcion');
  renderControlVehiculosColumn('muestreo');
  renderControlVehiculosColumn('pesaje');
  renderControlVehiculosColumn('descargado');
}

function llenarcombocondicion() {
  const datos = [
    { id: '%', texto: 'TODOS' },
    { id: 'H', texto: 'HUMEDO' },
    { id: 'S', texto: 'ACONDICIONADO' }
  ];

  const $miSelect =$('#cmbcondicion');
  $miSelect.empty();

  datos.forEach(item => {
    let nuevaOpcion = new Option(item.texto, item.id, false, false);
    $miSelect.append(nuevaOpcion);
  });
  
  $miSelect.trigger('change');
}

function fn_filter(mostrarCarga = true) {
  if (validar_form() == true) {    
    consultar_romana(mostrarCarga);
  }
}

function validar_form() {
  const txtdesde = document.forms["form1"].elements["txtdesde"].value;
  const txthasta = document.forms["form1"].elements["txthasta"].value;

  if (!txtdesde || txtdesde.length < 1) {
    alert('Indique la fecha desde');
    document.forms["form1"].elements["txtdesde"].focus();
    return false;
  }

  if (!txthasta || txthasta.length < 1) {
    alert('Indique la fecha hasta');
    document.forms["form1"].elements["txthasta"].focus();
    return false;
  }

  return true;
}


// ============================================================================
// 4. GRÁFICA DE CALIDAD (APEXCHARTS)
// ============================================================================
function actualizar_grafica(dataAverages) {
  const chartEl = document.querySelector("#shipmentStatisticsChart");
  
  if (chartEl) {
    const keys = ['HMD', 'IMP', 'GDT', 'GPT', 'GCS', 'GAM', 'PAF', 'MZC'];

    const chartConfig = {
      series: [
        {
          name: 'Promedio Calidad',
          data: dataAverages 
        }
      ],
      chart: {
        height: 250,
        type: 'bar',
        parentHeightOffset: 0,
        toolbar: { show: false },
        zoom: { enabled: false }
      },
      colors: [
        '#696cff', '#71dd37', '#03c3ec', '#ffab00', 
        '#ff3e1d', '#8592a3', '#233446', '#e83e8c'
      ],
      plotOptions: {
        bar: {
          columnWidth: '50%',
          borderRadius: 4,
          distributed: true
        }
      },
      grid: {
        strokeDashArray: 4,
        borderColor: '#e7e7e7'
      },
      dataLabels: {
        enabled: false
      },
      xaxis: {
        categories: keys,
        axisBorder: { show: false },
        axisTicks: { show: false },
        labels: {
          style: { colors: '#a1acb8', fontSize: '13px' }
        }
      },
      yaxis: {
        labels: {
          style: { colors: '#a1acb8', fontSize: '13px' },
          formatter: function (val) {
            return (val !== undefined && val !== null ? val.toFixed(1) : "0.0") + "%";
          }
        }
      },
      legend: { show: false }
    };

    if (shipmentChart) {
      shipmentChart.updateSeries([{ data: dataAverages }]);
    } else {
      shipmentChart = new ApexCharts(chartEl, chartConfig);
      shipmentChart.render();
    }
  }
}


// ============================================================================
// 5. CONSULTA PRINCIPAL AJAX Y PROCESAMIENTO DE DATOS
// ============================================================================
function consultar_romana(mostrarCarga = true) {
  var txtdesde     = document.forms["form1"].elements["txtdesde"].value;
  var txthasta     = document.forms["form1"].elements["txthasta"].value;
  var cmbcondicion = "%";

  if (document.forms["form1"].elements["cmbcondicion"].value != "") {
    cmbcondicion = document.forms["form1"].elements["cmbcondicion"].value;
  }

  let urlDestino = (typeof baseurl !== 'undefined' ? baseurl : '') + "RomanaController/consultar_romana";

  if (mostrarCarga) {
      if ($('#global-loader-overlay').length === 0) {
          $('body').append(`
              <style>
                  @keyframes customWaveAnim {
                      0%, 40%, 100% { transform: scaleY(0.4); }
                      20% { transform: scaleY(1); }
                  }
                  .custom-wave-bar {
                      background-color: #696cff;
                      width: 6px;
                      height: 35px;
                      margin: 0 3px;
                      border-radius: 3px;
                      display: inline-block;
                      animation: customWaveAnim 1.2s infinite ease-in-out;
                  }
                  .custom-wave-bar:nth-child(2) { animation-delay: -1.1s; }
                  .custom-wave-bar:nth-child(3) { animation-delay: -1.0s; }
                  .custom-wave-bar:nth-child(4) { animation-delay: -0.9s; }
                  .custom-wave-bar:nth-child(5) { animation-delay: -0.8s; }
              </style>
              <div id="global-loader-overlay" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(0, 0, 0, 0.4); z-index: 99999; display: flex; justify-content: center; align-items: center; backdrop-filter: blur(2px);">
                  <div class="text-center bg-white p-4 rounded-4 shadow-lg d-flex flex-column align-items-center" style="min-width: 260px;">
                      <div class="mb-3 d-flex align-items-center justify-content-center" style="height: 45px;">
                          <div class="custom-wave-bar"></div>
                          <div class="custom-wave-bar"></div>
                          <div class="custom-wave-bar"></div>
                          <div class="custom-wave-bar"></div>
                          <div class="custom-wave-bar"></div>
                      </div>
                      <span class="fw-bold text-dark fs-6">Cargando datos de la romana...</span>
                  </div>
              </div>
          `);
      } else {
          $('#global-loader-overlay').fadeIn(200);
      }
  }

  $.ajax({
    type: "POST",
    url: urlDestino,
    data: { txtdesde: txtdesde, txthasta: txthasta, cmbcondicion: cmbcondicion },
    success: function (respuesta) {
      if (mostrarCarga) {
          $('#global-loader-overlay').fadeOut(200);
      }

      try {
        var jsonRespuesta = (typeof respuesta === "object") ? respuesta : JSON.parse(respuesta);
        
        if (typeof respuesta === "string" && respuesta.includes("A PHP Error was encountered")) {
            alert(respuesta);
            return;
        }

        if (jsonRespuesta.resultado == "1") {

          let kg_tercero = 0;
          let kg_propio = 0;
          let kg_general = 0;
          let cont_tercero = 0;
          let cont_propio = 0;
          let cont_general = 0;
          let porc_tercero = 0;
          let porc_propio = 0;
          let array_almacen = {};

          $('#cmbcondicion').val(jsonRespuesta.par_condicion).trigger('change');

          if (jsonRespuesta.Model_consultar_NOE_ALM && Array.isArray(jsonRespuesta.Model_consultar_NOE_ALM)) {
              for (let noe_alm of jsonRespuesta.Model_consultar_NOE_ALM) {
                  let cantidad = parseFloat(noe_alm.CA_PRODUCTO_NOE) || 0; 
                  let tipoAlmacen = (noe_alm.CO_TIPO_ALMACEN || '').trim().toUpperCase();

                  let esPropio = (tipoAlmacen === 'P' || tipoAlmacen === 'PROPIO');

                  if (esPropio) {
                      kg_propio += cantidad;
                      cont_propio += 1;
                  } else {
                      kg_tercero += cantidad;
                      cont_tercero += 1;
                  }

                  let keyAlm = noe_alm.CO_ALMACEN_NOE;
                  if (array_almacen[keyAlm]) {
                      array_almacen[keyAlm].TOTAL_CA_PRODUCTO_NOE += cantidad;
                      array_almacen[keyAlm].CANTIDAD_REGISTROS += 1;
                  } else {
                      array_almacen[keyAlm] = {
                          CO_ALMACEN_NOE: noe_alm.CO_ALMACEN_NOE,
                          NB_ALMACEN_NOE: noe_alm.NB_ALMACEN_NOE,
                          TOTAL_CA_PRODUCTO_NOE: cantidad,
                          CANTIDAD_REGISTROS: 1,
                          CO_TIPO_ALMACEN: noe_alm.CO_TIPO_ALMACEN
                      };
                  }
              }
          }

          almacenesDataGlobal = Object.values(array_almacen);
          kg_general = kg_propio + kg_tercero;
          cont_general = cont_propio + cont_tercero;

          porc_propio = kg_general > 0 ? (kg_propio * 100) / kg_general : 0;
          porc_tercero = kg_general > 0 ? (kg_tercero * 100) / kg_general : 0;

          document.getElementById("kpi1_total_kg_p").innerHTML = Number(kg_propio).toLocaleString('en-US', {minimumFractionDigits: 0, maximumFractionDigits: 0}) + " KG";
          document.getElementById("kpi1_porc_kg_p").innerHTML = Number(porc_propio).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + " %";
          document.getElementById("kpi1_total_kg_c").innerHTML = Number(kg_tercero).toLocaleString('en-US', {minimumFractionDigits: 0, maximumFractionDigits: 0}) + " KG";
          document.getElementById("kpi1_porc_kg_c").innerHTML = Number(porc_tercero).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + " %";

          let porc_patio = 0;
          let totalElementos = 0;

          if (jsonRespuesta.Model_consultar_NOR && 
              jsonRespuesta.Model_consultar_NOR.length > 0 && 
              jsonRespuesta.Model_consultar_NOR[0].TOTAL_EN_PATIO !== undefined) 
          {
              let totalEnPatio = parseFloat(jsonRespuesta.Model_consultar_NOR[0].TOTAL_EN_PATIO) || 0;
              totalElementos = jsonRespuesta.Model_consultar_NOR.length;
              porc_patio = totalEnPatio;
          } 

          document.getElementById("kpi3_total_vehiculo_p").innerHTML = Number(totalElementos).toLocaleString('en-US', {minimumFractionDigits: 0, maximumFractionDigits: 0}) + " UND";
          document.getElementById("kpi3_porc_vehiculo_p").innerHTML = Number(porc_patio).toLocaleString('en-US', {minimumFractionDigits: 0, maximumFractionDigits: 0}) + " UND";

          if (jsonRespuesta.promedio_descarga_hms) {
              const elementoPromedio = document.getElementById('promedioTiempo');
              if (elementoPromedio) {
                  elementoPromedio.textContent = jsonRespuesta.promedio_descarga_hms;
              }
          }

          renderizarTablaAlmacenesPorTab(tabAlmacenActual);

          if (jsonRespuesta.Model_consultar_Control && Array.isArray(jsonRespuesta.Model_consultar_Control)) {
              listaVehiculosGlobal = jsonRespuesta.Model_consultar_Control;
              renderizarTablaVehiculosPorTab(tabActivaActual);
          } else {
              listaVehiculosGlobal = [];
              renderizarTablaVehiculosPorTab(tabActivaActual);
          }

          const dataRows = jsonRespuesta.Model_consultar_NOE_ALM || [];
          const keys = ['HMD', 'IMP', 'GDT', 'GPT', 'GCS', 'GAM', 'PAF', 'MZC'];

          let sums = { HMD: 0, IMP: 0, GDT: 0, GPT: 0, GCS: 0, GAM: 0, PAF: 0, MZC: 0 };
          let counts = { HMD: 0, IMP: 0, GDT: 0, GPT: 0, GCS: 0, GAM: 0, PAF: 0, MZC: 0 };

          dataRows.forEach(item => {
            keys.forEach(key => {
              let val = parseFloat(item[key]);
              if (!isNaN(val)) {
                sums[key] += val;
                counts[key] += 1;
              }
            });
          });

          const averages = keys.map(key => {
            return counts[key] > 0 ? parseFloat((sums[key] / counts[key]).toFixed(2)) : 0;
          });

          actualizar_grafica(averages);
          control_vehiculo(jsonRespuesta.Model_consultar_Control);

          try {
              let proveedoresMap = {};

              if (jsonRespuesta.Model_consultar_Control && Array.isArray(jsonRespuesta.Model_consultar_Control)) {
                  jsonRespuesta.Model_consultar_Control.forEach(item => {
                      if (!item.FH_FINAL) {
                          return;
                      }

                      let proveedor = item.NB_ORGANIZACION_NOR || 'SIN PROVEEDOR';
                      let cantidad = parseFloat(item.CA_PRODUCTO_NOE) || 0;
                      let almacen = item.NB_ALMACEN || 'Sin Almacén';

                      if (proveedor && proveedor !== 'SIN PROVEEDOR') {
                          if (!proveedoresMap[proveedor]) {
                              proveedoresMap[proveedor] = {
                                  total: 0,
                                  almacenes: {}
                              };
                          }
                          proveedoresMap[proveedor].total += cantidad;
                          proveedoresMap[proveedor].almacenes[almacen] = (proveedoresMap[proveedor].almacenes[almacen] || 0) + cantidad;
                      }
                  });
              }

              let topProveedores = Object.keys(proveedoresMap).map(nombre => {
                  return { 
                      nombre: nombre, 
                      total: proveedoresMap[nombre].total,
                      almacenes: proveedoresMap[nombre].almacenes
                  };
              }).sort((a, b) => b.total - a.total).slice(0, 5);

              renderizar_top_proveedores_lista(topProveedores);
          } catch (errTop) {
              console.warn("Aviso en Top Proveedores:", errTop);
          }
          
        } else if (jsonRespuesta.resultado == "0") {
          alert("No retornaron datos esperados");
        } else if (jsonRespuesta.resultado == "ERROR") {
          alert(jsonRespuesta.msn);
        } else {
          alert("No retornaron datos esperados");
        }
      } catch (e) {
        console.error("Error principal AJAX: ", e);
        alert("Ocurrió un error al procesar la respuesta del servidor.");
      }
    },
    error: function(xhr, status, error) {
      if (mostrarCarga) {
          $('#global-loader-overlay').fadeOut(200);
      }
      console.error("Error de conexión:", status, error);
      alert("Error de conexión con el servidor.");
    }
  });
}


// ============================================================================
// 6. CONTROL DE PESTAÑAS Y RENDERIZADO DEL LISTADO DE ALMACENES Y VEHÍCULOS
// ============================================================================
window.cambiarTabAlmacenes = function(nombreTab) {
    tabAlmacenActual = nombreTab;
    
    document.querySelectorAll('#almacenesTabs .nav-link').forEach(btn => {
        btn.classList.remove('active');
        if (btn.getAttribute('data-tab') === nombreTab) {
            btn.classList.add('active');
        }
    });

    renderizarTablaAlmacenesPorTab(tabAlmacenActual);
};

function renderizarTablaAlmacenesPorTab(tab) {
    let tabla = $('#example').DataTable();
    tabla.clear();

    if (!Array.isArray(almacenesDataGlobal) || almacenesDataGlobal.length === 0) {
        tabla.draw();
        document.getElementById("total1_cont_general").innerHTML = "0";
        document.getElementById("total2_cont_general").innerHTML = "0";
        document.getElementById("total1_kg_general").innerHTML = "0.00 KG";
        document.getElementById("total2_kg_general").innerHTML = "0.00 KG";
        return;
    }

    let totalKgTab = 0;
    let totalContTab = 0;

    almacenesDataGlobal.forEach(almacen => {
        let tipo = (almacen.CO_TIPO_ALMACEN || '').trim().toUpperCase();
        let esPropio = (tipo === 'P' || tipo === 'PROPIO');
        
        let cumpleFiltro = false;
        if (tab === 'propio') {
            cumpleFiltro = esPropio;
        } else if (tab === 'consignacion') {
            cumpleFiltro = !esPropio;
        }

        if (cumpleFiltro) {
            totalKgTab += parseFloat(almacen.TOTAL_CA_PRODUCTO_NOE) || 0;
            totalContTab += parseInt(almacen.CANTIDAD_REGISTROS) || 0;

            let cantRegFmt = Number(almacen.CANTIDAD_REGISTROS).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            let totalKilosFmt = Number(almacen.TOTAL_CA_PRODUCTO_NOE).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});

            tabla.row.add([
                `<div class="td-cedula-container">        
                    <div class="avatar flex-shrink-0 me-3">
                        <i class="icon-base ri ri-car-line icon-24px"></i>
                    </div>
                    <span class="cedula-data">${almacen.CO_ALMACEN_NOE}</span>
                 </div>`,
                `<span class="badge-office">${almacen.NB_ALMACEN_NOE}</span>`,
                cantRegFmt,
                `<span class="badge-office">${totalKilosFmt}</span>`
            ]);
        }
    });

    tabla.draw();
    tabla.columns.adjust().responsive.recalc();

    document.getElementById("total1_cont_general").innerHTML = Number(totalContTab).toLocaleString('en-US', {minimumFractionDigits: 0, maximumFractionDigits: 0});
    document.getElementById("total2_cont_general").innerHTML = Number(totalContTab).toLocaleString('en-US', {minimumFractionDigits: 0, maximumFractionDigits: 0});
    document.getElementById("total1_kg_general").innerHTML = Number(totalKgTab).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + " KG";
    document.getElementById("total2_kg_general").innerHTML = Number(totalKgTab).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + " KG";
}

window.cambiarTabVehiculos = function(nombreTab) {
    tabActivaActual = nombreTab;
    
    document.querySelectorAll('#vehiculosTabs .nav-link').forEach(btn => {
        btn.classList.remove('active');
        if (btn.getAttribute('data-tab') === nombreTab) {
            btn.classList.add('active');
        }
    });

    renderizarTablaVehiculosPorTab(tabActivaActual);
};

function renderizarTablaVehiculosPorTab(tab) {
    let tablaVehiculos = $('#datatable_vehiculo').DataTable();
    tablaVehiculos.clear();

    if (!Array.isArray(listaVehiculosGlobal) || listaVehiculosGlobal.length === 0) {
        tablaVehiculos.draw();
        const elContV3 = document.getElementById("total3_cont_general");
        const elKgV3 = document.getElementById("total3_kg_general");
        if (elContV3) elContV3.innerText = "0 Und";
        if (elKgV3) elKgV3.innerText = "0.00 KG";
        return;
    }

    let totalKilosNetosV = 0;
    let registrosFiltrados = [];

    listaVehiculosGlobal.forEach(item => {
        let fhFinal = item.FH_FINAL;
        let nuBoleto = item.NU_BOLETO_NOR;
        let cumpleFiltro = false;

        if (tab === 'descargado') {
            cumpleFiltro = (fhFinal !== null && fhFinal !== undefined && fhFinal !== '');
        } 
        else if (tab === 'recepcion') {
            cumpleFiltro = (nuBoleto === null || nuBoleto === undefined || nuBoleto === '');
        } 
        else if (tab === 'pesaje') {
            let tieneBoleto = (nuBoleto !== null && nuBoleto !== undefined && nuBoleto !== '');
            let sinFinal = (fhFinal === null || fhFinal === undefined || fhFinal === '');
            cumpleFiltro = (tieneBoleto && sinFinal);
        }

        if (cumpleFiltro) {
            registrosFiltrados.push(item);
        }
    });

    let totalVehiculosV = registrosFiltrados.length;

    registrosFiltrados.forEach(item => {
        let boleto = item.NU_BOLETO_NOR ? `<span class="badge-office">${item.NU_BOLETO_NOR}</span>` : '';
        let ticket = item.NU_TICKET || '';
        let entrada = item.FH_INICIAL ? item.FH_INICIAL : '';
        let salida = item.FH_FINAL ? item.FH_FINAL : '';
        
        let tiempoSegundos = item.TIEMPO_DESCARGA_SEGUNDOS !== null && item.TIEMPO_DESCARGA_SEGUNDOS !== undefined ? item.TIEMPO_DESCARGA_SEGUNDOS : '';

        let organizacion = item.NB_ORGANIZACION_NOR || '';
        
        let coAlmacen = item.CO_ALMACEN || '';
        let nbAlmacen = item.NB_ALMACEN || '';
        let almacen = (coAlmacen && nbAlmacen) ? `${coAlmacen} - ${nbAlmacen}` : (coAlmacen || nbAlmacen);
        
        let pesoInicial = parseFloat(item.CA_PESO_INICIAL) || 0;
        let pesoFinal = parseFloat(item.CA_PESO_FINAL) || 0;
        let neto = Math.abs(pesoInicial - pesoFinal);

        let acond = parseFloat(item.CA_PRODUCTO_NOE) || 0;
        totalKilosNetosV += acond;
        let netoFmt = Number(neto).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});

        let acondFmt = Number(acond).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});

        let transportista = item.NB_TRANSPORTISTA_NOR || '';
        let chofer = item.NB_CHOFER_NOR || '';
        let vehiculo = item.CO_VEHICULO || '';
        
        let hmd = (item.HMD !== null && item.HMD !== undefined && item.HMD !== '') ? parseFloat(item.HMD).toFixed(2) : '0.00';
        let imp = (item.IMP !== null && item.IMP !== undefined && item.IMP !== '') ? parseFloat(item.IMP).toFixed(2) : '0.00';

        tablaVehiculos.row.add([
            ticket,
            boleto,
            entrada,
            salida,
            tiempoSegundos,
            organizacion,
            almacen,
            netoFmt,
            acondFmt,
            transportista,
            chofer,
            vehiculo,
            hmd,
            imp
        ]);
    });

    tablaVehiculos.draw();
    tablaVehiculos.columns.adjust().responsive.recalc();

    const elContV3 = document.getElementById("total3_cont_general");
    const elKgV3 = document.getElementById("total3_kg_general");
    if (elContV3) elContV3.innerText = totalVehiculosV + " Und";
    if (elKgV3) elKgV3.innerText = Number(totalKilosNetosV).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + " KG";

    const elContV4 = document.getElementById("total4_cont_general");
    const elKgV4 = document.getElementById("total4_kg_general");
    if (elContV4) elContV4.innerText = totalVehiculosV;
    if (elKgV4) elKgV4.innerText = Number(totalKilosNetosV).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + " KG";
}


// ============================================================================
// 7. CONTROL DE VEHÍCULOS (4 COLUMNAS DE ESTADOS)
// ============================================================================
function control_vehiculo(modelControl) {
    vehiculosDataGlobal = {
        recepcion: [],
        muestreo: [],
        pesaje: [],
        descargado: []
    };

    if (modelControl && Array.isArray(modelControl)) {
        modelControl.forEach(item => {
            if (item.NU_TICKET !== null && item.NU_TICKET !== undefined && item.NU_TICKET !== '') {
                
                let vehiculoObj = {
                    codigo: item.NU_TICKET,
                    placa: item.CO_VEHICULO || '',
                    conductor: item.NB_CHOFER_NOR || ''
                };

                let hmd = (item.HMD !== null && item.HMD !== undefined && item.HMD !== '') ? parseFloat(item.HMD) : null;
                let boleto = item.NU_BOLETO_NOR;
                let notaEntrada = item.NU_NOTA_ENTRADA;
                let fhFinal = item.FH_FINAL;

                if ((hmd === 0 || hmd === null) && (boleto === null || boleto === undefined || boleto === '') && (notaEntrada === null || notaEntrada === undefined || notaEntrada === '')) {
                    vehiculosDataGlobal.recepcion.push(vehiculoObj);
                } 
                else if ((hmd !== 0 && hmd !== null) && (boleto === null || boleto === undefined || boleto === '') && (notaEntrada === null || notaEntrada === undefined || notaEntrada === '')) {
                    vehiculosDataGlobal.muestreo.push(vehiculoObj);
                } 
                else if ((boleto !== null && boleto !== undefined && boleto !== '') && (notaEntrada === null || notaEntrada === undefined || notaEntrada === '')) {
                    vehiculosDataGlobal.pesaje.push(vehiculoObj);
                } 
                else if ((boleto !== null && boleto !== undefined && boleto !== '') && (notaEntrada !== null && notaEntrada !== undefined && notaEntrada !== '') && (fhFinal === null || fhFinal === undefined || fhFinal === '')) {
                    vehiculosDataGlobal.descargado.push(vehiculoObj);
                }
            }
        });
    }

    renderControlVehiculosColumn('recepcion');
    renderControlVehiculosColumn('muestreo');
    renderControlVehiculosColumn('pesaje');
    renderControlVehiculosColumn('descargado');
}

function renderControlVehiculosColumn(categoria) {
    const container = document.getElementById(`cv-cards-${categoria}`);
    const pageInfo = document.getElementById(`cv-page-info-${categoria}`);
    const btnPrev = document.getElementById(`cv-btn-prev-${categoria}`);
    const btnNext = document.getElementById(`cv-btn-next-${categoria}`);
    const countBadge = document.getElementById(`cv-count-${categoria}`);

    if (!container) return;

    const items = vehiculosDataGlobal[categoria] || [];
    if (countBadge) countBadge.innerText = items.length;

    const currentPage = cvState[categoria].page;
    const perPage = cvState[categoria].perPage;
    const totalPages = Math.ceil(items.length / perPage) || 1;

    if (currentPage > totalPages) cvState[categoria].page = totalPages;
    if (cvState[categoria].page < 1) cvState[categoria].page = 1;

    const start = (cvState[categoria].page - 1) * perPage;
    const end = start + perPage;
    const paginatedItems = items.slice(start, end);

    let html = "";
    if (paginatedItems.length === 0) {
        html = `<div class="text-center text-muted py-4 small">No hay vehículos</div>`;
    } else {
        paginatedItems.forEach(v => {
            let dotClass = 'dot-warning';
            if (categoria === 'muestreo') dotClass = 'dot-primary';
            if (categoria === 'pesaje') dotClass = 'dot-purple';
            if (categoria === 'descargado') dotClass = 'dot-success';

            html += `
                <div class="cv-card-item">
                    <div class="cv-card-top">
                        <span class="cv-truck-code">
                            <span class="cv-status-dot ${dotClass}"></span>
                            ${v.codigo}
                        </span>
                        <span class="cv-driver-badge">${v.conductor}</span>
                    </div>
                    <p class="cv-plate">Placa: ${v.placa}</p>
                </div>
            `;
        });
    }
    container.innerHTML = html;

    if (pageInfo) pageInfo.innerText = `Pág ${cvState[categoria].page} de ${totalPages}`;
    if (btnPrev) btnPrev.disabled = cvState[categoria].page <= 1;
    if (btnNext) btnNext.disabled = cvState[categoria].page >= totalPages;
}

window.cvCambiarPagina = function (categoria, direccion) {
    cvState[categoria].page += direccion;
    renderControlVehiculosColumn(categoria);
};


// ============================================================================
// 8. RENDERIZADO DEL TOP 5 DE PROVEEDORES
// ============================================================================
function renderizar_top_proveedores_lista(topProveedores) {
    const container = document.getElementById("topProveedoresList");
    if (!container) return;

    if (!topProveedores || topProveedores.length === 0) {
        container.innerHTML = `<div class="text-center text-muted py-4 small">No hay datos de proveedores disponibles</div>`;
        return;
    }

    let maxValor = topProveedores[0].total > 0 ? topProveedores[0].total : 1;
    const coloresPalette = ['#696cff', '#71dd37', '#03c3ec', '#ffab00', '#ff3e1d'];

    let html = "";
    topProveedores.forEach((p, index) => {
        let porcentaje = (p.total / maxValor) * 100;
        let kilosFmt = Number(p.total).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + " KG";
        let colorActual = coloresPalette[index % coloresPalette.length];

        let almacenesStr = "Desglose por Almacén:";
        for (let alm in p.almacenes) {
            almacenesStr += `\n• ${alm}: ${Number(p.almacenes[alm]).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})} KG`;
        }

        html += `
            <div class="tp-item" title="${almacenesStr}">
                <div class="tp-info">
                    <span class="tp-name" title="${p.nombre}">${index + 1}. ${p.nombre}</span>
                    <span class="tp-kilos" style="color: ${colorActual};">${kilosFmt}</span>
                </div>
                <div class="tp-progress-bar-bg">
                    <div class="tp-progress-bar-fill" style="width: ${porcentaje}%; background-color: ${colorActual};"></div>
                </div>
            </div>
        `;
    });

    container.innerHTML = html;
}