<?php
/**
 * PlatformBlocks are blocks of content specific to an article & platform
 *
 * @author Jay Francis <jay.francis@jdiuk.com>
 */

namespace Qubes\Support\Components\Content\Block\Mappers;

use Cubex\Mapper\Database\I18n\I18nRecordMapper;
use Qubes\Support\Components\Content\Article\Mappers\Article;
use Qubes\Support\Components\Content\Block\BlockTextContainer;

class PlatformBlock extends I18nRecordMapper
{
  public $articleId;
  public $platformId;
  public $content;

  /**
   * @return $this|void
   */
  protected function _configure()
  {
    $this->_addTranslationAttribute(
      'content'
    );
  }

  /**
   * @return bool|\Cubex\Mapper\Database\RecordMapper|static
   */
  public function getArticle()
  {
    return $this->belongsTo(new Article());
  }

  /**
   * @return BlockTextContainer
   */
  public function getTextContainer()
  {
    return new BlockTextContainer();
  }
}
