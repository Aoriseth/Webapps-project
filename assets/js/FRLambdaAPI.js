/**
 * This function is to add an image to a given(name & key ) album, the picture is to 
 * be giv"en with a dataURL and you also have to give the correct mashapekey
 * It reurns the answer of the API in a JSON format
 * @param {string} albumName
 * @param {string} albumKey
 * @param {string} entryID
 * @param {string} dataURLImage
 * @param {string} mashapeKey
 * @param {function} callback
 */
function addToAlbumFunc(albumName, albumKey, entryID, dataURLImage, mashapeKey, callback) {
    // make a form to send with the http-request
    if (albumName !== "" && albumKey !== "" && entryID !== "" && dataURLImage !== "" && mashapeKey !== "") {
        var fd = new FormData();
        fd.append("album", albumName);
        fd.append("albumkey", albumKey);
        fd.append("entryid", entryID);
        fd.append("files", dataURLtoBlob(dataURLImage));
        // send it to the correct URL
        $.ajax({
            url: "https://lambda-face-recognition.p.mashape.com/album_train",
            type: "POST",
            data: fd,
            processData: false,
            contentType: false,
            beforeSend: function (xhr) {
                // In the documentation of the API it is said you need more headers as this one
                // but when you do this it will give error for some reason, so don't do this
                xhr.setRequestHeader("X-Mashape-Key", mashapeKey);
                xhr.setRequestHeader("Accept", "application/json");                
            }
        }).always(function (result) {
            // This is the function which is called when the it's send it will always be called you also have a seperate function
            // .fail when it gives an error and .done when it does not give an error
            callback(result);
        });
    }
}
/**
 * This function will build the facemodels of the given album(name & key) also the correct
 * mashape key needs to be given
 * it will return the answer of the API in a JSON format
 * @param {string} albumName
 * @param {string} albumKey
 * @param {string} mashapeKey
 * @param {function} callback 
 */
function rebuildAlbumFunc(albumName, albumKey, mashapeKey, callback) {
    if (albumName !== "" && albumKey !== "" && mashapeKey !== "") {
        // Send it to the correct URL the albumname and albumkey needs to be added to the URL
        $.ajax({
            url: "https://lambda-face-recognition.p.mashape.com/album_rebuild?album=" + albumName + "&albumkey=" + albumKey,
            type: 'GET',
            data: "",
            processData: false,
            contentType: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader("X-Mashape-Key", mashapeKey);
                xhr.setRequestHeader("Accept", "application/json");
               
            }
        }).always(function (result) {
            if (callback && typeof (callback) === "function") {
                callback(result);
            }
        });
    }
}
/**
 * This function is to compare the given image(with dataURL) with the images
 * in the given album ( name & key) this with the correct mashapekey
 * this function will return the answer of the API this will be in a JSON format
 * @param {string} dataURLImage
 * @param {string} albumName
 * @param {string} albumKey
 * @param {string} mashapeKey
 * @param {function} callback 
 */
function recognizeFunc(dataURLImage, albumName, albumKey, mashapeKey, callback) {
    if (albumName !== "" && albumKey !== "" && dataURLImage !== "" && mashapeKey !== "") {
        var fd = new FormData();
        fd.append("files", dataURLtoBlob(dataURLImage));
        fd.append("album", albumName);
        fd.append("albumkey", albumKey);
        $.ajax({
            url: "https://lambda-face-recognition.p.mashape.com/recognize",
            type: "POST",
            data: fd,
            processData: false,
            contentType: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader("X-Mashape-Key", mashapeKey);
            }
        }).always(function (result) {
            if (callback && typeof (callback) === "function") {
                callback(result);
            }
        });
    }
}
/**
 * This function is to get al the information of a given album(name & key) with the correct mashapeKey
 * This returs the answer of the API which will be in a JSON-format
 * @param {string} albumName
 * @param {string} albumKey
 * @param {string} mashapeKey
 * @param {function} callback 
 */
function getAlbumFunc(albumName, albumKey, mashapeKey,callback) {
    if (albumName !== "" && albumKey !== "" && mashapeKey !== "") {
        $.ajax({
            url: "https://lambda-face-recognition.p.mashape.com/album?album=" + albumName + "&albumkey=" + albumKey,
            type: 'GET',
            data: "",
            processData: false,
            contentType: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader("X-Mashape-Key", mashapeKey);
                xhr.setRequestHeader("Accept", "application/json");
            }
        }).always(function (result) {
            if (callback && typeof (callback) === "function") {
                callback(result);
            }
        });
    }
}
/**
 * This function is to get information about one single entryid this can be selected
 * with the albumname,key & entryid next to this you also need a correct mashapekey
 * callback is the function that will be called when the answer is received
 * @param {string} albumname
 * @param {string} albumkey
 * @param {string} mashapekey
 * @param {string} entryid
 * @param {function} callback
 */
function getEntryID(albumname,albumkey,mashapekey,entryid,callback) {
    if(albumname!==""&&albumkey!==""&&mashapekey!==""&&entryid!==""){
        $.ajax({
          url: "https://lambda-face-recognition.p.mashape.com/album_train?album=" + albumname + "&albumkey=" + albumkey + "&entryid=" + entryid,
            type: 'GET',
            data: "",
            processData: false,
            contentType: false,
            beforeSend: function (xhr) {
                xhr.setRequestHeader("X-Mashape-Key", mashapekey);
                xhr.setRequestHeader("Accept", "application/json");
            }
        }).always(function (result) {
            if (callback && typeof (callback) === "function") {
                callback(result);
            }
        });
    }
    
}
/**
 * This function is used to create a new album with a given name you still need a valid mashapekey
 * This method will return the answer of the API in a JSON format
 * This will contain the albumKey which is vital to getting this album.
 * This function is written differently ( without jQuery this way you can see the headers and status if you want that
 * This can be done by commenting-In some lines
 * @param {string} albumname
 * @param {string} mashapeKey
 * @param {fuction} callback 
 */
function createAlbumFunc(albumname, mashapeKey,callback) {
    if (albumname !== "" && mashapeKey !== "") {
        // This function is done without JQuery so you guys can see how it's done maybe otherwise
        xhr = new XMLHttpRequest();
        var url = 'https://lambda-face-recognition.p.mashape.com/album';
        xhr.open("POST", url, true);
        xhr.setRequestHeader('X-Mashape-Key', mashapeKey);
        xhr.onreadystatechange = function () {
            if (this.readyState === 4) {
                //alert('Status:', this.status);
                //alert('Headers:', this.getAllResponseHeaders());
                if (callback && typeof (callback) === "function") {
                    callback(this.responseText);
                }
            }
        };
        var data = 'album=' + albumname;
        xhr.send(data);
    }
}

/**
 * This function is used to convert a dataURL of an image to a Blob-type
 * @param {string} dataUrl
 * @returns {Blob}
 */
function dataURLtoBlob(dataUrl) {
    if (dataUrl !== "") {
        // Decode the dataURL    
        var binary = atob(dataUrl.split(',')[1]);

        // Create 8-bit unsigned array
        var array = [];
        for (var i = 0; i < binary.length; i++) {
            array.push(binary.charCodeAt(i));
        }

        // Return our Blob object
        return new Blob([new Uint8Array(array)], {
            type: 'image/png'
        });
    }
}


