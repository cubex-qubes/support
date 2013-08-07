<?php
namespace Qubes\Support\Applications\Front\Search\Views;

use Cubex\Mapper\Database\RecordCollection;
use Qubes\Support\Applications\Front\Base\Views\FrontView;
use Qubes\Support\Components\Content\Article\Mappers\Article;

class SearchIndexView extends FrontView
{
  private $_term;
  /** @var  Article[]|RecordCollection */
  private $_articles;

  public function __construct()
  {

  }

  public function setTerm($term = '')
  {
    $this->_term = $term;

    $this->setTitle($term);

    return $this;
  }

  public function getTerm()
  {
    return $this->_term;
  }

  public function setArticles(RecordCollection $articles)
  {
    $this->_articles = $articles;

    return $this;
  }
}
