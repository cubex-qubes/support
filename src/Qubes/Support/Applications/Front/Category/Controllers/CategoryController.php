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
   * Render a Category Index
   *
   * @param $slug
   *
   * @return CategoryIndexView
   */
  public function renderIndex($slug)
  {
    /** @var CategoryIndexView $view */
    $view = $this->getView('CategoryIndexView');

    return $view;
  }

  /**
   * Render a Category
   *
   * @param $slug
   *
   * @return CategoryView
   */
  public function renderCategory($slug)
  {
    /** @var CategoryView $view */
    $view = $this->getView('CategoryView');

    return $view;
  }

  public function getRoutes()
  {

    return [
      '/'          => 'index',
      '/:slug@all' => 'category',
    ];
  }
}
