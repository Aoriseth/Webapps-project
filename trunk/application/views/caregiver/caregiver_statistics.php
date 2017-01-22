<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/9.0.0/nouislider.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/9.0.0/nouislider.min.css"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.min.js"></script>
    <script type="text/javascript">
        var base_url = "<?php Print(base_url()); ?>"; 
        var caregiverID = "<?php Print($caregiverID); ?>"; 
        var no_result = "<?php Print(lang('c_statistics_no_result')); ?>"; 
        var chart_title0 = "<?php Print(lang('c_statistics_all_category_selected_individual')); ?>"; 
        var chart_title1 = "<?php Print(lang('c_statistics_all_category_individual')); ?>"; 
        var chart_title2 = "<?php Print(lang('c_statistics_category_all_individual')); ?>"; 
        var chart_title3 = "<?php Print(lang('c_statistics_average_scores_of_selected_residents')); ?>"; 
    </script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/caregiver_filter.js"></script>
</head>

<!--Div that will hold the pie chart-->
<div class="container-fluid">

    <div class="row">
        <div class="col-md-12">
            <div class="panel container-fluid">
                <div class="row">
                    <div class="filter-content">
                            <div class="modal-header">
                                <h3 class="modal-title"><?= lang('c_statistics_filter') ?></h3>
                            </div>
                        <div class="col-md-6 col-sm-6">        

                            <div class="modal-body form">
                                <form action="#" id="form" class="form-horizontal">

                                        <!-- GENDER -->
                                        <div class="form-group">
                                            <label class="col-md-2"><?= lang('c_statistics_gender') ?></label>
                                            <div class="radios" onchange="clickFilter(caregiverID);">
                                                <div class="col-md-4">
                                                    <div class="radio radio-primary">
                                                        <label>
                                                            <?= lang('c_statistics_male') ?>
                                                            <input type="radio" name="optionsRadios" id="optionMale" value="option1"<!--checked=""--><span class="circle"></span><span class="check"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="radio radio-primary">
                                                        <label>
                                                            <?= lang('c_statistics_female') ?>
                                                            <input type="radio" name="optionsRadios" id="optionFemale" value="option2"><span class="circle"></span><span class="check"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- FLOOR -->   
                                        <div class="form-group">
                                            <label class="col-md-2"><?= lang('c_statistics_floor') ?></label>
                                            <div class="col-md-10">
                                                    <select class="selectpicker form-control" id="floor" onchange="clickFilter(caregiverID);"> <!-- multiple="multiple" expands the opts -->
                                                        <?php foreach ($floors as $floor) { ?> 
                                                            <option value= <?php
                                                            $floor->floor_number;
                                                            echo $floor->floor_number;          // key name in db
                                                            ?> > <?php echo $floor->floor_number ?> </option>
                                                         <?php } ?>   
                                                    </select>
                                            </div>                            
                                        </div>

                                        <!-- AGE -->
                                        <div class="form-group">
                                            <label class="col-md-2"><?= lang('c_statistics_age') ?></label>
                                            <div class="col-md-10">
                                                <div id="slider-non-linear-step" class="slider shor noUi-target noUi-ltr noUi-horizontal noUi-connect">
                                                    <div class="noUi-base">
                                                        <div class="noUi-origin noUi-background" >
                                                        </div>
                                                        <div class="noUi-origin noUi-background" >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <span class="age-range" id="age-min"></span>
                                                    -
                                                    <span class="age-range" id="age-max"></span>
                                                </div>
                                            </div>
                                        </div>



                                        <!-- RESULTS -->
                                        <div id="result-info" style="font-size:16px; text-align:right; color:#BDBDBD;"></div>
                                        <div class="form-group" id="update_div" style="display:none">
                                            <label class="col-md-2"><?= lang('c_statistics_result') ?></label>
                                            <div class="col-md-10">
                                                    <div id="result-list">
                                                    </div>
                                            </div>  
                                        </div>

                                        <div class="modal-footer">
                                            <!--button type="button" class="btn btn-info" id="btnFilter" onclick="clickFilter(caregiverID);" style="float: right;">
                                                <i class="glyphicon glyphicon-filter"></i> Filter</button-->
                                            <button type="button" class="btn btn-info" id="btnSave" onclick="clickSave()">
                                                <i class="glyphicon glyphicon-stats"></i> Stats</button>
                                        </div>
                                </form>
                            </div> <!--class="modal-body form"-->
                        </div>

                        <div class="col-md-6 col-sm-12">
                            <div class="container">
                                <div id="chart1_div" style="width:100%"></div>
                                <div id="wait" 
                                     style="
                                        display:none;
                                        border:0px solid black;
                                        position:absolute;
                                        text-align:center;
                                        top:50%;
                                        left:50%;
                                        "><img src=<?php echo base_url() . 'assets/imgs/ajax-loader.gif' ?> >                                   
                                </div>
                            </div>
                        </div> 

                    </div><!--div class="filter-content"-->
                </div><!--div class="row"-->
            </div><!--div class="panel container-fluid-->
        </div><!--div class="col-md-12"-->
        
        <!--div class="col-md-6">
            <div class="panel container-fluid">
                <form class="form-group" method="POST" id="chart1_form" name="chart1Form">
                    <select class="selectpicker form-control" name="residents" id="residents_select" onchange="chart1function()" onload="chart1function()">
                        <?php foreach ($residents as $resident) { ?>   
                            <option value=<?= json_encode($resident->id); ?> ><?= $resident->first_name; ?></option>
                        <?php } ?>                    
                    </select>
                </form>

                <div id="chart1_div" style="width:100%"></div>
            </div>
        </div-->

        <div class="col-md-6">
            <div class="panel container-fluid">
                <form class="form-group" method="POST" id="chart2_form" name="chart2Form">
                    <select class="selectpicker form-control" name="categories" id="categories_select" onchange="chart2function()" onload="chart2function()">
                        <?php foreach ($categories as $category) { ?>   
                            <option value=<?= json_encode($category->category_set); ?> ><?php echo $category->category; ?></option>
                        <?php } ?>           
                    </select>


                </form>
                <div id="chart2_div" style="width:100%"></div>
            </div>

        </div>

        <div class="col-md-6">
            <div class="panel container-fluid">
                <div id="chart3_div" style="width:100%"></div>
            </div>
        </div>
        
    </div>
</div>


<script type="text/javascript">
    /*
    //var formChart1 = document.getElementById('chart1_form');
    var formChart2 = document.getElementById('chart2_form');

    google.charts.load('current', {'packages': ['corechart']});
    //chart1function();
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
                    columnChart(Yaxis, Xaxis, data, "chart1_div", "c_statistics_all_category_individual");
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
                    columnChart(Yaxis, Xaxis, data, "chart2_div", "c_statistics_category_all_individual");
                }
            }
        });
        return false;
    }
    
    function chart3function() {
        console.log('chart 3 submitted');
	$.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>index.php/caregiver/load_avarage_score_per_resident_chart",
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
    }*/
</script>
