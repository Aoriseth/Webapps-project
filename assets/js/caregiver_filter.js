var nonLinearStepSlider;
var ageRange;
var ageMin;
var ageMax;
var gender = ""; // initialization
var floors = [];
var filter_residents = [];
var update_div = $('#update_div');
var results = $('#results');
var code = "";

/*
(function () {
    <?php foreach ($residents as $resident) { ?>
        $("#<?php echo ($resident->id); ?>").draggable(); //TODO
    <?php }; ?>
});
*/
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

function filter(base_url, caregiverID)
{
    var url = base_url + 'index.php/caregiver/filterGroup';
    var caregiverID = caregiverID;
    // clear global array
    floors = [];
    filter_residents = [];
    // TODO: warning if empty
    console.log('--- function filter() ---');
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
        url: url, 
        data: {
            "ageMin": ageMin,
            "ageMax": ageMax,
            "gender": gender,
            "floors": floors[0]
        },
        dataType: "text",
        cache: false,

        success: function (data) {
            //console.log("Filter:", ageMin, ageMax, gender, floors[0]);
            var filter_residents = JSON.parse(data);
            //console.log("filter_residents:", filter_residents);
            code = "";
            for (filter_resident of filter_residents) {
                console.log(filter_resident.first_name, filter_resident.last_name);
                code += "<select class=\"form-control\" id=\"filter_resident\" multiple=\"multiple\"> \n\
                <option value = \"" + filter_resident.first_name +"\">" +filter_resident.first_name + "</option>\n\n\
                </select>";
            }
            console.log("caregiverID: ", caregiverID);
            //$('#update_div').replaceWith($(data["filter_residents"]));
            //$('#update_div').replaceWith($(data['filter_residents']));
            //results.html(code);
            replace();
        },
        error: function() {
            alert("Error")
        },
    });
}

function replace(){

    document.getElementById('update_div').style.display = "block";
    //document.getElementById("results").innerHTML = (code);
    /*
    var para = document.createElement("div");
var node = document.createTextNode(code);
para.appendChild(node);
var element = document.getElementById("results");
element.appendChild(para);*/
    /*console.log("code: ", code);
    document.getElementById('results').innerHTML = 'results';*/

               /*         var test = "<option value = \"Lucas\">Lucas</option>";
            $('#floor').html("code");
            $('#results').html("code");

*/
    //console.log(filter_residents);
    for (filter_resident of filter_residents) {
        //document.getElementById('theDiv').innerHTML += (filter_resident + " ");
        console.log(filter_resident);
        //document.getElementById('replace').write(filter_resident);

    }
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


