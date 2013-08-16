<?php
namespace Qubes\Support\Applications\Front\Category;

use Qubes\Support\Applications\Front\Base\BaseFrontApp;
use Qubes\Support\Applications\Front\Category\Controllers\CategoryController;

class CategoryFrontApp extends BaseFrontApp
{
  public function defaultController()
  {
    /** @var CategoryController $controller */
    $controller = $this->getController('CategoryController');

    return $controller;
  }
}
