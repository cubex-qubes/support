<?php
/**
 * Article Block
 *
 * @author Jay Francis <jay.francis@jdiuk.com>
 */

namespace Qubes\Support\Components\Content\Article\Mappers;

use Cubex\Mapper\Database\I18n\I18nRecordMapper;

/**
 * Class ArticleBlock
 *
 * @package Qubes\Support\Components\Content\Article\Mappers
 * @method static \Qubes\Support\Components\Content\Article\Mappers\ArticleBlock[]|\Cubex\Mapper\Database\RecordCollection collection
 */
class ArticleBlock extends I18nRecordMapper
{
  public $name;
  public $articleId;

  /**
   * @return ArticleBlockContent[]
   */
  public function getArticleBlockContent()
  {
    return $this->hasMany(new ArticleBlockContent, 'articleBlockId');
  }

  /**
   * @return Article
   */
  public function getArticle()
  {
    return $this->belongsTo(new Article, 'articleId');
  }

  /**
   * @return ArticleText
   */
  public function getTextContainer()
  {
    return new ArticleText;
  }

}