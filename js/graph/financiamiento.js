function getFinanciamientoAnual(anio) {
    peticionDatosGraficoFinanciamientoAnual(anio, "");
}
function getPartidoPolitico() {
    var partido = $("#opcionPartidoPolitico").val();
    peticionDatosGraficoFinanciamientoAnual(0, partido);
}
function peticionDatosGraficoFinanciamientoAnual(anio, partido) {
    var parametro = "";
    var existe = false;
    if (anio > 0) {
        existe = true;
        parametro = "anio=" + anio;
    }
    if (partido !== "") {
        if (existe) {
            parametro = parametro + "&";
        }
        existe = true;
        parametro = parametro + "partido=" + partido;
    }
    console.log(parametro);
    $.ajax({
        beforeSend: function (xhrObj) {
            xhrObj.setRequestHeader("Content-Type", "application/json");
            xhrObj.setRequestHeader("Accept", "application/json");
        },
        type: "GET",
        dataType: "json",
        url: "http://23.21.205.77:8080/ine-services/HistoricoFinanciero/general?" + parametro,
        success: function (data) {
            if (anio > 0) {
                crearGraficoFinanciamientoAnual(data);
            }
            if (partido !== "") {
                crearGraficoHistoricoRecursosPartido(data);
            }
        }
    });
}
function crearGraficoFinanciamientoAnual(data) {

    var listaPartidos = [];
    var listaActividadesEsp = [];
    var listaActividadesOrd = [];
    var listaGastoCampania = [];
    var listaTotal = [];
    $.each(data, function (index, value) {
        listaPartidos.push(value[1]);
        listaActividadesEsp.push(value[2]);
        listaActividadesOrd.push(value[3]);
        listaGastoCampania.push(value[4]);
        listaTotal.push(value[5]);

    });
    Highcharts.chart('financiamientoTop', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Financiamiento Público'
        },
        xAxis: {
            categories: listaPartidos
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Financiemiento'
            },
            stackLabels: {
                enabled: true,
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                }
            }
        },
        legend: {
            align: 'right',
            x: -30,
            verticalAlign: 'top',
            y: 25,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
            borderColor: '#CCC',
            borderWidth: 1,
            shadow: false
        },
        tooltip: {
            headerFormat: '<b>{point.x}</b><br/>',
            pointFormat: '{series.name}: {point.y}<br/>Total: ${point.stackTotal}'
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                }
            }
        },
        series: [{
                name: 'Total Actividades Ordinarias Permanentes',
                data: listaActividadesOrd
            }, {
                name: 'Total Gastos de Campaña',
                data: listaGastoCampania
            }, {
                name: 'Total Actividades Específicas',
                data: listaActividadesEsp
            }, {
                name: 'Gran Total Anual',
                data: listaTotal
            }]
    });
}

function crearGraficoHistoricoRecursosPartido(data) {
    var listaAnios = [];
    var listaActividadesEsp = [];
    var listaActividadesOrd = [];
    var listaGastoCampania = [];
    var listaTotal = [];
    console.log(data);
    $.each(data, function (index, value) {
        listaAnios.push(value[0]);
        listaActividadesEsp.push(value[2]);
        listaActividadesOrd.push(value[3]);
        listaGastoCampania.push(value[4]);
        listaTotal.push(value[5]);

    });

    Highcharts.chart('financiamientoHistorico', {
        chart: {
            type: 'spline'
        },
        title: {
            text: 'HISTÓRICO DE RECURSOS PÚBLICOS'
        },
        subtitle: {
            text: 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget'
        },
        xAxis: {
            categories: listaAnios,
            type: 'datetime',
            dateTimeLabelFormats: {// don't display the dummy year
                year: '%Y'
            },
            title: {
                text: 'Año'
            }
        },
        yAxis: {
            title: {
                text: 'Financiamiento ($)'
            },
            min: 0
        },
        tooltip: {
            headerFormat: '<b>{series.name}</b><br>',
            pointFormat: '${point.y:.2f} '
        },
        plotOptions: {
            spline: {
                marker: {
                    enabled: true
                }
            }
        },
        series: [{
                name: 'Actividades Ordinarias',
                data: listaActividadesOrd
            }, {
                name: 'Gastos de camapaña',
                data: listaGastoCampania
            }, {
                name: 'Actividades Especificas',
                data: listaActividadesEsp
            }, {
                name: 'Gran Total',
                data: listaTotal
            }]
    });
}

$(document).ready(function () {
    peticionDatosGraficoFinanciamientoAnual(1997, "");
    peticionDatosGraficoFinanciamientoAnual(0, "Partido Cardenista");
});

