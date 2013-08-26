<?php
/**
 * Author: oke.ugwu
 * Date: 02/08/13 08:45
 */

namespace Qubes\Support\Applications\Back\User;

use Qubes\Support\Applications\Back\Base\BaseBackApp;
use Qubes\Support\Applications\Back\User\Controllers\UserBackController;

class UserBackApp extends BaseBackApp
{
  public function __construct()
  {
    $this->setBaseUri('admin/user');
  }

  public function name()
  {
    return "Support Center - User";
  }

  public function defaultController()
  {
    return new UserBackController();
  }
}
