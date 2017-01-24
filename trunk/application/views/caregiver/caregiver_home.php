<?php if ($display_login_notification == true) { ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $.snackbar({content: '<?= lang('common_welcome_snackbar') ?>'});
        });
    </script>
<?php } ?>

<div class=" panel container-fluid">
    </br>
<!--    <p class="txScale"><?= lang('c_home_title') ?></p>
    <p class="tlScale">  Welkom!</p>
    <hr>-->

    

    <div class="row">
        <div class="col-md-6">
            <p style="font-size:16px;"><?= lang('c_home_info_residents') ?></p>
            <hr>
            <div class="list-group">
                <?php $i = 0;
                foreach ($recent_residents as $resident) {
                    ?><div class="list-group-item">
                        <div class="row-picture">
                            <img class="circle" src= "<?php echo $profile_pictures[$i]?>" alt="icon">
                        </div>
                        <div class="row-content">
                            <h4 class="list-group-item-heading"><a href="<?php echo base_url(); ?>index.php/caregiver/resident/<?php echo $resident->id ?>" ><?php echo $resident->first_name; ?> <?php echo $resident->last_name;?> </a></h4>

                            <p class="list-group-item-text">Completed Questionnaire on - <?php echo date("Y-m-d", strtotime($resident->last_completed));?></p>
                        </div>
                    </div>
                    <div class="list-group-separator"></div> 
                <?php $i++; } ?>

            </div>
        </div>
        <div class="col-md-6">
        <div class="row">
            <div class="col-xs-12">
                <div id="chart1_div"></div>
            </div>
            <div class="col-xs-6">
                </br>

            </div>
        </div>
    </div>
    </div>
    
    </br>
</div>


<script type="text/javascript">


    google.charts.load('current', {'packages': ['corechart']});
    
    chart1function();
    
    $(window).resize(function(){
        chart1function();
    });
    //formChart1.addEventListener('submit', function(e) {
    function chart1function() {
        console.log('chart 1 submitted');
        //e.preventDefault();

        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>index.php/caregiver/load_avarage_score_per_category_chart",
            data: {},
            dataType: "text",
            cache: false,

            success: function (data) {
                var Yaxis = [];
                var Xaxis = [];
                //console.log(data);
                var response = JSON.parse(data);
                //console.log(response);

                Xaxis = response[0];
                Yaxis = response[1];

                //google.charts.load('current', {'packages':['corechart']});
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {

                    var data = new google.visualization.DataTable();
                    columnChart(Yaxis, Xaxis, data, "chart1_div"); //, 'average scores of all categories'
                }
            }
        });
        return false;
    }

</script>