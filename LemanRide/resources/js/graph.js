/**
 * ETML
 * Author : João Ferreira
 * Date : 01.06.2023
 * Description : Graph script that uses the Echarts Apache library
 * Creates a graph to display the evolution of wind strength over given hours
 */

// sort the data by the stored date on the database
graphData.sort((a, b) => new Date(a.valStoredDate) - new Date(b.valStoredDate));

// arrays to store the data for the graph
var dates = [];
var windStrengths = [];
var gustStrengths = [];
var averageStrengths = [];

// loop through the data for the graph and extract the values for each graph series 
for (var key in graphData) {
    // format the date time
    var date = new Date(graphData[key].valStoredDate);
    var formattedDate = date.toLocaleDateString('fr-FR', 
                                                {day: 'numeric', 
                                                month: 'numeric', 
                                                year: 'numeric', 
                                                hour: 'numeric', 
                                                minute: 'numeric'});
    
    // add the values to the arrays of the series data
    dates.push(formattedDate);
    windStrengths.push(graphData[key].windStrength);
    gustStrengths.push(graphData[key].gustStrength);
    averageStrengths.push(graphData[key].averageStrength);
}

// add an event to be able resize (zoom) the graph
window.addEventListener('resize', function() {
    chart.resize();
});

// start the graph with the element id 'graph'
var chart = echarts.init(document.getElementById('graph'));

// set the graph options
var option = {
    // legends of the graph
    legend : {
        data: ['Force du vent', 'Force de rafale', 'Force moyenne'],
        left: 'center',
        orient: 'vertical'
    },
    // axis X options (horizontal)
    xAxis: {
        type: 'category',
        data: dates
    },
    // axis Y options (vertical)
    yAxis: {
        type: 'value'
    },
    // grid options (inside the graph)
    grid: {
        top: '20%'
    },
    // tooltip options, (hovering data points)
    tooltip: {
        trigger: 'axis',
        axisPointer: {
            // set the axis pointer type
            type: 'cross' 
        }
    },
    // dataZoom options, allows to filter data with a slider and zoom inside the graph
    dataZoom: [{
        type: 'inside'
        }, {
        type: 'slider'
    }],
    // the series on the graph, the lines containing the data
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

// apply the options did before to the graph 
chart.setOption(option);
