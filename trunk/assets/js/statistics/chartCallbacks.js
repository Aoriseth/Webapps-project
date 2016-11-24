

      function ScorePerCategoryChart(categories, data) {
         
        // Create the data table.
        //var data = new google.visualization.DataTable();
        data.addColumn('string', 'Category');
        data.addColumn('number', 'Score');
        var rows = [];

        rows.forEach(function(category){

            rows.push([category, Math.floor((Math.random() * 10) + 1)]);
        
        });
        for (var index = 0; index < categories.length; ++index) {
            rows.push([categories[index], Math.floor((Math.random() * 10) + 1)]);

        }
            
        data.addRows(rows);
        // Set chart options
        var options = {'title':'Score per category',
                       'width':400,
                       'height':400};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.BarChart(document.getElementById('score_per_cat_chart_div'));
        chart.draw(data, options);
      }


