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
  /**
   * Render a Category
   *
   * @param $id
   *
   * @return CategoryView
   */
  public function renderCategory($id)
  {
    /** @var CategoryView $view */
    $view = $this->getView('CategoryView');

    return $view;
  }

  public function getRoutes()
  {
    return [
      '/(?P<id>\d+)-.*' => 'category',
    ];
  }
}
