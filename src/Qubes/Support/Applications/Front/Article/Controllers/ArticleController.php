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
   * @param $slug
   *
   * @return ArticleView
   */
  public function renderArticle($slug)
  {
    /** @var ArticleView $view */
    $view = $this->getView('ArticleView');

    return $view;
  }

  public function getRoutes()
  {
    return [
      '/:slug@all' => 'article',
    ];
  }
}
