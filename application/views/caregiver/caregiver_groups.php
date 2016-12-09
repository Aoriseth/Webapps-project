<head>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/9.0.0/nouislider.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/9.0.0/nouislider.min.css"></script>
    
    <script type="text/javascript">
        var nonLinearStepSlider;
        var ageRange;
        var ageMin;
        var ageMax;
        var gender;
        var floors = [];
        
        $(function () {
            <?php foreach ($residents as $resident) { ?>
                $("#<?php echo ($resident->id); ?>").draggable(); //TODO
            <?php } ?>

        });

        function add_group()
        {
            //add_method = 'add';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            //$('.help-block').empty(); // clear error string, TODO
            $('#modal_form').modal('show'); // show bootstrap modal
            $('.modal-title').text('Add Group'); // Set Title to Bootstrap modal title


            nonLinearStepSlider = document.getElementById('slider-non-linear-step');
            noUiSlider.create(nonLinearStepSlider, {
                start: [60, 80],
                step: 1,
                range: {
                    'min': [50],
                    'max': [120]
                }
            });

            ageRange = [
                document.getElementById('age-min'),
                document.getElementById('age-max')
            ];

            nonLinearStepSlider.noUiSlider.on('update', function (values, handle) {
                ageRange[handle].innerHTML = parseInt(values[handle]);
            });
        }

        function filter()
        {
            // TODO: warning if empty
            console.log('function filter()');
            // GENDER
            if(document.getElementById('optionMale').checked) {
                gender = "male";
            } else if(document.getElementById('optionFemale').checked) {
                gender = "female";
            }
            
            // FLOOR
            var f = document.getElementById("floor");
            for (var i = 0; i < f.options.length; i++) {
                if(f.options[i].selected){
                    if ( !( f.options[i].value in floors ) ) { // prevent duplicates
                        floors.push(f.options[i].value);
                    }
                }
            }
  
            // AGE
            nonLinearStepSlider.noUiSlider.on('update', function ( values, handle ) {
                if ( handle === 0 ) {
                    ageMin = parseInt(values[handle]);
                }
                else if ( handle === 1 ) {
                    ageMax = parseInt(values[handle]);
                }
            });
            //console.log("Filter:", ageMin, ageMax, gender, floors);
                        
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>index.php/caregiver/filterGroup", //filterGroup
                data: {
                    "ageMin": ageMin,
                    "ageMax": ageMax,
                    "gender": gender,
                    "floors": floors
                },
                dataType: "text",
                cache: false,

                success: function (data) {
                    console.log(data);
                    var response = JSON.parse(data);
                    //console.log(response);
                },
                        
                error: function() {
                    alert("Error")
                }
            });
            // clear global array
            floors = [];
        }
        /*
         function allowDrop(ev) {
         ev.preventDefault();
         }
         
         function drag(ev) {
         ev.dataTransfer.setData("Text", ev.target.id);
         }
         
         function drop(ev) {
         var data = ev.dataTransfer.getData("Text");
         ev.target.appendChild(document.getElementById(data));
         ev.preventDefault();
         }
         */
        //


    </script>
</head>

<div class="container-fluid">

    <button class="btn btn-success" onclick="add_group()"><i class="glyphicon glyphicon-plus"></i> Add Group</button>

    <!-- -->

    <div class="row">
        <?php foreach ($residents as $resident) { ?>   
            <div id="<?php echo ($resident->id); ?>" class="ui-widget-content">

                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 ">
                    <div class="panel panel-default">
                        <div class="panel-body">

                            <!--div id="drag" draggable="true" ondragstart="drag(event)"-->
                            <!--p value=<?php echo ($resident->id); ?>--> <?php echo ($resident->first_name); ?> </p>
                            <!--/div-->

                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>    
    </div>


    <div class ="col-xs-12"
         <div id="div1" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
    </div>

</div>

<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Group Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <div class="form-body">  

                        <!-- GENDER -->
                        <div class="form-group">
                            <label class="col-md-2">Gender</label>
                                <div class="radios">
                                    <div class="col-md-2">
                                        <div class="radio radio-primary">
                                            <label>
                                                Male
                                                <input type="radio" name="optionsRadios" id="optionMale" value="option1"<!--checked=""--><span class="circle"></span><span class="check"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="radio radio-primary">
                                            <label>
                                                Female
                                                <input type="radio" name="optionsRadios" id="optionFemale" value="option2"><span class="circle"></span><span class="check"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                        </div>

                        <!-- FLOOR -->   
                        <div class="form-group">
                            <label class="col-md-2">Floor</label>
                            <div class="col-md-10">
                                <form class="form-group" method="POST" id="floor_form" >
                                    <select class="form-control" id="floor" > <!-- multiple="multiple" expands the opts -->
                                        <?php foreach ($floors as $floor) { ?> 
                                        <option value= <?php
                                            $floor->floor_number;
                                            echo $floor->floor_number;          // key name in db
                                        ?> > <?php echo $floor->floor_number ?> </option>
                                        <?php } ?>   
                                    </select>
                                </form>
                            </div>                            
                        </div>

                        <!-- AGE -->
                        <div class="form-group">
                            <label class="col-md-2">Age</label>
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
                                    ~
                                    <span class="age-range" id="age-max"></span>
                                </div>
                            </div>

                        </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnFilter" onclick="filter()" class="btn btn-primary">Filter</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="button" id="btnAdd" onclick="save()" class="btn btn-success">Add</button>
            </div>
        </div>

    </div> 
</div> 
</div> 
