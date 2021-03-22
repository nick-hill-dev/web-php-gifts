function $id(id) {
    return document.getElementById(id);
}
function $name(name) {
    var elements = document.getElementsByName(name);
    return elements.length == 0 ? null : elements[0];
}
function $names(name) {
    var result = [];
    var elements = document.getElementsByName(name);
    for (var i = 0; i < elements.length; i++) {
        result.push(elements[i]);
    }
    return result;
}
function $classes(name) {
    var result = [];
    var elements = document.getElementsByClassName(name);
    for (var i = 0; i < elements.length; i++) {
        result.push(elements[i]);
    }
    return result;
}
function $first(list, f, errorMessage) {
    if (errorMessage === void 0) { errorMessage = undefined; }
    for (var i in list) {
        var currentItem = list[i];
        if (f(currentItem)) {
            return currentItem;
        }
    }
    throw errorMessage === undefined ? 'Could not find the item.' : errorMessage;
}
function $firstOrNull(list, f) {
    for (var i in list) {
        var currentItem = list[i];
        if (f(currentItem)) {
            return currentItem;
        }
    }
    return null;
}
function $any(list, f) {
    for (var i in list) {
        var currentItem = list[i];
        if (f(currentItem)) {
            return true;
        }
    }
    return false;
}
function $all(list, f) {
    for (var i in list) {
        var currentItem = list[i];
        if (!f(currentItem)) {
            return false;
        }
    }
    return true;
}
function $where(list, f) {
    var result = [];
    for (var i in list) {
        var currentItem = list[i];
        if (f(currentItem)) {
            result.push(currentItem);
        }
    }
    return result;
}
function $min(list, f) {
    var first = true;
    var result = 0;
    for (var i in list) {
        var currentItem = list[i];
        if (first) {
            result = f(currentItem);
            first = false;
        }
        else {
            result = Math.min(result, f(currentItem));
        }
    }
    return result;
}
function $max(list, f) {
    var first = true;
    var result = 0;
    for (var i in list) {
        var currentItem = list[i];
        if (first) {
            result = f(currentItem);
            first = false;
        }
        else {
            result = Math.max(result, f(currentItem));
        }
    }
    return result;
}
function $sum(list, f) {
    var result = 0;
    for (var i in list) {
        var currentItem = list[i];
        result += f(currentItem);
    }
    return result;
}
function $select(list, f) {
    var result = [];
    for (var i in list) {
        var currentItem = list[i];
        var selection = f(currentItem);
        result.push(selection);
    }
    return result;
}
function $distinct(list, f) {
    var result = [];
    for (var i in list) {
        var currentItem = list[i];
        var currentValue = f(currentItem);
        if (result.indexOf(currentValue) == -1) {
            result.push(currentValue);
        }
    }
    return result;
}
function $notNullIf(item, f) {
    return f(item) ? item : null;
}
function $arrayToObject(list, keyName, valueName) {
    var result = [];
    for (var itemKey in list) {
        var itemValue = list[itemKey];
        var convertedItem = {};
        convertedItem[keyName] = itemKey;
        convertedItem[valueName] = itemValue;
        result.push(convertedItem);
    }
    return result;
}
//# sourceMappingURL=query.js.map