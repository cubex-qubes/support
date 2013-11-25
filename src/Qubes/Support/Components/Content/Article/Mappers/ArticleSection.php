<?php
namespace Qubes\Support\Components\Content\Article\Mappers;

use Cubex\Mapper\Database\I18n\I18nRecordMapper;
use Cubex\Mapper\Database\RecordCollection;
use Cubex\Mapper\Database\RecordMapper;

class ArticleSection extends RecordMapper
{
  public $articleId;
  /**
   * @datatype int(11)
   */
  public $order;

  /**
   * @param null $platformId
   *
   * @return ArticleSectionBlock[]|RecordCollection
   */
  public function getBlocks($platformId = null)
  {
    $blocks = $this->hasMany(new ArticleSectionBlock, 'articleSectionId');
    if($platformId)
    {
      $blocks = $blocks->whereEq('platform_id', $platformId);
    }

    // todo this is a workaround: http://phabricator.cubex.io/T145
    foreach($blocks as $block)
    {
      $block->reload();
    }

    return $blocks;
  }

  /**
   * @return Article
   */
  public function getArticle()
  {
    return $this->belongsTo(new Article, 'articleId');
  }
}
