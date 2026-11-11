var current, current_step, next_step, steps;
let myChart_1, myChart_2, myChart_3, myChart_4, myChart_5, myChart_6, myChart_7, myChart_8;

//*****************************************************************************
//
//*****************************************************************************
$( document ).ready(function(){  

  //document.forms["form1"].elements["txtdesde"].value = '2026-01-01';
  //document.forms["form1"].elements["txthasta"].value = '2026-12-31';

  if( (document.forms["form1"].elements["cobro_adesa"].value == "1") && (document.forms["form1"].elements["cobro_aai"].value == "1") )
  {    
        
    html  = '<div class="row" id="row_1">';
    html += '<div class="col-md-1"></div>';
    html += '<div class="col-md-4 alt_fija" id="col_1">';
    html += '<canvas id="myChart_1"></canvas>';
    html += '</div>';
    html += '<div class="col-md-1"></div>';
    html += '<div class="col-md-4 alt_fija" id="col_2">';
    html += '<canvas id="myChart_2"></canvas>';
    html += '</div>';
    html += '<div class="col-md-2"></div>';
    html += '</div>';

    html += '<br>';
    html += '<br>';

    html += '<div class="row" id="row_2">';    
    html += '<div class="col-md-5 alt_fija" id="col_3">';
    html += '<canvas id="myChart_3"></canvas>';
    html += '</div>';
    html += '<div class="col-md-1"></div>';
    html += '<div class="col-md-5 alt_fija" id="col_4">';
    html += '<canvas id="myChart_4"></canvas>';
    html += '</div>';
    html += '<div class="col-md-1"></div>';
    html += '</div>';

    html += '<br>';
    html += '<br>';

    html += '<div class="row" id="row_3">';    
    html += '<div class="col-md-5 alt_fija" id="col_5">';
    html += '<canvas id="myChart_5"></canvas>';
    html += '</div>';
    html += '<div class="col-md-1"></div>';
    html += '<div class="col-md-5 alt_fija" id="col_6">';
    html += '<canvas id="myChart_6"></canvas>';
    html += '</div>';
    html += '<div class="col-md-1"></div>';
    html += '</div>';

    html += '<br>';
    html += '<br>';

    html += '<div class="row" id="row_4">';    
    html += '<div class="col-md-5 alt_fija" id="col_7">';
    html += '<canvas id="myChart_7"></canvas>';
    html += '</div>';
    html += '<div class="col-md-1"></div>';
    html += '<div class="col-md-5 alt_fija" id="col_8">';
    html += '<canvas id="myChart_8"></canvas>';
    html += '</div>';
    html += '<div class="col-md-1"></div>';
    html += '</div>';

    $('#cont_graf').append(html);
  }
  else
  {
    html  = '<div class="row" id="row_1">';
    html += '<div class="col-md-6" id="col_1">';
    html += '<canvas id="myChart_1" width="300" height="300"></canvas>';
    html += '</div>';
    html += '<div class="col-md-6" id="col_2">';
    html += '<canvas id="myChart_2" width="300" height="300"></canvas>';
    html += '</div>';
    html += '</div>';

    html += '<br>';
    html += '<br>';

    html += '<div class="row" id="row_2">';    
    html += '<div class="col-md-5 alt_fija" id="col_3">';
    html += '<canvas id="myChart_3"></canvas>';
    html += '</div>';
    html += '<div class="col-md-1"></div>';
    html += '<div class="col-md-5 alt_fija" id="col_4">';
    html += '<canvas id="myChart_4"></canvas>';
    html += '</div>';
    html += '<div class="col-md-1"></div>';
    html += '</div>';

    $('#cont_graf').append(html);
  }          

  document.getElementById("btnfilter").click();   

});

//*****************************************************************************
//
//*****************************************************************************
function mostrar_graficas(adesa_prd_arr_1, adesa_cant_arr_1, aai_prd_arr_1, aai_cant_arr_1, adesa_vend_arr_2,
                          adesa_vent_arr_2, aai_vend_arr_2, aai_vent_arr_2, vend_arr_3, adesa_cobr_arr_3, aai_cobr_arr_3,
                          adesa_fech_arr_4, adesa_cobr_arr_4, aai_fech_arr_5, aai_cobr_arr_5) {

  if (myChart_1) { myChart_1.destroy(); }
  if (myChart_2) { myChart_2.destroy(); }
  if (myChart_3) { myChart_3.destroy(); }
  if (myChart_4) { myChart_4.destroy(); }
  if (myChart_5) { myChart_5.destroy(); }
  if (myChart_6) { myChart_6.destroy(); }
  if (myChart_7) { myChart_7.destroy(); }
  if (myChart_8) { myChart_8.destroy(); }

  //=============================================================================
  // PERMISO GRAFICAS ADESA Y AAI
  //=============================================================================
  if( (document.forms["form1"].elements["cobro_adesa"].value == "1") && 
      (document.forms["form1"].elements["cobro_aai"].value == "1") )
  {  
    
    //---------------------------------------------------------------------------
    // VENTAS POR EMPRESA - PRODUCTOS (RANGO DE FECHA) ADESA
    //---------------------------------------------------------------------------
    var ctx_1 = document.getElementById('myChart_1').getContext('2d');
    myChart_1 = new Chart(ctx_1, {
        type: 'doughnut',
        data: {
            labels: adesa_prd_arr_1,
            datasets: [{
                label: 'Pedidos Producto Web',
                data: adesa_cant_arr_1,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Pedidos Producto Web (ADESA)'
                }
            }
        }
    });

    //---------------------------------------------------------------------------
    // VENTAS POR EMPRESA - PRODUCTOS (RANGO DE FECHA) AAI
    //---------------------------------------------------------------------------
    var ctx_2 = document.getElementById('myChart_2').getContext('2d');
    myChart_2 = new Chart(ctx_2, {
        type: 'doughnut',
        data: {
            labels: aai_prd_arr_1,
            datasets: [{
                label: 'Pedidos Producto Web',
                data: aai_cant_arr_1,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgb(85, 163, 11, 0.7)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgb(85, 163, 11, 0.7)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Pedidos Producto Web (AAI)'
                }
            }
        }
    });

    //---------------------------------------------------------------------------
    // VENDEDOR CON MAS VENTAS POR EMPRESA (RANGO DE FECHA) ADESA
    //---------------------------------------------------------------------------
    var ctx_3 = document.getElementById('myChart_3').getContext('2d');
    myChart_3 = new Chart(ctx_3, {
    type: 'bar',
    data: {
        labels: adesa_vend_arr_2,
        datasets: [{
            label: 'Total Pedidos Web (BTO)',
            data: adesa_vent_arr_2,
            backgroundColor: [
                'rgba(54, 162, 235, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(255, 99, 132, 0.5)',
                'rgb(85, 163, 11, 0.7)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 99, 132, 1)',
                'rgb(85, 163, 11, 0.7)'
            ],
            borderWidth: 1
        }]
    },
    options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Pedidos Web por Vendedores (ADESA)'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    //---------------------------------------------------------------------------
    // VENDEDOR CON MAS VENTAS POR EMPRESA (RANGO DE FECHA) AAI
    //---------------------------------------------------------------------------
    var ctx_4 = document.getElementById('myChart_4').getContext('2d');
    myChart_4 = new Chart(ctx_4, {
    type: 'bar',
    data: {
        labels: aai_vend_arr_2,
        datasets: [{
            label: 'Total Pedidos Web (FDO)',
            data: aai_vent_arr_2,
            backgroundColor: [
                'rgba(54, 162, 235, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(255, 99, 132, 0.5)',
                'rgb(85, 163, 11, 0.7)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 99, 132, 1)',
                'rgb(85, 163, 11, 0.7)'
            ],
            borderWidth: 1
        }]
    },
    options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Pedidos Web por Vendedores (AAI)'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    //---------------------------------------------------------------------------
    // VENDEDOR CON MAS COBRANZAS POR EMPRESA (RANGO DE FECHA) ADESA
    //---------------------------------------------------------------------------
    var ctx_5 = document.getElementById('myChart_5').getContext('2d');
    myChart_5 = new Chart(ctx_5, {
    type: 'bar',
    data: {
        labels: vend_arr_3,
        datasets: [{
            label: 'Total Cobranzas Web ($)',
            data: adesa_cobr_arr_3,
            backgroundColor: [
                'rgba(54, 162, 235, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(255, 99, 132, 0.5)',
                'rgb(85, 163, 11, 0.7)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 99, 132, 1)',
                'rgb(85, 163, 11, 0.7)'
            ],
            borderWidth: 1,
            fill: false
        }]
    },
    options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Cobranzas Web por Vendedores (ADESA)'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    //---------------------------------------------------------------------------
    // VENDEDOR CON MAS COBRANZAS POR EMPRESA (RANGO DE FECHA) AAI
    //---------------------------------------------------------------------------
    var ctx_6 = document.getElementById('myChart_6').getContext('2d');
    myChart_6 = new Chart(ctx_6, {
    type: 'bar',
    data: {
        labels: vend_arr_3,
        datasets: [{
            label: 'Total Cobranzas Web ($)',
            data: aai_cobr_arr_3,
            backgroundColor: [
                'rgba(54, 162, 235, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(255, 99, 132, 0.5)',
                'rgb(85, 163, 11, 0.7)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 99, 132, 1)',
                'rgb(85, 163, 11, 0.7)'
            ],
            borderWidth: 1,
            fill: false
        }]
    },
    options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Cobranzas Web por Vendedores (AAI)'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    
    //---------------------------------------------------------------------------
    // COBRANZAS ADESA (RANGO DE FECHA)
    //---------------------------------------------------------------------------
    var ctx_7 = document.getElementById('myChart_7').getContext('2d');
    myChart_7 = new Chart(ctx_7, {
    type: 'line',
    data: {
        labels: adesa_fech_arr_4,
        datasets: [{
            label: 'Total Cobranzas Web ($)',
            data: adesa_cobr_arr_4,
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 99, 132, 1)',
                'rgb(85, 163, 11, 0.7)'
            ],
            borderWidth: 2,
            fill: false
        }]
    },
    options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Cobranzas Web (ADESA)'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    //---------------------------------------------------------------------------
    // COBRANZAS AAI (RANGO DE FECHA)
    //---------------------------------------------------------------------------
    var ctx_8 = document.getElementById('myChart_8').getContext('2d');
    myChart_8 = new Chart(ctx_8, {
    type: 'line',
    data: {
        labels: aai_fech_arr_5,
        datasets: [{
            label: 'Total Cobranzas Web ($)',
            data: aai_cobr_arr_5,
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 99, 132, 1)',
                'rgb(85, 163, 11, 0.7)'
            ],
            borderWidth: 2,
            fill: false
        }]
    },
    options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Cobranzas Web (AAI)'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
  } 
  
  //=============================================================================
  // PERMISO SOLO GRAFICAS ADESA
  //=============================================================================
  if( (document.forms["form1"].elements["cobro_adesa"].value == "1") && 
      (document.forms["form1"].elements["cobro_aai"].value != "1") )
  {
    var ctx_1 = document.getElementById('myChart_1').getContext('2d');
    myChart_1 = new Chart(ctx_1, {
        type: 'doughnut',
        data: {
            labels: adesa_prd_arr_1,
            datasets: [{
                label: 'Ventas Producto',
                data: adesa_cant_arr_1,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Ventas Productos (ADESA)'
                }
            }
        }
    });

    var ctx_2 = document.getElementById('myChart_2').getContext('2d');
    myChart_2 = new Chart(ctx_2, {
    type: 'bar',
    data: {
        labels: adesa_vend_arr_2,
        datasets: [{
            label: 'Total Ventas (BTO)',
            data: adesa_vent_arr_2,
            backgroundColor: [
                'rgba(54, 162, 235, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(255, 99, 132, 0.5)',
                'rgb(85, 163, 11, 0.7)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 99, 132, 1)',
                'rgb(85, 163, 11, 0.7)'
            ],
            borderWidth: 1
        }]
    },
    options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Ventas por Vendedores (ADESA)'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    var ctx_3 = document.getElementById('myChart_3').getContext('2d');
    myChart_3 = new Chart(ctx_3, {
    type: 'bar',
    data: {
        labels: vend_arr_3,
        datasets: [{
            label: 'Total Cobranzas ($)',
            data: adesa_cobr_arr_3,
            backgroundColor: [
                'rgba(54, 162, 235, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(255, 99, 132, 0.5)',
                'rgb(85, 163, 11, 0.7)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 99, 132, 1)',
                'rgb(85, 163, 11, 0.7)'
            ],
            borderWidth: 1,
            fill: false
        }]
    },
    options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Cobranzas por Vendedores (ADESA)'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    var ctx_4 = document.getElementById('myChart_4').getContext('2d');
    myChart_4 = new Chart(ctx_4, {
    type: 'line',
    data: {
        labels: adesa_fech_arr_4,
        datasets: [{
            label: 'Total Cobranzas ($)',
            data: adesa_cobr_arr_4,
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 99, 132, 1)',
                'rgb(85, 163, 11, 0.7)'
            ],
            borderWidth: 2,
            fill: false
        }]
    },
    options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    position: 'bottom',
                    text: 'Cobranzas (ADESA)'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
  }

  //=============================================================================
  // PERMISO SOLO GRAFICAS AAI
  //=============================================================================
  if( (document.forms["form1"].elements["cobro_aai"].value == "1") && 
      (document.forms["form1"].elements["cobro_adesa"].value != "1") )
  {
    var ctx_1 = document.getElementById('myChart_1').getContext('2d');
    myChart_1 = new Chart(ctx_1, {
        type: 'doughnut',
        data: {
            labels: aai_prd_arr_1,
            datasets: [{
                label: 'Ventas Producto',
                data: aai_cant_arr_1,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgb(85, 163, 11, 0.7)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgb(85, 163, 11, 0.7)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Ventas Productos (AAI)'
                }
            }
        }
    });

    var ctx_2 = document.getElementById('myChart_2').getContext('2d');
    myChart_2 = new Chart(ctx_2, {
    type: 'bar',
    data: {
        labels: aai_vend_arr_2,
        datasets: [{
            label: 'Total Ventas (FDO)',
            data: aai_vent_arr_2,
            backgroundColor: [
                'rgba(54, 162, 235, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(255, 99, 132, 0.5)',
                'rgb(85, 163, 11, 0.7)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 99, 132, 1)',
                'rgb(85, 163, 11, 0.7)'
            ],
            borderWidth: 1
        }]
    },
    options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Ventas por Vendedores (AAI)'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    var ctx_3 = document.getElementById('myChart_3').getContext('2d');
    myChart_3 = new Chart(ctx_3, {
    type: 'bar',
    data: {
        labels: vend_arr_3,
        datasets: [{
            label: 'Total Cobranzas ($)',
            data: aai_cobr_arr_3,
            backgroundColor: [
                'rgba(54, 162, 235, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(255, 99, 132, 0.5)',
                'rgb(85, 163, 11, 0.7)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 99, 132, 1)',
                'rgb(85, 163, 11, 0.7)'
            ],
            borderWidth: 1,
            fill: false
        }]
    },
    options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Cobranzas por Vendedores (AAI)'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    
    var ctx_4 = document.getElementById('myChart_4').getContext('2d');
    myChart_4 = new Chart(ctx_4, {
    type: 'line',
    data: {
        labels: aai_fech_arr_5,
        datasets: [{
            label: 'Total Cobranzas ($)',
            data: aai_cobr_arr_5,
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 99, 132, 1)',
                'rgb(85, 163, 11, 0.7)'
            ],
            borderWidth: 2,
            fill: false
        }]
    },
    options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Cobranzas (AAI)'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
  }
}

//*****************************************************************************
//
//*****************************************************************************
function fn_filter() {

  if(validar_form() == true) {

    var txtdesde = document.forms["form1"].elements["txtdesde"].value;
    var txthasta = document.forms["form1"].elements["txthasta"].value;    

    $.ajax({
      type: "POST",
      url: baseurl + "GraficaController/datos_grafica_fecha",
      data: {txtdesde : txtdesde, txthasta : txthasta},
      success: function (respuesta) {
        
        var res = (typeof respuesta === 'object') ? respuesta : JSON.parse(respuesta);

        if (res.resultado == "1") {

          var adesa_prd_arr_1  = [];
          var adesa_cant_arr_1 = [];

          var aai_prd_arr_1    = [];
          var aai_cant_arr_1   = [];

          var adesa_vend_arr_2 = [];
          var adesa_vent_arr_2 = [];

          var aai_vend_arr_2   = [];
          var aai_vent_arr_2   = [];

          var vend_arr_3       = [];
          var adesa_cobr_arr_3 = [];
          var aai_cobr_arr_3   = [];

          var adesa_fech_arr_4 = [];
          var adesa_cobr_arr_4 = [];

          var aai_fech_arr_5   = [];
          var aai_cobr_arr_5   = [];

          for(i = 0; i < res.Model_arr_grafica_1.length; i++)
          {
            if(res.Model_arr_grafica_1[i]["co_empresa"] == "ADESA")
            {
              adesa_prd_arr_1.push(res.Model_arr_grafica_1[i]["nb_corto"]);
              adesa_cant_arr_1.push(res.Model_arr_grafica_1[i]["ca_producto"]);
            }

            if(res.Model_arr_grafica_1[i]["co_empresa"] == "AA1")
            {
              aai_prd_arr_1.push(res.Model_arr_grafica_1[i]["nb_corto"]);
              aai_cant_arr_1.push(res.Model_arr_grafica_1[i]["ca_producto"]);
            }  
          }

          for(i = 0; i < res.Model_arr_grafica_2.length; i++)
          {
            if(res.Model_arr_grafica_2[i]["co_empresa"] == "ADESA")
            {
              adesa_vend_arr_2.push(res.Model_arr_grafica_2[i]["nb_vendedor"]);
              adesa_vent_arr_2.push(res.Model_arr_grafica_2[i]["ca_producto"]);
            }

            if(res.Model_arr_grafica_2[i]["co_empresa"] == "AA1")
            {
              aai_vend_arr_2.push(res.Model_arr_grafica_2[i]["nb_vendedor"]);
              aai_vent_arr_2.push(res.Model_arr_grafica_2[i]["ca_producto"]);
            }   
          }

          for(i = 0; i < res.Model_arr_grafica_3.length; i++)
          {
            vend_arr_3.push(res.Model_arr_grafica_3[i]["nb_vendedor"]);
            adesa_cobr_arr_3.push(res.Model_arr_grafica_3[i]["monto_cobrado_adesa"]);
            aai_cobr_arr_3.push(res.Model_arr_grafica_3[i]["monto_cobrado_aai"]);
          }

          for(i = 0; i < res.Model_arr_grafica_4.length; i++)
          {
            adesa_fech_arr_4.push(res.Model_arr_grafica_4[i]["fe_emision"]);
            adesa_cobr_arr_4.push(res.Model_arr_grafica_4[i]["monto_cobrado_adesa"]);
          }

          for(i = 0; i < res.Model_arr_grafica_5.length; i++)
          {            
            aai_fech_arr_5.push(res.Model_arr_grafica_5[i]["fe_emision"]);
            aai_cobr_arr_5.push(res.Model_arr_grafica_5[i]["monto_cobrado_aai"]);
          }

          mostrar_graficas(adesa_prd_arr_1, adesa_cant_arr_1, aai_prd_arr_1, aai_cant_arr_1, adesa_vend_arr_2,
                           adesa_vent_arr_2, aai_vend_arr_2, aai_vent_arr_2, vend_arr_3, adesa_cobr_arr_3, aai_cobr_arr_3,
                           adesa_fech_arr_4, adesa_cobr_arr_4, aai_fech_arr_5, aai_cobr_arr_5);
         
        }
        else if (res.resultado == "0") {
          alert("No retornaron datos para graficar");
        }
        else if (res.resultado == "ERROR") {
          alert(res.msn);
          window.location.href = baseurl + "GraficaController/grafica/";
        }      
        else {
          alert("No retornaron datos esperados");
          window.location.href = baseurl + "GraficaController/grafica/";
        }   
      }
    });
  }
}

//*****************************************************************************
//
//*****************************************************************************
function validar_form() { 

  // VALIDACION DE FECHA DESDE
  if (document.forms["form1"].elements["txtdesde"].value.length < 1) {
    alert('Indique la fecha desde');
    document.forms["form1"].elements["txtdesde"].focus();
    return (false);
  }

  // VALIDACION DE FECHA HASTA
  if (document.forms["form1"].elements["txthasta"].value.length < 1) {
    alert('Indique la fecha hasta');
    document.forms["form1"].elements["txthasta"].focus();
    return (false);
  }

  else {
      return (true);
  }
}