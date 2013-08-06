<?php
namespace Qubes\Support\Applications\Front\Category\Controllers;

use Qubes\Support\Applications\Front\Base\Controllers\FrontController;
use Qubes\Support\Applications\Front\Category\Views\CategoryView;
use Qubes\Support\Components\Content\Category\Mappers\Category;

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
    $category = new Category($id);
    if(!$category->exists())
    {
      return $this->renderNotFound();
    }

    /** @var CategoryView $view */
    $view           = $this->getView('CategoryView');
    $view->setCategory($category);

    return $view;
  }

  /**
   * @return array|\Cubex\Routing\IRoute[]
   */
  public function getRoutes()
  {
    return [
      '/category/(?P<id>\d+)-.*' => 'category',
    ];
  }
}
