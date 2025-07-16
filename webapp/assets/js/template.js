$(document).ready(function () {
    Handlebars.registerHelper('getElementValue', function (array, index, value_name) {
        if (typeof array[index] !== 'undefined') {
            return array[index][value_name];
        }
        else {
            return '';
        }
    });

    Handlebars.registerHelper('isEquals', function (arg1, arg2, options) {
        return (arg1 == arg2) ? options.fn(this) : options.inverse(this);
    });

    Handlebars.registerHelper('isNotEquals', function (a, b, options) {
        if (a != b) { return options.fn(this); }
        return options.inverse(this);
    });

    Handlebars.registerHelper('notZero', function (arg, options) {
        return (arg && arg > 0) ? options.fn(this) : options.inverse(this);
    });
});