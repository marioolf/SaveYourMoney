window.docReady(() => {
    createAndAddLineChart();
});

function createAndAddLineChart() {
    // chart data...
    let mesesIntervalo = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
    let datos = [{
        name: 'Comunicaciones',
        data: [100, 200, 300, 150, 235, 254, 345, 293, 392, 124, 102, 134]
    },
    {
        name: 'Ocio',
        data: [50, 30, 20, 15, 23, 25, 34, 29, 39, 12, 10, 13]
    },
    {
        name: 'Alimentación',
        data: [155, 132, 158, 156, 160, 135, 134, 129, 139, 112, 110, 113]
    },
    {
        name: 'Combustible',
        data: [50, 55, 60, 65, 70, 75, 80, 0, 170, 80, 85, 82]
    },
    {
        name: 'Suministros',
        data: [45, 45, 49, 50, 60, 65, 62, 66, 62, 66, 70, 65]
    }];

    // Configure and put the chart in the Html document
    Highcharts.chart('container', {
        title: {
            text: 'Gastos en los últimos doce meses'
        },


        yAxis: {
            title: {
                text: 'Euros'
            }
        },

        xAxis: {
            accessibility: {
                rangeDescription: 'Range: 2010 to 2020'
            },
            categories: mesesIntervalo

        },

        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },

        plotOptions: {
            series: {
                label: {
                    connectorAllowed: false
                }
            }
        },

        series: datos,

        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }

    });
}
