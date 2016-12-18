<div class="panel container-fluid">
    <br />
    <button class="btn btn-success" onclick="add_person()"><i class="glyphicon glyphicon-plus"></i>Add Person</button>
    <button class="btn btn-info" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
    
    <div class="row">
        <div class="col-md-12">
            <div id="colvis"></div>
        </div>
    </div>

    <div class="table-responsive">
        <table  id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr> 
                    <?php
                        $tableheads = [
                            'ID', 'First Name', 'Last Name', 'Gender', 'Date of Birth',
                            'Floor Number', 'Room Number',
                            'Last Activity', 'Last Completed', 'Completed Sessions',
                            'Action'
                        ];
                        foreach ( $tableheads as $head ) {
                            echo '<th>'.$head.'</th>';
                        }
                    ?>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
                <tr>
                    <?php
                        foreach ( $tableheads as $head ) {
                            echo '<th>'.$head.'</th>';
                        }
                    ?>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-colvis/1.1.2/js/dataTables.colVis.js"></script>

<script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.bootstrap.js"></script>


<script type="text/javascript">
        //for save method string
        var save_method;
        var table;

        $(document).ready(function () {

            //datatables
            table = $('#table').DataTable({

                //Feature control the processing indicator.
                "processing": true,
                //Feature control DataTables' server-side processing mode.
                "serverSide": true,
                //Initial no order.
                "order": [],

                // Load data for the table's content from an Ajax source
                "ajax": {
                    "url": "<?php echo site_url('Sort/ajax_list') ?>",
                    "type": "POST"
                },

                //Set column definition initialisation properties.
                "columnDefs": [
                    {
                        "targets": [0], //last column
                        "orderable": false, //set not orderable
                    },
                ],

            });
        
          var colvis = new $.fn.dataTable.ColVis(table); //initial colvis
    $('#colvis').html(colvis.button()); //add colvis button to div with id="colvis"


            //datepicker
            $('.datepicker').datepicker({
                autoclose: true,
                format: "yyyy-mm-dd",
                todayHighlight: true,
                orientation: "top auto",
                todayBtn: true,
                todayHighlight: true,
            });

            //set input/textarea/select event when change value, remove class error and remove text help block 
            $("input").change(function () {
                $(this).parent().parent().removeClass('has-error');
                $(this).next().empty();
            });
            $("textarea").change(function () {
                $(this).parent().parent().removeClass('has-error');
                $(this).next().empty();
            });
            $("select").change(function () {
                $(this).parent().parent().removeClass('has-error');
                $(this).next().empty();
            });

        });
        


        function redirect(url){
            
            window.location.href = url;
        }
        function add_person()
        {
            save_method = 'add';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $('#modal_form').modal('show'); // show bootstrap modal
            $('.modal-title').text('Add Person'); // Set Title to Bootstrap modal title    

        }

        function edit_person(id)
        {
            save_method = 'update';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string

            //Ajax Load data from ajax
            $.ajax({
                url: "<?php echo site_url('Sort/ajax_edit/') ?>/" + id,
                type: "GET",
                dataType: "JSON",
                success: function (data)
                {

                    $('[name="id"]').val(data.id);
                    $('[name="first_name"]').val(data.first_name);
                    $('[name="last_name"]').val(data.last_name);
                    $('[name="gender"]').val(data.gender);
                    $('[name="password"]').val(data.password);
                    $('[name="date_of_birth"]').datepicker('update', data.date_of_birth);
                    $('[name="language"]').val(data.language);
                    $('[name="floor_number"]').val(data.floor_number);
                    $('[name="room_number"]').val(data.room_number);
                    $('[name="last_domicile"]').val(data.last_domicile);
                    $('[name="last_activity"]').datepicker('update', data.last_activity);
                    $('[name="last_completed"]').datepicker('update', data.last_completed);
                    $('[name="completed_sessions"]').val(data.completed_sessions);
                    $('[name="session_in_progress"]').val(data.session_in_progress);
                    $('[name="account_created_by"]').val(data.account_created_by);
                    $('[name="account_created_on"]').datepicker('update', data.account_created_on);


                    $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Edit Person'); // Set title to Bootstrap modal title



                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error get data from ajax');
                }
            });
        }

        function reload_table()
        {
            table.ajax.reload(null, false); //reload datatable ajax 
        }

        function save()
        {
            $('#btnSave').text('saving...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 


            var url;

            if (save_method == 'add') {
                url = "<?php echo site_url('Sort/ajax_add') ?>";
            } else {
                url = "<?php echo site_url('Sort/ajax_update') ?>";
            }

            // ajax adding data to database
            $.ajax({
                url: url,
                type: "POST",
                data: $('#form').serialize(),
                dataType: "JSON",
                success: function (data)
                {

                    if (data.status) //if success close modal and reload ajax table
                    {
                        $('#modal_form').modal('hide');
                        reload_table();
                    } else
                    {
                        for (var i = 0; i < data.inputerror.length; i++)
                        {
                            $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                            $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]); //select span help-block class set text error string
                        }
                    }
                    $('#btnSave').text('save'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable 


                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    //alert('Error adding / update data');
                    $('#modal_form').modal('hide');
                    $('#btnSave').text('save'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable 
                    reload_table();

                }
            });
        }

        function delete_person(id)
        {
            if (confirm('Are you sure delete this data?'))
            {
                // ajax delete data to database
                $.ajax({
                    url: "<?php echo site_url('Sort/ajax_delete') ?>/" + id,
                    type: "POST",
                    dataType: "JSON",
                    success: function (data)
                    {
                        //if success reload ajax table
                        $('#modal_form').modal('hide');
                        reload_table();
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error deleting data');
                    }
                });

            }
        }

</script>


<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Person Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                   
                    <div class="form-body">  
                        
                          <div class="form-group">
                            <label class="control-label col-md-3">ID</label>
                            <div class="col-md-9">
                                <input name="id" placeholder="r..." class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                          </div> 


                        <div class="form-group">
                            <label class="control-label col-md-3">First Name</label>
                            <div class="col-md-9">
                                <input name="first_name" placeholder="First Name" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Last Name</label>
                            <div class="col-md-9">
                                <input name="last_name" placeholder="Last Name" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Gender</label>
                            <div class="col-md-9">
                                <select name="gender" class="form-control">
                                    <option value="">--Select Gender--</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>                                    
                                </select>
                                <span class="help-block"></span>
                            </div>                            
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Password</label>
                            <div class="col-md-9">
                                <input name="password" placeholder="Password" class="form-control" type="password">
                                <span class="help-block"></span>
                            </div>
                        </div>  

                        <div class="form-group">
                            <label class="control-label col-md-3">Date of Birth</label>
                            <div class="col-md-9">
                                <input name="date_of_birth" placeholder="yyyy-mm-dd" class="form-control datepicker" type="">
                                <span class="help-block"></span>
                            </div>
                        </div> 

                     <div class="form-group">
                            <label class="control-label col-md-3">Language</label>
                            <div class="col-md-9">
                                <select name="Language" class="form-control">
                                    <option value="">--Select Language--</option>
                                    <option value="Nederlands">Nederlands</option>
                                    <option value="English">English</option>
                                    <option value="francais">Français</option>                                    
                                </select>
                                <span class="help-block"></span>
                            </div>                            
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Floor Number</label>
                            <div class="col-md-9">
                                <input name="floor_number" placeholder="Floor Number" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Room Number</label>
                            <div class="col-md-9">
                                <input name="room_number" placeholder="Room Number" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="control-label col-md-3">Last Domicile</label>
                            <div class="col-md-9">
                                <input name="last_domicile" placeholder="Last Domicile" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                          <input name="last_activity" placeholder="" class="form-control" type="hidden" value="null">
                          
                           <input name="last_completed" placeholder="" class="form-control" type="hidden" value="null">
                           
                           <input name="completed_sessions" placeholder="" class="form-control" type="hidden" >
                           
                           <input name="session_in_progress" placeholder="" class="form-control" type="hidden">
                          
                          
                         <div class="form-group">
                            <label class="control-label col-md-3">type</label>
                            <div class="col-md-9">
                                <select name="type" class="form-control">
                                    <option value="">--Select type--</option>
                                    <option value="resident">resident</option>
                                    <option value="caregiver">caregiver</option>                                                                       
                                </select>
                                <span class="help-block"></span>
                            </div>                            
                        </div>
                                                 
                        <input name="account_created_by" placeholder="" class="form-control" type="hidden" >
                                                                                              
                        <input name="account_created_on" placeholder="" class="form-control" type="hidden" value="">
                                          
                        <input name="profile_picture_id" placeholder="" class="form-control" type="hidden" value="null">
                             
                           

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-success">Save</button>
                <button type="button" class="btn  btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div> 
    </div> 
</div> 
