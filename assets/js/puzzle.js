function loadPuzzle(base_url, path, name, categories) {

    var image = new Image();
    var greyImage = new Image();
    var greyImage2 = new Image();
    if (path !== null && name !== null) {
        image.src = base_url + path + name;
    } else {
        image.src = base_url + "/assets/imgs/reserve.png";
    }
    (image.onload) = function () {
        greyImage2.src = base_url.concat('/assets/imgs/673ab7.png');
        greyImage.src = base_url.concat('/assets/imgs/question-mark12.png');
    };

    greyImage.onload = function () {
        var canvas = document.getElementById("puzzle");
        var context = canvas.getContext("2d");
        context.imageSmoothingEnabled = false;
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight * 0.8;
        var hRatio = canvas.width / image.width;
        var vRatio = canvas.height / image.height ;

        for (var y = 0; y < 4; ++y) {
            for (var x = 0; x < 3; ++x) {
                if (x === 0 && y === 0) {
                    context.drawImage(image, x * (image.width / 3), y * (image.height / 4), (image.width / 3), (image.height / 4),
                            (x * image.width * hRatio) / 3, (y * image.height * vRatio) / 4, (image.width * hRatio) / 3, (image.height * vRatio) / 4);
                } else if (categories[3 * y + x - 1] === 1) {
                    context.drawImage(image, x * (image.width / 3), y * (image.height / 4), (image.width / 3), (image.height / 4),
                            (x * image.width * hRatio) / 3, (y * image.height * vRatio) / 4, (image.width * hRatio) / 3, (image.height * vRatio) / 4);
                    //console.log("piece drawn" + y + x);
                } else {
                    context.drawImage(greyImage2,
                            (x * image.width * hRatio) / 3, (y * image.height * vRatio) / 4, (image.width * hRatio) / 3, (image.height * vRatio) / 4);
                    context.drawImage(greyImage,
                            (x * image.width * hRatio) / 3, (y * image.height * vRatio) / 4, (image.width * hRatio) / 3, (image.height * vRatio) / 4);
                }
            }
        }
    };
}

function loadPuzzlePiece(base_url, path, name, setID) {
    var image = new Image();
    if (path !== null && name !== null) {
        image.src = base_url + path + name;
    } else {
        image.src = base_url + "/assets/imgs/reserve.png";
    }
    (image.onload) = function () {
        var canvas = document.getElementById("puzzle");
        var context = canvas.getContext("2d");
        context.imageSmoothingEnabled = false;
        canvas.width = window.innerWidth / 3;
        canvas.height = window.innerHeight / 4;

        var x = ((parseInt(setID)) % 3);
        var y = ((parseInt(setID) - x) / 3);

        context.drawImage(image, x * (image.width / 3), y * (image.height / 4), (image.width / 3), (image.height / 4), 0, 0, canvas.width, canvas.height);
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
        }
    } else {
        document.getElementById("no_pictures_message").style.visibility = 'visible';
    }
}
