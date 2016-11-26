<h2>Statistics for the caregivers</h2>
<hr>


<script type="text/javascript">
        

            
     
      //get all categories
      var categories = [];
      var group_scores = [];
      var individual_scores = [];
      
      <?php foreach ($categories as $category){ ?>
          categories.push( <?php echo json_encode($category->category); ?>);
      <?php } ?>     

     <?php if(isset($_POST['residents'])){
     foreach ($categories as $category){ ?>
            individual_scores.push(<?php echo json_encode($this->Statistics_model->getScoreCategory($_POST['residents'], $category->id)); ?>);         
     <?php }} ?> 
     <?php foreach ($categories as $category){ ?>          
            group_scores.push(<?php echo json_encode($this->Statistics_model->getAvarageScoreCategory($category->id)); ?>);
           
     <?php } ?> 
          
          
      //load Charts and corechart package
      google.charts.load('current', {'packages':['corechart']});
      
      //draw charts when Charts is loaded

      google.charts.setOnLoadCallback(individual_Chart); //Don't add brackets after callback function!
      
      function individual_Chart() {
        
        var data = new google.visualization.DataTable();
        dataChart(categories, individual_scores, data, "individual_scores_chart", "resident");
      }

      
      google.charts.setOnLoadCallback(group_Chart); //Don't add brackets after callback function!
      
      function group_Chart() {
        
        var data = new google.visualization.DataTable();
        dataChart(categories, group_scores, data, "group_scores_chart", "group");
      }
      

           
</script>


<body>
    <!--Div that will hold the pie chart-->
    
    <div id="group_scores_chart"></div>
    <div id="individual_scores_chart"></div>
    
    <form method='post'>
        <select name="categories" id="categories_select" onchange="this.form.submit()">
            <?php foreach ($categories as $category){ ?>   
                        <option value=<?php echo json_encode($category->category); ?>> <?php echo json_encode($category->category); ?> </option>
            <?php } ?>           
        </select>
    </form>
    <form method='post'>
        <select name="residents" id="residents_select" onchange="this.form.submit()">
            <option value=0> -Pick a resident- </option>
            <?php foreach ($residents as $resident){ ?>   
                        <option value=<?php echo json_encode($resident->id); ?>> <?php echo json_encode($resident->first_name); ?> </option>
            <?php } ?>           
        </select>
    </form>


      
  </body>
</html>