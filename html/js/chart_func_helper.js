//transpose = function(a) {
//
//  // Calculate the width and height of the Array
//  var w = a.length ? a.length : 0,
//    h = a[0] instanceof Array ? a[0].length : 0;
//
//  // In case it is a zero matrix, no transpose routine needed.
//  if(h === 0 || w === 0) { return []; }
//
//  /**
//   * @var {Number} i Counter
//   * @var {Number} j Counter
//   * @var {Array} t Transposed data is stored in this array.
//   */
//  var i, j, t = [];
//
//  // Loop through every item in the outer array (height)
//  for(i=0; i<h; i++) {
//
//    // Insert a new row (array)
//    t[i] = [];
//
//    // Loop through every item per item in outer array (width)
//    for(j=0; j<w; j++) {
//
//      // Save transposed data.
//      t[i][j] = a[j][i];
//    }
//  }
//
//  return t;
//};
function transposeDataTable(dataTable) {
			//step 1: let us get what the columns would be
			var rows = [];//the row tip becomes the column header and the rest become
			for (var rowIdx=0; rowIdx < dataTable.getNumberOfRows(); rowIdx++) {
				var rowData = [];
				for( var colIdx = 0; colIdx < dataTable.getNumberOfColumns(); colIdx++) {
					rowData.push(dataTable.getValue(rowIdx, colIdx));
				}
				rows.push( rowData);
			}
			var newTB = new google.visualization.DataTable();
			newTB.addColumn('string', dataTable.getColumnLabel(0));
			newTB.addRows(dataTable.getNumberOfColumns()-1);
			var colIdx = 1;
			for(var idx=0; idx < (dataTable.getNumberOfColumns() -1);idx++) {
				var colLabel = dataTable.getColumnLabel(colIdx);
				newTB.setValue(idx, 0, colLabel);
				colIdx++;
			}
			for (var i=0; i< rows.length; i++) {
				var rowData = rows[i];
                                //console.log("assume header : " + rowData[0]);
				newTB.addColumn('number',rowData[0]); //assuming the first one is always a header
				var localRowIdx = 0;
				
				for(var j=1; j< rowData.length; j++) {
					newTB.setValue(localRowIdx, (i+1), rowData[j]);
					localRowIdx++;
				}
			}
			return newTB;
	  }


Number.prototype.round = function(p) {
        p = p || 10;
        return parseFloat( this.toFixed(p) );
      };
    
    function populateDataChart() {
        console.log("populate data");
         var data = report_table.rows().data();
        data.each(function (value, index) {
            console.log('Data in index: ' + index + ' is: ' + value);
        });
    }

    function buildHoursColumn() {
        for (var i = 0; i < rowData.length; i++) {
            var hour = i + 9;
            if (hour == 9)
                hour = '0' + i + ':00';
            else 
                hour = hour + ':00';
            rowData[i].unshift(hour);
        }
        console.log("array : " + rowData.toString());
    }
    
    function buildUpArray(hour, number, index) {
        switch (hour) {
            case '09:00':

                if (dataArray[1][index] == '')
                    dataArray[1][index] = parseFloat(number).round(2);
                else {
                    var data = dataArray[index][index] + parseFloat(number).round(2);
                    dataArray[1][index] = data.round(2);
                }
                break;
            case '10:00':
                if (dataArray[2][index] == '')
                    dataArray[2][index] = parseFloat(number).round(2);
                else {
                    var data = dataArray[2][index] + parseFloat(number).round(2);
                    dataArray[2][index] = data.round(2);
                }
            case '11:00':
                if (dataArray[3][index] == '')
                    dataArray[3][index] = parseFloat(number).round(2);
                else {
                    var data = dataArray[3][index] + parseFloat(number).round(2);
                    dataArray[3][index] = data.round(2);
                }
                break;
            case '12:00':
                if (dataArray[4][index] == '')
                    dataArray[4][index] = parseFloat(number).round(2);
                else {
                    var data = dataArray[4][index] + parseFloat(number).round(2);
                    dataArray[4][index] = data.round(2);
                }
                break;
            case '13:00':
                if (dataArray[5][index] == '')
                    dataArray[5][index] = parseFloat(number).round(2);
                else {
                    var data = dataArray[5][index] + parseFloat(number).round(2);
                    dataArray[5][index] = data.round(2);
                }
                break;
            case '14:00':
                if (dataArray[6][index] == '')
                    dataArray[6][index] = parseFloat(number).round(2);
                else {
                    var data = dataArray[6][index] + parseFloat(number).round(2);
                    dataArray[6][index] = data.round(2);
                }
                break;
            case '15:00':
                if (dataArray[7][index] == '')
                    dataArray[7][index] = parseFloat(number).round(2);
                else {
                    var data = dataArray[7][index] + parseFloat(number).round(2);
                    dataArray[7][index] = data.round(2);
                }
                break;
            case '16:00':
                if (dataArray[8][index] == '')
                    dataArray[8][index] = parseFloat(number).round(2);
                else {
                    var data = dataArray[8][index] + parseFloat(number).round(2);
                    dataArray[8][index] = data.round(2);
                }
                break;
            case '17:00':
                if (dataArray[9][index] == '')
                    dataArray[9][index] = parseFloat(number).round(2);
                else {
                    var data = dataArray[9][index] + parseFloat(number).round(2);
                    dataArray[9][index] = data.round(2);
                }
                break;
            case '18:00':
                if (dataArray[10][index] == '')
                    dataArray[10][index] = parseFloat(number).round(2);
                else {
                    var data = dataArray[10][index] + parseFloat(number).round(2);
                    dataArray[10][index] = data.round(2);
                }
                break;
            case '19:00':
                if (dataArray[11][index] == '')
                    dataArray[11][index] = parseFloat(number).round(2);
                else {
                    var data = dataArray[11][index] + parseFloat(number).round(2);
                    dataArray[11][index] = data.round(2);
                }
                break;
            case '20:00':
                if (dataArray[12][index] == '')
                    dataArray[12][index] = parseFloat(number).round(2);
                else {
                    var data = dataArray[12][index] + parseFloat(number).round(2);
                    dataArray[12][index] = data.round(2);
                }
                break;
            case '21:00':
                if (dataArray[13][index] == '')
                    dataArray[13][index] = parseFloat(number).round(2);
                else {
                    var data = dataArray[13][index] + parseFloat(number).round(2);
                    dataArray[13][index] = data.round(2);
                }
                break;
            case '22:00':
                if (dataArray[14][index] == '')
                    dataArray[14][index] = parseFloat(number).round(2);
                else {
                    var data = dataArray[14][index] + parseFloat(number).round(2);
                    dataArray[14][1] = data.round(2);
                }
                break;

        }
    }
    
function drawLineChart(header, rowData, title, chart_div, rpt_type) {
console.log(rowData);
    var data = new google.visualization.DataTable();
    for (var i = 0; i < header.length; i++) {
        if (i == 0)
            data.addColumn('string', header[i]);
        else
            data.addColumn('number', header[i]);
    }
    data.addRows(rowData);
    var options = {
        title: title,
        pointSize: 4,
        height: 400,
        backgroundColor: {'fill': '#f9f9f9'},
        hAxis: {
            title: ""
        },
//        lineWidth: 3,
//          colors: ['#0000CC', '#CC0000', '#CC9900'],        
        tooltip : {textStyle: {color: '#000000'}, showColorCode: true},        
        'chartArea': {
            'backgroundColor': {
                'fill': '#f9f9f9'
            },
            width: "85%"
        },
        theme: 'material'
    };
    var transposedData;
    if (rpt_type == "3" || rpt_type == "5")
        transposedData = transposeDataTable(data);
    else
        transposedData = data; 
    var chart = new google.visualization.LineChart(document.getElementById(chart_div));
//      google.visualization.events.addListener(chart, 'ready', function () {
//        chart_div.innerHTML = '<img src="' + chart.getImageURI() + '">';
////        console.log(chart.getImageURI());
//      });    
    chart.draw(transposedData, options);
	$(window).smartresize(function () {
            chart.draw(transposedData, options);
     });
}
    
    function drawColumnChart(header, rowData, title, chart_div) {
        var data = new google.visualization.DataTable();
        for( var i = 0; i < header.length; i++) {
            if (i == 0)
                data.addColumn('string', header[i]);
            else
                data.addColumn('number', header[i]);
        }
        console.log("rowData : " + chart_div + rowData);
        data.addRows(rowData);
        var options = {
          title: title,
        backgroundColor: {'fill': '#f9f9f9'},
        height: 400,
		width : 700,
         bar: {groupWidth: "30%"},
//        hAxis: {
//          title: 'Time of Day'
//        },
//        vAxis: {
//          title: 'Rating (scale of 1-10)'
//        },
        'chartArea': {
            'backgroundColor': {
                'fill': '#f9f9f9',
                'opacity': 100
             }        
         }
        };
        var material = new google.visualization.ColumnChart(document.getElementById(chart_div));
        material.draw(data, options);
		$(window).smartresize(function () {
            material.draw(data, options);
        });
    }
    
    function drawComboChart(header, rowData, title, chart_div) {
        var data = new google.visualization.DataTable();
        console.log("header : " + header);
        for( var i = 0; i < header.length; i++) {
            if (i == 0)
                data.addColumn('string', header[i]);
            else
                data.addColumn('number', header[i]);
        }
        console.log("rowData : " + chart_div + rowData);
        data.addRows(rowData);
        var options = {
            title : title,
            seriesType: 'bars',
			width : 700,
            backgroundColor: {'fill': '#f9f9f9'},
            series: {1: {type: 'line'}},
            bar: {groupWidth: "30%"},
            'chartArea': {
            'backgroundColor': {
                'fill': '#f9f9f9',
                'opacity': 100
             }        
         }
        };
       var chart = new google.visualization.ComboChart(document.getElementById(chart_div));
       chart.draw(data, options);
	   $(window).smartresize(function () {
            chart.draw(data, options);
        });
    }
    
    (function($,sr){

  // debouncing function from John Hann
  // http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/
  var debounce = function (func, threshold, execAsap) {
      var timeout;

      return function debounced () {
          var obj = this, args = arguments;
          function delayed () {
              if (!execAsap)
                  func.apply(obj, args);
              timeout = null; 
          };

          if (timeout)
              clearTimeout(timeout);
          else if (execAsap)
              func.apply(obj, args);

          timeout = setTimeout(delayed, threshold || 100); 
      };
  }
    // smartresize 
    jQuery.fn[sr] = function(fn){  return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };

})(jQuery,'smartresize');
