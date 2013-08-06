<?php
/**
 * Author: oke.ugwu
 * Date: 30/07/13 16:23
 */

namespace Qubes\Support\Applications\Back\Access;

use Qubes\Support\Applications\Back\Base\BaseBackApp;
use Qubes\Support\Applications\Back\Access\Controllers\AccessBackController;

class AccessBackApp extends BaseBackApp
{
  public function __construct()
  {
    $this->setBaseUri('admin/access');
  }

  public function defaultController()
  {
    return new AccessBackController();
  }
}
