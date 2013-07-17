<?php
/**
 * Article Controller
 *
 * @author Jay Francis <jay.francis@justdevelop.it>
 */

namespace Qubes\Support\Applications\Front\Article\Controllers;

use Qubes\Support\Applications\Front\Base\Controllers\FrontController;
use Qubes\Support\Applications\Front\Article\Views\ArticleIndexView;
use Qubes\Support\Applications\Front\Article\Views\ArticleView;

class ArticleController extends FrontController
{

  public function renderArticle($slug)
  {
    return $this->setView(new ArticleView());
  }

  public function getRoutes()
  {
    return [
      '/:slug@all' => 'article',
    ];
  }
}
