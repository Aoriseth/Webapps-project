<!--Div that will hold the pie chart-->
<div class="container-fluid">

	<div class="row">
		<div class="col-md-6">
			<form class="form-group" method="POST" id="chart1_form" name="chart1Form">
				<select class="form-control" name="residents" id="residents_select" onchange="chart1function()" onload="chart1function()">
					<?php foreach ($residents as $resident) { ?>   
						<option value=<?= json_encode($resident->id); ?> ><?= $resident->first_name; ?></option>
					<?php } ?>                    
				</select>
			</form>

			<div id="chart1_div" style="width:100%"></div>
		</div>

		<div class="col-md-6">
			<form class="form-group" method="POST" id="chart2_form" name="chart2Form">
				<select class="form-control" name="categories" id="categories_select" onchange="chart2function()" onload="chart2function()">
					<?php foreach ($categories as $category) { ?>   
						<option value=<?= json_encode($category->category_set); ?> ><?php echo $category->category; ?></option>
					<?php } ?>           
				</select>


			</form>
			<div id="chart2_div" style="width:100%"></div>
		</div>
	</div>
        <div class="row">
            <div id="chart3_div" style="width:100%"></div>
        </div>
</div>









<script type="text/javascript">
	var formChart1 = document.getElementById('chart1_form');
	var formChart2 = document.getElementById('chart2_form');

	google.charts.load('current', {'packages': ['corechart']});
	chart1function();
	chart2function();
        chart3function();
	//formChart1.addEventListener('submit', function(e) {
	function chart1function() {
		console.log('chart 1 submitted');
		//e.preventDefault();
		var selects = formChart1.getElementsByTagName('select');
		var resident = selects[0].value;



		$.ajax({
			type: "POST",
			url: "<?php echo base_url() ?>index.php/caregiver/load_resident_chart",
			data: {resident: resident},
			dataType: "text",
			cache: false,

			success: function (data) {
				var Yaxis = [];
				var Xaxis = [];
				console.log(data);
				var response = JSON.parse(data);
				console.log(response);

				Xaxis = response[0];
				Yaxis = response[1];

				//google.charts.load('current', {'packages':['corechart']});
				google.charts.setOnLoadCallback(drawChart);


				function drawChart() {

					var data = new google.visualization.DataTable();
					columnChart(Yaxis, Xaxis, data, "chart1_div", '<?= lang( 'c_statistics_all_category_individual' ) ?>');
				}


			}
		});
		return false;
	}

	//formChart2.addEventListener('submit', 
	function chart2function() {
		console.log('chart 2 submitted');
		//e.preventDefault();
		var selects = formChart2.getElementsByTagName('select');


		var category = parseInt(selects[0].value);


		$.ajax({
			type: "POST",
			url: "<?php echo base_url() ?>index.php/caregiver/load_category_chart",
			data: {category: category},
			dataType: "text",
			cache: false,

			success: function (data) {
				var Yaxis = [];
				var Xaxis = [];
				console.log(data);
				var response = JSON.parse(data);
				console.log(response);

				Xaxis = response[0];
				Yaxis = response[1];


				google.charts.setOnLoadCallback(drawChart2);


				function drawChart2() {

					var data = new google.visualization.DataTable();
					columnChart(Yaxis, Xaxis, data, "chart2_div", '<?= lang( 'c_statistics_category_all_individual' ) ?>');
				}

			}
		});
		return false;
	}
        
        function chart3function() {
		console.log('chart 3 submitted');

		$.ajax({
			type: "POST",
			url: "<?php echo base_url() ?>index.php/caregiver/load_avarage_score_chart",
			data: {},
			dataType: "text",
			cache: false,

			success: function (data) {
				var Yaxis = [];
				var Xaxis = [];
				var response = JSON.parse(data);
				console.log(response);

				Xaxis = response[0];
				Yaxis = response[1];


				google.charts.setOnLoadCallback(drawChart3);


				function drawChart3() {

					var data = new google.visualization.DataTable();
					columnChart(Yaxis, Xaxis, data, "chart3_div", 'avarage scores of all residents');
				}

			}
		});
		return false;
	}




</script>
