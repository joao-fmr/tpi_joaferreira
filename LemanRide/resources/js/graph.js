allData.sort((a, b) => new Date(a.valStoredDate) - new Date(b.valStoredDate));

var dates = [];
var windStrengths = [];
var gustStrengths = [];
var averageStrengths = [];

for (var key in allData) {
    dates.push(allData[key].valStoredDate);
    windStrengths.push(allData[key].windStrength);
    gustStrengths.push(allData[key].gustStrength);
    averageStrengths.push(allData[key].averageStrength);
}


var chart = echarts.init(document.getElementById('graph'));


var option = {
    title : {
        text: 'Évolution de la force du vent depuis les dernières 96 heures'
    },
    legend : {
        data: ['Force du vent', 'Force de rafale', 'Force moyenne']
    },
    xAxis: {
        type: 'category',
        data: dates
    },
    yAxis: {
        type: 'value'
    },
    tooltip: {
        trigger: 'axis',
        axisPointer: {
            type: 'cross'
        }
    },
    dataZoom: [{
        type: 'inside'
    }, {
        type: 'slider'
    }],
    series: [{
        name: 'Force du vent',
        data: windStrengths,
        type: 'line'
    }, {
        name: 'Force de rafale',
        data: gustStrengths,
        type: 'line'
    }, {
        name: 'Force moyenne',
        data: averageStrengths,
        type: 'line'
    }]
};


chart.setOption(option);
