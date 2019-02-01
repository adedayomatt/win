ROOT = '';
$('document').ready(function(){

    $(function () {
    $('[data-toggle="tooltip"]').tooltip({
        html: true
    })
  });
$(function () {
    $('[data-toggle="popover"]').popover({
        html: true
    })
  });

    $('select').select2(); //use the select2 for all selects
})
