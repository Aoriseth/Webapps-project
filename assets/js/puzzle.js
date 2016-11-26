window.onload = function() {
    var image = new Image();
    var greyImage = new Image();
    var nrToDisplay = 3;
    var nrDisplayed = 0;
    image.src = 'https://a16_webapps_3.studev.groept.be/assets/imgs/puzzle.jpg';
    greyImage.src = 'https://a16_webapps_3.studev.groept.be/assets/imgs/grey.jpg';
    var canvas = document.getElementById("puzzle");
    var context = canvas.getContext("2d");
    var hRatio = canvas.width  / image.width    ;
    var vRatio =  canvas.height / image.height  ;
    var ratio  = Math.min ( hRatio, vRatio );
    var centerShift_x = ( canvas.width - image.width*ratio ) / 2;
    var centerShift_y = ( canvas.height - image.height*ratio ) / 2;
    
    for(var y = 0; y < 3; ++y) {
        for(var x = 0; x < 3; ++x) {
            if((Math.random() <= nrToDisplay/9 && nrDisplayed < nrToDisplay) || 9-3*(y+1)+x+1 <= nrToDisplay - nrDisplayed){
                context.drawImage(image, x * (image.width / 3), y * (image.height / 3), (image.width / 3), (image.height / 3),
                centerShift_x +( x * image.width * ratio)/3, centerShift_y + (y * image.height * ratio)/3, (image.width * ratio)/3, (image.height * ratio)/3);
                nrDisplayed++;
            }else{
                context.drawImage(greyImage,
                centerShift_x +( x * image.width * ratio)/3, centerShift_y + (y * image.height * ratio)/3, (image.width * ratio)/3, (image.height * ratio)/3);
            }
        }
    }
};