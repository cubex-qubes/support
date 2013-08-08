<?php
namespace Qubes\Support\Applications\Front\Video\Views;

use Cubex\Dispatch\Dependency\Resource\TypeEnum;
use Qubes\Support\Applications\Front\Base\Views\FrontView;
use Qubes\Support\Components\Content\Video\Mappers\Video;

class VideoView extends FrontView
{
  /** @var Video */
  private $_video;

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

    // Add Js
    $this->_addJs();

    return $this;
  }

  private function _addJs()
  {
    $this->requireJs('jwplayer');

    $video = $this->getVideo();

    $options = [
      'file'        => $video->url,
      'height'      => 360,
      'width'       => 640,
      'flashplayer' => $this->getDispatchUrl('jwplayer.flash.swf'),
      'html5player' => $this->getDispatchUrl('jwplayer.html5.js'),
    ];

    // Add image
    if($video->imageUrl)
    {
      $options['image'] = $video->imageUrl;
    }

    // Add captions
    if($video->getCaptions())
    {
      $options['tracks'] = [[
        'file' => sprintf('/video/captions/%d.vtt', $video->id()),
        'label' => 'On',
        'kind' => 'captions',
        'default' => true,
      ]];
    }

    $output[] = sprintf(
      'jwplayer("video-%d").setup(%s);',
      $video->id(),
      json_encode($options)
    );

    $this->addJsBlock(implode(PHP_EOL, $output));
  }


  public function getVideoHtml()
  {
    $video = $this->getVideo();

    $output   = [];
    $output[] = sprintf(
      '<div id="video-%d">Loading ...</div>',
      $video->id()
    );

    return implode(PHP_EOL, $output);
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
