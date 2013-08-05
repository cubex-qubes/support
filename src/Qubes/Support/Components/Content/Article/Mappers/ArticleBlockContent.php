<?php
/**
 * Platform specific Article Block Content, i.e. Windows, Mac, Linux
 *
 * @author Jay Francis <jay.francis@jdiuk.com>
 */

namespace Qubes\Support\Components\Content\Article\Mappers;

use Cubex\Mapper\Database\I18n\I18nRecordMapper;
use Qubes\Support\Components\Content\Platform\Mappers\Platform;

/**
 * Class ArticleBlockContent
 *
 * @package Qubes\Support\Components\Content\Article\Mappers
 * @method static \Qubes\Support\Components\Content\Article\Mappers\ArticleBlockContent[]|\Cubex\Mapper\Database\RecordCollection collection
 */
class ArticleBlockContent extends I18nRecordMapper
{
  public $name;
  public $articleBlockId;
  public $platformId;
  public $content;


  /**
   * @return $this|void
   */
  protected function _configure()
  {
    $this->_addTranslationAttribute('content');
  }

  /**
   * @return \Cubex\Mapper\Database\RecordCollection
   */
  public function getArticleBlock()
  {
    return $this->hasMany(new ArticleBlock, 'articleBlockId');
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
