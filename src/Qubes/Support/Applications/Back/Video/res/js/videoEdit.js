/**
 * Created by oke.ugwu on 20/08/13.
 */
$(function(){
  setTimeout(
    function(){
      console.log(duration);
      $('.frame:last .caption-time:last').val(duration);
      $('#new-caption-end').attr('max', duration);

    },
    3000
  )
});
