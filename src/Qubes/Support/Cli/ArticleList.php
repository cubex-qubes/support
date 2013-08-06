<?php
namespace Qubes\Support\Cli;

use Cubex\I18n\Processor\Cli;
use Qubes\Support\Components\Content\Article\Mappers\Article;
use Qubes\Support\Components\Content\Platform\Mappers\Platform;

/**
 * Display an article list
 */
class ArticleList extends Cli
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
      echo 'No articles to list.';
      exit;
    }

    $platforms = Platform::collection();

    foreach($articles as $article)
    {
      echo PHP_EOL;

      echo 'Article ID:  ' . $article->id() . PHP_EOL;
      echo 'Title:       ' . $article->title . PHP_EOL;
      echo 'Sub-Title:   ' . $article->subTitle . PHP_EOL;
      echo 'View:   ' . $article . PHP_EOL;

      foreach($article->getArticleBlocks() as $articleBlock)
      {
        foreach($articleBlock->getArticleBlockContent() as $blockContent)
        {
          /** @var Platform $platform */
          $platform = $platforms->getById($blockContent->platformId);

          echo PHP_EOL;
          echo 'Platform Name: ' . $platform->name . PHP_EOL;
          echo 'Platform Content: ' . $blockContent->content . PHP_EOL;
        }
      }
      echo PHP_EOL;
    }

    return $this;
  }
}
