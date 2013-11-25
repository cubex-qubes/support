<?php
namespace Qubes\Support\Components\Content\Article\Mappers;

use Cubex\Mapper\Database\I18n\I18nRecordMapper;
use Qubes\Support\Components\Content\Platform\Mappers\Platform;

/**
 * Platform specific Article Block Content, i.e. Windows, Mac, Linux
 */
class ArticleSectionBlock extends I18nRecordMapper
{
  public $articleSectionId;
  public $platformId;
  public $title;
  public $content;

  /**
   * @return $this|void
   */
  protected function _configure()
  {
    $this->_addTranslationAttribute(
      'title',
      'content'
    );
  }

  /**
   * @return bool|\Cubex\Mapper\Database\RecordMapper|static
   */
  public function getPlatform()
  {
    return $this->belongsTo(new Platform, 'platformId');
  }

  /**
   * @return ArticleText
   */
  public function getTextContainer()
  {
    return new ArticleText;
  }

}
