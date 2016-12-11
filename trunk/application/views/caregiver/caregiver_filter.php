
    <label class="col-md-2">Results</label>
    <div class="col-md-10">
        <form class="form-group" method="POST" id="floor_form" >
            <select class="form-control" id="floor" multiple="multiple"> <!-- multiple="multiple" expands the opts -->

                <div id="replace">
                    <?php foreach ($filter_residents as $filter_resident) { ?> 
                    <option value= <?php
                        $filter_resident->first_name;
                        echo $filter_resident->first_name;          // key name in db
                    ?> > <?php echo $filter_resident->first_name ?> </option>
                    <?php } ?>
                </div>

            </select>
        </form>
    </div>                            
