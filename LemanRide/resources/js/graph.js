/**
 * ETML
 * Author : João Ferreira
 * Date : 01.06.2023
 * Description :
 */


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

window.addEventListener('resize', function() {
    chart.resize();
});

var chart = echarts.init(document.getElementById('graph'));


var option = {
    legend : {
        data: ['Force du vent', 'Force de rafale', 'Force moyenne'],
        left: 'center',
        orient: 'vertical'
    },
    xAxis: {
        type: 'category',
        data: dates
    },
    yAxis: {
        type: 'value'
    },
    grid: {
        top: '20%'
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
