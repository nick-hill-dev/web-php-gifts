function $http(details, successCallback, errorCallback) {
    if (errorCallback === void 0) { errorCallback = null; }
    // Create a request
    var request = new XMLHttpRequest();
    request.open(details.method, details.url, true);
    if (details.contentType !== undefined) {
        request.setRequestHeader('Content-Type', details.contentType);
    }
    if (details.mimeType !== undefined) {
        request.overrideMimeType(details.mimeType);
    }
    request.onload = function (ev) {
        if (request.status == 200) {
            if (successCallback !== undefined && successCallback !== null) {
                successCallback(request.responseText);
            }
        }
        else {
            var message = details.method + ' failed with HTTP status code ' + request.status + ': "' + details.url + '".';
            if (errorCallback !== undefined && errorCallback !== null) {
                errorCallback(message);
            }
            else {
                throw message;
            }
        }
    };
    // Ensure we handle errors
    request.onerror = function (ev) {
        var message = details.method + ' failed due to network issue: "' + details.url + '".';
        if (errorCallback !== undefined && errorCallback !== null) {
            errorCallback(message);
        }
        else {
            throw message;
        }
    };
    // Send the request
    request.send(details.requestData);
}
function $httpGet(url, successCallback, errorCallback) {
    if (errorCallback === void 0) { errorCallback = null; }
    $http({ method: 'GET', url: url, mimeType: 'text/plain' }, successCallback, errorCallback);
}
function $httpGetImage(url, successCallback, errorCallback) {
    if (errorCallback === void 0) { errorCallback = null; }
    var image = new Image();
    image.onload = function (ev) {
        if (successCallback !== undefined && successCallback !== null) {
            successCallback(image);
        }
    };
    image.onerror = function (ev) {
        var message = 'GET image failed: "' + url + '".';
        if (errorCallback !== undefined && errorCallback !== null) {
            errorCallback(message);
        }
        else {
            throw message;
        }
    };
    image.src = url;
}
function $httpGetImages(urls, successCallback, errorCallback) {
    if (errorCallback === void 0) { errorCallback = null; }
    var i = 0;
    var successfulImages = [];
    var gotAnImage = function (image) {
        successfulImages.push(image);
        if (successfulImages.length == urls.length) {
            successCallback(successfulImages);
        }
        else {
            i++;
            $httpGetImage(urls[i], gotAnImage, errorCallback);
        }
    };
    if (urls.length == 0) {
        successCallback([]);
    }
    else {
        $httpGetImage(urls[i], gotAnImage, errorCallback);
    }
}
function $httpGetJson(url, successCallback, errorCallback) {
    if (errorCallback === void 0) { errorCallback = undefined; }
    $http({ method: 'GET', url: url, mimeType: 'application/json' }, function (responseData) {
        if (successCallback !== undefined && successCallback !== null) {
            var json = JSON.parse(responseData);
            successCallback(json);
        }
    }, errorCallback);
}
function $httpGetBinary(url, successCallback, errorCallback) {
    if (errorCallback === void 0) { errorCallback = null; }
    // Handle response
    var request = new XMLHttpRequest();
    request.open('GET', url, true);
    request.responseType = 'arraybuffer';
    request.onload = function (ev) {
        successCallback(request.response);
    };
    // Handle errors
    request.onerror = function (ev) {
        var message = 'GET binary failed: "' + url + '".';
        if (errorCallback !== undefined && errorCallback !== null) {
            errorCallback(message);
        }
        else {
            throw message;
        }
    };
    // Send the request    
    request.send();
}
function $httpPost(url, data, successCallback, errorCallback) {
    if (errorCallback === void 0) { errorCallback = undefined; }
    $http({ method: 'POST', url: url, requestData: data }, successCallback, errorCallback);
}
function $httpPostJson(url, data, successCallback, errorCallback) {
    if (errorCallback === void 0) { errorCallback = undefined; }
    var requestString = JSON.stringify(data);
    $http({ method: 'POST', url: url, requestData: requestString, contentType: 'application/json; charset=UTF-8' }, function (responseText) {
        if (successCallback !== undefined && successCallback !== null) {
            var responseJson = JSON.stringify(responseText);
            successCallback(responseJson);
        }
    }, errorCallback);
}
//# sourceMappingURL=http.js.map