<?php
/**
 * Author: oke.ugwu
 * Date: 31/07/13 10:14
 */

namespace Qubes\Support\Applications\Back\Category\Views;

use Cubex\View\TemplatedViewModel;

class Index extends TemplatedViewModel
{
  protected $_categories;

  public function __construct($categories)
  {
    $this->_categories = $categories;
  }

  public function getCategories()
  {
    return $this->_categories;
  }
}
