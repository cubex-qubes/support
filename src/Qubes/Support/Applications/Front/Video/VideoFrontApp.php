<?php
namespace Qubes\Support\Applications\Front\Video;

use Qubes\Support\Applications\Front\Base\BaseFrontApp;
use Qubes\Support\Applications\Front\Video\Controllers\VideoController;

class VideoFrontApp extends BaseFrontApp
{
  public function defaultController()
  {
    return new VideoController();
  }
}
