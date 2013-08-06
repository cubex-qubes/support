<?php
namespace Qubes\Support\Components\Content\Article\Mappers;

use Cubex\Mapper\Database\I18n\I18nRecordMapper;

/**
 * @method static \Qubes\Support\Components\Content\Article\Mappers\ArticleBlock[]|\Cubex\Mapper\Database\RecordCollection collection
 */
class BlockGroup extends I18nRecordMapper
{
  public $articleId;
  /**
   * @datatype int(11)
   */
  public $order;

  /**
   * @return Block[]
   */
  public function getBlocks()
  {
    return $this->hasMany(new Block, 'blockGroupId');
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
