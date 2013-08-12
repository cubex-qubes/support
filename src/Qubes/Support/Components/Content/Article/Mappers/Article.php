<?php
namespace Qubes\Support\Components\Content\Article\Mappers;

use Cubex\Mapper\Database\I18n\I18nRecordMapper;
use Cubex\Mapper\Database\RecordCollection;

/**
 * Article Mapper
 *
 * @method static \Qubes\Support\Components\Content\Article\Mappers\Article[]|\Cubex\Mapper\Database\RecordCollection collection
 */
class Article extends I18nRecordMapper
{
  public $categoryId;
  public $title;
  public $subTitle;
  public $view;
  public $slug;
  /**
   * @datatype int(11)
   */
  public $order;

  protected function _configure()
  {
    $this->_addTranslationAttribute(
      'title',
      'subTitle'
    );
  }

  /**
   * @return ArticleSection[]|RecordCollection
   */
  public function getArticleSections()
  {
    $sections = ArticleSection::collection(['article_id' => $this->id()]);
    return $sections->setOrderBy('order');
  }

  /**
   * @return ArticleText
   */
  public function getTextContainer()
  {
    return new ArticleText;
  }
}
