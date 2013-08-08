<?php
namespace Qubes\Support\Applications\Front\Video\Controllers;

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

    return $view;
  }

  public function renderVttCaptions($videoId)
  {
    $video = new Video($videoId);
    if(!$video->exists())
    {
      return $this->renderNotFound();
    }

    $captions = ['WEBVTT'];

    foreach($video->getCaptions() as $caption)
    {

      $startTime = gmdate("i:s.000", $caption->startSecond);
      $endTime = gmdate("i:s.000", $caption->endSecond);

      $captions[] = sprintf(
        '%s --> %s%s%s%s',
        $startTime,
        $endTime,
        PHP_EOL,
        $caption->text,
        PHP_EOL
      );
    }

    //header("Content-Type:text/vtt;charset=utf-8");
    echo implode(PHP_EOL, $captions);
    exit;
  }

  /**
   * @return array|\Cubex\Routing\IRoute[]
   */
  public function getRoutes()
  {
    return [
      '/video/captions/(?P<id>\d+).vtt' => 'vttCaptions',
      '/video/(?P<id>\d+)-.*' => 'video',
    ];
  }
}
