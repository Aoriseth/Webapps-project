<script src="<?= base_url() ?>assets/js/QR-code/qrcode.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/js/QR-code/download.js" type="text/javascript"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.min.js"></script>

<div class="container-fluid">

    <div class="panel container-fluid">
        <br>
        <p class="tlScale">
            {name} {last_name}
        </p><hr>
        <div class="container-fluid">
            <div class="row">
                <div  class="col-md-4 col-sm-5">
                    <img src={profile_picture} alt="Profile Picture" style="width:260px;height:300px;">
					<form id="propic-form" action="<?php echo base_url() ?>index.php/caregiver/upload" method="POST" enctype="multipart/form-data">
						<input type="file" id ="propic-select" name="pic" />
						<button class="btn primarylink" type="submit" id="propic-button">Change profile picture</button>
					</form>
					<form id="puzzlepic-form" action="<?php echo base_url() ?>index.php/caregiver/upload" method="POST" enctype="multipart/form-data">
                                            <input type="file" id ="puzzlepic-select" name="pic" />
						<button class="btn primarylink" type="submit" id="puzzlepic-button">Add a puzzle picture</button>
					</form>

                </div> 
                <div class="col-md-4 col-sm-7">
                    Born: {date_of_birth} <br>
                    Language: {language} <br>
                    Floor: {floor} Room: {room} <br>
                    Last activity: {last_activity} <br>
                    {sessions_completed} completed session(s) <br>
                    {name}'s average score is {average_score} <br><br>
                    <div  id="qrcode" style="text-align:center;"></div><button class="btn primarylink" id = "qrcodeButton">Download QR code</button>
                </div>
                
                <div class="col-md-4 col-sm-12">
                    {name} {comment}
                </div>
            </div>
        </div>

        <br>
    </div>


</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="panel container-fluid">
                <h3 style="font-size:1.3vmax;">Score voor alle categorien</h3>
                <hr/>
                <div id="chart1_div" style="width:100%"></div>
                <br>
            </div>
        </div>
        <div  class="col-md-6">
            <div class="panel container-fluid">
                    <h3 style="font-size:1.3vmax;">Verloop van categorie</h3>
                    <hr/>
                    <form class="form-group" method="POST" id="chart2_form" name="chart2Form">
                        <select class="selectpicker form-control" name="categories" id="categories_select" onchange="chart2function()" onload="chart2function()">
                            <?php foreach ($categories as $category) { ?>   
                                <option value=<?= json_encode($category->category_set); ?> ><?php echo $category->category; ?></option>
                            <?php } ?>           
                        </select>
                    <div id="chart2_div" style="width:100%"></div>
                </div>
            </div>
        </div>
    </div>
</div>




<script type="text/javascript">
    // Below here the QR code stuff
    // qr code generator library -> http://davidshimjs.github.io/qrcodejs/
    var qrcode = null;
    var data = ' {"username": "{username}", "password": "{password}"} ';
    qrcode = new QRCode(document.getElementById("qrcode"), {
        text: data,
        width: 200,
        height: 200,
        colorDark: "#000000",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.H});
    $("#qrcodeButton").click(function () {
        // download function library http://danml.com/download.html#FullSource
        // I changed something in the QR-code generator library so I have an id of the image of the QR-code
        // line 367
        download($("#qrcodeID").attr('src'), "qrcode_{name}_{last_name}.png", "image/png");
    });
	
 
    // puzzle stuf and profile pic
    var formPuzzlepic = document.getElementById('puzzlepic-form');
	var fileSelectPuzzlepic = document.getElementById('puzzlepic-select');
	var uploadButtonPuzzlepic = document.getElementById('puzzlepic-button');
	
	formPuzzlepic.onsubmit = function(event) {
		event.preventDefault();
		
		var files = fileSelectPuzzlepic.files;
		var formData = new FormData();
		// Loop through each of the selected files.
		for (var i = 0; i < files.length; i++) {
			var file = files[i];
			// Add the file to the request.
			formData.append('pic', file, file.name);
		}
		formData.append("username", "{username}");
		formData.append("profile", "0");
		
		// Set up the request.
		var xhr = new XMLHttpRequest();
		// Open the connection.
		xhr.open('POST', '<?php echo base_url() ?>index.php/caregiver/upload', true);
		
	// Send the Data.
		xhr.send(formData);
	};
	
	var formPropic = document.getElementById('propic-form');
	var fileSelectPropic = document.getElementById('propic-select');
	var uploadButtonPropic = document.getElementById('propic-button');
	
	formPropic.onsubmit = function(event) {
		event.preventDefault();
		
		var files = fileSelectPropic.files;
		var formData = new FormData();
		// Loop through each of the selected files.
		for (var i = 0; i < files.length; i++) {
			var file = files[i];
			// Add the file to the request.
			formData.append('pic', file, file.name);
		}
		formData.append("username", "{username}");
		formData.append("profile", "1");
		
		// Set up the request.
		var xhr = new XMLHttpRequest();
		// Open the connection.
		xhr.open('POST', '<?php echo base_url() ?>index.php/caregiver/upload', true);
		
		// Send the Data.
		xhr.send(formData);
	};
    var formChart2 = document.getElementById('chart2_form');
    google.charts.load('current', {'packages': ['corechart']});
    chart1function();
    chart2function();
        
    $(window).resize(function(){
        chart1function();
        chart2function();
    });
    
    function chart1function() {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>index.php/caregiver/load_resident_chart",
            data: {resident: "{id}"},
            dataType: "text",
            cache: false,
            success: function (data) {
                var Yaxis = [];
                var Xaxis = [];
                var response = JSON.parse(data);
                Xaxis = response[0];
                Yaxis = response[1];
                google.charts.setOnLoadCallback(drawChart);
                function drawChart() {
                    var data = new google.visualization.DataTable();
                    columnChart(Yaxis, Xaxis, data, "chart1_div", '<?= lang('c_statistics_all_category_individual') ?>');
                }
            }
        });
        return false;
    }

    function chart2function() {
        var selects = formChart2.getElementsByTagName('select');
        var category = parseInt(selects[0].value);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>index.php/caregiver/load_category_course_chart",
            data: {category: category, resident: "{id}"},
            dataType: "text",
            cache: false,
            success: function (data) {
                var Yaxis = [];
                var Xaxis = [];
                var response = JSON.parse(data);
                Xaxis = response[0];
                Yaxis = response[1];
                google.charts.setOnLoadCallback(drawChart2);
                function drawChart2() {
                    var data = new google.visualization.DataTable();
                    lineChart(Yaxis, Xaxis, data, "chart2_div"); // ,'verloop van categorie'
                }
            }
        });
        return false;
    }

</script>
