<?php
namespace Qubes\Support\Components\Content\Article\Mappers;

use Cubex\Mapper\Database\I18n\I18nRecordMapper;

/**
 * Article Mapper
 *
 * @author  Jay Francis <jay.francis@jdiuk.com>
 * @package Qubes\Support\Components\Content\Article\Mappers
 * @method static \Qubes\Support\Components\Content\Article\Mappers\Article[]|\Cubex\Mapper\Database\RecordCollection collection
 */
class Article extends I18nRecordMapper
{
  public $categoryId;
  public $title;
  public $subTitle;
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
   * @return ArticleBlock[]
   */
  public function getArticleBlocks()
  {
    return $this->hasMany(new ArticleBlock());
  }

  /**
   * @return ArticleText
   */
  public function getTextContainer()
  {
    return new ArticleText;
  }
}
