<?php
namespace Qubes\Support\Applications\Front\Walkthrough;

use Qubes\Support\Applications\Front\Walkthrough\Controllers\WalkthroughController;
use Qubes\Support\Applications\Front\Base\BaseFrontApp;

class WalkthroughFrontApp extends BaseFrontApp
{
  public function defaultController()
  {
    return new WalkthroughController();
  }
}
