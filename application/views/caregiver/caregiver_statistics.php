<h2>Statistics for the caregivers</h2>
<hr>





<body>
    <!--Div that will hold the pie chart-->
    
    
    
    <form class="form-group" method="POST" id="chart1_form" name="chart1Form">
        <select class="form-control" name="residents" id="residents_select" onchange="chart1function()" onload="chart1function()">
            <?php foreach ($residents as $resident){ ?>   
                   <option value=<?php echo json_encode($resident->id); ?>> <?php echo $resident->first_name; ?> </option>
            <?php } ?>                    
        </select>
    </form>
    
    <div id="chart1_div"></div>
    
    

    <form class="form-group" method="POST" id="chart2_form" name="chart2Form">
        <select class="form-control" name="categories" id="categories_select" onchange="chart2function()" onload="chart2function()">
            <?php foreach ($categories as $category){ ?>   
                        <option value=<?php echo json_encode($category->id); ?>> <?php echo $category->category; ?> </option>
            <?php } ?>           
        </select>


    </form>
    <div id="chart2_div"></div>
    
    
<script type="text/javascript">
        var formChart1 = document.getElementById('chart1_form');
        var formChart2 = document.getElementById('chart2_form');
        
        google.charts.load('current', {'packages':['corechart']});
        chart1function();
        chart2function();
        //formChart1.addEventListener('submit', function(e) {
        function chart1function(){
            console.log('chart 1 submitted');
            //e.preventDefault();
            var selects = formChart1.getElementsByTagName('select');
            var resident = selects[0].value;


            
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>index.php/caregiver/load_charts", 
                data: { resident: resident},
                dataType: "text",
                cache: false,

                success: function( data ) {
                    var Yaxis = [];
                    var Xaxis = [];
                    console.log(data);
                    var response = JSON.parse( data);
                    console.log(response);
                    
                    Xaxis = response[0];
                    Yaxis = response[1];

                    //google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawChart);

                    
                    function drawChart() {

                        var data = new google.visualization.DataTable();
                        dataChart(Yaxis, Xaxis, data, "chart1_div", "");
                    }

                    
                }
            });
            return false;
        }
        
        //formChart2.addEventListener('submit', 
        function chart2function(){
            console.log('chart 2 submitted');
            //e.preventDefault();
            var selects = formChart2.getElementsByTagName('select');

            
            var category = parseInt(selects[0].value);

            
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>index.php/caregiver/load_charts", 
                data: { category: category},
                dataType: "text",
                cache: false,

                success: function( data ) {
                    var Yaxis = [];

                    var Xaxis = [];
                    console.log(data);
                    var response = JSON.parse( data);
                    console.log(response);
                    
                    Xaxis = response[0];
                    Yaxis = response[1];

                    
                    google.charts.setOnLoadCallback(drawChart2);
                    

                    function drawChart2() {

                        var data = new google.visualization.DataTable();
                        dataChart(Yaxis, Xaxis, data, "chart2_div", "");
                    }
                    
                }
            });
            return false;
        }


  
           
</script>

      
  </body>
</html>