<?php
namespace Qubes\Support\Applications\Front\Article\Views;

use Qubes\Support\Applications\Front\Base\Views\FrontView;
use Qubes\Support\Applications\Front\Category\Views\CategorySidebar;
use Qubes\Support\Components\Content\Article\Mappers\Article;

class ArticleView extends FrontView
{
  /** @var Article */
  private $_article;

  /**
   * @param Article $article
   *
   * @return $this
   */
  public function setArticle(Article $article)
  {
    $this->_article = $article;

    // Set the title
    $this->setTitle($article->title);

    return $this;
  }

  /**
   * @throws \Exception
   * @return Article
   */
  public function getArticle()
  {
    if(!isset($this->_article))
    {
      throw new \Exception('Article not set');
    }

    return $this->_article;
  }

  public function getSidebar()
  {
    /** @var CategorySidebar $sidebar */
    $sidebar = $this->getView('CategorySidebar', 'Category');
    $category = $this->getArticle()->getCategory();
    $sidebar->setCategory($category);
    return $sidebar;
  }
}
