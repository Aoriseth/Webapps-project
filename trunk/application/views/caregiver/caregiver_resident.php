<p class="txScale">
    Details of {name}.
</p>

<div class="container-fluid">
    chart
    <div id="chart1_div" style="width:100%"></div>


</div>

<script type="text/javascript">
	

	google.charts.load('current', {'packages': ['corechart']});
	
        chart1function();
	//formChart1.addEventListener('submit', function(e) {
	function chart1function() {
		console.log('chart 1 submitted');
		//e.preventDefault();



		$.ajax({
			type: "POST",
			url: "<?php echo base_url() ?>index.php/caregiver/load_charts",
			data: {resident: "{name}"},
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
					dataChart(Yaxis, Xaxis, data, "chart1_div", '<?= lang( 'c_statistics_all_category_individual' ) ?>');
				}


			}
		});
		return false;
	}

	



</script>