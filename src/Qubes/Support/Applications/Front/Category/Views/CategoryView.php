<?php
namespace Qubes\Support\Applications\Front\Category\Views;

use Qubes\Support\Applications\Front\Base\Views\FrontView;
use Qubes\Support\Components\Content\Category\Mappers\Category;

class CategoryView extends FrontView
{
  /** @var  Category */
  private $_category;

  public function __construct()
  {
    $this->setTitle($this->t("Support : Category"));
  }

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
}
