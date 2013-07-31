<?php
/**
 * Article Mapper
 *
 * @author Jay Francis <jay.francis@jdiuk.com>
 */

namespace Qubes\Support\Components\Content\Article\Mappers;


use Cubex\Mapper\Database\I18n\I18nRecordMapper;
use Qubes\Support\Components\Content\Block\Mappers\PlatformBlock;
use Qubes\Support\Components\Content\Article\ArticleTextContainer;

class Article extends I18nRecordMapper
{
  public $categoryId;
  public $title;
  public $subTitle;
  public $content;

  protected function _configure()
  {
    $this->_addTranslationAttribute(
      'title',
      'subTitle',
      'content'
    );
  }

  public function getPlatformBlocks()
  {
    return $this->hasMany(new PlatformBlock());
  }

  /**
   * @return ArticleTextContainer
   */
  public function getTextContainer()
  {
    return new ArticleTextContainer();
  }
}
