var questions;
var questionSet;
var index = 0;
var max;
var width;
var timeout;


// User has to be logged in as resident to be able to do this!
function storeAnswer(chosenOption, base_url, categoryName) {
    if (index < max) {
        var url = base_url + 'index.php/resident/question_store_answer';
        //console.log("chosenoption = " + chosenOption);
        //console.log("questionid:" + questionId);
        //console.log("baseurl:" + base_url);
        var data = {question_set: questionSet,
            chosen_option: chosenOption+1};/* In the database the chosenoptions start from 1 not from 0 */
        $.ajax({
            url: url,
            type: 'POST',
            data: JSON.stringify(data),
            dataType: "text",
            cache: false,
            processData: false
        }).always(function (result) {
            //console.log(JSON.stringify(result));
            /**
             * {category_id: categoryId,
             question_id: questionId,
             chosen_option: chosenOption}
             */

        });

        // modify the question
        index++;
        width = index / max * 100;
        console.log("width: " + width)
        $('#progressBar').css('width', width + "%");
        $('#progressBar').text(index + "/" + max);

        if (index < max) {

            $("#question_text").text("");
            $("#question_text").text(questions[index].question);
            questionSet = questions[index].question_set;

        } else {
            //$("#progress").effect( "bounce", {times:5,distance: 50}, 3 );
            timeout = setTimeout(function () {
                window.location.href = base_url + "index.php/resident/completed?category=" + categoryName;

            }, 1500);
        }
    }else{
        window.location.href = base_url + "index.php/resident/completed?category=" + categoryName;
    }
}
function loadQuestion(i) {
    // put all the questions in a variable and put them in the view
    questions = i;

    questionSet = questions[index].question_set;


    //question_text.innerHTML = questions[index].question;
    //$("#waarom_wil_dit_niet_werken").innerHTML = questions[index].question;
    max = questions.length;

    window.addEventListener("load", function () {
        $("#question_text").text(questions[index].question);
        //console.log($("#question_text").text());
        width = index / max * 100;
        $('#progressBar').css('width', width + "%");
        $('#progressBar').text(index + "/" + max);

    }, false);
}
function pressGoBack() {
    if (index > 0) {
        index--;
        window.clearTimeout(timeout)
        $("#question_text").text("");
        $("#question_text").text(questions[index].question);
        questionSet = questions[index].question_set;
        width = index / max * 100;
        $('#progressBar').css('width', width + "%");
        $('#progressBar').text(index + "/" + max);
    }
}


