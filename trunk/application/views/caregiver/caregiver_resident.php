<p class="txScale">
    Details of {name}.
</p>

<div class="container-fluid">
    <div class="row">
        <div class="col-xs-6">
            <img src="<?php echo base_url(); ?>assets/elderly.jpg" alt="Profile Picture" style="width:250px;height:300px;">
        </div>
        <div class="col-xs-6">
            <div id="chart1_div" style="width:100%"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            eventueel problematische topics (-50?)
        </div>
        <div class="col-xs-6">
            grafiek die verloop toont van bepaalde categorie over over alle sessies
        </div>
    </div>
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
			url: "<?php echo base_url() ?>index.php/caregiver/load_resident_chart",
			data: {resident: "{id}"},
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