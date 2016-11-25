<h2>Statistics for the caregivers</h2>
<hr>
<script type="text/javascript">
      //get all categories
      var categories = [];
      <?php foreach ($categories as $category){ ?>
          categories.push(<?php echo json_encode($category->category); ?> );
      <?php } ?>  
      
      //load Charts and corechart package
      google.charts.load('current', {'packages':['corechart']});
      
      //draw charts when Charts is loaded
      google.charts.setOnLoadCallback(drawScorePerCategoryChart); //Don't add brackets after callback function!
      
      function drawScorePerCategoryChart() {
        // Create the data table for Sarah's pizza.
        var data = new google.visualization.DataTable();
        ScorePerCategoryChart(categories, data);
      }
               
</script>


<body>
    <!--Div that will hold the pie chart-->
    
    <div id="score_per_cat_chart_div"></div>
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