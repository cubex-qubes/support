<?php
/**
 * Author: oke.ugwu
 * Date: 30/07/13 17:13
 */

namespace Qubes\Support\Applications\Back\Categories\Controllers;

use Qubes\Support\Applications\Back\Base\Controllers\BaseController;

class categoryController extends BaseController
{
  public function renderIndex()
  {
    return "Categories Home";
  }
}
