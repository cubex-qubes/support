/**
 * Created by oke.ugwu on 21/08/13.
 */
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
      adjustEndFrame(targetFrameId, startVal)
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
      adjustStartFrame(targetFrameId, endVal);
    }

  });


  function adjustEndFrame(prevFrameId, val)
  {
    //get start and end value of the frame above
    var startFrame = $('#start-frame-'+prevFrameId);
    var endFrame = $('#end-frame-'+prevFrameId);

    var startVal = parseInt(startFrame.val(),10);
    var endVal = parseInt(endFrame.val(),10);

    //get start and end value of the current frame
    var currFrameId = prevFrameId+1;
    var currStartFrame = $('#start-frame-'+currFrameId);
    var currEndFrame = $('#end-frame-'+currFrameId);

    var currStartVal = parseInt(currStartFrame.val(),10);
    var currEndVal = parseInt(currEndFrame.val(),10);


    if(currStartVal < endVal)
    {
      console.log(currStartVal+' < '+endVal);
      console.log('1. invalid operation: start cannot be greater than end');

      //recover from invalid operation
      currStartFrame.val(currStartVal+1);
    }
  }

  function adjustStartFrame(nextFrameId, val)
  {
    //get start and end value of the frame below
    var startFrame = $('#start-frame-'+nextFrameId);
    var endFrame = $('#end-frame-'+nextFrameId);

    var startVal = parseInt(startFrame.val(),10);
    var endVal = parseInt(endFrame.val(),10);

    //get start and end value of the current frame
    var currFrameId = nextFrameId-1;
    var currStartFrame = $('#start-frame-'+currFrameId);
    var currEndFrame = $('#end-frame-'+currFrameId);

    var currStartVal = parseInt(currStartFrame.val(),10);
    var currEndVal = parseInt(currEndFrame.val(),10);

    if(currEndVal > startVal)
    {
      console.log(currEndVal+' > '+startVal);
      console.log('2. invalid operation: start cannot be greater than end');

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

  setTimeout(function(){
    var videoElementId = $('.jwplayer').attr('id');
    var player = jwplayer(videoElementId);
    player.onPause(function(){
      console.log('video paused at '+player.getPosition());
    });
    console.log(videoElementId);
  }, 3000);






});
