new WOW().init();

(function($) {
"use strict";
    // colorpicker js
    var color_picker6 = document.getElementById("ColorPicker6").value;
    document.getElementById("ColorPicker6").onchange = function() {
        color_picker6 = this.value;
        document.documentElement.style.setProperty('--theme-default6', color_picker6);
    };

    var color_picker7 = document.getElementById("ColorPicker7").value;
    document.getElementById("ColorPicker7").onchange = function() {
        color_picker7 = this.value;
        document.documentElement.style.setProperty('--theme-default7', color_picker7);
        };
})(jQuery);


document.getElementById('pwd-icon1').onclick = function() {
    if( this.classList.contains(open) ) {
    eleother.type="password";
    this.classList.remove(open);
    this.className += ' '+close;
    } else {
    eleother.type="text";
    this.classList.remove(close);
    this.className += ' '+open;
    }
}