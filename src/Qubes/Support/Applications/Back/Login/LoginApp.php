<?php
/**
 * Author: oke.ugwu
 * Date: 30/07/13 16:23
 */

namespace Qubes\Support\Applications\Back\Login;

use Qubes\Support\Applications\Back\Base\BaseApp;
use Qubes\Support\Applications\Back\Login\Controllers\DefaultController;

class LoginApp extends BaseApp
{
  public function defaultController()
  {
    return new DefaultController();
  }
}
