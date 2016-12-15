<head>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/9.0.0/nouislider.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/9.0.0/nouislider.min.css"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/caregiver_filter.js"></script>
    <script type="text/javascript">
        var base_url = "<?php Print(base_url()); ?>"; 
        var caregiverID = "<?php Print($caregiverID); ?>"; 
    </script>
</head>

<div class="panel container-fluid">
    <button class="btn btn-success" onclick="clickAddGroup()"><i class="glyphicon glyphicon-plus"></i> Add Group</button>
    <div class="panel-group" id="accordion">
        <?php 
        $group_id = -1;
        $resident_id = -1;
        foreach ($groups as $group) { 
            $resident_id = $group->resident_id;
            $duplicate = ($group_id == $group->group_id);
                if ($duplicate==FALSE) { 
                    $group_id = $group->group_id; ?> 
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $group_id ?>"><?php echo $group_id ?></a>
                            </h4>
                        </div>
                        <div id="collapse<?php echo $group_id ?>" class="panel-collapse collapse">
                <?php } ?>
                        <div class="panel-body"><?php echo $resident_id ?></div> 
                <?php 
                $mode = current($groups);
                $mode = next($groups);
                ///echo serialize($mode);
                if(!empty($mode)){
                    if ($mode->group_id != $group_id) { ?>  
                            </div>
                        </div>
                <?php }} ?> 
        <?php } ?>   
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
                    <!--div class="form-body"-->  

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
                                <!--form class="form-group" method="POST" id="floor_form"-->
                                    <select class="form-control" id="floor" > <!-- multiple="multiple" expands the opts -->
                                        <?php foreach ($floors as $floor) { ?> 
                                            <option value= <?php
                                            $floor->floor_number;
                                            echo $floor->floor_number;          // key name in db
                                            ?> > <?php echo $floor->floor_number ?> </option>
                                         <?php } ?>   
                                    </select>
                                <!--/form-->
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
                                    -
                                    <span class="age-range" id="age-max"></span>
                                </div>
                            </div>
                        </div>
                            
                        

                        <!-- RESULTS -->
                        <div class="form-group" id="update_div" style="display:none">
                            <!--{result}-->   
                            <label class="col-md-2">Results</label>
                            <div class="col-md-10">
                                <!--form class="form-group" method="POST" id="floor_form"-->
                                    <div id="result-list">
                                    </div>
                                <!--/form-->
                            </div>  
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-info" id="btnFilter" onclick="clickFilter(caregiverID)">
                                <i class="glyphicon glyphicon-filter"></i> Filter</button>
                            <button type="button" class="btn btn-info" id="btnAdd" onclick="clickSave()">Add</button>
                        </div>
                        
                    <!--/div-->
                </form>
            </div> <!--class="modal-body form"-->
        </div> <!--class="modal-content"-->
    </div> 
</div> 
