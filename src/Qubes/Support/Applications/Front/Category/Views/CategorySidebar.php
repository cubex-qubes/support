<?php
namespace Qubes\Support\Applications\Front\Category\Views;

use Cubex\View\TemplatedViewModel;
use Qubes\Bootstrap\Nav;
use Qubes\Bootstrap\NavItem;
use Qubes\Support\Applications\Front\Base\Views\FrontView;
use Qubes\Support\Components\Content\Category\Mappers\Category;

class CategorySidebar extends FrontView
{
  /** @var Category */
  private $_category;

  /**
   * @param Category $category
   *
   * @return $this
   */
  public function setCategory(Category $category)
  {
    $this->_category = $category;

    return $this;
  }

  /**
   * @throws \Exception
   * @return Category
   */
  public function getCategory()
  {
    if(!isset($this->_category))
    {
      throw new \Exception('Category not set');
    }

    return $this->_category;
  }

  /**
   * @return string
   */
  public function render()
  {
    $currentCategory = $this->getCategory();
    $menu            = new Nav(Nav::NAV_DEFAULT);

    foreach($currentCategory->getSiblingCategories() as $category)
    {
      if($category->id() == $currentCategory->id())
      {
        $state = NavItem::STATE_ACTIVE;
      }
      else
      {
        $state = NavItem::STATE_NONE;
      }

      $item = new NavItem(
        sprintf(
          '<a href="%s">%s</a>',
          $this->getUrl($category),
          $category->title
        ),
        $state
      );

      $item->setAttribute(
        'id', sprintf('sidebar-category-%d', $category->id())
      );

      $menu->addItem($item);
    }

    return $menu->render();
  }
}
