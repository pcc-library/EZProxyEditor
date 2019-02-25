window.$ = window.jQuery = require('jquery')
require('bootstrap');

$( document ).ready(function() {
    console.log($.fn.tooltip.Constructor.VERSION);
});
//
// $(function () {
//     $('[data-toggle="popover"]').popover()
// })