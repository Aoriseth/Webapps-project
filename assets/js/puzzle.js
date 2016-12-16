function loadPuzzle(base_url, path, name, categories) {
    
//    var url = base_url + 'index.php/Resident/getPuzzle';
//    $.ajax({
//		type: "POST",
//		url: url,
//		dataType: "text",
//		cache: false,
//	})
//        .done( function (data) {
//            console.log(data);
//		var response = JSON.parse( data );
//
//
//	})
//	.fail( function ( jqXHR, textStatus, errorThrown ) {
//		// display error message
//                console.log('error');
//	});

    var image = new Image();
    var greyImage = new Image();
    image.src = base_url + path + name;
	
    (image.onload) = function(){
        greyImage.src = base_url.concat('/assets/imgs/grey.jpg');
    };
    
    greyImage.onload = function(){
        var canvas = document.getElementById("puzzle");
        var context = canvas.getContext("2d");
        context.canvas.width  = window.innerWidth;
        context.canvas.height = window.innerHeight;
        var hRatio = canvas.width  / image.width;
        var vRatio =  canvas.height / image.height;
        var ratio  = Math.min ( hRatio, vRatio );
        var centerShift_x = ( canvas.width - image.width*ratio ) / 2;
        var centerShift_y = ( canvas.height - image.height*ratio ) / 2;

        for(var y = 0; y < 4; ++y) {
            for(var x = 0; x < 3; ++x) {
                //if((Math.random() <= nrToDisplay/12 && nrDisplayed < nrToDisplay) || (12-(3*y+x)) <= nrToDisplay - (nrDisplayed)){
                if( x === 0 && y === 0){
                    context.drawImage(image, x * (image.width / 3), y * (image.height / 4), (image.width / 3), (image.height / 4),
                    centerShift_x +( x * image.width * ratio)/3, centerShift_y + (y * image.height * ratio)/4, (image.width * ratio)/3, (image.height * ratio)/4);
                }else if(categories[3*y + x - 1] === 1){
                    context.drawImage(image, x * (image.width / 3), y * (image.height / 4), (image.width / 3), (image.height / 4),
                    centerShift_x +( x * image.width * ratio)/3, centerShift_y + (y * image.height * ratio)/4, (image.width * ratio)/3, (image.height * ratio)/4);
                    //console.log("piece drawn" + y + x);
                }else{
                    context.drawImage(greyImage,
                    centerShift_x +( x * image.width * ratio)/3, centerShift_y + (y * image.height * ratio)/4, (image.width * ratio)/3, (image.height * ratio)/4);
                    //console.log("grey drawn "+ (9-(3*y+x)) + " " + nrToDisplay + " " + nrDisplayed);
                }
            }
        }
    };
}
