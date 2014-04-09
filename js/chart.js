
function showContent() {

    var oTBL = document.getElementById('chartsTable');
    var step=false;
    var charts=[];
    var chart=[];

    for (var x = 0; x < oTBL.rows.length; x++) {
        for (var y = 0; y < oTBL.rows[x].cells.length; y++) {
        if(step){
                charts.push(parseInt(oTBL.rows[x].cells[y].firstChild.data));
                step=false;
            }
        else{
                charts.push(oTBL.rows[x].cells[y].firstChild.data);
                step=true;
            }
        }
    }
    while (charts.length > 0)
        chart.push(charts.splice(0, 2));
return chart;
}

var chartsToShow=showContent();

google.load('visualization', '1.0', {'packages':['corechart']});

google.setOnLoadCallback(drawChart);


function drawChart() {

    // Create the data table.
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Topping');
    data.addColumn('number', 'Slices');
    data.addRows(chartsToShow);

    // Set chart options
    var options = {'title':'Your summery charts',
    'width':600,
    'height':400};

// Instantiate and draw our chart, passing in some options.
var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
chart.draw(data, options);
}
