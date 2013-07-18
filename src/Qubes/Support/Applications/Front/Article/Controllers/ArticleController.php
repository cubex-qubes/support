<?php
/**
 * Article Controller
 *
 * @author Jay Francis <jay.francis@justdevelop.it>
 */

namespace Qubes\Support\Applications\Front\Article\Controllers;

use Qubes\Support\Applications\Front\Base\Controllers\FrontController;
use Qubes\Support\Applications\Front\Article\Views\ArticleView;
use Qubes\Support\Components\Content\Article\Article;

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
    $article = new Article($id);
    if(!$article->exists())
      return $this->renderNotFound();

    /** @var ArticleView $view */
    $view = $this->getView('ArticleView');
    $view->article = $article;

    return $view;
  }

  /**
   * @return array|\Cubex\Routing\IRoute[]
   */
  public function getRoutes()
  {
    return [
      '/(?P<id>\d+)-.*' => 'article',
    ];
  }
}
