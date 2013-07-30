<?php
/**
 * Author: oke.ugwu
 * Date: 30/07/13 17:06
 */

namespace Qubes\Support\Applications\Back\Base;

use Qubes\Support\Applications\Back\BackApp;

class BaseApp extends BackApp
{
  public function getRoutes()
  {
    return [
      'admin/categories/(.*)' => 'categoryController'
    ];
  }
}
