<?php
/**
 * Author: oke.ugwu
 * Date: 30/07/13 17:21
 */

namespace Qubes\Support\Applications\Back\User\Controllers;

use Qubes\Support\Applications\Back\Base\Controllers\BaseController;

class UserController extends BaseController
{
  public function renderIndex()
  {
    return "Users Home";
  }
}
