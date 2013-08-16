<?php
/**
 * Author: oke.ugwu
 * Date: 31/07/13 13:17
 */

namespace Qubes\Support\Applications\Back\Article\Views;

use Cubex\View\TemplatedViewModel;

class Index extends TemplatedViewModel
{
  protected $_articles;

  public function __construct($articles)
  {
    $this->_articles = $articles;
  }

  public function getArticles()
  {
    return $this->_articles;
  }
}
