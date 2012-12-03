$(document).ready(function() {
  $(".content").hide();
  $(".collapse").click(function()
  {
    $(this).next(".content").slideToggle(255);
  });
});

$(function() {
        $( "#datepicker" ).datepicker();
    });