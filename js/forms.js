/* global $ */

$(document).ready(function() {
    $('#datetime-btn').attr('disabled', true);
    $('[name="date"]').change(function() {
        if($(this).val().length != 0 || $('[name="time"]').val().length != 0)
            $('#datetime-btn').attr('disabled', false);            
        else
            $('#datetime-btn').attr('disabled', true);
    })
    $('[name="time"]').change(function() {
        if($(this).val().length != 0 || $('[name="date"]').val().length != 0)
            $('#datetime-btn').attr('disabled', false);            
        else
            $('#datetime-btn').attr('disabled', true);
    })
});