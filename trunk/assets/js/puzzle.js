
//resizes canvas and draws the pieces according to the array of booleans in 'categories'
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

        //resizing the canvas and calculate ratios
        var canvas = document.getElementById("puzzle");
        var context = canvas.getContext("2d");
        context.imageSmoothingEnabled = false;
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight * 0.8;
        var cheight = canvas.height;
        var cwidth = canvas.width;
        var iheight = image.height;
        var iwidth = image.width;
        for (var y = 0; y < 4; ++y) {
            for (var x = 0; x < 3; ++x) {
                if (x === 0 && y === 0 || categories[3 * y + x - 1] === 1) {
                    //first piece is always drawn, then it depends on the array 'categories'
                    context.drawImage(image, x * (iwidth / 3), y * (iheight / 4), (iwidth / 3), (iheight / 4),
                            (x * cwidth) / 3, (y * cheight) / 4, (cwidth) / 3, (cheight) / 4);
                } else {
                    //else purple piece with questionmark is drawn
                    context.drawImage(greyImage2,
                            (x * cwidth) / 3, (y * cheight) / 4, (cwidth) / 3, (cheight) / 4);
                    context.drawImage(greyImage,
                            (x * cwidth) / 3, (y * cheight) / 4, (cwidth) / 3, (cheight) / 4);
                }
            }
        }
    };
}

//resizes the canvas, calculates what piece was collected and draws it.
function loadPuzzlePiece(base_url, path, name, setID) {
    var image = new Image();
    if (path !== null && name !== null) {
        image.src = base_url + path + name;
    } else {
        image.src = base_url + "/assets/imgs/reserve.png";
    }
    (image.onload) = function () {
        //resize canvas
        var canvas = document.getElementById("puzzle");
        var context = canvas.getContext("2d");
        context.imageSmoothingEnabled = false;
        canvas.width = window.innerWidth / 3;
        canvas.height = window.innerHeight / 4;
        
        //calculate the x and y according to the setID.
        var x = ((parseInt(setID)) % 3);
        var y = ((parseInt(setID) - x) / 3);
        context.drawImage(image, x * (image.width / 3), y * (image.height / 4), (image.width / 3), (image.height / 4), 0, 0, canvas.width, canvas.height);
    };
}

//creates and resizes the canvases that contain all images.
//sets the images in the canvasses.
function loadGallery(base_url, data) {

    if (data !== null) {

        document.getElementById("slider").width = window.outerWidth;
        $('#slider').empty();
        for (var i = 0; i < data.length; i++) {
            var imgName = "slide" + i.toString();
            //add a list item to the ul, that has a canvas inside of it.
            $('#slider').append('<li style="display: block; float: none; position: absolute; opacity: 0; z-index: 2;"><canvas class="img-responsive" id="' + imgName + '"></canvas></li>');
            //resize canvas
            var canvas = document.getElementById(imgName);
            var context = canvas.getContext("2d");
            context.imageSmoothingEnabled = false;
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            var image = new Image();
            image.src = base_url + data[i]['picture_dir'] + data[i]['picture_name'];
            //this is an inner closure that creates an executable anonymous function. If this would not be done,
            //only the last image would be drawn.
            image.onload = (function (localCtx, localImg) {
                return function () {
                    localCtx.drawImage(localImg, 0, 0, canvas.width, canvas.height);
                };
            })(context, image);
        }
    } else {
        document.getElementById("no_pictures_message").style.visibility = 'visible';
    }
}
