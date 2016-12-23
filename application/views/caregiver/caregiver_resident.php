<script src="<?= base_url() ?>assets/js/QR-code/qrcode.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/js/QR-code/download.js" type="text/javascript"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.min.js"></script>

<div class="container-fluid">

    <div class="panel container-fluid">
        <br>
        <p class="txScale">
            Details of {name} {last_name}
        </p>

        <div class="row">
            <div class="col-sm-6">
                <img src={profile_picture} alt="Profile Picture" style="width:250px;height:300px;">
            </div> 
            <div class="col-sm-6">
                Born: {date_of_birth} </br>
                Language: {language} </br>
                Floor: {floor} Room: {room} </br>
                Last activity: {last_activity} </br>
                {sessions_completed} completed session(s) </br>
                {name}'s average score is {average_score} </br>
                <div id="qrcode"></div><button id = "qrcodeButton">Download QR code</button>
            </div>
        </div>
        </br>
    </div>


</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="panel container-fluid">
                <br>
                {name} {comment}
                <div id="chart1_div" style="width:100%"></div>
                <br>
            </div>


        </div>
        <div  class="col-md-6">
            <div class="panel container-fluid">
                <form class="form-group" method="POST" id="chart2_form" name="chart2Form">
                    <select class="selectpicker form-control" name="categories" id="categories_select" onchange="chart2function()" onload="chart2function()">
                        <?php foreach ($categories as $category) { ?>   
                            <option value=<?= json_encode($category->category_set); ?> ><?php echo $category->category; ?></option>
                        <?php } ?>           
                    </select>
                </form>
                <div class="btn" id="chart2_div" style="width:100%"></div>
            </div>


        </div>
    </div>
</div>




<script type="text/javascript">
    var qrcode = null;
    var formChart2 = document.getElementById('chart2_form');
    google.charts.load('current', {'packages': ['corechart']});
    // Below here the QR code stuff
    // qr code generator library -> http://davidshimjs.github.io/qrcodejs/
    var data = ' {"username": "{username}", "password": "{password}"} ';
    console.log(data);
    qrcode = new QRCode(document.getElementById("qrcode"), {
        text: data,
        width: 200,
        height: 200,
        colorDark: "#000000",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.H});
    $("#qrcodeButton").click(function(){
        // download function library http://danml.com/download.html#FullSource
        // I changed something in teh QR-code generator library so I have an id of the image of the QR-code
        // line 367
        download($("#qrcodeID").attr('src'),"qrcode_{name}_{last_name}.png","image/png");
    });

    chart1function();
    chart2function();
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
                    columnChart(Yaxis, Xaxis, data, "chart1_div", '<?= lang('c_statistics_all_category_individual') ?>');
                }


            }
        });
        return false;
    }

    function chart2function() {
        console.log('chart 2 submitted');
        //e.preventDefault();
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
                console.log(data);
                var response = JSON.parse(data);
                console.log(response);

                Xaxis = response[0];
                Yaxis = response[1];


                google.charts.setOnLoadCallback(drawChart2);


                function drawChart2() {

                    var data = new google.visualization.DataTable();
                    lineChart(Yaxis, Xaxis, data, "chart2_div", 'verloop van categorie');
                }

            }
        });
        return false;
    }





</script>