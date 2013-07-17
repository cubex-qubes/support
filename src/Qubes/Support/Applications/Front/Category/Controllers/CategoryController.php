<?php
/**
 * Category Controller
 *
 * @author Jay Francis <jay.francis@justdevelop.it>
 */

namespace Qubes\Support\Applications\Front\Category\Controllers;

use Qubes\Support\Applications\Front\Base\Controllers\FrontController;
use Qubes\Support\Applications\Front\Category\Views\CategoryView;
use Qubes\Support\Applications\Front\Category\Views\CategoryIndexView;

class CategoryController extends FrontController
{

  public function renderIndex()
  {
    return $this->setView(new CategoryIndexView());
  }

  public function renderCategory($slug)
  {
    return $this->setView(new CategoryView());
  }

  public function getRoutes()
  {

    return [
      '/'             => 'index',
      '/:slug@all' => 'category',
    ];
  }
}
