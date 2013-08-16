/**
 * Created with JetBrains PhpStorm.
 * User: oke.ugwu
 * Date: 14/08/13
 * Time: 14:16
 * To change this template use File | Settings | File Templates.
 */
//do all of these after DOM is ready
$(function(){

  $('#form-articleForm-title').keyup(function(){
    var title = $('#form-articleForm-title').val();
    console.log(title);
    $('#form-articleForm-slug').val(urlize(title));
  });

});

function urlize(str)
{
  return str.toLowerCase().replace(/\s+/g,'-');
}

