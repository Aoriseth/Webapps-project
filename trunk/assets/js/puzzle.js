function loadPuzzle(base_url, path, name, categories) {

    var image = new Image();
    var greyImage = new Image();
    var greyImage2 = new Image();
    image.src = base_url + path + name;

    (image.onload) = function () {
        greyImage2.src = base_url.concat('/assets/imgs/673ab7.png');
        greyImage.src = base_url.concat('/assets/imgs/question-mark12.png');
    };

    greyImage.onload = function () {
        var canvas = document.getElementById("puzzle");
        var context = canvas.getContext("2d");
        context.imageSmoothingEnabled = false;
        context.canvas.width = window.innerWidth;
        context.canvas.height = window.innerHeight;
        var hRatio = canvas.width / image.width;
        var vRatio = canvas.height / image.height;
        var ratio = Math.min(hRatio, vRatio);
        var centerShift_x = (canvas.width - image.width * ratio) / 2;
        var centerShift_y = (canvas.height - image.height * ratio) / 2;

        for (var y = 0; y < 4; ++y) {
            for (var x = 0; x < 3; ++x) {
                //if((Math.random() <= nrToDisplay/12 && nrDisplayed < nrToDisplay) || (12-(3*y+x)) <= nrToDisplay - (nrDisplayed)){
                if (x === 0 && y === 0) {
                    context.drawImage(image, x * (image.width / 3), y * (image.height / 4), (image.width / 3), (image.height / 4),
                            centerShift_x + (x * image.width * ratio) / 3, centerShift_y + (y * image.height * ratio) / 4, (image.width * ratio) / 3, (image.height * ratio) / 4);
                } else if (categories[3 * y + x - 1] === 1) {
                    context.drawImage(image, x * (image.width / 3), y * (image.height / 4), (image.width / 3), (image.height / 4),
                            centerShift_x + (x * image.width * ratio) / 3, centerShift_y + (y * image.height * ratio) / 4, (image.width * ratio) / 3, (image.height * ratio) / 4);
                    //console.log("piece drawn" + y + x);
                } else {
                    context.drawImage(greyImage2,
                            centerShift_x + (x * image.width * ratio) / 3, centerShift_y + (y * image.height * ratio) / 4, (image.width * ratio) / 3, (image.height * ratio) / 4);
                    context.drawImage(greyImage,
                            centerShift_x + (x * image.width * ratio) / 3, centerShift_y + (y * image.height * ratio) / 4, (image.width * ratio) / 3, (image.height * ratio) / 4);
                    //console.log("grey drawn "+ (9-(3*y+x)) + " " + nrToDisplay + " " + nrDisplayed);
                }
            }
        }
    };
}


function loadGallery(base_url, data) {

// now get the first element:

    if (data !== null) {
        document.getElementById("slider").width = window.outerWidth;
        $('#slider').empty();
        for (var i = 0; i < data.length; i++) {
            $('#slider').append('<li id="centered-btns1_s0" style="display: block; float: none; position: absolute; opacity: 0; z-index: 2; transition: opacity 500ms ease-in-out 0s;" class="img-responsive" ><img class="img-responsive" id="slide' + i.toString() + '"></li>');

            var imgName = "slide" + i.toString();
            //console.log(data[0]['picture_dir']);
            document.getElementById(imgName).src = base_url + data[i]['picture_dir'] + data[i]['picture_name'];
            document.getElementById(imgName).width = document.getElementById("slider").width;
            
            console.log("height = " + window.innerHeight)
        }
    } else {
        document.getElementById("no_pictures_message").style.visibility = 'visible';
    }
}
