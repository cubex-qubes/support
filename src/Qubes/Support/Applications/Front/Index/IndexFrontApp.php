<?php
namespace Qubes\Support\Applications\Front\Index;

use Qubes\Support\Applications\Front\Base\BaseFrontApp;
use Qubes\Support\Applications\Front\Index\Controllers\IndexController;

class IndexFrontApp extends BaseFrontApp
{
  public function defaultController()
  {
    return new IndexController();
  }
}
