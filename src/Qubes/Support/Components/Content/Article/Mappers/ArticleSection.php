<?php
namespace Qubes\Support\Components\Content\Article\Mappers;

use Cubex\Mapper\Database\I18n\I18nRecordMapper;
use Cubex\Mapper\Database\RecordCollection;

/**
 * @method static \Qubes\Support\Components\Content\Article\Mappers\ArticleSection[]|\Cubex\Mapper\Database\RecordCollection collection
 */
class ArticleSection extends I18nRecordMapper
{
  public $articleId;
  /**
   * @datatype int(11)
   */
  public $order;

  /**
   * @return ArticleSectionBlock[]|RecordCollection
   */
  public function getBlocks()
  {
    return $this->hasMany(new ArticleSectionBlock, 'articleSectionId');
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
