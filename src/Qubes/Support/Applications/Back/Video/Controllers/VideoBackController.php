<?php
/**
 * Author: oke.ugwu
 * Date: 30/07/13 17:13
 */

namespace Qubes\Support\Applications\Back\Video\Controllers;

use Cubex\Facade\Redirect;
use Cubex\Form\Form;
use Cubex\Routing\Templates\ResourceTemplate;
use Qubes\Support\Applications\Back\Base\Controllers\BaseBackController;
use Qubes\Support\Applications\Back\Video\Views\VideoForm;
use Qubes\Support\Applications\Back\Video\Views\Index;
use Qubes\Support\Components\Content\Category\Mappers\Category;
use Qubes\Support\Components\Content\Video\Mappers\Video;

class VideoBackController extends BaseBackController
{
  public function renderIndex()
  {
    $Videos = Video::collection()->loadAll();
    return new Index($Videos);
  }

  public function renderNew()
  {
    $form = new Form('addVideo', '');
    $form->bindMapper(new Video());
    $options = Category::collection()->getKeyPair('id', 'title');
    $form->addSelectElement(
      'categoryId',
      $options
    );


    return new VideoForm("New Video", $form);
  }

  public function postNew()
  {
    $postData = $this->request()->postVariables();
    $newVideo = new Video();
    $newVideo->hydrateFromUnserialized($postData);
    $newVideo->saveChanges();

    $msg       = new \stdClass();
    $msg->type = 'success';
    $msg->text = 'New Video was successfully added';

    Redirect::to('/' . $this->baseUri())->with('msg', $msg)->now();
  }

  public function renderEdit()
  {
    $VideoId = $this->getInt('id');
    $form    = new Form('editVideo', '');
    $video   = new Video($VideoId);
    $form->bindMapper($video);

    $options = Category::collection()->getKeyPair('id', 'title');
    $form->addSelectElement(
      'categoryId',
      $options,
      $video->categoryId
    );

    $this->requireJs('videoEdit');
    return new VideoForm("Edit Video", $form);
  }

  public function postEdit()
  {
    $postData    = $this->request()->postVariables();
    $newCategory = new Video();
    $newCategory->hydrateFromUnserialized($postData);
    $newCategory->saveChanges();

    $msg       = new \stdClass();
    $msg->type = 'success';
    $msg->text = 'Video was successfully updated';

    Redirect::to('/' . $this->baseUri())->with('msg', $msg)->now();
  }

  public function renderDestroy()
  {
    $VideoId = $this->getInt('id');
    $Video   = new Video($VideoId);
    $Video->delete();

    $msg       = new \stdClass();
    $msg->type = 'success';
    $msg->text = 'Video was successfully deleted';

    Redirect::to('/' . $this->baseUri())->with('msg', $msg)->now();
  }

  public function getRoutes()
  {
    return ResourceTemplate::getRoutes();
  }
}
