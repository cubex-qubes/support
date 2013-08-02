<?php
/**
 * Display an article list
 *
 * @author Jay Francis <jay.francis@justdevelop.it>
 */

namespace Qubes\Support\Cli;

use Qubes\Support\Components\Content\Article\Mappers\Article;
use Qubes\Support\Components\Content\Platform\Mappers\Platform;

class ArticleList extends BaseCli
{

  /**
   * Execute the process
   *
   * @return int|void
   */
  public function execute()
  {
    $articles = Article::collection();

    if($articles->count() === 0)
    {
      return $this->_print('No articles to list.');
    }

    $platforms = Platform::collection();

    foreach($articles as $article)
    {
      $this->_print();

      $this->_print('Article ID:  ' . $article->id());
      $this->_print('Title:       ' . $article->title);
      $this->_print('Sub-Title:   ' . $article->subTitle);

      foreach($article->getArticleBlocks() as $articleBlock)
      {
        foreach($articleBlock->getArticleBlockContent() as $blockContent)
        {
          /** @var Platform $platform */
          $platform = $platforms->getById($blockContent->platformId);

          $this->_print();
          $this->_print('Platform Name: ' . $platform->name);
          $this->_print('Platform Content: ' . $blockContent->content);
        }
      }
      $this->_print();
    }

    return $this;
  }
}
