<h2>Statistics for the caregivers</h2>
<hr>





<body>
    <!--Div that will hold the pie chart-->
    
    <div id="chart1_div"></div>
    
    <form method="POST" id="chart1_form" name="chart1Form">

        <select name="residents" id="residents_select">
            <?php foreach ($residents as $resident){ ?>   
                   <option value=<?php echo json_encode($resident->id); ?>> <?php echo json_encode($resident->first_name); ?> </option>
            <?php } ?>
                       
        </select>
        <select name="language" id="language_select" >
              
                        <option value="English"> "English" </option>
                        <option value="Nederlands"> "Nederlands" </option>
                       
        </select>
        <input type="submit" value="submit chart1" name="submit chart1"/>
    </form>
    
    <div id="chart2_div"></div>
    
    <form method="POST" id="chart2_form" name="chart2Form">
        <select name="categories" id="categories_select">
            <?php foreach ($categories as $category){ ?>   
                        <option value=<?php echo json_encode($category->id); ?>> <?php echo json_encode($category->category); ?> </option>
            <?php } ?>           
        </select>

        <select name="language" id="language_select" >
              
                        <option value="English"> "English" </option>
                        <option value="Nederlands"> "Nederlands" </option>
                       
        </select>
        <input type="submit" value="submit chart2" name="submit chart2"/>
    </form>
    
    
<script type="text/javascript">
        var formChart1 = document.getElementById('chart1_form');
        var formChart2 = document.getElementById('chart2_form');
        
        formChart1.addEventListener('submit', function(e) {
            e.preventDefault();
            var selects = this.getElementsByTagName('select');
            var resident = selects[0].value;
            var language = selects[1].value;

            
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>index.php/caregiver/load_charts", 
                data: { resident: resident, language: language},
                dataType: "text",
                cache: false,

                success: function( data ) {
                    var Yaxis = [];

                    var Xaxis = [];
                    console.log(data);
                    var response = JSON.parse( data);
                    console.log(response);
                    
                    Xaxis = response[0][0];
                    Yaxis = response[0][1];

                    google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawChart);

                    
                    function drawChart() {

                        var data = new google.visualization.DataTable();
                        dataChart(Yaxis, Xaxis, data, "chart1_div", resident);
                    }

                    
                }
            });
            return false;
        });
        
        formChart2.addEventListener('submit', function(e) {
            e.preventDefault();
            var selects = this.getElementsByTagName('select');

            
            var category = parseInt(selects[0].value);
            var language = selects[1].value;
            
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>index.php/caregiver/load_charts", 
                data: { language: language, category: category},
                dataType: "text",
                cache: false,

                success: function( data ) {
                    var Yaxis = [];

                    var Xaxis = [];
                    console.log(data);
                    var response = JSON.parse( data);
                    console.log(response);
                    
                    Xaxis = response[1][0];
                    Yaxis = response[1][1];

                    google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawChart2);
                    

                    function drawChart2() {

                        var data = new google.visualization.DataTable();
                        dataChart(Yaxis, Xaxis, data, "chart2_div", selects[0].value);
                    }
                    
                }
            });
            return false;
        });


  
           
</script>

      
  </body>
</html>