new WOW().init();
(function($) {
    "use strict";
    // colorpicker js
    var color_picker3 = document.getElementById("ColorPicker3").value;
    document.getElementById("ColorPicker3").onchange = function() {
        color_picker3 = this.value;
        document.documentElement.style.setProperty('--theme-default3', color_picker3);
    };

    var color_picker4 = document.getElementById("ColorPicker4").value;
    document.getElementById("ColorPicker4").onchange = function() {
        color_picker4 = this.value;
        document.documentElement.style.setProperty('--theme-default4', color_picker4);
    };
})(jQuery);