/**
 * Created by oke.ugwu on 23/08/13.
 */

$(function(){
  $('.iconpicker').click(function(){
    var popup = $(this).parent().parent().find('.iconpicker-popup');
    popup.toggle();
  });

  $(".iconlist li").click(function()
  {
    var picker = $(this).parents(".iconpicker-wrapper");
    var input = $("#" + picker.data("picker-id"));
    input.val($(this).attr("class"));
  });

  $('.iconpicker-popup').mouseleave(function(){
    $(this).hide();
  });
})

