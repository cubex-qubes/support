<?php
namespace Qubes\Support\Applications\Front\Video\Views;

use Cubex\Dispatch\Dependency\Resource\TypeEnum;
use JayFrancis\Cubex\JWPlayer\JWPlayer;
use Qubes\Support\Applications\Front\Base\Views\FrontView;
use Qubes\Support\Components\Content\Video\Mappers\Video;

class VideoView extends FrontView
{
  /** @var Video */
  private $_video;

  public function __construct()
  {
    $this->requireJs('jwplayer');
  }

  /**
   * @param Video $video
   *
   * @return $this
   */
  public function setVideo(Video $video)
  {
    $this->_video = $video;

    // Set the title
    $this->setTitle($video->title);

    return $this;
  }

  public function getVideoHtml()
  {
    $video  = $this->getVideo();
    $player = new JWPlayer();
    $player->setHtml5PlayerUrl($this->getDispatchUrl('jwplayer.html5.js'));
    $player->setFlashPlayerUrl($this->getDispatchUrl('jwplayer.flash.swf'));
    $player->setVideoUrl($video->url);

    if($video->getCaptions())
    {
      $player->addCaptionConfig(
        sprintf('/video/captions/%d.vtt', $video->id()),
        'On',
        true
      );
    }

    return $player->getHtml();
  }

  /**
   * @throws \Exception
   * @return Video
   */
  public function getVideo()
  {
    if(!isset($this->_video))
    {
      throw new \Exception('Video not set');
    }

    return $this->_video;
  }
}
