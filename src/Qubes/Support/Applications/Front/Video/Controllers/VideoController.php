<?php
namespace Qubes\Support\Applications\Front\Video\Controllers;

use JayFrancis\WebVTT\WebVTT;
use Qubes\Support\Applications\Front\Video\Views\VideoView;
use Qubes\Support\Applications\Front\Base\Controllers\FrontController;
use Qubes\Support\Components\Content\Video\Mappers\Video;

class VideoController extends FrontController
{
  /**
   * Render an Video
   *
   * @param $id
   *
   * @return VideoView
   */
  public function renderVideo($id)
  {
    $video = new Video($id);
    if(!$video->exists())
    {
      return $this->renderNotFound();
    }

    /** @var VideoView $view */
    $view = $this->getView('VideoView');
    $view->setVideo($video);

    return $this->setView($view);
  }

  public function renderVttCaptions($videoId)
  {
    $video = new Video($videoId);
    if(!$video->exists())
    {
      return $this->renderNotFound();
    }

    $webVtt = new WebVTT();
    foreach($video->getCaptions() as $caption)
    {
      $webVtt->addCaption(
        $caption->startSecond,
        $caption->endSecond,
        $caption->text
      );
    }
    echo $webVtt->render();

    exit;
  }

  /**
   * @return array|\Cubex\Routing\IRoute[]
   */
  public function getRoutes()
  {
    return [
      '/video/captions/(?P<id>\d+).vtt' => 'vttCaptions',
      '/video/(?P<id>\d+).*'           => 'video',
    ];
  }
}
