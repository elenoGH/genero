$(document).ready(function(){
    var anio = new Date().getFullYear();
    var partido = [];
    $.ajax({ 
        beforeSend: function(xhrObj){
                xhrObj.setRequestHeader("Content-Type","application/json");
                xhrObj.setRequestHeader("Accept","application/json");
        },
        type: "GET",
        dataType: "json",
        url: "http://23.21.205.77:8080/ine-services/HistoricoFinanciero/general",
        success: function(data){ 
            crearGrafico(data);
        }
    });

    // Create the chart
    function crearGrafico(data){
        var listaPartidos = data;
        var dataList = [];
        $.each(listaPartidos, function( index, value ) {
            item = {}
            item ["name"] = value[1];
            item ["y"] = value[2];
            item["drilldown"] = null;
             dataList.push(item);
        });
        
        Highcharts.chart('indexFinanciamiento', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'DINERO PARA PARTIDOS POL\u00cdTICOS ' + anio
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                type: 'category'
            },
        yAxis: {
            title: {
                text: 'Dinero'
        }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                        format: '${point.y:,.1f}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>${point.y:,.1f}</b><br/>'
        },
        series: [{
            name: 'Resultado',
            colorByPoint: true,
            data: dataList
        }],
        drilldown: {
        }  
        });
    }
	
	

});




$(document).ready(function(){
    var anio = new Date().getFullYear();
    var partido = [];
    $.ajax({ 
        beforeSend: function(xhrObj){
                xhrObj.setRequestHeader("Content-Type","application/json");
                xhrObj.setRequestHeader("Accept","application/json");
        },
        type: "GET",
        dataType: "json",
        url: "http://23.21.205.77:8080/ine-services/HistoricoVotos/filtro",
        success: function(data){ 
            console.log(data);
            crearGrafico(data);
        }
    });

    // Create the chart
    function crearGrafico(data){
        var listaPartidos = data;
        var listaAnio = [];
        var listaVotos = [];
        $.each(listaPartidos, function( index, value ) {
            var anio = value[0];
            var votos = value[4];
            listaAnio.push(anio);
            listaVotos.push(votos);
        });
        
        Highcharts.chart('indexParticipacion', {
            colors: ['#2b908f', '#90ee7e', '#f45b5b', '#7798BF', '#aaeeee', '#ff0066', '#eeaaee',
      '#55BF3B', '#DF5353', '#7798BF', '#aaeeee'],
    chart: {
        backgroundColor: {
         linearGradient: { x1: 0, y1: 0, x2: 1, y2: 1 },
         stops: [
            [0, '#2a2a2b'],
            [1, '#3e3e40']
         ]
      },
      style: {
         fontFamily: '\'Unica One\', sans-serif'
      },
      plotBorderColor: '#606063',
        type: 'spline'
    },
    title: {
        text: 'HIST\u00D3RICO DE VOTOS',
        style: {
         color: '#E0E0E3',
         textTransform: 'uppercase',
         fontSize: '20px'
      }
    },
    subtitle: {
        text: '',
        style: {
         color: '#E0E0E3',
         textTransform: 'uppercase'
      }
    },
    xAxis: {
        gridLineColor: '#707073',
      labels: {
         style: {
            color: '#E0E0E3'
         }
      },
      lineColor: '#707073',
      minorGridLineColor: '#505053',
      tickColor: '#707073',
      title: {
         style: {
            color: '#A0A0A3'

         }
      },
        categories: listaAnio
    },
    yAxis: {
        gridLineColor: '#707073',
      labels: {
         style: {
            color: '#E0E0E3'
         }
      },
      lineColor: '#707073',
      minorGridLineColor: '#505053',
      tickColor: '#707073',
      tickWidth: 1,
      title: {
         style: {
            color: '#A0A0A3'
         }
      },
        title: {
            text: 'Cantidad Votos'
        },
        labels: {
            formatter: function () {
                return this.value;
            }
        }
    },
    tooltip: {
        backgroundColor: 'rgba(0, 0, 0, 0.85)',
      style: {
         color: '#F0F0F0'
      },
        crosshairs: true,
        shared: true
    },
    plotOptions: {
        series: {
         dataLabels: {
            color: '#B0B0B3'
         },
         marker: {
            lineColor: '#333'
         }
      },
      boxplot: {
         fillColor: '#505053'
      },
      candlestick: {
         lineColor: 'white'
      },
      errorbar: {
         color: 'white'
      },
        spline: {
            marker: {
                radius: 4,
                lineColor: '#000000',
                lineWidth: 1
            }
        }
    },
    series: [{
        name: 'Votos',
        marker: {
            symbol: 'square'
        },
        data: listaVotos
    }]
});
    }
});