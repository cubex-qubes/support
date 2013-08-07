<?php
/**
 * Author: oke.ugwu
 * Date: 02/08/13 08:43
 */

namespace Qubes\Support\Applications\Back\Category;

use Qubes\Support\Applications\Back\Base\BaseBackApp;
use Qubes\Support\Applications\Back\Category\Controllers\CategoryBackController;

class CategoryBackApp extends BaseBackApp
{
  public function __construct()
  {
    $this->setBaseUri('admin/category');
  }

  public function name()
  {
    return "Support Center - Category";
  }

  public function defaultController()
  {
    return new CategoryBackController();
  }
}
