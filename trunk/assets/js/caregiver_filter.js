var nonLinearStepSlider;
var ageRange;
var ageMin;
var ageMax;
var gender = ""; // initialization
var floors = [];
var filter_residents;
var selected_residents = [];
var filter = [];

$( document ).ready(function() {
    //console.log( "base_url:"+base_url);
});

function clickAddGroup()
{
    //add_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    //$('.help-block').empty(); // clear error string, TODO
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Group'); // Set Title to Bootstrap modal title

    if (nonLinearStepSlider == null) {
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
}

function clickFilter(caregiverID)
{
    var url = base_url + 'index.php/caregiver/filterGroup';
    var caregiverID = caregiverID;
    // clear global array
    floors = [];
    filter = [];
    // TODO: warning if empty
    // GENDER
    if (document.getElementById('optionMale').checked) {
        gender = "male";
    } else if (document.getElementById('optionFemale').checked) {
        gender = "female";
    }

    // FLOOR
    var f = document.getElementById("floor");
    for (var i = 0; i < f.options.length; i++) {
        if (f.options[i].selected) {
            if (!(f.options[i].value in floors)) { // prevent duplicates
                floors.push(f.options[i].value);
            }
        }
    }

    // AGE
    nonLinearStepSlider.noUiSlider.on('update', function (values, handle) {
        if (handle === 0) {
            ageMin = parseInt(values[handle]);
        } else if (handle === 1) {
            ageMax = parseInt(values[handle]);
        }
    });
    //console.log("Filter:", ageMin, ageMax, gender, floors);
    filter.push(ageMin);
    filter.push(ageMax);
    filter.push(gender);
    filter.push(floors);

    $.ajax({
        type: "POST",
        url: base_url + 'index.php/caregiver/filterGroup',
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
            filter_residents = JSON.parse(data);
            console.log("caregiverID: ", caregiverID);
            result(filter_residents);
        },
        error: function () {
            alert("Error: filter")
        },
    });
}

function result(arg) {
    var filter_residents = arg;
    console.log("filter_residents:" );
    console.log(filter_residents);
    $('#result-list').html("<select class=\"form-control\" id=\"filter_resident\" \n\ multiple=\"multiple\"></select>");
    var options = "";
    if (filter_residents.length > 0) {
        document.getElementById('update_div').style.display = "block";
        for (filter_resident of filter_residents) {
            console.log(filter_resident.id, filter_resident.last_name);
            {
                options = "<option value = " + filter_resident.id + ">" + filter_resident.first_name + "</option>";
                $('#result-list select').append(options);
            }
            $("#result-list option").attr("selected", "selected");
        }
    } else {
        document.getElementById('update_div').style.display = "none"; // TODO: snackbar
    }
}

function clickSave(arg) {
    selected_residents = [];
    var f = document.getElementById("filter_resident");
    for (var i = 0; i < f.options.length; i++) {
        if (f.options[i].selected) {
            if (!(f.options[i].value in selected_residents)) { // prevent duplicates
                selected_residents.push(f.options[i].value);
            }
        }
    }
    
    console.log("selected_residents: " + selected_residents);
    console.log(selected_residents);
    
    $.ajax({
        type: "POST",
        url: base_url + 'index.php/caregiver/addGroup',
        data: {
            "selected_residents": selected_residents,
            "caregiverID": caregiverID,
            "filter": filter.toString()
        },
        dataType: "text",
        cache: false,

        success: function (data) {
            console.log(filter.toString());
        },
        error: function () {
            console.log("clickSaveJSON: " + selected_residents, caregiverID, filter.toString());
        },
    });
}

function test(arg)
{
    console.log(arg);
}