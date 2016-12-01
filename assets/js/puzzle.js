function loadPuzzle(base_url) {
    var image = new Image();
    var greyImage = new Image();
    var nrToDisplay = 3;
    var nrDisplayed = 0;
    image.src = base_url.concat('/assets/imgs/puzzle.jpg');
    
    (image.onload) = function(){
        greyImage.src = base_url.concat('/assets/imgs/grey.jpg');
    };
    
    greyImage.onload = function(){
        var canvas = document.getElementById("puzzle");
        var context = canvas.getContext("2d");
        var hRatio = canvas.width  / image.width;
        var vRatio =  canvas.height / image.height;
        var ratio  = Math.min ( hRatio, vRatio );
        var centerShift_x = ( canvas.width - image.width*ratio ) / 2;
        var centerShift_y = ( canvas.height - image.height*ratio ) / 2;

        for(var y = 0; y < 3; ++y) {
            for(var x = 0; x < 3; ++x) {
                if((Math.random() <= nrToDisplay/9 && nrDisplayed < nrToDisplay) || (9-(3*y+x)) <= nrToDisplay - (nrDisplayed)){
                    context.drawImage(image, x * (image.width / 3), y * (image.height / 3), (image.width / 3), (image.height / 3),
                    centerShift_x +( x * image.width * ratio)/3, centerShift_y + (y * image.height * ratio)/3, (image.width * ratio)/3, (image.height * ratio)/3);
                    nrDisplayed++;
                    //console.log("piece drawn" + y + x);
                }else{
                    context.drawImage(greyImage,
                    centerShift_x +( x * image.width * ratio)/3, centerShift_y + (y * image.height * ratio)/3, (image.width * ratio)/3, (image.height * ratio)/3);
                    //console.log("grey drawn "+ (9-(3*y+x)) + " " + nrToDisplay + " " + nrDisplayed);
                }
            }
        }
    };
}