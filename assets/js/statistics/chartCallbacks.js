

      function dataChart(yAxis, xAxis, data, chartId, chartTitle) {
         
        // Create the data table.
        //var data = new google.visualization.DataTable();
        data.addColumn('string', 'Category');
        data.addColumn('number', 'Score');
        var rows = [];


        for (var index = 0; index < yAxis.length; index++) {
            rows.push([yAxis[index], xAxis[index]]);

        }
            
        data.addRows(rows);
        // Set chart options
        var options = {'title':chartTitle,
                       'width':400,
                       'height':400,
                        vAxis: {gridlines: { count: 5 },
                                minValue: 0,
                                maxValue: 100
                                }

                        
                    };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.ColumnChart(document.getElementById(chartId));
        chart.draw(data, options);
        
        
    
      }

      
    
