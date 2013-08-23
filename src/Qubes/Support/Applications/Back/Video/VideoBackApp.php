<?php
/**
 * Author: oke.ugwu
 * Date: 02/08/13 08:45
 */

namespace Qubes\Support\Applications\Back\Video;

use Qubes\Support\Applications\Back\Base\BaseBackApp;
use Qubes\Support\Applications\Back\Video\Controllers\VideoBackController;

class VideoBackApp extends BaseBackApp
{
  public function __construct()
  {
    $this->setBaseUri('admin/video');
  }

  public function name()
  {
    return "Support Center - Video";
  }

  public function defaultController()
  {
    return new VideoBackController();
  }

  public function getRoutes()
  {
    return [
      "/" => [
        "/:id@num/caption/(.*)" => "VideoCaptionBackController",
        "(.*)"                  => "VideoBackController",
      ]
    ];
  }
}
