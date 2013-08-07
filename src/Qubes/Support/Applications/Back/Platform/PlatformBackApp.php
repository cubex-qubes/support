<?php
/**
 * Author: oke.ugwu
 * Date: 02/08/13 08:45
 */

namespace Qubes\Support\Applications\Back\Platform;

use Qubes\Support\Applications\Back\Base\BaseBackApp;
use Qubes\Support\Applications\Back\Platform\Controllers\PlatformBackController;

class PlatformBackApp extends BaseBackApp
{
  public function __construct()
  {
    $this->setBaseUri('admin/platform');
  }

  public function name()
  {
    return "Support Center - Platform";
  }

  public function defaultController()
  {
    return new PlatformBackController();
  }
}
