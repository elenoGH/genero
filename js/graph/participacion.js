$(document).ready(function () {
    $.ajax({
        beforeSend: function (xhrObj) {
            xhrObj.setRequestHeader("Content-Type", "application/json");
            xhrObj.setRequestHeader("Accept", "application/json");
        },
        type: "GET",
        dataType: "json",
        url: "http://23.21.205.77:8080/ine-services/DatosElectorales/Generales/listaNominal/abstencion/nulo/participacion",
        success: function (data) {
            crearGraficoHistoricoParticipacion(data);
        }
    });


    $.ajax({
        beforeSend: function (xhrObj) {
            xhrObj.setRequestHeader("Content-Type", "application/json");
            xhrObj.setRequestHeader("Accept", "application/json");
        },
        type: "GET",
        dataType: "json",
        url: "http://23.21.205.77:8080/ine-services/DatosElectorales/Generales/listaNominalParticipacion",
        success: function (data) {
            crearGraficoCantidadVotos(data);
        }
    });


    function crearGraficoHistoricoParticipacion(data) {

        var anios = [];
        var listaNominal = [];
        var abstencion = [];
        var nulo = [];
        var participacion = [];

        $.each(data, function (index, value) {
            anios.push(value[0]);
            listaNominal.push(value[1]);
            abstencion.push(value[2]);
            nulo.push(value[3]);
            participacion.push(value[4]);
        });

        Highcharts.chart('presidencialesHistorico', {
            chart: {
                type: 'line'
            },
            title: {
                text: 'Elecciones Presidenciales'
            },
            subtitle: {
                text: 'Histórico de Particpación'
            },
            xAxis: {
                categories: anios
            },
            yAxis: {
                title: {
                    text: 'Cantidad de Votos'
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series: [{
                    name: 'Lista Nominal',
                    data: listaNominal
                }, {
                    name: 'Participación',
                    data: participacion
                }, {
                    name: 'Votos Nulos',
                    data: nulo
                }, {
                    name: 'Abstencion',
                    data: abstencion
                }]
        });

    }
    ;



    function crearGraficoCantidadVotos(dataService) {

        var data = {
            'Lista nominal': {
                'Participación': {
                    'Votos nulos': '0',
                    'Votos': dataService[0][0]
                },
                'Abstenciones': {
                    'Abstenciones': (dataService[0][1] - dataService[0][0])
                },
            }
        }
        ,
                points = [],
                regionP,
                regionVal,
                regionI = 0,
                countryP,
                countryI,
                causeP,
                causeI,
                region,
                country,
                cause,
                causeName = {
                    'Votos nulos': 'Votos nulos',
                    'Votos': 'Votos',
                    'Abstenciones': 'Abstenciones',
                };

        for (region in data) {
            if (data.hasOwnProperty(region)) {
                regionVal = 0;
                regionP = {
                    id: 'id_' + regionI,
                    name: region,
                    color: Highcharts.getOptions().colors[regionI]
                };
                countryI = 0;
                for (country in data[region]) {
                    if (data[region].hasOwnProperty(country)) {
                        countryP = {
                            id: regionP.id + '_' + countryI,
                            name: country,
                            parent: regionP.id
                        };
                        points.push(countryP);
                        causeI = 0;
                        for (cause in data[region][country]) {
                            if (data[region][country].hasOwnProperty(cause)) {
                                causeP = {
                                    id: countryP.id + '_' + causeI,
                                    name: causeName[cause],
                                    parent: countryP.id,
                                    value: Math.round(+data[region][country][cause])
                                };
                                regionVal += causeP.value;
                                points.push(causeP);
                                causeI = causeI + 1;
                            }
                        }
                        countryI = countryI + 1;
                    }
                }
                regionP.value = Math.round(regionVal / countryI);
                points.push(regionP);
                regionI = regionI + 1;
            }
        }


        Highcharts.chart('cantidadVotosPresidenciales', {
            series: [{
                    type: 'treemap',
                    layoutAlgorithm: 'squarified',
                    allowDrillToNode: true,
                    animationLimit: 1000,
                    dataLabels: {
                        enabled: false
                    },
                    levelIsConstant: false,
                    levels: [{
                            level: 1,
                            dataLabels: {
                                enabled: true
                            },
                            borderWidth: 3
                        }],
                    data: points
                }],
            subtitle: {
                text: 'Cantidad de Votos'
            },
            title: {
                text: 'Elecciones Presidenciales'
            }
        });
    }
    ;
    $.ajax({
        beforeSend: function (xhrObj) {
            xhrObj.setRequestHeader("Content-Type", "application/json");
            xhrObj.setRequestHeader("Accept", "application/json");
        },
        type: "GET",
        dataType: "json",
        url: "http://23.21.205.77:8080/ine-services/DatosElectorales/Generales/mayorPorcentajeEstado",
        success: function (data) {
            crearGraficoMayorParticipacion(data);
        }
    });

    $.ajax({
        beforeSend: function (xhrObj) {
            xhrObj.setRequestHeader("Content-Type", "application/json");
            xhrObj.setRequestHeader("Accept", "application/json");
        },
        type: "GET",
        dataType: "json",
        url: "http://23.21.205.77:8080/ine-services/DatosElectorales/Generales/menorPorcentajeEstado",
        success: function (data) {
            crearGraficoMenorParticipacion(data);
        }
    });
});

function crearGraficoMayorParticipacion(data) {
    var mayorParticipacion = [];
    $.each(data, function (index, value) {
        var item = {};
        if (index === 0) {
            item = {x: 1, y: 1, z: value[0], name: value[1], country: value[1], color: 'rgb(100,179,60)'};
        }
        if (index === 1) {
            item = {x: 2, y: 1, z: value[0], name: value[1], country: value[1], color: 'rgb(255,204,0)'};
        }
        if (index === 2) {
            item = {x: 3, y: 1, z: value[0], name: value[1], country: value[1], color: 'rgb(245,102,0)'};
        }
        mayorParticipacion.push(item);
    });
    Highcharts.chart('cantidadVotosEstado', {
        chart: {
            type: 'bubble',
            plotBorderWidth: 1,
            zoomType: 'xy'
        },
        legend: {
            enabled: false
        },
        title: {
            text: 'Participación por estado'
        },
        subtitle: {
            text: ' Los 3 Estados con Mayor Participación'
        },
        xAxis: {
            lineWidth: 0,
            minorGridLineWidth: 0,
            lineColor: 'transparent',
            labels: {
                enabled: false
            }
        },
        yAxis: {
            startOnTick: false,
            endOnTick: false,
            title: {
                text: ' '
            },
            categories: [
                '',
                '',
                '',
                ''
            ]
        },
        tooltip: {
            useHTML: true,
            headerFormat: '<table>',
            pointFormat: '<tr><th colspan="2"><h3>{point.country}</h3></th></tr>' +
                    '<tr><th>Porcentaje de Participación</th><td>{point.z}%</td></tr>',
            footerFormat: '</table>',
            followPointer: true
        },
        plotOptions: {
            series: {
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }
        },
        series: [{
                data: mayorParticipacion
            }]

    });
}


function crearGraficoMenorParticipacion(data) {
    var menorParticipacion = [];
    $.each(data, function (index, value) {
        var item = {};
        if (index === 0) {
            item = {x: 1.4, y: 1, z: value[0], name: value[1], country: value[1], color: 'rgb(100,179,60)'};
        }
        if (index === 1) {
            item = {x: 1.2, y: 1, z: value[0], name: value[1], country: value[1], color: 'rgb(255,204,0)'};
        }
        if (index === 2) {
            item = {x: 1, y: 1, z: value[0], name: value[1], country: value[1], color: 'rgb(245,102,0)'};
        }
        menorParticipacion.push(item);
    });

    Highcharts.chart('cantidadVotosEstadoMenor', {
        chart: {
            type: 'bubble',
            plotBorderWidth: 1,
            zoomType: 'xy'
        },
        legend: {
            enabled: false
        },
        title: {
            text: 'Participación por estado'
        },
        subtitle: {
            text: ' Los 3 Estados con Menor Participación'
        },
        xAxis: {
            lineWidth: 0,
            minorGridLineWidth: 0,
            lineColor: 'transparent',
            labels: {
                enabled: false
            }
        },
        yAxis: {
            startOnTick: false,
            endOnTick: false,
            title: {
                text: ' '
            },
            categories: [
                '',
                '',
                '',
                ''
            ]
        },
        tooltip: {
            useHTML: true,
            headerFormat: '<table>',
            pointFormat: '<tr><th colspan="2"><h3>{point.country}</h3></th></tr>' +
                    '<tr><th>Porcentaje de Participación</th><td>{point.z}%</td></tr>',
            footerFormat: '</table>',
            followPointer: true
        },
        plotOptions: {
            series: {
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }
        },
        series: [{
                data: menorParticipacion
            }]

    });
}