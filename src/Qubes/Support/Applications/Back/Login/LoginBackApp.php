<?php
/**
 * Author: oke.ugwu
 * Date: 30/07/13 16:23
 */

namespace Qubes\Support\Applications\Back\Login;

use Qubes\Support\Applications\Back\Base\BaseBackApp;
use Qubes\Support\Applications\Back\Login\Controllers\LoginBackController;

class LoginBackApp extends BaseBackApp
{
  public function defaultController()
  {
    return new LoginBackController();
  }
}
