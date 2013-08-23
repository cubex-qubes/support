<?php
/**
 * Author: oke.ugwu
 * Date: 31/07/13 10:14
 */

namespace Qubes\Support\Applications\Back\Video\Views;

use Cubex\View\TemplatedViewModel;

class Index extends TemplatedViewModel
{
  protected $_videos;

  public function __construct($videos)
  {
    $this->_videos = $videos;
  }

  /**
   * @return \Qubes\Support\Components\Content\Video\Mappers\Video[]
   */
  public function getVideos()
  {
    return $this->_videos;
  }
}
