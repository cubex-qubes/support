<?php
namespace Qubes\Support\Applications\Front\Category;

use Qubes\Support\Applications\Front\Base\BaseFrontApp;
use Qubes\Support\Applications\Front\Category\Controllers\CategoryController;

class CategoryFrontApp extends BaseFrontApp
{
  public function defaultController()
  {
    return new CategoryController();
  }
}
