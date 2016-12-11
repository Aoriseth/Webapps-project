<head>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/9.0.0/nouislider.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/9.0.0/nouislider.min.css"></script>
    <script src="<?php echo base_url(); ?>assets/js/caregiver_filter.js" type="text/javascript"></script>

</head>

<div class="container-fluid">
    <button class="btn btn-success" onclick="add_group()"><i class="glyphicon glyphicon-plus"></i> Add Group</button>
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
    <div class ="col-xs-12">
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

                        <div class="modal-footer">
                            <button type="button" id="btnFilter" onclick="filter('<?php echo base_url() ?>', 'caregiverID')" class="btn btn-info">Filter</button>
                        </div>

                        <!-- RESULTS -->
                        <div class="form-group" id="update_div" style="display:none">
                            <!--{result}-->   
                            <label class="col-md-2">Results</label>
                                <div class="col-md-10">
                                 <form class="form-group" method="POST" id="floor_form" >
                                    <div id="result-list"></div>
                                     </form>
                                </div>  
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="button" id="btnAdd" onclick="save()" class="btn btn-info">Add</button>
            </div>
        </div>
    </div> 
</div> 
