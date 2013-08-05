<?php
/**
 * Article View
 *
 * @author Jay Francis <jay.francis@jdiuk.com>
 */

namespace Qubes\Support\Applications\Front\Article\Views;

use Qubes\Support\Applications\Front\Base\Views\FrontView;
use Qubes\Support\Components\Content\Article\Mappers\Article;

class ArticleView extends FrontView
{
  /** @var Article */
  private $_article;

  public function __construct()
  {
    $this->setTitle($this->t("Support : Article"));
  }

  /**
   * @param Article $article
   *
   * @return $this
   */
  public function setArticle(Article $article)
  {
    $this->_article = $article;

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
}
