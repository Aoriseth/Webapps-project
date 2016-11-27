<h2>Statistics for the caregivers</h2>
<hr>





<body>
    <!--Div that will hold the pie chart-->
    
    <div id="chart_div"></div>
    
    <form method="POST" id="select_axis_form" name="selectForm">
        <select name="categories" id="categories_select">
            <?php foreach ($categories as $category){ ?>   
                        <option value=<?php echo json_encode($category->id); ?>> <?php echo json_encode($category->category); ?> </option>
            <?php } ?>           
        </select>
        <select name="residents" id="residents_select">
            <?php foreach ($residents as $resident){ ?>   
                        <option value=<?php echo json_encode($resident->id); ?>> <?php echo json_encode($resident->first_name); ?> </option>
            <?php } ?>           
        </select>
        <input type="submit" value="submit" name="submit"/>
    </form>
<script type="text/javascript">
        var formAxis = document.getElementById('select_axis_form');
        
        formAxis.addEventListener('submit', function(e) {
            e.preventDefault();
            var selects = this.getElementsByTagName('select');
            var category = parseInt(selects[0].value);
            var resident = selects[1].value;
            
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>index.php/caregiver/load_charts", 
                data: {category: category, resident: resident},
                dataType: "text",
                cache: false,

                success: function( data ) {
                    var categories = [];

                    var scores = [];
                    console.log(data);
                    var response = JSON.parse( data);
                    console.log(response);
                    
                    for(var i = 0; i < response[0].length; i++){
                        categories.push(response[0][i].category);
                    }
                    for(var i = 1; i < response.length; i++){
                        scores.push(response[i]);
                    }
                    google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawChart);
                    
                    function drawChart() {

                        var data = new google.visualization.DataTable();
                        dataChart(categories, scores, data, "chart_div", "resident");
                    }
                    
                }
            });
            return false;
        });


  
           
</script>

      
  </body>
</html>