/**
 * Created by oke.ugwu on 21/08/13.
 */
var duration = 0;
$(function(){
  $('table.caption-control').on('change', '.caption-time', function(){

    var idAttr = $(this).attr('id');
    var frameId = getId(idAttr);

    var startFrame = $('#start-frame-'+frameId);
    var endFrame = $('#end-frame-'+frameId);

    var targetFrameId = 0;
    var startVal = parseInt(startFrame.val(), 10);
    var endVal = parseInt(endFrame.val(), 10);

    if(idAttr.substr(0,11) == 'start-frame')
    {
      console.log('1. start-frame changed');
      targetFrameId = frameId - 1;

      if(startVal >= endVal)
      {
        console.log('1. invalid operation: start cannot be greater than end');
        startFrame.val(startVal-1);
      }

      if($('#start-frame-'+targetFrameId).val() == undefined)
      {
        console.log('1. no frame above frame')
      }
      validateEndFrame(targetFrameId)
    }
    else
    {
      console.log('2. end-frame changed');
      targetFrameId = frameId + 1;
      if(startVal >= endVal)
      {
        console.log('2. invalid operation: start cannot be greater than end');

        //fix end value - force it to a value greater than start
        endFrame.val(startVal+1);
        endVal = startVal+1;
      }

      if($('#start-frame-'+targetFrameId).val() == undefined)
      {
        createFrame(targetFrameId);
      }
      validateStartFrame(targetFrameId);
    }

  });


  function validateEndFrame(prevFrameId)
  {
    //get end value of the frame above
    var endFrame = $('#end-frame-'+prevFrameId);
    var endVal = parseInt(endFrame.val(),10);

    //get start value of the current frame
    var currFrameId = prevFrameId+1;
    var currStartFrame = $('#start-frame-'+currFrameId);
    var currStartVal = parseInt(currStartFrame.val(),10);

    if(currStartVal < endVal)
    {
      console.log('1. invalid operation:');
      console.log(currStartVal+' < '+endVal);

      //recover from invalid operation
      currStartFrame.val(currStartVal+1);
    }
  }

  function validateStartFrame(nextFrameId)
  {
    //get start value of the frame below
    var startFrame = $('#start-frame-'+nextFrameId);
    var startVal = parseInt(startFrame.val(),10);

    //get end value of the current frame
    var currFrameId = nextFrameId-1;
    var currEndFrame = $('#end-frame-'+currFrameId);
    var currEndVal = parseInt(currEndFrame.val(),10);

    if(currEndVal > startVal)
    {
      console.log('2. invalid operation:');
      console.log(currEndVal+' > '+startVal);

      //recover from invalid operation
      currEndFrame.val(currEndVal-1);
    }
  }

  function createFrame(frameId)
  {
    $('.frame:last').after(
      '<tr class="frame">' +
         '<td>' +
          '<input type="number" name="_caption['+frameId+'][start]" class="caption-time input-mini"  id="start-frame-'+frameId+'" value="0" min="0" step="any"/>' +
          ' - ' +
          '<input type="number" name="_caption['+frameId+'][end]" class="caption-time input-mini"  id="end-frame-'+frameId+'" value="0" min="0" step="any"/>' +
          '</td>' +
          '<td>' +
          '<textarea name="_caption['+frameId+'][text]" id="caption-text-'+frameId+'" cols="180" style="width:96%" rows="1"></textarea>' +
          '</td>' +
      '</tr>'
    );

    var currFrameId = frameId - 1;
    var newVal = parseInt($('#end-frame-'+currFrameId).val(), 10)+4;
    $('#start-frame-'+frameId).val(newVal);
    $('#end-frame-'+frameId).val(duration);
  }


  function getId(frameId)
  {
    var id = frameId.split('-')[2];
    return parseInt(id, 10);
  }

  $('.seek').click(function(){
    var player = jwplayer($(this).data('video'));
    player.seek($(this).data('time'));
  });

  //wait 3 seconds after page has loaded. Enough time for video to be
  //fully loaded in DOM
  setTimeout(function(){
    var videoElementId = $('.jwplayer').attr('id');
    var player = jwplayer(videoElementId);

    console.log('Video loaded! '+videoElementId);
    console.log(player);

    if (duration == 0) {
      player.play();
    }

    player.onTime(function() {
    if (duration == 0) {
      duration = player.getDuration();
      player.stop();

      console.log(duration);

      var lastFrame = $('.frame:last .caption-time:last');
      lastFrame.val(duration);
      lastFrame.attr('max', duration);
    }
  });

  }, 3000);



});
