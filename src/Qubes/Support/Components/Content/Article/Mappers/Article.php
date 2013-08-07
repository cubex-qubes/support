<?php
namespace Qubes\Support\Components\Content\Article\Mappers;

use Cubex\Mapper\Database\I18n\I18nRecordMapper;

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
   * @return ArticleSection[]
   */
  public function getArticleSections()
  {
    return $this->hasMany(new ArticleSection());
  }

  /**
   * @return ArticleText
   */
  public function getTextContainer()
  {
    return new ArticleText;
  }
}
