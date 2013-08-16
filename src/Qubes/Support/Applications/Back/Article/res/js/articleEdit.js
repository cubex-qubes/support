//do all of these after DOM is ready
$(function(){

  //attach tab behaviour
  $('.platformBlocks a').click(function (e) {
    e.preventDefault();
    var cssClass = $(this).attr('class');
    $('.'+cssClass).tab('show');
  });

  $('.platformBlocks li:first-child a').tab('show');


  $('.save-block').click(function(){
    var id = $(this).attr('name').replace('submit','');
    var articleId = $("input[name='id']");
    var blockTitle = $("input[name='title"+id+"']");
    var blockContent = $("textarea[name='content"+id+"']");

    ids = extractSectionIdAndPlatformId(id);
    var articleSectionId = ids[0];
    var platformId = ids[1];

    var post = {};
    post['articleId'] = articleId.val();
    post['title'] = blockTitle.val();
    post['content'] = blockContent.val();
    post['sectionId'] = articleSectionId;
    post['platformId'] = platformId;

    saveBlock(post, this);
  });

  $('.clear-block').click(function(e){
    e.preventDefault();
    var id = $(this).attr('id').replace('clear-block','');
    //clear blockTitle
    $("input[name='title"+id+"']").val('');
    //clear blockContent
    $("textarea[name='content"+id+"']").val('');
  });

  $('.warn').click(function(e){
    var response = confirm($(this).attr('alt'));
    if(!response)
    {
      e.preventDefault();
    }
  });

  $('#form-articleForm-title').change(function(){
    var title = $('#form-articleForm-title').val();
    $('#form-articleForm-slug').val(urlize(title));
  });

});

//return an array where index
//0 = blockGroupId
//1 = platformId
function extractSectionIdAndPlatformId(idString)
{
  return eval(idString.replace("][", ","));
}

function saveBlock(data, saveButton)
{
  var postUrl = '/admin/article/'+data.articleId+'/section/'+data.blockGroupId+'/edit';
  var successMessage = $(saveButton).parent().parent().find('.saved-success-wrapper');
  $.post(postUrl, data, function(data){
    console.log(data);
    successMessage.fadeIn();
    setTimeout(function(){
      successMessage.fadeOut();
    }, 1000)
  });
}
