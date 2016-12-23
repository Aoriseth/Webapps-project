<div class="panel container-fluid">
    <br>
    <p class="tlScale">Overzicht van alle bewoners</p>
    <hr>
    <button class="btn btn-success" onclick="add_person()"><i class="glyphicon glyphicon-plus"></i> <?= lang( 'c_overview_add_person' ); ?></button>
    <button class="btn btn-info" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> <?= lang( 'c_overview_reload' ); ?></button>
    
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
                            lang( 'c_overview_id' ),
                            lang( 'c_overview_first_name' ),
                            lang( 'c_overview_last_name' ),
                            lang( 'c_overview_gender' ),
                            lang( 'c_overview_date_of_birth' ),
                            lang( 'c_overview_floor' ),
                            lang( 'c_overview_room' ),
                            lang( 'c_overview_last_activity' ),
                            lang( 'c_overview_last_completed_session' ),
                            lang( 'c_overview_amount_of_sessions' ),
                            lang( 'c_overview_action' ),
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

<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-colvis/1.1.2/js/dataTables.colVis.js"></script>

<script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.bootstrap.js"></script>


<script type="text/javascript">
    //for save method string
    var save_method;
    var table;

    $(document).ready(function() {

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

    function add_person() {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Add Person'); // Set Title to Bootstrap modal title    
    }

    function edit_person(id) {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('Sort/ajax_edit/') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
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
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    function reload_table() {
        table.ajax.reload(null, false); //reload datatable ajax 
    }

    function save() {
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
//        if (confirm('Are you sure you want to delete this person?'))
        if (confirm('Ben je zeker dat je deze persoon wilt verwijderen?'))
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
                            <label class="control-label col-md-3"><?= lang( 'c_overview_id' ) ?></label>
                            <div class="col-md-9">
                                <input name="id" placeholder="r..." class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div> 

                        <div class="form-group">
                            <label class="control-label col-md-3"><?= lang( 'c_overview_first_name' ) ?></label>
                            <div class="col-md-9">
                                <input name="first_name" placeholder="<?= lang( 'c_overview_first_name' ) ?>" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3"><?= lang( 'c_overview_last_name' ) ?></label>
                            <div class="col-md-9">
                                <input name="last_name" placeholder="<?= lang( 'c_overview_last_name' ) ?>" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3"><?= lang( 'c_overview_gender' ) ?></label>
                            <div class="col-md-9">
                                <select name="gender" class="form-control">
                                    <option value="">---</option>
                                    <option value="Male"><?= lang( 'c_overview_gender_male' ) ?></option>
                                    <option value="Female"><?= lang( 'c_overview_gender_female' ) ?></option>
                                    <option value="Other"><?= lang( 'c_overview_gender_other' ) ?></option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3"><?= lang( 'c_overview_password' ) ?></label>
                            <div class="col-md-9">
                                <input name="password" placeholder="<?= lang( 'c_overview_password' ) ?>" class="form-control" type="password">
                                <span class="help-block"></span>
                            </div>
                        </div>  

                        <div class="form-group">
                            <label class="control-label col-md-3"><?= lang( 'c_overview_date_of_birth' ) ?></label>
                            <div class="col-md-9">
                                <input name="date_of_birth" placeholder="yyyy-mm-dd" class="form-control datepicker" type="">
                                <span class="help-block"></span>
                            </div>
                        </div> 

                        <div class="form-group">
                            <label class="control-label col-md-3"><?= lang( 'c_overview_language' ) ?></label>
                            <div class="col-md-9">
                                <select name="Language" class="form-control">
                                    <option value="">---</option>
                                    <option value="English"><?= lang( 'c_overview_language_english' ) ?></option>
                                    <option value="francais"><?= lang( 'c_overview_language_francais' ) ?></option>
                                    <option value="Nederlands"><?= lang( 'c_overview_language_nederlands' ) ?></option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3"><?= lang( 'c_overview_floor' ) ?></label>
                            <div class="col-md-9">
                                <input name="floor_number" placeholder="<?= lang( 'c_overview_floor' ) ?>" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3"><?= lang( 'c_overview_room' ) ?></label>
                            <div class="col-md-9">
                                <input name="room_number" placeholder="<?= lang( 'c_overview_room' ) ?>" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                         <div class="form-group">
                            <label class="control-label col-md-3"><?= lang( 'c_overview_domicile' ) ?></label>
                            <div class="col-md-9">
                                <input name="last_domicile" placeholder="<?= lang( 'c_overview_domicile' ) ?>" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <input name="last_activity" placeholder="" class="form-control" type="hidden" value="null">

                        <input name="last_completed" placeholder="" class="form-control" type="hidden" value="null">

                        <input name="completed_sessions" placeholder="" class="form-control" type="hidden" >

                        <input name="session_in_progress" placeholder="" class="form-control" type="hidden">

                        <div class="form-group">
                            <label class="control-label col-md-3"><?= lang( 'c_overview_type' ) ?></label>
                            <div class="col-md-9">
                                <select name="type" class="form-control">
                                    <option value="">---</option>
                                    <option value="resident"><?= lang( 'c_overview_type_resident' ) ?></option>
                                    <option value="caregiver"><?= lang( 'c_overview_type_caregiver' ) ?></option>
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
                <button type="button" class="btn  btn-danger" data-dismiss="modal"><?= lang( 'common_cancel' ) ?></button>
                <button type="button" id="btnSave" onclick="save()" class="btn btn-success"><?= lang( 'common_save' ) ?></button>
            </div>
        </div>
    </div>
</div>
