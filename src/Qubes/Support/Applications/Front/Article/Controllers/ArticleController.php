<?php
/**
 * Article Controller
 *
 * @author Jay Francis <jay.francis@justdevelop.it>
 */

namespace Qubes\Support\Applications\Front\Article\Controllers;

use Qubes\Support\Applications\Front\Base\Controllers\FrontController;
use Qubes\Support\Applications\Front\Article\Views\ArticleView;

class ArticleController extends FrontController
{

  /**
   * Render an Article
   *
   * @param $id
   *
   * @return ArticleView
   */
  public function renderArticle($id)
  {
    /** @var ArticleView $view */
    $view = $this->getView('ArticleView');

    return $view;
  }

  public function getRoutes()
  {
    return [
      '/(?P<id>\d+)-.*' => 'article',
    ];
  }
}
