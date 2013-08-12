<?php
namespace Qubes\Support\Applications\Front\Article\Controllers;

use Qubes\Support\Applications\Front\Base\Controllers\FrontController;
use Qubes\Support\Applications\Front\Article\Views\ArticleView;
use Qubes\Support\Components\Content\Article\Mappers\Article;

class ArticleController extends FrontController
{
  /**
   * Render an Article
   *
   * @param $id
   * @param $slug
   *
   * @return ArticleView
   */
  public function renderArticle($id, $slug)
  {
    $article = new Article($id);
    if(!$article->exists())
    {
      return $this->renderNotFound();
    }

    /** @var ArticleView $view */
    $view = $this->getView('ArticleView');
    $view->setArticle($article);

    return $this->setView($view);
  }

  /**
   * @return array|\Cubex\Routing\IRoute[]
   */
  public function getRoutes()
  {
    return [
      '/article/:id@num:slug' => 'article',
    ];
  }
}
