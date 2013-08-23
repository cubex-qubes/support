<?php
/**
 * Author: oke.ugwu
 * Date: 30/07/13 17:13
 */

namespace Qubes\Support\Applications\Back\Video\Controllers;

use Cubex\Facade\Redirect;
use Cubex\Form\Form;
use Cubex\Routing\StdRoute;
use Cubex\Routing\Templates\ResourceTemplate;
use Qubes\Support\Applications\Back\Base\Controllers\BaseBackController;
use Qubes\Support\Applications\Back\Video\Views\VideoCaptionify;
use Qubes\Support\Components\Content\Video\Helpers\Captionify;
use Qubes\Support\Components\Content\Video\Mappers\Video;
use Qubes\Support\Components\Content\Video\Mappers\VideoCaption;

class VideoCaptionBackController extends BaseBackController
{
  public function renderEdit()
  {
    $videoId = $this->getInt('id');

    return new VideoCaptionify(new Video($videoId));
  }

  public function postEdit()
  {
    $videoId  = $this->getInt('id');
    $postData = $this->request()->postVariables();

    if(isset($postData['caption']))
    {
      foreach($postData['caption'] as $captionId => $captionData)
      {
        $caption              = new VideoCaption($captionId);
        $caption->startSecond = $captionData['start'];
        $caption->endSecond   = $captionData['end'];
        $caption->text        = $captionData['text'];
        $caption->saveChanges();
      }
    }

    if(isset($postData['_caption']))
    {
      foreach($postData['_caption'] as $captionData)
      {
        $caption              = new VideoCaption();
        $caption->videoId     = $videoId;
        $caption->startSecond = $captionData['start'];
        $caption->endSecond   = $captionData['end'];
        $caption->text        = $captionData['text'];
        $caption->saveChanges();
      }
    }

    Redirect::to('/admin/video/' . $videoId . '/caption/' . $videoId . '/edit')
    ->now();
  }

  public function renderImport()
  {
    $videoId  = $this->getInt('id');
    $postData = $this->request()->postVariables();

    Captionify::captionify($videoId, $postData['text']);

    Redirect::to('/admin/video/' . $videoId . '/caption/' . $videoId . '/edit')
    ->now();
  }


  public function getRoutes()
  {
    $routes   = ResourceTemplate::getRoutes();
    $routes[] = new StdRoute('/:id/import', 'import');

    return $routes;
  }
}
