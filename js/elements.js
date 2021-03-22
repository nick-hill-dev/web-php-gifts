var $Button = /** @class */ (function () {
    function $Button(element) {
        this.element = null;
        this.element = element;
    }
    $Button.prototype.text = function (text) {
        this.element.textContent = text;
    };
    $Button.prototype.onClick = function (handler) {
        this.element.onclick = handler;
    };
    return $Button;
}());
var $Div = /** @class */ (function () {
    function $Div(element) {
        this.element = null;
        this.element = element;
    }
    $Div.prototype.clear = function () {
        while (this.element.firstChild) {
            this.element.removeChild(this.element.firstChild);
        }
    };
    $Div.prototype.add = function (element) {
        this.element.appendChild(element);
    };
    $Div.prototype.hide = function () {
        if (this.element.style.display != 'none') {
            this.element['$oldDisplay'] = this.element.style.display;
            this.element.style.display = 'none';
        }
    };
    $Div.prototype.show = function () {
        if (this.element.style.display == 'none') {
            var oldDisplay = this.element['$oldDisplay'];
            if (oldDisplay !== undefined) {
                this.element.style.display = oldDisplay;
                delete this.element['$oldDisplay'];
            }
            else {
                this.element.style.display = 'inline';
            }
        }
    };
    return $Div;
}());
function $new() {
    return new $New();
}
function $asButton(id) {
    var element = document.getElementById(id);
    return new $Button(element);
}
function $asDiv(id) {
    var element = document.getElementById(id);
    return new $Div(element);
}
function $asPanels(ids) {
    return new $Panels(ids);
}
function $asPanelsAuto(id) {
    var panels = new $Panels([]);
    var element = document.getElementById(id);
    for (var i = 0; i < element.childNodes.length; i++) {
        var childElement = element.childNodes[i];
        if (childElement.id !== undefined) {
            panels.ids.push(childElement.id);
        }
    }
    return panels;
}
function $asSelect(id) {
    var element = document.getElementById(id);
    return new $Select(element);
}
function $asInput(id) {
    var element = document.getElementById(id);
    return new $Input(element);
}
function $asRepeater(id) {
    var element = document.getElementById(id);
    return new $Repeater(element);
}
function asTable(id) {
    var element = document.getElementById(id);
    return new $Table(element);
}
var $Input = /** @class */ (function () {
    function $Input(element) {
        this.element = null;
        this.element = element;
    }
    $Input.prototype.getValue = function () {
        return this.element.value;
    };
    return $Input;
}());
var $New = /** @class */ (function () {
    function $New() {
    }
    $New.prototype.element = function (name) {
        return new $NewElement(name);
    };
    $New.prototype.anchor = function () {
        return new $NewAnchor();
    };
    $New.prototype.button = function () {
        return new $NewButton();
    };
    $New.prototype.checkBox = function () {
        return new $NewCheckBox();
    };
    $New.prototype.select = function () {
        return new $NewSelect();
    };
    $New.prototype.div = function () {
        return new $NewDiv();
    };
    $New.prototype.image = function () {
        return new $NewImage();
    };
    $New.prototype.input = function (type) {
        return new $NewInput(type);
    };
    $New.prototype.label = function () {
        return new $NewLabel();
    };
    $New.prototype.paragraph = function () {
        return new $NewParagraph();
    };
    $New.prototype.textBox = function () {
        return this.input('text');
    };
    $New.prototype.table = function () {
        return new $NewTable();
    };
    return $New;
}());
var $NewElement = /** @class */ (function () {
    function $NewElement(name) {
        this.element = null;
        this.element = document.createElement(name);
    }
    $NewElement.prototype.id = function (id) {
        this.element.id = id;
        return this;
    };
    $NewElement.prototype.className = function (className) {
        this.element.className = className;
        return this;
    };
    $NewElement.prototype.style = function (style) {
        this.element.setAttribute('style', style);
        return this;
    };
    $NewElement.prototype.then = function (f) {
        f(this.element);
        return this;
    };
    return $NewElement;
}());
/// <reference path="NewElement.ts" />
var __extends = (this && this.__extends) || (function () {
    var extendStatics = function (d, b) {
        extendStatics = Object.setPrototypeOf ||
            ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
            function (d, b) { for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p]; };
        return extendStatics(d, b);
    };
    return function (d, b) {
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
var $NewAnchor = /** @class */ (function (_super) {
    __extends($NewAnchor, _super);
    function $NewAnchor() {
        return _super.call(this, 'a') || this;
    }
    $NewAnchor.prototype.href = function (href) {
        this.element.href = href;
        return this;
    };
    $NewAnchor.prototype.js = function (onclick) {
        this.element.onclick = onclick;
        this.element.href = 'javascript:void(0);';
        return this;
    };
    $NewAnchor.prototype.content = function (text) {
        this.element.textContent = text;
        return this;
    };
    return $NewAnchor;
}($NewElement));
/// <reference path="NewElement.ts" />
var $NewButton = /** @class */ (function (_super) {
    __extends($NewButton, _super);
    function $NewButton() {
        return _super.call(this, 'button') || this;
    }
    $NewButton.prototype.asButton = function () {
        return new $Button(this.element);
    };
    $NewButton.prototype.text = function (text) {
        this.element.textContent = text;
        return this;
    };
    $NewButton.prototype.onClick = function (handler) {
        this.element.onclick = handler;
        return this;
    };
    return $NewButton;
}($NewElement));
/// <reference path="NewElement.ts" />
var $NewContainer = /** @class */ (function (_super) {
    __extends($NewContainer, _super);
    function $NewContainer(name) {
        return _super.call(this, name) || this;
    }
    $NewContainer.prototype.append = function (element) {
        this.element.appendChild(element);
        return this;
    };
    $NewContainer.prototype.elements = function (elements) {
        for (var i = 0; i < elements.length; i++) {
            this.element.appendChild(elements[i]);
        }
        return this;
    };
    return $NewContainer;
}($NewElement));
/// <reference path="NewContainer.ts" />
var $NewCheckBox = /** @class */ (function (_super) {
    __extends($NewCheckBox, _super);
    function $NewCheckBox() {
        var _this = _super.call(this, 'div') || this;
        _this.checkBoxElement = null;
        _this.labelElement = null;
        _this.checkBoxElement = $new().input('checkbox').element;
        _this.labelElement = $new().label().element;
        _this.append(_this.checkBoxElement);
        _this.append(_this.labelElement);
        return _this;
    }
    $NewCheckBox.prototype.containerID = function (id) {
        this.element.id = id;
        return this;
    };
    $NewCheckBox.prototype.id = function (id) {
        this.checkBoxElement.id = id;
        this.labelElement.htmlFor = id;
        return this;
    };
    $NewCheckBox.prototype.label = function (text) {
        this.labelElement.textContent = text;
        return this;
    };
    return $NewCheckBox;
}($NewContainer));
var $NewDiv = /** @class */ (function (_super) {
    __extends($NewDiv, _super);
    function $NewDiv() {
        return _super.call(this, 'div') || this;
    }
    $NewDiv.prototype.asDiv = function () {
        return new $Div(this.element);
    };
    return $NewDiv;
}($NewContainer));
var $NewImage = /** @class */ (function (_super) {
    __extends($NewImage, _super);
    function $NewImage() {
        return _super.call(this, 'img') || this;
    }
    $NewImage.prototype.title = function (title) {
        this.element.title = title;
        return this;
    };
    $NewImage.prototype.source = function (fileName) {
        this.element.src = fileName;
        return this;
    };
    return $NewImage;
}($NewElement));
var $NewInput = /** @class */ (function (_super) {
    __extends($NewInput, _super);
    function $NewInput(type) {
        var _this = _super.call(this, 'input') || this;
        _this.element.type = type;
        return _this;
    }
    $NewInput.prototype.asInput = function () {
        return new $Input(this.element);
    };
    $NewInput.prototype.name = function (name) {
        this.element.name = name;
        return this;
    };
    $NewInput.prototype.value = function (value) {
        this.element.value = value;
        return this;
    };
    $NewInput.prototype.placeholder = function (placeholder) {
        this.element.placeholder = placeholder;
        return this;
    };
    $NewInput.prototype.maxLength = function (maxLength) {
        this.element.maxLength = maxLength;
        return this;
    };
    return $NewInput;
}($NewElement));
var $NewLabel = /** @class */ (function (_super) {
    __extends($NewLabel, _super);
    function $NewLabel() {
        return _super.call(this, 'label') || this;
    }
    $NewLabel.prototype.content = function (text) {
        this.element.textContent = text;
        return this;
    };
    return $NewLabel;
}($NewElement));
var $NewParagraph = /** @class */ (function (_super) {
    __extends($NewParagraph, _super);
    function $NewParagraph() {
        return _super.call(this, 'p') || this;
    }
    $NewParagraph.prototype.content = function (text) {
        this.element.textContent = text;
        return this;
    };
    return $NewParagraph;
}($NewContainer));
/// <reference path="NewElement.ts" />
var $NewSelect = /** @class */ (function (_super) {
    __extends($NewSelect, _super);
    function $NewSelect() {
        return _super.call(this, 'select') || this;
    }
    $NewSelect.prototype.asSelect = function () {
        return new $Select(this.element);
    };
    $NewSelect.prototype.name = function (name) {
        this.element.name = name;
        return this;
    };
    $NewSelect.prototype.value = function (value) {
        this.element.value = value;
        return this;
    };
    $NewSelect.prototype.multiple = function (multiple) {
        this.element.multiple = multiple;
        return this;
    };
    $NewSelect.prototype.size = function (size) {
        this.element.size = size;
        return this;
    };
    $NewSelect.prototype.options = function (options) {
        $Select.setOptions(this.element, options);
        return this;
    };
    return $NewSelect;
}($NewElement));
var $NewTable = /** @class */ (function (_super) {
    __extends($NewTable, _super);
    function $NewTable() {
        return _super.call(this, 'table') || this;
    }
    $NewTable.prototype.asTable = function () {
        return new $Table(this.element);
    };
    return $NewTable;
}($NewElement));
var $Panels = /** @class */ (function () {
    function $Panels(ids) {
        this.ids = [];
        this.ids = ids;
    }
    $Panels.prototype.hide = function () {
        var ids = [];
        for (var _i = 0; _i < arguments.length; _i++) {
            ids[_i] = arguments[_i];
        }
        for (var _a = 0, ids_1 = ids; _a < ids_1.length; _a++) {
            var id = ids_1[_a];
            var element = document.getElementById(id);
            if (element.style.display != 'none') {
                element['$oldDisplay'] = element.style.display;
                element.style.display = 'none';
            }
        }
    };
    $Panels.prototype.hideAll = function () {
        for (var _i = 0, _a = this.ids; _i < _a.length; _i++) {
            var id = _a[_i];
            this.hide(id);
        }
    };
    $Panels.prototype.show = function () {
        var ids = [];
        for (var _i = 0; _i < arguments.length; _i++) {
            ids[_i] = arguments[_i];
        }
        for (var _a = 0, ids_2 = ids; _a < ids_2.length; _a++) {
            var id = ids_2[_a];
            var element = document.getElementById(id);
            if (element.style.display == 'none') {
                var oldDisplay = element['$oldDisplay'];
                if (oldDisplay !== undefined) {
                    element.style.display = oldDisplay;
                    delete element['$oldDisplay'];
                }
                else {
                    element.style.display = 'inline';
                }
            }
        }
    };
    $Panels.prototype.showAll = function () {
        for (var _i = 0, _a = this.ids; _i < _a.length; _i++) {
            var id = _a[_i];
            this.show(id);
        }
    };
    $Panels.prototype.showOnly = function () {
        var ids = [];
        for (var _i = 0; _i < arguments.length; _i++) {
            ids[_i] = arguments[_i];
        }
        this.hideAll();
        for (var _a = 0, ids_3 = ids; _a < ids_3.length; _a++) {
            var id = ids_3[_a];
            this.show(id);
        }
    };
    return $Panels;
}());
var $Repeater = /** @class */ (function () {
    function $Repeater(element) {
        this.element = null;
        this.template = null;
        this.element = element;
    }
    $Repeater.prototype.clear = function () {
        while (this.element.firstChild) {
            this.element.removeChild(this.element.firstChild);
        }
    };
    $Repeater.prototype.appendFromTemplate = function () {
        var currentLength = this.element.childNodes.length;
        var element = this.template(currentLength);
        this.element.appendChild(element);
        return element;
    };
    $Repeater.prototype.removeAt = function (index) {
        var child = this.element.childNodes[index];
        this.element.removeChild(child);
    };
    $Repeater.prototype.remove = function (element) {
        this.element.removeChild(element);
    };
    return $Repeater;
}());
var $Select = /** @class */ (function () {
    function $Select(element) {
        this.element = null;
        this.element = element;
    }
    $Select.prototype.clear = function () {
        this.element.options.length = 0;
    };
    $Select.prototype.options = function (options) {
        $Select.setOptions(this.element, options);
    };
    $Select.prototype.getSelectedValue = function () {
        var option = this.element.options[this.element.selectedIndex];
        return option.value;
    };
    $Select.prototype.addItem = function (value, text) {
        var option = document.createElement('option');
        option.value = value;
        option.textContent = text;
        this.element.appendChild(option);
    };
    $Select.prototype.setItem = function (value, text) {
        for (var i = 0; i < this.element.length; i++) {
            var option = this.element.options[i];
            if (option.value == value) {
                option.textContent = text;
                return;
            }
        }
        throw 'Could not set value of item "' + value + '" in the select element.';
    };
    $Select.prototype.removeItem = function (value) {
        for (var i = 0; i < this.element.length; i++) {
            if (this.element.options[i].value == value) {
                this.element.remove(i);
                return;
            }
        }
        throw 'Could not remove item "' + value + '" from the select element.';
    };
    $Select.prototype.values = function (values) {
        var oldValue = this.element.value;
        this.clear();
        for (var _i = 0, values_1 = values; _i < values_1.length; _i++) {
            var value = values_1[_i];
            this.addItem(value, value);
        }
        if (values.indexOf(oldValue) != -1) {
            this.element.value = oldValue;
        }
    };
    $Select.prototype.sortByText = function () {
        var options = this.element.options;
        var optionsArray = [];
        for (var i = 0; i < options.length; i++) {
            optionsArray.push(options[i]);
        }
        optionsArray = optionsArray.sort(function (a, b) {
            var left = a.textContent.toLowerCase();
            var right = b.textContent.toLowerCase();
            if (left < right) {
                return -1;
            }
            if (left > right) {
                return 1;
            }
            return 0;
        });
        for (var i = 0; i <= options.length; i++) {
            options[i] = optionsArray[i];
        }
    };
    $Select.setOptions = function (element, options) {
        for (var key in options) {
            var option = document.createElement('option');
            option.value = key;
            option.textContent = options[key];
            element.appendChild(option);
        }
    };
    return $Select;
}());
var $Table = /** @class */ (function () {
    function $Table(element) {
        this.element = null;
        this.activeRow = null;
        this.element = element;
    }
    $Table.prototype.newRow = function () {
        this.activeRow = document.createElement('tr');
        this.element.appendChild(this.activeRow);
        return this.activeRow;
    };
    $Table.prototype.newCell = function (content) {
        if (content === void 0) { content = undefined; }
        return new $TableRow(this.activeRow).newCell(content);
    };
    $Table.prototype.addRowStrings = function (values) {
        this.newRow();
        for (var _i = 0, values_2 = values; _i < values_2.length; _i++) {
            var value = values_2[_i];
            this.newCell(value);
        }
    };
    return $Table;
}());
var $TableRow = /** @class */ (function () {
    function $TableRow(element) {
        this.element = null;
        this.activeCell = null;
        this.element = element;
    }
    $TableRow.prototype.newCell = function (content) {
        if (content === void 0) { content = undefined; }
        this.activeCell = document.createElement('td');
        if (content != undefined) {
            if (typeof content == 'string') {
                this.activeCell.textContent = content;
            }
            else {
                for (var _i = 0, content_1 = content; _i < content_1.length; _i++) {
                    var child = content_1[_i];
                    this.activeCell.appendChild(child);
                }
            }
        }
        this.element.appendChild(this.activeCell);
        return this.activeCell;
    };
    return $TableRow;
}());
//# sourceMappingURL=elements.js.map