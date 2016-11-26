<h2>Statistics for the caregivers</h2>
<hr>


<script type="text/javascript">
        
      <?php 

      echo $this->Statistics_model->getScoreCategory('r123', 1);
      echo $this->Statistics_model->getWeightFor(8);
      $answers = $this->Statistics_model->getResidentAnswersFromCategory( 'r123', 1);
      foreach ($answers as $answer) {
          echo $answer->option_id;
      }
      ?>
            
     
      //get all categories
      var categories = [];
      var score = [];



     <?php foreach ($categories as $category){ ?>
          categories.push( <?php echo json_encode($category->category); ?>);
          score.push(<?php echo json_encode($this->Statistics_model->getScoreCategory('r123', $category->id)); ?>);
      <?php } ?> 
      //load Charts and corechart package
      google.charts.load('current', {'packages':['corechart']});
      
      //draw charts when Charts is loaded
      google.charts.setOnLoadCallback(drawScorePerCategoryChart); //Don't add brackets after callback function!
      function drawScorePerCategoryChart() {
        // Create the data table for Sarah's pizza.
        var data = new google.visualization.DataTable();
        dataChart(categories, score, data, "score_per_cat_chart");
      }
              
</script>


<body>
    <!--Div that will hold the pie chart-->
    
    <div id="score_per_cat_chart"></div>
    <form method='post'>
        <select name="categories" id="categories_select" onchange="this.form.submit()">
            <?php foreach ($categories as $category){ ?>
                <?php if(isset($_POST['categories']) && $_POST['categories'] === $category){?>  
                    <option value=<?php echo json_encode($category->category); ?> selected> <?php echo json_encode($category->category); ?> </option>
                <?php } else { ?>
                        <option value=<?php echo json_encode($category->category); ?>> <?php echo json_encode($category->category); ?> </option>
                <?php } ?>
            <?php } ?>           
        </select>
      </form>
    <?php if(isset($_POST['categories'])) echo $_POST['categories']; ?>
      
  </body>
</html>